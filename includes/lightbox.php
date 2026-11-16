<!-- Lightbox -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Galerie foto" hidden>
    <button class="lb-close" aria-label="Închide">&times;</button>
    <button class="lb-prev" aria-label="Poza anterioară">&#8249;</button>
    <img alt="">
    <button class="lb-next" aria-label="Poza următoare">&#8250;</button>
    <span class="lb-count"></span>
</div>
<script>
(function () {
    var items = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
    if (!items.length) return;
    var lb = document.getElementById('lightbox'), img = lb.querySelector('img'), cnt = lb.querySelector('.lb-count'), cur = 0, startX = null;
    function show(i) { cur = (i + items.length) % items.length; img.src = items[cur].href; img.alt = items[cur].querySelector('img').alt; cnt.textContent = (cur + 1) + ' / ' + items.length; }
    function open(i) { show(i); lb.hidden = false; document.body.classList.add('no-scroll'); lb.querySelector('.lb-close').focus(); }
    function close() { lb.hidden = true; document.body.classList.remove('no-scroll'); items[cur].focus(); }
    items.forEach(function (a, i) { a.addEventListener('click', function (e) { e.preventDefault(); open(i); }); });
    lb.querySelector('.lb-close').onclick = close;
    lb.querySelector('.lb-prev').onclick = function () { show(cur - 1); };
    lb.querySelector('.lb-next').onclick = function () { show(cur + 1); };
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
        if (lb.hidden) return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') show(cur - 1);
        if (e.key === 'ArrowRight') show(cur + 1);
    });
    lb.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    lb.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 50) show(cur + (dx < 0 ? 1 : -1));
        startX = null;
    });
})();
</script>
