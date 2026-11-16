<?php
require_once 'includes/db.php';

$st = db()->prepare('SELECT * FROM events WHERE slug = ? AND published = 1');
$st->execute([(string)($_GET['e'] ?? '')]);
$ev = $st->fetch();

if (!$ev) {
    http_response_code(404);
    $page_title = 'Eveniment negăsit';
    include 'includes/header.php';
    echo '<section class="coming-soon"><h2 class="section-title gold-text">Eveniment negăsit</h2><p>Evenimentul nu există sau a fost retras.</p><a href="jurnal.php" class="btn-gold">Înapoi la Jurnal</a></section>';
    include 'includes/footer.php';
    exit;
}

$photos = event_photos((int)$ev['id']);
$past = strtotime(($ev['ends_on'] ?? '') !== '' ? $ev['ends_on'] : substr($ev['starts_at'], 0, 10)) < strtotime('today');

$page_title = $ev['title'];
$page_desc = $ev['excerpt'] ?: ($ev['title'] . ' — ' . event_date_long($ev['starts_at'], $ev['ends_on'] ?? '') . ', Urania Studio Cluj-Napoca.');
if ($ev['cover']) $og_image = photo_url($ev['cover']);
include 'includes/header.php';

$jsonLd = array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Event',
    'name' => $ev['title'],
    'startDate' => str_replace(' ', 'T', $ev['starts_at']),
    'endDate' => ($ev['ends_on'] ?? '') !== '' ? $ev['ends_on'] : null,
    'eventStatus' => 'https://schema.org/EventScheduled',
    'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
    'location' => ['@type' => 'Place', 'name' => 'Urania Studio' . ($ev['venue'] ? ' — ' . $ev['venue'] : ''),
        'address' => ['@type' => 'PostalAddress', 'streetAddress' => 'Strada Horea 4', 'addressLocality' => 'Cluj-Napoca', 'addressCountry' => 'RO']],
    'description' => $ev['excerpt'],
], fn($v) => $v !== null);
if ($ev['cover']) $jsonLd['image'] = 'https://' . ($_SERVER['HTTP_HOST'] ?? 'uraniastudio.eu') . '/' . photo_url($ev['cover']);
if ($ev['ticket_url'] && !is_facebook_link($ev['ticket_url'])) $jsonLd['offers'] = ['@type' => 'Offer', 'url' => $ev['ticket_url']];
?>
<script type="application/ld+json"><?= json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>

<a href="#main-content" class="skip-to-content">Sari la conținutul principal</a>

<main id="main-content">
<article class="section evd">
    <div class="container">
        <a href="jurnal.php<?= $past ? '#arhiva' : '' ?>" class="card-link evd-back">&larr; <?= $past ? 'Arhivă' : 'Toate evenimentele' ?></a>

        <div class="evd-head">
            <?php if ($ev['cover']): ?>
            <figure class="evd-cover">
                <img src="<?= e(photo_url($ev['cover'])) ?>" alt="Afiș: <?= e($ev['title']) ?>">
            </figure>
            <?php endif; ?>
            <div class="evd-info">
                <span class="card-sub"><?= e(implode(' · ', array_filter([$ev['category'], $ev['venue']]))) ?></span>
                <h1 class="evd-title gold-text"><?= e($ev['title']) ?></h1>
                <p class="evd-when"><?= e(event_date_long($ev['starts_at'], $ev['ends_on'] ?? '')) ?></p>
                <p class="evd-where">Urania Studio<?= $ev['venue'] ? ' — ' . e($ev['venue']) : '' ?> · Strada Horea 4, Cluj-Napoca</p>
                <?php if ($past): ?>
                    <span class="evd-badge">Eveniment încheiat</span>
                <?php elseif ($ev['ticket_url']): ?>
                    <a href="<?= e($ev['ticket_url']) ?>" class="btn-gold btn-gold-fill" target="_blank" rel="noopener noreferrer"><?= e(ticket_label($ev['ticket_url'])) ?></a>
                <?php endif; ?>
                <?php if (($ev['video'] ?? '') !== ''): ?>
                <div class="evd-video">
                    <video src="<?= e(URANIA_UPLOAD_URL . '/' . rawurlencode($ev['video'])) ?>#t=0.5" controls playsinline preload="metadata"></video>
                </div>
                <?php endif; ?>
                <?php if ($ev['body']): ?>
                <div class="evd-text">
                    <?php foreach (preg_split('/\R{2,}/', $ev['body']) as $para): ?>
                        <p><?= nl2br(e(trim($para))) ?></p>
                    <?php endforeach; ?>
                </div>
                <?php elseif ($ev['excerpt']): ?>
                <div class="evd-text"><p><?= e($ev['excerpt']) ?></p></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($photos): ?>
        <section class="evd-gallery" aria-label="Galerie foto">
            <h2 class="section-title gold-text">Galerie</h2>
            <div class="gallery-grid">
                <?php foreach ($photos as $i => $p): ?>
                <a href="<?= e(photo_url($p['file'])) ?>" class="gallery-item" data-lightbox data-index="<?= $i ?>">
                    <img src="<?= e(photo_url($p['file'], true)) ?>" alt="<?= e($ev['title']) ?> — foto <?= $i + 1 ?>" loading="lazy" decoding="async">
                </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
</article>
</main>

<?php include 'includes/lightbox.php'; ?>

<?php include 'includes/footer.php'; ?>
