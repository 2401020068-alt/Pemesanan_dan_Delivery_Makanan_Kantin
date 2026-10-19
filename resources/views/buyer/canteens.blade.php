@extends('layouts.app')

@section('title', 'Daftar Kantin Kampus')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Daftar Kantin Kampus</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Pilih warung kantin resmi di fakultas atau gedung kampus.</p>
        </div>

        <form action="{{ route('buyer.canteens') }}" method="GET" class="relative max-w-xs w-full">
            <svg class="w-4 h-4 text-[#76847B] absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama warung atau lokasi..." class="w-full rounded-xl bg-white border border-[#E5ECE7] text-xs pl-10 pr-4 py-2.5 shadow-sm text-[#1A241E] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
        </form>
    </div>

    <!-- Canteens Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($canteens as $canteen)
            <div class="bg-white rounded-2xl border border-[#E5ECE7] overflow-hidden shadow-subtle flex flex-col justify-between group hover:border-[#1F3E2C] transition-all">
                <div>
                    <div class="relative h-44 w-full overflow-hidden bg-[#F4F6F4]">
                        <img src="{{ $canteen->image ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=70' }}" alt="{{ $canteen->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span class="inline-flex items-center justify-center absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold {{ $canteen->open ? 'bg-[#1F3E2C]/95 text-white' : 'bg-[#173022]/85 text-[#BFD4C7]' }} backdrop-blur-md shadow-xs">
                            {{ $canteen->open ? 'Sedang Buka' : 'Tutup' }}
                        </span>
                    </div>

                    <div class="p-5">
                        <h2 class="font-display text-lg font-bold text-[#1A241E]">{{ $canteen->name }}</h2>
                        <p class="mt-1.5 text-xs text-[#76847B] leading-relaxed">{{ $canteen->description }}</p>

                        <div class="mt-4 space-y-2 text-xs text-[#4A584F] bg-[#F4F6F4] p-3 rounded-xl border border-[#E5ECE7]">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#3F6E52] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span>{{ $canteen->location }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#A68A68] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Jam Operasional: {{ $canteen->hours }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5 pt-0">
                    <a href="{{ route('buyer.canteens.show', $canteen->id) }}" class="flex items-center justify-center w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold shadow-xs transition active:scale-98">
                        <span>Lihat Menu Warung</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-dashed border-[#C8D6CD] p-12 text-center">
                <svg class="w-12 h-12 text-[#76847B] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <p class="font-display font-bold text-[#1A241E]">Tidak ada warung kantin ditemukan</p>
                <p class="text-xs text-[#76847B] mt-1">Coba kata kunci pencarian yang lain.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
