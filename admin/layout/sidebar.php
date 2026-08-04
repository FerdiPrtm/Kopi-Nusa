<?php
/** Sidebar admin dengan menu + active state. */
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$dirName = basename(dirname($scriptPath));
$module = ($dirName === 'admin') ? 'dashboard' : $dirName;

$menu = [
    'dashboard'  => ['icon' => 'layout-dashboard', 'label' => 'Dashboard', 'href' => 'index.php'],
    'produk'     => ['icon' => 'coffee', 'label' => 'Produk', 'href' => 'produk/index.php'],
    'kategori'   => ['icon' => 'tags', 'label' => 'Kategori', 'href' => 'kategori/index.php'],
    'artikel'    => ['icon' => 'newspaper', 'label' => 'Artikel', 'href' => 'artikel/index.php'],
    'galeri'     => ['icon' => 'image', 'label' => 'Galeri', 'href' => 'galeri/index.php'],
    'testimoni'  => ['icon' => 'message-square-quote', 'label' => 'Testimoni', 'href' => 'testimoni/index.php'],
    'pesan'      => ['icon' => 'inbox', 'label' => 'Pesan Masuk', 'href' => 'pesan/index.php'],
    'pengaturan' => ['icon' => 'settings', 'label' => 'Pengaturan', 'href' => 'pengaturan/index.php'],
];
?>
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-espresso text-cream transition-transform duration-300 lg:translate-x-0">
    <div class="flex items-center gap-3 px-6 py-6">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-copper to-orange-600 text-white shadow-lg shadow-copper/30">
            <i data-lucide="coffee" class="h-5 w-5"></i>
        </span>
        <div>
            <p class="font-bold text-white"><?= e(site('site_name', APP_NAME)) ?></p>
            <p class="text-xs text-cream/50">Admin Panel</p>
        </div>
    </div>
    <nav class="mt-2 flex-1 space-y-1 overflow-y-auto px-4 pb-6">
        <?php foreach ($menu as $key => $m): ?>
            <?php $active = $module === $key; ?>
            <a href="<?= url('admin/' . $m['href']) ?>"
               class="group relative flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-all duration-300 <?= $active ? 'bg-gradient-to-r from-copper to-orange-600 text-white shadow-lg shadow-copper/25' : 'text-cream/70 hover:bg-white/10 hover:text-white' ?>">
                <?php if ($active): ?><span class="absolute left-0 top-1/2 h-6 w-1 -translate-y-1/2 rounded-r-full bg-white"></span><?php endif; ?>
                <i data-lucide="<?= $m['icon'] ?>" class="h-5 w-5"></i>
                <?= $m['label'] ?>
                <?php if ($key === 'pesan'): ?>
                    <?php $unread = (int)db()->query("SELECT COUNT(*) FROM kontak WHERE is_read = 0")->fetchColumn(); ?>
                    <?php if ($unread > 0): ?>
                        <span class="ml-auto flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1.5 text-[11px] font-bold text-white"><?= $unread ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="border-t border-white/10 p-4">
        <div class="flex items-center gap-3 rounded-xl bg-white/5 px-4 py-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-copper text-sm font-bold text-white"><?= e(mb_strtoupper(mb_substr($_SESSION['admin_name'] ?? 'A', 0, 1))) ?></span>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-white"><?= e($_SESSION['admin_name'] ?? 'Admin') ?></p>
                <a href="<?= url('index.php') ?>" target="_blank" class="text-xs text-cream/50 transition hover:text-copper">Lihat Website</a>
            </div>
        </div>
        <a href="<?= url('admin/logout.php') ?>" class="mt-3 flex items-center justify-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-500">
            <i data-lucide="log-out" class="h-4 w-4"></i> Logout
        </a>
    </div>
</aside>