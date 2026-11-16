<?php
// Creează primul cont de administrator. Funcționează DOAR cât timp nu există niciun cont.
require __DIR__ . '/_boot.php';

if (users_exist()) { header('Location: login.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    if (!preg_match('/^[A-Za-z0-9._-]{3,40}$/', $user)) {
        $error = 'Numele de utilizator: 3–40 caractere (litere, cifre, . _ -).';
    } elseif (strlen($pass) < 10) {
        $error = 'Parola trebuie să aibă cel puțin 10 caractere.';
    } elseif ($pass !== ($_POST['password2'] ?? '')) {
        $error = 'Parolele nu coincid.';
    } else {
        db()->prepare('INSERT INTO users (username, pass_hash) VALUES (?, ?)')
            ->execute([$user, password_hash($pass, PASSWORD_DEFAULT)]);
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        flash('Contul a fost creat. Bine ai venit!');
        header('Location: index.php');
        exit;
    }
}

admin_header('Configurare');
?>
<div class="a-card a-narrow">
    <h1>Primul cont de administrator</h1>
    <p class="a-muted">Această pagină apare o singură dată. După ce creezi contul, alte persoane pot fi adăugate din „Utilizatori”.</p>
    <?php if ($error): ?><div class="a-flash a-flash-err"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <?= csrf_field() ?>
        <label>Nume de utilizator<input name="username" required autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>"></label>
        <label>Parolă (min. 10 caractere)<input type="password" name="password" required autocomplete="new-password"></label>
        <label>Repetă parola<input type="password" name="password2" required autocomplete="new-password"></label>
        <button class="a-btn">Creează contul</button>
    </form>
</div>
<?php admin_footer();
