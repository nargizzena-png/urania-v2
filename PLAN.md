# Urania Studio — ce a rămas de făcut

_Actualizat: 10 noiembrie 2026 (v2). Lucrul se face în `Urania-v2`, branch `redesign-2026`, localhost:8006. Nimic nu este încă salvat în git (commit) și nimic nu este publicat._

---

## 1. De aprobat cu șeful

> **Răspuns primit (10.11):** repetiții rămân „de la 120”; minimul de ore stă lângă preț; prețuri valabile până la 31.12.2026; fără TVA; fără promisiunea de 24 de ore la ofertă; contract „de servicii pentru sesiune de lucru”; garanția se plătește înainte și se returnează după eveniment; restul de plată în 3 zile lucrătoare după eveniment; biletele și alte încasări — responsabilitatea organizatorului; scoase: excepțiile la program, regula despre alcool, secțiunea „Despre noi”. Toate aplicate pe site.
 (texte și condiții scrise de mine, nu din documentul de prețuri)

### Prețuri (`preturi.php`)
- [ ] „Ce este inclus” — formulări adăugate de mine:
  - Repetiții: „Lumini de lucru și acces la sunet”
  - Conferințe: „Sunet și proiecție de bază”, „Aranjarea sălii după format”
  - Spectacole: „Repetiție tehnică — la cerere”
  - Podcast: „Studio tratat acustic” (luat de pe site-ul vechi)
- [ ] **Repetiții „de la 120”**, dar subtitlul spune „Teatru · Dans · Trupe” — în document teatru/dans încep de la **100** lei/oră
- [ ] **Podcast, foto & video „de la 120”** — foto/video costă de fapt 200 lei/oră, minim 2 ore
- [ ] Promisiunea „oferta în maxim 24 de ore” (pe Contact scrie doar „răspundem în 24 de ore”)
- [ ] „Weekendul are tarife diferite” — păstrăm sau scoatem?
- [ ] „Garanția se returnează **integral**” — în document doar „se returnează”

### Termeni și condiții (`termeni.php`) — propuneri ale mele
- [ ] Anulare: >30 zile avansul se returnează; 30–14 zile se reține 50%; <14 zile nu se returnează
- [ ] Reprogramare: o dată, gratuit, cu min. 14 zile înainte, în max. 6 luni
- [ ] Restul plății: cu min. 3 zile lucrătoare înainte, prin transfer bancar
- [ ] Oferta valabilă 7 zile; garanția returnată în 7 zile lucrătoare
- [ ] Alcool „doar în condițiile din contract”; servicii doar pentru 18+
- [ ] Răspuns la reclamații în 15 zile lucrătoare
- [ ] Păstrarea datelor: corespondența fără rezervare max. 24 luni (Politica de confidențialitate)

### Texte pe pagina principală
- [x] Secțiunea „Despre noi” scoasă (decizia șefului)

### Verificare juridică
- [ ] Un avocat / contabil verifică Termeni, Politica de confidențialitate și contractul de închiriere

---

## 2. Informații de primit

- [x] **Straniu** (Abel Barabaș, 21.11) — adăugat în Jurnal cu afiș și video
- [ ] **TVA:** PIXEL STUDIOS TRANSILVANIA SRL este plătitoare? (mențiunea „+TVA” / „TVA inclus” la prețuri)
- [ ] **ID Google Analytics 4** (format `G-XXXXXXXXXX`)
- [ ] **Fișa tehnică Sala Mare:** dimensiunile scenei, înălțimea, lumini și sunet, electricitate, cabine, acces decor
- [ ] **Fișa tehnică Studio de sunet:** suprafață, microfoane, interfață, camere/lumini
- [x] Fotografii reale ale **Sălii Mari** (color + albastru) — puse pe pagina Spații
- [ ] **Fotografii Studio de sunet** (camera de podcast) — încă nu există, de făcut
- [ ] Fotografii de la **Motel Amour** (afișul există)
- [ ] Ora de început la lansarea **Patricia Brad**

---

## 2b. Colectarea recenziilor (de pornit acum)
- [ ] De discutat cu șeful cine se ocupă
- [ ] După fiecare eveniment / închiriere: mesaj scurt către organizator cu link de recenzie (Google Business + Facebook)
- [ ] Șablon de mesaj (RO) pentru cererea de recenzie
- [ ] Cerem acordul de a publica numele / citatul pe site
- [ ] Pe site: secțiunea „Ce spun cei care au jucat la Urania” apare când avem cel puțin 3 recenzii

## 3. Google Analytics
- [x] Bannerul de cookies și încărcarea GA4 doar după acord — gata
- [ ] Creezi proprietatea GA4 și îmi trimiți ID-ul → îl pun în `includes/config.php`
- [ ] Evenimente de conversie: trimitere formular ofertă, click WhatsApp, click telefon
- [ ] Google Search Console (verificarea domeniului după mutare)

## 4. Vizibilitate în căutarea AI (ChatGPT, Perplexity, Gemini, Google AI Overviews)
- [ ] Date structurate Schema.org pe tot site-ul: `Organization` + `LocalBusiness / PerformingArtsTheater` (nume, adresă, telefon, program, coordonate, `sameAs` Facebook/Instagram)
- [ ] `robots.txt` care permite crawlerele AI (GPTBot, ClaudeBot, PerplexityBot, Google-Extended)
- [ ] `llms.txt` — rezumat clar al site-ului pentru modelele AI
- [ ] Secțiune FAQ (întrebări frecvente) cu marcaj `FAQPage`: capacitate, prețuri, parcare, acces, cum rezervi
- [ ] Date identice peste tot (nume, adresă, telefon): site, Google Business, Facebook, Instagram
- [ ] Profil **Google Business** (Google Maps) actualizat, cu poze și recenzii

## 5. SEO
- [ ] `sitemap.xml` (cu evenimentele din Jurnal generate automat)
- [ ] Titluri și descrieri unice pe fiecare pagină (Spații încă nu are)
- [ ] Domeniul canonic corect (în cod apare de rezervă greșit `uraniasstudio.ro`)
- [ ] Texte `alt` la toate imaginile
- [ ] Redirect HTTPS în `.htaccess` (lipsește din versiunea nouă)
- [ ] Redirecturi 301 de la paginile vechi (servicii → prețuri — făcut; restul după mutare)
- [ ] Viteză: fonturi găzduite local, Font Awesome înlocuit cu SVG, test PageSpeed după publicare
- [ ] SEO local: „sală de închiriat Cluj”, „sală repetiții Cluj”, „studio podcast Cluj” în titluri și texte

## 5b. FAQ și marketing
- [ ] **FAQ (întrebări frecvente)** — cu întrebări din Termeni și condiții; materialul vine de la tine. Cu marcaj `FAQPage` pentru Google și AI
- [x] Două căsuțe în formulare: (1) obligatorie — politica de confidențialitate; (2) opțională, nebifată — noutăți și oferte pe email
- [ ] Unde păstrăm lista celor care au bifat marketing (ex. Brevo / Mailchimp) + link de dezabonare în fiecare email

## 6. Design — de terminat
- [ ] Link Instagram (`studiourania`) în subsol și în datele structurate
- [ ] Butonul „Cere ofertă” în meniu
- [ ] Un singur formular comun (Contact + Prețuri)
- [ ] Spații: titlu de pagină vizibil, carduri mai compacte, capacitate și preț „de la”
- [ ] Mai puține efecte pe cardurile vechi (glow pulsant, titluri care cresc la hover)
- [ ] Culori și etichete unificate în tot CSS-ul
- [ ] Favicon
- [ ] Pagina Contact — aliniată la noul stil

## 7. Înainte de lansare
- [ ] Commit în git (branch `redesign-2026`)
- [ ] Noul hosting: PHP 8 cu SQLite și GD/WebP, Apache (pentru `.htaccess`)
- [ ] Trimiterea emailurilor din formular: testată pe server; recomandat SMTP (Gmail / Brevo) în loc de `mail()`
- [ ] Backup regulat pentru `data/` și `uploads/events/`
- [ ] Ștergerea paginilor vechi nefolosite (`servicii.php`, imaginile `images/servicii/`) și a `router.php` (doar pentru local)
- [ ] Test final pe telefon și calculator

## Backlog — Admin (amânat, nu lucrăm acum)
_Admin-ul este dezactivat pe server din 17.11.2026: folderul a fost mutat în afara site-ului, în `/srv/sites/uraniastudio/uraniastudio/admin-disabled`. Evenimentele din Jurnal rămân vizibile._
- [ ] La publicare: **nu urca folderul `admin/`** pe server până nu reactivăm admin-ul
- [ ] Reactivare: mutăm folderul înapoi în `public_html/admin` și creăm imediat primul cont în `/admin/setup.php` (până atunci oricine ar putea crea contul)
- [ ] Până atunci, evenimente noi în Jurnal se adaugă doar manual, de către developer
- [ ] Protecție suplimentară pentru `/admin` (acces limitat, parolă puternică, 2FA) — de decis la reactivare

---

## Reguli permanente
- **Evenimente:** după ce trece data unui eveniment viitor (sau ultima zi, la evenimentele pe mai multe zile), acesta trece automat din „Urmează” în „Din arhivă” — în Jurnal, pe pagina principală și în admin. Nu trebuie mutat manual.
- [ ] De verificat după 21.11.2026: „Straniu” apare în arhivă
- **Imagini:** WebP, max. 1600px pentru vizualizare, 700–800px pentru carduri, `loading="lazy"`; niciodată originalele grele.
