@extends('layouts.app')

@section('title', 'Persetujuan Warung')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Persetujuan Warung Kantin</h1>
        <p class="text-xs sm:text-sm text-[#76847B] mt-1">Verifikasi kelayakan warung, lokasi blok, dan jam buka sebelum ditampilkan di katalog kantin.</p>
    </div>

    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Nama Warung</th>
                        <th class="px-5 py-3.5">Pemilik</th>
                        <th class="px-5 py-3.5">Lokasi &amp; Jam</th>
                        <th class="px-5 py-3.5">Status Buka</th>
                        <th class="px-5 py-3.5">Persetujuan</th>
                        <th class="px-5 py-3.5 text-right">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($shops as $sh)
                        <tr class="hover:bg-[#FAFBF9] transition">
                            <td class="px-5 py-3.5 flex items-center gap-3">
                                <img src="{{ $sh->image ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=100&q=70' }}" class="w-10 h-10 rounded-xl object-cover bg-[#F4F6F4]">
                                <div>
                                    <span class="font-bold text-[#1A241E] block text-xs">{{ $sh->name }}</span>
                                    <span class="text-[10px] text-[#76847B] font-mono">{{ $sh->id }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-[#1A241E]">{{ $sh->owner->name ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="font-medium text-[#1A241E] block">{{ $sh->location ?? '-' }}</span>
                                <span class="text-[10px] text-[#76847B]">{{ $sh->hours ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sh->open ? 'bg-[#E3ECE6] text-[#1F3E2C] border-[#BFD4C7]' : 'bg-[#F4F6F4] text-[#76847B] border-[#E5ECE7]' }}">
                                    {{ $sh->open ? 'Buka' : 'Tutup' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sh->approval === 'approved' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($sh->approval === 'pending' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200') }}">
                                    @if($sh->approval === 'approved')
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Disetujui</span>
                                    @elseif($sh->approval === 'pending')
                                        <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>Menunggu</span>
                                    @else
                                        <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        <span>Ditolak</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($sh->approval !== 'approved')
                                        <form action="{{ route('admin.shops.approve', $sh->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition active:scale-95">
                                                <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($sh->approval !== 'rejected')
                                        <form action="{{ route('admin.shops.approve', $sh->id) }}" method="POST" onsubmit="return confirm('Tolak persetujuan warung ini?')">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs border border-rose-200 transition active:scale-95">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-[#76847B]">
                                <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <p class="font-bold text-[#1A241E] text-sm">Tidak Ada Warung Terdaftar</p>
                                <p class="text-xs text-[#76847B] mt-0.5">Daftar warung kantin yang mendaftar akan tampil di tabel ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
