<?php require_once __DIR__ . '/config.php'; ?>
<footer class="footer-main">
    <div class="footer-container">
        <div class="footer-col footer-brand">
            <a href="index.php" class="footer-wordmark gold-text">URANIA</a>
            <span class="footer-logo">Partenerul imaginației tale</span>
            <p>Sală de spectacol, scenă și studio de sunet în Cluj-Napoca.</p>
        </div>

        <nav class="footer-col" aria-label="Navigare subsol">
            <h2 class="footer-h">Navigare</h2>
            <ul>
                <li><a href="spatii.php">Spații</a></li>
                <li><a href="preturi.php">Prețuri</a></li>
                <li><a href="jurnal.php">Jurnal</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>

        <div class="footer-col">
            <h2 class="footer-h">Contact</h2>
            <ul>
                <li>Strada Horea, nr. 4, Cluj-Napoca</li>
                <li><a href="tel:+40756861229">+40 756 861 229</a></li>
                <li><a href="mailto:uraniastudio.eu@gmail.com">uraniastudio.eu@gmail.com</a></li>
                <li><a href="https://www.facebook.com/profile.php?id=61586391453182" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f" aria-hidden="true"></i> Facebook</a></li>
                <li><a href="https://www.instagram.com/studiourania/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram" aria-hidden="true"></i> Instagram</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h2 class="footer-h">Informații legale</h2>
            <ul>
                <li><a href="termeni.php">Termeni și condiții</a></li>
                <li><a href="privacy.php">Politica de confidențialitate</a></li>
                <li><a href="cookies.php">Politica de cookies</a></li>
                <?php if (GA_MEASUREMENT_ID !== ''): ?><li><a href="#" data-cookie-settings>Setări cookies</a></li><?php endif; ?>
                <li><a href="https://anpc.ro/" target="_blank" rel="noopener noreferrer">ANPC</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-anpc">
        <a href="https://anpc.ro/sal" target="_blank" rel="noopener noreferrer" title="Soluționarea alternativă a litigiilor (SAL) — ANPC">
            <img src="images/anpc-sal.png" alt="ANPC — Soluționarea alternativă a litigiilor" width="201" height="50" loading="lazy">
        </a>
    </div>

    <div class="footer-legal">
        <p>&copy; <?php echo date('Y'); ?> Urania Studio &middot; operat de PIXEL STUDIOS TRANSILVANIA SRL</p>
        <p>CUI 41218534 &middot; Nr. Reg. Com. J2019002330127 &middot; EUID ROONRC.J2019002330127 &middot; Sediu: Str. Fierului 22, Cluj-Napoca 400179</p>
    </div>
</footer>


<a href="https://wa.me/40756861229" target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Contactează-ne pe WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<?php include __DIR__ . '/consent.php'; ?>
<script src="js/script.js?v=<?php echo filemtime(__DIR__ . '/../js/script.js'); ?>"></script>
</body>
</html>
