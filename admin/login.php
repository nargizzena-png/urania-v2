<?php
require __DIR__ . '/_boot.php';

if (!users_exist()) { header('Location: setup.php'); exit; }
if (current_user()) { header('Location: index.php'); exit; }

// Limitare încercări: max 5 greșeli / 15 minute per IP
$ip = $_SERVER['REMOTE_ADDR'] ?? 'x';
$lockFile = sys_get_temp_dir() . '/urania_login_' . md5($ip);
$fails = is_file($lockFile) ? array_filter(json_decode(file_get_contents($lockFile), true) ?: [], fn($t) => $t > time() - 900) : [];

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    if (count($fails) >= 5) {
        $error = 'Prea multe încercări. Încearcă din nou peste 15 minute.';
    } else {
        $st = db()->prepare('SELECT * FROM users WHERE username = ?');
        $st->execute([trim($_POST['username'] ?? '')]);
        $u = $st->fetch();
        if ($u && password_verify($_POST['password'] ?? '', $u['pass_hash'])) {
            @unlink($lockFile);
            session_regenerate_id(true);
            $_SESSION['user'] = $u['username'];
            header('Location: index.php');
            exit;
        }
        $fails[] = time();
        file_put_contents($lockFile, json_encode(array_values($fails)));
        usleep(700000);
        $error = 'Utilizator sau parolă greșită.';
    }
}

admin_header('Autentificare');
?>
<div class="a-card a-narrow">
    <h1>Autentificare</h1>
    <?php if ($error): ?><div class="a-flash a-flash-err"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <?= csrf_field() ?>
        <label>Utilizator<input name="username" required autocomplete="username" autofocus></label>
        <label>Parolă<input type="password" name="password" required autocomplete="current-password"></label>
        <button class="a-btn">Intră</button>
    </form>
</div>
<?php admin_footer();
