@extends('layouts.app')

@section('title', 'Beranda Pembeli')

@section('content')
<div class="space-y-8">
    <!-- Hero / Promo Showcase Banner with Deep Moss Multi-Layer Gradient -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#163322] via-[#1D402C] to-[#264F38] p-6 sm:p-8 lg:p-10 text-white shadow-xl border border-white/10 ring-1 ring-white/10">
        <!-- Ambient decorative background glows (pure CSS) -->
        <div class="pointer-events-none absolute -top-20 -right-20 h-80 w-80 rounded-full bg-gradient-to-br from-[#709981]/25 to-transparent blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-16 -left-16 h-72 w-72 rounded-full bg-gradient-to-tr from-[#A68A68]/15 via-[#3F6E52]/20 to-transparent blur-2xl"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/5 via-transparent to-transparent"></div>

        <div class="relative z-10 grid gap-6 lg:grid-cols-12 lg:items-center">
            <!-- Left Info & Search -->
            <div class="lg:col-span-7 xl:col-span-8 max-w-2xl">
                <!-- Pill Badge with White Logo -->
                <div class="inline-flex items-center gap-2 rounded-full bg-white/12 px-3.5 py-1.5 text-xs font-semibold backdrop-blur-md border border-white/20 text-[#E8F3ED] shadow-xs transition-colors hover:bg-white/15">
                    <img src="{{ asset('images/logo_white.svg') }}" alt="KantinKu Logo" class="h-4 w-auto object-contain shrink-0 filter drop-shadow-xs">
                    <span class="tracking-wide">Kantin Kampus Online Terpadu</span>
                </div>

                <h1 class="mt-3.5 font-display text-2xl sm:text-3xl lg:text-[2.5rem] font-extrabold leading-tight tracking-tight text-white">
                    Mau makan apa hari ini, <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-[#E8F3ED] to-[#BFD4C7]">{{ $buyer->name }}</span>?
                </h1>

                <p class="mt-2.5 text-sm sm:text-base text-[#D0E2D6] leading-relaxed max-w-xl font-normal">
                    Pesan makanan hangat dari warung kantin favorit di kampus, bayar praktis via QRIS, dan nikmati hidangan lezat langsung di kelas atau ruanganmu.
                </p>

                <!-- Search Input Form with elevated floating container -->
                <form action="{{ route('buyer.index') }}" method="GET" class="mt-6 max-w-xl">
                    <div class="relative flex items-center bg-white rounded-2xl p-1.5 shadow-lg shadow-black/15 border border-white/40 transition-all focus-within:ring-2 focus-within:ring-[#BFD4C7] focus-within:shadow-xl">
                        <div class="flex items-center pl-3.5 pr-2 pointer-events-none text-[#76847B]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nasi goreng, mie ayam, kopi, jus..." class="w-full bg-transparent text-[#1A241E] placeholder-[#76847B] text-sm py-2 px-1 focus:outline-none font-medium">
                        @if($search)
                            <a href="{{ route('buyer.index') }}" class="p-1.5 mr-1 text-[#76847B] hover:text-[#1A241E] rounded-lg transition" title="Reset">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                        <button type="submit" class="shrink-0 rounded-xl bg-gradient-to-r from-[#A68A68] to-[#8E7252] hover:from-[#B89A74] hover:to-[#9E805E] px-5 py-2.5 text-sm font-bold text-white shadow-xs transition-all active:scale-95 flex items-center gap-1.5">
                            <span>Cari</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <!-- Quick Search Suggestion Chips -->
                    <div class="mt-3.5 flex flex-wrap items-center gap-2 text-xs">
                        <span class="text-[11px] font-medium text-[#BFD4C7]/80">Coba cari:</span>
                        @foreach(['Nasi Goreng', 'Mie Ayam', 'Kopi Susu', 'Ayam Geprek'] as $chip)
                            <a href="{{ route('buyer.index', ['q' => $chip]) }}" class="inline-flex items-center px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/20 text-[#E8F3ED] text-[11px] font-medium backdrop-blur-sm border border-white/15 transition-all hover:scale-105 active:scale-95">
                                {{ $chip }}
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>

            <!-- Right Showcase Card (Clean, Sharp, Human-Crafted) -->
            <div class="hidden lg:flex lg:col-span-5 xl:col-span-4 justify-end">
                <div class="w-full max-w-xs bg-[#0A1D13] border border-emerald-500/30 rounded-2xl p-5 shadow-2xl relative">
                    <!-- Top Status Bar -->
                    <div class="flex items-center justify-between gap-2 pb-3.5 border-b border-emerald-900/60">
                        <span class="text-xs font-bold text-white tracking-wide">Layanan Kampus Aktif</span>
                        <span class="inline-flex items-center justify-center text-center whitespace-nowrap text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 px-3 py-1 rounded-full border border-emerald-500/40 leading-none">Siap Antar</span>
                    </div>

                    <!-- Service Highlight Items -->
                    <div class="mt-3.5 space-y-2.5">
                        <!-- Item 1: Antar Cepat -->
                        <div class="flex items-center gap-3 bg-[#11281B] hover:bg-[#163323] transition-colors duration-150 rounded-xl p-3 border border-emerald-900/50">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-white text-xs leading-snug">Antar Cepat ke Kelas</div>
                                <div class="text-[11px] text-emerald-200/75 leading-tight mt-0.5">Estimasi 10–20 Menit</div>
                            </div>
                        </div>

                        <!-- Item 2: QRIS & Transfer -->
                        <div class="flex items-center gap-3 bg-[#11281B] hover:bg-[#163323] transition-colors duration-150 rounded-xl p-3 border border-emerald-900/50">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-white text-xs leading-snug">QRIS & Transfer Instan</div>
                                <div class="text-[11px] text-emerald-200/75 leading-tight mt-0.5">Tanpa repot uang kembalian</div>
                            </div>
                        </div>

                        <!-- Item 3: Warung Terverifikasi -->
                        <div class="flex items-center gap-3 bg-[#11281B] hover:bg-[#163323] transition-colors duration-150 rounded-xl p-3 border border-emerald-900/50">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-teal-500/20 text-teal-400 border border-teal-500/30">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-white text-xs leading-snug">Warung Terverifikasi</div>
                                <div class="text-[11px] text-emerald-200/75 leading-tight mt-0.5">Menu higienis harga mahasiswa</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Coverage Info -->
                    <div class="mt-3.5 pt-3 border-t border-emerald-900/60 flex items-center justify-between text-[11px] text-emerald-300/80">
                        <span class="flex items-center gap-1.5 font-medium">
                            <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Tarif Flat Kampus
                        </span>
                        <span class="font-bold text-white bg-emerald-900/80 px-2 py-0.5 rounded-md border border-emerald-500/30">Rp 3.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Features Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
        <div class="group bg-white hover:bg-[#F9FAF9] rounded-2xl border border-[#E5ECE7] hover:border-[#1F3E2C]/30 p-4 flex items-center gap-3.5 shadow-subtle hover:shadow-md transition-all duration-200">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C] group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </span>
            <div>
                <h4 class="text-xs font-bold text-[#1A241E]">Antar Cepat ke Ruangan</h4>
                <p class="text-[11px] text-[#76847B] mt-0.5">Driver standby di tiap fakultas</p>
            </div>
        </div>
        <div class="group bg-white hover:bg-[#F9FAF9] rounded-2xl border border-[#E5ECE7] hover:border-[#A68A68]/40 p-4 flex items-center gap-3.5 shadow-subtle hover:shadow-md transition-all duration-200">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F6F3EF] text-[#A68A68] group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            <div>
                <h4 class="text-xs font-bold text-[#1A241E]">Harga Ramah Kantong</h4>
                <p class="text-[11px] text-[#76847B] mt-0.5">Tarif resmi standar kantin kampus</p>
            </div>
        </div>
        <div class="group bg-white hover:bg-[#F9FAF9] rounded-2xl border border-[#E5ECE7] hover:border-[#3F6E52]/40 p-4 flex items-center gap-3.5 shadow-subtle hover:shadow-md transition-all duration-200">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#F1F5F2] text-[#3F6E52] group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            <div>
                <h4 class="text-xs font-bold text-[#1A241E]">Pelacakan Real-Time</h4>
                <p class="text-[11px] text-[#76847B] mt-0.5">Pantau dari proses masak s.d tiba</p>
            </div>
        </div>
    </div>

    <!-- Category Filter Pills -->
    <div>
        <div class="flex items-center justify-between mb-3.5">
            <div>
                <h2 class="font-display text-lg font-bold text-[#1A241E]">Kategori Menu</h2>
                <p class="text-xs text-[#76847B]">Pilih varian menu favoritmu</p>
            </div>
            <a href="{{ route('buyer.menu') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-[#1F3E2C] bg-[#E3ECE6] hover:bg-[#BFD4C7] transition shadow-xs">
                Semua Menu
            </a>
        </div>
        <div class="flex items-center gap-2.5 overflow-x-auto pb-1 scrollbar-none">
            @foreach($categories as $cat)
                <a href="{{ route('buyer.index', ['category' => $cat, 'q' => $search]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $category === $cat ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'bg-white text-[#4A584F] border border-[#E5ECE7] hover:bg-[#F1F5F2] hover:border-[#C8D6CD]' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $category === $cat ? 'bg-white' : 'bg-[#709981]' }}"></span>
                    <span>{{ $cat }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Warung Kantin Terpopuler -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-display text-lg font-bold text-[#1A241E]">Warung Kantin</h2>
                <p class="text-xs text-[#76847B]">Pilih dari warung resmi terverifikasi di area kampus</p>
            </div>
            <a href="{{ route('buyer.canteens') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-[#1F3E2C] bg-[#E3ECE6] hover:bg-[#BFD4C7] transition shadow-xs">
                Lihat Semua ({{ count($shops) }})
            </a>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($shops->take(3) as $shop)
                <a href="{{ route('buyer.canteens.show', $shop->id) }}" class="group bg-white rounded-2xl border border-[#E5ECE7] overflow-hidden shadow-subtle hover:border-[#1F3E2C] transition-all">
                    <div class="relative h-40 w-full overflow-hidden bg-[#F4F6F4]">
                        <img src="{{ $shop->image ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=70' }}" alt="{{ $shop->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $shop->open ? 'bg-[#1F3E2C]/90 text-white' : 'bg-[#1A241E]/80 text-[#BFD4C7]' }} backdrop-blur-md">
                                <span class="w-1.5 h-1.5 rounded-full {{ $shop->open ? 'bg-white animate-pulse' : 'bg-[#76847B]' }}"></span>
                                {{ $shop->open ? 'Buka' : 'Tutup' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4.5">
                        <h3 class="font-display font-bold text-[#1A241E] group-hover:text-[#1F3E2C] transition text-base">{{ $shop->name }}</h3>
                        <p class="mt-1 text-xs text-[#76847B] line-clamp-1 leading-relaxed">{{ $shop->description }}</p>
                        <div class="mt-3.5 flex items-center justify-between text-[11px] text-[#76847B] border-t border-[#E5ECE7] pt-3">
                            <span class="flex items-center gap-1 text-[#4A584F] font-medium">
                                <svg class="w-3.5 h-3.5 text-[#3F6E52]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $shop->location }}
                            </span>
                            <span class="text-[#76847B]">{{ $shop->hours }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Menu Rekomendasi Grid -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-display text-lg font-bold text-[#1A241E]">Menu Rekomendasi Hari Ini</h2>
                <p class="text-xs text-[#76847B]">Paling banyak dipesan oleh mahasiswa dan dosen</p>
            </div>
            <a href="{{ route('buyer.menu') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold text-[#1F3E2C] bg-[#E3ECE6] hover:bg-[#BFD4C7] transition shadow-xs">
                Jelajahi Menu
            </a>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($menus as $menu)
                <div class="bg-white rounded-2xl border border-[#E5ECE7] overflow-hidden shadow-subtle flex flex-col justify-between group hover:border-[#1F3E2C] transition-all">
                    <div>
                        <div class="relative h-40 w-full overflow-hidden bg-[#F4F6F4]">
                            <img src="{{ $menu->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=70' }}" alt="{{ $menu->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute bottom-2.5 left-2.5 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-[#173022]/80 text-white backdrop-blur-md">
                                {{ $menu->category }}
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#3F6E52] block mb-1">{{ $menu->shop->name ?? 'Warung Kantin' }}</span>
                            <h3 class="font-display font-bold text-sm text-[#1A241E] line-clamp-1 group-hover:text-[#1F3E2C] transition">{{ $menu->name }}</h3>
                            <p class="mt-1 text-xs text-[#76847B] line-clamp-2 leading-relaxed">{{ $menu->description }}</p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 flex items-center justify-between border-t border-[#E5ECE7] mt-2">
                        <div>
                            <span class="text-[10px] text-[#76847B] block font-medium">Harga</span>
                            <span class="font-display font-bold text-sm text-[#1A241E]">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </div>
                        <form action="{{ route('buyer.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <button type="submit" class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold transition shadow-xs active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span>Pesan</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
