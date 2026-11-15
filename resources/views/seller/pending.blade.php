@extends('layouts.app')

@section('title', ($seller->approval ?? 'pending') === 'rejected' ? 'Pendaftaran Akun Ditolak' : 'Menunggu Persetujuan Admin')

@section('content')
<div class="max-w-lg mx-auto flex flex-col items-center justify-center min-h-[60vh] py-8">
    <div class="w-full bg-white border border-[#E5ECE7] rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col items-center text-center space-y-6">

        @if(($seller->approval ?? 'pending') === 'rejected')
            {{-- Icon Rejected --}}
            <div class="w-20 h-20 rounded-3xl bg-red-50 border border-red-200 flex items-center justify-center shadow-xs">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            {{-- Teks utama Rejected --}}
            <div class="space-y-2">
                <h1 class="font-display text-2xl font-bold text-[#1A241E]">Pendaftaran Akun Ditolak</h1>
                <p class="text-sm text-[#4A584F] leading-relaxed max-w-sm mx-auto">
                    Halo, <span class="font-semibold text-[#1A241E]">{{ $seller->name ?? 'Penjual' }}</span>.
                    Mohon maaf, permohonan pendaftaran akun penjual Anda belum disetujui oleh Administrator KantinKu.
                </p>
                <p class="text-xs text-[#76847B] max-w-sm mx-auto">
                    Silakan hubungi pengelola kantin atau administrator kampus di Gedung Rektorat jika terdapat kesalahan data.
                </p>
            </div>

            {{-- Status badge Rejected --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                Status: Pendaftaran Ditolak
            </div>
        @else
            {{-- Icon Pending --}}
            <div class="w-20 h-20 rounded-3xl bg-[#F6F3EF] border border-[#E9E2D8] flex items-center justify-center shadow-xs">
                <svg class="w-10 h-10 text-[#A68A68]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            {{-- Teks utama Pending --}}
            <div class="space-y-2">
                <h1 class="font-display text-2xl font-bold text-[#1A241E]">Akun Sedang Diverifikasi</h1>
                <p class="text-sm text-[#4A584F] leading-relaxed max-w-sm mx-auto">
                    Halo, <span class="font-semibold text-[#1A241E]">{{ $seller->name ?? 'Penjual' }}</span>!
                    Pendaftaran akun penjual Anda sedang menunggu persetujuan dari admin KantinKu.
                </p>
                <p class="text-xs text-[#76847B] max-w-sm mx-auto">
                    Anda akan mendapatkan akses penuh ke dashboard toko setelah akun disetujui.
                    Proses verifikasi biasanya membutuhkan waktu 1×24 jam.
                </p>
            </div>

            {{-- Status badge Pending --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                Status: Menunggu Persetujuan Admin
            </div>
        @endif

        {{-- Info box --}}
        <div class="w-full bg-[#FAFBF9] border border-[#E5ECE7] rounded-2xl p-5 text-left space-y-3 text-xs">
            <p class="text-[11px] font-bold text-[#2D553D] uppercase tracking-wider">Informasi Akun Anda</p>
            <div class="flex items-center justify-between border-b border-[#E5ECE7] pb-2">
                <span class="text-[#76847B]">Nama Pemilik</span>
                <span class="text-[#1A241E] font-semibold">{{ $seller->name ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-[#E5ECE7] pb-2">
                <span class="text-[#76847B]">Email Terdaftar</span>
                <span class="text-[#1A241E] font-semibold">{{ $seller->email ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-[#E5ECE7] pb-2">
                <span class="text-[#76847B]">Nomor Telepon</span>
                <span class="text-[#1A241E] font-semibold">{{ $seller->phone ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-[#76847B]">Status Persetujuan</span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ ($seller->approval ?? 'pending') === 'rejected' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                    {{ ucfirst($seller->approval ?? 'pending') }}
                </span>
            </div>
        </div>

        {{-- Tombol keluar --}}
        <a href="{{ route('logout') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#FDF3F3] hover:bg-[#FBE8E8] border border-[#F3C5C5] text-[#C25454] text-xs font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Keluar dari Akun
        </a>

    </div>
</div>
@endsection
