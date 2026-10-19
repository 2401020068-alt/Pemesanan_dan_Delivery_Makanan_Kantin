@extends('layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Checkout Pesanan</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Lengkapi alamat pengantaran dan pilih metode pembayaran.</p>
        </div>
        <a href="{{ route('buyer.cart') }}" class="text-xs font-semibold text-[#1F3E2C] hover:underline">Kembali ke Keranjang</a>
    </div>

    <form action="{{ route('buyer.checkout.place') }}" method="POST">
        @csrf
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Form Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Delivery Info Card -->
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-[#E5ECE7]">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C] font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </span>
                        <h2 class="font-display font-bold text-[#1A241E] text-base">Alamat Tujuan Pengantaran</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#1A241E] mb-1">Gedung / Ruangan / Titik Temu di Kampus *</label>
                        <input type="text" name="address" required value="{{ old('address', $buyer->address ?? 'Gedung Fakultas Teknik, Ruang 3.12') }}" placeholder="Contoh: Gedung Fakultas Teknik, Ruang 3.12" class="w-full rounded-xl border border-[#E5ECE7] px-3.5 py-2.5 text-sm text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20">
                        <p class="text-[11px] text-[#76847B] mt-1">Driver kantin akan mengantarkan pesanan langsung ke lokasi ini.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#1A241E] mb-1">Catatan Tambahan untuk Penjual / Driver (Opsional)</label>
                        <textarea name="note" rows="2" placeholder="Contoh: Sambal dipisah, tolong antarkan sebelum jam 12.00" class="w-full rounded-xl border border-[#E5ECE7] px-3.5 py-2.5 text-sm text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20"></textarea>
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-[#E5ECE7]">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#F6F3EF] text-[#A68A68] font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </span>
                        <h2 class="font-display font-bold text-[#1A241E] text-base">Pilih Metode Pembayaran</h2>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <label class="relative flex flex-col p-4 bg-[#F4F6F4] border-2 border-[#E5ECE7] rounded-2xl cursor-pointer hover:border-[#1F3E2C] transition has-[:checked]:border-[#1F3E2C] has-[:checked]:bg-[#E3ECE6]/40">
                            <input type="radio" name="payment_method" value="QRIS" checked class="sr-only">
                            <span class="font-display font-bold text-sm text-[#1A241E]">QRIS Instan</span>
                            <span class="text-[11px] text-[#76847B] mt-1">BCA, Gopay, OVO, Dana, LinkAja</span>
                        </label>

                        <label class="relative flex flex-col p-4 bg-[#F4F6F4] border-2 border-[#E5ECE7] rounded-2xl cursor-pointer hover:border-[#1F3E2C] transition has-[:checked]:border-[#1F3E2C] has-[:checked]:bg-[#E3ECE6]/40">
                            <input type="radio" name="payment_method" value="Transfer Bank" class="sr-only">
                            <span class="font-display font-bold text-sm text-[#1A241E]">Transfer Bank</span>
                            <span class="text-[11px] text-[#76847B] mt-1">Virtual Account / Rekening Warung</span>
                        </label>

                        <label class="relative flex flex-col p-4 bg-[#F4F6F4] border-2 border-[#E5ECE7] rounded-2xl cursor-pointer hover:border-[#1F3E2C] transition has-[:checked]:border-[#1F3E2C] has-[:checked]:bg-[#E3ECE6]/40">
                            <input type="radio" name="payment_method" value="E-Wallet" class="sr-only">
                            <span class="font-display font-bold text-sm text-[#1A241E]">E-Wallet</span>
                            <span class="text-[11px] text-[#76847B] mt-1">ShopeePay / Dompet Digital</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4 sticky top-24">
                    <h3 class="font-display font-bold text-[#1A241E] text-base">Rincian Belanja</h3>

                    <div class="text-xs text-[#76847B] border-b border-[#E5ECE7] pb-3">
                        @if(isset($shops) && count($shops) > 1)
                            <div class="mb-2 p-2 bg-emerald-50 rounded-xl border border-emerald-200 text-emerald-900">
                                <span class="font-bold flex items-center gap-1.5 text-xs text-emerald-800">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Pesanan Multi-Kantin ({{ count($shops) }} Kantin)
                                </span>
                                <p class="text-[11px] text-emerald-700 mt-0.5 truncate">{{ $shops->pluck('name')->join(', ') }}</p>
                            </div>
                        @else
                            <span class="font-semibold text-[#1A241E] block">Warung: {{ $shop->name ?? 'Kantin Kampus' }}</span>
                        @endif
                        <div class="mt-2 space-y-1.5">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-center text-xs">
                                    <div class="truncate pr-2">
                                        <span class="font-medium text-[#1A241E]">{{ $item['qty'] }}x {{ $item['menu']->name }}</span>
                                        @if(isset($item['menu']->shop))
                                            <span class="text-[10px] text-emerald-700 block -mt-0.5">{{ $item['menu']->shop->name }}</span>
                                        @endif
                                    </div>
                                    <span class="font-semibold text-[#1A241E] shrink-0">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2 text-xs text-[#4A584F] border-b border-[#E5ECE7] pb-4">
                        <div class="flex justify-between">
                            <span>Subtotal Menu</span>
                            <span class="font-semibold text-[#1A241E]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim Kampus</span>
                            <span class="font-semibold text-[#1A241E]">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-sm font-bold text-[#1A241E] pt-1">
                        <span>Total Tagihan</span>
                        <span class="font-display text-xl text-[#1F3E2C]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-sm shadow-subtle transition active:scale-98">
                        Buat Pesanan & Bayar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
