<?php
require_once 'includes/config.php';
$page_title = 'Termeni și condiții';
$page_desc = 'Termenii și condițiile de rezervare și utilizare a spațiilor Urania Studio: ofertă, avans, anulare, reprogramare, garanție și regulament intern.';
include 'includes/header.php';
?>

<a href="#main-content" class="skip-to-content">Sari la conținutul principal</a>

<main id="main-content">
<section class="section">
    <div class="container legal">
        <header class="legal-head">
            <span class="section-label">Informații legale</span>
            <h1 class="section-title gold-text">Termeni și condiții</h1>
            <div class="gold-line gold-line-center" aria-hidden="true"></div>
            <p class="legal-updated">Ultima actualizare: <?= LEGAL_UPDATED ?></p>
        </header>

        <nav class="legal-toc" aria-label="Cuprins">
            <strong>Cuprins</strong>
            <ol>
                <li><a href="#general">Informații generale</a></li>
                <li><a href="#preturi">Prețuri și ofertă</a></li>
                <li><a href="#rezervare">Rezervare și plată</a></li>
                <li><a href="#anulare">Anulare și reprogramare</a></li>
                <li><a href="#garantie">Garanția</a></li>
                <li><a href="#regulament">Regulament intern</a></li>
                <li><a href="#raspundere">Răspundere</a></li>
                <li><a href="#forta-majora">Forță majoră</a></li>
                <li><a href="#site">Utilizarea site-ului</a></li>
                <li><a href="#litigii">Reclamații și litigii</a></li>
            </ol>
        </nav>

        <h2 id="general">1. Informații generale</h2>
        <p>Site-ul și spațiile Urania Studio (<?= VENUE_ADDRESS ?>) sunt administrate de <strong><?= COMPANY_NAME ?></strong>, cu sediul social în <?= COMPANY_ADDRESS ?>, CUI <?= COMPANY_CUI ?>, Nr. Reg. Com. <?= COMPANY_REGCOM ?>, numită în continuare „Urania Studio” sau „noi”.</p>
        <p>Acești termeni se aplică cererilor de ofertă și rezervărilor pentru Sala Mare, Studio de sunet și sala de repetiții. Pentru fiecare rezervare se încheie un contract de servicii pentru sesiune de lucru; dacă acesta prevede altceva decât termenii de față, are prioritate contractul.</p>

        <h2 id="preturi">2. Prețuri și ofertă</h2>
        <ul>
            <li>Prețurile afișate pe site sunt <strong>orientative</strong> („de la…”) și au rol informativ.</li>
            <li>Prețul final este cel din <strong>oferta scrisă</strong> pe care ți-o trimitem, în funcție de dată, durată, sală și serviciile suplimentare (tehnician, curățenie, echipamente).</li>
            <li>Oferta este valabilă <strong>7 zile</strong> de la trimitere, dacă nu este menționat altfel.</li>
            <li>Tarifele pot diferi pentru weekend (vineri seara – duminică) și sărbători legale.</li>
        </ul>

        <h2 id="rezervare">3. Rezervare și plată</h2>
        <ol class="legal-steps">
            <li><p><strong>Cererea</strong> — ne trimiți data, formatul și numărul de participanți prin formular, telefon, email sau WhatsApp.</p></li>
            <li><p><strong>Oferta</strong> — îți trimitem oferta scrisă.</p></li>
            <li><p><strong>Confirmarea</strong> — rezervarea devine fermă după semnarea contractului și plata unui <strong>avans de 30%</strong> din valoarea totală. Până atunci, data nu este blocată.</p></li>
            <li><p><strong>Garanția</strong> se achită înainte de eveniment și se returnează după eveniment, dacă spațiul și echipamentele nu au fost deteriorate.</p></li>
            <li><p><strong>Restul de plată</strong> se achită în cel mult <strong>3 zile lucrătoare după eveniment</strong>.</p></li>
        </ol>
        <p><strong>Bilete și alte venituri:</strong> vânzarea de bilete și orice alte încasări obținute din eveniment sunt în întregime responsabilitatea organizatorului. Urania Studio nu răspunde de acestea.</p>
        <p>Plata se face prin transfer bancar, pe baza facturii emise de <?= COMPANY_NAME ?>.</p>

        <h2 id="anulare">4. Anulare și reprogramare</h2>
        <table class="legal-table">
            <thead><tr><th>Când anulezi</th><th>Ce se întâmplă cu avansul</th></tr></thead>
            <tbody>
                <tr><td>Cu peste 30 de zile înainte</td><td>Avansul se returnează integral sau se mută pe o altă dată</td></tr>
                <tr><td>Între 30 și 14 zile înainte</td><td>Se reține 50% din avans</td></tr>
                <tr><td>Cu mai puțin de 14 zile înainte</td><td>Avansul nu se returnează</td></tr>
            </tbody>
        </table>
        <ul>
            <li><strong>Reprogramarea</strong> se poate face o singură dată, gratuit, cu cel puțin 14 zile înainte, în funcție de disponibilitatea sălii, în maxim 6 luni.</li>
            <li>Dacă noi suntem nevoiți să anulăm, îți returnăm integral sumele plătite sau îți propunem o altă dată, la alegerea ta.</li>
            <li>Anularea se comunică în scris, pe email.</li>
        </ul>

        <h2 id="garantie">5. Garanția</h2>
        <p>Pentru evenimente se percepe o garanție pentru integritatea spațiului și a echipamentelor, stabilită în ofertă. Starea sălii se consemnează într-un proces-verbal de predare-primire, cu fotografii, înainte și după eveniment. Garanția se returnează în cel mult <strong>7 zile lucrătoare</strong> după eveniment, mai puțin eventualele daune constatate în procesul-verbal.</p>

        <h2 id="regulament">6. Regulament intern</h2>
        <p>Pentru siguranța tuturor și păstrarea spațiului, pe durata închirierii se respectă următoarele reguli:</p>
        <ul>
            <li><strong>Program:</strong> activitatea în sală se încheie cel târziu la ora <strong>22:00</strong>, cu respectarea liniștii vecinilor.</li>
            <li><strong>Fumatul</strong> (inclusiv țigări electronice) este interzis în tot spațiul.</li>
            <li><strong>Fixări pe pereți</strong>, decoruri, confetti, fum, pirotehnie sau flacără deschisă — doar cu acordul nostru scris.</li>
            <li><strong>Montaj și demontaj</strong> — în intervalul rezervat; timpul suplimentar se taxează.</li>
            <li><strong>Capacitatea</strong> maximă a sălii nu poate fi depășită.</li>
            <li><strong>Echipamentele tehnice</strong> ale sălii sunt operate de tehnicianul nostru sau cu acordul lui.</li>
            <li>Spațiul se predă <strong>în starea în care a fost primit</strong>; curățenia suplimentară și daunele se taxează din garanție.</li>
            <li>Organizatorul răspunde de comportamentul participanților și de obținerea eventualelor avize necesare evenimentului (de exemplu drepturi de autor pentru muzică).</li>
        </ul>

        <h2 id="raspundere">7. Răspundere</h2>
        <p>Organizatorul răspunde pentru daunele produse spațiului, mobilierului și echipamentelor de el, de echipa sau de invitații săi. Urania Studio nu răspunde pentru bunurile personale lăsate nesupravegheate în spațiu.</p>

        <h2 id="forta-majora">8. Forță majoră</h2>
        <p>Niciuna dintre părți nu răspunde pentru neexecutarea obligațiilor cauzată de forță majoră (de exemplu restricții impuse de autorități, calamități, întreruperi majore de utilități). În acest caz, evenimentul se reprogramează sau sumele plătite se returnează, fără penalități.</p>

        <h2 id="site">9. Utilizarea site-ului</h2>
        <p>Conținutul site-ului (texte, fotografii, logo, video) aparține Urania Studio sau partenerilor săi și nu poate fi folosit fără acord. Prelucrarea datelor personale este descrisă în <a href="privacy.php">Politica de confidențialitate</a>, iar folosirea cookie-urilor în <a href="cookies.php">Politica de cookies</a>.</p>

        <h2 id="litigii">10. Reclamații și litigii</h2>
        <p>Pentru orice nemulțumire, scrie-ne la <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a> — răspundem în cel mult 15 zile lucrătoare. Încercăm întotdeauna să rezolvăm situațiile pe cale amiabilă.</p>
        <p>Consumatorii se pot adresa și <strong>Autorității Naționale pentru Protecția Consumatorilor</strong> (<a href="https://anpc.ro" target="_blank" rel="noopener noreferrer">anpc.ro</a>) sau pot folosi procedura de <a href="https://anpc.ro/sal" target="_blank" rel="noopener noreferrer">Soluționare Alternativă a Litigiilor (SAL)</a>.</p>
        <p>Acești termeni sunt guvernați de legea română. Litigiile care nu pot fi soluționate amiabil sunt de competența instanțelor din Cluj-Napoca, cu excepția cazurilor în care legea prevede altfel pentru consumatori.</p>
    </div>
</section>
</main>

<?php include 'includes/footer.php'; ?>
