<?php
/**
 * Banner de cookies + încărcarea Google Analytics 4 DOAR după acord.
 * Dacă GA_MEASUREMENT_ID este gol, nu se afișează nimic.
 */
require_once __DIR__ . '/config.php';
if (GA_MEASUREMENT_ID === '') return;
?>
<div class="cookie-banner" id="cookieBanner" role="dialog" aria-live="polite" aria-label="Setări cookies" hidden>
    <div class="cookie-inner">
        <i class="fa-solid fa-cookie-bite cookie-icon" aria-hidden="true"></i>
        <div class="cookie-text">
            <p class="cookie-title">Acceptați cookie-urile?</p>
            <p>Folosim cookie-uri de analiză (Google Analytics) ca să vedem ce pagini sunt utile. Le activăm doar cu acordul tău. <a href="cookies.php">Detalii</a></p>
        </div>
        <div class="cookie-actions">
            <button type="button" class="btn-gold btn-sm" data-consent="deny">Refuz</button>
            <button type="button" class="btn-gold btn-gold-fill btn-sm" data-consent="accept">Accept</button>
        </div>
    </div>
</div>
<script>
(function () {
    var GA_ID = <?= json_encode(GA_MEASUREMENT_ID) ?>, KEY = 'urania_consent', MAX_AGE = 1000 * 60 * 60 * 24 * 182;
    var banner = document.getElementById('cookieBanner');

    function read() {
        try { var c = JSON.parse(localStorage.getItem(KEY)); return c && Date.now() - c.ts < MAX_AGE ? c : null; } catch (e) { return null; }
    }
    function save(analytics) {
        try { localStorage.setItem(KEY, JSON.stringify({ analytics: analytics, ts: Date.now() })); } catch (e) {}
    }
    function loadGA() {
        if (window.__gaLoaded) return; window.__gaLoaded = true;
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () { dataLayer.push(arguments); };
        gtag('consent', 'default', { ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied', analytics_storage: 'granted' });
        gtag('js', new Date());
        // Trafic intern: ?intern=1 marchează acest browser (laptop, birou), ?intern=0 anulează.
        // În GA4 filtrul „Internal Traffic” exclude evenimentele cu traffic_type = internal.
        var internal = false;
        try {
            var m = location.search.match(/[?&]intern=([01])/);
            if (m) { m[1] === '1' ? localStorage.setItem('urania_internal', '1') : localStorage.removeItem('urania_internal'); }
            internal = localStorage.getItem('urania_internal') === '1';
        } catch (e) {}
        gtag('config', GA_ID, internal ? { traffic_type: 'internal' } : {});
        var s = document.createElement('script'); s.async = true;
        s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(GA_ID);
        document.head.appendChild(s);
    }
    function clearGA() {
        document.cookie.split(';').forEach(function (c) {
            var n = c.split('=')[0].trim();
            if (n === '_ga' || n.indexOf('_ga_') === 0) {
                var host = location.hostname, parts = host.split('.');
                var doms = ['', host, '.' + host, '.' + parts.slice(-2).join('.')];
                doms.forEach(function (d) { document.cookie = n + '=; Max-Age=0; path=/' + (d ? '; domain=' + d : ''); });
            }
        });
    }
    function show() { banner.hidden = false; }
    function hide() { banner.hidden = true; }

    banner.addEventListener('click', function (e) {
        var b = e.target.closest('[data-consent]'); if (!b) return;
        var ok = b.dataset.consent === 'accept';
        var had = (read() || {}).analytics;
        save(ok); hide();
        if (ok) loadGA();
        else if (had) { clearGA(); location.reload(); }
    });
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-cookie-settings]')) { e.preventDefault(); show(); }
    });

    var c = read();
    if (!c) show(); else if (c.analytics) loadGA();
})();
</script>
