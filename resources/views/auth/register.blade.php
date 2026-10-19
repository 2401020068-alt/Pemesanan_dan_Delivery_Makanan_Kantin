<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - KantinKu</title>
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
    <div class="w-full max-w-lg mx-auto flex items-center justify-between mb-4">
        <a href="/" class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-200/80 hover:text-white bg-emerald-950/60 hover:bg-emerald-900/80 border border-emerald-500/20 px-3.5 py-1.5 rounded-full backdrop-blur-md transition-all shadow-sm active:scale-95">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Main Content Container -->
    <div class="sm:mx-auto sm:w-full sm:max-w-lg my-auto">
        <!-- Logo and Heading -->
        <div class="text-center mb-6">
            <a href="/" class="inline-flex items-center justify-center gap-1.5 group mb-3">
                <img src="{{ asset('images/logo_white.svg') }}" alt="Logo KantinKu" class="h-12 w-auto max-w-[50px] object-contain transition-transform group-hover:scale-105 drop-shadow-md">
                <span class="font-display text-3xl font-extrabold tracking-tight text-white drop-shadow-sm">antin<span class="text-amber-400">Ku</span></span>
            </a>
            <h2 class="font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-white drop-shadow-md">Buat Akun Baru</h2>
            <p class="mt-1.5 text-xs sm:text-sm text-emerald-200/80 font-medium">Bergabunglah dengan ekosistem kantin kampus digital.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/95 backdrop-blur-xl py-8 px-6 shadow-2xl shadow-black/40 border border-emerald-100/60 rounded-3xl sm:px-9 text-slate-800">
            <!-- Server Error Alert -->
            @if($errors->any())
                <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl font-medium shadow-sm">
                    <div class="flex items-center gap-2 font-bold mb-1.5 text-rose-900">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>Peringatan Pendaftaran:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 text-rose-700 pl-1">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Client-Side Alert Banner -->
            <div id="clientAlert" class="hidden mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl font-medium shadow-sm">
                <div class="flex items-center gap-2 font-bold mb-1.5 text-rose-900">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Peringatan:</span>
                </div>
                <ul id="clientAlertList" class="list-disc list-inside space-y-1 text-rose-700 pl-1"></ul>
            </div>

            <form id="registerForm" action="{{ route('register') }}" method="POST" class="space-y-4" novalidate>
                @csrf
                <div>
                    <label for="nameInput" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="name" id="nameInput" required value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="w-full rounded-xl border {{ $errors->has('name') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-slate-50/60' }} pl-10 pr-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                    </div>
                    @error('name')
                        <p class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="emailInput" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" id="emailInput" required value="{{ old('email') }}" placeholder="nama@email.com" class="w-full rounded-xl border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-slate-50/60' }} pl-10 pr-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                    </div>
                    @error('email')
                        <p class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phoneInput" class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp / HP <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <input type="tel" name="phone" id="phoneInput" required value="{{ old('phone') }}" placeholder="0812-xxxx-xxxx" class="w-full rounded-xl border {{ $errors->has('phone') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-slate-50/60' }} pl-10 pr-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="roleInput" class="block text-xs font-bold text-slate-700 mb-1.5">Mendaftar Sebagai (Peran) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <select name="role" id="roleInput" required class="w-full rounded-xl border {{ $errors->has('role') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-slate-50/60' }} pl-10 pr-10 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all appearance-none cursor-pointer">
                            <option value="">-- Pilih Peran Akun --</option>
                            <option value="buyer" {{ old('role', 'buyer') === 'buyer' ? 'selected' : '' }}>Pembeli (Mahasiswa / Dosen / Staf)</option>
                            <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>Penjual (Pemilik Warung Kantin)</option>
                            <option value="driver" {{ old('role') === 'driver' ? 'selected' : '' }}>Driver (Kurir Pengantar)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('role')
                        <p class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="passwordInput" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" id="passwordInput" required placeholder="Minimal 6 karakter" class="w-full rounded-xl border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200 bg-slate-50/60' }} pl-10 pr-10 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/15 transition-all">
                        <button type="button" onclick="togglePasswordVisibility('passwordInput', 'eyeIcon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-700/25 transition-all duration-200 active:scale-[0.98] flex items-center justify-center">
                        <span>Daftar Sekarang</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-colors">Login di sini</a>
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

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const alertBox = document.getElementById('clientAlert');
            const alertList = document.getElementById('clientAlertList');
            alertList.innerHTML = '';
            let errors = [];

            const name = document.getElementById('nameInput').value.trim();
            const email = document.getElementById('emailInput').value.trim();
            const phone = document.getElementById('phoneInput').value.trim();
            const role = document.getElementById('roleInput').value.trim();
            const password = document.getElementById('passwordInput').value;

            // 1. Peringatan: Harus diisi semuanya
            if (!name || !email || !phone || !role || !password) {
                errors.push('Peringatan: Semua kolom formulir wajib diisi semuanya sebelum mendaftar.');
            }

            // 2. Peringatan: Email wajib ada '@' baru bisa register
            if (!email) {
                // Already caught by empty check
            } else if (!email.includes('@')) {
                errors.push('Peringatan: Alamat email wajib mengandung tanda "@" baru bisa register.');
            } else if (email.startsWith('@') || email.endsWith('@')) {
                errors.push('Peringatan: Alamat email tidak lengkap. Pastikan terdapat nama pengguna dan nama domain (contoh: nama@email.com).');
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errors.push('Peringatan: Alamat email harus berformat lengkap dengan domain valid (contoh: nama@domain.com).');
            }

            // 3. Password minimal 6 karakter
            if (password && password.length < 6) {
                errors.push('Peringatan: Kata sandi minimal harus 6 karakter.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                errors.forEach(function(msg) {
                    const li = document.createElement('li');
                    li.textContent = msg;
                    alertList.appendChild(li);
                });
                alertBox.classList.remove('hidden');
                window.scrollTo({ top: alertBox.offsetTop - 40, behavior: 'smooth' });
                return false;
            }

            alertBox.classList.add('hidden');
        });
    </script>
</body>
</html>
