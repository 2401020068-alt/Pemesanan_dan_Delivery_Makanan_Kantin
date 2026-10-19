@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-[#1A241E]">Manajemen Pengguna</h1>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Daftar semua pengguna terdaftar: pembeli, penjual, driver, dan administrator sistem.</p>
        </div>

        <form action="{{ route('admin.users') }}" method="GET" class="flex gap-2 max-w-sm w-full">
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-[#76847B] absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama atau email..." class="w-full rounded-xl bg-white border border-[#E5ECE7] text-xs pl-10 pr-4 py-2.5 shadow-sm text-[#1A241E] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
            </div>
            <button type="submit" class="rounded-xl bg-[#1F3E2C] px-4 py-2 text-xs font-bold text-white hover:bg-[#2D553D] transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Role Filter Pills -->
    <div class="flex items-center gap-2 border-b border-[#E5ECE7] pb-2 overflow-x-auto scrollbar-none">
        <a href="{{ route('admin.users', ['role' => 'all', 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $role === 'all' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Semua Peran</a>
        <a href="{{ route('admin.users', ['role' => 'buyer', 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $role === 'buyer' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Pembeli</a>
        <a href="{{ route('admin.users', ['role' => 'seller', 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $role === 'seller' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Penjual</a>
        <a href="{{ route('admin.users', ['role' => 'driver', 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $role === 'driver' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Driver</a>
        <a href="{{ route('admin.users', ['role' => 'admin', 'q' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $role === 'admin' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">Admin</a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5">Nama &amp; ID</th>
                        <th class="px-5 py-3.5">Email</th>
                        <th class="px-5 py-3.5">No. HP</th>
                        <th class="px-5 py-3.5">Peran</th>
                        <th class="px-5 py-3.5">Status Akun</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($users as $usr)
                        <tr class="hover:bg-[#FAFBF9] transition">
                            <td class="px-5 py-3.5 flex items-center gap-3">
                                <img src="{{ $usr->avatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=70' }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-[#BFD4C7]/20">
                                <div>
                                    <span class="font-bold text-[#1A241E] block text-xs">{{ $usr->name }}</span>
                                    <span class="text-[10px] text-[#76847B] font-mono">{{ $usr->id }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-[#4A584F]">{{ $usr->email }}</td>
                            <td class="px-5 py-3.5 font-mono text-[#4A584F]">{{ $usr->phone ?? '-' }}</td>
                            <td class="px-5 py-3.5">
                                @php
                                    $roleBadges = [
                                        'buyer' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                        'seller' => 'bg-amber-50 text-amber-800 border-amber-200',
                                        'driver' => 'bg-indigo-50 text-indigo-800 border-indigo-200',
                                        'admin' => 'bg-purple-50 text-purple-800 border-purple-200',
                                    ];
                                    $rCol = $roleBadges[$usr->role] ?? 'bg-[#F4F6F4] text-[#1A241E] border-[#E5ECE7]';
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $rCol }}">
                                    {{ $usr->role }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $usr->status === 'active' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-rose-50 text-rose-800 border-rose-200' }}">
                                    @if($usr->status === 'active')
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Aktif</span>
                                    @else
                                        <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        <span>Nonaktif</span>
                                    @endif
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <form action="{{ route('admin.users.status', $usr->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold border transition active:scale-95 {{ $usr->status === 'active' ? 'border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100' : 'border-emerald-200 text-emerald-800 bg-emerald-50 hover:bg-emerald-100' }}">
                                        @if($usr->status === 'active')
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            <span>Nonaktifkan</span>
                                        @else
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span>Aktifkan</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-[#76847B]">
                                <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <p class="font-bold text-[#1A241E] text-sm">Tidak Ada Pengguna Ditemukan</p>
                                <p class="text-xs text-[#76847B] mt-0.5">Coba kata kunci lain atau pilih tab filter peran yang berbeda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $users->links() }}
    </div>
</div>
@endsection
