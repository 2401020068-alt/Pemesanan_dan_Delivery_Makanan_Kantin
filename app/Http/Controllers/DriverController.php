<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class DriverController extends Controller
{
    protected function getDriver()
    {
        if (auth()->check() && auth()->user()->role === 'driver') {
            session(['user_id' => auth()->id()]);
            return auth()->user();
        }
        $userId = session('user_id');
        if ($userId) {
            $user = User::find($userId);
            if ($user) return $user;
        }
        return auth()->user() ?? User::where('role', 'driver')->first();
    }

    public function index()
    {
        $driver = $this->getDriver();

        $myDeliveries = Order::with(['shop', 'buyer', 'items'])->where('driver_id', $driver->id)->latest()->get();
        $availableOrders = Order::with(['shop', 'buyer', 'items'])
            ->whereIn('status', ['ready', 'processing'])
            ->whereNull('driver_id')
            ->latest()
            ->get();

        $activeCount = $myDeliveries->whereIn('delivery_status', ['picked', 'onway'])->count();
        $doneCount = $myDeliveries->where('delivery_status', 'done')->count();

        return view('driver.index', compact('driver', 'myDeliveries', 'availableOrders', 'activeCount', 'doneCount'));
    }

    public function deliveries(Request $request)
    {
        $driver = $this->getDriver();
        $tab = $request->query('tab', 'available'); // available, ongoing, done

        $available = Order::with(['shop', 'buyer', 'items'])
            ->whereIn('status', ['ready', 'processing', 'paid'])
            ->whereNull('driver_id')
            ->latest()
            ->get();

        $ongoing = Order::with(['shop', 'buyer', 'items'])
            ->where('driver_id', $driver->id)
            ->whereIn('delivery_status', ['picked', 'onway'])
            ->latest()
            ->get();

        $done = Order::with(['shop', 'buyer', 'items'])
            ->where('driver_id', $driver->id)
            ->where('delivery_status', 'done')
            ->latest()
            ->get();

        return view('driver.deliveries', compact('driver', 'tab', 'available', 'ongoing', 'done'));
    }

    public function takeDelivery($id)
    {
        $driver = $this->getDriver();
        $order = Order::findOrFail($id);

        if ($order->driver_id && $order->driver_id !== $driver->id) {
            return back()->with('error', 'Pesanan ini sudah diambil driver lain.');
        }

        $order->update([
            'driver_id' => $driver->id,
            'delivery_status' => 'picked',
        ]);

        return back()->with('success', "Pesanan {$order->id} berhasil Anda ambil! Segera ambil makanan di warung.");
    }

    public function updateDeliveryStatus(Request $request, $id)
    {
        $driver = $this->getDriver();
        $order = Order::where('driver_id', $driver->id)->findOrFail($id);

        $status = $request->input('delivery_status'); // onway or done

        if ($status === 'onway') {
            $order->update([
                'delivery_status' => 'onway',
                'status' => 'delivering',
            ]);
            $msg = 'Status diperbarui: Sedang dalam perjalanan mengantar ke pembeli!';
        } elseif ($status === 'done') {
            $order->update([
                'delivery_status' => 'done',
                'status' => 'done',
            ]);
            $msg = 'Pengantaran selesai! Pesanan telah sampai ke tangan pembeli.';
        } else {
            return back()->with('error', 'Status tidak valid.');
        }

        return back()->with('success', $msg);
    }

    public function profile()
    {
        $driver = $this->getDriver();
        return view('driver.profile', compact('driver'));
    }

    public function updateProfile(Request $request)
    {
        $driver = $this->getDriver();
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string',
        ]);

        $driver->update($request->only('name', 'phone'));
        return back()->with('success', 'Profil driver berhasil disimpan.');
    }
}
