<?php
require_once 'includes/config.php';
$page_title = 'Politica de cookies';
$page_desc = 'Ce cookie-uri folosește site-ul Urania Studio, de ce și cum îți poți schimba alegerea.';
include 'includes/header.php';
?>

<a href="#main-content" class="skip-to-content">Sari la conținutul principal</a>

<main id="main-content">
<section class="section">
    <div class="container legal">
        <header class="legal-head">
            <span class="section-label">Informații legale</span>
            <h1 class="section-title gold-text">Politica de cookies</h1>
            <div class="gold-line gold-line-center" aria-hidden="true"></div>
            <p class="legal-updated">Ultima actualizare: <?= LEGAL_UPDATED ?></p>
        </header>

        <h2>Ce sunt cookie-urile</h2>
        <p>Cookie-urile sunt fișiere mici pe care un site le salvează în browserul tău. Unele sunt necesare ca site-ul să funcționeze, altele ne ajută să înțelegem cum este folosit. Folosim cookie-uri de analiză <strong>doar dacă îți dai acordul</strong>.</p>

        <h2>Ce folosim</h2>
        <h3>Strict necesare (fără acord)</h3>
        <table class="legal-table">
            <thead><tr><th>Nume</th><th>Scop</th><th>Durată</th></tr></thead>
            <tbody>
                <tr><td>urania_consent</td><td>Ține minte alegerea ta privind cookie-urile (stocare locală în browser)</td><td>6 luni</td></tr>
                <tr><td>urania_admin</td><td>Sesiunea de autentificare în panoul de administrare — doar pentru echipa noastră</td><td>Până la închiderea browserului</td></tr>
            </tbody>
        </table>

        <h3>Analiză (doar cu acordul tău)</h3>
        <table class="legal-table">
            <thead><tr><th>Nume</th><th>Furnizor</th><th>Scop</th><th>Durată</th></tr></thead>
            <tbody>
                <tr><td>_ga</td><td>Google Analytics</td><td>Distinge vizitatorii, pentru statistici anonime de vizitare</td><td>2 ani</td></tr>
                <tr><td>_ga_*</td><td>Google Analytics</td><td>Păstrează starea sesiunii de vizitare</td><td>2 ani</td></tr>
            </tbody>
        </table>
        <p>Google Analytics ne arată, de exemplu, câte persoane vizitează pagina de prețuri sau din ce oraș vin vizitatorii. Nu folosim aceste date pentru publicitate. Detalii: <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">politica de confidențialitate Google</a>.</p>

        <h3>Conținut extern</h3>
        <ul>
            <li><strong>Harta Google</strong> din pagina de contact se încarcă doar când apeși „Afișează harta”. Atunci Google poate seta propriile cookie-uri.</li>
            <li><strong>Fonturile</strong> site-ului sunt încărcate de pe serverele Google Fonts, care primesc adresa IP a browserului tău. Nu se setează cookie-uri.</li>
            <li>Linkurile către <strong>Facebook</strong> și <strong>WhatsApp</strong> sunt simple linkuri; cookie-urile acestor servicii apar doar după ce le deschizi.</li>
        </ul>

        <h2>Cum îți schimbi alegerea</h2>
        <?php if (GA_MEASUREMENT_ID !== ''): ?>
        <p>Îți poți schimba oricând alegerea: <a href="#" data-cookie-settings>deschide setările de cookies</a>. Linkul „Setări cookies” se află și în subsolul fiecărei pagini.</p>
        <?php else: ?>
        <p>În acest moment site-ul nu folosește cookie-uri de analiză. Când le vom activa, vei putea alege din bannerul de cookies și din linkul „Setări cookies” din subsol.</p>
        <?php endif; ?>
        <p>Poți șterge sau bloca cookie-urile și din setările browserului tău. Blocarea cookie-urilor strict necesare poate afecta funcționarea unor părți ale site-ului.</p>

        <h2>Contact</h2>
        <p>Întrebări despre cookie-uri sau date personale: <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>. Vezi și <a href="privacy.php">Politica de confidențialitate</a>.</p>
    </div>
</section>
</main>

<?php include 'includes/footer.php'; ?>
