<?php
/** Edit produk. */
require_once __DIR__ . '/../config/init.php';
require_login();

$id = (int)get('id', 0);
$stmt = db()->prepare("SELECT * FROM produk WHERE id = :id");
$stmt->execute(['id' => $id]);
$p = $stmt->fetch();

if (!$p) {
    set_flash('error', 'Produk tidak ditemukan.');
    redirect(url('admin/produk/index.php'));
}

$title = 'Edit Produk';
$kategoris = db()->query("SELECT * FROM kategori ORDER BY nama ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $nama = post('nama');
    $deskripsi = post('deskripsi');

    try {
        if ($nama === '' || $deskripsi === '') {
            throw new Exception('Nama dan deskripsi wajib diisi.');
        }
        $gambar = upload_image($_FILES['gambar'] ?? [], 'produk', $p['gambar']);
        $gambar_2 = upload_image($_FILES['gambar_2'] ?? [], 'produk', $p['gambar_2']);
        $gambar_3 = upload_image($_FILES['gambar_3'] ?? [], 'produk', $p['gambar_3']);

        $slug = post('slug') !== '' ? slugify(post('slug')) : slugify($nama);

        db()->prepare(
            "UPDATE produk SET
                kategori_id = :kat, nama = :nama, slug = :slug, deskripsi = :desc,
                harga = :harga, stok = :stok, berat = :berat,
                gambar = :gambar, gambar_2 = :g2, gambar_3 = :g3,
                best_seller = :best, promo = :promo, diskon = :diskon
             WHERE id = :id"
        )->execute([
            'kat' => (int)post('kategori_id', 0),
            'nama' => $nama,
            'slug' => $slug,
            'desc' => $deskripsi,
            'harga' => (int)post('harga', 0),
            'stok' => (int)post('stok', 0),
            'berat' => post('berat', '250 gram'),
            'gambar' => $gambar,
            'g2' => $gambar_2,
            'g3' => $gambar_3,
            'best' => post('best_seller') ? 1 : 0,
            'promo' => post('promo') ? 1 : 0,
            'diskon' => (int)post('diskon', 0),
            'id' => $id,
        ]);
        set_flash('success', 'Produk berhasil diperbarui.');
        redirect(url('admin/produk/index.php'));
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
        redirect(url('admin/produk/edit.php?id=' . $id));
    }
}

require_once __DIR__ . '/../layout/head.php';
?>
<?php require __DIR__ . '/_form.php'; ?>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>