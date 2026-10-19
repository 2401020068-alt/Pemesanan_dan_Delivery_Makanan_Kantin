@extends('layouts.app')

@section('title', 'Persetujuan Penjual')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Persetujuan Akun Penjual</h1>
        <p class="text-xs sm:text-sm text-[#76847B] mt-1">Verifikasi pendaftaran akun penjual kantin sebelum dapat membuka warung di kampus.</p>
    </div>

    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Nama &amp; Kontak</th>
                        <th class="px-5 py-3.5">Email</th>
                        <th class="px-5 py-3.5">No. HP</th>
                        <th class="px-5 py-3.5">Status Akun</th>
                        <th class="px-5 py-3.5">Persetujuan</th>
                        <th class="px-5 py-3.5 text-right">Tindakan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($sellers as $sel)
                        <tr class="hover:bg-[#FAFBF9] transition">
                            <td class="px-5 py-3.5 flex items-center gap-3">
                                <img src="{{ $sel->avatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=70' }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-[#BFD4C7]/20">
                                <div>
                                    <span class="font-bold text-[#1A241E] block text-xs">{{ $sel->name }}</span>
                                    <span class="text-[10px] text-[#76847B] font-mono">{{ $sel->id }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-[#4A584F]">{{ $sel->email }}</td>
                            <td class="px-5 py-3.5 font-mono text-[#4A584F]">{{ $sel->phone ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sel->status === 'active' ? 'bg-[#E3ECE6] text-[#1F3E2C] border-[#BFD4C7]' : 'bg-[#F4F6F4] text-[#76847B] border-[#E5ECE7]' }}">
                                    {{ $sel->status }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sel->approval === 'approved' ? 'bg-[#E3ECE6] text-[#1F3E2C] border-[#BFD4C7]' : ($sel->approval === 'pending' ? 'bg-[#F6F3EF] text-[#A68A68] border-[#E5ECE7]' : 'bg-[#FDF3F3] text-[#C25454] border-[#F3C5C5]') }}">
                                    {{ ucfirst($sel->approval ?? 'pending') }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($sel->approval !== 'approved')
                                        <form action="{{ route('admin.sellers.approve', $sel->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs transition shadow-xs active:scale-98">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($sel->approval !== 'rejected')
                                        <form action="{{ route('admin.sellers.approve', $sel->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran penjual ini?')">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#FDF3F3] hover:bg-[#FBE8E8] text-[#C25454] font-bold text-xs border border-[#F3C5C5] transition active:scale-98">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-slate-700">Tidak Ada Data Penjual</p>
                                    <p class="text-[11px] text-slate-400">Pendaftaran akun penjual baru akan muncul di sini untuk diverifikasi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
