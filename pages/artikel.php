<?php
/** Halaman Artikel: list artikel dengan pagination. */
$pageTitle = 'Artikel';

$pageN = max(1, (int)get('hal', 1));
$perPage = 6;

$total = (int)db()->query("SELECT COUNT(*) FROM artikel")->fetchColumn();
$totalPages = max(1, (int)ceil($total / $perPage));
$offset = ($pageN - 1) * $perPage;

$artikels = db()->query(
    "SELECT * FROM artikel ORDER BY created_at DESC LIMIT $perPage OFFSET $offset"
)->fetchAll();
?>
<?php $currentPage = 'artikel'; ?>

<section class="relative overflow-hidden bg-espresso pb-16 pt-32 text-white">
    <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-copper/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copperLight" data-aos="fade-up">Blog</span>
        <h1 class="mt-4 text-4xl font-extrabold" data-aos="fade-up" data-aos-delay="100">Artikel & Berita Kopi</h1>
        <span class="mt-5 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
        <p class="mt-5 max-w-xl text-white/80" data-aos="fade-up" data-aos-delay="150">Tips, panduan, dan cerita seputar dunia kopi Nusantara.</p>
    </div>
</section>

<section class="py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <?php if (count($artikels) > 0): ?>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
<?php foreach ($artikels as $a): ?>
                <a href="<?= url('index.php?page=detail-artikel&id=' . (int)$a['id']) ?>" class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-soft transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10" data-aos="fade-up">
                    <div class="product-img-wrap aspect-[16/9] bg-cream dark:bg-espresso">
                        <img src="<?= e(asset($a['gambar'] ?: 'assets/img/placeholder-coffee.svg')) ?>" loading="lazy" alt="<?= e($a['judul']) ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="flex items-center gap-2 text-xs text-coffee">
                            <i data-lucide="calendar" class="h-3.5 w-3.5"></i> <?= e(format_date($a['created_at'])) ?>
                            <span class="text-espresso/30">·</span> <?= e($a['penulis']) ?>
                        </p>
                        <h3 class="mt-2 line-clamp-2 text-lg font-bold leading-snug transition-colors group-hover:text-copper"><?= e($a['judul']) ?></h3>
                        <p class="mt-2 line-clamp-3 text-sm text-espresso/70 dark:text-cream/70"><?= e(excerpt($a['ringkasan'], 130)) ?></p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-copper">
                            Baca Artikel <i data-lucide="arrow-right" class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <nav class="mt-12 flex justify-center">
                    <ul class="flex items-center gap-2">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li>
                                <a href="<?= url('index.php?page=artikel&hal=' . $i) ?>"
                                   class="flex h-11 min-w-11 items-center justify-center rounded-xl px-3 text-sm font-semibold transition-all duration-300 <?= $i === $pageN ? 'bg-copper text-white shadow-soft' : 'bg-white text-espresso hover:bg-cream dark:bg-white/5 dark:text-cream dark:hover:bg-white/10' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="py-20 text-center">
                <i data-lucide="file-text" class="mx-auto h-16 w-16 text-coffee/40"></i>
                <p class="mt-4 text-lg font-semibold">Belum ada artikel</p>
            </div>
        <?php endif; ?>
    </div>
</section>