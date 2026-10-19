@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Riwayat Pesanan</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Pantau status pesanan makanan aktif dan riwayat transaksi sebelumnya.</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-[#E5ECE7] pb-2 overflow-x-auto scrollbar-none">
        <a href="{{ route('buyer.orders', ['status' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'all' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Semua Pesanan
        </a>
        <a href="{{ route('buyer.orders', ['status' => 'active']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'active' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Sedang Berlangsung
        </a>
        <a href="{{ route('buyer.orders', ['status' => 'done']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'done' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Selesai
        </a>
        <a href="{{ route('buyer.orders', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'cancelled' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Dibatalkan
        </a>
    </div>

    <!-- Orders Cards -->
    <div class="space-y-4">
        @forelse($orders as $order)
            @php
                $statusBadges = [
                    'created' => ['bg' => 'bg-[#F6F3EF] text-[#A68A68] border-[#E5ECE7]', 'label' => 'Menunggu Pembayaran'],
                    'paid' => ['bg' => 'bg-[#E3ECE6] text-[#1F3E2C] border-[#BFD4C7]', 'label' => 'Sudah Dibayar'],
                    'processing' => ['bg' => 'bg-[#F1F5F2] text-[#2D553D] border-[#BFD4C7]', 'label' => 'Sedang Dimasak'],
                    'ready' => ['bg' => 'bg-[#F6F3EF] text-[#8E7252] border-[#E5ECE7]', 'label' => 'Siap Diantar'],
                    'delivering' => ['bg' => 'bg-[#E3ECE6] text-[#173022] border-[#BFD4C7]', 'label' => 'Dalam Pengantaran'],
                    'done' => ['bg' => 'bg-[#E3ECE6] text-[#1F3E2C] border-[#BFD4C7]', 'label' => 'Selesai'],
                    'cancelled' => ['bg' => 'bg-[#FDF3F3] text-[#C25454] border-[#F3C5C5]', 'label' => 'Dibatalkan'],
                ];
                $badge = $statusBadges[$order->status] ?? ['bg' => 'bg-[#F4F6F4] text-[#76847B] border-[#E5ECE7]', 'label' => $order->status];
            @endphp

            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 sm:p-6 shadow-subtle space-y-4 hover:border-[#C8D6CD] transition">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-[#E5ECE7]">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C] font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </span>
                        <div>
                            <h2 class="font-display font-bold text-[#1A241E] text-sm sm:text-base">{{ $order->shop->name ?? 'Warung Kantin' }}</h2>
                            <span class="text-[11px] text-[#76847B] font-mono">{{ $order->id }} - {{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Items Preview -->
                <div class="space-y-2">
                    @foreach($order->items->take(2) as $item)
                        <div class="flex items-center justify-between text-xs text-[#4A584F]">
                            <span>{{ $item->qty }}x {{ $item->name }}</span>
                            <span class="font-medium text-[#1A241E]">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    @if($order->items->count() > 2)
                        <p class="text-[11px] text-[#76847B] italic">+ {{ $order->items->count() - 2 }} item lainnya</p>
                    @endif
                </div>

                <!-- Footer details -->
                <div class="pt-3 border-t border-[#E5ECE7] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <span class="text-[10px] text-[#76847B] uppercase tracking-wider block">Total Belanja</span>
                        <span class="font-display font-bold text-base text-[#1A241E]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($order->payment_status === 'unpaid')
                            <a href="{{ route('buyer.payment', $order->id) }}" class="px-4 py-2 rounded-xl bg-[#A68A68] hover:bg-[#8E7252] text-white text-xs font-bold shadow-xs transition">
                                Bayar Sekarang
                            </a>
                        @endif
                        <a href="{{ route('buyer.orders.show', $order->id) }}" class="px-4 py-2 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold transition">
                            Lihat Detail &amp; Lacak
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-dashed border-[#C8D6CD] p-12 text-center shadow-subtle">
                <svg class="w-12 h-12 text-[#76847B] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <p class="font-display font-bold text-[#1A241E]">Belum ada pesanan</p>
                <p class="text-xs text-[#76847B] mt-1">Pesanan Anda akan muncul di sini setelah Anda checkout.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
