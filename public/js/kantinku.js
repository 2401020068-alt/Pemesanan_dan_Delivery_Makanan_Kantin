/**
 * KantinKu - Vanilla JavaScript (Fetch API & DOM Manipulation)
 * Standar Silabus RPS Pemrograman Web (Pertemuan 5: JavaScript Modern & Asinkron)
 * 
 * Fitur:
 * 1. Manipulasi DOM (Document Object Model)
 * 2. Event Handling (addEventListener, preventDefault)
 * 3. Asynchronous Programming (Fetch API, async/await, Promise, JSON)
 * 4. Interaktivitas Dinamis Keranjang Belanja & Toast Notification tanpa reload halaman
 */

document.addEventListener('DOMContentLoaded', function () {
    console.log('[KantinKu] Vanilla JS Engine aktif.');

    // 1. Ambil CSRF Token dari meta tag HTML
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

    // 2. Fungsi Toast Notification Dinamis (Manipulasi DOM Murni)
    function showToast(message, type = 'success') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-20 right-4 sm:right-6 z-50 flex flex-col gap-2.5 pointer-events-none max-w-sm w-full';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto transform translate-y-2 opacity-0 transition-all duration-300 ease-out flex items-center gap-3 p-4 rounded-2xl shadow-xl text-xs font-semibold backdrop-blur-md border';

        if (type === 'success') {
            toast.classList.add('bg-[#1F3E2C]/95', 'text-white', 'border-white/20');
            toast.innerHTML = `
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/20 text-emerald-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="flex-1">${message}</div>
                <button type="button" class="text-white/60 hover:text-white transition ml-1" onclick="this.parentElement.remove()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
        } else {
            toast.classList.add('bg-rose-900/95', 'text-white', 'border-rose-500/30');
            toast.innerHTML = `
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/20 text-rose-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="flex-1">${message}</div>
                <button type="button" class="text-white/60 hover:text-white transition ml-1" onclick="this.parentElement.remove()">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
        }

        container.appendChild(toast);

        // Animasi masuk (Fade In & Slide Up)
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });

        // Hapus otomatis setelah 3,5 detik
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    // 3. Fungsi Pembaruan Badge Keranjang di Seluruh DOM (Desktop & Mobile)
    function updateCartBadges(count) {
        const badges = document.querySelectorAll('.cart-badge-count');
        badges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.classList.remove('hidden');
                // Micro-animation "pop" saat angka berubah
                badge.animate([
                    { transform: 'scale(0.8)' },
                    { transform: 'scale(1.2)' },
                    { transform: 'scale(1)' }
                ], { duration: 250 });
            } else {
                badge.classList.add('hidden');
            }
        });
    }

    // 4. Intercept Form Penambahan Keranjang Belanja secara Asinkron (Fetch API)
    const cartForms = document.querySelectorAll('form[action*="cart/add"], form.ajax-cart-form');
    cartForms.forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Mencegah reload halaman standar browser

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            const menuIdInput = form.querySelector('input[name="menu_id"]');
            const qtyInput = form.querySelector('input[name="qty"]');

            const menuId = menuIdInput ? menuIdInput.value : '';
            const qty = qtyInput ? qtyInput.value : 1;

            if (!menuId) return;

            // Indikator loading halus pada tombol
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-1 h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>...</span>
                `;
            }

            try {
                // Memanggil REST API endpoint secara asinkron dengan Fetch API
                const response = await fetch('/api/v1/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        menu_id: menuId,
                        qty: qty
                    })
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    // Update DOM Badge & Tampilkan Toast
                    updateCartBadges(result.cart_count);
                    showToast(result.message || 'Menu berhasil ditambahkan ke keranjang!', 'success');
                } else {
                    showToast(result.message || 'Gagal menambahkan ke keranjang', 'error');
                }
            } catch (error) {
                console.error('[KantinKu Fetch Error]:', error);
                // Jika request asinkron bermasalah karena koneksi, fallback ke submit form bawaan
                form.submit();
            } finally {
                // Kembalikan tombol ke keadaan semula
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        });
    });

    // Ekspos helper ke window untuk kebutuhan pengujian di browser console
    window.kantinKu = {
        showToast: showToast,
        updateCartBadges: updateCartBadges
    };
});
