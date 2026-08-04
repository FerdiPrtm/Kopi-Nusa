-- ============================================================
--  WEBSITE UMKM KOPI - DATABASE
--  PHP Native + MySQL
--  Import melalui phpMyAdmin (XAMPP) atau: mysql -u root -p < database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS `caffe_umkm`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `caffe_umkm`;

-- ------------------------------------------------------------
-- Tabel: users (admin login)
-- ------------------------------------------------------------
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','superadmin') NOT NULL DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: kategori
-- ------------------------------------------------------------
CREATE TABLE `kategori` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(120) NOT NULL UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: produk
-- ------------------------------------------------------------
CREATE TABLE `produk` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `kategori_id` INT UNSIGNED NOT NULL,
  `nama` VARCHAR(150) NOT NULL,
  `slug` VARCHAR(180) NOT NULL UNIQUE,
  `deskripsi` TEXT NOT NULL,
  `harga` INT UNSIGNED NOT NULL DEFAULT 0,
  `stok` INT UNSIGNED NOT NULL DEFAULT 0,
  `berat` VARCHAR(30) DEFAULT '250 gram',
  `gambar` VARCHAR(255) NOT NULL,
  `gambar_2` VARCHAR(255) DEFAULT NULL,
  `gambar_3` VARCHAR(255) DEFAULT NULL,
  `best_seller` TINYINT(1) NOT NULL DEFAULT 0,
  `promo` TINYINT(1) NOT NULL DEFAULT 0,
  `diskon` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'persen, hanya jika promo',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`kategori_id`)
    REFERENCES `kategori`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: artikel
-- ------------------------------------------------------------
CREATE TABLE `artikel` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(220) NOT NULL UNIQUE,
  `gambar` VARCHAR(255) DEFAULT NULL,
  `ringkasan` VARCHAR(400) DEFAULT NULL,
  `isi` LONGTEXT NOT NULL,
  `penulis` VARCHAR(100) DEFAULT 'Admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: galeri
-- ------------------------------------------------------------
CREATE TABLE `galeri` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `gambar` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: testimoni
-- ------------------------------------------------------------
CREATE TABLE `testimoni` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(120) NOT NULL,
  `peran` VARCHAR(120) DEFAULT NULL,
  `pesan` TEXT NOT NULL,
  `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5 COMMENT '1-5',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: kontak (pesan masuk)
-- ------------------------------------------------------------
CREATE TABLE `kontak` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `subjek` VARCHAR(200) DEFAULT 'Pertanyaan',
  `pesan` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabel: pengaturan (key/value)
-- ------------------------------------------------------------
CREATE TABLE `pengaturan` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key` VARCHAR(100) NOT NULL UNIQUE,
  `value` LONGTEXT
) ENGINE=InnoDB;

-- ============================================================
--  SEED DATA
-- ============================================================

-- Admin: username = admin, password = admin123
INSERT INTO `users` (`nama`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', '$2y$10$J9tq6MGABAMKDgti0neV7uqyElMjmNytcR6klmC/5cwIljIJ3Qvly', 'superadmin');

-- Kategori
INSERT INTO `kategori` (`nama`, `slug`) VALUES
('Biji Kopi', 'biji-kopi'),
('Kopi Bubuk', 'kopi-bubuk'),
('Kopi Siap Seduh', 'kopi-siap-seduh'),
('Minuman', 'minuman'),
('Peralatan', 'peralatan'),
('Merchandise', 'merchandise');

-- Produk
INSERT INTO `produk` (`kategori_id`, `nama`, `slug`, `deskripsi`, `harga`, `stok`, `berat`, `gambar`, `best_seller`, `promo`, `diskon`) VALUES
(1, 'Green Bean Robusta Lampung', 'green-bean-robusta-lampung', 'Biji kopi robusta pilihan dari perkebunan Lampung dengan karakter bodi kuat, sedikit earthy dan cocoa. Sangat cocok untuk espresso. Proses washed, sorting secara manual untuk kualitas terbaik.', 110000, 40, '500 gram', 'assets/img/placeholder-coffee.svg', 1, 0, 0),
(1, 'Arabika Gayo Full Wash', 'arabika-gayo-full-wash', 'Kopi arabika Gayo dari ketinggian 1200 mdpl dengan proses full washed. Aroma floral, rasa citrus dan hint caramel yang manis. Siap dinikmati untuk metode manual brew.', 150000, 30, '250 gram', 'assets/img/placeholder-coffee.svg', 1, 1, 15),
(2, 'Bubuk Kopi Espresso Home', 'bubuk-kopi-espresso-home', 'Kopi bubuk hasil roast medium-dark yang disesuaikan untuk mesin espresso rumahan. Grind halus siap pakai, crema tebal dan rasa cokelat yang pekat.', 55000, 60, '250 gram', 'assets/img/placeholder-coffee.svg', 1, 0, 0),
(2, 'Bubuk Kopi Tubruk Spesial', 'bubuk-kopi-tubruk-spesial', 'Campuran arabika dan robusta dengan roast medium untuk metode tubruk dan seduh sederhana. Tanpa ampas di mulut, rasa seimbang dan body lembut.', 48000, 75, '200 gram', 'assets/img/placeholder-coffee.svg', 0, 1, 10),
(3, 'V60 Drip Bag Gayo', 'v60-drip-bag-gayo', 'Kopi siap seduh praktis dalam kemasan drip bag. Satu pouch untuk satu cangkir, cocok untuk perjalanan dan kantor. Nikmati kemudahan tanpa alat tambahan.', 35000, 100, '10 gr x 10', 'assets/img/placeholder-coffee.svg', 0, 0, 0),
(3, 'Cold Brew Drip Pack', 'cold-brew-drip-pack', 'Drip pack khusus untuk cold-brew. Rendam dingin selama 12-24 jam, hasilkan kopi dingin yang smooth dengan rasa manis alami.', 42000, 50, '15 gr x 6', 'assets/img/placeholder-coffee.svg', 0, 0, 0),
(4, 'Es Kopi Susu Kemasan', 'es-kopi-susu-kemasan', 'Minuman kopi susu siap minum dalam kemasan botol. Perpaduan espresso dan susu segar dengan gula aren asli. Dinginkan atau tambahkan es batu.', 15000, 200, '200 ml', 'assets/img/placeholder-coffee.svg', 1, 1, 10),
(5, 'Manual Coffee Grinder', 'manual-coffee-grinder', 'Penggilingan kopi manual portable berbahan keramik burr. Konsisten dalam pengaturan kasar-halus, praktis untuk dibawa ke mana saja.', 250000, 15, 'Unit', 'assets/img/placeholder-coffee.svg', 0, 0, 0),
(6, 'Tumbler Kopi Limited', 'tumbler-kopi-limited', 'Tumbler premium 350ml dengan desain eksklusif edisi terbatas. Insulated double wall menjaga suhu tetap hangat atau dingin hingga 6 jam.', 120000, 25, 'Unit', 'assets/img/placeholder-coffee.svg', 0, 1, 20);

-- Artikel
INSERT INTO `artikel` (`judul`, `slug`, `ringkasan`, `isi`, `penulis`) VALUES
('Panduan Memilih Biji Kopi untuk Pemula', 'panduan-memilih-biji-kopi-pemula', 'Memahami jenis arabika dan robusta adalah kunci awal menikmati kopi. Simak panduan singkat berikut sebelum membeli biji kopi pertama Anda.', '<p>Kopi hadir dalam dua spesies utama yang paling umum dikenal: <strong>Arabika</strong> dan <strong>Robusta</strong>. Keduanya memiliki karakter yang sangat berbeda dan cocok untuk metode seduh yang berbeda pula.</p><h2>Perbedaan Mendasar</h2><p>Arabika ditanam di dataran tinggi (di atas 1000 mdpl), memiliki rasa yang lebih kompleks dengan tingkat keasaman (acidity) yang lebih beragam. Robusta lebih tahan terhadap penyakit, lebih murah, bodi lebih pekat, dan kandungan kafein hampir dua kali lipat.</p><h2>Kapan Memilih Arabika?</h2><p>Pilih arabika jika Anda suka kenikmatan aromatik dengan nuansa floral, fruity, dan citrus. Sangat direkomendasikan untuk metode pour over seperti V60 dan Chemex.</p><h2>Kapan Memilih Robusta?</h2><p>Pilih robusta untuk minuman yang membutuhkan bodi tebal dan crema banyak, seperti espresso campuran dan kopi tubruk tradisional.</p><p>Mulailah dengan mencoba kedua jenis ini dalam jumlah kecil untuk menemukan selera terbaik Anda.</p>', 'Admin'),
('5 Teknik Seduh Kopi Favorit di Rumah', '5-teknik-seduh-kopi-favorit-di-rumah', 'Tidak perlu alat mahal untuk menikmati kopi enak di rumah. Berikut lima metode seduh yang mudah dipelajari oleh siapa saja.', '<p>Menyeduh kopi di rumah kini semakin mudah dengan berbagai peralatan yang terjangkau. Berikut lima metode yang layak Anda coba.</p><h2>1. Tubruk</h2><p>Metode paling sederhana ala Indonesia. Masukkan bubuk kopi, tuang air panas, aduk, dan tunggu ampasnya mengendap.</p><h2>2. V60 Pour Over</h2><p>Metode pour over memberikan kontrol penuh pada alur penyiraman air sehingga rasa menjadi jernih dan bercahaya.</p><h2>3. French Press</h2><p>Hasilkan kopi berbodi penuh dengan tekstur creamy. Cocok untuk biji kopi dengan karakter cokelat dan nutty.</p><h2>4. Moka Pot</h2><p>Membuat kopi pekat ala espresso di atas kompor. Wajib coba untuk pencinta rasa kuat.</p><h2>5. Drip Bag</h2><p>Praktis dan mudah. Buka, gantung, siram air panas, dan kopi segar siap dinikmati di mana saja.</p>', 'Admin'),
('Mengenal Level Roasting dan Pengaruhnya pada Rasa', 'mengenal-level-roasting-pengaruh-rasa', 'Tingkat sangrai menentukan karakter rasa akhir kopi. Kenali light, medium, dan dark roast sebelum menentukan pilihan.', '<p>Proses roasting atau sangrai adalah jantung dari rasa kopi. Selama proses ini biji hijau berubah menjadi biji cokelat dengan aroma khas yang kita kenal.</p><h2>Light Roast</h2><p>Roasting singkat, mempertahankan keasaman dan karakter asli dari biji. Nuansa fruity dan floral paling menonjol. Cocok untuk single origin.</p><h2>Medium Roast</h2><p>Keseimbangan antara keasaman, rasa, dan aroma. Pilihan paling populer untuk cara seduh manual dan mesin espresso.</p><h2>Dark Roast</h2><p>Bodi lebih berat, pahit cokelat, dan rasa karamel yang kuat. Asal-usul biji menjadi kurang terasa, tetapi menghasilkan crema yang kaya.</p><p>Pahami selera Anda, lalu pilih level yang paling menyenangkan.</p>', 'Admin');

-- Galeri
INSERT INTO `galeri` (`gambar`, `caption`) VALUES
('assets/img/placeholder-coffee.svg', 'Green bean kualitas terbaik'),
('assets/img/placeholder-coffee.svg', 'Proses roast sedang berlangsung'),
('assets/img/placeholder-coffee.svg', 'Cangkir cappuccino artisan'),
('assets/img/placeholder-coffee.svg', 'Kebun kopi dataran tinggi'),
('assets/img/placeholder-coffee.svg', 'Barista menyeduh V60'),
('assets/img/placeholder-coffee.svg', 'Packaging kemasan baru');

-- Testimoni
INSERT INTO `testimoni` (`nama`, `peran`, `pesan`, `rating`) VALUES
('Rina Kusuma', 'Pelanggan setia', 'Kopi tubruknya enak banget, aromanya wangi dan tidak meninggalkan ampas. Pasti order lagi!', 5),
('Budi Santoso', 'Pemilik kafe', 'Kualitas green bean robusta konsisten. Sudah jadi supplier cafe saya selama setahun.', 5),
('Sari Dewi', 'Home brewer', 'Drip bag Gayo-nya praktis dan rasanya lembut. Selalu ready di tas kerja saya.', 4);

-- Pengaturan
INSERT INTO `pengaturan` (`key`, `value`) VALUES
('site_name', 'Nusantara Coffee'),
('tagline', 'Racikan Kopi Nusantara dari Petani ke Cangkir Anda'),
('deskripsi', 'UMKM kopi lokal yang menghadirkan biji kopi terbaik dari petani Indonesia. Kami meracik dengan hati untuk kenikmatan maksimal di setiap cangkir.'),
('logo', 'assets/img/logo.svg'),
('wa_number', '6281234567890'),
('email', 'halo@nusantaracoffee.id'),
('alamat', 'Jl. Kopi Nusantara No. 88, Kota Bandung, Jawa Barat'),
('maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.9!2d107.6!3d-6.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTQnMDAuMFMiIDEwN8KwMzYnMDAuMEU!5e0!3m2!1sid!2sid!4v1600000000000'),
('jam_buka', 'Senin - Sabtu: 07.00 - 21.00 WIB'),
('facebook', 'https://facebook.com/nusantaracoffee'),
('instagram', 'https://instagram.com/nusantaracoffee'),
('twitter', 'https://twitter.com/nusantaracoffee'),
('youtube', ''),
('hero_judul', 'Seduh Rasa Asli Kopi Nusantara'),
('hero_sub', 'Dari kebun ke cangkir, setiap tetes adalah cerita petani dan kehangatan tradisi.'),
('tentang_judul', 'Tentang Kami'),
('tentang_konten', 'Nusantara Coffee lahir dari kecintaan terhadap kopi Indonesia. Kami bekerja langsung bersama petani lokal untuk memastikan setiap biji dipetik, diproses, dan disangrai dengan standar terbaik. Misi kami sederhana: menghadirkan secangkir kebahagiaan yang jujur dan berkualitas kepada setiap penikmat kopi.'),
('footer_teks', 'Menghadirkan secangkir kopi Nusantara terbaik untuk Anda. Sosialisasikan cita rasa ke seluruh Indonesia.'),
('meta_description', 'Website UMKM kopi Nusantara Coffee, menghadirkan biji kopi terbaik dari petani Indonesia.'),
('dark_mode', '1');