<?php
/** Halaman Tentang Kami: sejarah, filosofi, proses roasting, visi-misi. */
$pageTitle = 'Tentang Kami';
?>
<?php $currentPage = 'tentang'; ?>

<!-- Header -->
<section class="relative overflow-hidden bg-espresso pb-16 pt-32 text-white">
    <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-copper/20 blur-3xl"></div>
    <div class="pointer-events-none absolute left-1/2 top-1/2 h-48 w-48 -translate-x-1/2 rounded-full bg-coffee/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-copper">Tentang Kami</span>
        <h1 class="mt-4 text-4xl font-extrabold" data-aos="fade-up" data-aos-delay="100">Cerita di Balik Secangkir Kopi</h1>
        <span class="mt-5 block h-1 w-16 rounded-full bg-gradient-to-r from-copper to-orange-500"></span>
    </div>
</section>

<!-- Sejarah -->
<section class="py-20">
    <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div data-aos="fade-right">
            <p class="text-sm font-semibold uppercase tracking-widest text-copper">Sejarah Kami</p>
            <h2 class="mt-3 text-3xl font-extrabold"><?= e(site('tentang_judul', 'Tentang Kami')) ?></h2>
            <p class="mt-5 leading-relaxed text-espresso/75 dark:text-cream/70"><?= nl2br(e(site('tentang_konten', ''))) ?></p>
            <p class="mt-4 leading-relaxed text-espresso/75 dark:text-cream/70">Dimulai dari sebuah dapur kecil dan passion terhadap kopi Nusantara, kami tumbuh menjadi UMKM yang terus menjunjung tinggi kerja sama adil dengan petani serta konsistensi kualitas di setiap kemasan.</p>
        </div>
        <div class="grid grid-cols-2 gap-5" data-aos="fade-left">
            <img src="<?= url('assets/img/about-coffee.svg') ?>" alt="Sejarah" class="col-span-2 aspect-[2/1] w-full rounded-2xl object-cover shadow-soft">
            <img src="<?= url('assets/img/gallery-1.svg') ?>" alt="Kebun kopi" class="aspect-square w-full rounded-2xl object-cover shadow-soft">
            <img src="<?= url('assets/img/gallery-2.svg') ?>" alt="Roasting" class="aspect-square w-full rounded-2xl object-cover shadow-soft">
        </div>
    </div>
</section>

<!-- Filosofi & Visi Misi -->
<section class="bg-gradient-to-b from-transparent to-white/60 py-20 dark:to-white/[0.02]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <p class="text-sm font-semibold uppercase tracking-widest text-copper">Filosofi</p>
            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Nilai yang Kami Pegang</h2>
            <p class="mx-auto mt-4 max-w-2xl text-espresso/70 dark:text-cream/70">Kami percaya secangkir kopi yang baik adalah hasil dari kejujuran, kerja keras petani, dan ketekunan di setiap tahap.</p>
        </div>
        <div class="mt-12 grid gap-7 md:grid-cols-3">
            <?php
            $nilai = [
                ['handshake', 'Visi', 'Menjadi UMKM kopi Nusantara terdepan yang membawa cita rasa lokal ke kancah nasional dan internasional.'],
                ['target', 'Misi', 'Memberdayakan petani lokal, menjaga kualitas, menghadirkan pengalaman kopi terbaik bagi pelanggan.'],
                ['sparkles', 'Filosofi', 'Kesederhanaan dan kehangatan adalah resep utama. Setiap cangkir adalah wujud syukur atas alam.'],
            ];
            foreach ($nilai as $i => $n): ?>
            <div class="rounded-2xl bg-white p-7 shadow-soft transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-copper/10 text-copper">
                    <i data-lucide="<?= $n[0] ?>" class="h-6 w-6"></i>
                </span>
                <h3 class="mt-5 text-lg font-bold"><?= $n[1] ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-espresso/70 dark:text-cream/70"><?= $n[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Proses roasting -->
<section class="py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <p class="text-sm font-semibold uppercase tracking-widest text-copper">Proses</p>
            <h2 class="mt-3 text-3xl font-extrabold sm:text-4xl">Alur Roasting Kami</h2>
        </div>
        <div class="mt-12 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
            <?php
            $tahap = [
                ['leaf', '1. Pemilihan Biji', 'Sortir manual biji pilihan dari petani mitra.'],
                ['droplets', '2. Proses Basah/Kering', 'Pengolahan sesuai karakter asal daerah.'],
                ['thermometer', '3. Roasting', 'Disangrai dalam batch kecil agar maksimal.'],
                ['package', '4. Pengemasan', 'Dikemas kedap udara demi kesegaran terjaga.'],
            ];
            foreach ($tahap as $i => $t): ?>
            <div class="relative rounded-2xl bg-white p-7 shadow-soft dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-espresso text-copper">
                    <i data-lucide="<?= $t[0] ?>" class="h-6 w-6"></i>
                </span>
                <h3 class="mt-5 font-bold"><?= $t[1] ?></h3>
                <p class="mt-2 text-sm text-espresso/70 dark:text-cream/70"><?= $t[2] ?></p>
                <?php if ($i < 3): ?><i data-lucide="arrow-right" class="absolute right-5 top-1/2 hidden h-5 w-5 -translate-y-1/2 text-copper lg:block"></i><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="pb-8">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-copper to-espresso p-10 text-center text-white shadow-xl" data-aos="zoom-in">
            <h2 class="text-2xl font-extrabold sm:text-3xl">Mau mencoba kopi kami?</h2>
            <a href="<?= url('index.php?page=produk') ?>" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-8 py-3.5 font-semibold text-espresso shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-cream">
                Lihat Koleksi Produk <i data-lucide="arrow-right" class="h-5 w-5"></i>
            </a>
        </div>
    </div>
</section>