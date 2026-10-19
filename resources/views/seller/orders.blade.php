@extends('layouts.app')

@section('title', 'Daftar Pesanan Warung')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Kelola Pesanan Masuk</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Warung: {{ $shop->name ?? 'Kantin' }} &bull; Perbarui status pesanan dari antrean masak hingga siap diambil driver.</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-[#E5ECE7] pb-2 overflow-x-auto scrollbar-none">
        <a href="{{ route('seller.orders', ['status' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'all' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Semua</a>
        <a href="{{ route('seller.orders', ['status' => 'paid']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'paid' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Perlu Dimasak</a>
        <a href="{{ route('seller.orders', ['status' => 'processing']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'processing' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Sedang Dimasak</a>
        <a href="{{ route('seller.orders', ['status' => 'ready']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'ready' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Siap Diantar</a>
        <a href="{{ route('seller.orders', ['status' => 'done']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'done' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Selesai</a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">ID &amp; Waktu</th>
                        <th class="px-5 py-3.5">Pembeli</th>
                        <th class="px-5 py-3.5">Alamat Antar</th>
                        <th class="px-5 py-3.5">Rincian Menu</th>
                        <th class="px-5 py-3.5">Total (Rp)</th>
                        <th class="px-5 py-3.5">Status Pesanan</th>
                        <th class="px-5 py-3.5 text-right">Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($orders as $ord)
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
                            <td class="px-5 py-3.5">
                                <span class="font-mono font-bold text-[#1A241E] block">{{ $ord->id }}</span>
                                <span class="text-[10px] text-[#76847B]">{{ $ord->created_at->format('d/m H:i') }} WIB</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-[#1A241E] block">{{ $ord->buyer->name ?? 'Pembeli' }}</span>
                                <span class="text-[10px] text-[#76847B] font-mono">{{ $ord->buyer->phone ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-3.5 max-w-[180px] truncate" title="{{ $ord->address }}">
                                <span class="text-xs text-slate-700">{{ $ord->address }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @foreach($ord->items as $it)
                                    <div class="truncate text-[11px] font-medium text-slate-800">{{ $it->qty }}x {{ $it->name }}</div>
                                @endforeach
                            </td>
                            <td class="px-5 py-3.5 font-bold text-[#1A241E]">
                                Rp {{ number_format($ord->total, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $st['bg'] }}">
                                    {{ $st['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <a href="{{ route('seller.orders.show', $ord->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold transition shadow-xs">
                                    <span>Detail</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-[#76847B]">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Tidak Ada Pesanan</p>
                                    <p class="text-[11px] text-slate-400">Tidak ada pesanan masuk dengan kategori filter status ini.</p>
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
