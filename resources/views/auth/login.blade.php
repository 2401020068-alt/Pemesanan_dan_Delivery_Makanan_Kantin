<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KantinKu</title>
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
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #031c12;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.18) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(245, 158, 11, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(5, 150, 105, 0.15) 0px, transparent 60%);
            background-attachment: fixed;
        }
        .pattern-overlay {
            background-image: radial-gradient(rgba(16, 185, 129, 0.12) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="min-h-screen text-slate-100 flex flex-col justify-between py-8 px-4 sm:px-6 lg:px-8 relative pattern-overlay antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Top Bar: Back to Home -->
    <div class="w-full max-w-md mx-auto flex items-center justify-between mb-4">
        <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200/80 hover:text-white bg-emerald-950/60 hover:bg-emerald-900/80 border border-emerald-500/20 px-3.5 py-1.5 rounded-full backdrop-blur-md transition-all shadow-sm active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Main Content Container -->
    <div class="sm:mx-auto sm:w-full sm:max-w-md my-auto">
        <!-- Logo and Heading -->
        <div class="text-center mb-6">
            <a href="/" class="inline-flex items-center justify-center gap-1.5 group mb-3">
                <img src="{{ asset('images/logo_white.svg') }}" alt="Logo KantinKu" class="h-12 w-auto max-w-[50px] object-contain transition-transform group-hover:scale-105 drop-shadow-md">
                <span class="font-display text-3xl font-extrabold tracking-tight text-white drop-shadow-sm">antin<span class="text-amber-400">Ku</span></span>
            </a>
            <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-white drop-shadow-md">Login ke Akun Anda</h2>
            <p class="mt-1.5 text-xs sm:text-sm text-emerald-200/80 font-medium">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/95 backdrop-blur-xl py-8 px-6 shadow-2xl shadow-black/40 border border-emerald-100/60 rounded-3xl sm:px-9 text-slate-800">
            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium flex items-center gap-2.5 shadow-sm">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-xl font-medium flex items-start gap-2.5 shadow-sm">
                    <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="emailInput" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" id="emailInput" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full rounded-xl border border-slate-200 bg-slate-50/60 pl-10 pr-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                    </div>
                </div>

                <div>
                    <label for="passwordInput" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" id="passwordInput" required placeholder="Masukkan kata sandi" class="w-full rounded-xl border border-slate-200 bg-slate-50/60 pl-10 pr-10 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                        <button type="button" onclick="togglePasswordVisibility('passwordInput', 'eyeIcon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/25 transition-all duration-200 active:scale-[0.98] flex items-center justify-center">
                        <span>Login Sekarang</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
                Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">Daftar Akun Baru</a>
            </div>
        </div>
    </div>

    <!-- Footer Copyright -->
    <div class="text-center text-xs text-emerald-300/40 mt-6">
        &copy; 2026 KantinKu Platform Pemesanan Kantin Kampus Digital.
    </div>

    <script>
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
    </script>
</body>
</html>
