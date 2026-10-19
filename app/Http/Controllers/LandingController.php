<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\MenuItem;
use App\Models\Order;

class LandingController extends Controller
{
    public function index()
    {
        $featuredShops = Shop::where('approval', 'approved')->where('open', true)->take(4)->get();
        $popularMenus = MenuItem::where('available', true)->take(6)->get();
        $orderCount = Order::count();

        return view('landing', compact('featuredShops', 'popularMenus', 'orderCount'));
    }
}
