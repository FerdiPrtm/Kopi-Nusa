<?php
/** Pengaturan Website: ubah key/value pengaturan. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Pengaturan Website';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $keys = [
        'site_name', 'tagline', 'deskripsi', 'wa_number', 'email', 'alamat', 'maps_embed',
        'jam_buka', 'facebook', 'instagram', 'twitter', 'youtube',
        'hero_judul', 'hero_sub', 'tentang_judul', 'tentang_konten', 'footer_teks',
        'meta_description', 'dark_mode',
    ];

    $stmt = db()->prepare(
        "INSERT INTO pengaturan (`key`, `value`) VALUES (:k, :v)
         ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)"
    );

    foreach ($keys as $k) {
        $stmt->execute(['k' => $k, 'v' => post($k)]);
    }

    set_flash('success', 'Pengaturan berhasil disimpan.');
    redirect(url('admin/pengaturan/index.php'));
}

require_once __DIR__ . '/../layout/head.php';
?>

<form method="post" class="space-y-6">
    <?= csrf_field() ?>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="space-y-5">
            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="mb-4 text-lg font-bold">Identitas Website</h3>
                <?php foreach ([
                    ['site_name', 'Nama Website'],
                    ['tagline', 'Tagline'],
                    ['deskripsi', 'Deskripsi Singkat'],
                ] as [$k, $label]): ?>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium"><?= $label ?></label>
                    <input type="text" name="<?= $k ?>" value="<?= e(site($k)) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
                </div>
                <?php endforeach; ?>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Meta Description (SEO)</label>
                    <textarea name="meta_description" rows="3" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper"><?= e(site('meta_description')) ?></textarea>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="mb-4 text-lg font-bold">Hero Section</h3>
                <?php foreach ([
                    ['hero_judul', 'Judul Hero'],
                    ['hero_sub', 'Subjudul Hero'],
                ] as [$k, $label]): ?>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium"><?= $label ?></label>
                    <input type="text" name="<?= $k ?>" value="<?= e(site($k)) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
                </div>
                <?php endforeach; ?>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="mb-4 text-lg font-bold">Tentang Kami</h3>
                <?php foreach ([
                    ['tentang_judul', 'Judul'],
                    ['tentang_konten', 'Konten Cerita'],
                ] as [$k, $label]): ?>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium"><?= $label ?></label>
                    <?php if ($k === 'tentang_konten'): ?>
                        <textarea name="<?= $k ?>" rows="5" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper"><?= e(site($k)) ?></textarea>
                    <?php else: ?>
                        <input type="text" name="<?= $k ?>" value="<?= e(site($k)) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="mb-4 text-lg font-bold">Kontak & Lokasi</h3>
                <?php foreach ([
                    ['wa_number', 'Nomor WhatsApp (contoh: 6281234567890)'],
                    ['email', 'Email'],
                    ['alamat', 'Alamat'],
                    ['jam_buka', 'Jam Operasional'],
                ] as [$k, $label]): ?>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium"><?= $label ?></label>
                    <input type="text" name="<?= $k ?>" value="<?= e(site($k)) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper">
                </div>
                <?php endforeach; ?>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Google Maps Embed URL</label>
                    <textarea name="maps_embed" rows="3" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper"><?= e(site('maps_embed')) ?></textarea>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="mb-4 text-lg font-bold">Sosial Media</h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    <?php foreach ([
                        ['facebook', 'Facebook'],
                        ['instagram', 'Instagram'],
                        ['twitter', 'Twitter / X'],
                        ['youtube', 'YouTube'],
                    ] as [$k, $label]): ?>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium"><?= $label ?></label>
                        <input type="text" name="<?= $k ?>" value="<?= e(site($k)) ?>" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper" placeholder="https://...">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-soft">
                <h3 class="mb-4 text-lg font-bold">Footer & Lainnya</h3>
                <div class="mb-4">
                    <label class="mb-1.5 block text-sm font-medium">Teks Footer</label>
                    <textarea name="footer_teks" rows="3" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper"><?= e(site('footer_teks')) ?></textarea>
                </div>
                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-cream p-4 transition hover:border-copper">
                    <input type="checkbox" name="dark_mode" value="1" class="h-4 w-4 accent-copper" <?= site('dark_mode') === '1' ? 'checked' : '' ?>>
                    <span class="text-sm font-medium">Aktifkan Dark Mode bawaan</span>
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="rounded-xl bg-copper px-8 py-3 font-semibold text-white shadow-soft transition-all duration-300 hover:bg-espresso">
            <i data-lucide="save" class="inline h-4 w-4"></i> Simpan Pengaturan
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>