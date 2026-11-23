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

            <article class="space-card reveal" id="blackbox" role="listitem" tabindex="0" data-href="#fisa-sala-mare">
                <div class="card-img-wrap">
                    <img src="images/spatii/blackbox.webp" 
                         srcset="images/spatii/blackbox-400.webp 400w,
                                 images/spatii/blackbox-600.webp 600w,
                                 images/spatii/blackbox.webp 640w"
                         sizes="(max-width: 640px) 90vw, 400px"
                         alt="Sala Mare cu scenă (Blackbox) — Urania Studio, Cluj"
                         width="640"
                         height="640"
                         decoding="async"
                         aria-hidden="true">
                </div>
                <h2 class="card-title">Blackbox</h2>
                <span class="card-sub">Sala Mare cu scenă</span>
                <p class="card-desc">Spațiu flexibil și multifuncțional pentru spectacole, prezentări, proiecții și evenimente de amploare. Echipat cu sistem de sunet și lumini profesionale.</p>
                <a href="#fisa-sala-mare" class="card-link">Fișa tehnică &amp; video 3D &rarr;</a>
                <a href="contact.php" class="btn-gold" aria-label="Rezervă Blackbox">Rezervă</a>
            </article>

            <article class="space-card reveal reveal-delay-1" id="podcast" role="listitem" tabindex="0" data-href="#fisa-studio">
                <div class="card-img-wrap">
                    <img src="images/spatii/podcast.webp"
                         srcset="images/spatii/podcast-400.webp 400w,
                                 images/spatii/podcast-600.webp 600w,
                                 images/spatii/podcast.webp 640w"
                         sizes="(max-width: 640px) 90vw, 400px"
                         alt="Studio de sunet pentru podcast — Urania Studio, Cluj"
                         width="640"
                         height="640"
                         loading="lazy"
                         decoding="async"
                         aria-hidden="true">
                </div>
                <h2 class="card-title">Studio de sunet</h2>
                <span class="card-sub">Înregistrare Audio</span>
                <p class="card-desc">Podcast în atmosfera Black Box: la masă sau pe canapele, cu unul sau până la șase invitați. Microfoane, lavaliere și lumini profesionale.</p>
                <a href="contact.php" class="btn-gold" aria-label="Rezervă Studio de sunet">Rezervă</a>
            </article>

            <article class="space-card reveal reveal-delay-2" id="repetitii" role="listitem" tabindex="0" data-href="#fisa-repetitii">
                <div class="card-img-wrap">
                    <img src="images/spatii/repetitii.webp"
                         srcset="images/spatii/repetitii-400.webp 400w,
                                 images/spatii/repetitii-600.webp 600w,
                                 images/spatii/repetitii.webp 640w"
                         sizes="(max-width: 640px) 90vw, 400px"
                         alt="Sala de repetiții cu instrumente — Urania Studio, Cluj"
                         width="640"
                         height="640"
                         loading="lazy"
                         decoding="async"
                         aria-hidden="true">
                </div>
                <h2 class="card-title">Sală Repetiții</h2>
                <span class="card-sub">Studio de înregistrări</span>
                <p class="card-desc">Sală versatilă, într-o zonă în care sunetul nu deranjează vecinii. Amenajată ca studio de înregistrări, cu sală de instrumente și cabină acustică.</p>
                <a href="contact.php" class="btn-gold" aria-label="Rezervă Sală Repetiții">Rezervă</a>
            </article>

        </div>

    <!-- Fotografii Sala Mare -->
    <section class="space-photos" aria-label="Fotografii Sala Mare">
        <a href="images/spatii/sala-mare-lumini.webp" class="sp-photo sp-photo-main" data-lightbox>
            <img src="images/spatii/sala-mare-lumini-800.webp" srcset="images/spatii/sala-mare-lumini-800.webp 800w, images/spatii/sala-mare-lumini.webp 1800w" sizes="(max-width: 900px) 100vw, 66vw" alt="Sala Mare cu scena luminată în roșu și albastru — Urania Studio, Cluj" width="1800" height="1200" loading="lazy" decoding="async">
        </a>
        <a href="images/spatii/sala-mare-albastru.webp" class="sp-photo" data-lightbox>
            <img src="images/spatii/sala-mare-albastru-800.webp" srcset="images/spatii/sala-mare-albastru-800.webp 800w, images/spatii/sala-mare-albastru.webp 1800w" sizes="(max-width: 900px) 100vw, 33vw" alt="Sala Mare goală, cu glob disco și panouri acustice — Urania Studio, Cluj" width="1800" height="1200" loading="lazy" decoding="async">
        </a>
    </section>

    <!-- Fișa tehnică: Sala Mare -->
    <section class="fisa" id="fisa-sala-mare">
        <div class="fisa-media">
            <span class="cine-corner tl"></span><span class="cine-corner tr"></span>
            <span class="cine-corner bl"></span><span class="cine-corner br"></span>
            <video id="fisa-video" src="video/sala-mare.mp4#t=3" preload="metadata" playsinline></video>
            <button class="fisa-play" id="fisa-play" aria-label="Pornește video">
                <span class="fisa-play-icon"></span>
                <span class="fisa-play-label">Vizualizare 3D cu dimensiuni</span>
            </button>
        </div>
        <div class="fisa-info">
            <small class="fisa-kicker">Fișa tehnică</small>
            <h2>Sala Mare cu scenă</h2>
            <p>Scenă completă și sală de 100 de scaune — pentru spectacole, concerte, conferințe și repetiții pe scena reală.</p>
            <ul class="fisa-stats">
                <li><strong>100</strong><span>scaune în sală</span></li>
                <li><strong>7.20 × 3.00 × 5.40 m</strong><span>scenă (L × h × A)</span></li>
                <li><strong>11.00 × 8.30 × 5.00 m</strong><span>sala mare (L × l × h)</span></li>
                <li><strong>Standard</strong><span>lumini &amp; sunet</span></li>
            </ul>
            <a href="contact.php" class="btn-gold">Cere ofertă</a>
        </div>
    </section>

    <!-- Fișa tehnică: Studio de sunet / podcast -->
    <section class="fisa fisa-reverse" id="fisa-studio">
        <div class="fisa-media">
            <span class="cine-corner tl"></span><span class="cine-corner tr"></span>
            <span class="cine-corner bl"></span><span class="cine-corner br"></span>
            <img src="images/spatii/podcast.webp" alt="Studio de sunet pentru podcast, cu microfoane și lumini — Urania Studio, Cluj" width="640" height="640" loading="lazy" decoding="async" class="fisa-img">
        </div>
        <div class="fisa-info">
            <small class="fisa-kicker">Fișa tehnică</small>
            <h2>Studio de sunet</h2>
            <p>Podcastul se înregistrează în spațiul Black Box sau în Studio de sunet — la masă sau pe canapele. Atmosfera este versatilă: fiecare emisiune își găsește propriul decor.</p>
            <ul class="fisa-stats">
                <li><strong>Black Box (Sala Mare) · Studio de sunet</strong><span>locație</span></li>
                <li><strong>1–6 persoane</strong><span>invitați</span></li>
                <li><strong>Masă sau canapele</strong><span>amenajare</span></li>
                <li><strong>Microfoane, lavaliere, lumini profesionale</strong><span>echipament</span></li>
            </ul>
            <a href="preturi.php#cerere" class="btn-gold">Cere ofertă</a>
        </div>
    </section>

    <!-- Fișa tehnică: Sala de repetiții -->
    <section class="fisa" id="fisa-repetitii">
        <div class="fisa-media">
            <span class="cine-corner tl"></span><span class="cine-corner tr"></span>
            <span class="cine-corner bl"></span><span class="cine-corner br"></span>
            <img src="images/spatii/repetitii.webp" alt="Sala de repetiții, studio de înregistrări la subsol — Urania Studio, Cluj" width="640" height="640" loading="lazy" decoding="async" class="fisa-img">
        </div>
        <div class="fisa-info">
            <small class="fisa-kicker">Fișa tehnică</small>
            <h2>Sala de repetiții</h2>
            <p>O sală versatilă, situată într-o zonă în care sunetul nu deranjează vecinii. Este amenajată ca studio de înregistrări, cu sală de instrumente și cabină acustică pentru înregistrare.</p>
            <ul class="fisa-stats">
                <li><strong>Studioul acustic de la subsol · sunetul nu deranjează vecinii</strong><span>locație</span></li>
                <li><strong>Studio de înregistrări</strong><span>amenajare</span></li>
                <li><strong>Sală de instrumente</strong><span>instrumente</span></li>
                <li><strong>Cabină acustică</strong><span>înregistrare</span></li>
            </ul>
            <a href="preturi.php#cerere" class="btn-gold">Cere ofertă</a>
        </div>
    </section>
    </div>
</section>

</main>

<script>
(function(){
    var v=document.getElementById('fisa-video'), b=document.getElementById('fisa-play');
    b.addEventListener('click',function(){
        v.currentTime=0; v.controls=true; v.play(); b.classList.add('hidden');
        if (window.innerWidth<=768 && v.requestFullscreen) v.requestFullscreen().catch(function(){});
    });
    v.addEventListener('ended',function(){ v.controls=false; b.classList.remove('hidden'); });
})();
</script>

<script>
// Tot cardul este clicabil (în afară de butoanele și linkurile din el)
// Dacă fișa nu există încă pe pagină (ex. #fisa-studio), cardul nu face nimic până o adăugăm
document.querySelectorAll('.space-card[data-href]').forEach(function (card) {
    var h = card.dataset.href;
    if (h.charAt(0) === '#' && !document.querySelector(h)) return;
    function go() { location.href = h; }
    card.style.cursor = 'pointer';
    card.addEventListener('click', function (e) { if (!e.target.closest('a, button')) go(); });
    card.addEventListener('keydown', function (e) { if (e.key === 'Enter' && e.target === card) go(); });
});
</script>

<?php include 'includes/lightbox.php'; ?>

<?php include 'includes/footer.php'; ?>
