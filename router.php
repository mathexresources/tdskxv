<?php
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/^\/album\/(\d+)$/', $request, $matches)) {
    $_GET['id'] = $matches[1];
    include 'www/album.php';
    exit;
}

return false; // Let PHP handle other files normally
