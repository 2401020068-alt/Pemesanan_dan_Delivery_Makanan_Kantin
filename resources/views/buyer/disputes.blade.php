@extends('layouts.app')

@section('title', 'Pusat Bantuan & Sengketa')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-12">
    <!-- Top Header & Context Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white rounded-3xl border border-[#E5ECE7] p-5 sm:p-6 shadow-subtle">
        <div class="flex items-center gap-3.5">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </span>
            <div>
                <h1 class="font-display text-xl sm:text-2xl font-bold text-[#1A241E]">Pusat Bantuan &amp; Sengketa</h1>
                <p class="text-xs sm:text-sm text-[#76847B] mt-0.5">Layanan bantuan dan mediasi resmi transaksi antara pembeli, kantin, dan kurir kampus.</p>
            </div>
        </div>

        <!-- Quick Summary Counters -->
        <div class="flex items-center gap-2 self-start sm:self-auto flex-wrap">
            <div class="bg-[#FAFBF9] border border-[#E5ECE7] rounded-2xl px-3.5 py-2 text-center min-w-[80px]">
                <span class="text-[10px] uppercase font-bold text-[#76847B] tracking-wider block">Total Laporan</span>
                <span class="font-display font-extrabold text-sm text-[#1A241E]">{{ $disputes->count() }}</span>
            </div>
            <div class="bg-[#FAFBF9] border border-[#E5ECE7] rounded-2xl px-3.5 py-2 text-center min-w-[80px]">
                <span class="text-[10px] uppercase font-bold text-[#8E7252] tracking-wider block">Dalam Proses</span>
                <span class="font-display font-extrabold text-sm text-[#8E7252]">{{ $disputes->whereIn('status', ['open', 'review'])->count() }}</span>
            </div>
            <div class="bg-[#FAFBF9] border border-[#E5ECE7] rounded-2xl px-3.5 py-2 text-center min-w-[80px]">
                <span class="text-[10px] uppercase font-bold text-[#1F3E2C] tracking-wider block">Selesai</span>
                <span class="font-display font-extrabold text-sm text-[#1F3E2C]">{{ $disputes->where('status', 'resolved')->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Guarantee Highlights Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
        <div class="bg-white rounded-2xl border border-[#E5ECE7] p-3.5 flex items-center gap-3 shadow-subtle">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </span>
            <div>
                <h4 class="text-xs font-bold text-[#1A241E]">Mediasi Objektif</h4>
                <p class="text-[11px] text-[#76847B]">Ditangani langsung oleh admin pengelola kantin</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-[#E5ECE7] p-3.5 flex items-center gap-3 shadow-subtle">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F6F3EF] text-[#A68A68]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            <div>
                <h4 class="text-xs font-bold text-[#1A241E]">Respon Maks. 1x24 Jam</h4>
                <p class="text-[11px] text-[#76847B]">Proses investigasi dan solusi cepat</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-[#E5ECE7] p-3.5 flex items-center gap-3 shadow-subtle">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F1F5F2] text-[#3F6E52]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </span>
            <div>
                <h4 class="text-xs font-bold text-[#1A241E]">Garansi Transaksi</h4>
                <p class="text-[11px] text-[#76847B]">Kompensasi jika terjadi kelalaian layanan</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-6 lg:grid-cols-12 items-start">

        <!-- Left Column: Form Ajukan Keluhan Baru (lg:col-span-5) -->
        <div class="lg:col-span-5 bg-white rounded-3xl border border-[#E5ECE7] p-6 shadow-subtle space-y-5">
            <div class="flex items-center gap-2.5 pb-3 border-b border-[#E5ECE7]">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#FDF3F3] text-[#C25454]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </span>
                <div>
                    <h2 class="font-display font-bold text-[#1A241E] text-base">Ajukan Keluhan Baru</h2>
                    <p class="text-[11px] text-[#76847B]">Laporkan kendala terkait pesanan Anda</p>
                </div>
            </div>

            @if($eligibleOrders->count() > 0)
                <form action="{{ route('buyer.disputes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="disputeForm">
                    @csrf

                    <!-- Order Selector -->
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Pilih Pesanan Bermasalah *</label>
                        <div class="relative">
                            <select name="order_id" required class="w-full appearance-none rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-3.5 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition pr-9">
                                @foreach($eligibleOrders as $ord)
                                    <option value="{{ $ord->id }}">
                                        {{ $ord->id }} &bull; Rp {{ number_format($ord->total, 0, ',', '.') }} ({{ $ord->shop->name ?? 'Kantin' }})
                                    </option>
                                @endforeach
                            </select>
                            <svg class="w-4 h-4 text-[#76847B] absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Issue Category -->
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Kategori Masalah *</label>
                        <div class="relative">
                            <select name="issue" required class="w-full appearance-none rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-3.5 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition pr-9">
                                <option value="Pesanan tidak sesuai">Pesanan tidak sesuai (kurang item / salah menu)</option>
                                <option value="Pengantaran terlambat">Pengantaran terlambat (melebihi estimasi waktu)</option>
                                <option value="Kualitas makanan">Kualitas makanan tidak layak / tumpah</option>
                                <option value="Pembayaran bermasalah">Pembayaran ditolak / kendala verifikasi</option>
                                <option value="Lainnya">Kendala lainnya</option>
                            </select>
                            <svg class="w-4 h-4 text-[#76847B] absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Jelaskan Detail Masalah *</label>
                        <textarea name="description" rows="3" required placeholder="Ceritakan kronologi kendala (misal: menu yang kurang, durasi keterlambatan, dll)..." class="w-full rounded-xl border border-[#E5ECE7] bg-[#FAFBF9] px-3.5 py-2.5 text-xs sm:text-sm text-[#1A241E] focus:bg-white focus:border-[#1F3E2C] focus:outline-none focus:ring-2 focus:ring-[#1F3E2C]/20 transition"></textarea>
                    </div>

                    <!-- Proof Upload Dropzone -->
                    <div>
                        <label class="block text-xs font-bold text-[#1A241E] mb-1.5">Foto Bukti Pendukung (Opsional)</label>
                        <input type="file" name="proof" id="disputeProofInput" accept="image/*" class="sr-only">

                        <div id="disputeDropzone" onclick="document.getElementById('disputeProofInput').click()" class="group rounded-2xl border-2 border-dashed border-[#C8D6CD] hover:border-[#1F3E2C] bg-[#FAFBF9] hover:bg-[#F1F5F2] p-4 text-center cursor-pointer transition">
                            <div id="dispIdleState" class="space-y-1">
                                <svg class="w-6 h-6 text-[#76847B] group-hover:text-[#1F3E2C] mx-auto transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs font-bold text-[#1F3E2C] hover:underline block">Pilih Foto Bukti</span>
                                <span class="text-[11px] text-[#76847B]">Format JPG, PNG (Maks. 5MB)</span>
                            </div>

                            <div id="dispPreviewState" class="hidden text-left flex items-center gap-3">
                                <img id="dispPreviewImg" src="" alt="Bukti" class="w-12 h-12 rounded-lg object-cover border border-[#E5ECE7] shrink-0">
                                <div class="flex-1 min-w-0">
                                    <span id="dispPreviewName" class="text-xs font-bold text-[#1A241E] truncate block">bukti.jpg</span>
                                    <span id="dispPreviewSize" class="text-[11px] text-[#76847B]">120 KB</span>
                                </div>
                                <button type="button" onclick="event.stopPropagation(); removeDisputeFile();" class="p-1 text-[#C25454] hover:bg-rose-50 rounded-lg transition" title="Hapus foto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3 rounded-2xl bg-[#C25454] hover:bg-[#A83D3D] text-white font-bold text-xs sm:text-sm shadow-subtle hover:shadow-md transition active:scale-98 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span>Kirimkan Laporan Sengketa</span>
                    </button>
                </form>
            @else
                <div class="p-6 rounded-2xl bg-[#FAFBF9] border border-[#E5ECE7] text-center space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-[#1A241E]">Tidak Ada Pesanan yang Perlu Dilaporkan</p>
                    <p class="text-[11px] text-[#76847B] leading-relaxed">Anda belum memiliki pesanan aktif atau pesanan selesai yang dapat diajukan keluhan saat ini.</p>
                </div>
            @endif
        </div>

        <!-- Right Column: Riwayat Sengketa Saya (lg:col-span-7) -->
        <div class="lg:col-span-7 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-display font-bold text-base sm:text-lg text-[#1A241E]">Riwayat Sengketa Saya</h2>
                    <p class="text-xs text-[#76847B]">Pantau penanganan dan tanggapan admin atas keluhan Anda</p>
                </div>
                <span class="text-xs font-semibold text-[#1F3E2C] bg-[#E3ECE6] px-2.5 py-1 rounded-xl">
                    {{ $disputes->count() }} Laporan
                </span>
            </div>

            <!-- List of Dispute Cards -->
            <div class="space-y-4">
                @forelse($disputes as $disp)
                    @php
                        $dispBadges = [
                            'open' => [
                                'bg' => 'bg-[#FFF9EE] text-[#9A6B1F] border-[#F2DEB0]', 
                                'label' => 'Menunggu Mediasi',
                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                            ],
                            'review' => [
                                'bg' => 'bg-[#F0F7FF] text-[#1D68BD] border-[#BFDBFE]', 
                                'label' => 'Dalam Peninjauan',
                                'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'
                            ],
                            'resolved' => [
                                'bg' => 'bg-[#EAF5EF] text-[#1F6E43] border-[#B7E2CB]', 
                                'label' => 'Selesai / Teratasi',
                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                            ],
                            'rejected' => [
                                'bg' => 'bg-[#FDF3F3] text-[#C25454] border-[#F3C5C5]', 
                                'label' => 'Ditolak',
                                'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
                            ],
                        ];
                        $badge = $dispBadges[$disp->status] ?? [
                            'bg' => 'bg-[#F4F6F4] text-[#76847B] border-[#E5ECE7]', 
                            'label' => ucfirst($disp->status),
                            'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                        ];
                    @endphp

                    <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 sm:p-6 shadow-subtle space-y-4 hover:border-[#BFD4C7] transition-all">
                        <!-- Card Top Bar: Ticket ID, Order Link & Status Badge -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3 border-b border-[#E5ECE7]">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-mono text-xs font-bold text-[#1A241E] bg-[#F1F5F2] px-2.5 py-1 rounded-lg border border-[#E5ECE7]">
                                    {{ $disp->id }}
                                </span>
                                <a href="{{ route('buyer.orders.show', $disp->order_id) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#1F3E2C] hover:underline bg-[#EAF2ED] px-2.5 py-1 rounded-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span>Pesanan #{{ $disp->order_id }}</span>
                                    @if($disp->order && $disp->order->shop)
                                        <span class="text-[11px] text-[#76847B]">({{ $disp->order->shop->name }})</span>
                                    @endif
                                </a>
                            </div>

                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }} self-start sm:self-auto">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badge['icon'] }}"></path>
                                </svg>
                                <span>{{ $badge['label'] }}</span>
                            </span>
                        </div>

                        <!-- Card Body: Problem Issue & Buyer Description -->
                        <div class="space-y-2">
                            <h3 class="font-display font-bold text-sm sm:text-base text-[#1A241E] flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#C25454]"></span>
                                <span>{{ $disp->issue }}</span>
                            </h3>

                            <div class="p-3.5 bg-[#FAFBF9] rounded-2xl border border-[#E5ECE7] text-xs text-[#4A584F] leading-relaxed">
                                <p>{{ $disp->description }}</p>

                                @if($disp->proof)
                                    <div class="mt-2.5 pt-2 border-t border-[#E5ECE7]/60 flex items-center gap-2">
                                        <span class="text-[11px] text-[#76847B] font-semibold">Bukti Terlampir:</span>
                                        <a href="{{ $disp->proof }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-[#1F3E2C] hover:underline bg-[#E3ECE6] px-2 py-0.5 rounded-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            <span>Buka Foto</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Resolution Box (Tanggapan Resmi Admin) -->
                        @if($disp->resolution)
                            <div class="p-4 rounded-2xl bg-[#EAF5EF] border border-[#B7E2CB] text-xs text-[#173022] space-y-1.5 shadow-xs">
                                <div class="flex items-center gap-1.5 font-bold text-[#1F3E2C]">
                                    <svg class="w-4 h-4 text-[#1F6E43]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Tanggapan &amp; Solusi Admin KantinKu:</span>
                                </div>
                                <p class="leading-relaxed text-[#2D553D] pl-5">{{ $disp->resolution }}</p>
                            </div>
                        @else
                            <div class="p-3 rounded-xl bg-[#FFF9EE] border border-[#F2DEB0] text-[11px] text-[#8E7252] flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0 text-[#9A6B1F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Laporan Anda telah tercatat dalam sistem dan sedang dalam antrean verifikasi admin.</span>
                            </div>
                        @endif

                        <!-- Footer Details -->
                        <div class="pt-2 flex items-center justify-between text-[11px] text-[#76847B]">
                            <span>Diajukan pada: <strong class="text-[#4A584F]">{{ $disp->created_at->format('d M Y, H:i') }} WIB</strong></span>
                            @if($disp->status === 'resolved')
                                <span class="font-bold text-[#1F6E43] flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Kasus Selesai
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-3xl border border-dashed border-[#C8D6CD] p-12 text-center shadow-subtle space-y-3">
                        <div class="w-14 h-14 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-display font-bold text-base text-[#1A241E]">Belum Ada Riwayat Keluhan</h3>
                        <p class="text-xs text-[#76847B] max-w-sm mx-auto leading-relaxed">
                            Seluruh pesanan Anda berjalan lancar tanpa kendala. Jika suatu saat pesanan tidak sesuai, Anda dapat mengajukan laporan melalui form di samping.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // File upload preview for dispute form
    var proofInput = document.getElementById('disputeProofInput');
    var dropzone = document.getElementById('disputeDropzone');
    var idleState = document.getElementById('dispIdleState');
    var previewState = document.getElementById('dispPreviewState');
    var previewImg = document.getElementById('dispPreviewImg');
    var previewName = document.getElementById('dispPreviewName');
    var previewSize = document.getElementById('dispPreviewSize');

    if (proofInput) {
        proofInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleDisputeFile(this.files[0]);
            }
        });
    }

    if (dropzone) {
        ['dragenter', 'dragover'].forEach(function(ev) {
            dropzone.addEventListener(ev, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-[#1F3E2C]', 'bg-[#E3ECE6]/40');
            });
        });

        ['dragleave', 'drop'].forEach(function(ev) {
            dropzone.addEventListener(ev, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-[#1F3E2C]', 'bg-[#E3ECE6]/40');
            });
        });

        dropzone.addEventListener('drop', function(e) {
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]) {
                proofInput.files = e.dataTransfer.files;
                handleDisputeFile(e.dataTransfer.files[0]);
            }
        });
    }

    function handleDisputeFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Harap pilih file gambar (JPG, PNG).');
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
            idleState.classList.add('hidden');
            previewState.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeDisputeFile() {
        proofInput.value = '';
        previewImg.src = '';
        idleState.classList.remove('hidden');
        previewState.classList.add('hidden');
    }
</script>
@endpush
