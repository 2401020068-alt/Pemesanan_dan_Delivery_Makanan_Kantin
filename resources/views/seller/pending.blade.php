@extends('layouts.app')

@section('title', 'Menunggu Persetujuan Admin')

@section('content')
<div class="max-w-lg mx-auto flex flex-col items-center justify-center min-h-[60vh] text-center space-y-6">

    {{-- Icon --}}
    <div class="w-20 h-20 rounded-3xl bg-[#F6F3EF] border border-[#E9E2D8] flex items-center justify-center shadow-sm">
        <svg class="w-10 h-10 text-[#A68A68]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    {{-- Teks utama --}}
    <div class="space-y-2">
        <h1 class="font-display text-2xl font-bold text-white">Akun Sedang Diverifikasi</h1>
        <p class="text-sm text-emerald-200/80 leading-relaxed max-w-sm mx-auto">
            Halo, <span class="font-semibold text-white">{{ $seller->name ?? 'Penjual' }}</span>!
            Pendaftaran akun penjual Anda sedang menunggu persetujuan dari admin KantinKu.
        </p>
        <p class="text-xs text-emerald-300/60 max-w-sm mx-auto">
            Anda akan mendapatkan akses penuh ke dashboard setelah akun disetujui.
            Proses verifikasi biasanya membutuhkan waktu 1×24 jam.
        </p>
    </div>

    {{-- Status badge --}}
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#F6F3EF]/10 border border-[#A68A68]/30 text-[#D4B896] text-xs font-bold">
        <span class="w-2 h-2 rounded-full bg-[#A68A68] animate-pulse"></span>
        Status: Menunggu Persetujuan Admin
    </div>

    {{-- Info box --}}
    <div class="w-full bg-white/5 border border-white/10 rounded-2xl p-5 text-left space-y-3 text-sm">
        <p class="text-xs font-bold text-emerald-300 uppercase tracking-wider">Informasi Akun Anda</p>
        <div class="flex items-center justify-between border-b border-white/10 pb-2">
            <span class="text-emerald-200/60 text-xs">Nama</span>
            <span class="text-white font-semibold text-xs">{{ $seller->name ?? '-' }}</span>
        </div>
        <div class="flex items-center justify-between border-b border-white/10 pb-2">
            <span class="text-emerald-200/60 text-xs">Email</span>
            <span class="text-white font-semibold text-xs">{{ $seller->email ?? '-' }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="text-emerald-200/60 text-xs">Status Persetujuan</span>
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#F6F3EF]/20 text-[#D4B896] border border-[#A68A68]/30">
                {{ ucfirst($seller->approval ?? 'pending') }}
            </span>
        </div>
    </div>

    {{-- Tombol keluar --}}
    <a href="{{ route('logout') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 text-white text-xs font-semibold transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        Keluar dari Akun
    </a>

</div>
@endsection

