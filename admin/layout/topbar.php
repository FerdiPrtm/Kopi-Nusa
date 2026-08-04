<?php /** Topbar admin: judul halaman + tombol sidebar mobile. */ ?>
<header class="sticky top-0 z-30 flex items-center justify-between border-b border-cream bg-cream/90 px-4 py-4 backdrop-blur sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button id="sidebar-toggle" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-espresso shadow-soft lg:hidden" aria-label="Toggle menu">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>
        <h1 class="text-lg font-bold"><?= e($title ?? 'Dashboard') ?></h1>
    </div>
    <a href="<?= url('admin/logout.php') ?>" class="hidden items-center gap-2 rounded-xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-500 hover:text-white sm:flex">
        <i data-lucide="log-out" class="h-4 w-4"></i> Logout
    </a>
</header>