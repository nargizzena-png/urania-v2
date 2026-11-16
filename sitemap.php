<?php
/**
 * sitemap.xml dinamic: paginile statice + evenimentele publicate din Jurnal.
 * Servit ca /sitemap.xml prin .htaccess.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/xml; charset=UTF-8');

$pages = [
    '/'             => ['weekly',  '1.0', __DIR__ . '/index.php'],
    '/spatii.php'   => ['monthly', '0.9', __DIR__ . '/spatii.php'],
    '/preturi.php'  => ['monthly', '0.9', __DIR__ . '/preturi.php'],
    '/jurnal.php'   => ['weekly',  '0.8', __DIR__ . '/jurnal.php'],
    '/contact.php'  => ['yearly',  '0.7', __DIR__ . '/contact.php'],
    '/privacy.php'  => ['yearly',  '0.2', __DIR__ . '/privacy.php'],
    '/cookies.php'  => ['yearly',  '0.2', __DIR__ . '/cookies.php'],
    '/termeni.php'  => ['yearly',  '0.2', __DIR__ . '/termeni.php'],
];

$esc = fn($s) => htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($pages as $path => [$freq, $prio, $file]) {
    echo "  <url><loc>" . $esc(SITE_URL . $path) . "</loc>"
       . "<lastmod>" . date('Y-m-d', filemtime($file)) . "</lastmod>"
       . "<changefreq>$freq</changefreq><priority>$prio</priority></url>\n";
}

try {
    $rows = db()->query('SELECT slug, updated_at FROM events WHERE published = 1 ORDER BY starts_at DESC')->fetchAll();
    foreach ($rows as $ev) {
        $loc = SITE_URL . '/eveniment.php?e=' . rawurlencode($ev['slug']);
        echo "  <url><loc>" . $esc($loc) . "</loc>"
           . "<lastmod>" . $esc(substr($ev['updated_at'], 0, 10)) . "</lastmod>"
           . "<changefreq>monthly</changefreq><priority>0.6</priority></url>\n";
    }
} catch (Throwable $e) {
    // Fără bază de date: sitemap-ul conține doar paginile statice.
}

echo "</urlset>\n";
