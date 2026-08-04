<?php
/** Tambah artikel. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Tulis Artikel';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $judul = post('judul');
    $isi = $_POST['isi'] ?? '';

    try {
        if ($judul === '' || trim($isi) === '') {
            throw new Exception('Judul dan isi wajib diisi.');
        }
        $gambar = upload_image($_FILES['gambar'] ?? [], 'artikel');
        $slug = post('slug') !== '' ? slugify(post('slug')) : slugify($judul);

        db()->prepare("INSERT INTO artikel (judul, slug, gambar, ringkasan, isi, penulis) VALUES (:judul, :slug, :gambar, :ringkasan, :isi, :penulis)")
            ->execute([
                'judul' => $judul,
                'slug' => $slug,
                'gambar' => $gambar,
                'ringkasan' => post('ringkasan'),
                'isi' => $isi,
                'penulis' => post('penulis', 'Admin'),
            ]);
        set_flash('success', 'Artikel berhasil dipublikasikan.');
        redirect(url('admin/artikel/index.php'));
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
        redirect(url('admin/artikel/create.php'));
    }
}

require_once __DIR__ . '/../layout/head.php';
?>
<?php require __DIR__ . '/_form.php'; ?>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>