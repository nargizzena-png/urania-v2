<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo isset($page_desc) ? htmlspecialchars($page_desc) : 'Urania Studio - Hub Cultural & Studio de Producție în Cluj-Napoca. Locații pentru evenimente, repetiții, podcast-uri și producții creative.'; ?>">
    <meta name="keywords" content="studio producție Cluj, hub cultural, spații evenimente, repetiții, podcast, închiriere sală">
    <meta name="author" content="Urania Studio">
    <meta name="robots" content="index, follow">
<?php
    require_once __DIR__ . '/config.php';
    $canon_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($canon_path === '/index.php') $canon_path = '/';
    // Pentru pagina de eveniment păstrăm parametrul ?e=slug (fiecare eveniment e o pagină separată)
    if (basename($canon_path) === 'eveniment.php' && isset($_GET['e'])) $canon_path .= '?e=' . rawurlencode((string)$_GET['e']);
    $canon_url = SITE_URL . $canon_path;
?>
    <link rel="canonical" href="<?php echo htmlspecialchars($canon_url); ?>">
<?php if (GSC_VERIFICATION !== ''): ?>
    <meta name="google-site-verification" content="<?php echo htmlspecialchars(GSC_VERIFICATION); ?>">
<?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | Urania Studio' : 'Urania Studio'; ?>">
    <meta property="og:description" content="<?php echo isset($page_desc) ? htmlspecialchars($page_desc) : 'Urania Studio - Hub Cultural & Studio de Producție în Cluj-Napoca.'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($canon_url); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars(SITE_URL); ?>/<?php echo htmlspecialchars($og_image ?? 'images/og-urania.jpg'); ?>">
    <meta property="og:locale" content="ro_RO">
    <meta property="og:site_name" content="Urania Studio">
    
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | Urania Studio' : 'Urania Studio'; ?></title>
    <link rel="icon" href="/favicon.ico?v=2" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png?v=2">
    <link rel="icon" type="image/png" sizes="512x512" href="/icon-512.png?v=2">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime(__DIR__ . '/../css/style.css'); ?>">
    <?php if (isset($preload_image)): ?>
    <link rel="preload" as="image" href="<?php echo htmlspecialchars($preload_image); ?>" type="image/webp">
    <?php endif; ?>
    <link rel="alternate" type="text/plain" href="/llms.txt" title="LLM summary">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Urania Studio",
      "description": "Hub cultural și studio de producție în Cluj-Napoca: sală de spectacole (blackbox), studio de sunet și sală de repetiții de închiriat pentru repetiții, concerte, spectacole, conferințe, workshop-uri, podcast-uri, foto și video.",
      "url": "<?php echo htmlspecialchars(SITE_URL); ?>/",
      "logo": "<?php echo htmlspecialchars(SITE_URL); ?>/icon-512.png",
      "image": "<?php echo htmlspecialchars(SITE_URL); ?>/images/og-urania.jpg",
      "telephone": "+40756861229",
      "email": "uraniastudio.eu@gmail.com",
      "address": {"@type": "PostalAddress", "streetAddress": "Strada Horea, nr. 4", "addressLocality": "Cluj-Napoca", "addressCountry": "RO"},
      "openingHours": "Mo-Su 00:00-24:00",
      "sameAs": ["https://www.facebook.com/profile.php?id=61586391453182", "https://www.instagram.com/studiourania/"]
    }
    </script>
</head>
<body>

<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<header class="header-main">
    <div class="header-container">
        <div class="logo"><a href="index.php">URANIA</a></div>

        <button class="burger-icon" id="open-menu" aria-label="Deschide meniu">
            <span></span><span></span><span></span>
        </button>

        <div class="header-right">
            <nav class="nav-wrap" id="site-nav" aria-label="Navigare principală">
                <ul class="nav-list">
                    <li><a href="spatii.php" class="<?php echo ($current_page === 'spatii.php') ? 'active' : ''; ?>">Spații</a></li>
                    <li><a href="preturi.php" class="<?php echo ($current_page === 'preturi.php') ? 'active' : ''; ?>">Prețuri</a></li>
                    <li><a href="jurnal.php" class="<?php echo ($current_page === 'jurnal.php') ? 'active' : ''; ?>">Jurnal</a></li>
                    <li><a href="contact.php" class="<?php echo ($current_page === 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
