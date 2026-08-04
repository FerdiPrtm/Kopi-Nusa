<?php
/** Edit artikel. */
require_once __DIR__ . '/../config/init.php';
require_login();

$id = (int)get('id', 0);
$stmt = db()->prepare("SELECT * FROM artikel WHERE id = :id");
$stmt->execute(['id' => $id]);
$a = $stmt->fetch();

if (!$a) {
    set_flash('error', 'Artikel tidak ditemukan.');
    redirect(url('admin/artikel/index.php'));
}

$title = 'Edit Artikel';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $judul = post('judul');
    $isi = $_POST['isi'] ?? '';

    try {
        if ($judul === '' || trim($isi) === '') {
            throw new Exception('Judul dan isi wajib diisi.');
        }
        $gambar = upload_image($_FILES['gambar'] ?? [], 'artikel', $a['gambar']);
        $slug = post('slug') !== '' ? slugify(post('slug')) : slugify($judul);

        db()->prepare("UPDATE artikel SET judul = :judul, slug = :slug, gambar = :gambar, ringkasan = :ringkasan, isi = :isi, penulis = :penulis WHERE id = :id")
            ->execute([
                'judul' => $judul,
                'slug' => $slug,
                'gambar' => $gambar,
                'ringkasan' => post('ringkasan'),
                'isi' => $isi,
                'penulis' => post('penulis', 'Admin'),
                'id' => $id,
            ]);
        set_flash('success', 'Artikel berhasil diperbarui.');
        redirect(url('admin/artikel/index.php'));
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
        redirect(url('admin/artikel/edit.php?id=' . $id));
    }
}

require_once __DIR__ . '/../layout/head.php';
?>
<?php require __DIR__ . '/_form.php'; ?>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>