<?php
/**
 * Halaman Detail Produk: galeri, harga, stok, info, produk terkait,
 * tombol Pesan WhatsApp, share.
 */
$id = (int)get('id', 0);
$stmt = db()->prepare(
    "SELECT p.*, k.nama AS kategori_nama, k.slug AS kategori_slug
       FROM produk p
       JOIN kategori k ON k.id = p.kategori_id
      WHERE p.id = :id LIMIT 1"
);
$stmt->execute(['id' => $id]);
$p = $stmt->fetch();

if (!$p) {
    set_flash('error', 'Produk tidak ditemukan.');
    redirect(url('index.php?page=produk'));
}

$pageTitle = $p['nama'];

// Produk terkait (kategori sama, kecuali produk ini)
$stmt = db()->prepare(
    "SELECT p.*, k.nama AS kategori_nama
       FROM produk p
       JOIN kategori k ON k.id = p.kategori_id
      WHERE p.kategori_id = :kat AND p.id != :id
      ORDER BY p.created_at DESC LIMIT 4"
);
$stmt->execute(['kat' => $p['kategori_id'], 'id' => $id]);
$related = $stmt->fetchAll();

$hargaFinal = (int)$p['harga'];
if (!empty($p['promo']) && (int)$p['diskon'] > 0) {
    $hargaFinal = $hargaFinal - ($hargaFinal * (int)$p['diskon'] / 100);
}

$gambar = [$p['gambar']];
if ($p['gambar_2']) $gambar[] = $p['gambar_2'];
if ($p['gambar_3']) $gambar[] = $p['gambar_3'];

$shareUrl = url('index.php?page=detail&id=' . $id);
?>

<?php $currentPage = 'produk'; ?>

<!-- Breadcrumb -->
<section class="relative overflow-hidden bg-espresso pb-20 pt-32 text-white">
    <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-copper/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 text-sm text-white/70">
            <a href="<?= url('index.php') ?>" class="transition hover:text-copper">Home</a>
            <i data-lucide="chevron-right" class="h-4 w-4"></i>
            <a href="<?= url('index.php?page=produk') ?>" class="transition hover:text-copper">Produk</a>
            <i data-lucide="chevron-right" class="h-4 w-4"></i>
            <span class="text-copper"><?= e($p['nama']) ?></span>
        </nav>
    </div>
</section>

<section class="mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
    <div class="grid gap-10 rounded-3xl bg-white p-6 shadow-soft dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10 sm:p-8 lg:grid-cols-2">
        <!-- Galeri -->
        <div>
            <div class="overflow-hidden rounded-2xl">
                <img id="main-image" src="<?= e(asset($gambar[0])) ?>" alt="<?= e($p['nama']) ?>" class="aspect-[4/3] w-full object-cover">
            </div>
            <div class="mt-4 grid grid-cols-3 gap-4">
                <?php foreach ($gambar as $i => $g): ?>
                <button type="button" class="gallery-thumb overflow-hidden rounded-xl ring-2 ring-transparent transition-all duration-300 hover:ring-copper <?= $i === 0 ? 'ring-copper' : '' ?>" data-src="<?= e(asset($g)) ?>">
                    <img src="<?= e(asset($g)) ?>" alt="Galeri <?= $i + 1 ?>" class="aspect-[4/3] w-full object-cover">
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Info -->
        <div class="flex flex-col">
            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-copper/10 px-3 py-1 text-xs font-semibold text-copper ring-1 ring-copper/10">
                <i data-lucide="tag" class="h-3.5 w-3.5"></i> <?= e($p['kategori_nama']) ?>
            </span>
            <h1 class="mt-4 text-3xl font-extrabold"><?= e($p['nama']) ?></h1>

            <div class="mt-4 flex flex-wrap items-center gap-4">
                <p class="text-3xl font-extrabold text-copper"><?= e(rupiah($hargaFinal)) ?></p>
                <?php if (!empty($p['promo']) && (int)$p['diskon'] > 0): ?>
                    <p class="text-lg text-red-500 line-through"><?= e(rupiah($p['harga'])) ?></p>
                    <span class="rounded-lg bg-gradient-to-r from-copper to-orange-500 px-2 py-1 text-xs font-bold text-white">-<?= (int)$p['diskon'] ?>%</span>
                <?php endif; ?>
            </div>

            <div class="mt-6 grid grid-cols-3 gap-4">
                <div class="rounded-xl bg-cream/70 p-4 text-center ring-1 ring-copper/5 dark:bg-white/5">
                    <i data-lucide="package" class="mx-auto h-5 w-5 text-copper"></i>
                    <p class="mt-2 text-xs text-espresso/60 dark:text-cream/60">Berat</p>
                    <p class="mt-0.5 text-sm font-semibold"><?= e($p['berat']) ?></p>
                </div>
                <div class="rounded-xl bg-cream/70 p-4 text-center ring-1 ring-copper/5 dark:bg-white/5">
                    <i data-lucide="layers" class="mx-auto h-5 w-5 text-copper"></i>
                    <p class="mt-2 text-xs text-espresso/60 dark:text-cream/60">Stok</p>
                    <p class="mt-0.5 text-sm font-semibold <?= (int)$p['stok'] > 0 ? 'text-olive' : 'text-red-500' ?>">
                        <?= (int)$p['stok'] > 0 ? (int)$p['stok'] . ' Tersedia' : 'Habis' ?>
                    </p>
                </div>
                <div class="rounded-xl bg-cream/70 p-4 text-center ring-1 ring-copper/5 dark:bg-white/5">
                    <i data-lucide="award" class="mx-auto h-5 w-5 text-copper"></i>
                    <p class="mt-2 text-xs text-espresso/60 dark:text-cream/60">Status</p>
                    <p class="mt-0.5 text-sm font-semibold"><?= !empty($p['best_seller']) ? 'Best Seller' : 'Reguler' ?></p>
                </div>
            </div>

            <p class="mt-6 leading-relaxed text-espresso/75 dark:text-cream/70"><?= nl2br(e($p['deskripsi'])) ?></p>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="<?= whatsapp_link($p['nama'], rupiah($hargaFinal)) ?>" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-olive to-olive/80 px-7 py-3.5 font-semibold text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-olive/30">
                    <i data-lucide="message-circle" class="h-5 w-5"></i> Pesan Sekarang
                </a>
                <button id="share-btn" type="button" class="inline-flex items-center gap-2 rounded-xl border-2 border-copper px-6 py-3 text-sm font-semibold text-copper transition-all duration-300 hover:bg-copper hover:text-white">
                    <i data-lucide="share-2" class="h-4 w-4"></i> Bagikan
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Produk terkait -->
<?php if (count($related) > 0): ?>
<section class="pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold" data-aos="fade-up">Produk Terkait</h2>
        <div class="mt-8 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($related as $rp): include __DIR__ . '/../includes/product-card.php'; endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
    const shareUrl = <?= json_encode($shareUrl) ?>;
    document.getElementById('share-btn').addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(shareUrl);
            Swal.fire({ icon: 'success', title: 'Tautan disalin!', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
        } catch (e) {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(shareUrl), '_blank');
        }
    });
</script>