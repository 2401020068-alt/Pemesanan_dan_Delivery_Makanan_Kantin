<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Dispute;
use App\Models\User;

class BuyerController extends Controller
{
    protected function getBuyer()
    {
        if (auth()->check() && auth()->user()->role === 'buyer') {
            session(['user_id' => auth()->id()]);
            return auth()->user();
        }
        $userId = session('user_id');
        if ($userId) {
            $user = User::find($userId);
            if ($user) return $user;
        }
        return auth()->user() ?? User::where('role', 'buyer')->first();
    }

    public function index(Request $request)
    {
        $buyer = $this->getBuyer();
        $category = $request->query('category', 'Semua');
        $search = $request->query('q', '');

        $shops = Shop::where('approval', 'approved')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->get();

        $menuQuery = MenuItem::whereHas('shop', fn($q) => $q->where('approval', 'approved'))
            ->where('available', true);

        if ($category !== 'Semua') {
            $menuQuery->where('category', $category);
        }

        if ($search) {
            $menuQuery->where('name', 'like', "%{$search}%");
        }

        $menus = $menuQuery->take(12)->get();
        $categories = ['Semua', 'Makanan', 'Minuman', 'Camilan'];

        return view('buyer.index', compact('buyer', 'shops', 'menus', 'categories', 'category', 'search'));
    }

    public function canteens(Request $request)
    {
        $buyer = $this->getBuyer();
        $search = $request->query('q', '');

        $canteens = Shop::where('approval', 'approved')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('location', 'like', "%{$search}%"))
            ->get();

        return view('buyer.canteens', compact('buyer', 'canteens', 'search'));
    }

    public function canteenShow($id)
    {
        $buyer = $this->getBuyer();
        $shop = Shop::with('menuItems')->findOrFail($id);
        return view('buyer.canteen-detail', compact('buyer', 'shop'));
    }

    public function menu(Request $request)
    {
        $buyer = $this->getBuyer();
        $category = $request->query('category', 'Semua');
        $search = $request->query('q', '');

        $query = MenuItem::with('shop')->whereHas('shop', fn($q) => $q->where('approval', 'approved'));

        if ($category !== 'Semua') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $menus = $query->paginate(12)->withQueryString();
        $categories = ['Semua', 'Makanan', 'Minuman', 'Camilan'];

        return view('buyer.menu', compact('buyer', 'menus', 'categories', 'category', 'search'));
    }

    public function cart()
    {
        $buyer = $this->getBuyer();
        $cartSession = session('cart', []);
        $cartItems = [];
        $subtotal = 0;
        $shop = null;

        foreach ($cartSession as $menuId => $item) {
            $menu = MenuItem::with('shop')->find($menuId);
            if ($menu) {
                $itemTotal = $menu->price * $item['qty'];
                $subtotal += $itemTotal;
                $cartItems[] = [
                    'menu' => $menu,
                    'qty' => $item['qty'],
                    'total' => $itemTotal,
                ];
                $shop = $menu->shop;
            }
        }

        $shops = collect($cartItems)->pluck('menu.shop')->unique('id')->values();
        $deliveryFee = count($cartItems) > 0 ? 3000 : 0;
        $total = $subtotal + $deliveryFee;

        return view('buyer.cart', compact('buyer', 'cartItems', 'subtotal', 'deliveryFee', 'total', 'shop', 'shops'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('menu_id');
        $menu = MenuItem::findOrFail($menuId);

        $cart = session('cart', []);

        // Allow items from any canteen / shop seamlessly without clearing cart
        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'qty' => 1,
                'shop_id' => $menu->shop_id,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', "{$menu->name} berhasil ditambahkan ke keranjang!");
    }

    public function updateCart(Request $request)
    {
        $menuId = $request->input('menu_id');
        $action = $request->input('action'); // increase, decrease, remove

        $cart = session('cart', []);

        if (isset($cart[$menuId])) {
            if ($action === 'increase') {
                $cart[$menuId]['qty'] += 1;
            } elseif ($action === 'decrease') {
                $cart[$menuId]['qty'] -= 1;
                if ($cart[$menuId]['qty'] <= 0) {
                    unset($cart[$menuId]);
                }
            } elseif ($action === 'remove') {
                unset($cart[$menuId]);
            }
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Keranjang diperbarui');
    }

    public function checkout()
    {
        $buyer = $this->getBuyer();
        $cartSession = session('cart', []);

        if (empty($cartSession)) {
            return redirect('/buyer/cart')->with('error', 'Keranjang Anda masih kosong.');
        }

        $cartItems = [];
        $subtotal = 0;
        $shop = null;

        foreach ($cartSession as $menuId => $item) {
            $menu = MenuItem::with('shop')->find($menuId);
            if ($menu) {
                $itemTotal = $menu->price * $item['qty'];
                $subtotal += $itemTotal;
                $cartItems[] = [
                    'menu' => $menu,
                    'qty' => $item['qty'],
                    'total' => $itemTotal,
                ];
                $shop = $menu->shop;
            }
        }

        $shops = collect($cartItems)->pluck('menu.shop')->unique('id')->values();
        $deliveryFee = 3000;
        $total = $subtotal + $deliveryFee;

        return view('buyer.checkout', compact('buyer', 'cartItems', 'subtotal', 'deliveryFee', 'total', 'shop', 'shops'));
    }

    public function placeOrder(Request $request)
    {
        $buyer = $this->getBuyer();
        $cartSession = session('cart', []);

        if (empty($cartSession)) {
            return redirect('/buyer/cart')->with('error', 'Keranjang belanja kosong.');
        }

        $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Group items by shop_id to support multi-canteen orders properly
        $itemsByShop = [];
        foreach ($cartSession as $menuId => $item) {
            $menu = MenuItem::find($menuId);
            if ($menu) {
                $itemsByShop[$menu->shop_id][] = [
                    'menu' => $menu,
                    'qty' => $item['qty'],
                ];
            }
        }

        if (empty($itemsByShop)) {
            return back()->with('error', 'Item menu tidak valid');
        }

        $createdOrders = [];
        $trxId = 'TRX-' . rand(1000, 9999);

        foreach ($itemsByShop as $shopId => $items) {
            $orderId = 'ORD-' . rand(2000, 9999);
            $subtotal = 0;
            $itemsToInsert = [];

            foreach ($items as $it) {
                $itemPrice = $it['menu']->price;
                $subtotal += $itemPrice * $it['qty'];
                $itemsToInsert[] = [
                    'menu_id' => $it['menu']->id,
                    'name' => $it['menu']->name,
                    'image' => $it['menu']->image,
                    'price' => $itemPrice,
                    'qty' => $it['qty'],
                ];
            }

            $deliveryFee = 3000;
            $total = $subtotal + $deliveryFee;

            $order = Order::create([
                'id' => $orderId,
                'trx_id' => $trxId,
                'buyer_id' => $buyer->id,
                'shop_id' => $shopId,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'address' => $request->address,
                'note' => $request->note ?? '',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'status' => 'created',
                'delivery_status' => 'waiting',
            ]);

            foreach ($itemsToInsert as $ins) {
                $order->items()->create($ins);
            }

            $createdOrders[] = $order;
        }

        session()->forget('cart');

        if (count($createdOrders) === 1) {
            return redirect("/buyer/payment/{$createdOrders[0]->id}")->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');
        } else {
            return redirect('/buyer/orders')->with('success', 'Berhasil membuat ' . count($createdOrders) . ' pesanan dari kantin berbeda!');
        }
    }

    public function payment($id)
    {
        $buyer = $this->getBuyer();
        $order = Order::with(['shop', 'items'])->findOrFail($id);
        return view('buyer.payment', compact('buyer', 'order'));
    }

    public function submitPayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $proofUrl = 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=400&q=70';

        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('payments', 'public');
            $proofUrl = '/storage/' . $path;
        }

        $order->update([
            'payment_status' => 'pending',
            'proof' => $proofUrl,
            'payment_method' => $request->payment_method ?? $order->payment_method,
        ]);

        return redirect("/buyer/orders/{$order->id}")->with('success', 'Bukti pembayaran terkirim! Menunggu verifikasi penjual.');
    }

    public function orders(Request $request)
    {
        $buyer = $this->getBuyer();
        $status = $request->query('status', 'all');

        $query = Order::with(['shop', 'items'])
            ->where('buyer_id', $buyer->id)
            ->latest();

        if ($status === 'active') {
            $query->whereIn('status', ['created', 'paid', 'processing', 'ready', 'delivering']);
        } elseif ($status === 'done') {
            $query->where('status', 'done');
        } elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        $orders = $query->get();

        return view('buyer.orders', compact('buyer', 'orders', 'status'));
    }

    public function orderShow($id)
    {
        $buyer = $this->getBuyer();
        $order = Order::with(['shop', 'items', 'driver', 'disputes'])->findOrFail($id);
        return view('buyer.order-detail', compact('buyer', 'order'));
    }

    public function disputes()
    {
        $buyer = $this->getBuyer();
        $disputes = Dispute::with(['order.shop'])->where('buyer_id', $buyer->id)->latest()->get();
        $eligibleOrders = Order::where('buyer_id', $buyer->id)->whereIn('status', ['done', 'cancelled', 'delivering', 'created'])->get();

        return view('buyer.disputes', compact('buyer', 'disputes', 'eligibleOrders'));
    }

    public function storeDispute(Request $request)
    {
        $buyer = $this->getBuyer();

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'issue' => 'required|string',
            'description' => 'required|string',
        ]);

        $proofUrl = null;
        if ($request->hasFile('proof')) {
            $path = $request->file('proof')->store('disputes', 'public');
            $proofUrl = '/storage/' . $path;
        }

        Dispute::create([
            'id' => 'DSP-' . rand(100, 999),
            'order_id' => $request->order_id,
            'buyer_id' => $buyer->id,
            'issue' => $request->issue,
            'description' => $request->description,
            'proof' => $proofUrl,
            'status' => 'open',
        ]);

        return back()->with('success', 'Sengketa berhasil diajukan dan sedang ditinjau Admin KantinKu.');
    }

    public function profile()
    {
        $buyer = $this->getBuyer();
        return view('buyer.profile', compact('buyer'));
    }

    public function updateProfile(Request $request)
    {
        $buyer = $this->getBuyer();
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $buyer->update($request->only('name', 'phone', 'address'));
        return back()->with('success', 'Profil pembeli berhasil diperbarui.');
    }
}
