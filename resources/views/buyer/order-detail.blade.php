@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="font-display text-2xl font-bold text-[#1A241E]">{{ $order->id }}</h1>
                <span class="text-xs font-mono text-[#76847B]">({{ $order->trx_id }})</span>
            </div>
            <p class="text-xs text-[#76847B] mt-1">Dipesan pada {{ $order->created_at->format('d F Y, H:i') }} WIB &bull; Warung: {{ $order->shop->name ?? 'Kantin' }}</p>
        </div>
        <a href="{{ route('buyer.orders') }}" class="text-xs font-semibold text-[#1F3E2C] hover:underline">Kembali ke Daftar Pesanan</a>
    </div>

    <!-- Live Order Tracking Stepper -->
    @php
        $steps = [
            ['key' => 'created', 'label' => 'Pesanan Dibuat', 'desc' => 'Menunggu Pembayaran'],
            ['key' => 'paid', 'label' => 'Pembayaran Valid', 'desc' => 'Diverifikasi Penjual'],
            ['key' => 'processing', 'label' => 'Sedang Dimasak', 'desc' => 'Dapur Warung'],
            ['key' => 'ready', 'label' => 'Siap Diantar', 'desc' => 'Menunggu Driver'],
            ['key' => 'delivering', 'label' => 'Dalam Perjalanan', 'desc' => 'Driver Mengantar'],
            ['key' => 'done', 'label' => 'Pesanan Selesai', 'desc' => 'Telah Diterima'],
        ];

        $statusIndexMap = [
            'created' => 0,
            'paid' => 1,
            'processing' => 2,
            'ready' => 3,
            'delivering' => 4,
            'done' => 5,
            'cancelled' => -1,
        ];

        $currentStepIndex = $statusIndexMap[$order->status] ?? 0;
    @endphp

    @if($order->status === 'cancelled')
        <div class="bg-[#FDF3F3] border border-[#F3C5C5] rounded-3xl p-6 text-[#8A2E2E] shadow-subtle flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#C25454] text-white flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </span>
            <div>
                <h2 class="font-display font-bold text-lg text-[#8A2E2E]">Pesanan Telah Dibatalkan</h2>
                <p class="text-xs text-[#C25454] mt-0.5">Pesanan ini telah dibatalkan oleh pihak warung atau sistem karena pembayaran ditolak/waktu habis.</p>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle">
            <h2 class="font-display font-bold text-[#1A241E] text-base mb-6">Status Pengantaran Pesanan</h2>

            <!-- Stepper Progress -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                @foreach($steps as $idx => $step)
                    @php
                        $isCompleted = $idx < $currentStepIndex;
                        $isCurrent = $idx === $currentStepIndex;
                    @endphp
                    <div class="flex flex-col items-center text-center p-3 rounded-2xl {{ $isCurrent ? 'bg-[#E3ECE6] border border-[#BFD4C7]' : 'bg-[#F4F6F4]' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold mb-2 {{ $isCompleted ? 'bg-[#1F3E2C] text-white' : ($isCurrent ? 'bg-[#1F3E2C] text-white ring-4 ring-[#BFD4C7]' : 'bg-[#E5ECE7] text-[#76847B]') }}">
                            @if($isCompleted)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>
                        <span class="font-display font-bold text-xs {{ $isCurrent ? 'text-[#1F3E2C]' : ($isCompleted ? 'text-[#1A241E]' : 'text-[#76847B]') }}">
                            {{ $step['label'] }}
                        </span>
                        <span class="text-[10px] text-[#76847B] mt-0.5">{{ $step['desc'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Order Items & Details Grid -->
    <div class="grid gap-6 md:grid-cols-3">
        <!-- Items Table -->
        <div class="md:col-span-2 bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
            <h2 class="font-display font-bold text-[#1A241E] text-base">Rincian Menu yang Dipesan</h2>

            <div class="divide-y divide-[#E5ECE7]">
                @foreach($order->items as $item)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=200&q=70' }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-xl object-cover bg-[#F4F6F4]">
                            <div>
                                <h3 class="font-display font-bold text-[#1A241E] text-xs sm:text-sm">{{ $item->name }}</h3>
                                <span class="text-xs text-[#76847B]">{{ $item->qty }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <span class="font-display font-bold text-sm text-[#1A241E]">
                            Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-[#E5ECE7] space-y-2 text-xs text-[#4A584F]">
                <div class="flex justify-between">
                    <span>Subtotal Menu</span>
                    <span class="font-semibold text-[#1A241E]">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Ongkos Kirim</span>
                    <span class="font-semibold text-[#1A241E]">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-sm font-bold text-[#1A241E] pt-2 border-t border-[#E5ECE7]">
                    <span>Total Pembayaran</span>
                    <span class="font-display text-base text-[#1F3E2C]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Order Meta Card -->
        <div class="md:col-span-1 space-y-4">
            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4 text-xs">
                <h3 class="font-display font-bold text-[#1A241E] text-sm">Informasi Pengiriman</h3>

                <div class="space-y-1">
                    <span class="text-[10px] text-[#76847B] font-semibold uppercase">Tujuan</span>
                    <p class="font-medium text-[#1A241E]">{{ $order->address }}</p>
                </div>

                @if($order->note)
                    <div class="space-y-1">
                        <span class="text-[10px] text-[#76847B] font-semibold uppercase">Catatan Pembeli</span>
                        <p class="font-medium text-[#1A241E] bg-[#F4F6F4] p-2.5 rounded-xl border border-[#E5ECE7] italic">{{ $order->note }}</p>
                    </div>
                @endif

                <div class="space-y-1 pt-2 border-t border-[#E5ECE7]">
                    <span class="text-[10px] text-[#76847B] font-semibold uppercase">Driver Pengantar</span>
                    @if($order->driver)
                        <div class="flex items-center gap-2 mt-1">
                            <img src="{{ $order->driver->avatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=70' }}" class="w-7 h-7 rounded-full object-cover">
                            <div>
                                <p class="font-bold text-[#1A241E]">{{ $order->driver->name }}</p>
                                <span class="text-[10px] text-[#76847B]">{{ $order->driver->phone }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-[#76847B] italic">Menunggu driver mengambil pesanan...</p>
                    @endif
                </div>

                <div class="space-y-1 pt-2 border-t border-[#E5ECE7]">
                    <span class="text-[10px] text-[#76847B] font-semibold uppercase">Status Pembayaran</span>
                    <div class="mt-1">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $order->payment_status === 'verified' ? 'bg-[#E3ECE6] text-[#1F3E2C] border border-[#BFD4C7]' : ($order->payment_status === 'pending' ? 'bg-[#F1F5F2] text-[#2D553D] border border-[#BFD4C7]' : 'bg-[#F6F3EF] text-[#A68A68] border border-[#E5ECE7]') }}">
                            {{ ucfirst($order->payment_status) }} ({{ $order->payment_method }})
                        </span>
                    </div>
                </div>

                @if($order->payment_status === 'unpaid')
                    <a href="{{ route('buyer.payment', $order->id) }}" class="block w-full py-2.5 rounded-xl bg-[#A68A68] hover:bg-[#8E7252] text-white font-bold text-center text-xs shadow-xs transition">
                        Bayar Sekarang
                    </a>
                @endif
            </div>

            <!-- Complaint / Dispute Action -->
            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle text-center">
                <p class="text-xs text-[#76847B] mb-3">Pesanan bermasalah, salah menu, atau pembayaran tidak sesuai?</p>
                <a href="{{ route('buyer.disputes') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#F4F6F4] hover:bg-[#FDF3F3] text-[#4A584F] hover:text-[#C25454] text-xs font-semibold border border-[#E5ECE7] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Ajukan Sengketa / Komplain</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
