<?php
/** Halaman Kontak: form kontak (disimpan), maps, WA, email, jam. */
$pageTitle = 'Kontak';
$errors = [];
$old = ['nama' => '', 'email' => '', 'subjek' => '', 'pesan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nama']   = post('nama');
    $old['email']  = post('email');
    $old['subjek'] = post('subjek', 'Pertanyaan');
    $old['pesan']  = post('pesan');

    if ($old['nama'] === '') $errors['nama'] = 'Nama wajib diisi.';
    if ($old['pesan'] === '') $errors['pesan'] = 'Pesan wajib diisi.';
    if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    }

    if (empty($errors)) {
        $stmt = db()->prepare(
            "INSERT INTO kontak (nama, email, subjek, pesan) VALUES (:nama, :email, :subjek, :pesan)"
        );
        $stmt->execute([
            'nama' => $old['nama'],
            'email' => $old['email'],
            'subjek' => $old['subjek'],
            'pesan' => $old['pesan'],
        ]);
        set_flash('success', 'Pesan berhasil dikirim. Terima kasih!');
        redirect(url('index.php?page=kontak'));
    }
}
?>
<?php $currentPage = 'kontak'; ?>

<section class="relative overflow-hidden bg-espresso pb-16 pt-32 text-white">
    <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-copper/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copperLight" data-aos="fade-up">Kontak</span>
        <h1 class="mt-4 text-4xl font-extrabold" data-aos="fade-up" data-aos-delay="100">Hubungi Kami</h1>
        <span class="mt-5 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
        <p class="mt-5 max-w-xl text-white/80" data-aos="fade-up" data-aos-delay="150">Punya pertanyaan atau ingin bekerja sama? Kami siap membantu.</p>
    </div>
</section>

<section class="mx-auto -mt-10 max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
    <div class="grid gap-10 lg:grid-cols-5">
        <!-- Info kontak -->
        <div class="space-y-5 lg:col-span-2">
            <?php
            $infos = [
                ['map-pin', 'Alamat', site('alamat', '-')],
                ['phone', 'WhatsApp', site('wa_number', '-'), 'https://wa.me/' . preg_replace('/[^0-9]/', '', site('wa_number')), true],
                ['mail', 'Email', site('email', '-'), 'mailto:' . site('email'), true],
                ['clock', 'Jam Operasional', site('jam_buka', '-')],
            ];
            foreach ($infos as $i => $info): ?>
            <div class="flex items-start gap-4 rounded-2xl bg-white p-6 shadow-soft dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-copper/10 text-copper">
                    <i data-lucide="<?= $info[0] ?>" class="h-6 w-6"></i>
                </span>
                <div>
                    <p class="font-semibold"><?= $info[1] ?></p>
                    <?php if (isset($info[4])): ?>
                        <a href="<?= $info[3] ?>" target="<?= strpos($info[3], 'mailto') === 0 ? '_self' : '_blank' ?>" class="mt-1 text-sm text-espresso/70 transition hover:text-copper dark:text-cream/70"><?= e($info[2]) ?></a>
                    <?php else: ?>
                        <p class="mt-1 text-sm text-espresso/70 dark:text-cream/70"><?= e($info[2]) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Form -->
        <div class="rounded-3xl bg-white p-6 shadow-soft dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10 sm:p-8 lg:col-span-3" data-aos="fade-up">
            <h2 class="text-xl font-bold">Kirim Pesan</h2>
            <p class="mt-1 text-sm text-espresso/60 dark:text-cream/60">Isi form di bawah, kami akan segera merespons Anda.</p>

            <form method="post" class="mt-6 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="<?= e($old['nama']) ?>" placeholder="Nama Anda" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5 <?= isset($errors['nama']) ? 'border-red-400' : '' ?>">
                        <?php if (isset($errors['nama'])): ?><p class="mt-1 text-xs text-red-500"><?= e($errors['nama']) ?></p><?php endif; ?>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="<?= e($old['email']) ?>" placeholder="email@contoh.com" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5 <?= isset($errors['email']) ? 'border-red-400' : '' ?>">
                        <?php if (isset($errors['email'])): ?><p class="mt-1 text-xs text-red-500"><?= e($errors['email']) ?></p><?php endif; ?>
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Subjek</label>
                    <select name="subjek" class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5">
                        <?php foreach (['Pertanyaan', 'Pemesanan', 'Kerja Sama', 'Lainnya'] as $s): ?>
                            <option value="<?= $s ?>" <?= $old['subjek'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Pesan <span class="text-red-500">*</span></label>
                    <textarea name="pesan" rows="5" placeholder="Tulis pesan Anda..." class="w-full rounded-xl border border-cream bg-cream/60 px-4 py-3 text-sm outline-none transition focus:border-copper dark:border-white/10 dark:bg-white/5 <?= isset($errors['pesan']) ? 'border-red-400' : '' ?>"><?= e($old['pesan']) ?></textarea>
                    <?php if (isset($errors['pesan'])): ?><p class="mt-1 text-xs text-red-500"><?= e($errors['pesan']) ?></p><?php endif; ?>
                </div>
                <button type="submit" class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-copper to-orange-600 px-7 py-3.5 font-semibold text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg">
                    <i data-lucide="send" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"></i> Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Maps -->
<section class="pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl shadow-soft">
            <iframe src="<?= e(site('maps_embed')) ?>" width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>