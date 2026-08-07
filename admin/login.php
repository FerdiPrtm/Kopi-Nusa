<?php
/** Halaman Login Admin. */
require_once __DIR__ . '/config/init.php';

if (is_admin_logged_in()) {
    redirect(url('admin/index.php'));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = post('username');
    $password = post('password');

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $stmt = db()->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$user['id'];
            $_SESSION['admin_name'] = $user['nama'];
            set_flash('success', 'Selamat datang, ' . $user['nama'] . '!');
            redirect(url('admin/index.php'));
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – <?= e(site('site_name', APP_NAME)) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                colors: { espresso: '#3E2723', coffee: '#6F4E37', copper: '#B87333', cream: '#F8F4EC', olive: '#6B7A4A' },
            } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@1.29.0/dist/umd/lucide.js"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-espresso via-coffee to-espresso px-4 font-sans">
    <div class="pointer-events-none fixed -left-24 top-10 h-72 w-72 rounded-full bg-copper/20 blur-3xl"></div>
    <div class="pointer-events-none fixed -right-24 bottom-10 h-72 w-72 rounded-full bg-orange-500/15 blur-3xl"></div>
    <div class="relative w-full max-w-md">
        <div class="rounded-3xl bg-white/95 p-8 shadow-2xl backdrop-blur">
            <div class="mb-8 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-copper to-orange-600 text-white shadow-lg shadow-copper/30">
                    <i data-lucide="coffee" class="h-7 w-7"></i>
                </span>
                <h1 class="mt-4 text-2xl font-extrabold text-espresso">Admin Dashboard</h1>
                <p class="text-sm text-espresso/60"><?= e(site('site_name', APP_NAME)) ?></p>
            </div>

            <?php if ($error): ?>
                <div class="mb-5 flex items-center gap-2 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600">
                    <i data-lucide="alert-circle" class="h-4 w-4"></i> <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" class="space-y-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-espresso">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-coffee"></i>
                        <input type="text" name="username" required class="w-full rounded-xl border border-cream bg-cream/60 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-copper" placeholder="admin">
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-espresso">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-coffee"></i>
                        <input type="password" name="password" required class="w-full rounded-xl border border-cream bg-cream/60 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-copper" placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-copper to-orange-600 py-3 font-semibold text-white shadow-lg shadow-copper/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl">
                    Masuk
                </button>
            </form>

            <div class="mt-6 rounded-xl bg-cream/70 px-4 py-3 text-center text-xs text-espresso/60">
                Default: <b>admin</b> / <b>admin123</b>
            </div>
        </div>
        <p class="mt-6 text-center text-sm text-white/70">
            <a href="<?= url('index.php') ?>" class="inline-flex items-center gap-2 transition hover:text-copper"><i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke Website</a>
        </p>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>