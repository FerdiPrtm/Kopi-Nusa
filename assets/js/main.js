/* ============================================================
   WEBSITE UMKM KOPI - CUSTOM JAVASCRIPT
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Loading screen ---------- */
    const loading = document.getElementById('loading-screen');
    if (loading) {
        window.addEventListener('load', () => {
            loading.style.opacity = '0';
            setTimeout(() => loading.remove(), 500);
        });
        // Fallback agar tidak menggantung
        setTimeout(() => {
            if (loading.parentNode) {
                loading.style.opacity = '0';
                setTimeout(() => loading.remove(), 500);
            }
        }, 3000);
    }

    /* ---------- Navbar scroll state ---------- */
    const navbar = document.getElementById('navbar');
    if (navbar) {
        const onScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ---------- Back to top ---------- */
    const backTop = document.getElementById('back-to-top');
    if (backTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backTop.classList.remove('hidden');
                backTop.classList.add('flex');
                backTop.style.opacity = '1';
            } else {
                backTop.classList.add('hidden');
                backTop.classList.remove('flex');
                backTop.style.opacity = '0';
            }
        }, { passive: true });
        backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }

    /* ---------- Mobile menu ---------- */
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mobileMenu.classList.add('hidden')));
    }

    /* ---------- Dark mode ---------- */
    const darkToggle = document.getElementById('dark-toggle');
    if (darkToggle) {
        const applyDark = (on) => {
            document.documentElement.classList.toggle('dark', on);
            document.cookie = 'dark=' + (on ? '1' : '0') + '; path=/; max-age=' + (60 * 60 * 24 * 365);
        };
        darkToggle.addEventListener('click', () => {
            applyDark(!document.documentElement.classList.contains('dark'));
        });
    }

    /* ---------- Gallery thumbs (detail produk) ---------- */
    const mainImage = document.getElementById('main-image');
    document.querySelectorAll('.gallery-thumb').forEach(thumb => {
        thumb.addEventListener('click', () => {
            if (mainImage) mainImage.src = thumb.dataset.src;
            document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('ring-copper'));
            thumb.classList.add('ring-copper');
        });
    });

    /* ---------- Lightbox ---------- */
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxClose = document.getElementById('lightbox-close');
    if (lightbox && lightboxImg) {
        document.querySelectorAll('.lightbox-trigger').forEach(btn => {
            btn.addEventListener('click', () => {
                lightboxImg.src = btn.dataset.full;
                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });
        });
        const closeLightbox = () => {
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
            document.body.style.overflow = '';
        };
        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !lightbox.classList.contains('hidden')) closeLightbox();
        });
    }

    /* ---------- Refetch lucide icons (untuk konten dinamis) ---------- */
    if (window.lucide) lucide.createIcons();
})();