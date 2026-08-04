<?php
/**
 * Inisialisasi area admin: session, config, helpers, proteksi login.
 */

session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/functions.php';

/** Cek apakah user sudah login sebagai admin. */
function is_admin_logged_in(): bool {
    return !empty($_SESSION['admin_id']);
}

/** Paksa halaman membutuhkan login. */
function require_login(): void {
    if (!is_admin_logged_in()) {
        redirect(url('admin/login.php'));
    }
}

/** URL path halaman admin aktif. */
function admin_active(string $segment): string {
    $current = basename($_SERVER['SCRIPT_NAME']);
    if ($segment === 'dashboard') return $current === 'index.php';
    return strpos($current, $segment . '.php') === 0 || strpos($current, $segment) === 0;
}