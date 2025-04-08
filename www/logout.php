<?php
require_once '../fileHead.php';
unset($_SESSION['admin']);
unset($_SESSION['user']);
header('Location: /');