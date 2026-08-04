<?php
/**
 * Front controller website publik.
 * URL: index.php?page=home|produk|detail|tentang|artikel|detail-artikel|kontak
 */

session_start();

ob_start(); // agar redirect() bekerja meski telah ada output HTML

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

$page = get('page', 'home');
$currentPage = $page;

$allowed = [
    'home'          => 'pages/home.php',
    'produk'        => 'pages/produk.php',
    'detail'        => 'pages/detail-produk.php',
    'tentang'       => 'pages/tentang.php',
    'artikel'       => 'pages/artikel.php',
    'detail-artikel'=> 'pages/detail-artikel.php',
    'kontak'        => 'pages/kontak.php',
];

if (!isset($allowed[$page])) {
    $page = 'home';
    $currentPage = 'home';
}

$pageFile = $allowed[$page];

require_once __DIR__ . '/includes/head.php';
require_once __DIR__ . '/includes/navbar.php';

require_once __DIR__ . '/' . $pageFile;

require_once __DIR__ . '/includes/footer.php';
require_once __DIR__ . '/includes/scripts.php';
