<?php
require __DIR__ . '/_boot.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $user = trim($_POST['username'] ?? '');
        $pass = $_POST['password'] ?? '';
        if (!preg_match('/^[A-Za-z0-9._-]{3,40}$/', $user)) flash('Nume de utilizator invalid (3–40 caractere: litere, cifre, . _ -).', 'err');
        elseif (strlen($pass) < 10) flash('Parola trebuie să aibă cel puțin 10 caractere.', 'err');
        else {
            try {
                db()->prepare('INSERT INTO users (username, pass_hash) VALUES (?, ?)')->execute([$user, password_hash($pass, PASSWORD_DEFAULT)]);
                flash("Utilizatorul „{$user}” a fost adăugat.");
            } catch (PDOException $ex) {
                flash('Acest nume de utilizator există deja.', 'err');
            }
        }
    }

    if ($action === 'password') {
        $pass = $_POST['password'] ?? '';
        if (strlen($pass) < 10) flash('Parola trebuie să aibă cel puțin 10 caractere.', 'err');
        else {
            db()->prepare('UPDATE users SET pass_hash = ? WHERE username = ?')->execute([password_hash($pass, PASSWORD_DEFAULT), current_user()]);
            flash('Parola ta a fost schimbată.');
        }
    }

    if ($action === 'delete') {
        $uid = (int)($_POST['uid'] ?? 0);
        $st = db()->prepare('SELECT username FROM users WHERE id = ?');
        $st->execute([$uid]);
        $name = $st->fetchColumn();
        if ($name === current_user()) flash('Nu îți poți șterge propriul cont.', 'err');
        elseif ($name) { db()->prepare('DELETE FROM users WHERE id = ?')->execute([$uid]); flash("Utilizatorul „{$name}” a fost șters."); }
    }

    header('Location: users.php');
    exit;
}

$users = db()->query('SELECT id, username, created_at FROM users ORDER BY id')->fetchAll();
admin_header('Utilizatori');
?>
<div class="a-head"><h1>Utilizatori</h1></div>

<div class="a-card">
    <h2>Cine are acces</h2>
    <?php foreach ($users as $u): ?>
    <div class="a-row a-row-slim">
        <div class="a-info"><strong><?= e($u['username']) ?><?= $u['username'] === current_user() ? ' (tu)' : '' ?></strong><span>din <?= e(substr($u['created_at'], 0, 10)) ?></span></div>
        <?php if ($u['username'] !== current_user()): ?>
        <form method="post" onsubmit="return confirm('Ștergi accesul pentru <?= e($u['username']) ?>?');">
            <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="uid" value="<?= (int)$u['id'] ?>">
            <button class="a-btn a-btn-sm a-btn-danger">Șterge</button>
        </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<div class="a-grid2">
    <form method="post" class="a-card">
        <h2>Adaugă o persoană</h2>
        <?= csrf_field() ?><input type="hidden" name="action" value="add">
        <label>Nume de utilizator<input name="username" required autocomplete="off"></label>
        <label>Parolă temporară (min. 10 caractere)<input type="password" name="password" required autocomplete="new-password"></label>
        <button class="a-btn">Adaugă</button>
    </form>
    <form method="post" class="a-card">
        <h2>Schimbă parola mea</h2>
        <?= csrf_field() ?><input type="hidden" name="action" value="password">
        <label>Parolă nouă (min. 10 caractere)<input type="password" name="password" required autocomplete="new-password"></label>
        <button class="a-btn">Schimbă</button>
    </form>
</div>
<?php admin_footer();
