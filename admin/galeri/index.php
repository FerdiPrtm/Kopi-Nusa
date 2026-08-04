<?php
/** Galeri: list + tambah + hapus. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Galeri';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = post('action');

    if ($action === 'delete') {
        $id = (int)post('id', 0);
        $stmt = db()->prepare("SELECT gambar FROM galeri WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $g = $stmt->fetch();
        if ($g) {
            delete_uploaded($g['gambar']);
            db()->prepare("DELETE FROM galeri WHERE id = :id")->execute(['id' => $id]);
            set_flash('success', 'Gambar galeri dihapus.');
        }
        redirect(url('admin/galeri/index.php'));
    }

    if ($action === 'save') {
        try {
            $gambar = upload_image($_FILES['gambar'] ?? [], 'galeri');
            if (!$gambar) {
                throw new Exception('Gambar wajib diunggah.');
            }
            db()->prepare("INSERT INTO galeri (gambar, caption) VALUES (:gambar, :caption)")
                ->execute(['gambar' => $gambar, 'caption' => post('caption')]);
            set_flash('success', 'Gambar berhasil ditambahkan.');
        } catch (Exception $e) {
            set_flash('error', $e->getMessage());
        }
        redirect(url('admin/galeri/index.php'));
    }
}

$galeris = db()->query("SELECT * FROM galeri ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/../layout/head.php';
?>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="rounded-2xl bg-white p-6 shadow-soft">
        <h3 class="text-lg font-bold">Tambah Gambar</h3>
        <form method="post" enctype="multipart/form-data" class="mt-5 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Gambar <span class="text-red-500">*</span></label>
                <img id="preview-gambar" src="<?= url('assets/img/placeholder-coffee.svg') ?>" class="aspect-[4/3] w-full rounded-xl object-cover" alt="Preview">
                <input type="file" name="gambar" data-preview="preview-gambar" accept="image/*" required class="mt-4 w-full text-sm text-espresso/60 file:mr-3 file:rounded-lg file:border-0 file:bg-copper/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-copper">
                <p class="mt-2 text-xs text-espresso/50">Maksimal 2 MB.</p>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Caption</label>
                <input type="text" name="caption" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="Keterangan gambar">
            </div>
            <button type="submit" class="w-full rounded-xl bg-copper py-3 font-semibold text-white transition-all duration-300 hover:bg-espresso">Unggah Gambar</button>
        </form>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-soft lg:col-span-2">
        <h3 class="text-lg font-bold">Koleksi Galeri (<?= count($galeris) ?>)</h3>
        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3">
            <?php foreach ($galeris as $g): ?>
            <div class="group relative overflow-hidden rounded-2xl">
                <img src="<?= e(asset($g['gambar'])) ?>" alt="<?= e($g['caption']) ?>" class="aspect-square w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 flex flex-col justify-between bg-gradient-to-t from-black/70 via-black/10 to-transparent p-3 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <form method="post" data-confirm="Hapus gambar ini?" class="ml-auto">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$g['id'] ?>">
                        <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/20 text-white backdrop-blur transition hover:bg-red-500" title="Hapus"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                    </form>
                    <?php if ($g['caption']): ?><p class="text-xs font-medium text-white"><?= e($g['caption']) ?></p><?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>