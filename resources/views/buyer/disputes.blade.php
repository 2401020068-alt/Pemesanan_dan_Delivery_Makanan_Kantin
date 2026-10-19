@extends('layouts.app')

@section('title', 'Sengketa & Bantuan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white drop-shadow-md">Sengketa &amp; Layanan Bantuan</h1>
        <p class="text-xs sm:text-sm text-emerald-200/80 mt-1 font-medium">Ajukan keluhan transaksi jika menu tidak sesuai, keterlambatan parah, atau kendala verifikasi pembayaran.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <!-- New Dispute Form -->
        <div class="md:col-span-1 bg-white/95 backdrop-blur-xl rounded-3xl border border-emerald-100/60 p-6 shadow-2xl shadow-black/30 space-y-4 text-slate-800">
            <h2 class="font-display font-bold text-slate-900 text-base">Ajukan Keluhan Baru</h2>

            @if($eligibleOrders->count() > 0)
                <form action="{{ route('buyer.disputes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Pesanan *</label>
                        <select name="order_id" required class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs sm:text-sm text-slate-800 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                            @foreach($eligibleOrders as $ord)
                                <option value="{{ $ord->id }}">{{ $ord->id }} - Rp {{ number_format($ord->total, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori Masalah *</label>
                        <select name="issue" required class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs sm:text-sm text-slate-800 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                            <option value="Pesanan tidak sesuai">Pesanan tidak sesuai (kurang item / salah menu)</option>
                            <option value="Pembayaran bermasalah">Pembayaran ditolak / kendala transfer</option>
                            <option value="Pengantaran terlambat">Pengantaran melebihi estimasi waktu</option>
                            <option value="Kualitas makanan">Kualitas makanan tidak layak / tumpah</option>
                            <option value="Lainnya">Masalah lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jelaskan Masalah *</label>
                        <textarea name="description" rows="3" required placeholder="Jelaskan detail kendala yang dialami..." class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs sm:text-sm text-slate-800 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Bukti Foto (Opsional)</label>
                        <input type="file" name="proof" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-800 hover:file:bg-emerald-100 transition-all">
                    </div>

                    <button type="submit" class="w-full py-2.5 sm:py-3 rounded-xl bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white font-bold text-xs sm:text-sm shadow-lg shadow-rose-700/25 transition active:scale-98 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>Kirimkan Laporan Sengketa</span>
                    </button>
                </form>
            @else
                <p class="text-xs text-slate-500 leading-relaxed">Anda belum memiliki pesanan aktif yang dapat diajukan sengketa.</p>
            @endif
        </div>

        <!-- Dispute History -->
        <div class="md:col-span-2 space-y-4">
            <h2 class="font-display font-bold text-white drop-shadow-sm text-base sm:text-lg">Riwayat Sengketa Saya</h2>

            @forelse($disputes as $disp)
                @php
                    $dispBadges = [
                        'open' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Menunggu Mediasi'],
                        'review' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'label' => 'Dalam Peninjauan'],
                        'resolved' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Selesai / Teratasi'],
                        'rejected' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'label' => 'Ditolak'],
                    ];
                    $dBadge = $dispBadges[$disp->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => $disp->status];
                @endphp
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-emerald-100/60 p-5 shadow-xl shadow-black/20 space-y-3 text-slate-800">
                    <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                        <div>
                            <span class="font-mono text-xs font-bold text-slate-900">{{ $disp->id }}</span>
                            <span class="text-xs text-slate-500 ml-2">Pesanan: #{{ $disp->order_id }}</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $dBadge['bg'] }}">
                            {{ $dBadge['label'] }}
                        </span>
                    </div>

                    <div>
                        <h3 class="font-display font-bold text-sm text-slate-900">{{ $disp->issue }}</h3>
                        <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ $disp->description }}</p>
                    </div>

                    @if($disp->resolution)
                        <div class="p-3.5 bg-emerald-50/80 border border-emerald-200/70 rounded-2xl text-xs text-emerald-950">
                            <span class="font-bold block text-emerald-900 mb-0.5">Tanggapan / Solusi Admin:</span>
                            <p class="leading-relaxed">{{ $disp->resolution }}</p>
                        </div>
                    @endif

                    <div class="text-[11px] text-slate-400 font-medium">
                        Diajukan pada: {{ $disp->created_at->format('d M Y, H:i') }} WIB
                    </div>
                </div>
            @empty
                <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-dashed border-emerald-200/60 p-12 text-center text-xs text-slate-500 shadow-xl">
                    Belum ada riwayat keluhan atau sengketa transaksi.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
