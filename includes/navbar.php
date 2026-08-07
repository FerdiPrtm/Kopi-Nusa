<?php
/** Navbar floating + sticky, active menu otomatis. */
$current = $currentPage ?? '';
function is_active(string $name): string {
    global $current;
    return $current === $name ? 'text-copper' : 'text-espresso/75 dark:text-cream/75 hover:text-copper';
}
function is_active_bar(string $name): string {
    global $current;
    return $current === $name ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0';
}
?>
<header id="navbar" class="fixed inset-x-0 top-0 z-50">
    <nav class="mx-auto max-w-7xl px-3 pt-3 sm:px-5 sm:pt-4">
        <div id="nav-pill" class="nav-inner flex items-center justify-between rounded-2xl border border-cream/60 bg-cream/80 px-4 py-2.5 shadow-md shadow-espresso/5 backdrop-blur-md dark:border-white/10 dark:bg-espresso/80 sm:px-5">
            <!-- Logo -->
            <a href="<?= url('index.php') ?>" class="group flex items-center gap-2.5" aria-label="<?= e(site('site_name', APP_NAME)) ?>">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-copper to-espresso text-white shadow-sm transition-transform duration-300 group-hover:scale-105">
                    <i data-lucide="coffee" class="h-5 w-5"></i>
                </span>
                <span class="hidden text-[15px] font-bold tracking-tight sm:inline"><?= e(site('site_name', APP_NAME)) ?></span>
            </a>

            <!-- Desktop menu -->
            <div class="hidden items-center gap-1 lg:flex">
                <?php
                $links = [
                    'home'    => ['Home', url('index.php')],
                    'produk'  => ['Produk', url('index.php?page=produk')],
                    'tentang' => ['Tentang', url('index.php?page=tentang')],
                    'artikel' => ['Artikel', url('index.php?page=artikel')],
                    'kontak'  => ['Kontak', url('index.php?page=kontak')],
                ];
                foreach ($links as $key => $link): ?>
                <a href="<?= $link[1] ?>" class="relative rounded-xl px-4 py-2 text-sm font-medium transition-colors <?= is_active($key) ?>">
                    <?= $link[0] ?>
                    <span class="pointer-events-none absolute inset-x-4 -bottom-0.5 h-0.5 rounded-full bg-copper transition-all duration-300 <?= is_active_bar($key) ?>"></span>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="flex items-center gap-2">
                <button id="dark-toggle" class="flex h-10 w-10 items-center justify-center rounded-xl text-espresso/80 transition-colors hover:bg-espresso/5 dark:text-cream/80 dark:hover:bg-white/10" aria-label="Mode gelap">
                    <i data-lucide="moon" class="hidden h-5 w-5 dark:block text-copper"></i>
                    <i data-lucide="sun" class="h-5 w-5 dark:hidden"></i>
                </button>
                <a href="<?= whatsapp_link() ?>" target="_blank" class="hidden items-center gap-2 rounded-xl bg-espresso px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:bg-copper hover:shadow-md sm:inline-flex">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Pesan Sekarang
                </a>
                <button id="menu-toggle" class="flex h-10 w-10 items-center justify-center rounded-xl text-espresso/80 transition-colors hover:bg-espresso/5 lg:hidden dark:text-cream/80 dark:hover:bg-white/10" aria-label="Menu" aria-expanded="false">
                    <i data-lucide="menu" class="icon-menu h-5 w-5"></i>
                    <i data-lucide="x" class="icon-close hidden h-5 w-5"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile menu backdrop -->
    <div id="menu-backdrop" class="fixed inset-0 z-[-1] hidden bg-black/40 backdrop-blur-sm lg:hidden"></div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="mx-3 mt-2 hidden rounded-2xl p-2 shadow-lg glass sm:mx-5 lg:hidden">
        <div class="flex flex-col gap-0.5">
            <?php foreach ($links as $key => $link): ?>
                <a href="<?= $link[1] ?>" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm transition <?= $current === $key ? 'bg-copper/10 font-semibold text-copper' : 'text-espresso/80 hover:bg-espresso/5 dark:text-cream/80 dark:hover:bg-white/5' ?>">
                    <?= $link[0] ?>
                    <?php if ($current === $key): ?><i data-lucide="chevron-right" class="ml-auto h-4 w-4"></i><?php endif; ?>
                </a>
            <?php endforeach; ?>
            <a href="<?= whatsapp_link() ?>" target="_blank" class="mt-1 flex items-center justify-center gap-2 rounded-xl bg-copper px-4 py-3 text-sm font-semibold text-white">
                <i data-lucide="message-circle" class="h-4 w-4"></i> Pesan Sekarang
            </a>
        </div>
    </div>
</header>