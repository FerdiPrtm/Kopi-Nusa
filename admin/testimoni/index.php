<?php
/** Testimoni: list + tambah + edit + hapus. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Testimoni';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = post('action');
    $id = (int)post('id', 0);

    if ($action === 'delete' && $id > 0) {
        db()->prepare("DELETE FROM testimoni WHERE id = :id")->execute(['id' => $id]);
        set_flash('success', 'Testimoni dihapus.');
        redirect(url('admin/testimoni/index.php'));
    }

    if ($action === 'save') {
        $nama = post('nama');
        $pesan = post('pesan');
        $rating = (int)post('rating', 5);
        if ($nama === '' || $pesan === '') {
            set_flash('error', 'Nama dan pesan wajib diisi.');
            redirect(url('admin/testimoni/index.php' . ($id > 0 ? '?edit=' . $id : '')));
        }
        $rating = max(1, min(5, $rating));
        $avatar = upload_image($_FILES['avatar'] ?? [], 'testimoni');

        if ($id > 0) {
            $old = db()->prepare("SELECT avatar FROM testimoni WHERE id = :id");
            $old->execute(['id' => $id]);
            $oldRow = $old->fetch();
            if ($avatar === null) $avatar = $oldRow['avatar'] ?? null;
            db()->prepare("UPDATE testimoni SET nama = :nama, peran = :peran, pesan = :pesan, rating = :rating, avatar = :avatar WHERE id = :id")
                ->execute(['nama' => $nama, 'peran' => post('peran'), 'pesan' => $pesan, 'rating' => $rating, 'avatar' => $avatar, 'id' => $id]);
            set_flash('success', 'Testimoni diperbarui.');
        } else {
            db()->prepare("INSERT INTO testimoni (nama, peran, pesan, rating, avatar) VALUES (:nama, :peran, :pesan, :rating, :avatar)")
                ->execute(['nama' => $nama, 'peran' => post('peran'), 'pesan' => $pesan, 'rating' => $rating, 'avatar' => $avatar]);
            set_flash('success', 'Testimoni ditambahkan.');
        }
        redirect(url('admin/testimoni/index.php'));
    }
}

$testimonis = db()->query("SELECT * FROM testimoni ORDER BY id DESC")->fetchAll();

$edit = null;
$editId = (int)get('edit', 0);
if ($editId > 0) {
    $stmt = db()->prepare("SELECT * FROM testimoni WHERE id = :id");
    $stmt->execute(['id' => $editId]);
    $edit = $stmt->fetch();
}

require_once __DIR__ . '/../layout/head.php';
?>

<div class="grid gap-6 lg:grid-cols-3">
    <!-- Form -->
    <div class="rounded-2xl bg-white p-6 shadow-soft">
        <h3 class="text-lg font-bold"><?= $edit ? 'Edit Testimoni' : 'Tambah Testimoni' ?></h3>
        <form method="post" enctype="multipart/form-data" class="mt-5 space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama" required value="<?= e($edit['nama'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Peran</label>
                <input type="text" name="peran" value="<?= e($edit['peran'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="cth: Pelanggan setia">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Pesan <span class="text-red-500">*</span></label>
                <textarea name="pesan" required rows="4" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper"><?= e($edit['pesan'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Rating (1-5)</label>
                <select name="rating" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= (int)($edit['rating'] ?? 5) === $i ? 'selected' : '' ?>><?= $i ?> Bintang</option>
                    <?php endfor; ?>
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Avatar <span class="text-xs text-espresso/50">(opsional)</span></label>
                <img id="preview-avatar" src="<?= e(asset($edit['avatar'] ?? 'assets/img/placeholder-coffee.svg')) ?>" class="h-20 w-20 rounded-full object-cover" alt="Avatar">
                <input type="file" name="avatar" data-preview="preview-avatar" accept="image/*" class="mt-3 w-full text-sm text-espresso/60 file:mr-3 file:rounded-lg file:border-0 file:bg-copper/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-copper">
            </div>
            <button type="submit" class="w-full rounded-xl bg-copper py-3 font-semibold text-white transition-all duration-300 hover:bg-espresso"><?= $edit ? 'Simpan Perubahan' : 'Tambah Testimoni' ?></button>
            <?php if ($edit): ?><a href="<?= url('admin/testimoni/index.php') ?>" class="block rounded-xl border border-cream py-3 text-center text-sm font-semibold text-espresso/60 transition hover:border-copper hover:text-copper">Batal</a><?php endif; ?>
        </form>
    </div>

    <!-- List -->
    <div class="space-y-4 lg:col-span-2">
        <?php foreach ($testimonis as $t): ?>
        <div class="flex items-start gap-4 rounded-2xl bg-white p-5 shadow-soft">
            <img src="<?= e(asset($t['avatar'] ?: 'assets/img/placeholder-coffee.svg')) ?>" alt="<?= e($t['nama']) ?>" class="h-12 w-12 rounded-full object-cover">
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <p class="font-semibold"><?= e($t['nama']) ?></p>
                        <p class="text-xs text-espresso/50"><?= e($t['peran']) ?></p>
                    </div>
                    <div class="flex gap-1 text-copper">
                        <?php for ($i = 1; $i <= 5; $i++): ?><i data-lucide="star" class="h-3.5 w-3.5 <?= $i <= (int)$t['rating'] ? '' : 'opacity-25' ?>"></i><?php endfor; ?>
                    </div>
                </div>
                <p class="mt-2 text-sm text-espresso/70">"<?= e(excerpt($t['pesan'], 160)) ?>"</p>
                <div class="mt-3 flex gap-2">
                    <a href="<?= url('admin/testimoni/index.php?edit=' . (int)$t['id']) ?>" class="flex h-8 w-8 items-center justify-center rounded-lg bg-olive/10 text-olive transition hover:bg-olive hover:text-white"><i data-lucide="pencil" class="h-3.5 w-3.5"></i></a>
                    <form method="post" data-confirm="Hapus testimoni ini?" class="inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                        <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-500 transition hover:bg-red-500 hover:text-white"><i data-lucide="trash-2" class="h-3.5 w-3.5"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (count($testimonis) === 0): ?>
        <div class="rounded-2xl bg-white p-12 text-center text-espresso/50 shadow-soft">Belum ada testimoni.</div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>