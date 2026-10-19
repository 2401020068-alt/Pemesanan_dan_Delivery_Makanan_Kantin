# Dokumentasi Desain Sistem Palet Warna: Earthy Moss Elegance

Dokumen ini merinci sistem palet warna UI/UX untuk website dengan nuansa **Hijau Lumut Elegan (Moss Green & Botanical Luxury)**, diadaptasi langsung dari struktur visual referensi e-commerce kosmetik & perawatan alami. Sistem ini mematuhi prinsip desain **CRAP** (*Contrast, Repetition, Alignment, Proximity*), mengutamakan keterbacaan, kebersihan visual (*cleanliness*), dan bebas dari saturasi berlebih (non-neon).

---

## 1. Filosofi & Arah Visual

* **Tone & Mood**: Organik, bersih, tenang, mewah (*refined luxury*), dan terpercaya.
* **Warna Dasar**: Kombinasi hijau lumut pekat (*deep forest moss*) sebagai jangkar stabilitas, disandingkan dengan sage lembut (*soft botanical wash*) dan latar putih gading (*warm off-white*) untuk memberikan ruang bernapas yang luas (*ample negative space*).
* **Anti-Neon & Natural**: Seluruh saturasi warna dijaga pada spektrum earthy dan natural (tidak ada warna pendar atau high-saturation sintetis).

---

## 2. Palet Warna Utama (Core Palette Tokens)

### A. Dominan: Hijau Lumut (*Moss Spectrum*)
Warna identitas utama yang digunakan pada navigasi penting, tombol aksi (CTA), header kategori, dan elemen penegas.

| Token CSS | Kode HEX | Peran & Penggunaan UI |
| :--- | :--- | :--- |
| `--color-moss-900` | `#173022` | Footer utama, bar atas gelap (*top bar*), teks judul dengan kontras maksimal. |
| `--color-moss-800` | `#1F3E2C` | **Primary Brand Color**: Tombol CTA utama, badge diskon gelap, kartu statistik. |
| `--color-moss-700` | `#2D553D` | State *hover* untuk CTA utama, ikon aksen aktif. |
| `--color-moss-600` | `#3F6E52` | Sub-heading tertentu, outline aktif, tautan teks. |
| `--color-moss-400` | `#709981` | Aksen grafis sekunder, garis ornamen halus. |
| `--color-moss-200` | `#BFD4C7` | Border kartu aktif, garis pemisah lembut bertema sage. |
| `--color-moss-100` | `#E3ECE6` | Background badge diskon terang, container info promo. |
| `--color-moss-50`  | `#F1F5F2` | Background hero shape / kontainer kartu produk ringan. |

---

### B. Netral & Permukaan (*Neutrals & Surfaces*)
Fondasi *cleanliness* agar website terasa lapang, sejuk, dan tidak melelahkan mata.

| Token CSS | Kode HEX | Peran & Penggunaan UI |
| :--- | :--- | :--- |
| `--color-bg-canvas`   | `#FAFBF9` | Latar belakang website menyeluruh (sedikit *warm/sage off-white*). |
| `--color-bg-surface`  | `#FFFFFF` | Permukaan kartu (*cards*), modal, dropdown menu, input field. |
| `--color-bg-muted`    | `#F4F6F4` | Container sekunder (misal: strip sertifikasi fitur / value props). |
| `--color-border-subtle` | `#E5ECE7` | Border antar-kartu, divider garis horizontal tipis (1px). |
| `--color-border-hover`  | `#C8D6CD` | Border ketika cursor diarahkan ke kartu atau kolom form. |

---

### C. Tipografi & Kontras (*Typography Colors*)
Disesuaikan agar teks mudah dibaca dan memiliki hierarki tajam tanpa menggunakan hitam pekat murni (`#000000`).

| Token CSS | Kode HEX | Peran & Penggunaan UI |
| :--- | :--- | :--- |
| `--color-text-main`   | `#1A241E` | Judul utama (H1, H2, H3), label harga, nama produk. |
| `--color-text-body`   | `#4A584F` | Teks paragraf, deskripsi produk, detail artikel blog. |
| `--color-text-muted`  | `#76847B` | Teks penjelas kecil, breadcrumb, tanggal rilis, placeholder input. |
| `--color-text-white`  | `#FFFFFF` | Teks di atas latar belakang Moss 800/900. |

---

### D. Aksen Natural (*Warm Earth & Sand*)
Aksen hangat pelengkap untuk bintang rating, badge sertifikat, atau highlight minor tanpa merusak dominasi hijau lumut.

| Token CSS | Kode HEX | Peran & Penggunaan UI |
| :--- | :--- | :--- |
| `--color-sand-500` | `#A68A68` | Rating bintang, ikon sertifikasi organik, outline subtil. |
| `--color-sand-100` | `#F6F3EF` | Background pill promo bertema hangat ("Glow with Confidence"). |

---

## 3. Sistem Gradasi Lembut (*Clean Ambient Gradients*)

Gradasi diterapkan secara halus (*subtle*) untuk memberi kedalaman tanpa efek visual yang bising atau murahan.

### 1. Hero Ambient Gradient (Latar Hero Section)
Menciptakan ilusi bentuk organik lembut di balik model/produk:
```css
--gradient-hero: radial-gradient(circle at 75% 45%, #E3EBE5 0%, #FAFBF9 70%);
```

### 2. Deep Moss Card Gradient (Kartu Promosi & Footer Accent)
Digunakan pada kartu banner promosi seperti kartu "Save Big on Skincare":
```css
--gradient-moss-card: linear-gradient(145deg, #1F3E2C 0%, #2A533B 100%);
```

### 3. Category Ribbon Gradient
Bar horizontal kategori produk yang memanjang:
```css
--gradient-ribbon: linear-gradient(90deg, #173022 0%, #224732 50%, #173022 100%);
```

### 4. Soft Card Highlight
Gradasi sangat halus untuk kartu berstatus unggulan (*featured*):
```css
--gradient-surface-subtle: linear-gradient(180deg, #FFFFFF 0%, #F5F8F6 100%);
```

---

## 4. Penerapan Prinsip C.R.A.P.

### 1. Contrast (Kontras)
* **High Contrast CTA**: Tombol aksi utama menggunakan latar belakang `--color-moss-800` (`#1F3E2C`) dengan teks putih murni (`#FFFFFF`). Rasio kontras melebihi 9.5:1 (memenuhi standar aksesibilitas WCAG AAA).
* **Text Readability**: Teks isi menggunakan charcoal-moss `--color-text-main` (`#1A241E`) di atas `--color-bg-canvas` (`#FAFBF9`), memastikan keterbacaan tinggi tanpa kesan kaku.
* **Secondary Action**: Tombol sekunder menggunakan background transparan, border tipis `--color-border-hover`, dan teks `--color-moss-800`.

### 2. Repetition (Pengulangan / Konsistensi)
* **Identitas Warna Tombol**: Seluruh tombol interaktif primer di seluruh halaman (Hero, Banner Diskon, Footer Subscribe) memakai konsistensi satu warna: `--color-moss-800`.
* **Badge & Pill Tags**: Seluruh tag kategori/diskon menggunakan format seragam: latar belakang `--color-moss-100` dengan teks `--color-moss-800` berbobot medium (500).
* **Icon Tones**: Semua ikon fungsional (keranjang, pencarian, profil, fitur jaminan) memiliki warna yang seragam yaitu `--color-moss-800` atau `--color-text-body`.

### 3. Alignment (Penyelarasan Melalui Bobot Warna)
* **Keseimbangan Visual**: Bagian atas (top bar) dan bagian bawah (footer) ditutup dengan warna terdalam (`--color-moss-900`), menciptakan bingkai simetris yang kokoh.
* **Card Hierarchy**: Kontainer promosi berdampingan dibuat seimbang secara optik: kartu pertama menggunakan warna terang (`--color-moss-100` / sand), kartu kedua menggunakan warna gelap (`--color-moss-800`), menciptakan ritme visual yang beraturan (*balanced dual-tone*).

### 4. Proximity (Kedekatan & Pengelompokan)
* **Section Grouping**: Pengelompokan elemen terkait (seperti 4 pilar layanan: Free Shipping, Organic, Cruelty Free, dsb.) ditempatkan di dalam kontainer berlatar `--color-bg-muted` (`#F4F6F4`) untuk membedakannya secara alami dari area produk tanpa garis tebal.
* **Floating Chips**: Chip informasi (seperti "Fast Delivery", "Natural Ingredients") menggunakan latar putih bersih dengan bayangan lembut (*soft blur elevation*) untuk memberi kesan kedekatan langsung dengan visual produk.

---

## 5. Variabel CSS Siap Pakai (`tokens.css`)

```css
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
  --grad-hero: radial-gradient(circle at 75% 45%, #E3ECE6 0%, #FAFBF9 70%);
  --grad-card-moss: linear-gradient(145deg, #1F3E2C 0%, #2A533B 100%);
  --grad-ribbon: linear-gradient(90deg, #173022 0%, #224732 50%, #173022 100%);

  /* Shadows (Natural & Soft) */
  --shadow-subtle: 0 4px 16px rgba(23, 48, 34, 0.04);
  --shadow-float: 0 8px 24px rgba(23, 48, 34, 0.08);
}
```

---

## 6. Panduan Implementasi Komponen UI

* **Header & Topbar**:
  * Top Announcement Bar: Latar `--moss-900`, teks `--text-inverse`.
  * Main Navbar: Latar `--canvas-bg` atau `--surface-card`, teks tautan navigasi `--text-heading` (hover: `--moss-700`).
* **Kategori Ribbon Bar**:
  * Latar `--grad-ribbon`, teks & ikon monokrom putih bersih (`#FFFFFF`).
* **Kartu Produk / Blog**:
  * Kartu dasar: Latar `--surface-card`, border 1px solid `--border-light`, border-radius: `16px`.
  * Bayangan: `--shadow-subtle`.
* **Input Newsletter & Formulir**:
  * Field input: Latar `--surface-card`, border `--border-light`, teks `--text-heading`, placeholder `--text-muted`.
  * Tombol Subscribe: Latar `--moss-800`, teks `--text-inverse` (hover: `--moss-700`).
* **Footer**:
  * Latar `--moss-900`, teks judul `--text-inverse`, teks tautan dan deskripsi `--moss-200`, sub-footer divider line: `rgba(255, 255, 255, 0.08)`.
