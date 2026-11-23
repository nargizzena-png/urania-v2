<?php
require_once 'includes/db.php';

$perPage = 12;
$page = max(1, (int)($_GET['p'] ?? 1));

// O singură pagină: întâi ce urmează, apoi arhiva — mereu cu imagini, fără ecran gol
$upcoming = upcoming_events();
$total = past_events_count();
$past = past_events($perPage, ($page - 1) * $perPage);
$pages = max(1, (int)ceil($total / $perPage));

$page_title = 'Jurnal';
$page_desc = 'Calendarul Urania Studio Cluj-Napoca: concerte, spectacole, proiecții și evenimente care urmează, plus arhiva evenimentelor trecute.';
include 'includes/header.php';

function event_card(array $ev, bool $past): void
{
    $t = strtotime($ev['starts_at']);
    $url = 'eveniment.php?e=' . rawurlencode($ev['slug']);
    ?>
    <article class="ev-card reveal<?= $past ? ' ev-past' : '' ?>">
        <a href="<?= e($url) ?>" class="ev-media" tabindex="-1" aria-hidden="true">
            <?php if ($ev['cover']): ?>
                <img src="<?= e(photo_url($ev['cover'], true)) ?>" alt="Afiș: <?= e($ev['title']) ?> — Urania Studio, Cluj" loading="lazy" decoding="async">
            <?php else: ?>
                <span class="ev-noimg">URANIA</span>
            <?php endif; ?>
            <?php if (($ev['video'] ?? '') !== ''): ?><span class="ev-video-badge">&#9654; Video</span><?php endif; ?>
            <span class="ev-date"><strong><?= e(event_day_label($ev)) ?></strong><?= ro_month((int)date('n', $t), true) ?><?= date('Y', $t) != date('Y') ? '<small>' . date('Y', $t) . '</small>' : '' ?></span>
        </a>
        <div class="ev-body">
            <span class="card-sub"><?= e(implode(' · ', array_filter([$ev['category'], $ev['venue']]))) ?></span>
            <h3 class="ev-title"><a href="<?= e($url) ?>"><?= e($ev['title']) ?></a></h3>
            <p class="ev-when"><?= e(event_date_long($ev['starts_at'], $ev['ends_on'] ?? '')) ?></p>
            <?php if ($ev['excerpt']): ?><p class="ev-excerpt"><?= e($ev['excerpt']) ?></p><?php endif; ?>
            <div class="ev-links">
                <a href="<?= e($url) ?>" class="card-link"><?= $past ? 'Vezi galeria' : 'Detalii' ?> &rarr;</a>
                <?php if (!$past && $ev['ticket_url']): ?><a href="<?= e($ev['ticket_url']) ?>" class="btn-gold btn-sm" target="_blank" rel="noopener noreferrer"><?= e(ticket_label($ev['ticket_url'], true)) ?></a><?php endif; ?>
            </div>
        </div>
    </article>
    <?php
}
?>

<a href="#main-content" class="skip-to-content">Sari la conținutul principal</a>

<main id="main-content">
<section class="section ev-section">
    <div class="container">
        <div class="text-center">
            <span class="section-label reveal">Calendar</span>
            <h1 class="section-title gold-text reveal">Jurnal</h1>
            <div class="gold-line gold-line-center reveal" aria-hidden="true"></div>
        </div>

        <?php if ($upcoming): ?>
        <div class="ev-block" id="urmeaza">
            <h2 class="ev-block-title"><span>Urmează</span></h2>
            <div class="ev-grid">
                <?php foreach ($upcoming as $ev) event_card($ev, false); ?>
            </div>
        </div>
        <?php else: ?>
        <p class="ev-soon reveal">Programul următoarelor evenimente va fi anunțat în curând · <a href="preturi.php">Organizează un eveniment la Urania &rarr;</a></p>
        <?php endif; ?>

        <?php if ($past): ?>
        <div class="ev-block" id="arhiva">
            <h2 class="ev-block-title"><span>Din arhivă</span></h2>
            <div class="ev-grid">
                <?php foreach ($past as $ev) event_card($ev, true); ?>
            </div>
            <?php if ($pages > 1): ?>
            <nav class="ev-pager" aria-label="Paginare arhivă">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="jurnal.php?p=<?= $i ?>#arhiva" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </nav>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
</main>

<?php include 'includes/footer.php'; ?>
