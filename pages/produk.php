<?php
/**
 * Halaman Produk: search, filter kategori, sorting, pagination, lazy load.
 */
$pageTitle = 'Produk';

$q    = get('q');
$kat  = (int)get('kategori', 0);
$sort = get('sort', 'terbaru');
$pageN = max(1, (int)get('hal', 1));
$perPage = 9;

$where = ['1=1'];
$params = [];

if ($q !== '') {
    $where[] = '(p.nama LIKE :q OR p.deskripsi LIKE :q)';
    $params['q'] = '%' . $q . '%';
}
if ($kat > 0) {
    $where[] = 'p.kategori_id = :kat';
    $params['kat'] = $kat;
}

$orderMap = [
    'terbaru'  => 'p.id DESC',
    'termurah' => 'p.harga ASC',
    'termahal' => 'p.harga DESC',
    'nama'     => 'p.nama ASC',
];
$order = $orderMap[$sort] ?? $orderMap['terbaru'];

$whereSql = implode(' AND ', $where);

// Total untuk pagination
$stmt = db()->prepare("SELECT COUNT(*) FROM produk p WHERE $whereSql");
$stmt->execute($params);
$total = (int)$stmt->fetchColumn();
$totalPages = max(1, (int)ceil($total / $perPage));
$offset = ($pageN - 1) * $perPage;

// Data produk
$stmt = db()->prepare(
    "SELECT p.*, k.nama AS kategori_nama
       FROM produk p
       JOIN kategori k ON k.id = p.kategori_id
      WHERE $whereSql
      ORDER BY $order
      LIMIT $perPage OFFSET $offset"
);
$stmt->execute($params);
$produks = $stmt->fetchAll();

// Kategori untuk filter
$kategoris = db()->query("SELECT * FROM kategori ORDER BY nama ASC")->fetchAll();
?>

<?php $currentPage = 'produk'; ?>

<!-- Page header -->
<section class="bg-espresso pb-16 pt-32 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <p class="text-sm font-semibold uppercase tracking-widest text-copper" data-aos="fade-up">Katalog</p>
        <h1 class="mt-3 text-4xl font-extrabold" data-aos="fade-up" data-aos-delay="100">Semua Produk</h1>
        <p class="mt-3 max-w-xl text-white/80" data-aos="fade-up" data-aos-delay="150">Jelajahi koleksi kopi dan peralatan pilihan kami.</p>
    </div>
</section>

<!-- Filter bar -->
<section class="mx-auto -mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
    <form method="get" class="rounded-2xl bg-white p-4 shadow-soft dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10 sm:p-6" data-aos="fade-up">
        <input type="hidden" name="page" value="produk">
        <div class="grid items-center gap-3 md:grid-cols-[1fr_auto_auto_auto]">
            <div class="relative">
                <i data-lucide="search" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-coffee"></i>
                <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari produk..." class="w-full rounded-xl border border-cream bg-cream/60 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5 dark:placeholder:text-cream/40">
            </div>
            <select name="kategori" class="rounded-xl border border-cream bg-cream/60 py-3 px-4 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5">
                <option value="0">Semua Kategori</option>
                <?php foreach ($kategoris as $k): ?>
                    <option value="<?= (int)$k['id'] ?>" <?= $kat === (int)$k['id'] ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort" class="rounded-xl border border-cream bg-cream/60 py-3 px-4 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5">
                <option value="terbaru"  <?= $sort === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                <option value="termurah" <?= $sort === 'termurah' ? 'selected' : '' ?>>Termurah</option>
                <option value="termahal" <?= $sort === 'termahal' ? 'selected' : '' ?>>Termahal</option>
                <option value="nama"     <?= $sort === 'nama' ? 'selected' : '' ?>>Nama A-Z</option>
            </select>
            <button type="submit" class="rounded-xl bg-copper px-6 py-3 text-sm font-semibold text-white shadow-soft transition-all duration-300 hover:bg-espresso">Terapkan</button>
        </div>
    </form>
</section>

<!-- Product grid -->
<section class="py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <p class="mb-8 flex items-center gap-2 text-sm text-espresso/60 dark:text-cream/60">
            Menampilkan <b class="text-copper"><?= $total ?></b> produk
            <?php if ($q !== ''): ?> dari pencarian "<b><?= e($q) ?></b>"<a href="<?= url('index.php?page=produk') ?>" class="ml-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-copper/10 text-copper transition hover:bg-copper hover:text-white" title="Hapus pencarian"><i data-lucide="x" class="h-3.5 w-3.5"></i></a><?php endif; ?>
        </p>

        <?php if (count($produks) > 0): ?>
            <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($produks as $p): include __DIR__ . '/../includes/product-card.php'; endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <nav class="mt-12 flex justify-center" aria-label="Pagination">
                    <ul class="flex items-center gap-2">
                        <?php if ($pageN > 1): ?>
                            <?php $prev = ['page' => 'produk', 'hal' => $pageN - 1]; if ($q) $prev['q'] = $q; if ($kat) $prev['kategori'] = $kat; if ($sort !== 'terbaru') $prev['sort'] = $sort; ?>
                            <li>
                                <a href="<?= url('index.php?' . http_build_query($prev)) ?>" aria-label="Sebelumnya" class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-espresso shadow-soft transition-all duration-300 hover:bg-cream dark:bg-white/5 dark:text-cream dark:hover:bg-white/10">
                                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php
                            $linkParams = ['page' => 'produk', 'hal' => $i];
                            if ($q) $linkParams['q'] = $q;
                            if ($kat) $linkParams['kategori'] = $kat;
                            if ($sort !== 'terbaru') $linkParams['sort'] = $sort;
                            ?>
                            <li>
                                <a href="<?= url('index.php?' . http_build_query($linkParams)) ?>"
                                   class="flex h-11 min-w-11 items-center justify-center rounded-xl px-3 text-sm font-semibold transition-all duration-300 <?= $i === $pageN ? 'bg-copper text-white shadow-soft' : 'bg-white text-espresso hover:bg-cream dark:bg-white/5 dark:text-cream dark:hover:bg-white/10' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($pageN < $totalPages): ?>
                            <?php $next = ['page' => 'produk', 'hal' => $pageN + 1]; if ($q) $next['q'] = $q; if ($kat) $next['kategori'] = $kat; if ($sort !== 'terbaru') $next['sort'] = $sort; ?>
                            <li>
                                <a href="<?= url('index.php?' . http_build_query($next)) ?>" aria-label="Berikutnya" class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-espresso shadow-soft transition-all duration-300 hover:bg-cream dark:bg-white/5 dark:text-cream dark:hover:bg-white/10">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="py-20 text-center">
                <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-copper/10"><i data-lucide="package-open" class="h-10 w-10 text-copper/50"></i></span>
                <p class="mt-5 text-lg font-semibold">Produk tidak ditemukan</p>
                <p class="text-sm text-espresso/60 dark:text-cream/60">Coba kata kunci atau filter lain.</p>
                <a href="<?= url('index.php?page=produk') ?>" class="mt-5 inline-flex items-center gap-2 rounded-xl border border-copper px-6 py-2.5 text-sm font-semibold text-copper transition hover:bg-copper hover:text-white">Reset Filter</a>
            </div>
        <?php endif; ?>
    </div>
</section>