<?php
// Doar pentru localhost (php -S): imită regulile din .htaccess.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/servicii.php') { header('Location: /preturi.php', true, 301); exit; }
if (preg_match('#\.(md|sqlite|zip)$#i', $path) || preg_match('#^/(data|includes)/#', $path) || preg_match('#^/uploads/.*\.(php|phtml|phar)$#i', $path)) {
    http_response_code(403); exit('Forbidden');
}
return false;
