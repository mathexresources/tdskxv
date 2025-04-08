<?php
$path = $_SERVER['REQUEST_URI'];
$path = substr($path, 0, strpos($path, '?') ?: strlen($path));
$labels = [
    '/admin' => 'Administrace',
    '/users' => 'Správa uživatelů',
    '/manage' => 'Alba',
    '/texts' => 'Texty na hl. stránce',
    '/contactDetails' => 'Kontaktní údaje',
    '/stats' => 'Blog',
    '/edit' => 'Úprava alba'
];
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb pt-5">
        <li class="breadcrumb-item"><a href="/admin">Administrace</a></li>
        <li class="breadcrumb-item " aria-current="page"><?=$labels[$path]?></li>
    </ol>
</nav>