@extends('layouts.app')

@section('title', 'Tugas Pengantaran Driver')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Tugas Pengantaran Kantin</h1>
        <p class="text-xs sm:text-sm text-[#76847B] mt-1">Pilih tugas baru atau perbarui status pesanan yang sedang Anda bawa.</p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-[#E5ECE7] pb-2 overflow-x-auto scrollbar-none">
        <a href="{{ route('driver.deliveries', ['tab' => 'ongoing']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'ongoing' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Sedang Diantar ({{ $ongoing->count() }})
        </a>
        <a href="{{ route('driver.deliveries', ['tab' => 'available']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'available' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Tersedia Diambil ({{ $available->count() }})
        </a>
        <a href="{{ route('driver.deliveries', ['tab' => 'done']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $tab === 'done' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
            Riwayat Selesai ({{ $done->count() }})
        </a>
    </div>

    @if($tab === 'ongoing')
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($ongoing as $ord)
                <div class="bg-white rounded-3xl border border-[#BFD4C7] p-5 shadow-subtle space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-[#E5ECE7] text-xs">
                        <span class="font-mono font-bold text-[#1A241E]">{{ $ord->id }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $ord->delivery_status === 'picked' ? 'bg-[#F6F3EF] text-[#A68A68] border border-[#E5ECE7]' : 'bg-[#E3ECE6] text-[#1F3E2C] border border-[#BFD4C7]' }}">
                            {{ $ord->delivery_status === 'picked' ? 'Sudah Diambil dari Warung' : 'Dalam Perjalanan' }}
                        </span>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-[10px] font-bold text-[#76847B] uppercase">Warung Asal</span>
                            <p class="font-bold text-[#1A241E]">{{ $ord->shop->name ?? 'Warung Kantin' }} ({{ $ord->shop->location ?? '' }})</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-[#76847B] uppercase">Tujuan Antar</span>
                            <p class="font-bold text-[#1F3E2C] text-sm">{{ $ord->address }}</p>
                            <p class="text-[#76847B] text-[11px]">Penerima: {{ $ord->buyer->name ?? 'Pembeli' }} &bull; {{ $ord->buyer->phone ?? '' }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-[#E5ECE7] space-y-2">
                        @if($ord->delivery_status === 'picked')
                            <form action="{{ route('driver.deliveries.status', $ord->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="delivery_status" value="onway">
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2 active:scale-98">
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                    <span>Mulai Berangkat Mengantar</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('driver.deliveries.status', $ord->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="delivery_status" value="done">
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-2 active:scale-98">
                                    <span>Pesanan Telah Diterima Pembeli (Selesai)</span>
                                    <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-dashed border-[#C8D6CD] p-12 text-center text-[#76847B]">
                    <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    </div>
                    <p class="font-bold text-[#1A241E] text-sm">Tidak Ada Pesanan Sedang Diantar</p>
                    <p class="text-xs text-[#76847B] mt-0.5">Ambil pesanan baru pada tab "Tersedia Diambil" untuk memulai pengantaran.</p>
                </div>
            @endforelse
        </div>
    @elseif($tab === 'available')
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($available as $ord)
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-subtle space-y-4 flex flex-col justify-between hover:border-[#1F3E2C] transition">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-[#E5ECE7] text-xs">
                            <span class="font-mono font-bold text-[#1A241E]">{{ $ord->id }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#F6F3EF] text-[#A68A68] border border-[#E5ECE7]">
                                Siap Diambil
                            </span>
                        </div>

                        <div class="space-y-2 text-xs mt-3">
                            <div>
                                <span class="text-[10px] font-bold text-[#76847B] uppercase">Warung Asal</span>
                                <p class="font-bold text-[#1A241E]">{{ $ord->shop->name ?? 'Warung' }}</p>
                                <p class="text-[11px] text-[#76847B]">{{ $ord->shop->location }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-[#76847B] uppercase">Tujuan Antar</span>
                                <p class="font-bold text-[#1A241E]">{{ $ord->address }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('driver.deliveries.take', $ord->id) }}" method="POST" class="pt-3 border-t border-[#E5ECE7]">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition active:scale-98 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span>Ambil Tugas Pengantaran</span>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-dashed border-[#C8D6CD] p-12 text-center text-[#76847B]">
                    <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <p class="font-bold text-[#1A241E] text-sm">Belum Ada Pesanan Siap Diambil</p>
                    <p class="text-xs text-[#76847B] mt-0.5">Tugas pengantaran baru akan muncul otomatis ketika warung selesai memasak pesanan.</p>
                </div>
            @endforelse
        </div>
    @else
        <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#4A584F]">
                    <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                        <tr>
                            <th class="px-5 py-3">ID Pesanan</th>
                            <th class="px-5 py-3">Waktu Selesai</th>
                            <th class="px-5 py-3">Warung Asal</th>
                            <th class="px-5 py-3">Tujuan Antar</th>
                            <th class="px-5 py-3">Pembeli</th>
                            <th class="px-5 py-3 text-right">Ongkir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5ECE7]">
                        @forelse($done as $ord)
                            <tr class="hover:bg-[#FAFBF9] transition">
                                <td class="px-5 py-3 font-mono font-bold text-[#1A241E]">{{ $ord->id }}</td>
                                <td class="px-5 py-3 text-[11px] text-[#76847B]">{{ $ord->updated_at->format('d/m/Y H:i') }}</td>
                                <td class="px-5 py-3 font-medium text-[#1A241E]">{{ $ord->shop->name ?? 'Warung' }}</td>
                                <td class="px-5 py-3 max-w-[200px] truncate">{{ $ord->address }}</td>
                                <td class="px-5 py-3 text-[#4A584F]">{{ $ord->buyer->name ?? 'Pembeli' }}</td>
                                <td class="px-5 py-3 font-bold text-[#1F3E2C] text-right">Rp {{ number_format($ord->delivery_fee, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-[#76847B]">
                                    <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    </div>
                                    <p class="font-bold text-[#1A241E] text-sm">Belum Ada Riwayat Pengantaran Selesai</p>
                                    <p class="text-xs text-[#76847B] mt-0.5">Daftar pesanan yang berhasil Anda antarkan akan tercatat di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
