<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\User;

class SellerController extends Controller
{
    protected function getSeller()
    {
        if (auth()->check() && auth()->user()->role === 'seller') {
            session(['user_id' => auth()->id()]);
            return auth()->user();
        }
        $userId = session('user_id');
        if ($userId) {
            $user = User::find($userId);
            if ($user) return $user;
        }
        return auth()->user() ?? User::where('role', 'seller')->first();
    }

    protected function getShop()
    {
        $seller = $this->getSeller();
        if (!$seller) return Shop::first();
        $shop = Shop::where('owner_id', $seller->id)->first();
        if (!$shop) {
            $maxShopId = Shop::all()->map(fn($s) => (int) preg_replace('/\D/', '', $s->id))->max() ?? 0;
            $shop = Shop::create([
                'id' => 's' . ($maxShopId + 1),
                'owner_id' => $seller->id,
                'name' => 'Warung ' . $seller->name,
                'description' => 'Warung kantin resmi milik ' . $seller->name,
                'location' => 'Kantin Kampus',
                'hours' => '08.00 - 17.00',
                'open' => true,
                'approval' => 'approved',
                'submitted' => date('Y-m-d'),
            ]);
        }
        return $shop;
    }

    public function index()
    {
        $seller = $this->getSeller();
        $shop = $this->getShop();

        $orders = Order::where('shop_id', $shop->id)->latest()->get();
        $totalRevenue = $orders->where('payment_status', 'verified')->sum('subtotal');
        $activeOrders = $orders->whereIn('status', ['paid', 'processing', 'ready'])->count();
        $doneOrders = $orders->where('status', 'done')->count();
        $pendingPayments = $orders->where('payment_status', 'pending')->count();

        $recentOrders = $orders->take(5);

        return view('seller.index', compact('seller', 'shop', 'totalRevenue', 'activeOrders', 'doneOrders', 'pendingPayments', 'recentOrders'));
    }

    public function orders(Request $request)
    {
        $seller = $this->getSeller();
        $shop = $this->getShop();
        $status = $request->query('status', 'all');

        $query = Order::with(['buyer', 'items'])->where('shop_id', $shop->id)->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->get();

        return view('seller.orders', compact('seller', 'shop', 'orders', 'status'));
    }

    public function orderDetail($id)
    {
        $seller = $this->getSeller();
        $shop = $this->getShop();
        $order = Order::with(['buyer', 'items', 'driver'])->where('shop_id', $shop->id)->findOrFail($id);

        return view('seller.order-detail', compact('seller', 'shop', 'order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $shop = $this->getShop();
        $order = Order::where('shop_id', $shop->id)->findOrFail($id);

        $request->validate(['status' => 'required|in:processing,ready,done,cancelled']);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function shop()
    {
        $seller = $this->getSeller();
        $shop = $this->getShop();
        $menuItems = MenuItem::where('shop_id', $shop->id)->latest()->get();

        return view('seller.shop', compact('seller', 'shop', 'menuItems'));
    }

    public function updateShop(Request $request)
    {
        $shop = $this->getShop();

        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string',
            'hours' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $shop->update([
            'name' => $request->name,
            'location' => $request->location,
            'hours' => $request->hours,
            'description' => $request->description,
            'open' => $request->has('open'),
        ]);

        return back()->with('success', 'Informasi warung berhasil diperbarui!');
    }

    public function storeMenu(Request $request)
    {
        $shop = $this->getShop();

        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $newId = 'm' . (MenuItem::count() + 1);
        $imageUrl = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=70';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $imageUrl = '/storage/' . $path;
        }

        MenuItem::create([
            'id' => $newId,
            'shop_id' => $shop->id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageUrl,
            'available' => $request->has('available'),
        ]);

        return back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function updateMenu(Request $request, $id)
    {
        $shop = $this->getShop();
        $menu = MenuItem::where('shop_id', $shop->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'available' => $request->has('available'),
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $menu->update($data);

        return back()->with('success', 'Menu berhasil diubah!');
    }

    public function deleteMenu($id)
    {
        $shop = $this->getShop();
        $menu = MenuItem::where('shop_id', $shop->id)->findOrFail($id);
        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus!');
    }

    public function payments()
    {
        $seller = $this->getSeller();
        $shop = $this->getShop();
        $orders = Order::with('buyer')->where('shop_id', $shop->id)->whereIn('payment_status', ['pending', 'verified', 'rejected'])->latest()->get();

        return view('seller.payments', compact('seller', 'shop', 'orders'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $shop = $this->getShop();
        $order = Order::where('shop_id', $shop->id)->findOrFail($id);

        $action = $request->input('action'); // verify or reject

        if ($action === 'verify') {
            $order->update([
                'payment_status' => 'verified',
                'status' => 'paid',
            ]);
            $msg = 'Pembayaran berhasil diverifikasi. Pesanan masuk antrean masak!';
        } else {
            $order->update([
                'payment_status' => 'rejected',
                'status' => 'cancelled',
            ]);
            $msg = 'Pembayaran ditolak.';
        }

        return back()->with('success', $msg);
    }

    public function profile()
    {
        $seller = $this->getSeller();
        $shop = $this->getShop();
        return view('seller.profile', compact('seller', 'shop'));
    }

    public function updateProfile(Request $request)
    {
        $seller = $this->getSeller();
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string',
        ]);

        $seller->update($request->only('name', 'phone'));
        return back()->with('success', 'Profil penjual berhasil diperbarui.');
    }
}
