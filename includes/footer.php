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
                    <?php
                    $socIcons = [
                        'facebook'  => 'M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z',
                        'instagram' => 'M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z',
                        'twitter'   => 'M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z',
                        'youtube'   => 'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
                    ];
                    foreach ($socIcons as $soc => $iconPath): ?>
                        <?php if (site($soc) !== ''): ?>
                            <a href="<?= e(site($soc)) ?>" target="_blank" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 text-cream/70 ring-1 ring-white/10 transition-all duration-300 hover:-translate-y-1 hover:bg-copper hover:text-white hover:ring-copper" aria-label="<?= ucfirst($soc) ?>">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="<?= $iconPath ?>"/></svg>
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