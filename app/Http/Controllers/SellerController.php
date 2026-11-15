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
            if ($user && $user->role === 'seller') return $user;
        }
        return (auth()->check() && auth()->user()->role === 'seller' ? auth()->user() : null)
            ?? User::where('role', 'seller')->where('approval', 'approved')->first()
            ?? User::where('role', 'seller')->first();
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
                'location' => 'Kantin Senggarang',
                'hours' => '08.00 - 17.00',
                'open' => true,
                'approval' => 'approved',
                'submitted' => date('Y-m-d'),
            ]);
        }
        return $shop;
    }

    protected function checkApproval()
    {
        if (auth()->check() && auth()->user()->role !== 'seller') {
            return redirect('/' . auth()->user()->role)->with('info', 'Anda saat ini sedang login sebagai ' . ucfirst(auth()->user()->role) . '.');
        }
        $seller = $this->getSeller();
        if ($seller && $seller->role === 'seller' && $seller->approval !== 'approved') {
            return redirect()->route('seller.pending');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkApproval()) return $redirect;
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
        if ($redirect = $this->checkApproval()) return $redirect;
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
        if ($redirect = $this->checkApproval()) return $redirect;
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
            'hours' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $shop->update([
            'name' => $request->name,
            'location' => 'Kantin Senggarang',
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

        $maxMenuId = MenuItem::all()->map(function ($m) {
            return (int) preg_replace('/\D/', '', $m->id);
        })->max() ?? 0;
        $newId = 'm' . ($maxMenuId + 1);
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
        if ($redirect = $this->checkApproval()) return $redirect;
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

    public function pending()
    {
        if (auth()->check() && auth()->user()->role !== 'seller') {
            return redirect('/' . auth()->user()->role)->with('info', 'Anda sedang login sebagai ' . ucfirst(auth()->user()->role) . '. Untuk melihat dashboard warung, silakan login dengan akun Penjual.');
        }
        $seller = $this->getSeller();
        // Kalau sudah approved, langsung ke dashboard
        if ($seller && $seller->approval === 'approved') {
            return redirect()->route('seller.index');
        }
        return view('seller.pending', compact('seller'));
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
            'avatar_file' => 'nullable|image|max:2048',
            'avatar_preset' => 'nullable|string',
        ]);

        $data = $request->only('name', 'phone');

        if ($request->hasFile('avatar_file')) {
            $path = $request->file('avatar_file')->store('avatars', 'public');
            $data['avatar'] = '/storage/' . $path;
        } elseif ($request->filled('avatar_preset')) {
            $data['avatar'] = $request->avatar_preset;
        } elseif ($seller->name !== $request->name) {
            $data['avatar'] = \App\Models\User::determineAvatarByName($request->name);
        }

        $seller->update($data);
        return back()->with('success', 'Profil dan foto avatar penjual berhasil diperbarui!');
    }
}
