@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Dashboard Administrator</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Pemantauan operasional ekosistem KantinKu di lingkungan kampus.</p>
        </div>

        <a href="{{ route('admin.reports') }}" class="px-4 py-2 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold shadow-xs transition">
            Buka Laporan Transaksi
        </a>
    </div>

    <!-- Stats 5 Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Total Omset</span>
                <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-xl font-bold text-emerald-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <p class="text-[11px] text-emerald-700 mt-1 font-medium">Terverifikasi</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Total Pesanan</span>
                <span class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
            </div>
            <div class="font-display text-xl font-bold text-[#1A241E]">{{ $totalOrders }}</div>
            <p class="text-[11px] text-slate-500 mt-1">Keseluruhan</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Warung Buka</span>
                <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </span>
            </div>
            <div class="font-display text-xl font-bold text-[#1A241E]">{{ $activeShops }}</div>
            <p class="text-[11px] text-amber-700 mt-1 font-medium">Siap melayani</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Penjual Baru</span>
                <span class="w-9 h-9 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </span>
            </div>
            <div class="font-display text-xl font-bold text-sky-900">{{ $pendingSellers }}</div>
            <p class="text-[11px] text-sky-700 mt-1 font-medium"><a href="{{ route('admin.sellers') }}" class="underline hover:text-sky-900">Perlu Verifikasi ↗</a></p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Sengketa</span>
                <span class="w-9 h-9 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </span>
            </div>
            <div class="font-display text-xl font-bold text-rose-700">{{ $openDisputes }}</div>
            <p class="text-[11px] text-rose-700 mt-1 font-medium"><a href="{{ route('admin.disputes') }}" class="underline hover:text-rose-900">Tinjau Kasus ↗</a></p>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Recent Transactions -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-[#E5ECE7] shadow-sm overflow-hidden">
            <div class="p-5 border-b border-[#E5ECE7] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#1F3E2C] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </span>
                    <h2 class="font-display font-bold text-base text-[#1A241E]">Transaksi Kampus Terkini</h2>
                </div>
                <a href="{{ route('admin.reports') }}" class="text-xs font-bold text-[#1F3E2C] hover:underline flex items-center gap-1">
                    <span>Semua Transaksi</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#4A584F]">
                    <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                        <tr>
                            <th class="px-5 py-3.5">ID Pesanan</th>
                            <th class="px-5 py-3.5">Pembeli</th>
                            <th class="px-5 py-3.5">Warung</th>
                            <th class="px-5 py-3.5">Total</th>
                            <th class="px-5 py-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5ECE7]">
                        @foreach($recentOrders as $ord)
                            @php
                                $statusMap = [
                                    'created' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Menunggu Bayar'],
                                    'paid' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Terbayar'],
                                    'processing' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'label' => 'Dimasak'],
                                    'ready' => ['bg' => 'bg-indigo-50 text-indigo-800 border-indigo-200', 'label' => 'Siap Antar'],
                                    'delivering' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200', 'label' => 'Diantar Kurir'],
                                    'done' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Selesai'],
                                    'cancelled' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'label' => 'Dibatalkan'],
                                ];
                                $st = $statusMap[$ord->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => $ord->status];
                            @endphp
                            <tr class="hover:bg-[#FAFBF9] transition">
                                <td class="px-5 py-3.5 font-mono font-bold text-[#1A241E]">{{ $ord->id }}</td>
                                <td class="px-5 py-3.5 font-medium text-[#1A241E]">{{ $ord->buyer->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-[#4A584F]">{{ $ord->shop->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 font-bold text-[#1A241E]">Rp {{ number_format($ord->total, 0, ',', '.') }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $st['bg'] }}">
                                        {{ $st['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Audit Logs Preview -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-[#E5ECE7]">
                <h2 class="font-display font-bold text-base text-[#1A241E]">Log Aktivitas Sistem</h2>
                <a href="{{ route('admin.logs') }}" class="text-xs font-semibold text-[#1F3E2C] hover:underline">Semua Log</a>
            </div>

            <div class="space-y-3">
                @foreach($recentLogs as $lg)
                    <div class="p-3 bg-[#F4F6F4] rounded-2xl border border-[#E5ECE7] text-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[#1A241E]">{{ $lg->action }}</span>
                            <span class="text-[10px] font-bold text-[#3F6E52]">{{ $lg->status }}</span>
                        </div>
                        <p class="text-[#4A584F] text-[11px]">{{ $lg->target }}</p>
                        <span class="text-[10px] text-[#76847B] block">{{ $lg->time->diffForHumans() }} &bull; oleh {{ $lg->admin }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
