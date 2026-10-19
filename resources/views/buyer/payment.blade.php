@extends('layouts.app')

@section('title', 'Pembayaran ' . $order->id)

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="text-center">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#F6F3EF] text-[#A68A68] border border-[#E5ECE7] mb-2">
            Menunggu Pembayaran
        </span>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Selesaikan Pembayaran</h1>
        <p class="text-xs text-[#76847B] mt-1">ID Pesanan: <span class="font-semibold text-[#1A241E]">{{ $order->id }}</span> | {{ $order->shop->name ?? 'Warung Kantin' }}</p>
    </div>

    <!-- Amount Card with Deep Moss Card Gradient -->
    <div class="bg-gradient-to-br from-[#1F3E2C] to-[#2A533B] rounded-3xl p-6 text-white text-center shadow-subtle border border-[#2D553D]">
        <span class="text-xs font-medium text-[#BFD4C7] uppercase tracking-wider">Total yang Harus Dibayar</span>
        <div class="font-display text-3xl font-extrabold mt-1 text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        <div class="mt-2 text-xs text-[#BFD4C7]">Metode: {{ $order->payment_method }}</div>
    </div>

    <!-- Payment Instruction Box -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-5">
        @if($order->payment_method === 'QRIS')
            <div class="text-center space-y-3">
                <span class="text-xs font-semibold text-[#76847B] block">Pindai kode QRIS di bawah ini dengan aplikasi m-Banking atau E-Wallet apa saja</span>

                <!-- QRIS Visual Code Container -->
                <div class="inline-block p-4 bg-white border-2 border-[#E5ECE7] rounded-2xl shadow-inner mx-auto">
                    <svg class="w-48 h-48 mx-auto" viewBox="0 0 100 100" fill="none">
                        <rect width="100" height="100" fill="white"/>
                        <!-- Top-left position marker -->
                        <rect x="10" y="10" width="28" height="28" fill="#173022" rx="4"/>
                        <rect x="14" y="14" width="20" height="20" fill="white" rx="2"/>
                        <rect x="18" y="18" width="12" height="12" fill="#1F3E2C" rx="1"/>

                        <!-- Top-right position marker -->
                        <rect x="62" y="10" width="28" height="28" fill="#173022" rx="4"/>
                        <rect x="66" y="14" width="20" height="20" fill="white" rx="2"/>
                        <rect x="70" y="18" width="12" height="12" fill="#1F3E2C" rx="1"/>

                        <!-- Bottom-left position marker -->
                        <rect x="10" y="62" width="28" height="28" fill="#173022" rx="4"/>
                        <rect x="14" y="66" width="20" height="20" fill="white" rx="2"/>
                        <rect x="18" y="70" width="12" height="12" fill="#1F3E2C" rx="1"/>

                        <!-- Data matrix decorative modules -->
                        <rect x="44" y="12" width="8" height="8" fill="#173022"/>
                        <rect x="44" y="24" width="8" height="8" fill="#173022"/>
                        <rect x="44" y="36" width="8" height="8" fill="#2D553D"/>
                        <rect x="12" y="44" width="8" height="8" fill="#173022"/>
                        <rect x="24" y="44" width="8" height="8" fill="#173022"/>
                        <rect x="36" y="44" width="8" height="8" fill="#173022"/>
                        <rect x="48" y="48" width="12" height="12" fill="#173022"/>
                        <rect x="64" y="44" width="8" height="8" fill="#173022"/>
                        <rect x="76" y="44" width="8" height="8" fill="#2D553D"/>
                        <rect x="88" y="44" width="8" height="8" fill="#173022"/>
                        <rect x="44" y="64" width="8" height="8" fill="#173022"/>
                        <rect x="44" y="76" width="8" height="8" fill="#173022"/>
                        <rect x="64" y="64" width="8" height="8" fill="#2D553D"/>
                        <rect x="76" y="76" width="12" height="12" fill="#173022"/>
                    </svg>
                    <div class="mt-2 text-[10px] font-bold text-[#76847B] uppercase tracking-widest">KantinKu - {{ $order->shop->name }}</div>
                </div>

                <p class="text-[11px] text-[#76847B]">NMID: ID102938475892 | Mendukung GoPay, OVO, Dana, ShopeePay, BCA Mobile, Livin, BRImo</p>
            </div>
        @else
            <div class="space-y-3 bg-[#F4F6F4] p-4 rounded-2xl border border-[#E5ECE7] text-xs">
                <span class="font-bold text-[#1A241E] block">Informasi Transfer:</span>
                <div class="flex justify-between items-center py-1 border-b border-[#E5ECE7]">
                    <span class="text-[#76847B]">Bank / Channel</span>
                    <span class="font-bold text-[#1A241E]">Bank Mandiri / BCA</span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-[#E5ECE7]">
                    <span class="text-[#76847B]">Nomor Rekening / VA</span>
                    <span class="font-mono font-bold text-[#1F3E2C] text-sm">8801-0812-2222-0002</span>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-[#76847B]">Atas Nama</span>
                    <span class="font-semibold text-[#1A241E]">{{ $order->shop->name ?? 'KantinKu Kampus' }}</span>
                </div>
            </div>
        @endif

        <!-- Upload Proof Form -->
        <form action="{{ route('buyer.payment.submit', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 pt-4 border-t border-[#E5ECE7]">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#1A241E] mb-1.5">Unggah Bukti Transfer / Tangkapan Layar Pembayaran</label>
                <div class="border-2 border-dashed border-[#C8D6CD] rounded-2xl p-5 text-center hover:border-[#1F3E2C] bg-[#FAFBF9] cursor-pointer">
                    <input type="file" name="proof" id="proofInput" accept="image/*" class="w-full text-xs text-[#76847B] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#E3ECE6] file:text-[#1F3E2C] hover:file:bg-[#BFD4C7]">
                    <p class="text-[11px] text-[#76847B] mt-2">Format: JPG, PNG, atau tangkapan layar ponsel. (Jika tidak diisi, bukti demo otomatis dilampirkan).</p>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-2xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-sm shadow-subtle transition">
                Konfirmasi &amp; Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection
