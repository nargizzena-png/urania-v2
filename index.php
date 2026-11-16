<?php
require_once 'includes/db.php';
$upcoming = upcoming_events(3);
$next = $upcoming[0] ?? null;
$recent = past_events(3);
$page_desc = 'Urania Studio, Cluj-Napoca: sală de spectacol cu scenă, studio de sunet și sală de repetiții. Închiriere pentru concerte, teatru, conferințe, podcast și producție video.';
include 'includes/header.php';
?>

<!-- HERO: cinema viewfinder -->
<section class="cine-hero">
    <div class="cine-shade"></div>
    <div class="cine-grain"></div>

    <span class="cine-corner tl"></span><span class="cine-corner tr"></span>
    <span class="cine-corner bl"></span><span class="cine-corner br"></span>

    <div class="cine-hud tl"><small>Now playing</small><span id="cine-tc">00:00:00:00</span></div>
    <div class="cine-hud tr"><small>Format</small><span>2.39 : 1</span></div>
    <div class="cine-hud bl"><small>Location</small><span>Cluj-Napoca, RO</span></div>
    <div class="cine-hud br"><span>MCMX</span></div>

    <div class="cine-center">
        <p class="cine-kicker">Cluj-Napoca · Est. 1910</p>
        <span class="cine-rule"></span>
        <h1 class="cine-title" aria-label="Urania Studio">
            <span class="cine-letters" aria-hidden="true"><?php foreach (str_split('URANIA') as $i => $ch): ?><span style="--i:<?= $i ?>"><?= $ch ?></span><?php endforeach; ?></span>
        </h1>
        <p class="cine-sub" aria-hidden="true">Studio</p>
        <div class="cine-actions">
            <a href="spatii.php" class="cine-btn">Spațiile</a>
            <a href="preturi.php" class="cine-btn cine-btn-primary">Cere ofertă</a>
        </div>
        <?php if ($next): ?>
        <a href="eveniment.php?e=<?= e(rawurlencode($next['slug'])) ?>" class="cine-next">
            <small>Urmează</small>
            <span><?= e(event_day_label($next) . ' ' . ro_month((int)date('n', strtotime($next['starts_at'])), true)) ?> — <?= e($next['title']) ?></span>
        </a>
        <?php endif; ?>
    </div>

    <a href="#home-spaces" class="cine-scroll" aria-label="Derulează">Scroll<span></span></a>
</section>
<script>
(function(){
    var hdr=document.querySelector('.header-main'), hero=document.querySelector('.cine-hero');
    if (hdr && hero && 'IntersectionObserver' in window) {
        hdr.classList.add('logo-hidden');
        new IntersectionObserver(function(en){ hdr.classList.toggle('logo-hidden', en[0].isIntersecting); }, { rootMargin: '-90px 0px 0px 0px' }).observe(hero);
    }
})();
(function(){
    var el=document.getElementById('cine-tc'), t0=Date.now();
    function pad(n){return (n<10?'0':'')+n;}
    setInterval(function(){
        var ms=Date.now()-t0, s=Math.floor(ms/1000);
        el.textContent=pad(Math.floor(s/3600))+':'+pad(Math.floor(s/60)%60)+':'+pad(s%60)+':'+pad(Math.floor(ms/1000*24)%24);
    },42);
})();
</script>

<main id="main-content">

<!-- SPAȚII -->
<section class="home-sec band-graphite" id="home-spaces" aria-labelledby="spaces-heading">
    <div class="container">
        <div class="home-head reveal">
            <div>
                <span class="section-label">Spații</span>
                <h2 class="home-h2" id="spaces-heading">Trei săli, un singur loc</h2>
            </div>
            <a href="spatii.php" class="card-link">Toate spațiile &rarr;</a>
        </div>
        <div class="home-spaces">
            <a href="spatii.php#blackbox" class="hs-card reveal">
                <img src="images/spatii/blackbox-400.webp" alt="" width="400" height="400" loading="lazy" decoding="async">
                <div>
                    <span class="card-sub">Sala Mare cu scenă</span>
                    <h3>Blackbox</h3>
                    <p>100 de scaune · spectacole, concerte, conferințe</p>
                </div>
            </a>
            <a href="spatii.php#podcast" class="hs-card reveal reveal-delay-1">
                <img src="images/spatii/podcast-400.webp" alt="" width="400" height="400" loading="lazy" decoding="async">
                <div>
                    <span class="card-sub">Înregistrare audio</span>
                    <h3>Studio de sunet</h3>
                    <p>Podcast, interviuri, voce, foto și video</p>
                </div>
            </a>
            <a href="spatii.php#repetitii" class="hs-card reveal reveal-delay-2">
                <img src="images/spatii/repetitii-400.webp" alt="" width="400" height="400" loading="lazy" decoding="async">
                <div>
                    <span class="card-sub">Studio de înregistrări</span>
                    <h3>Repetiții</h3>
                    <p>Sală de instrumente și cabină acustică</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- EVENIMENTE: calendar + arhivă -->
<section class="home-sec" aria-labelledby="events-heading">
    <div class="container">
        <div class="home-head reveal">
            <div>
                <span class="section-label">Jurnal</span>
                <h2 class="home-h2" id="events-heading">Pe scena Urania</h2>
            </div>
            <a href="jurnal.php" class="card-link">Tot calendarul &rarr;</a>
        </div>
        <div class="home-cal">
            <div class="home-cal-col">
                <h3 class="ev-block-title"><span>Urmează</span></h3>
                <?php if ($upcoming): ?>
                <div class="home-events">
                    <?php foreach ($upcoming as $i => $ev): $t = strtotime($ev['starts_at']); ?>
                    <a href="eveniment.php?e=<?= e(rawurlencode($ev['slug'])) ?>" class="he-item reveal<?= $i ? ' reveal-delay-' . $i : '' ?>">
                        <span class="he-date"><strong><?= e(event_day_label($ev)) ?></strong><?= ro_month((int)date('n', $t), true) ?></span>
                        <span class="he-info">
                            <span class="card-sub"><?= e(implode(' · ', array_filter([$ev['category'], $ev['venue']]))) ?></span>
                            <span class="he-title"><?= e($ev['title']) ?></span>
                        </span>
                        <span class="he-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="home-cal-empty reveal">
                    <p>Programul următoarelor evenimente va fi anunțat în curând.</p>
                    <a href="preturi.php" class="card-link">Organizează un eveniment la Urania &rarr;</a>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($recent): ?>
            <div class="home-cal-col">
                <h3 class="ev-block-title"><span>Din arhivă</span></h3>
                <div class="home-archive">
                    <?php foreach ($recent as $i => $ev): ?>
                    <a href="eveniment.php?e=<?= e(rawurlencode($ev['slug'])) ?>" class="ha-item reveal<?= $i ? ' reveal-delay-' . $i : '' ?>">
                        <?php if ($ev['cover']): ?><img src="<?= e(photo_url($ev['cover'], true)) ?>" alt="" loading="lazy" decoding="async"><?php endif; ?>
                        <span class="ha-cap"><small><?= e(event_day_label($ev) . ' ' . ro_month((int)date('n', strtotime($ev['starts_at'])), true)) ?></small><?= e($ev['title']) ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- PREȚURI -->
<section class="home-sec band-graphite" aria-labelledby="prices-heading">
    <div class="container">
        <div class="home-head reveal">
            <div>
                <span class="section-label">Prețuri</span>
                <h2 class="home-h2" id="prices-heading">Transparent, de la început</h2>
            </div>
            <a href="preturi.php" class="card-link">Toate prețurile &rarr;</a>
        </div>
        <ul class="home-prices reveal">
            <li><span>Repetiții pe scenă</span><strong><small>de la</small> 120 <em>lei/oră · minim 2 ore</em></strong></li>
            <li><span>Podcast, foto &amp; video</span><strong><small>de la</small> 120 <em>lei/oră · minim 2 ore</em></strong></li>
            <li><span>Conferințe &amp; workshopuri</span><strong><small>de la</small> 800 <em>lei · 3–4 ore</em></strong></li>
            <li><span>Spectacole &amp; concerte</span><strong><small>de la</small> 1.800 <em>lei · 4–6 ore</em></strong></li>
        </ul>
        <p class="home-valid reveal">Prețuri valabile până la 31.12.2026</p>
    </div>
</section>

<!-- CTA FINAL -->
<section class="home-cta" aria-labelledby="cta-heading">
    <span class="cine-corner tl"></span><span class="cine-corner tr"></span>
    <span class="cine-corner bl"></span><span class="cine-corner br"></span>
    <div class="container reveal">
        <span class="section-label">Ai un proiect?</span>
        <h2 class="home-h2" id="cta-heading">Hai să-l punem în scenă</h2>
        <p class="home-text">Spune-ne data și formatul — îți trimitem o ofertă personalizată.</p>
        <div class="home-cta-actions">
            <a href="preturi.php#cerere" class="cine-btn cine-btn-primary">Cere ofertă</a>
            <a href="https://wa.me/40756861229" class="cine-btn" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp</a>
            <a href="tel:+40756861229" class="cine-btn"><i class="fas fa-phone-alt" aria-hidden="true"></i> +40 756 861 229</a>
        </div>
    </div>
</section>

</main>

<?php include 'includes/footer.php'; ?>
