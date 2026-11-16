<?php
/**
 * Baza de date pentru Jurnal (evenimente) — SQLite, fără server de baze de date.
 * Fișierul bazei stă în /data (acces web blocat prin .htaccess).
 */

const URANIA_DATA_DIR   = __DIR__ . '/../data';
const URANIA_UPLOAD_DIR = __DIR__ . '/../uploads/events';
const URANIA_UPLOAD_URL = 'uploads/events';

function db(): PDO
{
    static $pdo = null;
    if ($pdo) return $pdo;

    if (!is_dir(URANIA_DATA_DIR)) {
        mkdir(URANIA_DATA_DIR, 0755, true);
    }
    $pdo = new PDO('sqlite:' . URANIA_DATA_DIR . '/urania.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');

    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        pass_hash TEXT NOT NULL,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )');
    $pdo->exec('CREATE TABLE IF NOT EXISTS events (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        starts_at TEXT NOT NULL,          -- YYYY-MM-DD HH:MM
        venue TEXT NOT NULL DEFAULT "",
        category TEXT NOT NULL DEFAULT "",
        excerpt TEXT NOT NULL DEFAULT "",
        body TEXT NOT NULL DEFAULT "",
        ticket_url TEXT NOT NULL DEFAULT "",
        cover TEXT NOT NULL DEFAULT "",
        published INTEGER NOT NULL DEFAULT 1,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )');
    $pdo->exec('CREATE TABLE IF NOT EXISTS event_photos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        event_id INTEGER NOT NULL REFERENCES events(id) ON DELETE CASCADE,
        file TEXT NOT NULL,
        sort INTEGER NOT NULL DEFAULT 0
    )');
    // Migrare: dată de sfârșit pentru evenimente pe mai multe zile
    $cols = array_column($pdo->query('PRAGMA table_info(events)')->fetchAll(), 'name');
    if (!in_array('ends_on', $cols, true)) {
        $pdo->exec('ALTER TABLE events ADD COLUMN ends_on TEXT NOT NULL DEFAULT ""');
    }
    if (!in_array('video', $cols, true)) {
        $pdo->exec('ALTER TABLE events ADD COLUMN video TEXT NOT NULL DEFAULT ""');
    }
    return $pdo;
}

function e(?string $s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

const URANIA_VENUES = ['Sala Mare', 'Studio de sunet', 'Sala de repetiții', 'Foaier'];
const URANIA_CATEGORIES = ['Concert', 'Teatru', 'Film', 'Dans', 'Conferință', 'Lansare de carte', 'Proiecție & expoziție', 'Workshop', 'Expoziție', 'Podcast', 'Eveniment'];

function ro_month(int $m, bool $short = false): string
{
    $full = ['', 'ianuarie', 'februarie', 'martie', 'aprilie', 'mai', 'iunie', 'iulie', 'august', 'septembrie', 'octombrie', 'noiembrie', 'decembrie'];
    $abbr = ['', 'ian', 'feb', 'mar', 'apr', 'mai', 'iun', 'iul', 'aug', 'sep', 'oct', 'noi', 'dec'];
    return $short ? $abbr[$m] : $full[$m];
}

function ro_weekday(int $w): string
{
    return ['duminică', 'luni', 'marți', 'miercuri', 'joi', 'vineri', 'sâmbătă'][$w];
}

/** "vineri, 14 noiembrie 2026 · 19:00" sau "24–25 octombrie 2026 · 19:00" */
function event_date_long(string $startsAt, string $endsOn = ''): string
{
    $t = strtotime($startsAt);
    $time = date('H:i', $t);
    $timeOut = $time !== '00:00' ? ' · ' . $time : '';
    $e = $endsOn !== '' ? strtotime($endsOn) : 0;
    if ($e && date('Y-m-d', $e) > date('Y-m-d', $t)) {
        if (date('Y-m', $e) === date('Y-m', $t)) {
            $out = date('j', $t) . '–' . date('j', $e) . ' ' . ro_month((int)date('n', $t)) . ' ' . date('Y', $t);
        } else {
            $out = date('j', $t) . ' ' . ro_month((int)date('n', $t)) . ' – ' . date('j', $e) . ' ' . ro_month((int)date('n', $e)) . ' ' . date('Y', $e);
        }
        return $out . $timeOut;
    }
    return ro_weekday((int)date('w', $t)) . ', ' . date('j', $t) . ' ' . ro_month((int)date('n', $t)) . ' ' . date('Y', $t) . $timeOut;
}

/** Ziua pentru plăcuța de dată: "14" sau "24–25" */
function event_day_label(array $ev): string
{
    $t = strtotime($ev['starts_at']);
    $e = ($ev['ends_on'] ?? '') !== '' ? strtotime($ev['ends_on']) : 0;
    if ($e && date('Y-m', $e) === date('Y-m', $t) && date('j', $e) !== date('j', $t)) return date('j', $t) . '–' . date('j', $e);
    return date('j', $t);
}

/** Data după care evenimentul trece în arhivă */
const EVENT_LAST_DAY_SQL = "date(CASE WHEN ends_on != '' THEN ends_on ELSE starts_at END)";

function slugify(string $s): string
{
    $map = ['ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ş' => 's', 'ț' => 't', 'ţ' => 't',
            'Ă' => 'a', 'Â' => 'a', 'Î' => 'i', 'Ș' => 's', 'Ş' => 's', 'Ț' => 't', 'Ţ' => 't'];
    $s = strtr($s, $map);
    $s = strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $s));
    $s = trim($s, '-');
    return $s !== '' ? substr($s, 0, 80) : 'eveniment';
}

function unique_slug(string $title, int $ignoreId = 0): string
{
    $base = slugify($title);
    $slug = $base;
    $i = 2;
    $st = db()->prepare('SELECT COUNT(*) FROM events WHERE slug = ? AND id != ?');
    while (true) {
        $st->execute([$slug, $ignoreId]);
        if (!$st->fetchColumn()) return $slug;
        $slug = $base . '-' . $i++;
    }
}

function event_photos(int $eventId): array
{
    $st = db()->prepare('SELECT * FROM event_photos WHERE event_id = ? ORDER BY sort, id');
    $st->execute([$eventId]);
    return $st->fetchAll();
}

/** Urmează: evenimente de azi încolo. */
function upcoming_events(int $limit = 50): array
{
    $st = db()->prepare("SELECT * FROM events WHERE published = 1 AND " . EVENT_LAST_DAY_SQL . " >= date('now','localtime') ORDER BY starts_at ASC LIMIT ?");
    $st->execute([$limit]);
    return $st->fetchAll();
}

/** Arhivă: evenimente trecute, cele mai noi primele. */
function past_events(int $limit, int $offset = 0): array
{
    $st = db()->prepare("SELECT * FROM events WHERE published = 1 AND " . EVENT_LAST_DAY_SQL . " < date('now','localtime') ORDER BY starts_at DESC LIMIT ? OFFSET ?");
    $st->execute([$limit, $offset]);
    return $st->fetchAll();
}

function past_events_count(): int
{
    return (int)db()->query("SELECT COUNT(*) FROM events WHERE published = 1 AND " . EVENT_LAST_DAY_SQL . " < date('now','localtime')")->fetchColumn();
}

/** Linkul din „ticket_url” poate fi o pagină de bilete sau un eveniment Facebook. */
function is_facebook_link(string $url): bool
{
    $host = strtolower((string)parse_url($url, PHP_URL_HOST));
    return $host === 'facebook.com' || str_ends_with($host, '.facebook.com') || $host === 'fb.me';
}

function ticket_label(string $url, bool $short = false): string
{
    if (is_facebook_link($url)) return $short ? 'Facebook' : 'Confirmă pe Facebook';
    return $short ? 'Bilete' : 'Bilete / înscriere';
}

function photo_url(string $file, bool $thumb = false): string
{
    return URANIA_UPLOAD_URL . '/' . ($thumb ? 'thumb-' : '') . rawurlencode($file);
}

/**
 * Salvează o imagine încărcată: verifică tipul real, o redimensionează și o convertește în WebP.
 * Creează și o miniatură. Întoarce numele fișierului sau aruncă excepție.
 */
function save_uploaded_image(array $f): string
{
    if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $msg = [UPLOAD_ERR_INI_SIZE => 'Fișierul este prea mare.', UPLOAD_ERR_FORM_SIZE => 'Fișierul este prea mare.', UPLOAD_ERR_PARTIAL => 'Încărcare incompletă.'];
        throw new RuntimeException($msg[$f['error']] ?? 'Eroare la încărcare.');
    }
    if ($f['size'] > 25 * 1024 * 1024) {
        throw new RuntimeException('Imaginea depășește 25 MB.');
    }
    $info = @getimagesize($f['tmp_name']);
    $types = [IMAGETYPE_JPEG => 'jpeg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    if (!$info || !isset($types[$info[2]])) {
        throw new RuntimeException('Sunt acceptate doar imagini JPG, PNG sau WebP.');
    }
    $src = match ($types[$info[2]]) {
        'jpeg' => @imagecreatefromjpeg($f['tmp_name']),
        'png'  => @imagecreatefrompng($f['tmp_name']),
        'webp' => @imagecreatefromwebp($f['tmp_name']),
    };
    if (!$src) throw new RuntimeException('Imaginea nu poate fi citită.');

    // Rotire corectă pentru poze de pe telefon
    if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $exif = @exif_read_data($f['tmp_name']);
        $o = $exif['Orientation'] ?? 1;
        if ($o == 3) $src = imagerotate($src, 180, 0);
        elseif ($o == 6) $src = imagerotate($src, -90, 0);
        elseif ($o == 8) $src = imagerotate($src, 90, 0);
    }

    if (!is_dir(URANIA_UPLOAD_DIR)) mkdir(URANIA_UPLOAD_DIR, 0755, true);
    $name = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.webp';

    // Reguli de greutate: max 1600px (vizualizare mare), 700px (carduri); WebP calitate 78
    foreach ([['', 1600], ['thumb-', 700]] as [$prefix, $max]) {
        $w = imagesx($src); $h = imagesy($src);
        $scale = min(1, $max / max($w, $h));
        $nw = (int)round($w * $scale); $nh = (int)round($h * $scale);
        $dst = imagecreatetruecolor($nw, $nh);
        imagealphablending($dst, false); imagesavealpha($dst, true);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagewebp($dst, URANIA_UPLOAD_DIR . '/' . $prefix . $name, 78);
    }
    return $name;
}

function delete_image_files(string $file): void
{
    if ($file === '' || basename($file) !== $file) return;
    @unlink(URANIA_UPLOAD_DIR . '/' . $file);
    @unlink(URANIA_UPLOAD_DIR . '/thumb-' . $file);
}
