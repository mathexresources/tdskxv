<?php
require_once '../../fileHead.php';

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /login');
    die('<script>window.location = "/login";</script>');
    exit();
}

$old = $_POST['oldPassword'] ?? '';
$new = $_POST['newPassword'] ?? '';
$confirm = $_POST['newPassword2'] ?? '';

if ($old == '' || $new == '' || $confirm == '') {
    $_SESSION['error'] = 'Všechna pole musí být vyplněna';
    header('Location: /admin?alert=pass1');
    die('<script>window.location = "/admin?alert=pass1";</script>');
    exit();
}

if ($new != $confirm) {
    $_SESSION['error'] = 'Hesla se neshodují';
    header('Location: /admin?alert=pass2');
    die('<script>window.location = "/admin?alert=pass2";</script>');
    exit();
}

$sql = "SELECT * FROM users WHERE id = " . $_SESSION['user']['id'];
$user = $db->query($sql)->fetch_assoc();
if (!password_verify($old, $user['password'])) {
    $_SESSION['error'] = 'Špatné staré heslo';
    header('Location: /admin?alert=pass3');
    die('<script>window.location = "/admin?alert=pass3";</script>');
    exit();
}

$hash = password_hash($new, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = '$hash' WHERE id = " . $_SESSION['user']['id'];
$db->query($sql);
header('Location: /logout');
die('<script>window.location = "/logout";</script>');