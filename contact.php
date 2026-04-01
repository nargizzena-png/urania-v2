<?php 
$page_title = 'Contact'; 
$page_desc = 'Contactează Urania Studio la 0739 333 357 sau pe WhatsApp. Strada Horea, nr. 4, Cluj-Napoca. Scrie-ne pentru evenimente, repetiții, podcast-uri și producții creative.'; 
include 'includes/header.php'; 
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Urania Studio",
  "description": "Hub Cultural & Studio de Producție în Cluj-Napoca",
  "url": "https://<?php echo $_SERVER['HTTP_HOST'] ?? 'uraniasstudio.ro'; ?>",
  "telephone": "+40739333357",
  "email": "uraniastudio.eu@gmail.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Strada Horea, nr. 4",
    "addressLocality": "Cluj-Napoca",
    "addressCountry": "RO"
  },
  "openingHours": "Mo-Su 00:00-24:00",
  "sameAs": [
    "https://www.facebook.com/profile.php?id=61586391453182"
  ]
}
</script>

<section class="section" id="contact-main">
    <div class="container">
        <div class="contact-wrap">
            <div class="contact-content">
                <div class="contact-info-box reveal">
                    <div class="contact-info-header">
                        <h2 class="contact-info-title">Urania Studio</h2>
                        <span class="contact-role">Hub Cultural & Studio de Producție</span>
                    </div>

                    <hr class="contact-divider">

                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt contact-icon" aria-hidden="true"></i>
                            <div class="contact-item-content">
                                <strong>Adresă:</strong>
                                <span>Strada Horea, nr. 4, Cluj-Napoca</span>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-phone-alt contact-icon" aria-hidden="true"></i>
                            <div class="contact-item-content">
                                <strong>Telefon:</strong>
                                <a href="tel:+40739333357" aria-label="Apelează 0739 333 357">0739 333 357</a>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-envelope contact-icon" aria-hidden="true"></i>
                            <div class="contact-item-content">
                                <strong>Email:</strong>
                                <a href="mailto:uraniastudio.eu@gmail.com" aria-label="Trimite email către uraniastudio.eu@gmail.com">uraniastudio.eu@gmail.com</a>
                            </div>
                        </div>
                    </div>

                    <div class="contact-actions">
                        <a href="tel:+40739333357" class="btn-gold contact-action-btn">
                            <i class="fas fa-phone-alt"></i><span>Sună Acum</span>
                        </a>
                        <a href="https://wa.me/40739333357" target="_blank" rel="noopener noreferrer" class="btn-gold btn-gold-fill contact-action-btn">
                            <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                        </a>
                        <a href="mailto:uraniastudio.eu@gmail.com" class="btn-gold contact-action-btn">
                            <i class="fas fa-envelope"></i><span>Email</span>
                        </a>
                    </div>

                    <div class="contact-response-time reveal">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                        <span>Răspundem în maxim 24 de ore</span>
                    </div>

                    <div class="contact-social reveal">
                        <p class="social-label">Urmărește-ne</p>
                        <div class="social-links">
                            <a href="https://www.facebook.com/profile.php?id=61586391453182" target="_blank" rel="noopener noreferrer" aria-label="Urmărește-ne pe Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="contact-form-box reveal">
                    <h2 class="form-title">Scrie-ne un mesaj</h2>
                    <p class="form-subtitle">Completează formularul și te contactăm în cel mai scurt timp</p>
                    
                    <form class="contact-form" action="contact-submit.php" method="POST" id="contactForm" novalidate>
                        <div class="form-group">
                            <label for="name">Nume complet <span class="required" aria-label="obligatoriu">*</span></label>
                            <input type="text" id="name" name="name" required aria-required="true" placeholder="Numele tău" pattern="[A-Za-zăâîșțĂÂÎȘȚ\s]{2,100}">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email <span class="required" aria-label="obligatoriu">*</span></label>
                            <input type="email" id="email" name="email" required aria-required="true" placeholder="email@exemplu.com">
                        </div>

                        <div class="form-group">
                            <label for="phone">Telefon (opțional)</label>
                            <input type="tel" id="phone" name="phone" placeholder="07xx xxx xxx" pattern="[0-9\s\+\-\(\)]{10,20}">
                        </div>

                        <div class="form-group">
                            <label for="subject">Subiect <span class="required" aria-label="obligatoriu">*</span></label>
                            <select id="subject" name="subject" required aria-required="true">
                                <option value="" disabled selected>Selectează un subiect</option>
                                <option value="eveniment">Organizare eveniment</option>
                                <option value="repetitii">Închiriere sală repetiții</option>
                                <option value="podcast">Închiriere studio podcast</option>
                                <option value="productie">Producție foto/video</option>
                                <option value="colaborare">Propunere de colaborare</option>
                                <option value="altele">Altele</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Mesajul tău <span class="required" aria-label="obligatoriu">*</span></label>
                            <textarea id="message" name="message" rows="5" required aria-required="true" placeholder="Spune-ne despre proiectul tău..."></textarea>
                        </div>

                        <div class="form-group form-consent">
                            <label class="checkbox-label">
                                <input type="checkbox" name="consent" required aria-required="true">
                                <span>Sunt de acord cu prelucrarea datelor personale conform <a href="privacy.php" target="_blank">Politicii de Confidențialitate</a> <span class="required">*</span></span>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn-gold btn-gold-fill form-submit">
                            <i class="fas fa-paper-plane"></i><span>Trimite Mesajul</span>
                        </button>
                    </form>

                    <div id="formSuccess" class="form-message form-success" role="status" aria-live="polite" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        <h3>Mulțumim!</h3>
                        <p>Mesajul tău a fost trimis cu succes. Te vom contacta în cel mai scurt timp.</p>
                    </div>

                    <div id="formError" class="form-message form-error" role="alert" aria-live="assertive" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <h3>Oops!</h3>
                        <p>A apărut o eroare la trimiterea mesajului. Te rugăm să încerci din nou sau să ne contactezi direct.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="map-container reveal">
            <h2 class="map-title">Găsește-ne</h2>
            <div class="map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21858.56324886526!2d23.5708!3d46.7684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47490c2a5a6b4b5f%3A0x123456789abcdef!2sStrada%20Horea%204%2C%20Cluj-Napoca!5e0!3m2!1sro!2sro!4v1234567890123!5m2!1sro!2sro"
                    width="100%" 
                    height="400" 
                    style="border:0; filter: grayscale(100%) invert(92%) contrast(83%);" 
                    allowfullscreen="" 
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Locația Urania Studio pe hartă"
                    aria-label="Hartă Google Maps cu locația Urania Studio - Strada Horea, nr. 4, Cluj-Napoca">
                </iframe>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
