@extends('layouts.app')

@section('title', 'Profil Kurir')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="text-center">
        <h1 class="font-display text-2xl font-bold text-white">Profil Kurir</h1>
        <p class="text-xs sm:text-sm text-emerald-200/90 mt-1 font-medium">Kelola data identitas akun kurir pengantar kantin kampus.</p>
    </div>

    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 sm:p-8 shadow-subtle space-y-6 text-[#1A241E]">
        {{-- Profile Header Badge (Centered) --}}
        <div class="flex flex-col items-center text-center pb-6 border-b border-[#E5ECE7]">
            <img src="{{ asset(ltrim($driver->avatar, '/')) }}" alt="{{ $driver->name }}" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-[#1F3E2C]/10 shadow-xs mb-3 bg-[#FAFBF9]">
            <h2 class="font-display font-bold text-xl text-[#1A241E]">{{ $driver->name }}</h2>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#E3ECE6] text-[#1F3E2C] border border-[#BFD4C7]/60 mt-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                Kurir Kantin Aktif
            </span>
        </div>

        <form action="{{ route('driver.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Nama Lengkap Kurir</label>
                <input type="text" name="name" value="{{ old('name', $driver->name) }}" required class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-4 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition-all">
                <span class="text-[11px] text-[#76847B] mt-1 block">Avatar otomatis menyesuaikan jenis kelamin (pria/wanita) berdasarkan nama jika belum memilih avatar khusus.</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Email Kurir</label>
                <input type="email" value="{{ $driver->email }}" disabled class="w-full rounded-xl border border-[#E5ECE7] bg-slate-100/80 px-4 py-2.5 text-xs sm:text-sm text-slate-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Nomor WhatsApp Aktif</label>
                <input type="text" name="phone" value="{{ old('phone', $driver->phone) }}" class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-4 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition-all">
            </div>

            {{-- Pilihan Preset Avatar Karakter Kartun --}}
            <div class="pt-2">
                <label class="block text-xs font-bold text-[#1A241E] mb-2">Pilih Karakter Avatar Kartun</label>
                
                {{-- Preset Wanita --}}
                <div class="mb-4">
                    <span class="text-[11px] font-semibold text-emerald-800 uppercase tracking-wider block mb-2">Pilihan Karakter Wanita</span>
                    <div class="grid grid-cols-4 gap-3">
                        @php
                            $females = [
                                '/images/avatars/female_1.png',
                                '/images/avatars/female_2.png',
                                '/images/avatars/female_3.png',
                                '/images/avatars/female_4.png',
                            ];
                        @endphp
                        @foreach($females as $f)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="avatar_preset" value="{{ $f }}" {{ ($driver->avatar === $f || str_ends_with($driver->avatar, $f)) ? 'checked' : '' }} class="peer sr-only">
                                <div class="w-full aspect-square rounded-2xl overflow-hidden bg-[#FAFBF9] border-2 border-[#E5ECE7] peer-checked:border-[#1F3E2C] peer-checked:ring-4 peer-checked:ring-[#1F3E2C]/20 transition-all group-hover:scale-105 shadow-xs">
                                    <img src="{{ asset(ltrim($f, '/')) }}" alt="Karakter Wanita" class="w-full h-full object-cover">
                                </div>
                                <span class="hidden peer-checked:flex absolute top-1 right-1 w-5 h-5 bg-[#1F3E2C] text-white rounded-full items-center justify-center text-[10px] font-bold shadow-xs">✓</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Preset Pria --}}
                <div>
                    <span class="text-[11px] font-semibold text-emerald-800 uppercase tracking-wider block mb-2">Pilihan Karakter Pria</span>
                    <div class="grid grid-cols-4 gap-3">
                        @php
                            $males = [
                                '/images/avatars/male_1.png',
                                '/images/avatars/male_2.png',
                                '/images/avatars/male_3.png',
                                '/images/avatars/male_4.png',
                            ];
                        @endphp
                        @foreach($males as $m)
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="avatar_preset" value="{{ $m }}" {{ ($driver->avatar === $m || str_ends_with($driver->avatar, $m)) ? 'checked' : '' }} class="peer sr-only">
                                <div class="w-full aspect-square rounded-2xl overflow-hidden bg-[#FAFBF9] border-2 border-[#E5ECE7] peer-checked:border-[#1F3E2C] peer-checked:ring-4 peer-checked:ring-[#1F3E2C]/20 transition-all group-hover:scale-105 shadow-xs">
                                    <img src="{{ asset(ltrim($m, '/')) }}" alt="Karakter Pria" class="w-full h-full object-cover">
                                </div>
                                <span class="hidden peer-checked:flex absolute top-1 right-1 w-5 h-5 bg-[#1F3E2C] text-white rounded-full items-center justify-center text-[10px] font-bold shadow-xs">✓</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Opsi Upload Foto Sendiri --}}
            <div class="pt-2">
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Atau Unggah Foto Profil Sendiri</label>
                <input type="file" name="avatar_file" accept="image/*" class="w-full text-xs text-[#76847B] file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#E3ECE6] file:text-[#1F3E2C] hover:file:bg-[#BFD4C7] file:cursor-pointer cursor-pointer border border-[#E5ECE7] rounded-xl bg-[#FAFBF9] p-2">
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
