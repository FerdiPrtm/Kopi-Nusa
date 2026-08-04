<?php
/** Halaman Detail Artikel + related artikel. */
$id = (int)get('id', 0);
$stmt = db()->prepare("SELECT * FROM artikel WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$a = $stmt->fetch();

if (!$a) {
    set_flash('error', 'Artikel tidak ditemukan.');
    redirect(url('index.php?page=artikel'));
}

$pageTitle = $a['judul'];

$stmt = db()->prepare("SELECT * FROM artikel WHERE id != :id ORDER BY created_at DESC LIMIT 3");
$stmt->execute(['id' => $id]);
$related = $stmt->fetchAll();
?>
<?php $currentPage = 'artikel'; ?>

<section class="relative overflow-hidden bg-espresso pb-16 pt-32 text-white">
    <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-copper/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 text-sm text-white/70">
            <a href="<?= url('index.php') ?>" class="transition hover:text-copper">Home</a>
            <i data-lucide="chevron-right" class="h-4 w-4"></i>
            <a href="<?= url('index.php?page=artikel') ?>" class="transition hover:text-copper">Artikel</a>
        </nav>
        <h1 class="mt-6 max-w-3xl text-3xl font-extrabold sm:text-4xl" data-aos="fade-up"><?= e($a['judul']) ?></h1>
        <p class="mt-4 flex flex-wrap items-center gap-3 text-sm text-white/70">
            <span class="flex items-center gap-2"><i data-lucide="user" class="h-4 w-4 text-copper"></i> <?= e($a['penulis']) ?></span>
            <span class="flex items-center gap-2"><i data-lucide="calendar" class="h-4 w-4 text-copper"></i> <?= e(format_date($a['created_at'])) ?></span>
        </p>
    </div>
</section>

<section class="py-16">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
        <article class="lg:col-span-2">
            <img src="<?= e(asset($a['gambar'] ?: 'assets/img/placeholder-coffee.svg')) ?>" alt="<?= e($a['judul']) ?>" class="w-full rounded-2xl object-cover shadow-soft" data-aos="fade-up">
            <div class="prose-custom mt-8 leading-relaxed text-espresso/80 dark:text-cream/80">
                <?= $a['isi'] ?>
            </div>

            <div class="mt-10 flex items-center gap-3 border-t border-cream pt-6 dark:border-white/10">
                <p class="text-sm font-semibold">Bagikan:</p>
                <button id="share-article" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg bg-copper/10 text-copper transition hover:bg-copper hover:text-white">
                    <i data-lucide="share-2" class="h-4 w-4"></i>
                </button>
            </div>
        </article>

        <aside>
            <h3 class="text-lg font-bold">Artikel Lainnya</h3>
            <div class="mt-5 space-y-5">
                <?php foreach ($related as $r): ?>
                <a href="<?= url('index.php?page=detail-artikel&id=' . (int)$r['id']) ?>" class="group flex gap-4 rounded-2xl bg-white p-3 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10">
                    <img src="<?= e(asset($r['gambar'] ?: 'assets/img/placeholder-coffee.svg')) ?>" alt="<?= e($r['judul']) ?>" class="h-20 w-24 shrink-0 rounded-xl object-cover">
                    <div>
                        <p class="text-xs text-coffee"><?= e(format_date($r['created_at'])) ?></p>
                        <p class="mt-1 line-clamp-2 text-sm font-semibold leading-snug transition-colors group-hover:text-copper"><?= e($r['judul']) ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</section>

<script>
    document.getElementById('share-article').addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(window.location.href);
            Swal.fire({ icon: 'success', title: 'Tautan disalin!', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
        } catch (e) {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
        }
    });
</script>