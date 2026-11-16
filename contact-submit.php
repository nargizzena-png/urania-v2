<?php
/**
 * Contact Form Handler - Urania Studio
 * Processes contact form submissions with validation and security
 */

// Set response headers
header('Content-Type: application/json');

// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Configuration
$recipient_email = 'uraniastudio.eu@gmail.com';
$subject_prefix = '[Urania Studio Contact]';
$honeypot_field = 'website'; // Anti-spam honeypot field name

// Initialize response
$response = ['success' => false, 'message' => ''];

// CSRF Token validation (if you implement CSRF tokens)
// Uncomment if you add CSRF tokens to your form
/*
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $response['message'] = 'Sesiunea a expirat. Te rugăm să reîncarci pagina.';
    echo json_encode($response);
    exit;
}
*/

// Honeypot check (anti-spam)
if (!empty($_POST[$honeypot_field])) {
    // Silently reject - looks like bot
    $response['success'] = true; // Fake success to avoid revealing it's a honeypot
    echo json_encode($response);
    exit;
}

// Sanitize and validate input
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$subject_type = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$consent = isset($_POST['consent']) ? true : false;
$marketing = !empty($_POST['marketing']);
$event_date = isset($_POST['event_date']) ? trim($_POST['event_date']) : '';
$guests = isset($_POST['guests']) ? trim($_POST['guests']) : '';
$source = (isset($_POST['source']) && $_POST['source'] === 'preturi') ? 'Pagina Prețuri' : 'Pagina Contact';
if ($event_date !== '') {
    // format românesc zz.ll.aaaa
    if (!preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $event_date, $dm) || !checkdate((int)$dm[2], (int)$dm[1], (int)$dm[3])) {
        $errors_date = 'Data dorită nu este validă (format zz.ll.aaaa).';
        $event_date = '';
    }
}
if ($guests !== '' && !ctype_digit($guests)) { $guests = ''; }

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Numele este obligatoriu.';
} elseif (strlen($name) < 2 || strlen($name) > 100) {
    $errors[] = 'Numele trebuie să aibă între 2 și 100 caractere.';
} elseif (!preg_match('/^[\p{L}\s\-]+$/u', $name)) {
    $errors[] = 'Numele conține caractere invalide.';
}

if (empty($email)) {
    $errors[] = 'Email-ul este obligatoriu.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Adresa de email nu este validă.';
} elseif (strlen($email) > 100) {
    $errors[] = 'Adresa de email este prea lungă.';
}

if (!empty($phone)) {
    if (!preg_match('/^[0-9\s\+\-\(\)]{10,20}$/', $phone)) {
        $errors[] = 'Numărul de telefon nu este valid.';
    }
}

if (empty($subject_type)) {
    $errors[] = 'Te rugăm să selectezi un subiect.';
}

if (empty($message)) {
    $errors[] = 'Mesajul este obligatoriu.';
} elseif (str_word_count($message) < 2) {
    $errors[] = 'Mesajul trebuie să conțină cel puțin două cuvinte.';
} elseif (strlen($message) > 5000) {
    $errors[] = 'Mesajul este prea lung (maxim 5000 caractere).';
}

if (!empty($errors_date)) {
    $errors[] = $errors_date;
}

if (!$consent) {
    $errors[] = 'Trebuie să accepti prelucrarea datelor personale.';
}

// Check for common spam patterns
$spam_patterns = [
    '/http(s)?:\/\//i',
    '/www\./i',
    '/\[url\]/i',
    '/\[link\]/i',
    '/viagra|cialis|casino|lottery|winner|prize/i',
];

$check_text = $name . ' ' . $message;
foreach ($spam_patterns as $pattern) {
    if (preg_match($pattern, $check_text)) {
        $errors[] = 'Mesajul tău conține elemente suspecte.';
        break;
    }
}

// Rate limiting check (using file-based simple rate limiting)
$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate_limit_file = sys_get_temp_dir() . '/urania_contact_' . md5($ip_address) . '.txt';
$max_requests = 3;
$time_window = 3600; // 1 hour
$now = time();

// Load existing requests and filter out old ones
$requests = [];
if (file_exists($rate_limit_file)) {
    $requests = json_decode(file_get_contents($rate_limit_file), true) ?: [];
    $requests = array_filter($requests, function($time) use ($now, $time_window) {
        return ($now - $time) < $time_window;
    });
}

// Check if limit exceeded
if (count($requests) >= $max_requests) {
    $errors[] = 'Ai depășit numărul maxim de mesaje. Încearcă din nou mai târziu.';
}

// If there are errors, return them
if (!empty($errors)) {
    $response['message'] = implode(' ', $errors);
    echo json_encode($response);
    exit;
}

// Prepare subject mapping
$subjects = [
    'eveniment' => 'Organizare eveniment',
    'repetitii' => 'Închiriere sală repetiții',
    'podcast' => 'Podcast, foto sau video',
    'conferinta' => 'Conferință sau workshop',
    'spectacol' => 'Spectacol sau concert',
    'expozitie' => 'Expoziție',
    'productie' => 'Producție foto/video',
    'colaborare' => 'Propunere de colaborare',
    'altele' => 'Altele'
];

$subject = $subject_prefix . ' ' . ($subjects[$subject_type] ?? 'Contact general');

// Get referrer info
$referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';

// Prepare email content
$email_body = "Mesaj nou de pe site-ul Urania Studio\n";
$email_body .= str_repeat("=", 50) . "\n\n";
$email_body .= "NUME: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "\n";
$email_body .= "EMAIL: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "\n";
if (!empty($phone)) {
    $email_body .= "TELEFON: " . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . "\n";
}
$email_body .= "SUBIECT: " . htmlspecialchars($subjects[$subject_type] ?? $subject_type, ENT_QUOTES, 'UTF-8') . "\n";
if ($event_date !== '') { $email_body .= "DATA DORITĂ: " . $event_date . "\n"; }
if ($guests !== '') { $email_body .= "PARTICIPANȚI: " . $guests . "\n"; }
$email_body .= "SURSA: " . $source . "\n";
$email_body .= "ACORD MARKETING: " . ($marketing ? "DA (bifat de utilizator la " . date('Y-m-d H:i') . ")" : "NU") . "\n";
$email_body .= "\nMESAJ:\n";
$email_body .= str_repeat("-", 50) . "\n";
$email_body .= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "\n";
$email_body .= str_repeat("-", 50) . "\n\n";
$email_body .= "INFORMAȚII TEHNICE:\n";
$email_body .= "Data: " . date('Y-m-d H:i:s') . "\n";
$email_body .= "IP: " . $ip_address . "\n";
$email_body .= "Referrer: " . htmlspecialchars($referrer, ENT_QUOTES, 'UTF-8') . "\n";

// Email headers
$headers = "From: " . $recipient_email . "\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
$mail_sent = mail($recipient_email, $subject, $email_body, $headers);

if ($mail_sent) {
    // Add current request to rate limiting and save
    $requests[] = $now;
    file_put_contents($rate_limit_file, json_encode(array_values($requests)));

    $response['success'] = true;
    $response['message'] = 'Mesajul a fost trimis cu succes!';
} else {
    $response['message'] = 'Eroare la trimiterea mesajului. Te rugăm să încerci din nou.';
}

// Return response
echo json_encode($response);
exit;
