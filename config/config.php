<?php
/**
 * Konfigurasi utama website.
 * Sesuaikan BASE_URL dengan lokasi folder di XAMPP (biasanya http://localhost/coffe).
 */

// Root path (absolut folder proyek)
define('ROOTPATH', __DIR__ . '/..');

// URL dasar website - sesuaikan bila folder berbeda
define('BASE_URL', 'http://localhost/Kopi-Nusa');

// URL untuk folder assets (front end & admin)
define('ASSET_URL', BASE_URL . '/assets');

// Data koneksi database
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'caffe_umkm');
define('DB_USER', 'root');
define('DB_PASS', '');

// Pengaturan umum
define('APP_NAME', 'Nusantara Coffee');
define('UPLOAD_MAX', 2 * 1024 * 1024); // 2 MB
define('UPLOAD_DIR', ROOTPATH . '/uploads');

// Format waktu (Asia/Jakarta)
date_default_timezone_set('Asia/Jakarta');