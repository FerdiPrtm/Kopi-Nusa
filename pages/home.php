<?php
/**
 * Halaman Home: hero, tentang, produk unggulan, kenapa memilih kami,
 * testimoni, artikel, galeri, CTA WhatsApp.
 */
$pageTitle = 'Home';

// Produk unggulan (best seller / promo)
$produkUnggulan = db()->query(
    "SELECT p.*, k.nama AS kategori_nama
       FROM produk p
       JOIN kategori k ON k.id = p.kategori_id
      WHERE p.best_seller = 1 OR p.promo = 1
      ORDER BY p.created_at DESC
      LIMIT 6"
)->fetchAll();

// Testimoni
$testimonis = db()->query(
    "SELECT * FROM testimoni ORDER BY created_at DESC LIMIT 6"
)->fetchAll();

// Artikel terbaru
$artikels = db()->query(
    "SELECT * FROM artikel ORDER BY created_at DESC LIMIT 3"
)->fetchAll();

// Galeri
$galeris = db()->query(
    "SELECT * FROM galeri ORDER BY created_at DESC LIMIT 8"
)->fetchAll();

$totalProduk = (int)db()->query("SELECT COUNT(*) FROM produk")->fetchColumn();
?>

<?php $currentPage = 'home'; ?>

<!-- ================= HERO ================= -->
<section id="home" class="relative flex min-h-screen items-center justify-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="<?= url('assets/img/hero-coffee.svg') ?>" alt="Kopi Nusantara" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-espresso/75 via-espresso/45 to-espresso/90"></div>
    </div>

    <!-- Dekorasi blur -->
    <div class="pointer-events-none absolute -left-20 top-1/4 h-72 w-72 rounded-full bg-copper/25 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-16 bottom-1/4 h-72 w-72 rounded-full bg-coffee/30 blur-3xl"></div>

    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center text-white">
        <p class="glass-dark mx-auto mb-6 inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-medium tracking-widest uppercase">
            <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-copper"></span>
            From Farm to Cup
        </p>
        <h1 class="text-4xl font-extrabold leading-tight drop-shadow-lg sm:text-5xl lg:text-6xl" data-aos="fade-up">
            <?= e(site('hero_judul', 'Seduh Rasa Asli Kopi Nusantara')) ?>
        </h1>
        <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-white/85 sm:text-lg" data-aos="fade-up" data-aos-delay="150">
            <?= e(site('hero_sub', 'Dari kebun ke cangkir, setiap tetes adalah cerita.')) ?>
        </p>
        <div class="mt-9 flex flex-col items-center justify-center gap-4 sm:flex-row" data-aos="fade-up" data-aos-delay="250">
            <a href="<?= url('index.php?page=produk') ?>" class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-copper to-orange-600 px-8 py-3.5 font-semibold text-white shadow-xl shadow-copper/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-copper/40">
                <i data-lucide="coffee" class="h-5 w-5"></i> Lihat Produk
                <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
            <a href="<?= whatsapp_link() ?>" target="_blank" class="glass-dark inline-flex items-center gap-2 rounded-xl px-8 py-3.5 font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-white/20">
                <i data-lucide="phone" class="h-5 w-5"></i> Hubungi Kami
            </a>
        </div>

        <!-- Stat strip -->
        <div class="glass-dark mx-auto mt-14 grid max-w-lg grid-cols-3 divide-x divide-white/15 rounded-2xl py-5" data-aos="fade-up" data-aos-delay="350">
            <div>
                <p class="text-2xl font-extrabold text-copper"><?= $totalProduk ?>+</p>
                <p class="text-xs text-white/70">Produk Pilihan</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-copper">300+</p>
                <p class="text-xs text-white/70">Pelanggan Puas</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-copper">100%</p>
                <p class="text-xs text-white/70">Kopi Lokal</p>
            </div>
        </div>
    </div>

    <a href="#tentang" class="absolute bottom-8 left-1/2 z-10 -translate-x-1/2 text-white/70 transition hover:text-copper" aria-label="Scroll ke bawah">
        <div class="flex h-12 w-7 items-start justify-center rounded-full border-2 border-current p-1.5">
            <span class="h-2.5 w-1 animate-bounce rounded-full bg-current"></span>
        </div>
    </a>
</section>

<!-- ================= TENTANG ================= -->
<section id="tentang" class="py-24">
    <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div class="relative" data-aos="fade-right">
            <div class="absolute -inset-3 rounded-3xl bg-gradient-to-br from-copper/20 to-transparent"></div>
            <img src="<?= url('assets/img/about-coffee.svg') ?>" alt="Tentang <?= e(site('site_name')) ?>" class="relative aspect-[4/3] w-full rounded-3xl object-cover shadow-xl">
            <div class="absolute -bottom-6 -right-4 hidden rounded-2xl p-6 shadow-xl glass sm:block">
                <p class="text-3xl font-extrabold text-copper">100%</p>
                <p class="text-sm font-medium text-espresso/70 dark:text-cream/70">Kopi Lokal Petani Indonesia</p>
            </div>
        </div>
        <div data-aos="fade-left">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">
                <span class="h-px w-8 bg-copper"></span> Tentang Kami
            </span>
            <h2 class="mt-4 text-3xl font-extrabold sm:text-4xl"><?= e(site('tentang_judul', 'Tentang Kami')) ?></h2>
            <p class="mt-5 leading-relaxed text-espresso/75 dark:text-cream/70"><?= nl2br(e(site('tentang_konten', ''))) ?></p>
            <div class="mt-8 grid grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white p-5 text-center shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10">
                    <p class="text-2xl font-extrabold text-copper">5+</p>
                    <p class="mt-1 text-xs text-espresso/60 dark:text-cream/60">Tahun Pengalaman</p>
                </div>
                <div class="rounded-2xl bg-white p-5 text-center shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10">
                    <p class="text-2xl font-extrabold text-copper">300+</p>
                    <p class="mt-1 text-xs text-espresso/60 dark:text-cream/60">Pelanggan Puas</p>
                </div>
                <div class="rounded-2xl bg-white p-5 text-center shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10">
                    <p class="text-2xl font-extrabold text-copper">10+</p>
                    <p class="mt-1 text-xs text-espresso/60 dark:text-cream/60">Produk Unggulan</p>
                </div>
            </div>
            <a href="<?= url('index.php?page=tentang') ?>" class="group mt-8 inline-flex items-center gap-2 rounded-xl bg-espresso px-6 py-3 text-sm font-semibold text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-coffee dark:bg-copper dark:hover:bg-coffee">
                Selengkapnya <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- ================= PRODUK UNGGULAN ================= -->
<section class="bg-gradient-to-b from-transparent to-white/60 py-24 dark:to-white/[0.02]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-xl text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">
                Koleksi Pilihan
            </span>
            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Produk Unggulan</h2>
            <span class="mx-auto mt-4 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
            <p class="mt-4 text-espresso/70 dark:text-cream/70">Pilihan terbaik dari petani untuk kenikmatan terbaik Anda.</p>
        </div>

        <div class="mt-12 grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($produkUnggulan as $p): include __DIR__ . '/../includes/product-card.php'; endforeach; ?>
        </div>

        <div class="mt-12 text-center">
            <a href="<?= url('index.php?page=produk') ?>" class="group inline-flex items-center gap-2 rounded-xl border-2 border-copper px-8 py-3 font-semibold text-copper transition-all duration-300 hover:bg-copper hover:text-white">
                Lihat Semua Produk <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- ================= KENAPA MEMILIH KAMI ================= -->
<section class="py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-xl text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">Keunggulan</span>
            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Kenapa Memilih Kami?</h2>
            <span class="mx-auto mt-4 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
        </div>
        <div class="mt-12 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
            <?php
            $keunggulan = [
                ['leaf', 'Biji Pilihan', 'Dikurasi langsung dari petani terbaik di berbagai daerah Indonesia.'],
                ['fire', 'Roasting Segar', 'Disangrai dalam jumlah kecil agar selalu segar saat sampai di tangan Anda.'],
                ['shield-check', 'Kualitas Terjaga', 'Kontrol kualitas di setiap proses, dari panen hingga pengemasan.'],
                ['truck', 'Pengiriman Cepat', 'Dikemas aman dan dikirim cepat ke seluruh Indonesia.'],
            ];
            foreach ($keunggulan as $i => $item): ?>
            <div class="group relative rounded-2xl bg-white p-7 shadow-soft transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <span class="absolute right-5 top-5 text-5xl font-extrabold text-espresso/5 transition-colors duration-300 group-hover:text-copper/10">0<?= $i + 1 ?></span>
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-copper/10 text-copper ring-1 ring-copper/10 transition-all duration-300 group-hover:bg-gradient-to-br group-hover:from-copper group-hover:to-orange-600 group-hover:text-white">
                    <i data-lucide="<?= $item[0] ?>" class="h-6 w-6"></i>
                </span>
                <h3 class="mt-5 text-lg font-bold"><?= $item[1] ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-espresso/70 dark:text-cream/70"><?= $item[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= TESTIMONI ================= -->
<section class="relative overflow-hidden bg-espresso py-24 text-cream">
    <div class="pointer-events-none absolute -right-20 top-0 h-72 w-72 rounded-full bg-copper/15 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-20 bottom-0 h-72 w-72 rounded-full bg-coffee/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-xl text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">Testimoni</span>
            <h2 class="mt-3 text-3xl font-extrabold text-white sm:text-4xl">Kata Mereka</h2>
            <span class="mx-auto mt-4 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
        </div>
        <div class="mt-12 grid gap-7 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($testimonis as $t): ?>
            <figure class="group relative rounded-2xl bg-white/5 p-7 ring-1 ring-white/10 backdrop-blur transition-all duration-300 hover:-translate-y-1.5 hover:bg-white/10 hover:ring-copper/40" data-aos="fade-up">
                <i data-lucide="quote" class="absolute right-6 top-6 h-8 w-8 text-copper/30 transition-colors duration-300 group-hover:text-copper/60"></i>
                <div class="flex gap-1 text-copper">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i data-lucide="star" class="h-4 w-4 fill-current <?= $i <= (int)$t['rating'] ? '' : 'opacity-25' ?>"></i>
                    <?php endfor; ?>
                </div>
                <blockquote class="mt-4 text-sm leading-relaxed text-cream/85">"<?= e($t['pesan']) ?>"</blockquote>
                <figcaption class="mt-5 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-copper to-orange-600 font-bold text-white ring-2 ring-white/20">
                        <?= e(mb_strtoupper(mb_substr($t['nama'], 0, 1))) ?>
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-white"><?= e($t['nama']) ?></p>
                        <p class="text-xs text-cream/60"><?= e($t['peran']) ?></p>
                    </div>
                </figcaption>
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= ARTIKEL ================= -->
<section class="py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4" data-aos="fade-up">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">
                    <span class="h-px w-8 bg-copper"></span> Blog
                </span>
                <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Artikel Terbaru</h2>
            </div>
            <a href="<?= url('index.php?page=artikel') ?>" class="group inline-flex items-center gap-2 text-sm font-semibold text-copper transition hover:text-espresso">
                Semua Artikel <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
        <div class="mt-12 grid gap-7 md:grid-cols-3">
            <?php foreach ($artikels as $a): ?>
            <a href="<?= url('index.php?page=detail-artikel&id=' . (int)$a['id']) ?>" class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-soft transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10" data-aos="fade-up">
                <div class="product-img-wrap aspect-[16/9] bg-cream dark:bg-espresso">
                    <img src="<?= e(asset($a['gambar'] ?: 'assets/img/placeholder-coffee.svg')) ?>" loading="lazy" alt="<?= e($a['judul']) ?>" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                </div>
                <div class="flex flex-1 flex-col p-6">
                    <p class="flex items-center gap-2 text-xs text-coffee">
                        <i data-lucide="calendar" class="h-3.5 w-3.5"></i> <?= e(format_date($a['created_at'])) ?>
                    </p>
                    <h3 class="mt-2 line-clamp-2 text-base font-bold leading-snug transition-colors group-hover:text-copper"><?= e($a['judul']) ?></h3>
                    <p class="mt-2 line-clamp-2 text-sm text-espresso/70 dark:text-cream/70"><?= e(excerpt($a['ringkasan'], 90)) ?></p>
                    <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-copper">
                        Baca Selengkapnya <i data-lucide="arrow-right" class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= GALERI ================= -->
<section class="bg-gradient-to-b from-white/60 to-transparent py-24 dark:from-white/[0.02]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-xl text-center" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">Galeri</span>
            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Momen Kami</h2>
            <span class="mx-auto mt-4 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
        </div>
        <div class="mt-12 columns-1 gap-6 sm:columns-2 lg:columns-4">
            <?php foreach ($galeris as $g): ?>
            <button type="button" class="lightbox-trigger group relative mb-6 block w-full overflow-hidden rounded-2xl shadow-soft" data-full="<?= e(asset($g['gambar'])) ?>">
                <img src="<?= e(asset($g['gambar'])) ?>" loading="lazy" alt="<?= e($g['caption']) ?>" class="w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <span class="absolute inset-0 flex items-center justify-center bg-gradient-to-t from-espresso/70 via-espresso/10 to-transparent opacity-0 transition-all duration-300 group-hover:opacity-100">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white/15 backdrop-blur">
                        <i data-lucide="zoom-in" class="h-6 w-6 text-white"></i>
                    </span>
                </span>
                <?php if ($g['caption']): ?>
                    <span class="absolute bottom-3 left-3 right-3 translate-y-2 text-left text-xs font-medium text-white opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"><?= e($g['caption']) ?></span>
                <?php endif; ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= CTA WHATSAPP ================= -->
<section class="py-24">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-copper via-coffee to-espresso p-10 text-center text-white shadow-2xl shadow-copper/20 sm:p-16" data-aos="zoom-in">
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
            <i data-lucide="coffee" class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20 p-4"></i>
            <h2 class="relative mt-6 text-3xl font-extrabold sm:text-4xl">Tertarik dengan Kopi Kami?</h2>
            <p class="relative mx-auto mt-4 max-w-xl text-white/85">Hubungi kami langsung melalui WhatsApp untuk pemesanan dan konsultasi produk.</p>
            <a href="<?= whatsapp_link() ?>" target="_blank" class="group relative mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-8 py-3.5 font-semibold text-espresso shadow-xl transition-all duration-300 hover:-translate-y-0.5 hover:bg-cream">
                <i data-lucide="message-circle" class="h-5 w-5"></i> Chat via WhatsApp
                <i data-lucide="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- ================= LIGHTBOX ================= -->
<div id="lightbox" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/90 p-6">
    <button id="lightbox-close" class="absolute right-6 top-6 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20" aria-label="Tutup">
        <i data-lucide="x" class="h-5 w-5"></i>
    </button>
    <img id="lightbox-img" src="" alt="Preview" class="max-h-[85vh] max-w-full rounded-2xl object-contain shadow-2xl">
</div>