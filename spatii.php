<?php
$page_title = 'Spații';
$preload_image = 'images/spatii/blackbox.webp';
include 'includes/header.php';
?>

<a href="#main-content" class="skip-to-content">Sari la conținutul principal</a>

<main id="main-content">

<section class="section" id="spatii-grid" aria-labelledby="spatii-title">
    <h1 id="spatii-title" class="sr-only">Spațiile noastre</h1>
    <div class="container">
        <div class="cards-grid" role="list">

            <article class="space-card reveal" id="blackbox" role="listitem" tabindex="0">
                <div class="card-img-wrap">
                    <img src="images/spatii/blackbox.webp" 
                         srcset="images/spatii/blackbox-400.webp 400w,
                                 images/spatii/blackbox-600.webp 600w,
                                 images/spatii/blackbox.webp 640w"
                         sizes="(max-width: 640px) 90vw, 400px"
                         alt=""
                         width="640"
                         height="640"
                         decoding="async"
                         aria-hidden="true">
                </div>
                <h2 class="card-title">Blackbox</h2>
                <span class="card-sub">Sala Mare</span>
                <p class="card-desc">Spațiu flexibil și multifuncțional pentru spectacole, prezentări, proiecții și evenimente de amploare. Echipat cu sistem de sunet și lumini profesionale.</p>
                <a href="contact.php" class="btn-gold" aria-label="Rezervă Blackbox">Rezervă</a>
            </article>

            <article class="space-card reveal reveal-delay-1" id="podcast" role="listitem" tabindex="0">
                <div class="card-img-wrap">
                    <img src="images/spatii/podcast.webp"
                         srcset="images/spatii/podcast-400.webp 400w,
                                 images/spatii/podcast-600.webp 600w,
                                 images/spatii/podcast.webp 640w"
                         sizes="(max-width: 640px) 90vw, 400px"
                         alt=""
                         width="640"
                         height="640"
                         loading="lazy"
                         decoding="async"
                         aria-hidden="true">
                </div>
                <h2 class="card-title">Studio Podcast</h2>
                <span class="card-sub">Înregistrare Audio</span>
                <p class="card-desc">Studio dotat profesional pentru înregistrări podcast, interviuri și conținut audio. Acustică optimizată și echipamente de top.</p>
                <a href="contact.php" class="btn-gold" aria-label="Rezervă Studio Podcast">Rezervă</a>
            </article>

            <article class="space-card reveal reveal-delay-2" id="repetitii" role="listitem" tabindex="0">
                <div class="card-img-wrap">
                    <img src="images/spatii/repetitii.webp"
                         srcset="images/spatii/repetitii-400.webp 400w,
                                 images/spatii/repetitii-600.webp 600w,
                                 images/spatii/repetitii.webp 640w"
                         sizes="(max-width: 640px) 90vw, 400px"
                         alt=""
                         width="640"
                         height="640"
                         loading="lazy"
                         decoding="async"
                         aria-hidden="true">
                </div>
                <h2 class="card-title">Sală Repetiții</h2>
                <span class="card-sub">Teatru &middot; Muzică &middot; Dans</span>
                <p class="card-desc">Spațiu dedicat repetițiilor pentru trupe de teatru, formații muzicale și companii de dans. Atmosferă inspirată și condiții optime de lucru.</p>
                <a href="contact.php" class="btn-gold" aria-label="Rezervă Sală Repetiții">Rezervă</a>
            </article>

        </div>
    </div>
</section>

</main>

<?php include 'includes/footer.php'; ?>
