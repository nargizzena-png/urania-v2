<?php
require __DIR__ . '/_boot.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    $ev = db()->prepare('SELECT cover FROM events WHERE id = ?');
    $ev->execute([$id]);
    if ($row = $ev->fetch()) {
        foreach (event_photos($id) as $p) delete_image_files($p['file']);
        delete_image_files($row['cover']);
        db()->prepare('DELETE FROM events WHERE id = ?')->execute([$id]);
        flash('Evenimentul a fost șters.');
    }
    header('Location: index.php');
    exit;
}

$rows = db()->query("SELECT e.*, (SELECT COUNT(*) FROM event_photos p WHERE p.event_id = e.id) AS photos,
    date(CASE WHEN e.ends_on != '' THEN e.ends_on ELSE e.starts_at END) >= date('now','localtime') AS upcoming
    FROM events e ORDER BY upcoming DESC,
    CASE WHEN date(CASE WHEN e.ends_on != '' THEN e.ends_on ELSE e.starts_at END) >= date('now','localtime') THEN e.starts_at END ASC,
    e.starts_at DESC")->fetchAll();

admin_header('Evenimente');
?>
<div class="a-head">
    <h1>Evenimente</h1>
    <a href="edit.php" class="a-btn">+ Eveniment nou</a>
</div>

<?php if (!$rows): ?>
    <div class="a-card a-empty">
        <p>Nu există încă niciun eveniment.</p>
        <a href="edit.php" class="a-btn">Adaugă primul eveniment</a>
    </div>
<?php else: ?>
<div class="a-list">
    <?php $section = null; foreach ($rows as $r):
        $s = $r['upcoming'] ? 'Urmează' : 'Arhivă';
        if ($s !== $section): $section = $s; ?>
            <h2 class="a-section"><?= $s ?></h2>
        <?php endif; ?>
        <div class="a-row">
            <div class="a-thumb"><?php if ($r['cover']): ?><img src="../<?= e(photo_url($r['cover'], true)) ?>" alt=""><?php endif; ?></div>
            <div class="a-info">
                <strong><?= e($r['title']) ?></strong>
                <span><?= e(event_date_long($r['starts_at'], $r['ends_on'])) ?><?= $r['venue'] ? ' · ' . e($r['venue']) : '' ?></span>
                <span class="a-tags">
                    <?php if (!$r['published']): ?><em class="a-tag a-tag-draft">Ciornă</em><?php endif; ?>
                    <?php if ($r['category']): ?><em class="a-tag"><?= e($r['category']) ?></em><?php endif; ?>
                    <?php if ($r['photos']): ?><em class="a-tag"><?= (int)$r['photos'] ?> foto</em><?php endif; ?>
                </span>
            </div>
            <div class="a-actions">
                <a href="edit.php?id=<?= (int)$r['id'] ?>" class="a-btn a-btn-sm a-btn-ghost">Editează</a>
                <a href="../eveniment.php?e=<?= e($r['slug']) ?>" target="_blank" class="a-btn a-btn-sm a-btn-ghost">Vezi</a>
                <form method="post" onsubmit="return confirm('Ștergi definitiv acest eveniment și pozele lui?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                    <button class="a-btn a-btn-sm a-btn-danger">Șterge</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php admin_footer();
