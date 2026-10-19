# KantinKu - Sistem Informasi & Pemesanan Kantin Kampus Digital

Sistem aplikasi web pemesanan makanan kantin kampus terpadu berbasis **Laravel Framework** (PHP) dengan arsitektur **Model-View-Controller (MVC)** dan antarmuka responsif **Tailwind CSS**.

---

## 🌟 Fitur Utama Berdasarkan Peran

### 1. Pembeli (Mahasiswa / Dosen / Staf)
- **Katalog Kantin & Menu:** Jelajahi warung kantin aktif dan filter kategori (Makanan, Minuman, Camilan).
- **Keranjang Belanja:** Manajemen kuantitas pesanan multi-item per warung.
- **Checkout & Pengantaran:** Input alamat gedung kampus dan catatan pesanan khusus.
- **Pembayaran Fleksibel:** Dukungan pembayaran QRIS instan, Transfer Bank, dan upload bukti bayar.
- **Live Order Tracking (6 Tahap):** Pantau status pesanan mulai dari Dibuat &rarr; Dibayar &rarr; Dimasak &rarr; Siap &rarr; Diantar Driver &rarr; Selesai Diterima.
- **Sistem Sengketa / Komplain:** Layanan bantuan jika pesanan tidak sesuai atau kendala transfer.

### 2. Penjual (Pemilik Warung Kantin)
- **Dashboard Omset:** Pantau pendapatan harian, pesanan perlu diproses, dan pesanan selesai.
- **Manajemen Warung:** Pengaturan jam operasional, lokasi blok kantin, dan tombol buka/tutup warung.
- **Kelola Menu Makanan:** Tambah menu baru, edit harga/deskripsi, dan status ketersediaan.
- **Antrean Dapur:** Update status pesanan dari antrean masak hingga siap diantar.
- **Verifikasi Pembayaran:** Cek dan validasi screenshot bukti transfer dari pembeli.

### 3. Driver (Kurir Pengantar Kampus)
- **Dashboard Pengantaran:** Pantau tugas pengantaran aktif dan pesanan siap diambil.
- **Ambil Tugas:** Ambil pesanan yang telah selesai dimasak di dapur kantin.
- **Update Status Antar:** Perbarui status pengantaran menuju gedung dan konfirmasi serah-terima.

### 4. Admin (Pengelola Sistem Kampus)
- **Metrik Sistem:** Pemantauan menyeluruh total omset, transaksi, dan warung aktif.
- **Persetujuan Akun & Warung:** Verifikasi pendaftaran penjual dan pembukaan warung kantin.
- **Manajemen Pengguna:** Kontrol status akun aktif/nonaktif.
- **Laporan Transaksi & Ekspor CSV:** Unduh rekapitulasi data pesanan dalam format Excel/CSV.
- **Mediasi Sengketa:** Tanggapi dan selesaikan komplain pembeli/penjual.
- **Log Audit Sistem:** Rekam jejak seluruh aktivitas administratif.

---

## 🚀 Cara Menjalankan Aplikasi

### Prasyarat:
- PHP 8.2 atau lebih tinggi
- Composer
- Ekstensi PHP: `pdo_sqlite` (atau `pdo_mysql`), `mbstring`, `openssl`, `curl`

### Langkah Menjalankan:
1. Pastikan dependensi terpasang:
   ```bash
   composer install
   ```
2. Pastikan file `.env` dan database siap:
   ```bash
   php artisan migrate:fresh --seed
   ```
3. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
4. Buka di browser:
   `http://localhost:8000`

---

## 👤 Akun Demo Siap Pakai

Gunakan **Dropdown Peran di Header** atau login dengan akun berikut (Password: `password123`):
- **Admin:** `admin@kantinku.ac.id`
- **Pembeli:** `andi@student.ac.id`
- **Penjual:** `siti@warung.id`
- **Driver:** `budi.driver@kantinku.ac.id`

---

## 📄 Laporan Proyek
Dokumentasi lengkap proyek kuliah untuk Semester 5 dapat dilihat pada berkas [LAPORAN_PROYEK.md](LAPORAN_PROYEK.md).
