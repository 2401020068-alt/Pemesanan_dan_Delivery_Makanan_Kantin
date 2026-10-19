@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran Masuk')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-[#1A241E]">Verifikasi Pembayaran Warung</h1>
        <p class="text-xs sm:text-sm text-[#76847B] mt-1">Periksa screenshot bukti transfer atau QRIS pembeli sebelum pesanan diteruskan ke dapur.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($orders as $ord)
            @php
                $pBadges = [
                    'verified' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Terverifikasi'],
                    'pending' => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Perlu Verifikasi'],
                    'rejected' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'label' => 'Ditolak'],
                ];
                $pBadge = $pBadges[$ord->payment_status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => ucfirst($ord->payment_status)];
            @endphp
            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 shadow-sm hover:shadow-md transition space-y-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-[#E5ECE7] text-xs">
                        <div>
                            <span class="font-mono font-bold text-[#1A241E]">{{ $ord->id }}</span>
                            <span class="text-[10px] text-[#76847B] block">{{ $ord->created_at->format('d M, H:i') }} WIB</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $pBadge['bg'] }}">
                            {{ $pBadge['label'] }}
                        </span>
                    </div>

                    <div class="mt-3 space-y-1.5 text-xs">
                        <div class="flex justify-between">
                            <span class="text-[#76847B]">Pembeli</span>
                            <span class="font-bold text-[#1A241E]">{{ $ord->buyer->name ?? 'Pembeli' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#76847B]">Nominal</span>
                            <span class="font-display font-bold text-emerald-800 text-sm">Rp {{ number_format($ord->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#76847B]">Metode</span>
                            <span class="font-medium text-[#4A584F] uppercase tracking-wide text-[11px]">{{ $ord->payment_method }}</span>
                        </div>
                    </div>

                    <!-- Proof Image Preview -->
                    <div class="mt-4">
                        <span class="text-[10px] font-bold text-[#76847B] uppercase tracking-wider block mb-1">Bukti Transfer</span>
                        @if($ord->proof)
                            <a href="{{ $ord->proof }}" target="_blank" class="block relative rounded-2xl overflow-hidden border border-[#E5ECE7] group bg-[#F4F6F4] h-36">
                                <img src="{{ $ord->proof }}" alt="Bukti Pembayaran {{ $ord->id }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <span class="absolute bottom-2 right-2 px-2.5 py-1 bg-[#173022]/85 text-white rounded-lg text-[10px] font-bold backdrop-blur-sm flex items-center gap-1">
                                    <span>Lihat Bukti</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </span>
                            </a>
                        @else
                            <div class="h-24 rounded-2xl bg-[#F4F6F4] border border-dashed border-[#C8D6CD] flex items-center justify-center text-xs text-[#76847B]">
                                Bukti belum diunggah pembeli
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-[#E5ECE7] flex gap-2">
                    @if($ord->payment_status === 'pending')
                        <form action="{{ route('seller.payments.verify', $ord->id) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="action" value="verify">
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-[#1F3E2C] hover:bg-[#2D553D] text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-1.5 active:scale-98">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span>Verifikasi</span>
                            </button>
                        </form>
                        <form action="{{ route('seller.payments.verify', $ord->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Tolak pembayaran pesanan ini?')">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="w-full py-2.5 rounded-xl bg-[#FDF3F3] hover:bg-[#FBE8E8] text-[#C25454] font-bold text-xs border border-[#F3C5C5] transition flex items-center justify-center gap-1.5 active:scale-98">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span>Tolak</span>
                            </button>
                        </form>
                    @else
                        <span class="w-full py-2 text-center text-xs font-semibold text-[#76847B] bg-[#F4F6F4] rounded-xl flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Status telah diperbarui</span>
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-dashed border-[#C8D6CD] p-12 text-center text-xs text-[#76847B] shadow-sm">
                <div class="max-w-xs mx-auto space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">Tidak Ada Pembayaran Tertunda</p>
                    <p class="text-[11px] text-slate-400">Semua bukti transfer pembeli telah diperiksa dan diverifikasi.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
