<?php
/** Form artikel (create & edit). @var array|null $a */
$a = $a ?? null;
?>
<form method="post" enctype="multipart/form-data" class="space-y-6 rounded-2xl bg-white p-6 shadow-soft sm:p-8">
    <?= csrf_field() ?>
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            <div>
                <label class="mb-1.5 block text-sm font-medium">Judul <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required value="<?= e($a['judul'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="Judul artikel">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Slug <span class="text-xs text-espresso/50">(kosongkan untuk otomatis)</span></label>
                <input type="text" name="slug" value="<?= e($a['slug'] ?? '') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="slug-artikel">
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Ringkasan <span class="text-xs text-espresso/50">(opsional)</span></label>
                <textarea name="ringkasan" rows="3" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="Ringkasan singkat..."><?= e($a['ringkasan'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Isi Artikel <span class="text-red-500">*</span></label>
                <textarea name="isi" required rows="16" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 font-mono text-sm outline-none transition focus:border-copper" placeholder="Tulis konten artikel di sini. Mendukung tag HTML dasar (<p>, <h2>, <strong>, dll)."><?= e($a['isi'] ?? '') ?></textarea>
                <p class="mt-2 text-xs text-espresso/50">Mendukung tag HTML dasar: &lt;p&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;blockquote&gt;.</p>
            </div>
        </div>
        <div class="space-y-5">
            <div class="rounded-2xl border border-cream p-5">
                <label class="mb-1.5 block text-sm font-medium">Gambar <span class="text-xs text-espresso/50">(opsional)</span></label>
                <img id="preview-gambar" src="<?= e(asset($a['gambar'] ?? 'assets/img/placeholder-coffee.svg')) ?>" class="aspect-[16/9] w-full rounded-xl object-cover" alt="Preview">
                <input type="file" name="gambar" data-preview="preview-gambar" accept="image/*" class="mt-4 w-full text-sm text-espresso/60 file:mr-3 file:rounded-lg file:border-0 file:bg-copper/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-copper">
                <p class="mt-2 text-xs text-espresso/50">Maksimal 2 MB.</p>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium">Penulis</label>
                <input type="text" name="penulis" value="<?= e($a['penulis'] ?? 'Admin') ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
            </div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <button type="submit" class="rounded-xl bg-copper px-8 py-3 font-semibold text-white shadow-soft transition-all duration-300 hover:bg-espresso"><?= $a ? 'Simpan Perubahan' : 'Publikasikan' ?></button>
        <a href="<?= url('admin/artikel/index.php') ?>" class="rounded-xl border border-cream px-6 py-3 text-sm font-semibold text-espresso/60 transition hover:border-copper hover:text-copper">Batal</a>
    </div>
</form>