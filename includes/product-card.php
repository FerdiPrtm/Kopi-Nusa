<?php
/** Kartu produk reusable.
 *  @param array $p data produk
 */
$hargaFinal = (int)$p['harga'];
if (!empty($p['promo']) && (int)$p['diskon'] > 0) {
    $hargaFinal = $hargaFinal - ($hargaFinal * (int)$p['diskon'] / 100);
}
$img = asset($p['gambar']);
$waLink = whatsapp_link($p['nama'], rupiah($hargaFinal));
?>
<article data-aos="fade-up" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-soft transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:shadow-espresso/20 dark:bg-white/5 dark:shadow-none dark:ring-1 dark:ring-white/10">
    <a href="<?= url('index.php?page=detail&id=' . (int)$p['id']) ?>" class="block">
        <!-- Image -->
        <div class="product-img-wrap relative aspect-[4/3] bg-cream dark:bg-espresso">
            <img src="<?= e($img) ?>" loading="lazy" alt="<?= e($p['nama']) ?>"
                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-espresso/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <!-- Status badge -->
            <?php if (!empty($p['promo']) && (int)$p['diskon'] > 0): ?>
                <span class="absolute left-3 top-3 rounded-lg bg-gradient-to-r from-copper to-orange-500 px-2.5 py-1 text-xs font-semibold text-white shadow">Promo <?= (int)$p['diskon'] ?>%</span>
            <?php elseif (!empty($p['best_seller'])): ?>
                <span class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-lg bg-espresso/85 px-2.5 py-1 text-xs font-semibold text-white backdrop-blur">
                    <i data-lucide="flame" class="h-3 w-3 text-copper"></i> Best Seller
                </span>
            <?php endif; ?>
            <?php if ((int)$p['stok'] <= 0): ?>
                <span class="absolute inset-0 flex items-center justify-center bg-black/55 text-sm font-semibold text-white backdrop-blur-sm">Stok Habis</span>
            <?php endif; ?>
        </div>
    </a>

    <!-- Body -->
    <div class="flex flex-1 flex-col p-5">
        <p class="text-[11px] font-semibold uppercase tracking-wider text-coffee"><?= e($p['kategori_nama'] ?? '') ?></p>
        <a href="<?= url('index.php?page=detail&id=' . (int)$p['id']) ?>">
            <h3 class="mt-1.5 line-clamp-2 text-[15px] font-bold leading-snug transition-colors group-hover:text-copper"><?= e($p['nama']) ?></h3>
        </a>
        <div class="mt-auto flex items-end justify-between pt-4">
            <div>
                <?php if (!empty($p['promo']) && (int)$p['diskon'] > 0): ?>
                    <p class="text-xs text-red-500 line-through"><?= e(rupiah($p['harga'])) ?></p>
                    <p class="text-lg font-extrabold leading-none text-copper"><?= e(rupiah($hargaFinal)) ?></p>
                <?php else: ?>
                    <p class="text-lg font-extrabold leading-none text-copper"><?= e(rupiah($p['harga'])) ?></p>
                <?php endif; ?>
            </div>
            <a href="<?= e($waLink) ?>" target="_blank" title="Pesan via WhatsApp" aria-label="Pesan <?= e($p['nama']) ?> via WhatsApp"
               class="flex h-9 w-9 items-center justify-center rounded-xl bg-cream text-copper ring-1 ring-copper/20 transition-all duration-300 hover:bg-copper hover:text-white hover:ring-copper dark:bg-white/10 dark:ring-white/10">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</article>