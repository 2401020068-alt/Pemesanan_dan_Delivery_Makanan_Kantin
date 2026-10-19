@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Dashboard {{ $shop->name ?? 'Warung Kantin' }}</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Kelola pesanan masuk, pantau omset warung, dan operasional harian.</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold {{ $shop->open ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $shop->open ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                Warung {{ $shop->open ? 'Buka' : 'Tutup' }}
            </span>
            <a href="{{ route('seller.shop') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white hover:bg-[#F4F6F4] text-[#1A241E] text-xs font-semibold border border-[#E5ECE7] shadow-xs transition">
                <svg class="w-3.5 h-3.5 text-[#76847B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Atur Warung</span>
            </a>
        </div>
    </div>

    <!-- Stats 4 Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Total Pendapatan</span>
                <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <p class="text-[11px] text-emerald-700 mt-1 font-medium">Pembayaran terverifikasi</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Perlu Diproses</span>
                <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">{{ $activeOrders }}</div>
            <p class="text-[11px] text-amber-700 mt-1 font-medium">Pesanan masuk &amp; dimasak</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Pesanan Selesai</span>
                <span class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">{{ $doneOrders }}</div>
            <p class="text-[11px] text-teal-700 mt-1 font-medium">Sukses terantar</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Verifikasi Bayar</span>
                <span class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">{{ $pendingPayments }}</div>
            <p class="text-[11px] text-blue-700 mt-1 font-medium"><a href="{{ route('seller.payments') }}" class="underline hover:text-blue-800">Cek Bukti Transfer ↗</a></p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-sm overflow-hidden">
        <div class="p-5 border-b border-[#E5ECE7] flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#1F3E2C] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
                <h2 class="font-display font-bold text-base text-[#1A241E]">Pesanan Masuk Terbaru</h2>
            </div>
            <a href="{{ route('seller.orders') }}" class="text-xs font-bold text-[#1F3E2C] hover:underline flex items-center gap-1">
                <span>Semua Pesanan</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">ID Pesanan</th>
                        <th class="px-5 py-3.5">Pembeli</th>
                        <th class="px-5 py-3.5">Item</th>
                        <th class="px-5 py-3.5">Total (Rp)</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($recentOrders as $ord)
                        @php
                            $statusMap = [
                                'created' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Menunggu Bayar'],
                                'paid' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Terbayar'],
                                'processing' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'label' => 'Sedang Dimasak'],
                                'ready' => ['bg' => 'bg-indigo-50 text-indigo-800 border-indigo-200', 'label' => 'Siap Diantar'],
                                'delivering' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200', 'label' => 'Diantar Kurir'],
                                'done' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Selesai'],
                                'cancelled' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'label' => 'Dibatalkan'],
                            ];
                            $st = $statusMap[$ord->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => $ord->status];
                        @endphp
                        <tr class="hover:bg-[#FAFBF9] transition">
                            <td class="px-5 py-3.5 font-mono font-bold text-[#1A241E]">{{ $ord->id }}</td>
                            <td class="px-5 py-3.5 font-medium text-[#1A241E]">{{ $ord->buyer->name ?? 'Pembeli' }}</td>
                            <td class="px-5 py-3.5">{{ $ord->items->count() }} item menu</td>
                            <td class="px-5 py-3.5 font-bold text-[#1A241E]">Rp {{ number_format($ord->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $st['bg'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('seller.orders.show', $ord->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold transition shadow-xs">
                                    <span>Kelola</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-[#76847B]">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Belum Ada Pesanan Masuk</p>
                                    <p class="text-[11px] text-slate-400">Pesanan dari pembeli akan otomatis muncul di sini begitu checkout diselesaikan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
