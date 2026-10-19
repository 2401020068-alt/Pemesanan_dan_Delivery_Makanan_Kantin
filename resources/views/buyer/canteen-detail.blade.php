@extends('layouts.app')

@section('title', $shop->name)

@section('content')
<div class="space-y-8">
    <!-- Canteen Hero Header -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] overflow-hidden shadow-subtle">
        <div class="relative h-48 sm:h-64 w-full bg-[#F4F6F4]">
            <img src="{{ $shop->image ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=70' }}" alt="{{ $shop->name }}" class="h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#173022]/90 via-[#173022]/40 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $shop->open ? 'bg-[#1F3E2C] text-white border border-[#BFD4C7]/40' : 'bg-[#173022] text-[#BFD4C7]' }}">
                            {{ $shop->open ? 'Buka Sekarang' : 'Tutup Sementara' }}
                        </span>
                        <span class="text-xs text-[#BFD4C7]">{{ $shop->hours }}</span>
                    </div>
                    <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white">{{ $shop->name }}</h1>
                    <p class="text-xs sm:text-sm text-[#BFD4C7] mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#709981]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        {{ $shop->location }}
                    </p>
                </div>
                <a href="{{ route('buyer.canteens') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white/20 hover:bg-white/30 backdrop-blur-md text-xs font-semibold text-white transition self-start sm:self-auto shadow-xs">
                    Kembali ke Kantin
                </a>
            </div>
        </div>
        <div class="p-6 text-xs sm:text-sm text-[#4A584F] border-t border-[#E5ECE7]">
            <p>{{ $shop->description }}</p>
        </div>
    </div>

    <!-- Canteen Menu Items -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-xl font-bold text-[#1A241E]">Daftar Menu Warung ({{ $shop->menuItems->count() }})</h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($shop->menuItems as $item)
                <div class="bg-white rounded-2xl border border-[#E5ECE7] overflow-hidden shadow-subtle flex flex-col justify-between hover:border-[#1F3E2C] transition">
                    <div>
                        <div class="relative h-40 w-full overflow-hidden bg-[#F4F6F4]">
                            <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=70' }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                            <span class="absolute top-3 left-3 px-2 py-0.5 rounded-md text-[10px] font-bold bg-[#173022]/85 text-white backdrop-blur-sm">
                                {{ $item->category }}
                            </span>
                            @if(!$item->available)
                                <span class="absolute inset-0 bg-[#173022]/75 flex items-center justify-center text-xs font-bold text-white uppercase tracking-wider backdrop-blur-[2px]">
                                    Habis
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-display font-bold text-[#1A241E] text-sm">{{ $item->name }}</h3>
                            <p class="mt-1 text-xs text-[#76847B] line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 flex items-center justify-between border-t border-[#E5ECE7] mt-2">
                        <div>
                            <span class="text-[10px] text-[#76847B] block">Harga</span>
                            <span class="font-display font-bold text-base text-[#1A241E]">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                        @if($item->available && $shop->open)
                            <form action="{{ route('buyer.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $item->id }}">
                                <button type="submit" class="flex items-center gap-1 px-3.5 py-2 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold shadow-xs transition active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    <span>Pesan</span>
                                </button>
                            </form>
                        @else
                            <button disabled class="px-3.5 py-2 rounded-xl bg-[#F4F6F4] text-[#76847B] text-xs font-semibold cursor-not-allowed">
                                Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-dashed border-[#C8D6CD] p-8 text-center text-xs text-[#76847B]">
                    Warung ini belum memiliki item menu aktif.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
