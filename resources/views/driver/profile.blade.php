@extends('layouts.app')

@section('title', 'Profil Driver')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white drop-shadow-md">Profil Driver</h1>
        <p class="text-xs sm:text-sm text-emerald-200/80 mt-1 font-medium">Kelola data identitas akun kurir pengantar kantin kampus.</p>
    </div>

    <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-emerald-100/60 p-6 sm:p-8 shadow-2xl shadow-black/30 space-y-6 text-slate-800">
        <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
            <img src="{{ $driver->avatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=70' }}" class="w-16 h-16 rounded-2xl object-cover ring-4 ring-emerald-500/25 shadow-sm">
            <div>
                <h2 class="font-display font-bold text-lg text-slate-900">{{ $driver->name }}</h2>
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 capitalize mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    Driver Kantin Aktif
                </span>
            </div>
        </div>

        <form action="{{ route('driver.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Driver</label>
                <input type="text" name="name" value="{{ old('name', $driver->name) }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-2.5 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Driver</label>
                <input type="email" value="{{ $driver->email }}" disabled class="w-full rounded-xl border border-slate-200 bg-slate-100/80 px-4 py-2.5 text-xs sm:text-sm text-slate-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp Aktif</label>
                <input type="text" name="phone" value="{{ old('phone', $driver->phone) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-2.5 text-xs sm:text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
            </div>

            <div class="pt-2">
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white font-bold text-xs sm:text-sm shadow-lg shadow-emerald-700/25 transition active:scale-98">
                    <span>Simpan Perubahan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
