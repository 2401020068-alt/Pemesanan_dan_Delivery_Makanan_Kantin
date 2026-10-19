@extends('layouts.app')

@section('title', 'Dashboard Driver')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Dashboard Driver Kantin</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Siap mengantarkan pesanan makanan hangat dari kantin ke ruangan pembeli.</p>
        </div>

        <a href="{{ route('driver.deliveries') }}" class="px-4 py-2 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white text-xs font-bold shadow-xs transition">
            Lihat Semua Pengantaran
        </a>
    </div>

    <!-- Driver Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Pengantaran Aktif</span>
                <span class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1F3E2C]">{{ $activeCount }}</div>
            <p class="text-[11px] text-slate-500 mt-1">Perlu diantar ke pembeli</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Pesanan Selesai</span>
                <span class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-[#1A241E]">{{ $doneCount }}</div>
            <p class="text-[11px] text-emerald-700 mt-1 font-medium">Berhasil diantar</p>
        </div>

        <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between text-[#76847B] mb-3">
                <span class="text-xs font-bold text-slate-600">Siap Diambil</span>
                <span class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </span>
            </div>
            <div class="font-display text-2xl font-bold text-amber-800">{{ $availableOrders->count() }}</div>
            <p class="text-[11px] text-amber-700 mt-1 font-medium">Menunggu driver</p>
        </div>
    </div>

    <!-- Available Orders to Pick Up -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#1F3E2C] flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </span>
                <h2 class="font-display font-bold text-base text-[#1A241E]">Pesanan Siap Diantar dari Kantin</h2>
            </div>
            <span class="text-xs font-bold text-[#1F3E2C] bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">{{ $availableOrders->count() }} pesanan tersedia</span>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($availableOrders as $ord)
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-[#E5ECE7] text-xs">
                            <span class="font-mono font-bold text-[#1A241E]">{{ $ord->id }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                Siap Diambil
                            </span>
                        </div>

                        <div class="mt-3 space-y-3 text-xs">
                            <div class="flex items-start gap-2.5">
                                <span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <div>
                                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Ambil di Warung</span>
                                    <p class="font-bold text-[#1A241E]">{{ $ord->shop->name ?? 'Warung' }}</p>
                                    <p class="text-slate-500 text-[11px]">{{ $ord->shop->location ?? 'Kantin Utama' }}</p>
                                </div>
                            </div>

                            <div class="pt-2.5 border-t border-slate-100 flex items-start gap-2.5">
                                <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </span>
                                <div>
                                    <span class="text-slate-400 text-[10px] uppercase font-bold block">Antar ke Ruangan</span>
                                    <p class="font-bold text-[#1A241E]">{{ $ord->address }}</p>
                                    <p class="text-slate-500 text-[11px]">Penerima: {{ $ord->buyer->name ?? 'Pembeli' }} &bull; {{ $ord->buyer->phone ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('driver.deliveries.take', $ord->id) }}" method="POST" class="pt-2 border-t border-[#E5ECE7]">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition active:scale-98 flex items-center justify-center gap-2">
                            <span>Ambil Tugas Pengantaran</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-dashed border-[#C8D6CD] p-12 text-center text-xs text-[#76847B] shadow-sm">
                    <div class="max-w-xs mx-auto space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        <p class="text-xs font-semibold text-slate-700">Tidak Ada Pesanan Siap Antar</p>
                        <p class="text-[11px] text-slate-400">Warung sedang memasak pesanan. Pesanan yang siap diantar akan tampil di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
