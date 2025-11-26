<?php
    session_start();
    $_SESSION = array();
    session_destroy();

    if (isset($_COOKIE['usuario'])) {
        setcookie('usuario', '', time() - 3600);
        unset($_COOKIE['usuario']);
    }
    if (isset($_COOKIE['pass'])) {
        setcookie('pass', '', time() - 3600);
        unset($_COOKIE['pass']);
    }

    header("Location: index.php");
    exit();
?>