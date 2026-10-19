<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinKu - Pesan Makanan Kantin Kampus Online</title>
    <meta name="description" content="Pesan makanan dari kantin kampus, bayar online, dan diantar langsung ke kelas atau ruanganmu.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=4">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=4">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=4">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=4">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=4">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-banner-bg {
            background-image: linear-gradient(to right, rgba(4, 28, 18, 0.95) 0%, rgba(4, 30, 20, 0.88) 42%, rgba(4, 30, 20, 0.3) 65%, rgba(4, 30, 20, 0) 100%), url('{{ asset('images/kantinku_bg_banner.png') }}');
            background-size: cover;
            background-position: right center;
        }
        @media (max-width: 1024px) {
            .hero-banner-bg {
                background-image: linear-gradient(to bottom, rgba(4, 28, 18, 0.92) 0%, rgba(4, 30, 20, 0.95) 100%), url('{{ asset('images/kantinku_bg_banner.png') }}');
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[#041d13] text-slate-100 antialiased flex flex-col justify-between hero-banner-bg bg-fixed">
    <!-- Navbar -->
    <header class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-6 md:px-8">
        <a href="/" class="flex items-center gap-1.5 group">
            <img src="{{ asset('images/logo_white.svg') }}" alt="Logo KantinKu" class="h-11 w-auto max-w-[48px] object-contain transition-transform group-hover:scale-105 drop-shadow-md">
            <span class="font-display text-2xl font-bold tracking-tight text-white drop-shadow-sm">antin<span class="text-amber-400">Ku</span></span>
        </a>
    </header>

    <!-- Hero Section -->
    <section class="mx-auto grid w-full max-w-7xl items-center gap-12 px-4 py-8 md:grid-cols-12 md:px-8 md:py-16 my-auto">
        <div class="md:col-span-8 lg:col-span-7 xl:col-span-6 z-10">
            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-950/80 px-4 py-2 text-xs sm:text-sm font-semibold text-emerald-300 border border-emerald-500/30 backdrop-blur-md shadow-sm">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Rata-rata sampai 15 menit ke ruang kelas</span>
            </div>

            <h1 class="mt-5 font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-white drop-shadow-lg">
                Makanan kantin kampus, <br class="hidden sm:inline">
                <span class="text-amber-400">diantar ke kelasmu.</span>
            </h1>

            <p class="mt-6 text-base sm:text-lg text-slate-200 leading-relaxed max-w-xl drop-shadow-sm font-medium">
                Pilih menu dari warung kantin favorit, bayar praktis dengan QRIS atau transfer, lalu pantau pesananmu dari dapur sampai tiba di ruangan.
            </p>

            <div class="mt-9 flex flex-wrap gap-4">
                <a href="{{ route('login') }}" class="inline-flex h-13 items-center justify-center rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-600 px-8 py-3.5 text-base font-bold text-white shadow-lg shadow-emerald-500/30 hover:from-emerald-400 hover:to-emerald-500 transition active:scale-95">
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="inline-flex h-13 items-center justify-center rounded-xl border-2 border-white/40 bg-white/10 backdrop-blur-md px-8 py-3.5 text-base font-bold text-white hover:bg-white/20 hover:border-white/70 transition shadow-sm active:scale-95">
                    <span>Register</span>
                </a>
            </div>
        </div>

        <div class="hidden md:block md:col-span-4 lg:col-span-5 xl:col-span-6">
            <!-- Space for food photography on background image to shine through cleanly -->
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-emerald-900/50 bg-[#03150e]/80 backdrop-blur-sm py-6 text-center text-xs text-slate-400">
        <p>&copy; 2026 KantinKu - Proyek Praktikum Pemrograman Web Framework Laravel. Dibuat dengan rapi & terstruktur.</p>
    </footer>
</body>
</html>
