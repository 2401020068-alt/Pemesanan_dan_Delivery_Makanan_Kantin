<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Dispute;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    protected function getAdmin()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            session(['user_id' => auth()->id()]);
            return auth()->user();
        }
        $userId = session('user_id');
        if ($userId) {
            $user = User::find($userId);
            if ($user) return $user;
        }
        return auth()->user() ?? User::where('role', 'admin')->first();
    }

    protected function logAction($action, $target, $status = 'success')
    {
        $admin = $this->getAdmin();
        ActivityLog::create([
            'id' => 'l' . (ActivityLog::count() + 1),
            'time' => now(),
            'admin' => $admin->name,
            'action' => $action,
            'target' => $target,
            'status' => $status,
        ]);
    }

    public function index()
    {
        $admin = $this->getAdmin();

        $totalRevenue = Order::where('payment_status', 'verified')->sum('total');
        $totalOrders = Order::count();
        $activeShops = Shop::where('approval', 'approved')->where('open', true)->count();
        $pendingSellers = User::where('role', 'seller')->where('approval', 'pending')->count();
        $openDisputes = Dispute::whereIn('status', ['open', 'review'])->count();

        $recentOrders = Order::with(['buyer', 'shop'])->latest()->take(6)->get();
        $recentLogs = ActivityLog::latest('time')->take(5)->get();

        return view('admin.index', compact('admin', 'totalRevenue', 'totalOrders', 'activeShops', 'pendingSellers', 'openDisputes', 'recentOrders', 'recentLogs'));
    }

    public function sellers()
    {
        $admin = $this->getAdmin();
        $sellers = User::where('role', 'seller')->latest()->get();
        return view('admin.sellers', compact('admin', 'sellers'));
    }

    public function approveSeller(Request $request, $id)
    {
        $seller = User::where('role', 'seller')->findOrFail($id);
        $action = $request->input('action'); // approve or reject

        $approval = $action === 'approve' ? 'approved' : 'rejected';
        $seller->update(['approval' => $approval]);

        $this->logAction($action === 'approve' ? 'Menyetujui penjual' : 'Menolak penjual', "{$seller->name} ({$seller->id})");

        return back()->with('success', "Penjual {$seller->name} berhasil " . ($action === 'approve' ? 'disetujui.' : 'ditolak.'));
    }

    public function shops()
    {
        $admin = $this->getAdmin();
        $shops = Shop::with('owner')->latest()->get();
        return view('admin.shops', compact('admin', 'shops'));
    }

    public function approveShop(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $action = $request->input('action'); // approve or reject

        $approval = $action === 'approve' ? 'approved' : 'rejected';
        $shop->update(['approval' => $approval]);

        $this->logAction($action === 'approve' ? 'Menyetujui warung' : 'Menolak warung', "{$shop->name} ({$shop->id})");

        return back()->with('success', "Warung {$shop->name} berhasil " . ($action === 'approve' ? 'disetujui.' : 'ditolak.'));
    }

    public function users(Request $request)
    {
        $admin = $this->getAdmin();
        $role = $request->query('role', 'all');
        $search = $request->query('q', '');

        $query = User::latest();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users', compact('admin', 'users', 'role', 'search'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $this->logAction($newStatus === 'active' ? 'Mengaktifkan pengguna' : 'Menonaktifkan pengguna', "{$user->name} ({$user->id})");

        return back()->with('success', "Status akun {$user->name} kini menjadi {$newStatus}.");
    }

    public function reports()
    {
        $admin = $this->getAdmin();
        $verifiedOrders = Order::with(['buyer', 'shop'])->where('payment_status', 'verified')->get();
        $totalRevenue = $verifiedOrders->sum('total');

        $allOrders = Order::with(['buyer', 'shop'])->latest()->get();
        $completedOrdersCount = $allOrders->where('status', 'done')->count();
        $cancelledOrdersCount = $allOrders->where('status', 'cancelled')->count();

        $approvedShops = Shop::where('approval', 'approved')->get();
        $perShop = $approvedShops->map(function ($shop) {
            $shopTotal = Order::where('shop_id', $shop->id)->where('payment_status', 'verified')->sum('total');
            return [
                'shop' => $shop,
                'revenue' => $shopTotal,
            ];
        });

        $maxShopRevenue = max(1, $perShop->max('revenue'));

        return view('admin.reports', compact('admin', 'allOrders', 'totalRevenue', 'completedOrdersCount', 'cancelledOrdersCount', 'perShop', 'maxShopRevenue'));
    }

    public function exportReportsCsv()
    {
        $orders = Order::with(['buyer', 'shop'])->latest()->get();

        $csvHeaders = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-transaksi-kantinku.csv"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            // Add BOM for Excel UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID Pesanan', 'ID Transaksi', 'Tanggal', 'Nama Pembeli', 'Nama Warung', 'Total (Rp)', 'Metode Pembayaran', 'Status Pembayaran', 'Status Pesanan']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->trx_id,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->buyer->name ?? '-',
                    $order->shop->name ?? '-',
                    $order->total,
                    $order->payment_method,
                    $order->payment_status,
                    $order->status,
                ]);
            }
            fclose($file);
        };

        $this->logAction('Ekspor laporan transaksi', 'Laporan Keseluruhan CSV KantinKu');

        return response()->stream($callback, 200, $csvHeaders);
    }

    public function disputes()
    {
        $admin = $this->getAdmin();
        $disputes = Dispute::with(['order.shop', 'buyer'])->latest()->get();
        return view('admin.disputes', compact('admin', 'disputes'));
    }

    public function resolveDispute(Request $request, $id)
    {
        $dispute = Dispute::findOrFail($id);

        $request->validate([
            'status' => 'required|in:review,resolved,rejected',
            'resolution' => 'nullable|string',
        ]);

        $dispute->update([
            'status' => $request->status,
            'resolution' => $request->resolution,
        ]);

        $this->logAction('Memperbarui sengketa', "{$dispute->id} - Status: {$request->status}");

        return back()->with('success', "Status sengketa {$dispute->id} berhasil diperbarui.");
    }

    public function logs()
    {
        $admin = $this->getAdmin();
        $logs = ActivityLog::latest('time')->paginate(20);
        return view('admin.logs', compact('admin', 'logs'));
    }

    public function profile()
    {
        $admin = $this->getAdmin();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = $this->getAdmin();
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string',
        ]);

        $admin->update($request->only('name', 'phone'));
        return back()->with('success', 'Profil admin berhasil disimpan.');
    }
}
