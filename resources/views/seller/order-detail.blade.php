@extends('layouts.app')

@section('title', 'Kelola Pesanan ' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Kelola Pesanan {{ $order->id }}</h1>
            <p class="text-xs text-[#76847B] mt-1">Pembeli: {{ $order->buyer->name ?? 'Mahasiswa' }} &bull; Waktu: {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
        </div>
        <a href="{{ route('seller.orders') }}" class="text-xs font-semibold text-[#1F3E2C] hover:underline">Kembali</a>
    </div>

    <!-- Status Action Bar -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
        <h2 class="font-display font-bold text-[#1A241E] text-sm">Perbarui Status Operasional Dapur</h2>

        <form action="{{ route('seller.orders.status', $order->id) }}" method="POST" class="flex flex-wrap items-center gap-2.5">
            @csrf
            <button type="submit" name="status" value="processing" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition border {{ $order->status === 'processing' ? 'bg-[#2D553D] text-white border-[#2D553D] shadow-xs ring-2 ring-[#2D553D]/30' : 'bg-[#F1F5F2] text-[#2D553D] border-[#BFD4C7] hover:bg-[#E3ECE6]' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                <span>Sedang Dimasak</span>
            </button>
            <button type="submit" name="status" value="ready" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition border {{ $order->status === 'ready' ? 'bg-[#A68A68] text-white border-[#A68A68] shadow-xs ring-2 ring-[#A68A68]/30' : 'bg-[#F6F3EF] text-[#8E7252] border-[#E5ECE7] hover:bg-[#EFE9DF]' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                <span>Siap Diambil Driver</span>
            </button>
            <button type="submit" name="status" value="done" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition border {{ $order->status === 'done' ? 'bg-[#1F3E2C] text-white border-[#1F3E2C] shadow-xs ring-2 ring-[#1F3E2C]/30' : 'bg-[#E3ECE6] text-[#1F3E2C] border-[#BFD4C7] hover:bg-[#BFD4C7]' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Tandai Selesai</span>
            </button>
            <button type="submit" name="status" value="cancelled" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition border {{ $order->status === 'cancelled' ? 'bg-[#C25454] text-white border-[#C25454]' : 'bg-[#FDF3F3] text-[#C25454] border-[#F3C5C5] hover:bg-[#FBE8E8]' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <span>Batalkan</span>
            </button>
        </form>
    </div>

    <!-- Items List Card -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
        <h2 class="font-display font-bold text-[#1A241E] text-base">Rincian Menu Masakan</h2>

        <div class="divide-y divide-[#E5ECE7]">
            @foreach($order->items as $item)
                <div class="py-3 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-3">
                        <img src="{{ $item->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=100&q=70' }}" class="w-10 h-10 rounded-xl object-cover bg-[#F4F6F4]">
                        <div>
                            <span class="font-bold text-[#1A241E] block text-sm">{{ $item->name }}</span>
                            <span class="text-[#76847B]">{{ $item->qty }} porsi @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <span class="font-bold text-[#1A241E]">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div class="pt-4 border-t border-[#E5ECE7] space-y-2 text-xs text-[#4A584F]">
            <div class="flex justify-between">
                <span>Subtotal Makanan</span>
                <span class="font-bold text-[#1A241E]">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Alamat Pengantaran</span>
                <span class="font-semibold text-[#1A241E]">{{ $order->address }}</span>
            </div>
            @if($order->note)
                <div class="flex justify-between">
                    <span>Catatan Khusus</span>
                    <span class="font-semibold text-[#8E7252] italic">{{ $order->note }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
