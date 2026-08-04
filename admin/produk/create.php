<?php
/** Tambah produk baru. */
require_once __DIR__ . '/../config/init.php';
require_login();

$title = 'Tambah Produk';
$kategoris = db()->query("SELECT * FROM kategori ORDER BY nama ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $nama = post('nama');
    $deskripsi = post('deskripsi');

    try {
        if ($nama === '' || $deskripsi === '') {
            throw new Exception('Nama dan deskripsi wajib diisi.');
        }
        $gambar = upload_image($_FILES['gambar'] ?? [], 'produk');
        if (!$gambar) {
            throw new Exception('Gambar utama wajib diunggah.');
        }
        $gambar_2 = upload_image($_FILES['gambar_2'] ?? [], 'produk');
        $gambar_3 = upload_image($_FILES['gambar_3'] ?? [], 'produk');

        $slug = post('slug') !== '' ? slugify(post('slug')) : slugify($nama);

        db()->prepare(
            "INSERT INTO produk (kategori_id, nama, slug, deskripsi, harga, stok, berat, gambar, gambar_2, gambar_3, best_seller, promo, diskon)
             VALUES (:kat, :nama, :slug, :desc, :harga, :stok, :berat, :gambar, :g2, :g3, :best, :promo, :diskon)"
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
        ]);
        set_flash('success', 'Produk berhasil ditambahkan.');
        redirect(url('admin/produk/index.php'));
    } catch (Exception $e) {
        set_flash('error', $e->getMessage());
        redirect(url('admin/produk/create.php'));
    }
}

require_once __DIR__ . '/../layout/head.php';
?>
<?php require __DIR__ . '/_form.php'; ?>
<?php require_once __DIR__ . '/../layout/footer.php'; ?>