@extends('layouts.app')

@section('title', 'Laporan Kantin Digital')

@section('content')
<div class="space-y-6">
    <!-- Header with Export CSV -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Laporan Kantin Digital</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Ringkasan transaksi dan performa omset seluruh warung kampus.</p>
        </div>

        <a href="{{ route('admin.reports.export') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Ekspor CSV (Excel)</span>
        </a>
    </div>

    <!-- 4 Summary Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle">
            <div class="flex items-center justify-between text-[#76847B] mb-2">
                <span class="text-xs font-semibold">Total Pendapatan</span>
                <span class="p-2 rounded-xl bg-[#E3ECE6] text-[#1F3E2C]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1F3E2C]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <p class="text-[11px] text-[#3F6E52] mt-1 font-medium">Transaksi terverifikasi</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle">
            <div class="flex items-center justify-between text-[#76847B] mb-2">
                <span class="text-xs font-semibold">Total Transaksi</span>
                <span class="p-2 rounded-xl bg-[#F1F5F2] text-[#3F6E52]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">{{ $allOrders->count() }}</div>
            <p class="text-[11px] text-[#76847B] mt-1">Keseluruhan pesanan</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle">
            <div class="flex items-center justify-between text-[#76847B] mb-2">
                <span class="text-xs font-semibold">Pesanan Selesai</span>
                <span class="p-2 rounded-xl bg-[#E3ECE6] text-[#1F3E2C]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">{{ $completedOrdersCount }}</div>
            <p class="text-[11px] text-[#3F6E52] mt-1 font-medium">Berhasil diantar</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle">
            <div class="flex items-center justify-between text-[#76847B] mb-2">
                <span class="text-xs font-semibold">Dibatalkan</span>
                <span class="p-2 rounded-xl bg-[#FDF3F3] text-[#C25454]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#C25454]">{{ $cancelledOrdersCount }}</div>
            <p class="text-[11px] text-[#C25454] mt-1 font-medium">Gagal / Ditolak</p>
        </div>
    </div>

    <!-- Pendapatan per Warung Progress Breakdown -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
        <h2 class="font-display font-bold text-[#1A241E] text-base">Pendapatan Omset per Warung Kantin</h2>

        <div class="space-y-4">
            @foreach($perShop as $item)
                @php
                    $percentage = $maxShopRevenue > 0 ? round(($item['revenue'] / $maxShopRevenue) * 100) : 0;
                @endphp
                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-bold text-[#1A241E]">{{ $item['shop']->name }}</span>
                        <span class="font-display font-bold text-[#1A241E]">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</span>
                    </div>
                    <div class="h-2.5 rounded-full bg-[#F4F6F4] overflow-hidden">
                        <div class="h-full rounded-full bg-[#1F3E2C] transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Table of All Orders -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
        <div class="p-5 border-b border-[#E5ECE7] flex items-center justify-between">
            <h2 class="font-display font-bold text-base text-[#1A241E]">Daftar Transaksi Keseluruhan</h2>
            <span class="text-xs text-[#76847B]">Total {{ $allOrders->count() }} transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">ID Pesanan</th>
                        <th class="px-5 py-3.5">Waktu Transaksi</th>
                        <th class="px-5 py-3.5">Pembeli</th>
                        <th class="px-5 py-3.5">Warung</th>
                        <th class="px-5 py-3.5">Total (Rp)</th>
                        <th class="px-5 py-3.5">Metode Bayar</th>
                        <th class="px-5 py-3.5">Status Pesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($allOrders as $o)
                        @php
                            $statusConfig = [
                                'created' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Menunggu Bayar'],
                                'paid' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Terbayar'],
                                'processing' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'label' => 'Sedang Dimasak'],
                                'ready' => ['bg' => 'bg-indigo-50 text-indigo-800 border-indigo-200', 'label' => 'Siap Diantar'],
                                'delivering' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200', 'label' => 'Diantar Kurir'],
                                'done' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Selesai'],
                                'cancelled' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'label' => 'Dibatalkan'],
                            ];
                            $st = $statusConfig[$o->status] ?? ['bg' => 'bg-[#F4F6F4] text-[#76847B] border-[#E5ECE7]', 'label' => ucfirst($o->status)];
                        @endphp
                        <tr class="hover:bg-[#FAFBF9] transition">
                            <td class="px-5 py-3.5 font-mono font-bold text-[#1A241E]">{{ $o->id }}</td>
                            <td class="px-5 py-3.5 text-[11px] text-[#76847B]">{{ $o->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-3.5 font-medium text-[#1A241E]">{{ $o->buyer->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-[#4A584F]">{{ $o->shop->name ?? '-' }}</td>
                            <td class="px-5 py-3.5 font-bold text-[#1A241E]">Rp {{ number_format($o->total, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-[#F4F6F4] border border-[#E5ECE7] text-[#1A241E]">
                                    {{ $o->payment_method }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $st['bg'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-[#76847B]">
                                <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="font-bold text-[#1A241E] text-sm">Belum Ada Transaksi Tercatat</p>
                                <p class="text-xs text-[#76847B] mt-0.5">Semua riwayat transaksi pesanan kantin akan terdaftar di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
