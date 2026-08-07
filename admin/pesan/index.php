<?php
/** Pesan Masuk: list, tandai dibaca, hapus. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Pesan Masuk';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = post('action');
    $id = (int)post('id', 0);

    if ($action === 'mark') {
        db()->prepare("UPDATE kontak SET is_read = 1 WHERE id = :id")->execute(['id' => $id]);
        set_flash('success', 'Pesan ditandai sudah dibaca.');
    }
    if ($action === 'delete') {
        db()->prepare("DELETE FROM kontak WHERE id = :id")->execute(['id' => $id]);
        set_flash('success', 'Pesan dihapus.');
    }
    redirect(url('admin/pesan/index.php'));
}

$pesans = db()->query("SELECT * FROM kontak ORDER BY is_read ASC, id DESC")->fetchAll();

require_once __DIR__ . '/../layout/head.php';
?>

<div class="flex flex-wrap items-center justify-between gap-4">
    <p class="text-sm text-espresso/60">
        <span class="mr-2 text-lg font-bold text-espresso"><?= count($pesans) ?></span> pesan masuk
    </p>
</div>

<div class="mt-6 space-y-4">
    <?php foreach ($pesans as $pm): ?>
    <div class="rounded-2xl bg-white p-6 shadow-soft <?= $pm['is_read'] ? '' : 'ring-2 ring-copper/40' ?>">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-copper/10 font-bold text-copper"><?= e(mb_strtoupper(mb_substr($pm['nama'], 0, 1))) ?></span>
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="font-semibold"><?= e($pm['nama']) ?></p>
                        <span class="rounded-lg bg-copper/10 px-2 py-0.5 text-xs font-semibold text-copper"><?= e($pm['subjek']) ?></span>
                        <?php if (!$pm['is_read']): ?><span class="rounded-lg bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-500">Baru</span><?php endif; ?>
                    </div>
                    <p class="mt-1 text-xs text-espresso/50"><?= e(format_date($pm['created_at'], 'd M Y, H:i')) ?></p>
                    <?php if ($pm['email']): ?><a href="mailto:<?= e($pm['email']) ?>" class="mt-0.5 inline-flex items-center gap-1 text-xs text-copper hover:underline"><i data-lucide="mail" class="h-3 w-3"></i> <span class="break-all"><?= e($pm['email']) ?></span></a><?php endif; ?>
                </div>
            </div>
            <div class="flex gap-2">
                <?php if (!$pm['is_read']): ?>
                <form method="post" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="mark">
                    <input type="hidden" name="id" value="<?= (int)$pm['id'] ?>">
                    <button type="submit" class="rounded-lg bg-olive/10 px-3 py-2 text-xs font-semibold text-olive transition hover:bg-olive hover:text-white"><i data-lucide="check" class="inline h-3.5 w-3.5"></i> Tandai Dibaca</button>
                </form>
                <?php endif; ?>
                <form method="post" data-confirm="Hapus pesan ini?" class="inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$pm['id'] ?>">
                    <button type="submit" class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-500 hover:text-white"><i data-lucide="trash-2" class="inline h-3.5 w-3.5"></i> Hapus</button>
                </form>
            </div>
        </div>
        <p class="mt-4 whitespace-pre-line break-words rounded-xl bg-cream/60 p-4 text-sm text-espresso/80 dark:bg-white/5"><?= e($pm['pesan']) ?></p>
    </div>
    <?php endforeach; ?>
    <?php if (count($pesans) === 0): ?>
    <div class="rounded-2xl bg-white p-16 text-center shadow-soft">
        <i data-lucide="inbox" class="mx-auto h-14 w-14 text-coffee/40"></i>
        <p class="mt-4 font-semibold">Tidak ada pesan masuk.</p>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>