<?php
require_once '../fileHead.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST['loginForm'];
    $mail = $form['email'];
    $pass = $form['password'];

    $sql = $db->query("SELECT * FROM users WHERE (email = '$mail' OR username = '$mail') AND deleted = 0");
    $result = $sql->fetch_assoc();

    if ($result && password_verify($pass, $result['password'])) {
        $_SESSION['user'] = $result;
        $_SESSION['admin'] = true;
        header('Location: /admin');
        exit();
    } else {
        header('Location: /login?error=1');
        exit();
    }
} else {
    header('Location: /login');
    exit();
}
