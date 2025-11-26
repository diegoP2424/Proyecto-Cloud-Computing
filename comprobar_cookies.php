<?php
    session_start();
    if(!isset($_SESSION["logueado"]) || $_SESSION["logueado"] !== true){
        header("Location: index.php?error=2");
        exit();
    }elseif(isset($_COOKIE["usuario"]) && isset($_COOKIE["pass"]) && 
        ($_COOKIE["usuario"] != $_SESSION["usuario"] || $_COOKIE["pass"] != $_SESSION["pass"])){
        header("Location: index.php?error=2");
        exit();
    }

    $pagina = $_POST['pagina'];
    header("Location: ".$pagina);
    exit();
?>