<?php
/** Skrip bersama di akhir halaman: AOS, lucide, custom JS, flash toast. */
?>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true });
    lucide.createIcons();
</script>

<?php if ($flash = get_flash()): ?>
<script>
    Swal.fire({
        icon: '<?= e($flash['type']) ?>',
        title: '<?= e($flash['message']) ?>',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
</script>
<?php endif; ?>

<script src="<?= url('assets/js/main.js') ?>"></script>