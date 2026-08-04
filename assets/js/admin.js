/* Admin JavaScript: sidebar mobile toggle + konfirmasi hapus. */
(function () {
    'use strict';

    // Sidebar toggle
    var sidebar = document.getElementById('admin-sidebar');
    var toggle = document.getElementById('sidebar-toggle');
    if (sidebar && toggle) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
        });
        sidebar.querySelectorAll('a[href]').forEach(function (a) {
            a.addEventListener('click', function () {
                if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
            });
        });
    }

    // Konfirmasi hapus via SweetAlert2
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var msg = form.dataset.confirm || 'Yakin ingin menghapus data ini?';
            Swal.fire({
                title: 'Konfirmasi',
                text: msg,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#B87333',
                cancelButtonColor: '#6F4E37',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    // Preview gambar sebelum upload
    document.querySelectorAll('input[type=file][data-preview]').forEach(function (input) {
        input.addEventListener('change', function () {
            var idName = input.dataset.preview;
            var img = document.getElementById(idName);
            if (img && input.files && input.files[0]) {
                img.src = URL.createObjectURL(input.files[0]);
            }
        });
    });

    if (window.lucide) lucide.createIcons();
})();