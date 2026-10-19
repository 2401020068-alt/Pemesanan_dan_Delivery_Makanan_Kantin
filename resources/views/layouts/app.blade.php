<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KantinKu') - Kantin Kampus Digital</title>
    <meta name="description" content="Pesan makanan dari kantin kampus secara online, bayar mudah, dan diantar langsung ke kelasmu.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=4">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=4">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=4">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=4">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=4">

    <!-- Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        // Dominan: Hijau Lumut (Moss Spectrum)
                        moss: {
                            50: '#F1F5F2',
                            100: '#E3ECE6',
                            200: '#BFD4C7',
                            300: '#98B7A4',
                            400: '#709981',
                            500: '#538367',
                            600: '#3F6E52',
                            700: '#2D553D',
                            800: '#1F3E2C', // Primary Brand Color
                            900: '#173022',
                            950: '#0D1C13',
                        },
                        // Aksen Natural (Warm Earth & Sand)
                        sand: {
                            50: '#FAF8F5',
                            100: '#F6F3EF',
                            200: '#E9E2D8',
                            300: '#D5C7B6',
                            400: '#BFAB92',
                            500: '#A68A68', // Rating, highlight
                            600: '#8E7252',
                            700: '#725A3F',
                        },
                        // Brand Aliases
                        brand: {
                            DEFAULT: '#1F3E2C',
                            50: '#F1F5F2',
                            100: '#E3ECE6',
                            200: '#BFD4C7',
                            300: '#98B7A4',
                            400: '#709981',
                            500: '#3F6E52',
                            600: '#1F3E2C', // Primary Brand
                            700: '#2D553D', // Hover
                            800: '#173022', // Deep
                            900: '#0D1C13',
                        },
                        primary: {
                            DEFAULT: '#1F3E2C',
                            hover: '#2D553D',
                            soft: '#E3ECE6',
                        },
                        // Netral & Permukaan
                        canvas: '#FAFBF9',
                        surface: {
                            DEFAULT: '#FFFFFF',
                            card: '#FFFFFF',
                            alt: '#F4F6F4',
                        },
                        // Mapped Slate & Emerald to Earthy Moss Elegance
                        slate: {
                            50: '#FAFBF9',  // canvas-bg
                            100: '#F4F6F4', // surface-alt
                            200: '#E5ECE7', // border-subtle
                            300: '#C8D6CD', // border-hover
                            400: '#76847B', // text-muted
                            500: '#76847B',
                            600: '#4A584F', // text-body
                            700: '#3F6E52', // moss-600
                            800: '#1A241E', // text-heading
                            900: '#173022', // moss-900
                            950: '#0D1C13',
                        },
                        emerald: {
                            50: '#F1F5F2',
                            100: '#E3ECE6',
                            200: '#BFD4C7',
                            300: '#98B7A4',
                            400: '#709981',
                            500: '#3F6E52',
                            600: '#2D553D',
                            700: '#1F3E2C',
                            800: '#173022',
                            900: '#0D1C13',
                        },
                        amber: {
                            50: '#FAF8F5',
                            100: '#F6F3EF',
                            200: '#E9E2D8',
                            300: '#D5C7B6',
                            400: '#BFAB92',
                            500: '#A68A68',
                            600: '#8E7252',
                            700: '#725A3F',
                        },
                        rose: {
                            50: '#FDF3F3',
                            100: '#FBE8E8',
                            200: '#F3C5C5',
                            500: '#C25454',
                            600: '#A63F3F',
                            700: '#8A2E2E',
                        }
                    },
                    borderRadius: {
                        '2xl': '16px',
                    },
                    boxShadow: {
                        subtle: '0 4px 16px rgba(23, 48, 34, 0.04)',
                        float: '0 8px 24px rgba(23, 48, 34, 0.08)',
                        card: '0 4px 16px rgba(23, 48, 34, 0.04)',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            /* Brand Moss Scale */
            --moss-900: #173022;
            --moss-800: #1F3E2C;
            --moss-700: #2D553D;
            --moss-600: #3F6E52;
            --moss-400: #709981;
            --moss-200: #BFD4C7;
            --moss-100: #E3ECE6;
            --moss-50:  #F1F5F2;

            /* Neutrals */
            --canvas-bg: #FAFBF9;
            --surface-card: #FFFFFF;
            --surface-alt: #F4F6F4;
            --border-light: #E5ECE7;
            --border-medium: #C8D6CD;

            /* Typography */
            --text-heading: #1A241E;
            --text-body: #4A584F;
            --text-muted: #76847B;
            --text-inverse: #FFFFFF;

            /* Warm Earth Accents */
            --accent-sand: #A68A68;
            --accent-sand-soft: #F6F3EF;

            /* Gradients */
            --grad-hero: radial-gradient(circle at 75% 45%, #E3EBE5 0%, #FAFBF9 70%);
            --grad-card-moss: linear-gradient(145deg, #1F3E2C 0%, #2A533B 100%);
            --grad-ribbon: linear-gradient(90deg, #173022 0%, #224732 50%, #173022 100%);
            --grad-surface-subtle: linear-gradient(180deg, #FFFFFF 0%, #F5F8F6 100%);

            /* Shadows */
            --shadow-subtle: 0 4px 16px rgba(23, 48, 34, 0.04);
            --shadow-float: 0 8px 24px rgba(23, 48, 34, 0.08);
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--canvas-bg);
            color: var(--text-body);
        }
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-heading);
        }
        .card-shadow {
            box-shadow: var(--shadow-subtle);
        }
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-float);
            border-color: var(--border-medium);
        }
        .glass-header {
            background: rgba(250, 251, 249, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--moss-200);
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--moss-400);
        }

        /* Form Inputs */
        input:not([type="checkbox"]):not([type="radio"]):focus,
        select:focus,
        textarea:focus {
            border-color: var(--moss-800) !important;
            box-shadow: 0 0 0 3px rgba(31, 62, 44, 0.12) !important;
            outline: none !important;
        }

        /* Rich Emerald Theme for profile & disputes requested by user */
        .pattern-emerald {
            background-color: #082318 !important;
            background-image: 
                radial-gradient(at 0% 0%, rgba(20, 80, 52, 0.45) 0px, transparent 55%),
                radial-gradient(at 100% 100%, rgba(166, 138, 104, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 20%, rgba(27, 95, 62, 0.35) 0px, transparent 65%) !important;
            background-attachment: fixed !important;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#FAFBF9] antialiased flex flex-col text-[#4A584F]">
    @php
        $currentRole = request()->is('admin*') ? 'admin' : (request()->is('seller*') ? 'seller' : (request()->is('driver*') ? 'driver' : 'buyer'));
        $cartSession = session('cart', []);
        $cartCount = 0;
        foreach ($cartSession as $c) {
            $cartCount += $c['qty'] ?? 0;
        }
        $authUser = Auth::user() ?? (session('user_id') ? \App\Models\User::find(session('user_id')) : null) ?? \App\Models\User::where('role', $currentRole)->first() ?? \App\Models\User::first();
        $isEmeraldPage = request()->routeIs('*profile*') || request()->routeIs('*dispute*') || request()->is('*profile*') || request()->is('*dispute*');
    @endphp

    <div class="min-h-screen flex">
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex w-64 flex-col fixed inset-y-0 left-0 z-30 bg-white border-r border-[#E5ECE7] p-4">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-1 px-2 py-3 mb-2 group">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo KantinKu" class="h-10 w-auto max-w-[44px] object-contain transition-transform group-hover:scale-105">
                <div>
                    <span class="font-display text-xl font-bold tracking-tight text-[#1A241E]">antin<span class="text-[#2D553D]">Ku</span></span>
                    <span class="block text-[11px] font-medium text-[#76847B] -mt-1">antin Kampus Digital</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="flex-1 space-y-1 overflow-y-auto pr-1">
                @if($currentRole === 'buyer')
                    <a href="{{ route('buyer.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.index') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('buyer.index') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('buyer.canteens') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.canteens*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('buyer.canteens*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Daftar Kantin</span>
                    </a>
                    <a href="{{ route('buyer.menu') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.menu*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('buyer.menu*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>Menu Makanan</span>
                    </a>
                    <a href="{{ route('buyer.cart') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.cart') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('buyer.cart') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Keranjang</span>
                        </div>
                        <span class="cart-badge-count px-2 py-0.5 rounded-full text-xs font-bold bg-[#1F3E2C] text-white {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
                    </a>
                    <a href="{{ route('buyer.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.orders*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('buyer.orders*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span>Pesanan Saya</span>
                    </a>
                    <a href="{{ route('buyer.disputes') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.disputes*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('buyer.disputes*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>Sengketa</span>
                    </a>
                    <a href="{{ route('buyer.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('buyer.profile*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('buyer.profile*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @elseif($currentRole === 'seller')
                    <a href="{{ route('seller.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('seller.index') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('seller.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('seller.orders*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span>Pesanan Masuk</span>
                    </a>
                    <a href="{{ route('seller.shop') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('seller.shop*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Warung & Menu</span>
                    </a>
                    <a href="{{ route('seller.payments') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('seller.payments*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Verifikasi Pembayaran</span>
                    </a>
                    <a href="{{ route('seller.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('seller.profile*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @elseif($currentRole === 'driver')
                    <a href="{{ route('driver.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('driver.index') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('driver.deliveries') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('driver.deliveries*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        <span>Tugas Pengantaran</span>
                    </a>
                    <a href="{{ route('driver.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('driver.profile*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @elseif($currentRole === 'admin')
                    <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.index') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.sellers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.sellers*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Persetujuan Penjual</span>
                    </a>
                    <a href="{{ route('admin.shops') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.shops*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Persetujuan Warung</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Pengguna</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.reports*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span>Laporan Digital</span>
                    </a>
                    <a href="{{ route('admin.disputes') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.disputes*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>Sengketa Transaksi</span>
                    </a>
                    <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.logs*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Log Aktivitas</span>
                    </a>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.profile*') ? 'bg-[#E3ECE6] text-[#1F3E2C] font-semibold' : 'text-[#4A584F] hover:bg-[#F1F5F2] hover:text-[#1A241E]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom Tools -->
            <div class="pt-3 border-t border-[#E5ECE7] space-y-1">
                <a href="{{ route('demo.reset') }}" onclick="return confirm('Reset semua data demo KantinKu ke kondisi awal?')" class="flex items-center gap-3 w-full px-3 py-2 rounded-xl text-xs font-semibold text-[#76847B] hover:bg-[#F6F3EF] hover:text-[#1A241E] transition">
                    <svg class="w-4 h-4 text-[#A68A68]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Reset Data Demo</span>
                </a>
                <a href="{{ route('logout') }}" class="flex items-center gap-3 w-full px-3 py-2 rounded-xl text-xs font-semibold text-[#C25454] hover:bg-[#FDF3F3] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 lg:pl-64 flex flex-col min-h-screen {{ $isEmeraldPage ? 'pattern-emerald text-slate-100' : 'bg-[#FAFBF9]' }}">
            <!-- Top Sticky Header -->
            <header class="sticky top-0 z-20 h-16 border-b px-4 sm:px-6 flex items-center justify-between transition-colors {{ $isEmeraldPage ? 'bg-[#082318]/90 border-emerald-900/50 backdrop-blur-md text-white' : 'border-[#E5ECE7] glass-header' }}">
                <!-- Mobile Logo / Toggle -->
                <div class="flex items-center gap-3 lg:hidden">
                    <a href="/" class="flex items-center gap-1.5">
                        <img src="{{ asset($isEmeraldPage ? 'images/logo_white.svg' : 'images/logo.svg') }}" alt="Logo KantinKu" class="h-8 w-auto object-contain">
                        <span class="font-display font-bold {{ $isEmeraldPage ? 'text-white' : 'text-[#1A241E]' }} text-lg">antin<span class="{{ $isEmeraldPage ? 'text-amber-400' : 'text-[#2D553D]' }}">Ku</span></span>
                    </a>
                </div>

                <!-- Top Right Controls -->
                <div class="flex items-center gap-3 ml-auto">
                    @if($currentRole === 'buyer')
                        <a href="{{ route('buyer.cart') }}" class="relative p-2 rounded-xl border transition {{ $isEmeraldPage ? 'text-emerald-200 hover:text-white hover:bg-emerald-900/60 border-emerald-500/20' : 'text-[#4A584F] hover:text-[#1F3E2C] hover:bg-[#E3ECE6] border-transparent hover:border-[#BFD4C7]' }}" title="Keranjang Belanja">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="cart-badge-count absolute top-1 right-1 flex h-4 min-w-[1rem] px-1 items-center justify-center rounded-full bg-emerald-600 text-[10px] font-bold text-white shadow-xs {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
                        </a>
                    @endif

                    <!-- User Pill Profile -->
                    <div class="flex items-center gap-2.5">
                        <img src="{{ $authUser->avatar ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=70' }}" alt="{{ $authUser->name }}" class="w-8 h-8 rounded-full object-cover ring-2 {{ $isEmeraldPage ? 'ring-emerald-400/40' : 'ring-[#BFD4C7]' }} shadow-xs">
                        <div class="hidden sm:block text-left leading-none">
                            <div class="text-xs font-bold {{ $isEmeraldPage ? 'text-white' : 'text-[#1A241E]' }} truncate max-w-[120px]">{{ $authUser->name }}</div>
                            <span class="text-[10px] {{ $isEmeraldPage ? 'text-emerald-300' : 'text-[#76847B]' }} font-medium">{{ ['buyer' => 'Pembeli', 'seller' => 'Penjual', 'driver' => 'Kurir', 'admin' => 'Admin'][$authUser->role] ?? ucfirst($authUser->role) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts Banner (Flash Messages) -->
            @if(session('success'))
                <div class="mx-4 sm:mx-6 mt-4 p-3.5 bg-[#E3ECE6] border border-[#BFD4C7] text-[#173022] rounded-xl flex items-center justify-between text-sm shadow-subtle">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-[#2D553D] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="p-1 rounded-lg hover:bg-[#1F3E2C]/10 text-[#2D553D] hover:text-[#173022] transition" title="Tutup">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="mx-4 sm:mx-6 mt-4 p-3.5 bg-[#FDF3F3] border border-[#F3C5C5] text-[#8A2E2E] rounded-xl flex items-center justify-between text-sm shadow-subtle">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-[#C25454] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('error') ?? ($errors->first() ?? '') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="p-1 rounded-lg hover:bg-[#C25454]/10 text-[#C25454] hover:text-[#8A2E2E] transition" title="Tutup">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto pb-20 lg:pb-12">
                @yield('content')
            </main>

            <!-- Bottom Mobile Navigation Bar -->
            <div class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white border-t border-[#E5ECE7] px-3 py-2 flex items-center justify-around shadow-lg">
                @if($currentRole === 'buyer')
                    <a href="{{ route('buyer.index') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('buyer.index') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('buyer.canteens') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('buyer.canteens*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Kantin</span>
                    </a>
                    <a href="{{ route('buyer.cart') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold relative {{ request()->routeIs('buyer.cart') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="cart-badge-count absolute -top-1 -right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-[#1F3E2C] text-[8px] font-bold text-white {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
                        <span>Keranjang</span>
                    </a>
                    <a href="{{ route('buyer.orders') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('buyer.orders*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span>Pesanan</span>
                    </a>
                @elseif($currentRole === 'seller')
                    <a href="{{ route('seller.index') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('seller.index') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('seller.orders') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('seller.orders*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span>Pesanan</span>
                    </a>
                    <a href="{{ route('seller.shop') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('seller.shop*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Warung</span>
                    </a>
                    <a href="{{ route('seller.profile') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('seller.profile*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @elseif($currentRole === 'driver')
                    <a href="{{ route('driver.index') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('driver.index') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('driver.deliveries') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('driver.deliveries*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        <span>Pengantaran</span>
                    </a>
                    <a href="{{ route('driver.profile') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('driver.profile*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @elseif($currentRole === 'admin')
                    <a href="{{ route('admin.index') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('admin.index') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.sellers') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('admin.sellers*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Penjual</span>
                    </a>
                    <a href="{{ route('admin.shops') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('admin.shops*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Warung</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('admin.reports*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('admin.profile') }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('admin.profile*') ? 'text-[#1F3E2C]' : 'text-[#76847B]' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Profil</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @stack('scripts')
    <!-- KantinKu Vanilla JavaScript (Fetch API & DOM) -->
    <script src="{{ asset('js/kantinku.js') }}"></script>
</body>
</html>
