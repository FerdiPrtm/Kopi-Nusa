<?php
/** Artikel: list + hapus. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Artikel';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    if (post('action') === 'delete') {
        $id = (int)post('id', 0);
        $stmt = db()->prepare("SELECT gambar FROM artikel WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $a = $stmt->fetch();
        if ($a) {
            delete_uploaded($a['gambar']);
            db()->prepare("DELETE FROM artikel WHERE id = :id")->execute(['id' => $id]);
            set_flash('success', 'Artikel berhasil dihapus.');
        }
        redirect(url('admin/artikel/index.php'));
    }
}

$artikels = db()->query("SELECT * FROM artikel ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/../layout/head.php';
?>

<div class="flex flex-wrap items-center justify-between gap-4">
    <p class="text-sm text-espresso/60">Total <?= count($artikels) ?> artikel</p>
    <a href="<?= url('admin/artikel/create.php') ?>" class="inline-flex items-center gap-2 rounded-xl bg-copper px-5 py-2.5 text-sm font-semibold text-white shadow-soft transition-all duration-300 hover:bg-espresso">
        <i data-lucide="plus" class="h-4 w-4"></i> Tulis Artikel
    </a>
</div>

<div class="mt-6 overflow-hidden rounded-2xl bg-white shadow-soft">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-cream text-xs uppercase text-espresso/50">
                    <th class="px-5 py-4">Artikel</th>
                    <th class="px-5 py-4">Penulis</th>
                    <th class="px-5 py-4">Tanggal</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($artikels as $a): ?>
                <tr class="border-b border-cream/70 hover:bg-cream/40">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="<?= e(asset($a['gambar'] ?: 'assets/img/placeholder-coffee.svg')) ?>" alt="<?= e($a['judul']) ?>" class="h-12 w-16 rounded-lg object-cover">
                            <div class="max-w-sm">
                                <p class="truncate font-semibold"><?= e($a['judul']) ?></p>
                                <p class="truncate text-xs text-espresso/50"><?= e(excerpt($a['ringkasan'], 60)) ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3"><?= e($a['penulis']) ?></td>
                    <td class="px-5 py-3"><?= e(format_date($a['created_at'])) ?></td>
                    <td class="px-5 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="<?= url('index.php?page=detail-artikel&id=' . (int)$a['id']) ?>" target="_blank" class="flex h-9 w-9 items-center justify-center rounded-lg bg-cream text-espresso/60 transition hover:bg-coffee hover:text-white" title="Lihat"><i data-lucide="eye" class="h-4 w-4"></i></a>
                            <a href="<?= url('admin/artikel/edit.php?id=' . (int)$a['id']) ?>" class="flex h-9 w-9 items-center justify-center rounded-lg bg-olive/10 text-olive transition hover:bg-olive hover:text-white" title="Edit"><i data-lucide="pencil" class="h-4 w-4"></i></a>
                            <form method="post" data-confirm="Hapus artikel ini?" class="inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                                <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500 transition hover:bg-red-500 hover:text-white" title="Hapus"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (count($artikels) === 0): ?>
                <tr><td colspan="4" class="px-5 py-12 text-center text-espresso/50">Belum ada artikel.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>