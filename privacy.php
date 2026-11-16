<?php
require_once 'includes/config.php';
$page_title = 'Politica de confidențialitate';
$page_desc = 'Cum prelucrează Urania Studio datele personale trimise prin site: ce date colectăm, de ce, cât timp le păstrăm și ce drepturi ai.';
include 'includes/header.php';
?>

<a href="#main-content" class="skip-to-content">Sari la conținutul principal</a>

<main id="main-content">
<section class="section">
    <div class="container legal">
        <header class="legal-head">
            <span class="section-label">Informații legale</span>
            <h1 class="section-title gold-text">Politica de confidențialitate</h1>
            <div class="gold-line gold-line-center" aria-hidden="true"></div>
            <p class="legal-updated">Ultima actualizare: <?= LEGAL_UPDATED ?></p>
        </header>

        <nav class="legal-toc" aria-label="Cuprins">
            <strong>Cuprins</strong>
            <ol>
                <li><a href="#operator">Cine suntem</a></li>
                <li><a href="#date">Ce date colectăm</a></li>
                <li><a href="#scop">De ce și pe ce temei</a></li>
                <li><a href="#durata">Cât timp le păstrăm</a></li>
                <li><a href="#destinatari">Cui le transmitem</a></li>
                <li><a href="#transfer">Transferuri în afara UE</a></li>
                <li><a href="#drepturi">Drepturile tale</a></li>
                <li><a href="#securitate">Securitate</a></li>
                <li><a href="#minori">Minori</a></li>
                <li><a href="#modificari">Modificări</a></li>
            </ol>
        </nav>

        <h2 id="operator">1. Cine suntem</h2>
        <p>Operatorul datelor tale personale este <strong><?= COMPANY_NAME ?></strong>, care administrează spațiul și site-ul Urania Studio.</p>
        <ul>
            <li>Sediu social: <?= COMPANY_ADDRESS ?></li>
            <li>CUI <?= COMPANY_CUI ?> · Nr. Reg. Com. <?= COMPANY_REGCOM ?></li>
            <li>Adresa spațiului: <?= VENUE_ADDRESS ?></li>
            <li>Email: <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a> · Telefon: <?= SITE_PHONE ?></li>
        </ul>
        <p>Pentru orice întrebare despre datele tale ne poți scrie la adresa de email de mai sus.</p>

        <h2 id="date">2. Ce date colectăm</h2>
        <h3>Date pe care ni le trimiți tu</h3>
        <p>Când completezi formularul de contact sau de cerere ofertă: numele, adresa de email, numărul de telefon (opțional), tipul evenimentului, data dorită, numărul de participanți și mesajul tău. Aceleași date le primim și dacă ne scrii direct pe email, telefon sau WhatsApp.</p>
        <p>Dacă rezervi spațiul, pentru contract și factură vom avea nevoie și de datele de facturare (pentru firme: denumire, CUI, sediu; pentru persoane fizice: nume și adresă).</p>
        <h3>Date colectate automat</h3>
        <ul>
            <li><strong>Adresa IP</strong> — păstrată temporar (maxim o oră) pentru a limita mesajele automate (spam) trimise prin formular și încercările de autentificare.</li>
            <li><strong>Date de utilizare a site-ului</strong> — doar dacă îți dai acordul pentru cookie-urile de analiză (vezi <a href="cookies.php">Politica de cookies</a>).</li>
        </ul>

        <h2 id="scop">3. De ce folosim datele și pe ce temei</h2>
        <table class="legal-table">
            <thead><tr><th>Scop</th><th>Temei legal (GDPR)</th></tr></thead>
            <tbody>
                <tr><td>Să răspundem cererii tale și să-ți trimitem o ofertă</td><td>Demersuri înainte de încheierea unui contract, la cererea ta — art. 6 alin. (1) lit. b)</td></tr>
                <tr><td>Încheierea și executarea contractului de servicii</td><td>Executarea contractului — art. 6 alin. (1) lit. b)</td></tr>
                <tr><td>Facturare și evidență contabilă</td><td>Obligație legală — art. 6 alin. (1) lit. c)</td></tr>
                <tr><td>Protecția site-ului împotriva spamului și abuzurilor</td><td>Interes legitim — art. 6 alin. (1) lit. f)</td></tr>
                <tr><td>Noutăți despre evenimente și oferte, pe email — doar dacă ai bifat căsuța separată din formular</td><td>Consimțământul tău — art. 6 alin. (1) lit. a); te poți dezabona oricând</td></tr>
                <tr><td>Statistici de vizitare (Google Analytics)</td><td>Consimțământul tău — art. 6 alin. (1) lit. a)</td></tr>
            </tbody>
        </table>
        <p>Folosim datele pentru noutăți și oferte doar dacă ai bifat separat această opțiune; căsuța nu este bifată implicit și nu este obligatorie pentru a trimite cererea. Te poți dezabona oricând, cu un simplu răspuns la email sau scriindu-ne la adresa de mai sus. Nu luăm decizii automate care să te afecteze.</p>

        <h2 id="durata">4. Cât timp păstrăm datele</h2>
        <ul>
            <li>Cererile și corespondența care nu s-au concretizat într-o rezervare: <strong>maxim 24 de luni</strong> de la ultimul mesaj.</li>
            <li>Contractele și documentele de facturare: <strong>10 ani</strong>, cât cere legislația contabilă.</li>
            <li>Adresa IP folosită împotriva spamului: <strong>maxim o oră</strong>.</li>
            <li>Datele pentru noutăți și oferte: până la dezabonare.</li>
            <li>Datele de analiză: conform setărilor Google Analytics (maxim 14 luni).</li>
        </ul>

        <h2 id="destinatari">5. Cui transmitem datele</h2>
        <p>Nu vindem și nu închiriem datele tale. Ele pot ajunge doar la furnizori care ne ajută să funcționăm, legați prin contract de obligații de confidențialitate:</p>
        <ul>
            <li>furnizorul de găzduire a site-ului;</li>
            <li>Google (serviciul de email Gmail; Google Analytics, doar cu acordul tău);</li>
            <li>contabilul sau firma de contabilitate, pentru facturare;</li>
            <li>autorități publice, doar când legea ne obligă.</li>
        </ul>

        <h2 id="transfer">6. Transferuri în afara Uniunii Europene</h2>
        <p>Unii furnizori (de exemplu Google) pot prelucra date în Statele Unite. Aceste transferuri se fac în baza Cadrului UE–SUA privind protecția datelor (Data Privacy Framework) sau a clauzelor contractuale standard aprobate de Comisia Europeană.</p>

        <h2 id="drepturi">7. Drepturile tale</h2>
        <p>Conform Regulamentului (UE) 2016/679 (GDPR), ai dreptul:</p>
        <ul>
            <li>să afli ce date avem despre tine și să primești o copie (dreptul de acces);</li>
            <li>să ceri corectarea datelor greșite (rectificare);</li>
            <li>să ceri ștergerea datelor („dreptul de a fi uitat”), când nu mai avem un motiv legal să le păstrăm;</li>
            <li>să ceri restricționarea prelucrării;</li>
            <li>să primești datele într-un format structurat (portabilitate);</li>
            <li>să te opui prelucrării bazate pe interes legitim;</li>
            <li>să îți retragi oricând consimțământul, fără a afecta prelucrarea făcută până atunci.</li>
        </ul>
        <p>Pentru a-ți exercita drepturile, scrie-ne la <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>. Răspundem în cel mult o lună.</p>
        <div class="legal-card">
            <p>Dacă consideri că drepturile tale au fost încălcate, poți depune o plângere la <strong>Autoritatea Națională de Supraveghere a Prelucrării Datelor cu Caracter Personal (ANSPDCP)</strong>, B-dul G-ral. Gheorghe Magheru 28–30, București · <a href="https://www.dataprotection.ro" target="_blank" rel="noopener noreferrer">www.dataprotection.ro</a>.</p>
        </div>

        <h2 id="securitate">8. Securitate</h2>
        <p>Site-ul folosește conexiune criptată (HTTPS). Accesul la datele primite este limitat la persoanele care se ocupă de rezervări. Formularul are protecție împotriva mesajelor automate.</p>

        <h2 id="minori">9. Minori</h2>
        <p>Serviciile noastre se adresează persoanelor de peste 18 ani. Nu colectăm cu bună știință date de la minori. Dacă ești părinte și crezi că un minor ne-a trimis date, scrie-ne și le vom șterge.</p>

        <h2 id="modificari">10. Modificări</h2>
        <p>Putem actualiza această politică atunci când se schimbă modul în care lucrăm sau legislația. Versiunea în vigoare este întotdeauna cea publicată pe această pagină, cu data ultimei actualizări de mai sus.</p>
    </div>
</section>
</main>

<?php include 'includes/footer.php'; ?>
