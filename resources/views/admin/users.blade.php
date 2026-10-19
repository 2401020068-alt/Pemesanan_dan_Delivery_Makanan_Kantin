@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h1 class="font-display text-2xl font-bold text-[#1A241E]">Manajemen Pengguna</h1>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#E3ECE6] text-[#1F3E2C] border border-[#BFD4C7]/50">
                    {{ $roleCounts['all'] ?? $users->total() }} Akun
                </span>
            </div>
            <p class="text-xs sm:text-sm text-[#76847B] mt-1">Daftar semua pengguna terdaftar: pembeli, penjual, driver, dan administrator sistem.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" onclick="openCreateUserModal()" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#1F3E2C] to-[#2D553D] hover:from-[#173022] hover:to-[#1F3E2C] px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-[#1F3E2C]/20 transition-all duration-200 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Admin</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-[#E5ECE7] shadow-xs">
        <!-- Role Filter Pills with Counts -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
            <a href="{{ route('admin.users', ['role' => 'all', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 {{ $role === 'all' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
                <span>Semua</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $role === 'all' ? 'bg-white/20 text-white' : 'bg-[#E5ECE7] text-[#4A584F]' }}">{{ $roleCounts['all'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.users', ['role' => 'admin', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 {{ $role === 'admin' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
                <span>Admin</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $role === 'admin' ? 'bg-white/20 text-white' : 'bg-purple-100 text-purple-700' }}">{{ $roleCounts['admin'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.users', ['role' => 'seller', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 {{ $role === 'seller' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
                <span>Penjual</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $role === 'seller' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-700' }}">{{ $roleCounts['seller'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.users', ['role' => 'buyer', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 {{ $role === 'buyer' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
                <span>Pembeli</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $role === 'buyer' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700' }}">{{ $roleCounts['buyer'] ?? 0 }}</span>
            </a>
            <a href="{{ route('admin.users', ['role' => 'driver', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shrink-0 {{ $role === 'driver' ? 'bg-[#1F3E2C] text-white shadow-subtle' : 'text-[#4A584F] hover:bg-[#F1F5F2]' }}">
                <span>Driver</span>
                <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $role === 'driver' ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700' }}">{{ $roleCounts['driver'] ?? 0 }}</span>
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.users') }}" method="GET" class="flex items-center gap-2 w-full md:max-w-xs">
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-[#76847B] absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama atau email..." class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] text-xs pl-9 pr-3 py-2 text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
            </div>
            <button type="submit" class="rounded-xl bg-[#1F3E2C] px-3.5 py-2 text-xs font-bold text-white hover:bg-[#2D553D] transition shrink-0">
                Cari
            </button>
            @if($search)
                <a href="{{ route('admin.users', ['role' => $role]) }}" class="rounded-xl bg-[#F4F6F4] hover:bg-[#E5ECE7] p-2 text-[#76847B] transition shrink-0" title="Hapus Pencarian">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#4A584F]">
                <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider border-b border-[#E5ECE7]">
                    <tr>
                        <th class="px-5 py-3.5">Nama &amp; ID</th>
                        <th class="px-5 py-3.5">Email</th>
                        <th class="px-5 py-3.5">No. HP</th>
                        <th class="px-5 py-3.5">Peran</th>
                        <th class="px-5 py-3.5">Status Akun</th>
                        <th class="px-5 py-3.5 text-right">Aksi Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5ECE7]">
                    @forelse($users as $usr)
                        @php
                            $isCurrentAdmin = ($admin && $admin->id === $usr->id);
                        @endphp
                        <tr class="hover:bg-[#FAFBF9] transition">
                            <td class="px-5 py-3.5 flex items-center gap-3">
                                <img src="{{ $usr->avatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&q=70' }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-[#BFD4C7]/30 shrink-0">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="font-bold text-[#1A241E] text-xs truncate">{{ $usr->name }}</span>
                                        @if($isCurrentAdmin)
                                            <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-purple-100 text-purple-700 border border-purple-200">Anda</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-[#76847B] font-mono">{{ $usr->id }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-[#4A584F] font-medium">{{ $usr->email }}</td>
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
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Edit Button -->
                                    <button type="button" 
                                            onclick='openEditUserModal(@json($usr))' 
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold border border-slate-200 bg-white hover:bg-slate-50 text-[#1F3E2C] transition active:scale-95 shadow-2xs"
                                            title="Edit Data Pengguna">
                                        <svg class="w-3.5 h-3.5 text-[#1F3E2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Status Toggle Button -->
                                    @if(!$isCurrentAdmin)
                                        <form action="{{ route('admin.users.status', $usr->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold border transition active:scale-95 {{ $usr->status === 'active' ? 'border-amber-200 text-amber-700 bg-amber-50 hover:bg-amber-100' : 'border-emerald-200 text-emerald-800 bg-emerald-50 hover:bg-emerald-100' }}"
                                                    title="{{ $usr->status === 'active' ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                                @if($usr->status === 'active')
                                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                    <span>Nonaktifkan</span>
                                                @else
                                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span>Aktifkan</span>
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1.5 rounded-xl text-[10px] font-semibold text-slate-400 bg-slate-50 border border-slate-200 cursor-not-allowed" title="Anda tidak dapat mengubah status akun sendiri">
                                            Terkunci
                                        </span>
                                    @endif

                                    <!-- Delete Button -->
                                    @if(!$isCurrentAdmin)
                                        <form action="{{ route('admin.users.delete', $usr->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $usr->name }} ({{ $usr->email }})? Data terkait seperti warung juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold border border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 transition active:scale-95"
                                                    title="Hapus Akun Pengguna">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>Hapus</span>
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

<!-- Modal Tambah Admin Baru -->
<div id="createUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop overlay -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeCreateUserModal()"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#E5ECE7]">
            <div class="bg-gradient-to-r from-[#173022] to-[#1F3E2C] px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-display text-base font-bold text-white" id="modal-title">Tambah Administrator Baru</h3>
                        <p class="text-[11px] text-emerald-200/80">Daftarkan akun administrator baru untuk mengelola sistem KantinKu.</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateUserModal()" class="rounded-xl p-1.5 text-white/70 hover:text-white hover:bg-white/10 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="role" value="admin">

                <div>
                    <label class="block text-xs font-bold text-[#1A241E] mb-1">Nama Lengkap Admin <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Rina Kartika" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1A241E] mb-1">Alamat Email Kampus / Resmi <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" required placeholder="Contoh: admin.baru@kantinku.ac.id" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" placeholder="Contoh: 0812-3456-7890" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Peran Akses</label>
                        <div class="flex items-center gap-2 px-3.5 py-2.5 bg-purple-50 border border-purple-200/70 rounded-xl text-purple-900 text-xs font-bold">
                            <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                            <span>Admin (Hak Akses Penuh)</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Kata Sandi <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="createPasswordInput" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] pl-3.5 pr-9 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                            <button type="button" onclick="togglePasswordVisibility('createPasswordInput', 'createEyeIcon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg id="createEyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Status Akun</label>
                        <select name="status" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                            <option value="active" selected>Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="p-3 bg-purple-50/70 border border-purple-200/60 rounded-2xl flex items-start gap-2.5 text-[11px] text-purple-900">
                    <svg class="w-4 h-4 text-purple-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Akun Administrator baru dapat langsung login menggunakan email &amp; sandi di atas dengan wewenang mengelola seluruh data KantinKu.</span>
                </div>

                <div class="pt-3 border-t border-[#E5ECE7] flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeCreateUserModal()" class="rounded-xl px-4 py-2 text-xs font-bold text-[#76847B] hover:bg-[#F1F5F2] hover:text-[#1A241E] transition">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-[#1F3E2C]/20 transition active:scale-95">
                        Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div id="editUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-edit-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeEditUserModal()"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#E5ECE7]">
            <div class="bg-gradient-to-r from-[#173022] to-[#1F3E2C] px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-display text-base font-bold text-white" id="modal-edit-title">Edit Data Pengguna</h3>
                        <p class="text-[11px] text-emerald-200/80">Perbarui informasi profil, peran, atau kata sandi akun.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditUserModal()" class="rounded-xl p-1.5 text-white/70 hover:text-white hover:bg-white/10 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="editUserForm" action="" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-[#1A241E] mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="editName" name="name" required class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1A241E] mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" id="editEmail" name="email" required class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Nomor WhatsApp / HP</label>
                        <input type="text" id="editPhone" name="phone" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Peran (Role) <span class="text-rose-500">*</span></label>
                        <select id="editRole" name="role" required class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                            <option value="admin">Admin (Pengelola Sistem)</option>
                            <option value="buyer">Pembeli (Mahasiswa / Staf)</option>
                            <option value="seller">Penjual (Pemilik Warung)</option>
                            <option value="driver">Driver (Kurir Pengantar)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Kata Sandi Baru <span class="text-[#76847B] font-normal">(Opsional)</span></label>
                        <div class="relative">
                            <input type="password" id="editPasswordInput" name="password" minlength="6" placeholder="Kosongkan jika tidak diganti" class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] pl-3.5 pr-9 py-2.5 text-xs text-[#1A241E] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                            <button type="button" onclick="togglePasswordVisibility('editPasswordInput', 'editEyeIcon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg id="editEyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1">Status Akun <span class="text-rose-500">*</span></label>
                        <select id="editStatus" name="status" required class="w-full rounded-xl bg-[#FAFBF9] border border-[#E5ECE7] px-3.5 py-2.5 text-xs text-[#1A241E] font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]">
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 border-t border-[#E5ECE7] flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeEditUserModal()" class="rounded-xl px-4 py-2 text-xs font-bold text-[#76847B] hover:bg-[#F1F5F2] hover:text-[#1A241E] transition">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-[#1F3E2C]/20 transition active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditUserModal(user) {
        document.getElementById('editName').value = user.name || '';
        document.getElementById('editEmail').value = user.email || '';
        document.getElementById('editPhone').value = user.phone || '';
        document.getElementById('editRole').value = user.role || 'buyer';
        document.getElementById('editStatus').value = user.status || 'active';
        document.getElementById('editPasswordInput').value = '';

        const form = document.getElementById('editUserForm');
        form.action = `/admin/users/${user.id}`;

        document.getElementById('editUserModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeCreateUserModal();
            closeEditUserModal();
        }
    });
</script>
@endsection
