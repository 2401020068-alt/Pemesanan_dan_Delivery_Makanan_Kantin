<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class DemoController extends Controller
{
    public function reset()
    {
        // Re-run database migrations and seeding
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true]);

        // Clear session cart
        session()->forget('cart');

        return back()->with('success', 'Data demo KantinKu berhasil di-reset ke kondisi awal!');
    }
}
