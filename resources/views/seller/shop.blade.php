@extends('layouts.app')

@section('title', 'Kelola Warung & Menu')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Kelola Warung &amp; Menu Makanan</h1>
        <p class="text-xs sm:text-sm text-[#76847B] mt-1">Atur profil warung kantin dan daftar menu yang tersedia untuk dipesan pembeli.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Shop Info Form -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
            <h2 class="font-display font-bold text-[#1A241E] text-base">Profil Warung Kantin</h2>

            <form action="{{ route('seller.shop.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-[#1A241E] mb-1">Nama Warung *</label>
                    <input type="text" name="name" value="{{ old('name', $shop->name) }}" required class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#1A241E] mb-1">Lokasi di Kampus</label>
                    <input type="text" name="location" value="{{ old('location', $shop->location) }}" placeholder="Kantin Utama, Blok A-02" class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#1A241E] mb-1">Jam Operasional</label>
                    <input type="text" name="hours" value="{{ old('hours', $shop->hours) }}" placeholder="07.00 - 16.00" class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#1A241E] mb-1">Deskripsi Warung</label>
                    <textarea name="description" rows="2" class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">{{ old('description', $shop->description) }}</textarea>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="open" value="1" {{ $shop->open ? 'checked' : '' }} class="rounded text-[#1F3E2C] focus:ring-[#1F3E2C] w-4 h-4">
                        <span class="text-xs font-bold text-[#1A241E]">Buka Warung Sekarang (Menerima Pesanan)</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition">
                    Simpan Informasi Warung
                </button>
            </form>
        </div>

        <!-- Menu Items Management Table -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Add New Menu Box -->
            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-4">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </span>
                    <h2 class="font-display font-bold text-[#1A241E] text-base">Tambah Menu Makanan Baru</h2>
                </div>

                <form action="{{ route('seller.menu.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-3 sm:grid-cols-2">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-semibold text-[#1A241E] mb-1">Nama Menu *</label>
                        <input type="text" name="name" required placeholder="Contoh: Nasi Goreng Spesial" class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-[#1A241E] mb-1">Kategori *</label>
                        <select name="category" required class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Camilan">Camilan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-[#1A241E] mb-1">Harga (Rp) *</label>
                        <input type="number" name="price" required placeholder="15000" class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-[#1A241E] mb-1">Deskripsi Singkat</label>
                        <input type="text" name="description" placeholder="Komposisi &amp; kelezatan..." class="w-full rounded-xl border border-[#E5ECE7] px-3 py-2 text-xs text-[#1A241E] focus:border-[#1F3E2C] focus:outline-none">
                    </div>

                    <div class="sm:col-span-2 flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-[#4A584F]">
                            <input type="checkbox" name="available" value="1" checked class="rounded text-[#1F3E2C] w-4 h-4">
                            <span>Tersedia untuk Dipesan</span>
                        </label>

                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition active:scale-95">
                            <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            <span>Simpan Menu Baru</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- List Menu Table -->
            <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
                <div class="p-5 border-b border-[#E5ECE7] flex items-center justify-between">
                    <h2 class="font-display font-bold text-base text-[#1A241E]">Daftar Menu Warung ({{ $menuItems->count() }})</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-[#4A584F]">
                        <thead class="bg-[#F4F6F4] uppercase text-[10px] font-bold text-[#76847B] tracking-wider">
                            <tr>
                                <th class="px-5 py-3">Menu</th>
                                <th class="px-5 py-3">Kategori</th>
                                <th class="px-5 py-3">Harga</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E5ECE7]">
                            @forelse($menuItems as $m)
                                <tr class="hover:bg-[#FAFBF9] transition">
                                    <td class="px-5 py-3 flex items-center gap-3">
                                        <img src="{{ $m->image ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=100&q=70' }}" class="w-10 h-10 rounded-xl object-cover bg-[#F4F6F4]">
                                        <div>
                                            <span class="font-bold text-[#1A241E] block">{{ $m->name }}</span>
                                            <span class="text-[10px] text-[#76847B] line-clamp-1">{{ $m->description }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 font-medium text-[#4A584F]">{{ $m->category }}</td>
                                    <td class="px-5 py-3 font-bold text-[#1A241E]">Rp {{ number_format($m->price, 0, ',', '.') }}</td>
                                    <td class="px-5 py-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $m->available ? 'bg-[#E3ECE6] text-[#1F3E2C] border border-[#BFD4C7]' : 'bg-[#F4F6F4] text-[#76847B] border border-[#E5ECE7]' }}">
                                            {{ $m->available ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <form action="{{ route('seller.menu.delete', $m->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus menu {{ $m->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-rose-700 bg-rose-50 hover:bg-rose-100 font-bold text-xs border border-rose-200 transition active:scale-95">
                                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center text-[#76847B]">
                                        <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <p class="font-bold text-[#1A241E] text-sm">Belum Ada Menu yang Dibuat</p>
                                        <p class="text-xs text-[#76847B] mt-0.5">Tambahkan menu pertama warung Anda pada form di atas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
