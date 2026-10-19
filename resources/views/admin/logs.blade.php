@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-moss-900">Log Aktivitas & Audit Sistem</h1>
        <p class="text-xs sm:text-sm text-text-muted mt-1">Catatan riwayat aksi penting administrator untuk transparansi dan audit sistem.</p>
    </div>

    <div class="bg-white rounded-2xl border border-border-light card-subtle overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-text-body">
                <thead class="bg-surface-alt uppercase text-[10px] font-bold text-text-muted tracking-wider border-b border-border-light">
                    <tr>
                        <th class="px-5 py-3.5">ID & Waktu</th>
                        <th class="px-5 py-3.5">Administrator</th>
                        <th class="px-5 py-3.5">Aksi / Tindakan</th>
                        <th class="px-5 py-3.5">Target Objek</th>
                        <th class="px-5 py-3.5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-light">
                    @forelse($logs as $lg)
                        <tr class="hover:bg-surface-alt/70 transition">
                            <td class="px-5 py-3.5 font-mono">
                                <span class="font-bold text-moss-900 block">{{ $lg->id }}</span>
                                <span class="text-[10px] text-text-muted">{{ $lg->time->format('d/m/Y H:i:s') }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-moss-900">{{ $lg->admin }}</td>
                            <td class="px-5 py-3.5 font-medium text-text-body">{{ $lg->action }}</td>
                            <td class="px-5 py-3.5 font-mono text-[11px] text-text-muted">{{ $lg->target }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $lg->status === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                                    @if($lg->status === 'success')
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Sukses</span>
                                    @else
                                        <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        <span>Gagal</span>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-[#76847B]">
                                <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="font-bold text-[#1A241E] text-sm">Belum Ada Riwayat Log Aktivitas</p>
                                <p class="text-xs text-[#76847B] mt-0.5">Semua aksi audit sistem dan admin akan tercatat di sini secara otomatis.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $logs->links() }}
    </div>
</div>
@endsection
