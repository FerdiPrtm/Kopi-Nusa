<?php
/** Produk: list + hapus. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Produk';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (post('action') === 'delete') {
        $id = (int)post('id', 0);
        $stmt = db()->prepare("SELECT * FROM produk WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $p = $stmt->fetch();
        if ($p) {
            foreach (['gambar', 'gambar_2', 'gambar_3'] as $col) {
                delete_uploaded($p[$col]);
            }
            db()->prepare("DELETE FROM produk WHERE id = :id")->execute(['id' => $id]);
            set_flash('success', 'Produk berhasil dihapus.');
        }
        redirect(url('admin/produk/index.php'));
    }
}

$q = get('q');
$where = '1=1';
$params = [];
if ($q !== '') {
    $where = '(p.nama LIKE :q OR p.deskripsi LIKE :q)';
    $params['q'] = '%' . $q . '%';
}

$stmt = db()->prepare(
    "SELECT p.*, k.nama AS kategori_nama
       FROM produk p
       JOIN kategori k ON k.id = p.kategori_id
      WHERE $where ORDER BY p.id DESC"
);
$stmt->execute($params);
$produks = $stmt->fetchAll();

require_once __DIR__ . '/../layout/head.php';
?>

<div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <p class="text-sm text-espresso/60">Total <?= count($produks) ?> produk</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <form method="get" class="relative">
            <i data-lucide="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-coffee"></i>
            <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari produk..." class="w-full rounded-xl border border-cream bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-copper sm:w-52">
        </form>
        <a href="<?= url('admin/produk/create.php') ?>" class="inline-flex items-center gap-2 rounded-xl bg-copper px-5 py-2.5 text-sm font-semibold text-white shadow-soft transition-all duration-300 hover:bg-espresso">
            <i data-lucide="plus" class="h-4 w-4"></i> Tambah Produk
        </a>
    </div>
</div>

<div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-soft">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-cream text-xs uppercase text-espresso/50">
                    <th class="px-5 py-4">Produk</th>
                    <th class="px-5 py-4">Kategori</th>
                    <th class="px-5 py-4">Harga</th>
                    <th class="px-5 py-4">Stok</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produks as $p): ?>
                <tr class="border-b border-cream/70 hover:bg-cream/40">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="<?= e(asset($p['gambar'])) ?>" alt="<?= e($p['nama']) ?>" class="h-12 w-14 rounded-lg object-cover">
                            <div>
                                <p class="font-semibold"><?= e($p['nama']) ?></p>
                                <p class="text-xs text-espresso/50">#<?= (int)$p['id'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3"><?= e($p['kategori_nama']) ?></td>
                    <td class="px-5 py-3 font-semibold text-copper"><?= e(rupiah($p['harga'])) ?></td>
                    <td class="px-5 py-3">
                        <span class="rounded-lg px-2 py-1 text-xs font-semibold <?= (int)$p['stok'] > 0 ? 'bg-olive/10 text-olive' : 'bg-red-100 text-red-500' ?>"><?= (int)$p['stok'] ?></span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1.5">
                            <?php if (!empty($p['best_seller'])): ?><span class="rounded-lg bg-espresso/10 px-2 py-1 text-[11px] font-semibold text-espresso">Best Seller</span><?php endif; ?>
                            <?php if (!empty($p['promo'])): ?><span class="rounded-lg bg-copper/10 px-2 py-1 text-[11px] font-semibold text-copper">Promo</span><?php endif; ?>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="<?= url('index.php?page=detail&id=' . (int)$p['id']) ?>" target="_blank" class="flex h-9 w-9 items-center justify-center rounded-lg bg-cream text-espresso/60 transition hover:bg-coffee hover:text-white" title="Lihat"><i data-lucide="eye" class="h-4 w-4"></i></a>
                            <a href="<?= url('admin/produk/edit.php?id=' . (int)$p['id']) ?>" class="flex h-9 w-9 items-center justify-center rounded-lg bg-olive/10 text-olive transition hover:bg-olive hover:text-white" title="Edit"><i data-lucide="pencil" class="h-4 w-4"></i></a>
                            <form method="post" data-confirm="Hapus produk ini?" class="inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                                <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500 transition hover:bg-red-500 hover:text-white" title="Hapus"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (count($produks) === 0): ?>
                <tr><td colspan="6" class="px-5 py-12 text-center text-espresso/50">Tidak ada produk.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>