<?php
/** Dashboard admin: statistik card + ringkasan. */
require_once __DIR__ . '/config/init.php';
require_login();

$title = 'Dashboard';

$counts = [
    'produk'    => (int)db()->query("SELECT COUNT(*) FROM produk")->fetchColumn(),
    'kategori'  => (int)db()->query("SELECT COUNT(*) FROM kategori")->fetchColumn(),
    'artikel'   => (int)db()->query("SELECT COUNT(*) FROM artikel")->fetchColumn(),
    'galeri'    => (int)db()->query("SELECT COUNT(*) FROM galeri")->fetchColumn(),
    'testimoni' => (int)db()->query("SELECT COUNT(*) FROM testimoni")->fetchColumn(),
    'pesan'     => (int)db()->query("SELECT COUNT(*) FROM kontak")->fetchColumn(),
    'pesan_belum' => (int)db()->query("SELECT COUNT(*) FROM kontak WHERE is_read = 0")->fetchColumn(),
    'stok_kosong' => (int)db()->query("SELECT COUNT(*) FROM produk WHERE stok <= 0")->fetchColumn(),
];

$stok = (int)db()->query("SELECT COALESCE(SUM(stok), 0) FROM produk")->fetchColumn();
$totalNilai = (int)db()->query("SELECT COALESCE(SUM(harga * stok), 0) FROM produk")->fetchColumn();

$pesanTerbaru = db()->query("SELECT * FROM kontak ORDER BY created_at DESC LIMIT 5")->fetchAll();

require_once __DIR__ . '/layout/head.php';
?>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <?php
    $cards = [
        ['coffee', 'Total Produk', $counts['produk'], 'bg-copper/10 text-copper'],
        ['tags', 'Kategori', $counts['kategori'], 'bg-olive/10 text-olive'],
        ['newspaper', 'Artikel', $counts['artikel'], 'bg-blue-100 text-blue-600'],
        ['image', 'Galeri', $counts['galeri'], 'bg-purple-100 text-purple-600'],
        ['message-square-quote', 'Testimoni', $counts['testimoni'], 'bg-pink-100 text-pink-600'],
        ['inbox', 'Pesan Masuk', $counts['pesan'], 'bg-amber-100 text-amber-600'],
        ['layers', 'Total Stok', $stok, 'bg-teal-100 text-teal-600'],
        ['package-x', 'Stok Kosong', $counts['stok_kosong'], 'bg-red-100 text-red-600'],
    ];
    foreach ($cards as $c): ?>
    <div class="rounded-2xl bg-white p-6 shadow-soft transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" data-aos="fade-up">
        <div class="flex items-center justify-between">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl <?= $c[2] ?>">
                <i data-lucide="<?= $c[0] ?>" class="h-6 w-6"></i>
            </span>
            <span class="text-2xl font-extrabold"><?= $c[2] ?></span>
        </div>
        <p class="mt-4 text-sm text-espresso/60"><?= $c[1] ?></p>
    </div>
    <?php endforeach; ?>
</div>

<div class="mt-6 grid gap-6 rounded-2xl bg-espresso p-8 text-white" data-aos="fade-up">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm text-cream/60">Total Nilai Persediaan Produk</p>
            <p class="mt-1 text-3xl font-extrabold text-copper"><?= e(rupiah($totalNilai)) ?></p>
        </div>
        <div class="flex items-center gap-2 rounded-xl bg-white/10 px-4 py-3">
            <i data-lucide="bell-ring" class="h-5 w-5 text-copper"></i>
            <span><?= $counts['pesan_belum'] ?> pesan belum dibaca</span>
        </div>
    </div>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="rounded-2xl bg-white p-6 shadow-soft" data-aos="fade-up">
        <h3 class="text-lg font-bold">Pesan Masuk Terbaru</h3>
        <?php if (count($pesanTerbaru) > 0): ?>
            <div class="mt-4 space-y-3">
                <?php foreach ($pesanTerbaru as $pm): ?>
                <div class="flex items-start gap-3 rounded-xl border border-cream p-4 <?= $pm['is_read'] ? '' : 'border-copper/50 bg-copper/5' ?>">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-copper/10 font-bold text-copper"><?= e(mb_strtoupper(mb_substr($pm['nama'], 0, 1))) ?></span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2">
                            <p class="truncate font-semibold"><?= e($pm['nama']) ?></p>
                            <span class="shrink-0 text-xs text-espresso/50"><?= e(format_date($pm['created_at'], 'd M H:i')) ?></span>
                        </div>
                        <p class="mt-1 truncate text-sm text-espresso/70"><?= e(excerpt($pm['pesan'], 70)) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mt-4 text-sm text-espresso/50">Belum ada pesan.</p>
        <?php endif; ?>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-soft" data-aos="fade-up">
        <h3 class="text-lg font-bold">Akses Cepat</h3>
        <div class="mt-4 grid gap-3">
            <?php
            $quick = [
                ['coffee', 'Tambah Produk', 'produk/create.php'],
                ['tags', 'Kelola Kategori', 'kategori/index.php'],
                ['newspaper', 'Tulis Artikel', 'artikel/create.php'],
                ['image', 'Unggah Galeri', 'galeri/create.php'],
                ['pencil', 'Tambah Testimoni', 'testimoni/create.php'],
            ];
            foreach ($quick as $q): ?>
            <a href="<?= url('admin/' . $q[2]) ?>" class="flex items-center gap-3 rounded-xl border border-cream px-4 py-3 transition-all duration-300 hover:-translate-y-0.5 hover:border-copper hover:shadow-soft">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-copper/10 text-copper"><i data-lucide="<?= $q[0] ?>" class="h-4 w-4"></i></span>
                <span class="text-sm font-semibold"><?= $q[1] ?></span>
                <i data-lucide="arrow-right" class="ml-auto h-4 w-4 text-espresso/40"></i>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>