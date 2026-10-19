<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\MenuItem;
use App\Models\Order;

class ApiController extends Controller
{
    /**
     * GET /api/v1/canteens
     * Mengembalikan daftar seluruh warung/kantin resmi yang disetujui
     */
    public function getCanteens(Request $request)
    {
        $search = $request->query('q', '');
        $canteens = Shop::where('approval', 'approved')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('location', 'like', "%{$search}%"))
            ->get();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data daftar warung kantin berhasil diambil',
            'total' => $canteens->count(),
            'data' => $canteens,
        ], 200);
    }

    /**
     * GET /api/v1/canteens/{id}
     * Mengembalikan detail warung kantin beserta menu makanan yang tersedia
     */
    public function getCanteenDetail($id)
    {
        $canteen = Shop::with(['menuItems' => function ($q) {
            $q->where('available', true);
        }])->find($id);

        if (!$canteen) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => "Warung kantin dengan ID '{$id}' tidak ditemukan",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Detail warung kantin berhasil diambil',
            'data' => $canteen,
        ], 200);
    }

    /**
     * GET /api/v1/menus
     * Mengembalikan katalog menu makanan dan minuman (bisa difilter kategori & kata kunci)
     */
    public function getMenus(Request $request)
    {
        $category = $request->query('category', 'Semua');
        $search = $request->query('q', '');

        $query = MenuItem::with('shop')
            ->whereHas('shop', fn($q) => $q->where('approval', 'approved'))
            ->where('available', true);

        if ($category !== 'Semua') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $menus = $query->get();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Katalog menu berhasil diambil',
            'filter' => [
                'category' => $category,
                'q' => $search,
            ],
            'total' => $menus->count(),
            'data' => $menus,
        ], 200);
    }

    /**
     * GET /api/v1/orders/{id}
     * Mengembalikan status dan detail pesanan transaksi
     */
    public function getOrderDetail($id)
    {
        $order = Order::with(['buyer', 'shop', 'driver', 'items'])->find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => "Pesanan dengan ID '{$id}' tidak ditemukan",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data detail pesanan berhasil diambil',
            'data' => $order,
        ], 200);
    }

    /**
     * POST /api/v1/cart/add
     * Menambahkan item ke keranjang belanja (digunakan oleh Vanilla JS Fetch API)
     */
    public function addToCart(Request $request)
    {
        $menuId = $request->input('menu_id');
        $qty = max(1, (int) $request->input('qty', 1));

        $menu = MenuItem::find($menuId);
        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Menu tidak ditemukan atau sudah tidak tersedia',
            ], 404);
        }

        $cart = session('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += $qty;
        } else {
            $cart[$menuId] = [
                'qty' => $qty,
                'shop_id' => $menu->shop_id,
            ];
        }

        session(['cart' => $cart]);

        $totalCount = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => "{$menu->name} berhasil ditambahkan ke keranjang!",
            'cart_count' => $totalCount,
            'added_item' => [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => $cart[$menuId]['qty'],
            ],
        ], 200);
    }

    /**
     * GET /api/v1/cart
     * Mengembalikan ringkasan isi keranjang saat ini
     */
    public function getCart()
    {
        $cartSession = session('cart', []);
        $items = [];
        $subtotal = 0;

        foreach ($cartSession as $menuId => $val) {
            $menu = MenuItem::with('shop')->find($menuId);
            if ($menu) {
                $totalPrice = $menu->price * $val['qty'];
                $subtotal += $totalPrice;
                $items[] = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'qty' => $val['qty'],
                    'total' => $totalPrice,
                    'shop' => [
                        'id' => $menu->shop->id ?? null,
                        'name' => $menu->shop->name ?? null,
                    ],
                ];
            }
        }

        $totalCount = array_sum(array_column($cartSession, 'qty'));
        $deliveryFee = $totalCount > 0 ? 3000 : 0;

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data keranjang berhasil diambil',
            'cart_count' => $totalCount,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $subtotal + $deliveryFee,
            'items' => $items,
        ], 200);
    }
}
