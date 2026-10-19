@extends('layouts.app')

@section('title', 'Sengketa Pembayaran & Transaksi')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl sm:text-3xl font-extrabold text-white drop-shadow-md">Sengketa Transaksi Kantin</h1>
        <p class="text-xs sm:text-sm text-emerald-200/80 mt-1 font-medium">Mediasi dan penyelesaian sengketa antara pembeli dan pemilik warung kantin.</p>
    </div>

    <div class="space-y-4">
        @forelse($disputes as $disp)
            @php
                $dispBadges = [
                    'open' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Sengketa Baru (Open)'],
                    'review' => ['bg' => 'bg-sky-50 text-sky-800 border-sky-200', 'label' => 'Sedang Ditinjau'],
                    'resolved' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Telah Diselesaikan'],
                    'rejected' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'label' => 'Ditolak'],
                ];
                $badge = $dispBadges[$disp->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => $disp->status];
            @endphp

            <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-emerald-100/60 p-6 shadow-xl shadow-black/20 space-y-4 text-slate-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-slate-100 text-xs">
                    <div class="flex items-center gap-3">
                        <span class="font-mono font-bold text-slate-900 text-sm">{{ $disp->id }}</span>
                        <span class="text-slate-500">ID Pesanan: <a href="{{ route('buyer.orders.show', $disp->order_id) }}" class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline">#{{ $disp->order_id }}</a></span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badge['bg'] }}">
                        {{ $badge['label'] }}
                    </span>
                </div>

                <div class="grid gap-4 md:grid-cols-2 text-xs">
                    <div class="space-y-3">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pelapor / Pembeli</span>
                            <p class="font-bold text-slate-900 mt-0.5">{{ $disp->buyer->name ?? 'Pembeli' }} <span class="text-slate-500 font-normal">({{ $disp->buyer->email ?? '' }})</span></p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Warung Terkait</span>
                            <p class="font-medium text-slate-800 mt-0.5">{{ $disp->order->shop->name ?? 'Warung Kantin' }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kategori Masalah</span>
                            <p class="font-bold text-rose-600 mt-0.5">{{ $disp->issue }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kronologi & Deskripsi</span>
                            <p class="text-slate-700 leading-relaxed bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80 mt-1">{{ $disp->description }}</p>
                        </div>
                    </div>

                    <!-- Admin Resolution Box -->
                    <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-200/80 space-y-3 flex flex-col justify-between">
                        <div>
                            <h3 class="font-display font-bold text-slate-900 text-xs">Tindakan & Solusi Mediasi Admin</h3>
                            <form action="{{ route('admin.disputes.resolve', $disp->id) }}" method="POST" class="mt-2.5 space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Status Sengketa</label>
                                    <select name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition">
                                        <option value="review" {{ $disp->status === 'review' ? 'selected' : '' }}>Tinjau (Dalam Investigasi)</option>
                                        <option value="resolved" {{ $disp->status === 'resolved' ? 'selected' : '' }}>Selesai (Solusi Diberikan)</option>
                                        <option value="rejected" {{ $disp->status === 'rejected' ? 'selected' : '' }}>Tolak Keluhan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Catatan Solusi / Penyelesaian</label>
                                    <textarea name="resolution" rows="2" placeholder="Tuliskan catatan tindak lanjut..." class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition">{{ $disp->resolution }}</textarea>
                                </div>

                                <button type="submit" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white font-bold text-xs shadow-md shadow-emerald-700/20 transition active:scale-98">
                                    Simpan Status Penyelesaian
                                </button>
                            </form>
                        </div>

                        <span class="text-[10px] text-slate-400 block pt-2 border-t border-slate-200">
                            Waktu Lapor: {{ $disp->created_at->format('d M Y, H:i') }} WIB
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-dashed border-emerald-200/60 p-12 text-center text-xs text-slate-500 shadow-xl">
                Tidak ada sengketa transaksi yang perlu ditangani saat ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
