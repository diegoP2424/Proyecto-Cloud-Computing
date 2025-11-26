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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menú Principal</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* Estilos base */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      background: #fff;
      width: 100%;
      max-width: 450px;
      padding: 40px;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      text-align: center;
    }
    h1 {
      font-family: 'Poppins', sans-serif;
      color: #2d3748;
      font-size: 26px;
      margin-bottom: 5px;
    }
    .user-badge {
        background: #ebf4ff;
        color: #5a67d8;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 30px;
    }
    .cmb { text-align: left; margin-bottom: 25px; }
    .cmb label {
      font-size: 13px; font-weight: 600; color: #4a5568;
      margin-bottom: 10px; display: block; text-transform: uppercase;
    }
    select {
      width: 100%;
      padding: 15px;
      background: #edf2f7;
      border: 2px solid transparent;
      border-radius: 12px;
      font-size: 15px;
      color: #2d3748;
      cursor: pointer;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a5568' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1em;
    }
    select:focus {
        background-color: #fff;
        border-color: #667eea;
        outline: none;
    }
    /* Botón Principal */
    button {
      width: 100%;
      padding: 16px;
      background: linear-gradient(to right, #667eea, #764ba2);
      border: none;
      border-radius: 12px;
      color: white;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 10px 20px rgba(118, 75, 162, 0.25);
      transition: transform 0.2s;
    }
    button:hover { transform: translateY(-2px); }


    .btn-logout {
        display: inline-block;
        margin-top: 20px;
        color: #718096;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.3s ease;
        padding: 10px;
    }
    .btn-logout:hover {
        color: #e53e3e; 
    }

    /* Contenedor para los botones */
    .menu-grid {
        display: flex;
        flex-direction: column;
        gap: 15px; /* Espacio entre botones */
        margin-bottom: 20px;
    }

    /* Estilo del nuevo botón tipo tarjeta */
    .btn-card {
        background: #f7fafc; /* Fondo gris claro */
        color: #4a5568;
        border: 2px solid #e2e8f0;
        padding: 20px;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;       /* Para alinear icono y texto */
        align-items: center;
        justify-content: flex-start; /* Alinear a la izquierda */
        text-align: left;
        box-shadow: none; /* Quitamos la sombra por defecto que tenías antes */
        width: 100%;
    }

    /* Icono dentro del botón */
    .btn-card .icon {
        font-size: 24px;
        margin-right: 15px;
        background: #fff;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    /* Efecto Hover (cuando pasas el mouse) */
    .btn-card:hover {
        background: #fff;
        border-color: #667eea; /* Color morado del tema */
        color: #5a67d8;
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(102, 126, 234, 0.15);
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Panel de Control</h1>
    <div class="user-badge">Hola, <?php echo $_SESSION["usuario"]; ?></div>
    
    <form method="post" action="comprobar_cookies.php">
        <div class="menu-grid">
            <button type="submit" name="pagina" value="personajes.php" class="btn-card">
                <span class="icon">🔍</span>
                <span class="text">Consultar Personajes</span>
            </button>

            <button type="submit" name="pagina" value="ingresar.php" class="btn-card">
                <span class="icon">➕</span>
                <span class="text">Ingresar Nuevo</span>
            </button>

            <button type="submit" name="pagina" value="archivos.php" class="btn-card">
                <span class="icon">📂</span>
                <span class="text">Descargar Archivos</span>
            </button>
        </div>
    </form>

    <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
    
  </div>
</body>
</html>