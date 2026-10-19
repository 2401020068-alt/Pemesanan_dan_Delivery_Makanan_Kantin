@extends('layouts.app')

@section('title', 'Katalog Menu Makanan')

@section('content')
<div class="space-y-6">
    <!-- Header with Search & Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Katalog Menu Kantin</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Jelajahi semua makanan, minuman, dan camilan di seluruh kantin kampus.</p>
        </div>

        <form action="{{ route('buyer.menu') }}" method="GET" class="flex gap-2 max-w-sm w-full">
            <input type="hidden" name="category" value="{{ $category }}">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-[#76847B] absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama makanan atau minuman..." class="w-full rounded-xl bg-white border border-[#E5ECE7] text-xs pl-10 pr-4 py-2.5 shadow-sm text-[#1A241E] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
            </div>
            <button type="submit" class="rounded-xl bg-[#1F3E2C] px-4 py-2 text-xs font-bold text-white hover:bg-[#2D553D] transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Category Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
        @foreach($categories as $cat)
            <a href="{{ route('buyer.menu', ['category' => $cat, 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $category === $cat ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'bg-white text-[#4A584F] border border-[#E5ECE7] hover:bg-[#F1F5F2]' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- Menu Items Grid -->
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @forelse($menus as $menu)
            <div class="bg-white rounded-2xl border border-[#E5ECE7] overflow-hidden shadow-subtle flex flex-col justify-between group hover:border-[#1F3E2C] transition-all">
                <div>
                    <div class="relative h-40 w-full overflow-hidden bg-[#F4F6F4]">
                        <img src="{{ $menu->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=70' }}" alt="{{ $menu->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="absolute bottom-2.5 left-2.5 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-[#173022]/85 text-white backdrop-blur-md">
                            {{ $menu->category }}
                        </span>
                        @if(!$menu->available)
                            <span class="absolute inset-0 bg-[#173022]/75 flex items-center justify-center text-xs font-bold text-white uppercase tracking-wider backdrop-blur-[2px]">
                                Habis
                            </span>
                        @endif
                    </div>
                    <div class="p-4">
                        <a href="{{ route('buyer.canteens.show', $menu->shop_id) }}" class="text-[10px] font-semibold text-[#3F6E52] hover:underline block mb-1">
                            {{ $menu->shop->name ?? 'Warung Kantin' }}
                        </a>
                        <h2 class="font-display font-bold text-sm text-[#1A241E] line-clamp-1">{{ $menu->name }}</h2>
                        <p class="mt-1 text-xs text-[#76847B] line-clamp-2 leading-relaxed">{{ $menu->description }}</p>
                    </div>
                </div>

                <div class="p-4 pt-0 flex items-center justify-between border-t border-[#E5ECE7] mt-2">
                    <div>
                        <span class="text-[10px] text-[#76847B] block">Harga</span>
                        <span class="font-display font-bold text-sm text-[#1A241E]">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                    @if($menu->available)
                        <form action="{{ route('buyer.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold transition active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span>Pesan</span>
                            </button>
                        </form>
                    @else
                        <span class="text-xs font-semibold text-[#76847B]">Habis</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-dashed border-[#C8D6CD] p-12 text-center text-xs text-[#76847B]">
                Tidak ada menu ditemukan untuk kriteria pencarian ini.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $menus->links() }}
    </div>
</div>
@endsection
