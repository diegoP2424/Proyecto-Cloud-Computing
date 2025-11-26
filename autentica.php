<?php
    session_start();
    date_default_timezone_set("America/Mexico_City");

    $conexion = mysqli_connect("localhost", "root", "", "proyecto_cc", 3306);

    if(isset($_COOKIE["usuario"]) && isset($_COOKIE["pass"])){
        $usuario_cookie = $_COOKIE["usuario"];
        $pass_cookie = $_COOKIE["pass"];

        $stmt = mysqli_prepare($conexion, "SELECT usuario, pass FROM Usuarios WHERE usuario = ? AND pass = ?");
        mysqli_stmt_bind_param($stmt, "ss", $usuario_cookie, $pass_cookie);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if($fila = mysqli_fetch_assoc($resultado)){
            $_SESSION["logueado"] = true;
            $_SESSION["usuario"] = $fila['usuario'];
            $_SESSION["pass"] = $fila['pass']; 
            
            mysqli_stmt_close($stmt);
            header("Location: bienvenida.php");
            exit();
        }
        mysqli_stmt_close($stmt);
        
    }

    
    if(isset($_POST["usuario"]) && isset($_POST["pass"])){
        $usuario_post = $_POST["usuario"];
        $pass_post = $_POST["pass"];

        $stmt = mysqli_prepare($conexion, "SELECT usuario, pass FROM Usuarios WHERE usuario = ? AND pass = ?");
        mysqli_stmt_bind_param($stmt, "ss", $usuario_post, $pass_post);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if($fila = mysqli_fetch_assoc($resultado)){
            if(isset($_POST["recordar"])){
                setcookie("usuario", $fila['usuario'], time()+60*60*24);
                setcookie("pass", $fila['pass'], time()+60*60*24);
            }

            $_SESSION["logueado"] = true;
            $_SESSION["usuario"] = $fila['usuario'];
            $_SESSION["pass"] = $fila['pass'];
            
            header("Location: bienvenida.php");
            exit();

        } else {
            header("Location: index.php?error=1");
            exit();
        }
        mysqli_stmt_close($stmt);
    } 
    
?>