# Kopi-Nusa — Website UMKM Kopi (PHP Native + Tailwind)

Website UMKM kopi modern, elegan, dan responsif yang dibangun menggunakan **PHP Native (tanpa framework)**, **MySQL**, dan **Tailwind CSS**. Menyajikan tampilan premium seperti brand coffee modern dengan fitur lengkap termasuk dashboard admin dengan CRUD.

---

## Fitur

### Frontend (Website Publik)
- **Landing Page** — hero fullscreen, tentang, produk unggulan, keunggulan, testimoni, artikel, galeri, dan CTA WhatsApp
- **Halaman Produk** — pencarian, filter kategori, sorting, pagination, lazy loading
- **Detail Produk** — galeri gambar, harga, stok, deskripsi, produk terkait, tombol **Pesan WhatsApp**, dan tombol share
- **Tentang Kami** — sejarah, filosofi, proses roasting, visi & misi
- **Artikel** — daftar, detail, dan artikel terkait
- **Kontak** — form kontak (tersimpan ke database), Google Maps, WhatsApp, email, jam operasional
- **Dark Mode** — toggle gelap/terang
- **Animasi AOS**, loading screen, back-to-top, smooth scrolling, skeleton, lightbox galeri

### Dashboard Admin
- Login menggunakan **Session** (`admin` / `admin123`)
- Dashboard dengan kartu statistik
- CRUD lengkap: **Produk, Kategori, Artikel, Galeri, Testimoni, Pesan Masuk, Pengaturan Website**

---

## Teknologi

| Bagian | Teknologi |
|--------|-----------|
| Backend | PHP Native (tanpa framework) |
| Database | MySQL (PDO + prepared statement) |
| Styling | Tailwind CSS (CDN) |
| Icons | Lucide |
| Animasi | AOS (Animate On Scroll) |
| Notifikasi | SweetAlert2, Toast |
| Font | Plus Jakarta Sans |

Tanpa Bootstrap.

---

## Palet Warna

| Peran | Warna | Hex |
|-------|-------|-----|
| Primary | Espresso | `#3E2723` |
| Secondary | Coffee Brown | `#6F4E37` |
| Accent | Copper | `#B87333` |
| Background | Cream | `#F8F4EC` |
| Success | Olive | `#6B7A4A` |

---

## Struktur Folder

```
coffe/
├── admin/                # Dashboard admin (login + CRUD per modul)
│   ├── kategori/
│   ├── produk/
│   ├── artikel/
│   ├── galeri/
│   ├── testimoni/
│   ├── pesan/
│   ├── pengaturan/
│   └── layout/           # head, sidebar, topbar, footer admin
├── assets/
│   ├── css/              # style.css
│   ├── js/               # main.js, admin.js
│   └── img/              # placeholder gambar
├── config/               # config.php, database.php (koneksi PDO)
├── includes/             # functions, navbar, footer, head, product-card
├── pages/                # home, produk, detail, tentang, artikel, kontak
├── uploads/              # produk/, artikel/, galeri/ (gambar hasil upload)
├── database.sql          # skema database + data awal
└── index.php             # front controller website publik
```

---

## Instalasi (XAMPP)

1. **Salin folder** proyek ini ke `C:\xampp\htdocs\` (atau jalankan langsung dari lokasi proyek).
2. Mulai **Apache** dan **MySQL** di XAMPP Control Panel.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
4. Import file **`database.sql`** — membuat database `caffe_umkm` beserta tabel & data awal.
   - Alternatif via CLI:
     ```bash
     mysql -u root -p < database.sql
     ```
5. Buka website: **`http://localhost/Kopi-Nusa`** (sesuaikan nama folder).
6. **Dashboard admin**: **`http://localhost/Kopi-Nusa/admin`**

> Jika folder tidak berada di `htdocs/` atau memiliki nama berbeda, sesuaikan `BASE_URL` pada `config/config.php`.

---

## Login Admin

| Field | Nilai |
|-------|-------|
| URL | `/admin` |
| Username | `admin` |
| Password | `admin123` |

---

## Keamanan

- **PDO Prepared Statement** — cegah SQL Injection
- **Escape Output** (`htmlspecialchars`) — cegah XSS
- **Validasi Input** dan **Upload aman** (validasi tipe MIME via `finfo`, maksimal **2 MB**)
- **Session Login** admin
- **CSRF Token** pada semua form admin
- **Password hashing** (`password_hash` / `password_verify`)

---

## Integrasi WhatsApp

Tombol **"Pesan Sekarang"** di detail produk membuka WhatsApp dengan pesan otomatis:

```
Halo Admin,
Saya tertarik dengan produk berikut.

Nama Produk: ...
Harga: ...

Apakah produk ini masih tersedia?

Terima kasih.
```

Nomor WhatsApp admin dapat diubah melalui **Admin → Pengaturan Website**.

---

## Lisensi

Proyek ini dibuat untuk kebutuhan UMKM. Silakan gunakan dan kembangkan sesuai kebutuhan Anda.