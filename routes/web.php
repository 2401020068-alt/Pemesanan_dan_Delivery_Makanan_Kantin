<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\ApiController;

// Public & Landing
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth & Demo switcher
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/switch-role/{role}', [AuthController::class, 'switchRole'])->name('switch.role');
Route::post('/demo/reset', [DemoController::class, 'reset'])->name('demo.reset');
Route::get('/demo/reset', [DemoController::class, 'reset']);

// Buyer Routes
Route::prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/', [BuyerController::class, 'index'])->name('index');
    Route::get('/canteens', [BuyerController::class, 'canteens'])->name('canteens');
    Route::get('/canteens/{id}', [BuyerController::class, 'canteenShow'])->name('canteens.show');
    Route::get('/menu', [BuyerController::class, 'menu'])->name('menu');
    Route::get('/cart', [BuyerController::class, 'cart'])->name('cart');
    Route::post('/cart/add', [BuyerController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [BuyerController::class, 'updateCart'])->name('cart.update');
    Route::get('/checkout', [BuyerController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [BuyerController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/payment/{id}', [BuyerController::class, 'payment'])->name('payment');
    Route::post('/payment/{id}', [BuyerController::class, 'submitPayment'])->name('payment.submit');
    Route::get('/orders', [BuyerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [BuyerController::class, 'orderShow'])->name('orders.show');
    Route::get('/disputes', [BuyerController::class, 'disputes'])->name('disputes');
    Route::post('/disputes', [BuyerController::class, 'storeDispute'])->name('disputes.store');
    Route::get('/profile', [BuyerController::class, 'profile'])->name('profile');
    Route::post('/profile', [BuyerController::class, 'updateProfile'])->name('profile.update');
});

// Seller Routes
Route::prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerController::class, 'index'])->name('index');
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [SellerController::class, 'orderDetail'])->name('orders.show');
    Route::post('/orders/{id}/status', [SellerController::class, 'updateOrderStatus'])->name('orders.status');
    Route::get('/shop', [SellerController::class, 'shop'])->name('shop');
    Route::post('/shop', [SellerController::class, 'updateShop'])->name('shop.update');
    Route::post('/menu', [SellerController::class, 'storeMenu'])->name('menu.store');
    Route::post('/menu/{id}', [SellerController::class, 'updateMenu'])->name('menu.update');
    Route::delete('/menu/{id}', [SellerController::class, 'deleteMenu'])->name('menu.delete');
    Route::get('/payments', [SellerController::class, 'payments'])->name('payments');
    Route::post('/payments/{id}', [SellerController::class, 'verifyPayment'])->name('payments.verify');
    Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
    Route::post('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');
});

// Driver Routes
Route::prefix('driver')->name('driver.')->group(function () {
    Route::get('/', [DriverController::class, 'index'])->name('index');
    Route::get('/deliveries', [DriverController::class, 'deliveries'])->name('deliveries');
    Route::post('/deliveries/{id}/take', [DriverController::class, 'takeDelivery'])->name('deliveries.take');
    Route::post('/deliveries/{id}/status', [DriverController::class, 'updateDeliveryStatus'])->name('deliveries.status');
    Route::get('/profile', [DriverController::class, 'profile'])->name('profile');
    Route::post('/profile', [DriverController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/sellers', [AdminController::class, 'sellers'])->name('sellers');
    Route::post('/sellers/{id}', [AdminController::class, 'approveSeller'])->name('sellers.approve');
    Route::get('/shops', [AdminController::class, 'shops'])->name('shops');
    Route::post('/shops/{id}', [AdminController::class, 'approveShop'])->name('shops.approve');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/{id}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminController::class, 'exportReportsCsv'])->name('reports.export');
    Route::get('/disputes', [AdminController::class, 'disputes'])->name('disputes');
    Route::post('/disputes/{id}', [AdminController::class, 'resolveDispute'])->name('disputes.resolve');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
});

// REST API v1 Routes (JSON Responses) - Sesuai Silabus RPS Pertemuan 6 & 12
Route::prefix('api/v1')->name('api.v1.')->group(function () {
    Route::get('/canteens', [ApiController::class, 'getCanteens'])->name('canteens');
    Route::get('/canteens/{id}', [ApiController::class, 'getCanteenDetail'])->name('canteens.detail');
    Route::get('/menus', [ApiController::class, 'getMenus'])->name('menus');
    Route::get('/orders/{id}', [ApiController::class, 'getOrderDetail'])->name('orders.detail');
    Route::post('/cart/add', [ApiController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ApiController::class, 'getCart'])->name('cart.index');
});

