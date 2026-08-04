<?php
/**
 * Fungsi bantuan (helpers) yang digunakan di seluruh website.
 */

require_once __DIR__ . '/../config/database.php';

/* ------------------------------------------------------------------
 *  Output & Input
 * ------------------------------------------------------------------ */

/** Escape output untuk mencegah XSS. */
function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/** Ambil nilai $_POST yang sudah dibersihkan (trim). */
function post(string $key, $default = '') {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

/** Ambil nilai $_GET yang sudah dibersihkan. */
function get(string $key, $default = '') {
    return isset($_GET[$key]) ? trim((string)$_GET[$key]) : $default;
}

/** Redirect ke URL tertentu lalu hentikan eksekusi. */
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

/* ------------------------------------------------------------------
 *  CSRF (untuk form admin)
 * ------------------------------------------------------------------ */
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void {
    $t = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $t)) {
        http_response_code(403);
        die('Token CSRF tidak valid. Silakan muat ulang halaman.');
    }
}

/* ------------------------------------------------------------------
 *  Flash message
 * ------------------------------------------------------------------ */
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

/* ------------------------------------------------------------------
 *  Formatting
 * ------------------------------------------------------------------ */
function rupiah($angka): string {
    return 'Rp ' . number_format((int)$angka, 0, ',', '.');
}

function currency($angka): string {
    return number_format((int)$angka, 0, ',', '.');
}

/** Buat slug dari string. */
function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

function format_date(?string $date, string $format = 'd M Y'): string {
    return $date ? date($format, strtotime($date)) : '-';
}

function excerpt(?string $text, int $limit = 120): string {
    $text = strip_tags(trim((string)$text));
    if (mb_strlen($text) <= $limit) return $text;
    return mb_substr($text, 0, $limit) . 'â€¦';
}

/* ------------------------------------------------------------------
 *  Upload gambar yang aman (max 2 MB)
 * ------------------------------------------------------------------ */
function upload_image(array $file, string $subdir, ?string $oldFile = null): ?string {
    if (empty($file['name']) || (int)$file['error'] !== UPLOAD_ERR_OK) {
        return $oldFile; // tidak ada file baru -> kembalikan yang lama
    }

    // Validasi ukuran max 2 MB
    if ((int)$file['size'] > UPLOAD_MAX) {
        throw new Exception('Ukuran file maksimal 2 MB.');
    }

    // Validasi tipe via finfo (bukan hanya ekstensi)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowedMime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    if (!in_array($mime, $allowedMime, true)) {
        throw new Exception('Tipe file harus gambar (JPG, PNG, WEBP, GIF).');
    }

    $extMap = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    $ext = $extMap[$mime];

    $dir = UPLOAD_DIR . '/' . $subdir;
    if (!is_dir($dir)) mkdir($dir, 0775, true);

    $name = date('YmdHis') . '-' . bin2hex(random_bytes(6)) . '.' . $ext;
    $target = $dir . '/' . $name;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new Exception('Gagal mengunggah gambar.');
    }

    // Hapus file lama bila ada (dalam subdir yang sama)
    if ($oldFile && $oldFile !== 'assets/img/placeholder-coffee.svg') {
        $oldPath = UPLOAD_DIR . '/../' . $oldFile;
        if (is_file($oldPath)) @unlink($oldPath);
    }

    return 'uploads/' . $subdir . '/' . $name;
}

/** Hapus file gambar aman. */
function delete_uploaded(?string $path): void {
    if (!$path) return;
    if (strpos($path, 'uploads/') !== 0) return; // hanya hapus dari folder uploads
    $full = ROOTPATH . '/../' . $path;
    if (is_file($full)) @unlink($full);
}

/* ------------------------------------------------------------------
 *  URL helper
 * ------------------------------------------------------------------ */
function url(string $path = ''): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

function public_asset(string $path): string {
    return url($path);
}

/** Alias singkat untuk asset URL. */
function asset(string $path): string {
    return url($path);
}

/* ------------------------------------------------------------------
 *  Pengaturan website
 * ------------------------------------------------------------------ */
function site(string $key, string $default = ''): string {
    static $list = null;
    if ($list === null) {
        $list = [];
        try {
            $rows = db()->query("SELECT `key`, `value` FROM `pengaturan`")->fetchAll();
            foreach ($rows as $row) $list[$row['key']] = $row['value'];
        } catch (PDOException $e) {
            $list = [];
        }
    }
    return isset($list[$key]) && $list[$key] !== null && $list[$key] !== ''
        ? (string)$list[$key]
        : $default;
}

/** Link WhatsApp dengan pesan otomatis. */
function whatsapp_link(string $productName = '', string $price = ''): string {
    $number = preg_replace('/[^0-9]/', '', site('wa_number', '6281234567890'));

    $message = "Halo Admin,\n";
    if ($productName !== '') {
        $message .= "Saya tertarik dengan produk berikut.\n\n";
        $message .= "Nama Produk: " . $productName . "\n";
        $message .= "Harga: " . $price . "\n\n";
    }
    $message .= "Apakah produk ini masih tersedia?\n\nTerima kasih.";

    return 'https://wa.me/' . $number . '?text=' . rawurlencode($message);
}