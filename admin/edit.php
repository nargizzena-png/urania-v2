<?php
require __DIR__ . '/_boot.php';
require_login();

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$ev = ['title' => '', 'starts_at' => '', 'venue' => 'Sala Mare', 'category' => '', 'excerpt' => '',
       'body' => '', 'ends_on' => '', 'video' => '', 'ticket_url' => '', 'cover' => '', 'published' => 1];
if ($id) {
    $st = db()->prepare('SELECT * FROM events WHERE id = ?');
    $st->execute([$id]);
    $ev = $st->fetch();
    if (!$ev) { flash('Evenimentul nu există.', 'err'); header('Location: index.php'); exit; }
}

/** Normalizează $_FILES pentru input multiple. */
function files_list(string $key): array
{
    if (empty($_FILES[$key]['name'])) return [];
    if (!is_array($_FILES[$key]['name'])) return [$_FILES[$key]];
    $out = [];
    foreach ($_FILES[$key]['name'] as $i => $n) {
        if ($_FILES[$key]['error'][$i] === UPLOAD_ERR_NO_FILE) continue;
        $out[] = ['name' => $n, 'tmp_name' => $_FILES[$key]['tmp_name'][$i], 'error' => $_FILES[$key]['error'][$i], 'size' => $_FILES[$key]['size'][$i]];
    }
    return $out;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    // Ștergere poză din album
    if (($_POST['action'] ?? '') === 'delete_photo') {
        $st = db()->prepare('SELECT file FROM event_photos WHERE id = ? AND event_id = ?');
        $st->execute([(int)$_POST['photo_id'], $id]);
        if ($f = $st->fetchColumn()) {
            delete_image_files($f);
            db()->prepare('DELETE FROM event_photos WHERE id = ?')->execute([(int)$_POST['photo_id']]);
            flash('Poza a fost ștearsă.');
        }
        header('Location: edit.php?id=' . $id . '#album');
        exit;
    }

    // Dacă formularul depășește post_max_size, PHP golește $_POST
    if (empty($_POST['title']) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0 && empty($_FILES)) {
        $errors[] = 'Fișierele încărcate sunt prea mari în total. Încarcă mai puține poze odată.';
    }

    $ev['title']      = trim($_POST['title'] ?? '');
    $date             = trim($_POST['date'] ?? '');
    $time             = trim($_POST['time'] ?? '');
    $ev['ends_on']    = trim($_POST['ends_on'] ?? '');
    $ev['venue']      = in_array($_POST['venue'] ?? '', URANIA_VENUES, true) ? $_POST['venue'] : '';
    $ev['category']   = in_array($_POST['category'] ?? '', URANIA_CATEGORIES, true) ? $_POST['category'] : '';
    $ev['excerpt']    = trim($_POST['excerpt'] ?? '');
    $ev['body']       = trim($_POST['body'] ?? '');
    $ev['ticket_url'] = trim($_POST['ticket_url'] ?? '');
    $ev['published']  = isset($_POST['published']) ? 1 : 0;

    if ($ev['title'] === '' && !$errors) $errors[] = 'Titlul este obligatoriu.';
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) $errors[] = 'Data este obligatorie.';
    if ($ev['ends_on'] !== '' && (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $ev['ends_on']) || $ev['ends_on'] < $date)) $errors[] = 'Data de sfârșit trebuie să fie după data de început.';
    if ($ev['ends_on'] === $date) $ev['ends_on'] = '';
    if ($time !== '' && !preg_match('/^\d{2}:\d{2}$/', $time)) $errors[] = 'Ora nu este validă.';
    if ($ev['ticket_url'] !== '' && !preg_match('#^https?://#i', $ev['ticket_url'])) $errors[] = 'Linkul de bilete trebuie să înceapă cu https://';
    if (mb_strlen($ev['excerpt']) > 220) $errors[] = 'Descrierea scurtă: maxim 220 de caractere.';
    $ev['starts_at'] = $date . ' ' . ($time ?: '00:00');

    $newCover = null;
    $coverFile = files_list('cover')[0] ?? null;
    if (!$errors && $coverFile) {
        try { $newCover = save_uploaded_image($coverFile); }
        catch (RuntimeException $ex) { $errors[] = 'Afiș: ' . $ex->getMessage(); }
    }

    $newVideo = null;
    $vf = files_list('video')[0] ?? null;
    if (!$errors && $vf) {
        if ($vf['error'] !== UPLOAD_ERR_OK) $errors[] = 'Video: eroare la încărcare (fișier prea mare?).';
        elseif ($vf['size'] > 15 * 1024 * 1024) $errors[] = 'Video: maxim 15 MB. Comprimă clipul înainte de încărcare.';
        else {
            $fh = fopen($vf['tmp_name'], 'rb'); $head = fread($fh, 12); fclose($fh);
            if (substr($head, 4, 4) !== 'ftyp') $errors[] = 'Video: doar fișiere MP4.';
            else {
                if (!is_dir(URANIA_UPLOAD_DIR)) mkdir(URANIA_UPLOAD_DIR, 0755, true);
                $newVideo = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.mp4';
                move_uploaded_file($vf['tmp_name'], URANIA_UPLOAD_DIR . '/' . $newVideo);
            }
        }
    }
    if (isset($_POST['remove_video'])) { if ($ev['video']) @unlink(URANIA_UPLOAD_DIR . '/' . basename($ev['video'])); $ev['video'] = ''; }

    if (!$errors) {
        if ($newVideo) { if ($ev['video']) @unlink(URANIA_UPLOAD_DIR . '/' . basename($ev['video'])); $ev['video'] = $newVideo; }
        if ($newCover) { if ($ev['cover']) delete_image_files($ev['cover']); $ev['cover'] = $newCover; }
        if ($id) {
            db()->prepare('UPDATE events SET title=?, slug=?, starts_at=?, ends_on=?, venue=?, category=?, excerpt=?, body=?, ticket_url=?, cover=?, video=?, published=?, updated_at=CURRENT_TIMESTAMP WHERE id=?')
                ->execute([$ev['title'], unique_slug($ev['title'], $id), $ev['starts_at'], $ev['ends_on'], $ev['venue'], $ev['category'], $ev['excerpt'], $ev['body'], $ev['ticket_url'], $ev['cover'], $ev['video'], $ev['published'], $id]);
        } else {
            db()->prepare('INSERT INTO events (title, slug, starts_at, ends_on, venue, category, excerpt, body, ticket_url, cover, video, published) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)')
                ->execute([$ev['title'], unique_slug($ev['title']), $ev['starts_at'], $ev['ends_on'], $ev['venue'], $ev['category'], $ev['excerpt'], $ev['body'], $ev['ticket_url'], $ev['cover'], $ev['video'], $ev['published']]);
            $id = (int)db()->lastInsertId();
        }

        // Album foto
        $added = 0; $failed = [];
        $sort = (int)db()->query('SELECT COALESCE(MAX(sort),0) FROM event_photos WHERE event_id = ' . $id)->fetchColumn();
        foreach (files_list('photos') as $pf) {
            try {
                $file = save_uploaded_image($pf);
                db()->prepare('INSERT INTO event_photos (event_id, file, sort) VALUES (?,?,?)')->execute([$id, $file, ++$sort]);
                $added++;
            } catch (RuntimeException $ex) {
                $failed[] = $pf['name'] . ' (' . $ex->getMessage() . ')';
            }
        }
        $msg = 'Evenimentul a fost salvat.' . ($added ? " Au fost adăugate $added poze." : '');
        if ($failed) $msg .= ' Nu s-au încărcat: ' . implode(', ', $failed);
        flash($msg, $failed ? 'err' : 'ok');
        header('Location: edit.php?id=' . $id);
        exit;
    }
}

$dateVal = $ev['starts_at'] ? substr($ev['starts_at'], 0, 10) : ($_POST['date'] ?? '');
$timeVal = $ev['starts_at'] ? substr($ev['starts_at'], 11, 5) : ($_POST['time'] ?? '');
if ($timeVal === '00:00') $timeVal = '';
$photos = $id ? event_photos($id) : [];

admin_header($id ? 'Editează evenimentul' : 'Eveniment nou');
?>
<div class="a-head">
    <h1><?= $id ? 'Editează evenimentul' : 'Eveniment nou' ?></h1>
    <a href="index.php" class="a-link">← Înapoi la listă</a>
</div>

<?php if ($errors): ?><div class="a-flash a-flash-err"><?= implode('<br>', array_map('e', $errors)) ?></div><?php endif; ?>

<form method="post" enctype="multipart/form-data" class="a-card a-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int)$id ?>">

    <label class="a-full">Titlu *<input name="title" required maxlength="140" value="<?= e($ev['title']) ?>" placeholder="ex. Concert de jazz — Trio Somnium"></label>

    <label>Data *<input type="date" name="date" required value="<?= e($dateVal) ?>"></label>
    <label>Ora<input type="time" name="time" value="<?= e($timeVal) ?>"></label>
    <label class="a-full">Până la <small>(opțional — doar pentru evenimente pe mai multe zile)</small><input type="date" name="ends_on" value="<?= e($ev['ends_on']) ?>"></label>

    <label>Sala
        <select name="venue">
            <option value="">—</option>
            <?php foreach (URANIA_VENUES as $v): ?><option <?= $ev['venue'] === $v ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
        </select>
    </label>
    <label>Categorie
        <select name="category">
            <option value="">—</option>
            <?php foreach (URANIA_CATEGORIES as $c): ?><option <?= $ev['category'] === $c ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
        </select>
    </label>

    <label class="a-full">Descriere scurtă <small>(apare pe card, max. 220 caractere)</small>
        <textarea name="excerpt" rows="2" maxlength="220"><?= e($ev['excerpt']) ?></textarea></label>

    <label class="a-full">Descriere completă <small>(paragrafele se separă cu un rând gol)</small>
        <textarea name="body" rows="8"><?= e($ev['body']) ?></textarea></label>

    <label class="a-full">Link bilete / înscriere <small>(opțional)</small>
        <input type="url" name="ticket_url" value="<?= e($ev['ticket_url']) ?>" placeholder="https://..."></label>

    <div class="a-full a-cover">
        <label>Afiș / imagine principală <small>(JPG, PNG sau WebP)</small>
            <input type="file" name="cover" accept="image/jpeg,image/png,image/webp"></label>
        <?php if ($ev['cover']): ?><img src="../<?= e(photo_url($ev['cover'], true)) ?>" alt="Afiș actual"><?php endif; ?>
    </div>

    <label class="a-full">Video de prezentare <small>(MP4, maxim 15 MB — opțional)</small>
        <input type="file" name="video" accept="video/mp4"></label>
    <?php if ($ev['video']): ?><label class="a-check a-full"><input type="checkbox" name="remove_video"> Șterge video-ul actual</label><?php endif; ?>

    <label class="a-full">Adaugă poze în album <small>(poți selecta mai multe; potrivit după eveniment)</small>
        <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/webp"></label>

    <label class="a-check a-full"><input type="checkbox" name="published" <?= $ev['published'] ? 'checked' : '' ?>> Publicat pe site <small>(debifează pentru ciornă)</small></label>

    <div class="a-full a-submit">
        <button class="a-btn">Salvează</button>
        <?php if ($id): ?><a href="../eveniment.php?e=<?= e($ev['slug']) ?>" target="_blank" class="a-link">Vezi pe site ↗</a><?php endif; ?>
    </div>
</form>

<?php if ($photos): ?>
<div class="a-card" id="album">
    <h2>Album (<?= count($photos) ?> poze)</h2>
    <div class="a-album">
        <?php foreach ($photos as $p): ?>
        <figure>
            <img src="../<?= e(photo_url($p['file'], true)) ?>" alt="">
            <form method="post" onsubmit="return confirm('Ștergi poza?');">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int)$id ?>">
                <input type="hidden" name="action" value="delete_photo">
                <input type="hidden" name="photo_id" value="<?= (int)$p['id'] ?>">
                <button title="Șterge poza" aria-label="Șterge poza">×</button>
            </form>
        </figure>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?php admin_footer();
