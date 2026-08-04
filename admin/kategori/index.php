<?php
/** Kategori: list, tambah, edit, hapus. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Kategori';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = post('action');
    $id = (int)post('id', 0);

    if ($action === 'delete' && $id > 0) {
        db()->prepare("DELETE FROM kategori WHERE id = :id")->execute(['id' => $id]);
        set_flash('success', 'Kategori berhasil dihapus.');
        redirect(url('admin/kategori/index.php'));
    }

    if ($action === 'save') {
        $nama = post('nama');
        $slug = post('slug') !== '' ? slugify(post('slug')) : slugify($nama);
        if ($nama === '') {
            set_flash('error', 'Nama kategori wajib diisi.');
            redirect(url('admin/kategori/index.php'));
        }
        if ($id > 0) {
            db()->prepare("UPDATE kategori SET nama = :nama, slug = :slug WHERE id = :id")
                ->execute(['nama' => $nama, 'slug' => $slug, 'id' => $id]);
            set_flash('success', 'Kategori berhasil diperbarui.');
        } else {
            db()->prepare("INSERT INTO kategori (nama, slug) VALUES (:nama, :slug)")
                ->execute(['nama' => $nama, 'slug' => $slug]);
            set_flash('success', 'Kategori berhasil ditambahkan.');
        }
        redirect(url('admin/kategori/index.php'));
    }
}

$kategoris = db()->query("SELECT k.*, (SELECT COUNT(*) FROM produk p WHERE p.kategori_id = k.id) AS jumlah_produk FROM kategori k ORDER BY k.id DESC")->fetchAll();

// Data untuk edit
$edit = null;
$editId = (int)get('edit', 0);
if ($editId > 0) {
    $stmt = db()->prepare("SELECT * FROM kategori WHERE id = :id");
    $stmt->execute(['id' => $editId]);
    $edit = $stmt->fetch();
}

require_once __DIR__ . '/../layout/head.php';
?>

<div class="grid gap-6 lg:grid-cols-3">
    <!-- Form tambah/edit -->
    <div class="rounded-2xl bg-white p-6 shadow-soft">
        <h3 class="text-lg font-bold"><?= $edit ? 'Edit Kategori' : 'Tambah Kategori' ?></h3>
        <form method="post" class="mt-5 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Nama Kategori</label>
                <input type="text" name="nama" required value="<?= e($edit['nama'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="cth: Biji Kopi">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Slug <span class="text-xs text-espresso/50">(kosongkan untuk otomatis)</span></label>
                <input type="text" name="slug" value="<?= e($edit['slug'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="biji-kopi">
            </div>
            <button type="submit" class="w-full rounded-xl bg-copper py-3 font-semibold text-white transition-all duration-300 hover:bg-espresso">
                <?= $edit ? 'Simpan Perubahan' : 'Tambah Kategori' ?>
            </button>
            <?php if ($edit): ?>
                <a href="<?= url('admin/kategori/index.php') ?>" class="block rounded-xl border border-cream py-3 text-center text-sm font-semibold text-espresso/60 transition hover:border-copper hover:text-copper">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tabel -->
    <div class="rounded-2xl bg-white p-6 shadow-soft lg:col-span-2">
        <h3 class="text-lg font-bold">Daftar Kategori</h3>
        <div class="mt-5 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-cream text-xs uppercase text-espresso/50">
                        <th class="px-3 py-3">ID</th>
                        <th class="px-3 py-3">Nama</th>
                        <th class="px-3 py-3">Slug</th>
                        <th class="px-3 py-3">Produk</th>
                        <th class="px-3 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kategoris as $k): ?>
                    <tr class="border-b border-cream/70">
                        <td class="px-3 py-3 text-espresso/60">#<?= (int)$k['id'] ?></td>
                        <td class="px-3 py-3 font-semibold"><?= e($k['nama']) ?></td>
                        <td class="px-3 py-3 text-espresso/60"><?= e($k['slug']) ?></td>
                        <td class="px-3 py-3"><span class="rounded-lg bg-copper/10 px-2 py-1 text-xs font-semibold text-copper"><?= (int)$k['jumlah_produk'] ?></span></td>
                        <td class="px-3 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="<?= url('admin/kategori/index.php?edit=' . (int)$k['id']) ?>" class="flex h-9 w-9 items-center justify-center rounded-lg bg-olive/10 text-olive transition hover:bg-olive hover:text-white" title="Edit"><i data-lucide="pencil" class="h-4 w-4"></i></a>
                                <form method="post" data-confirm="Hapus kategori ini? Produk di dalamnya ikut terhapus." class="inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int)$k['id'] ?>">
                                    <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500 transition hover:bg-red-500 hover:text-white" title="Hapus"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (count($kategoris) === 0): ?>
                    <tr><td colspan="5" class="px-3 py-10 text-center text-espresso/50">Belum ada kategori.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>