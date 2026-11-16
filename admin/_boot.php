<?php
require __DIR__ . '/../includes/db.php';

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/admin',
    'httponly' => true,
    'samesite' => 'Strict',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
]);
session_name('urania_admin');
session_start();

header('X-Frame-Options: DENY');
header('X-Robots-Tag: noindex, nofollow');

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_check(): void
{
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(400);
        exit('Sesiunea a expirat. Reîncarcă pagina și încearcă din nou.');
    }
}

function users_exist(): bool
{
    return (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn() > 0;
}

function current_user(): ?string
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (!users_exist()) { header('Location: setup.php'); exit; }
    if (!current_user()) { header('Location: login.php'); exit; }
}

function flash(?string $msg = null, string $type = 'ok'): ?array
{
    if ($msg !== null) { $_SESSION['flash'] = [$type, $msg]; return null; }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function admin_header(string $title): void
{
    $u = current_user();
    $f = flash();
    ?><!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title) ?> · Admin Urania</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<header class="a-top">
    <a href="index.php" class="a-logo">URANIA <span>admin</span></a>
    <?php if ($u): ?>
    <nav>
        <a href="index.php">Evenimente</a>
        <a href="edit.php" class="a-btn a-btn-sm">+ Eveniment nou</a>
        <a href="users.php">Utilizatori</a>
        <a href="../jurnal.php" target="_blank">Vezi site ↗</a>
        <a href="logout.php">Ieșire</a>
    </nav>
    <?php endif; ?>
</header>
<main class="a-main">
<?php if ($f): ?><div class="a-flash a-flash-<?= e($f[0]) ?>"><?= e($f[1]) ?></div><?php endif; ?>
<?php
}

function admin_footer(): void
{
    echo "</main>\n</body>\n</html>";
}
