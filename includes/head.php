<?php
require_once __DIR__ . '/../config/config.php';
$darkOn = (isset($_COOKIE['dark']) && $_COOKIE['dark'] === '1')
    || (!isset($_COOKIE['dark']) && site('dark_mode') === '1');
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth <?= $darkOn ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e(site('meta_description', 'Website UMKM Kopi Nusantara')) ?>">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' – ' : '' ?><?= e(site('site_name', APP_NAME)) ?></title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        espresso:  '#3E2723',
                        coffee:    '#6F4E37',
                        copper:    '#B87333',
                        cream:     '#F8F4EC',
                        olive:     '#6B7A4A',
                    },
                    boxShadow: {
                        soft: '0 10px 30px -12px rgba(62, 39, 35, 0.25)',
                    },
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@1.29.0/dist/umd/lucide.js"></script>

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="bg-cream dark:bg-espresso text-espresso dark:text-cream/90 font-sans antialiased transition-colors duration-300 min-h-screen">

<div id="loading-screen" class="fixed inset-0 z-[100] flex items-center justify-center bg-cream dark:bg-espresso transition-opacity duration-500">
    <div class="text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 animate-pulse items-center justify-center rounded-2xl bg-gradient-to-br from-copper to-orange-600 shadow-lg shadow-copper/30">
            <i data-lucide="coffee" class="text-2xl text-white"></i>
        </div>
        <div class="mx-auto h-1 w-24 overflow-hidden rounded-full bg-espresso/10 dark:bg-white/10">
            <div class="h-full w-1/2 animate-pulse rounded-full bg-copper"></div>
        </div>
        <p class="mt-3 text-sm font-medium tracking-widest uppercase text-coffee"><?= e(site('site_name', APP_NAME)) ?></p>
    </div>
</div>

<button id="back-to-top" class="fixed bottom-6 right-6 z-[60] hidden h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-copper to-orange-600 text-white shadow-lg opacity-0 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl">
    <i data-lucide="arrow-up" class="h-5 w-5"></i>
</button>