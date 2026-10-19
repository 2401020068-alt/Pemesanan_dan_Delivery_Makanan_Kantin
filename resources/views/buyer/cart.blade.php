@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Keranjang Belanja</h1>
        <p class="text-xs sm:text-sm text-[#76847B] mt-1">Periksa item makanan dan minuman sebelum melanjutkan pemesanan.</p>
    </div>

    @if(count($cartItems) > 0)
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Left: Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Shop Info Banner -->
                <!-- Shop Info Banner -->
                @if(isset($shops) && count($shops) > 1)
                    <div class="bg-gradient-to-r from-[#EAF2ED] via-[#F2F7F4] to-[#E3ECE6] border border-[#BFD4C7] rounded-2xl p-4 sm:p-4.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3.5 shadow-xs">
                        <div class="flex items-center gap-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#1F3E2C] text-white shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-display font-bold text-[#1A241E] text-sm sm:text-base">
                                        Pesanan Multi-Kantin
                                    </h3>
                                    <span class="text-[10px] bg-[#1F3E2C] text-white px-2 py-0.5 rounded-lg font-bold tracking-wide">
                                        {{ count($shops) }} Kantin
                                    </span>
                                </div>
                                <p class="text-xs text-[#526357] mt-0.5">Bisa pesan menu dari kantin berbeda sekaligus dalam satu keranjang.</p>
                            </div>
                        </div>
                        <a href="{{ route('buyer.canteens') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2A523A] text-white text-xs font-bold shadow-xs hover:shadow-md transition-all duration-200 active:scale-95 shrink-0 self-start sm:self-auto">
                            <svg class="w-3.5 h-3.5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah dari Kantin Lain</span>
                        </a>
                    </div>
                @elseif($shop)
                    <div class="bg-gradient-to-r from-[#EAF2ED] via-[#F2F7F4] to-[#E3ECE6] border border-[#BFD4C7] rounded-2xl p-4 sm:p-4.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3.5 shadow-xs">
                        <div class="flex items-center gap-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#1F3E2C] text-white shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            <div>
                                <h3 class="font-display font-bold text-[#1A241E] text-sm sm:text-base">{{ $shop->name }}</h3>
                                <p class="text-xs text-[#526357] mt-0.5">{{ $shop->location }}</p>
                            </div>
                        </div>
                        <a href="{{ route('buyer.canteens.show', $shop->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2A523A] text-white text-xs font-bold shadow-xs hover:shadow-md transition-all duration-200 active:scale-95 shrink-0 self-start sm:self-auto">
                            <svg class="w-3.5 h-3.5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Menu Lain</span>
                        </a>
                    </div>
                @endif

                <!-- Items Container -->
                <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden divide-y divide-[#E5ECE7]">
                    @foreach($cartItems as $item)
                        <div class="p-4 sm:p-5 flex items-center gap-4">
                            <img src="{{ $item['menu']->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=200&q=70' }}" alt="{{ $item['menu']->name }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover bg-[#F4F6F4] flex-shrink-0">

                            <div class="flex-1 min-w-0">
                                <h3 class="font-display font-bold text-[#1A241E] text-sm sm:text-base truncate">{{ $item['menu']->name }}</h3>
                                <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                    <p class="text-xs font-semibold text-[#3F6E52]">Rp {{ number_format($item['menu']->price, 0, ',', '.') }}</p>
                                    @if(isset($item['menu']->shop))
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200/80 px-2 py-0.5 rounded-md">
                                            {{ $item['menu']->shop->name }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3 flex items-center gap-3">
                                    <!-- Qty Stepper with clean SVGs -->
                                    <div class="inline-flex items-center rounded-xl border border-[#E5ECE7] bg-[#F4F6F4] p-1">
                                        <form action="{{ route('buyer.cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $item['menu']->id }}">
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" aria-label="Kurangi jumlah" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white text-[#1A241E] shadow-xs hover:bg-[#E5ECE7] transition active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                            </button>
                                        </form>

                                        <span class="w-8 text-center text-xs font-bold text-[#1A241E]">{{ $item['qty'] }}</span>

                                        <form action="{{ route('buyer.cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $item['menu']->id }}">
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" aria-label="Tambah jumlah" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white text-[#1A241E] shadow-xs hover:bg-[#E5ECE7] transition active:scale-95">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            </button>
                                        </form>
                                    </div>

                                    <form action="{{ route('buyer.cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $item['menu']->id }}">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="inline-flex items-center gap-1 text-xs text-rose-600 hover:text-rose-800 font-semibold px-2 py-1 rounded-lg hover:bg-rose-50 transition active:scale-95">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="text-right">
                                <span class="font-display font-bold text-[#1A241E] text-sm sm:text-base">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Order Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4 sticky top-24">
                    <h3 class="font-display font-bold text-[#1A241E] text-base">Ringkasan Pembayaran</h3>

                    <div class="space-y-2.5 text-xs text-[#4A584F] border-b border-[#E5ECE7] pb-4">
                        <div class="flex justify-between">
                            <span>Subtotal Menu</span>
                            <span class="font-semibold text-[#1A241E]">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkir Antar Kampus</span>
                            <span class="font-semibold text-[#1A241E]">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[#76847B] text-[11px]">
                            <span>Biaya Layanan</span>
                            <span>Rp 0 (Gratis)</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-sm font-bold text-[#1A241E] pt-1">
                        <span>Total Bayar</span>
                        <span class="font-display text-lg text-[#1F3E2C]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('buyer.checkout') }}" class="flex items-center justify-center w-full py-3.5 rounded-2xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-sm shadow-subtle transition active:scale-98">
                        <span>Lanjut ke Checkout</span>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-12 text-center shadow-subtle max-w-md mx-auto">
            <div class="w-16 h-16 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h2 class="font-display font-bold text-[#1A241E] text-lg">Keranjang Belanja Kosong</h2>
            <p class="text-xs text-[#76847B] mt-1 mb-6">Pilih makanan dan minuman lezat dari kantin kampus untuk mengisi keranjang Anda.</p>
            <a href="{{ route('buyer.canteens') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold shadow-xs transition active:scale-98">
                <span>Mulai Pesan Sekarang</span>
            </a>
        </div>
    @endif
</div>
@endsection
