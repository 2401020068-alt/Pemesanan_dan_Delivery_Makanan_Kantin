# LAPORAN TUGAS BESAR PEMROGRAMAN WEB (SEMESTER 5)
## SISTEM INFORMASI & PEMESANAN KANTIN KAMPUS DIGITAL ("KANTINKU") BERBASIS FRAMEWORK LARAVEL

---

### IDENTITAS PROYEK
- **Mata Kuliah:** Pemrograman Web
- **Semester:** 5 (Ganjil)
- **Nama Aplikasi:** KantinKu (Kantin Kampus Digital)
- **Framework Utama:** Laravel Framework (PHP 8.2+)
- **Arsitektur:** Model-View-Controller (MVC)
- **Basis Data:** Relational Database (SQLite / MySQL)
- **Frontend & Styling:** Blade Templating Engine & Tailwind CSS

---

## DAFTAR ISI
1. [BAB I: PENDAHULUAN](#bab-i-pendahuluan)
   - 1.1 Latar Belakang
   - 1.2 Rumusan Masalah
   - 1.3 Tujuan Pengembangan
   - 1.4 Batasan Masalah
2. [BAB II: LANDASAN TEORI & TEKNOLOGI](#bab-ii-landasan-teori--teknologi)
   - 2.1 Framework Laravel
   - 2.2 Pola Perancangan Model-View-Controller (MVC)
   - 2.3 Blade Templating Engine
   - 2.4 Object Relational Mapping (ORM) Eloquent
   - 2.5 Tailwind CSS & Antarmuka Responsif
3. [BAB III: ANALISIS & PERANCANGAN SISTEM](#bab-iii-analisis--perancangan-sistem)
   - 3.1 Aktor & Hak Akses (Multi-Role)
   - 3.2 Kebutuhan Fungsional
   - 3.3 Use Case Diagram & Alur Proses Bisnis
   - 3.4 Perancangan Basis Data (Entity Relationship)
   - 3.5 Spesifikasi Tabel Basis Data
4. [BAB IV: IMPLEMENTASI SISTEM DENGAN FRAMEWORK LARAVEL](#bab-iv-implementasi-sistem-dengan-framework-laravel)
   - 4.1 Struktur Direktori Proyek Laravel
   - 4.2 Konfigurasi Routing (`routes/web.php`)
   - 4.3 Implementasi Model & Relasi Eloquent
   - 4.4 Implementasi Controller (Business Logic)
   - 4.5 Desain Antarmuka (Blade Views)
5. [BAB V: HASIL & PENGUJIAN SISTEM](#bab-v-hasil--pengujian-sistem)
   - 5.1 Tampilan Antarmuka Per Role
   - 5.2 Pengujian Fitur Fungsional (Black-box Testing)
   - 5.3 Modul Laporan & Ekspor CSV
6. [BAB VI: PENUTUP](#bab-vi-penutup)
   - 6.1 Kesimpulan
   - 6.2 Saran Pengembangan
7. [PANDUAN MENJALANKAN SISTEM](#panduan-menjalankan-sistem)

---

## BAB I: PENDAHULUAN

### 1.1 Latar Belakang
Kantin kampus merupakan pusat aktivitas konsumsi bagi mahasiswa, dosen, dan staf pengajar. Pada jam-jam istirahat pergantian mata kuliah, antrean pada warung kantin kerap padat, memicu keterlambatan kembali ke ruang kelas, ketidakefisienan pemesanan, dan pencatatan transaksi yang rentan luput karena masih menggunakan metode manual.

Untuk mengatasi permasalahan tersebut, dikembangkan **KantinKu**, sebuah platform sistem informasi pemesanan kantin terintegrasi multi-peran (Pembeli, Penjual Warung, Driver Pengantar Kampus, dan Administrator Sistem) yang memungkinkan mahasiswa memesan makanan favorit dari ruang kelas, melakukan pembayaran digital berbasis QRIS/Transfer Bank, serta memantau pengantaran makanan secara bertahap (real-time tracking).

### 1.2 Rumusan Masalah
1. Bagaimana mengintegrasikan 4 peran pengguna (Pembeli, Penjual, Driver, dan Admin) dalam satu sistem web terpadu?
2. Bagaimana membangun struktur web yang rapi, modular, dan terstruktur sesuai kaidah framework Laravel?
3. Bagaimana menyajikan pelaporan omset warung dan ekspor rekapitulasi data transaksi secara akurat dan transparan?

### 1.3 Tujuan Pengembangan
1. Membangun aplikasi web kantin kampus digital berbasis framework PHP Laravel dengan prinsip MVC (*Model-View-Controller*).
2. Memfasilitasi alur transaksi lengkap mulai dari katalog warung, pemesanan, verifikasi pembayaran, proses masak di dapur, pengantaran oleh kurir internal, hingga penyelesaian pesanan dan penanganan sengketa.
3. Menyediakan dashboard dan laporan keuangan digital bagi pengelola kampus untuk memantau performa tiap warung.

### 1.4 Batasan Masalah
1. Sistem dikhususkan untuk area kampus (antar fakultas/gedung perkuliahan).
2. Ongkos kirim dihitung flat antar gedung kampus (Rp 3.000).
3. Pengelolaan data mendukung mode demo interaktif dengan fitur *1-click role switcher* dan *reset data demo* untuk kebutuhan penilaian praktikum dan presentasi pengujian.

---

## BAB II: LANDASAN TEORI & TEKNOLOGI

### 2.1 Framework Laravel
Laravel adalah kerangka kerja aplikasi web PHP berskala enterprise yang mengedepankan sintaks ekspresif, keamanan tinggi, dan ekosistem modern. Laravel menyediakan fitur bawaan penting seperti routing cerdas, *dependency injection container*, migrasi skema basis data (*database migrations*), dan sistem seeder.

### 2.2 Pola Perancangan Model-View-Controller (MVC)
- **Model:** Menangani struktur data dan logika bisnis melalui Eloquent ORM (`User`, `Shop`, `MenuItem`, `Order`, `OrderItem`, `Dispute`, `ActivityLog`).
- **View:** Menyajikan antarmuka visual kepada pengguna menggunakan Blade Templating Engine (`resources/views/`).
- **Controller:** Menerima *HTTP request*, memproses validasi, berinteraksi dengan model, dan mengembalikan respon view atau redirect (`app/Http/Controllers/`).

### 2.3 Blade Templating Engine
Blade adalah template engine bawaan Laravel yang memungkinkan pemanfaatan *layout inheritance* (`@extends`, `@section`, `@yield`), komponen parsial, dan kontrol alur yang bersih tanpa overhead performa.

### 2.4 Object Relational Mapping (ORM) Eloquent
Eloquent memetakan tabel basis data ke dalam kelas PHP berorientasi objek, memungkinkan manipulasi relasi seperti `hasMany`, `belongsTo`, dan `hasOne` secara intuitif tanpa menulis query SQL mentah.

### 2.5 Tailwind CSS & Antarmuka Responsif
Styling aplikasi dirancang menggunakan utility-first Tailwind CSS dengan palet warna bernuansa Emerald Green (`#059669`) dan Warm Amber (`#f59e0b`), tipografi modern Google Fonts (*Plus Jakarta Sans* dan *Inter*), serta ikon berbasis SVG murni (Feather/Lucide style) yang rapi, profesional, dan bebas dari distorsi ikon generik AI slop.

---

## BAB III: ANALISIS & PERANCANGAN SISTEM

### 3.1 Aktor & Hak Akses (Multi-Role)
Sistem memiliki 4 entitas pengguna:
1. **Pembeli (Buyer / Mahasiswa):** Menjelajahi kantin, memilih menu, mengelola keranjang belanja, melakukan checkout, mengunggah bukti pembayaran QRIS/Transfer, melacak progres pesanan, mengajukan sengketa (*dispute*), dan mengedit profil.
2. **Penjual (Seller / Warung Kantin):** Mengatur informasi warung (jam operasional, status buka/tutup), menambah/mengedit/menghapus menu makanan, memverifikasi bukti transfer pembayaran, dan memperbarui status pesanan dapur (dimasak, siap diambil).
3. **Driver (Kurir Kampus):** Mengambil pesanan yang siap diantar dari dapur warung, memperbarui status pengantaran menuju lokasi gedung pembeli, dan mengonfirmasi penyelesaian tugas antar.
4. **Admin (Pengelola Sistem):** Menyetujui pendaftaran akun penjual dan warung baru, memantau daftar pengguna, menyelesaikan mediasi sengketa, melihat log audit aktivitas sistem, serta memantau dan mengekspor laporan transaksi ke format CSV.

### 3.2 Spesifikasi Tabel Basis Data
Sistem menggunakan 7 tabel relasional utama:
- `users`: Menyimpan identitas akun (`id`, `name`, `email`, `password`, `phone`, `role`, `status`, `approval`, `avatar`, `address`).
- `shops`: Menyimpan data warung (`id`, `owner_id`, `name`, `description`, `image`, `location`, `hours`, `open`, `approval`, `submitted`).
- `menu_items`: Menyimpan item menu (`id`, `shop_id`, `name`, `description`, `category`, `price`, `image`, `available`).
- `orders`: Menyimpan kepala transaksi pesanan (`id`, `trx_id`, `buyer_id`, `shop_id`, `driver_id`, `subtotal`, `delivery_fee`, `total`, `address`, `note`, `payment_method`, `payment_status`, `proof`, `status`, `delivery_status`).
- `order_items`: Menyimpan rincian item pesanan (`id`, `order_id`, `menu_id`, `name`, `price`, `qty`, `image`).
- `disputes`: Menyimpan laporan komplain/sengketa (`id`, `order_id`, `buyer_id`, `issue`, `description`, `proof`, `status`, `resolution`).
- `activity_logs`: Menyimpan jejak audit sistem (`id`, `time`, `admin`, `action`, `target`, `status`).

---

## BAB IV: IMPLEMENTASI SISTEM DENGAN FRAMEWORK LARAVEL

### 4.1 Struktur Direktori Proyek
Proyek terstruktur mengikuti standar resmi framework Laravel:
```text
kantinku/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php      # Autentikasi & demo role switcher
│   │       ├── LandingController.php   # Beranda publik & showcase peran
│   │       ├── BuyerController.php     # Fitur belanja, keranjang & tracking
│   │       ├── SellerController.php    # Manajemen warung, menu & pesanan
│   │       ├── DriverController.php    # Pengantaran & update progres kurir
│   │       ├── AdminController.php     # Approval, user, dispute & laporan
│   │       └── DemoController.php      # Reset basis data demo 1-klik
│   └── Models/
│       ├── User.php
│       ├── Shop.php
│       ├── MenuItem.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Dispute.php
│       └── ActivityLog.php
├── database/
│   ├── migrations/                     # Skema tabel terstruktur
│   └── seeders/
│       └── DatabaseSeeder.php          # Data awal siap saji (11 user, 6 warung, 14 menu, dll)
├── public/
│   ├── index.php                       # Titik masuk utama aplikasi Laravel
│   └── .htaccess                       # URL rewriting Apache
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Master layout responsif + SVG icon
│       ├── auth/                       # Login & Register
│       ├── buyer/                      # Antarmuka Pembeli (7 view)
│       ├── seller/                     # Antarmuka Penjual (6 view)
│       ├── driver/                     # Antarmuka Driver (3 view)
│       ├── admin/                      # Antarmuka Admin (7 view)
│       └── landing.blade.php           # Landing page publik
├── routes/
│   └── web.php                         # 63 endpoint rute aplikasi
├── artisan                             # CLI tool Laravel
├── composer.json                       # Dependensi resmi PHP
└── .env                                # Konfigurasi lingkungan aplikasi
```

### 4.2 Endpoint Routing Utama (`routes/web.php`)
- **Publik:** `/` (Landing), `/login`, `/register`, `/logout`, `/switch-role/{role}`, `/demo/reset`
- **Pembeli:**
  - `GET /buyer` - Katalog beranda
  - `GET /buyer/canteens` & `/buyer/canteens/{id}` - Daftar & detail warung
  - `GET /buyer/cart` & `POST /buyer/cart/add` - Keranjang belanja
  - `GET /buyer/checkout` & `POST /buyer/checkout` - Checkout transaksi
  - `GET /buyer/payment/{id}` & `POST /buyer/payment/{id}` - Pembayaran QRIS/Transfer
  - `GET /buyer/orders` & `/buyer/orders/{id}` - Pelacakan status 6 tahapan
  - `GET /buyer/disputes` & `POST /buyer/disputes` - Penanganan sengketa
- **Penjual:**
  - `GET /seller` - Dashboard omset warung
  - `GET /seller/orders` & `POST /seller/orders/{id}/status` - Antrean dapur
  - `GET /seller/shop` & `POST /seller/menu` - Manajemen menu & warung
  - `GET /seller/payments` & `POST /seller/payments/{id}` - Verifikasi pembayaran
- **Driver:**
  - `GET /driver` - Dashboard pengantaran
  - `GET /driver/deliveries` & `POST /driver/deliveries/{id}/take` - Ambil tugas
  - `POST /driver/deliveries/{id}/status` - Update status antar
- **Admin:**
  - `GET /admin` - Dashboard metrik kampus
  - `GET /admin/sellers` & `GET /admin/shops` - Persetujuan pendaftaran
  - `GET /admin/users` - Kelola status pengguna
  - `GET /admin/reports` & `GET /admin/reports/export` - Laporan & Ekspor CSV
  - `GET /admin/disputes` - Mediasi sengketa
  - `GET /admin/logs` - Log audit

---

## BAB V: HASIL & PENGUJIAN SISTEM

### 5.1 Desain Tampilan Web
1. **Desain Bersih & Elegan:** Menggunakan kombinasi warna hijau emerald profesional, kartu berbayang halus (*soft card shadow*), dan *micro-interaction hover*.
2. **Ikon Standar SVG (Non-AI Slop):** Seluruh visualisasi menggunakan ikon vektor murni dengan garis konsisten (stroke 2px) seperti keranjang belanja, warung, truk pengantar, perisai admin, dan jam operasional.
3. **Role Switcher & Demo Tools:** Tersedia pemilih peran instan pada header desktop dan mobile, memungkinkan dosen penguji beralih dari Pembeli ke Penjual, Driver, atau Admin tanpa perlu logout berulang kali.

### 5.2 Pengujian Fungsionalitas
| No | Skenario Uji | Tindakan | Hasil yang Diharapkan | Status |
|---|---|---|---|---|
| 1 | Autentikasi / Demo Switcher | Memilih "Penjual (Bu Siti)" di dropdown | Sistem langsung mengalihkan ke `/seller` dengan data Bu Siti | Sukses |
| 2 | Tambah ke Keranjang | Mengklik "+ Pesan" pada menu Nasi Goreng | Jumlah keranjang di header bertambah otomatis | Sukses |
| 3 | Checkout & Buat Pesanan | Mengisi alamat gedung dan memilih metode QRIS | Pesanan tersimpan di basis data dengan ID `ORD-xxxx` | Sukses |
| 4 | Upload Bukti Bayar | Mengirimkan bukti transfer di halaman pembayaran | Status pembayaran berubah menjadi `pending` | Sukses |
| 5 | Verifikasi Penjual | Penjual mengklik "Verifikasi" pada bukti bayar | Status pesanan otomatis beralih menjadi `paid` | Sukses |
| 6 | Pengantaran Driver | Driver mengklik "Ambil Tugas Pengantaran" | Pesanan tercatat ke nama driver bersangkutan | Sukses |
| 7 | Mediasi Sengketa | Admin menyelesaikan komplain dengan solusi | Status sengketa berubah menjadi `resolved` | Sukses |
| 8 | Ekspor Laporan CSV | Mengklik tombol "Ekspor CSV" di `/admin/reports` | Browser mengunduh file `laporan-transaksi-kantinku.csv` | Sukses |
| 9 | Reset Data Demo | Mengklik tombol "Reset Data Demo" di sidebar | Database di-seed ulang ke data awal secara bersih | Sukses |

---

## BAB VI: PENUTUP

### 6.1 Kesimpulan
Proyek pengembangan aplikasi **KantinKu** telah berhasil dikonversi dan diimplementasikan secara menyeluruh menggunakan kerangka kerja **Laravel Framework**. Seluruh arsitektur MVC, database migrations, relasi Eloquent ORM, dan sistem routing terintegrasi dengan baik. Fitur utama di keempat peran (Pembeli, Penjual, Driver, Admin) berfungsi tanpa kehilangan satu fitur pun dari spesifikasi aslinya, dengan antarmuka yang jauh lebih menarik, rapi, responsif, dan menggunakan ikon vektor standar berkualitas tinggi.

### 6.2 Saran Pengembangan
1. Integrasi dengan Payment Gateway otomatis (misal Midtrans/Xendit) untuk verifikasi pembayaran QRIS tanpa konfirmasi manual.
2. Penambahan notifikasi pesan instan WhatsApp Gateway kepada pembeli saat makanan selesai dimasak.

---

## PANDUAN MENJALANKAN SISTEM

### Prasyarat
- PHP versi 8.2 atau lebih baru
- Ekstensi PHP: `pdo_sqlite` (atau `pdo_mysql`), `mbstring`, `openssl`, `curl`
- Web Browser modern (Chrome, Edge, Firefox)

### Langkah-langkah
1. **Buka Terminal / PowerShell di direktori proyek:**
   ```bash
   cd "D:\SEMESTER 5\PEMROGRAMAN WEB\kantinku"
   ```
2. **Jalankan server lokal Laravel:**
   ```bash
   php artisan serve
   ```
3. **Buka di browser:**
   Akses alamat: `http://127.0.0.1:8000`
4. **Akun Uji Demo:**
   - **Admin:** `admin@kantinku.ac.id` (Password: `password123`) atau via role switcher
   - **Pembeli:** `andi@student.ac.id` (Password: `password123`) atau via role switcher
   - **Penjual:** `siti@warung.id` (Password: `password123`) atau via role switcher
   - **Driver:** `budi.driver@kantinku.ac.id` (Password: `password123`) atau via role switcher
