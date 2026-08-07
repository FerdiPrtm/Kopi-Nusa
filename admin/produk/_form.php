<?php
/**
 * Form produk (dipakai oleh create.php dan edit.php).
 * @var array|null $p data produk saat edit
 * @var array $kategoris daftar kategori
 */
$p = $p ?? null;
$isEdit = $p !== null;
?>

<form method="post" enctype="multipart/form-data" class="space-y-8">
    <?= csrf_field() ?>
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Kolom kiri: info utama -->
        <div class="space-y-5 rounded-2xl bg-white p-6 shadow-soft lg:col-span-2">
            <h3 class="text-lg font-bold">Informasi Produk</h3>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" required value="<?= e($p['nama'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="Nama produk">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori_id" required class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
                        <?php foreach ($kategoris as $k): ?>
                            <option value="<?= (int)$k['id'] ?>" <?= ($p['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>><?= e($k['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Slug <span class="text-xs text-espresso/50">(kosongkan untuk otomatis)</span></label>
                    <input type="text" name="slug" value="<?= e($p['slug'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="nama-produk">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" required min="0" value="<?= (int)($p['harga'] ?? 0) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="50000">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" required min="0" value="<?= (int)($p['stok'] ?? 0) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="10">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Berat</label>
                    <input type="text" name="berat" value="<?= e($p['berat'] ?? '250 gram') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="250 gram">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Diskon (%)</label>
                    <input type="number" name="diskon" min="0" max="100" value="<?= (int)($p['diskon'] ?? 0) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="10">
                </div>
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" required rows="5" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="Deskripsi produk..."><?= e($p['deskripsi'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-cream p-4 transition hover:border-copper">
                    <input type="checkbox" name="best_seller" value="1" class="h-4 w-4 accent-copper" <?= !empty($p['best_seller']) ? 'checked' : '' ?>>
                    <span class="text-sm font-medium">Tandai Best Seller</span>
                </label>
                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-cream p-4 transition hover:border-copper">
                    <input type="checkbox" name="promo" value="1" class="h-4 w-4 accent-copper" <?= !empty($p['promo']) ? 'checked' : '' ?>>
                    <span class="text-sm font-medium">Tandai Promo</span>
                </label>
            </div>
        </div>

        <!-- Kolom kanan: gambar -->
        <div class="space-y-5">
            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="text-lg font-bold">Gambar Utama <span class="text-red-500">*</span></h3>
                <img id="preview-gambar" src="<?= e(asset($p['gambar'] ?? 'assets/img/placeholder-coffee.svg')) ?>" class="mt-4 aspect-[4/3] w-full rounded-xl object-cover" alt="Preview">
                <input type="file" name="gambar" data-preview="preview-gambar" accept="image/*" class="mt-4 w-full text-sm text-espresso/60 file:mr-3 file:rounded-lg file:border-0 file:bg-copper/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-copper">
                <p class="mt-2 text-xs text-espresso/50">Maksimal 2 MB. Format: JPG, PNG, WEBP, GIF.</p>
            </div>
            <?php foreach (['gambar_2' => 'Gambar 2', 'gambar_3' => 'Gambar 3'] as $field => $label): ?>
            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="text-lg font-bold"><?= $label ?> <span class="text-xs font-normal text-espresso/50">(opsional)</span></h3>
                <img id="preview-<?= $field ?>" src="<?= e(asset($p[$field] ?? 'assets/img/placeholder-coffee.svg')) ?>" class="mt-4 aspect-[4/3] w-full rounded-xl object-cover" alt="Preview">
                <input type="file" name="<?= $field ?>" data-preview="preview-<?= $field ?>" accept="image/*" class="mt-4 w-full text-sm text-espresso/60 file:mr-3 file:rounded-lg file:border-0 file:bg-copper/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-copper">
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-4">
        <button type="submit" class="rounded-xl bg-copper px-8 py-3 font-semibold text-white shadow-soft transition-all duration-300 hover:bg-espresso">
            <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Produk' ?>
        </button>
        <a href="<?= url('admin/produk/index.php') ?>" class="rounded-xl border border-cream px-6 py-3 text-sm font-semibold text-espresso/60 transition hover:border-copper hover:text-copper">Batal</a>
    </div>
</form>