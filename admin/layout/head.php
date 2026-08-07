<?php
/** Header admin layout. Variable yang tersedia: $title */
if (!isset($title)) $title = 'Dashboard';
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> – Admin <?= e(site('site_name', APP_NAME)) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                colors: { espresso: '#3E2723', coffee: '#6F4E37', copper: '#B87333', cream: '#F8F4EC', olive: '#6B7A4A' },
                boxShadow: { soft: '0 10px 30px -12px rgba(62, 39, 35, 0.25)' },
            } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@1.29.0/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="bg-cream font-sans text-espresso">
<div class="flex min-h-screen">
    <?php require_once __DIR__ . '/sidebar.php'; ?>
    <div id="sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-black/40 backdrop-blur-sm lg:hidden"></div>
    <div id="admin-main" class="flex min-h-screen w-full flex-col lg:ml-64">
        <?php require_once __DIR__ . '/topbar.php'; ?>
        <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8"><?php if ($flash): ?><script>Swal.fire({ icon: '<?= e($flash['type']) ?>', title: '<?= e($flash['message']) ?>', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });</script><?php endif; ?>