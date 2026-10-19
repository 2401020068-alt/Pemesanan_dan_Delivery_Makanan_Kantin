@extends('layouts.app')

@section('title', 'Selesaikan Pembayaran - ' . $order->id)

@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-12">
    <!-- Top Bar: Navigation, ID Badge & Live Countdown -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white rounded-2xl border border-[#E5ECE7] p-4 sm:p-5 shadow-subtle">
        <div class="flex items-center gap-3">
            <a href="{{ route('buyer.orders.show', $order->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#1F3E2C] bg-[#F1F5F2] hover:bg-[#E3ECE6] transition border border-[#BFD4C7]/50 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="font-display font-bold text-base sm:text-lg text-[#1A241E]">Pembayaran Pesanan</h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold bg-[#EAF2ED] text-[#1F3E2C] border border-[#BFD4C7]">
                        {{ $order->id }}
                        <button type="button" onclick="copyText('{{ $order->id }}', this, 'ID disalin!')" title="Salin ID Pesanan" class="text-[#76847B] hover:text-[#1F3E2C] transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </button>
                    </span>
                </div>
                <p class="text-xs text-[#76847B] mt-0.5">Warung: <strong class="text-[#1A241E]">{{ $order->shop->name ?? 'Kantin Kampus' }}</strong> &bull; {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Live Countdown Timer -->
        <div class="flex items-center gap-2.5 self-start sm:self-auto bg-[#F6F3EF] border border-[#E5ECE7] rounded-xl px-3.5 py-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#A68A68] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#A68A68]"></span>
            </span>
            <div class="text-right">
                <span class="text-[10px] uppercase tracking-wider font-semibold text-[#8E7252] block leading-none">Batas Pembayaran</span>
                <span id="countdownDisplay" class="font-mono text-xs font-extrabold text-[#1A241E]">14:59</span>
            </div>
        </div>
    </div>

    <!-- Main Grid: 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Payment Instrument Stand (QRIS / Bank) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Total Amount Header Banner -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#173022] via-[#1F3E2C] to-[#2D553D] p-6 text-white shadow-md border border-[#2D553D]">
                <div class="absolute -right-8 -top-8 w-40 h-40 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute right-6 bottom-4 opacity-10 pointer-events-none">
                    <svg class="w-28 h-28" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/15 text-[#E8F3ED] backdrop-blur-sm border border-white/10 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            Metode: {{ $order->payment_method }}
                        </span>
                        <div class="text-xs text-[#BFD4C7] font-medium mt-3">Total Tagihan Yang Harus Dibayar</div>
                        <div class="font-display text-3xl sm:text-4xl font-extrabold text-white tracking-tight mt-0.5 flex items-baseline gap-2">
                            <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex sm:flex-col gap-2 shrink-0">
                        <button type="button" onclick="copyText('{{ $order->total }}', this, 'Nominal disalin!')" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-md text-white text-xs font-bold border border-white/20 transition shadow-xs active:scale-95">
                            <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg>
                            <span>Salin Nominal</span>
                        </button>
                    </div>
                </div>
            </div>

            @if($order->payment_method === 'QRIS')
                <!-- Authentic Digital QRIS Stand Card -->
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 sm:p-7 shadow-subtle space-y-6">
                    <!-- QRIS Stand Frame -->
                    <div id="qrisContainer" class="max-w-sm mx-auto bg-white rounded-3xl border-2 border-[#1A241E]/15 p-5 shadow-float relative transition-transform hover:scale-[1.01]">
                        <!-- National QRIS Header -->
                        <div class="flex items-center justify-between pb-3 border-b-2 border-[#1A241E]/10">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 bg-[#EE2737] text-white font-extrabold text-xs tracking-wider rounded-md shadow-xs">
                                    QRIS
                                </span>
                                <div class="leading-none">
                                    <span class="text-[9px] font-extrabold text-[#1A241E] uppercase tracking-tight block">Pembayaran Digital</span>
                                    <span class="text-[8px] text-[#76847B]">Standar Nasional Bank Indonesia</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-black text-[#1A241E] tracking-widest border border-[#1A241E]/20 px-1.5 py-0.5 rounded">
                                GPN
                            </span>
                        </div>

                        <!-- Merchant Information -->
                        <div class="text-center pt-3 pb-2">
                            <h3 class="font-display font-extrabold text-sm sm:text-base text-[#1A241E] tracking-tight uppercase">
                                {{ $order->shop->name ?? 'KANTINKU KAMPUS' }}
                            </h3>
                            <div class="flex items-center justify-center gap-2 mt-0.5 text-[10px] text-[#76847B] font-mono">
                                <span>NMID: ID102938475892</span>
                                <span>&bull;</span>
                                <span>A01</span>
                            </div>
                        </div>

                        <!-- QR Code Visual (High Density & Clean Design) -->
                        <div class="relative bg-white p-3 rounded-2xl border border-[#E5ECE7] shadow-inner my-2 flex items-center justify-center">
                            <svg class="w-56 h-56 max-w-full" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="200" height="200" fill="white"/>

                                <!-- Position Detection Pattern: Top Left -->
                                <rect x="12" y="12" width="48" height="48" rx="8" fill="#173022"/>
                                <rect x="20" y="20" width="32" height="32" rx="4" fill="white"/>
                                <rect x="26" y="26" width="20" height="20" rx="3" fill="#173022"/>

                                <!-- Position Detection Pattern: Top Right -->
                                <rect x="140" y="12" width="48" height="48" rx="8" fill="#173022"/>
                                <rect x="148" y="20" width="32" height="32" rx="4" fill="white"/>
                                <rect x="154" y="26" width="20" height="20" rx="3" fill="#173022"/>

                                <!-- Position Detection Pattern: Bottom Left -->
                                <rect x="12" y="140" width="48" height="48" rx="8" fill="#173022"/>
                                <rect x="20" y="148" width="32" height="32" rx="4" fill="white"/>
                                <rect x="26" y="154" width="20" height="20" rx="3" fill="#173022"/>

                                <!-- Alignment Pattern: Bottom Right -->
                                <rect x="144" y="144" width="28" height="28" rx="6" fill="#173022"/>
                                <rect x="150" y="150" width="16" height="16" rx="3" fill="white"/>
                                <rect x="154" y="154" width="8" height="8" rx="1.5" fill="#173022"/>

                                <!-- Timing Pattern Horizontal -->
                                <rect x="66" y="28" width="8" height="8" fill="#173022"/>
                                <rect x="80" y="28" width="8" height="8" fill="#173022"/>
                                <rect x="94" y="28" width="8" height="8" fill="#173022"/>
                                <rect x="108" y="28" width="8" height="8" fill="#173022"/>
                                <rect x="122" y="28" width="8" height="8" fill="#173022"/>

                                <!-- Timing Pattern Vertical -->
                                <rect x="28" y="66" width="8" height="8" fill="#173022"/>
                                <rect x="28" y="80" width="8" height="8" fill="#173022"/>
                                <rect x="28" y="94" width="8" height="8" fill="#173022"/>
                                <rect x="28" y="108" width="8" height="8" fill="#173022"/>
                                <rect x="28" y="122" width="8" height="8" fill="#173022"/>

                                <!-- Dense Realistic Matrix Modules -->
                                <rect x="66" y="44" width="8" height="8" fill="#173022"/>
                                <rect x="74" y="52" width="8" height="8" fill="#2D553D"/>
                                <rect x="88" y="44" width="8" height="8" fill="#173022"/>
                                <rect x="102" y="52" width="8" height="8" fill="#173022"/>
                                <rect x="116" y="44" width="8" height="8" fill="#2D553D"/>
                                <rect x="124" y="52" width="8" height="8" fill="#173022"/>

                                <rect x="66" y="66" width="8" height="8" fill="#173022"/>
                                <rect x="74" y="80" width="8" height="8" fill="#173022"/>
                                <rect x="82" y="66" width="8" height="8" fill="#2D553D"/>
                                <rect x="110" y="66" width="8" height="8" fill="#173022"/>
                                <rect x="124" y="80" width="8" height="8" fill="#173022"/>
                                <rect x="132" y="66" width="8" height="8" fill="#2D553D"/>

                                <rect x="66" y="104" width="8" height="8" fill="#173022"/>
                                <rect x="74" y="118" width="8" height="8" fill="#2D553D"/>
                                <rect x="82" y="104" width="8" height="8" fill="#173022"/>
                                <rect x="110" y="118" width="8" height="8" fill="#173022"/>
                                <rect x="124" y="104" width="8" height="8" fill="#2D553D"/>
                                <rect x="132" y="118" width="8" height="8" fill="#173022"/>

                                <rect x="144" y="66" width="8" height="8" fill="#173022"/>
                                <rect x="158" y="74" width="8" height="8" fill="#2D553D"/>
                                <rect x="172" y="66" width="8" height="8" fill="#173022"/>
                                <rect x="144" y="94" width="8" height="8" fill="#2D553D"/>
                                <rect x="158" y="104" width="8" height="8" fill="#173022"/>
                                <rect x="172" y="114" width="8" height="8" fill="#173022"/>
                                <rect x="180" y="94" width="8" height="8" fill="#2D553D"/>

                                <rect x="44" y="66" width="8" height="8" fill="#173022"/>
                                <rect x="52" y="80" width="8" height="8" fill="#2D553D"/>
                                <rect x="44" y="94" width="8" height="8" fill="#173022"/>
                                <rect x="52" y="108" width="8" height="8" fill="#173022"/>
                                <rect x="44" y="122" width="8" height="8" fill="#2D553D"/>

                                <rect x="66" y="140" width="8" height="8" fill="#173022"/>
                                <rect x="80" y="148" width="8" height="8" fill="#2D553D"/>
                                <rect x="94" y="140" width="8" height="8" fill="#173022"/>
                                <rect x="108" y="148" width="8" height="8" fill="#173022"/>
                                <rect x="122" y="140" width="8" height="8" fill="#2D553D"/>

                                <rect x="66" y="166" width="8" height="8" fill="#173022"/>
                                <rect x="74" y="174" width="8" height="8" fill="#2D553D"/>
                                <rect x="88" y="166" width="8" height="8" fill="#173022"/>
                                <rect x="102" y="174" width="8" height="8" fill="#173022"/>
                                <rect x="116" y="166" width="8" height="8" fill="#2D553D"/>
                                <rect x="124" y="174" width="8" height="8" fill="#173022"/>

                                <!-- Center Shield Emblem -->
                                <circle cx="100" cy="100" r="16" fill="white"/>
                                <circle cx="100" cy="100" r="13" fill="#1F3E2C"/>
                                <path d="M96 95h8c2.2 0 4 1.8 4 4 0 2.2-1.8 4-4 4h-4v4h-4V95zm4 5h4c.55 0 1-.45 1-1s-.45-1-1-1h-4v2z" fill="white"/>
                            </svg>
                        </div>

                        <!-- Footer Stand Amount Stamp -->
                        <div class="mt-2 text-center pt-2 border-t border-[#E5ECE7]">
                            <span class="text-[9px] uppercase tracking-wider text-[#76847B] font-semibold block">Nominal Pembayaran</span>
                            <span class="font-display font-extrabold text-sm sm:text-base text-[#1F3E2C]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Quick Actions Under QRIS -->
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                        <button type="button" onclick="downloadQRIS()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F1F5F2] hover:bg-[#E3ECE6] text-[#1F3E2C] text-xs font-bold transition shadow-xs active:scale-95 border border-[#BFD4C7]">
                            <svg class="w-4 h-4 text-[#1F3E2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <span>Unduh Kode QR</span>
                        </button>
                        <button type="button" onclick="copyText('{{ $order->total }}', this, 'Nominal Disalin!')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F6F3EF] hover:bg-[#EFEAE2] text-[#8E7252] text-xs font-bold transition shadow-xs active:scale-95 border border-[#E5ECE7]">
                            <svg class="w-4 h-4 text-[#A68A68]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            <span>Salin Nominal</span>
                        </button>
                    </div>

                    <!-- Supported Banking & E-Wallets Channels -->
                    <div class="pt-4 border-t border-[#E5ECE7]">
                        <span class="text-[11px] font-semibold text-[#76847B] text-center block mb-2.5">
                            Mendukung Pembayaran Dari Semua Aplikasi Perbankan &amp; Dompet Digital:
                        </span>
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#0081C9]"></span> BCA Mobile
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#00AA13]"></span> GoPay
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#4C35DE]"></span> OVO
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#118EEA]"></span> DANA
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#EE4D2D]"></span> ShopeePay
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#F58220]"></span> Livin' Mandiri
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#FAFBF9] border border-[#E5ECE7] text-[11px] font-bold text-[#1A241E]">
                                <span class="w-2 h-2 rounded-full bg-[#00529C]"></span> BRImo
                            </span>
                        </div>
                    </div>
                </div>

            @else
                <!-- Transfer Bank / E-Wallet Manual Stand -->
                <div class="bg-white rounded-3xl border border-[#E5ECE7] p-6 sm:p-7 shadow-subtle space-y-5">
                    <div class="flex items-center gap-3 pb-3 border-b border-[#E5ECE7]">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </span>
                        <div>
                            <h3 class="font-display font-bold text-base text-[#1A241E]">Rekening Transfer Resmi</h3>
                            <p class="text-xs text-[#76847B]">Transfer tepat sesuai nominal tagihan yang tertera.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="p-4 rounded-2xl bg-[#F4F6F4] border border-[#E5ECE7] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-[#76847B] tracking-wider block">Bank Mandiri / Virtual Account</span>
                                <span class="font-mono text-lg font-bold text-[#1F3E2C] tracking-wide">8801-0812-2222-0002</span>
                                <span class="text-xs text-[#4A584F] block mt-0.5">a.n. {{ $order->shop->name ?? 'KantinKu Kampus' }}</span>
                            </div>
                            <button type="button" onclick="copyText('8801081222220002', this, 'Nomor disalin!')" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-[#E3ECE6] text-[#1F3E2C] text-xs font-bold border border-[#BFD4C7] shadow-xs transition active:scale-95 shrink-0">
                                <svg class="w-3.5 h-3.5 text-[#1F3E2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Salin No. Rek</span>
                            </button>
                        </div>

                        <div class="p-4 rounded-2xl bg-[#F4F6F4] border border-[#E5ECE7] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-[#76847B] tracking-wider block">BCA (Bank Central Asia)</span>
                                <span class="font-mono text-lg font-bold text-[#1F3E2C] tracking-wide">731-0294-881</span>
                                <span class="text-xs text-[#4A584F] block mt-0.5">a.n. {{ $order->shop->name ?? 'KantinKu Kampus' }}</span>
                            </div>
                            <button type="button" onclick="copyText('7310294881', this, 'Nomor disalin!')" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-white hover:bg-[#E3ECE6] text-[#1F3E2C] text-xs font-bold border border-[#BFD4C7] shadow-xs transition active:scale-95 shrink-0">
                                <svg class="w-3.5 h-3.5 text-[#1F3E2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Salin No. Rek</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 3-Step Simple Guide -->
            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 sm:p-6 shadow-subtle">
                <h4 class="font-display font-bold text-xs uppercase tracking-wider text-[#1A241E] mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#1F3E2C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    3 Langkah Mudah Menyelesaikan Pembayaran
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3 bg-[#FAFBF9] rounded-2xl border border-[#E5ECE7]">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg bg-[#E3ECE6] text-[#1F3E2C] font-bold text-xs mb-1.5">1</span>
                        <h5 class="font-bold text-xs text-[#1A241E]">Pindai / Transfer</h5>
                        <p class="text-[11px] text-[#76847B] mt-0.5 leading-relaxed">Buka aplikasi mobile banking atau e-wallet Anda, lalu pindai kode QRIS di atas.</p>
                    </div>
                    <div class="p-3 bg-[#FAFBF9] rounded-2xl border border-[#E5ECE7]">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg bg-[#E3ECE6] text-[#1F3E2C] font-bold text-xs mb-1.5">2</span>
                        <h5 class="font-bold text-xs text-[#1A241E]">Periksa Tagihan</h5>
                        <p class="text-[11px] text-[#76847B] mt-0.5 leading-relaxed">Pastikan nama warung dan nominal pas <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> sebelum bayar.</p>
                    </div>
                    <div class="p-3 bg-[#FAFBF9] rounded-2xl border border-[#E5ECE7]">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-lg bg-[#E3ECE6] text-[#1F3E2C] font-bold text-xs mb-1.5">3</span>
                        <h5 class="font-bold text-xs text-[#1A241E]">Unggah Bukti</h5>
                        <p class="text-[11px] text-[#76847B] mt-0.5 leading-relaxed">Simpan tangkapan layar pembayaran, lalu unggah pada form di samping.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Breakdown Receipt & Upload Proof Form -->
        <div class="lg:col-span-5 space-y-6">

            <!-- Order Breakdown Ticket Receipt -->
            <div class="bg-white rounded-3xl border border-[#E5ECE7] shadow-subtle overflow-hidden">
                <div class="p-5 bg-gradient-to-r from-[#F4F6F4] to-white border-b border-[#E5ECE7]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#E3ECE6] text-[#1F3E2C]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            <div>
                                <h3 class="font-display font-bold text-sm text-[#1A241E]">Rincian Pesanan</h3>
                                <p class="text-[11px] text-[#76847B]">{{ $order->shop->name ?? 'Kantin' }} &bull; {{ $order->shop->location ?? 'Kantin Kampus' }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-mono text-[#76847B] bg-[#F1F5F2] px-2 py-0.5 rounded-md font-bold">
                            {{ $order->items->count() }} Menu
                        </span>
                    </div>
                </div>

                <!-- Items List -->
                <div class="p-5 space-y-3 divide-y divide-[#E5ECE7]/60">
                    <div class="space-y-2.5 pb-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-9 h-9 rounded-xl object-cover bg-[#F4F6F4] shrink-0 border border-[#E5ECE7]">
                                    @else
                                        <div class="w-9 h-9 rounded-xl bg-[#E3ECE6] text-[#1F3E2C] flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ substr($item->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="truncate">
                                        <h5 class="font-bold text-[#1A241E] truncate">{{ $item->name }}</h5>
                                        <span class="text-[11px] text-[#76847B]">{{ $item->qty }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <span class="font-bold text-[#1A241E] shrink-0">
                                    Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cost Calculations -->
                    <div class="pt-3 space-y-2 text-xs text-[#4A584F]">
                        <div class="flex justify-between">
                            <span class="text-[#76847B]">Subtotal Menu</span>
                            <span class="font-semibold text-[#1A241E]">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#76847B]">Ongkos Kirim Kampus</span>
                            <span class="font-semibold text-[#1A241E]">Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[11px] text-[#76847B]">
                            <span>Biaya Layanan &amp; Penanganan</span>
                            <span class="font-bold text-emerald-700">Rp 0 (Gratis)</span>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="pt-3 flex justify-between items-center text-sm font-bold">
                        <span class="text-[#1A241E]">Total Tagihan</span>
                        <span class="font-display text-lg text-[#1F3E2C]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Delivery Address Mini Card -->
                    <div class="pt-3 text-[11px] text-[#76847B]">
                        <div class="flex items-start gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#1F3E2C] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <div>
                                <span class="font-semibold text-[#1A241E] block">Tujuan Pengantaran:</span>
                                <span>{{ $order->address }}</span>
                                @if($order->note)
                                    <p class="text-[10px] text-[#A68A68] italic mt-0.5">"{{ $order->note }}"</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Transfer Interactive Card -->
            <div class="bg-white rounded-3xl border border-[#E5ECE7] p-5 sm:p-6 shadow-subtle space-y-4">
                <div class="flex items-center gap-2.5 pb-2 border-b border-[#E5ECE7]">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#F6F3EF] text-[#A68A68]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </span>
                    <div>
                        <h3 class="font-display font-bold text-sm text-[#1A241E]">Unggah Bukti Pembayaran</h3>
                        <p class="text-[11px] text-[#76847B]">Lampirkan tangkapan layar transaksi berhasil</p>
                    </div>
                </div>

                <form action="{{ route('buyer.payment.submit', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="paymentForm">
                    @csrf

                    <!-- Custom Interactive Dropzone -->
                    <div>
                        <!-- Hidden Native File Input -->
                        <input type="file" name="proof" id="proofInput" accept="image/*" class="sr-only">

                        <!-- Interactive Drop Area -->
                        <div id="dropzoneBox" onclick="document.getElementById('proofInput').click()" class="group relative rounded-2xl border-2 border-dashed border-[#C8D6CD] hover:border-[#1F3E2C] bg-[#FAFBF9] hover:bg-[#F1F5F2] p-5 text-center cursor-pointer transition-all duration-200">
                            <!-- Idle State Content -->
                            <div id="idleState" class="space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-[#E3ECE6] text-[#1F3E2C] group-hover:scale-110 flex items-center justify-center mx-auto transition-transform shadow-xs">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-[#1F3E2C] hover:underline">
                                        Pilih Tangkapan Layar
                                    </span>
                                    <span class="text-xs text-[#76847B]"> atau seret file ke sini</span>
                                    <p class="text-[11px] text-[#76847B] mt-1">Mendukung format JPG, PNG, atau WebP (Maks. 5MB)</p>
                                </div>
                            </div>

                            <!-- Selected / Preview State Content (Hidden by default) -->
                            <div id="previewState" class="hidden text-left">
                                <div class="flex items-center gap-3 bg-white p-2.5 rounded-xl border border-[#E5ECE7]">
                                    <img id="previewImage" src="" alt="Bukti Pembayaran" class="w-14 h-14 rounded-lg object-cover border border-[#E5ECE7] shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span id="previewName" class="text-xs font-bold text-[#1A241E] truncate block">bukti_bayar.png</span>
                                        </div>
                                        <span id="previewSize" class="text-[11px] text-[#76847B] block mt-0.5">240 KB</span>
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200 mt-1 inline-block">
                                            ✓ File Siap Diunggah
                                        </span>
                                    </div>
                                    <button type="button" onclick="event.stopPropagation(); removeFile();" class="p-1.5 rounded-lg text-[#C25454] hover:bg-[#FDF3F3] transition shrink-0" title="Hapus foto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <p class="text-[11px] text-[#76847B] mt-2 italic flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-[#1F3E2C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Mode Demo: Jika tidak ada file yang dipilih, bukti simulasi otomatis dilampirkan.</span>
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" class="group relative flex items-center justify-center gap-2 w-full py-3.5 px-4 rounded-2xl bg-[#1F3E2C] hover:bg-[#2A523A] text-white font-bold text-sm shadow-subtle hover:shadow-md transition-all duration-200 active:scale-98">
                        <svg class="w-4 h-4 text-white/90 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Konfirmasi &amp; Kirim Bukti Pembayaran</span>
                    </button>
                </form>

                <!-- Secure Guarantee Seal -->
                <div class="pt-2 flex items-center justify-center gap-2 text-[11px] text-[#76847B]">
                    <svg class="w-3.5 h-3.5 text-[#2D553D]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Transaksi Terenkripsi &amp; Terverifikasi Oleh Penjual Kantin</span>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toast Feedback Container -->
<div id="toastBox" class="fixed bottom-6 right-6 z-50 transform translate-y-12 opacity-0 transition-all duration-300 pointer-events-none bg-[#173022] text-white px-4 py-2.5 rounded-xl shadow-float flex items-center gap-2 text-xs font-bold border border-[#2D553D]">
    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    <span id="toastMsg">Tersalin!</span>
</div>
@endsection

@push('scripts')
<script>
    // 1. Live Countdown Timer (15 Minutes)
    (function initCountdown() {
        var storageKey = 'payment_deadline_' + '{{ $order->id }}';
        var deadline = localStorage.getItem(storageKey);
        var now = Math.floor(Date.now() / 1000);

        if (!deadline || parseInt(deadline) <= now) {
            deadline = now + (15 * 60); // 15 mins from now
            localStorage.setItem(storageKey, deadline);
        }

        var display = document.getElementById('countdownDisplay');

        function updateTimer() {
            var currentNow = Math.floor(Date.now() / 1000);
            var remaining = parseInt(deadline) - currentNow;

            if (remaining <= 0) {
                if (display) display.textContent = '00:00 (Kedaluwarsa)';
                return;
            }

            var mins = Math.floor(remaining / 60);
            var secs = remaining % 60;
            var formatted = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
            if (display) display.textContent = formatted;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    })();

    // 2. Copy Text Helper with Toast
    function copyText(text, btn, message) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text);
        } else {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }

        showToast(message || 'Tersalin ke papan klip!');
    }

    function showToast(message) {
        var toast = document.getElementById('toastBox');
        var msg = document.getElementById('toastMsg');
        if (!toast || !msg) return;

        msg.textContent = message;
        toast.classList.remove('translate-y-12', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(function() {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-12', 'opacity-0');
        }, 2500);
    }

    // 3. Interactive File Upload & Drag-and-Drop Preview
    var proofInput = document.getElementById('proofInput');
    var dropzoneBox = document.getElementById('dropzoneBox');
    var idleState = document.getElementById('idleState');
    var previewState = document.getElementById('previewState');
    var previewImage = document.getElementById('previewImage');
    var previewName = document.getElementById('previewName');
    var previewSize = document.getElementById('previewSize');

    if (proofInput) {
        proofInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                handleFile(this.files[0]);
            }
        });
    }

    if (dropzoneBox) {
        ['dragenter', 'dragover'].forEach(function(eventName) {
            dropzoneBox.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzoneBox.classList.add('border-[#1F3E2C]', 'bg-[#EAF2ED]');
            }, false);
        });

        ['dragleave', 'drop'].forEach(function(eventName) {
            dropzoneBox.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzoneBox.classList.remove('border-[#1F3E2C]', 'bg-[#EAF2ED]');
            }, false);
        });

        dropzoneBox.addEventListener('drop', function(e) {
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]) {
                proofInput.files = e.dataTransfer.files;
                handleFile(e.dataTransfer.files[0]);
            }
        });
    }

    function handleFile(file) {
        if (!file.type.startsWith('image/')) {
            showToast('Hanya berkas gambar yang didukung');
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';

            idleState.classList.add('hidden');
            previewState.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function removeFile() {
        proofInput.value = '';
        previewImage.src = '';
        idleState.classList.remove('hidden');
        previewState.classList.add('hidden');
        showToast('Foto bukti dibatalkan');
    }

    // 4. Download QRIS Stand Functionality
    function downloadQRIS() {
        var svg = document.querySelector('#qrisContainer svg');
        if (!svg) return;

        var svgData = new XMLSerializer().serializeToString(svg);
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var img = new Image();

        canvas.width = 600;
        canvas.height = 700;

        // Draw Canvas Background and Card Stand Frame
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Header Background
        ctx.fillStyle = '#EE2737';
        ctx.fillRect(40, 30, 90, 35);
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 20px sans-serif';
        ctx.fillText('QRIS', 58, 55);

        // Merchant text
        ctx.fillStyle = '#173022';
        ctx.font = 'bold 22px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('{{ strtoupper($order->shop->name ?? "KANTINKU KAMPUS") }}', canvas.width / 2, 110);
        ctx.font = '14px monospace';
        ctx.fillStyle = '#76847B';
        ctx.fillText('NMID: ID102938475892 | KantinKu', canvas.width / 2, 135);

        img.onload = function() {
            ctx.drawImage(img, (canvas.width - 400) / 2, 160, 400, 400);

            // Amount Footer
            ctx.fillStyle = '#F4F6F4';
            ctx.fillRect(40, 580, canvas.width - 80, 75);
            ctx.fillStyle = '#76847B';
            ctx.font = 'bold 12px sans-serif';
            ctx.fillText('TOTAL PEMBAYARAN', canvas.width / 2, 608);
            ctx.fillStyle = '#1F3E2C';
            ctx.font = 'bold 26px sans-serif';
            ctx.fillText('Rp {{ number_format($order->total, 0, ",", ".") }}', canvas.width / 2, 642);

            var a = document.createElement('a');
            a.download = 'QRIS-{{ $order->id }}.png';
            a.href = canvas.toDataURL('image/png');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            showToast('Kode QRIS berhasil diunduh!');
        };

        img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
    }
</script>
@endpush
