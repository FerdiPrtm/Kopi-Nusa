<?php /** Footer modern dengan kolom info, tautan, dan sosial media. */ ?>
<footer class="relative mt-20 overflow-hidden bg-espresso text-cream/80">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-copper/70 to-transparent"></div>
    <div class="absolute -left-24 top-10 h-64 w-64 rounded-full bg-copper/10 blur-3xl"></div>
    <div class="absolute -right-24 bottom-10 h-64 w-64 rounded-full bg-coffee/20 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <!-- Brand -->
            <div>
                <a href="<?= url('index.php') ?>" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-copper to-espresso text-white shadow-lg">
                        <i data-lucide="coffee" class="h-5 w-5"></i>
                    </span>
                    <span class="text-lg font-bold text-white"><?= e(site('site_name', APP_NAME)) ?></span>
                </a>
                <p class="mt-4 text-sm leading-relaxed"><?= e(site('footer_teks', '')) ?></p>
                <div class="mt-5 flex gap-2.5">
                    <?php foreach (['facebook', 'instagram', 'twitter', 'youtube'] as $soc): ?>
                        <?php if (site($soc) !== ''): ?>
                            <a href="<?= e(site($soc)) ?>" target="_blank" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 text-cream/70 ring-1 ring-white/10 transition-all duration-300 hover:-translate-y-1 hover:bg-copper hover:text-white hover:ring-copper" aria-label="<?= ucfirst($soc) ?>">
                                <i data-lucide="<?= $soc === 'youtube' ? 'youtube' : $soc ?>" class="h-4 w-4"></i>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Menu -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Menu</h4>
                <ul class="mt-4 space-y-3 text-sm">
                    <?php foreach ([
                        ['Home', 'index.php'],
                        ['Produk', 'index.php?page=produk'],
                        ['Tentang Kami', 'index.php?page=tentang'],
                        ['Artikel', 'index.php?page=artikel'],
                        ['Kontak', 'index.php?page=kontak'],
                    ] as $f): ?>
                    <li>
                        <a href="<?= url($f[1]) ?>" class="group inline-flex items-center gap-2 transition-all duration-300 hover:text-copper">
                            <i data-lucide="chevron-right" class="h-3.5 w-3.5 text-copper/60 transition-transform duration-300 group-hover:translate-x-0.5"></i>
                            <?= $f[0] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Hubungi Kami</h4>
                <ul class="mt-4 space-y-3.5 text-sm">
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-copper"><i data-lucide="map-pin" class="h-4 w-4"></i></span>
                        <span class="leading-relaxed"><?= e(site('alamat', '-')) ?></span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-copper"><i data-lucide="phone" class="h-4 w-4"></i></span>
                        <a href="https://wa.me/<?= e(preg_replace('/[^0-9]/', '', site('wa_number'))) ?>" class="leading-relaxed transition hover:text-copper"><?= e(site('wa_number', '-')) ?></a>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-copper"><i data-lucide="mail" class="h-4 w-4"></i></span>
                        <a href="mailto:<?= e(site('email')) ?>" class="leading-relaxed break-all transition hover:text-copper"><?= e(site('email', '-')) ?></a>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-copper"><i data-lucide="clock" class="h-4 w-4"></i></span>
                        <span class="leading-relaxed"><?= e(site('jam_buka', '-')) ?></span>
                    </li>
                </ul>
            </div>

            <!-- CTA -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Jam Operasional</h4>
                <p class="mt-4 text-sm leading-relaxed"><?= e(site('jam_buka', '-')) ?></p>
                <div class="mt-5 rounded-2xl bg-gradient-to-br from-copper/20 to-coffee/10 p-5 ring-1 ring-white/10">
                    <p class="text-sm font-semibold text-white">Pesan sekarang,</p>
                    <p class="text-xs text-cream/60">kami siap melayani Anda melalui WhatsApp.</p>
                    <a href="<?= whatsapp_link() ?>" target="_blank" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-copper px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:bg-coffee">
                        <i data-lucide="message-circle" class="h-4 w-4"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="relative border-t border-white/10 py-5 text-center text-xs text-cream/50">
        &copy; <?= date('Y') ?> <?= e(site('site_name', APP_NAME)) ?>. Seluruh hak cipta dilindungi.
    </div>
</footer>