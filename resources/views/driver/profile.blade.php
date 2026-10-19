@extends('layouts.app')

@section('title', 'Profil Kurir')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-white">Profil Kurir</h1>
        <p class="text-xs sm:text-sm text-emerald-200/90 mt-1 font-medium">Kelola data identitas akun kurir pengantar kantin kampus.</p>
    </div>

    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 sm:p-8 shadow-subtle space-y-6 text-[#1A241E]">
        <div class="flex items-center gap-4 pb-6 border-b border-[#E5ECE7]">
            <img src="{{ $driver->avatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=70' }}" class="w-16 h-16 rounded-2xl object-cover ring-4 ring-[#1F3E2C]/10 shadow-xs">
            <div>
                <h2 class="font-display font-bold text-lg text-[#1A241E]">{{ $driver->name }}</h2>
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-[#E3ECE6] text-[#1F3E2C] border border-[#BFD4C7]/60 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    Kurir Kantin Aktif
                </span>
            </div>
        </div>

        <form action="{{ route('driver.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Nama Lengkap Kurir</label>
                <input type="text" name="name" value="{{ old('name', $driver->name) }}" required class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-4 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Email Kurir</label>
                <input type="email" value="{{ $driver->email }}" disabled class="w-full rounded-xl border border-[#E5ECE7] bg-slate-100/80 px-4 py-2.5 text-xs sm:text-sm text-slate-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Nomor WhatsApp Aktif</label>
                <input type="text" name="phone" value="{{ old('phone', $driver->phone) }}" class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-4 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition-all">
            </div>

            <div class="pt-4 flex justify-center">
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs sm:text-sm shadow-subtle hover:shadow-md transition active:scale-98">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
