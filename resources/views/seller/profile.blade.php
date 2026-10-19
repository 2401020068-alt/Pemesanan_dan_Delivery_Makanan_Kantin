@extends('layouts.app')

@section('title', 'Profil Penjual')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-white">Profil Penjual</h1>
        <p class="text-xs sm:text-sm text-emerald-200/90 mt-1 font-medium">Kelola data profil pemilik warung kantin.</p>
    </div>

    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 sm:p-8 shadow-subtle space-y-6 text-[#1A241E]">
        <div class="flex items-center gap-4 pb-6 border-b border-[#E5ECE7]">
            <img src="{{ $seller->avatar ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=70' }}" class="w-16 h-16 rounded-2xl object-cover ring-4 ring-[#1F3E2C]/10 shadow-xs">
            <div>
                <h2 class="font-display font-bold text-lg text-[#1A241E]">{{ $seller->name }}</h2>
                <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-xs font-bold bg-[#F6F3EF] text-[#8E7252] border border-[#E5ECE7] mt-1">
                    Warung: {{ $shop->name ?? '-' }}
                </span>
            </div>
        </div>

        <form action="{{ route('seller.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Nama Pemilik Warung</label>
                <input type="text" name="name" value="{{ old('name', $seller->name) }}" required class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-4 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Alamat Email</label>
                <input type="email" value="{{ $seller->email }}" disabled class="w-full rounded-xl border border-[#E5ECE7] bg-slate-100/80 px-4 py-2.5 text-xs sm:text-sm text-slate-400 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Nomor WhatsApp / HP</label>
                <input type="text" name="phone" value="{{ old('phone', $seller->phone) }}" class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-4 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition-all">
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
