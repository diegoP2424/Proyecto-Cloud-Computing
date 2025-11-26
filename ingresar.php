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

    $mensaje = "";
    $tipo_mensaje = ""; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conexion = mysqli_connect("localhost", "root", "", "proyecto_cc", 3306);

        $nombre = trim($_POST["nombre"]);
        $rol = $_POST["rol"];
        $descripcion = trim($_POST["descripcion"]);
        
        $nombre_imagen_final = "default.jpg"; 
        $directorio_destino = "img/";
        $error_subida = false;

        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            // esto pa extraer la extension
            $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
            
            $nombre_unico = uniqid() . "." . $extension;
            $ruta_final = $directorio_destino . $nombre_unico;

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_final)) {
                $nombre_imagen_final = $nombre_unico;
            } else {
                $mensaje = "Error al mover la imagen a la carpeta 'img'.";
                $tipo_mensaje = "error";
                $error_subida = true;
            }
        }

        if (!$error_subida) {
            $sql = "INSERT INTO Personajes (nombre, descripcion, rol, imagen) VALUES (?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $nombre, $descripcion, $rol, $nombre_imagen_final);
            
            if (mysqli_stmt_execute($stmt)) {
                $mensaje = "¡Personaje registrado correctamente!";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error al guardar: " . mysqli_stmt_error($stmt);
                $tipo_mensaje = "error";
            }
            mysqli_stmt_close($stmt);
            
        }
        mysqli_close($conexion);
        
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ingresar Personaje</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* --- Estilos Base --- */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .card {
      background: #fff;
      width: 100%;
      max-width: 500px;
      padding: 40px;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    h1 {
      font-family: 'Poppins', sans-serif;
      color: #2d3748;
      font-size: 26px;
      margin-bottom: 5px;
      text-align: center;
    }
    p.subtitle {
        text-align: center;
        color: #718096;
        font-size: 14px;
        margin-bottom: 30px;
    }

    /* Formulario */
    .input-group { margin-bottom: 20px; }
    
    label {
        display: flex;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    label svg { margin-right: 6px; color: #667eea; }

    /* Estilos compartidos para inputs de texto, area de texto y SELECT */
    input[type="text"], 
    textarea, 
    select {
        width: 100%;
        padding: 14px 16px;
        background: #f7fafc;
        border: 2px solid #edf2f7;
        border-radius: 12px;
        font-size: 15px;
        color: #2d3748;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    /* Estilo específico para el SELECT (Flecha personalizada) */
    select {
        cursor: pointer;
        appearance: none; /* Elimina la flecha fea por defecto del navegador */
        /* Icono de flecha SVG en background */
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a5568' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
    }

    textarea { resize: vertical; min-height: 100px; }
    
    /* Focus states */
    input:focus, textarea:focus, select:focus {
        background-color: #fff;
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Input FILE styles */
    input[type="file"] {
        width: 100%;
        padding: 10px;
        background: #f7fafc;
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        cursor: pointer;
        color: #4a5568;
    }
    input[type="file"]::file-selector-button {
        margin-right: 15px;
        padding: 8px 16px;
        border-radius: 8px;
        background: #e2e8f0;
        border: none;
        font-weight: 600;
        color: #4a5568;
        cursor: pointer;
        transition: background 0.2s;
    }
    input[type="file"]::file-selector-button:hover { background: #cbd5e0; }

    /* Buttons */
    button.btn-primary {
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
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 10px;
    }
    button.btn-primary:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 15px 25px rgba(118, 75, 162, 0.35);
    }
    .btn-back {
        display: block;
        text-align: center;
        margin-top: 25px;
        color: #718096;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.2s;
    }
    .btn-back:hover { color: #4a5568; text-decoration: underline; }
    
    /* Alerts */
    .alert {
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
    }
    .alert-success { background-color: #f0fff4; color: #2f855a; border: 1px solid #c6f6d5; }
    .alert-error { background-color: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
  </style>
</head>
<body>
  <div class="card">
    <h1>Nuevo Personaje</h1>
    <p class="subtitle">Ingresa los datos para registrarlo en la base de datos</p>
    
    <?php if(!empty($mensaje)): ?>
        <div class="alert <?php echo ($tipo_mensaje == 'success') ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="ingresar.php" enctype="multipart/form-data">
        <div class="input-group">
            <label>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Nombre del Personaje
            </label>
            <input type="text" name="nombre" required placeholder="Ej: Doomfist"/>
        </div>
        
        <div class="input-group">
            <label>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Rol
            </label>
            
            <select name="rol" required>
                <option value="" disabled selected>Selecciona un rol...</option>
                <option value="Tanque">Tanque</option>
                <option value="DPS">DPS</option>
                <option value="Support">Support</option>
            </select>

        </div>

        <div class="input-group">
            <label>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                Imagen del Personaje
            </label>
            <input type="file" name="imagen" accept=".jpg, .jpeg, .png" required />
        </div>

        <div class="input-group">
            <label>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                Descripción
            </label>
            <textarea name="descripcion" placeholder="Escribe una breve lore o poderes especiales..."></textarea>
        </div>

        <button type="submit" class="btn-primary">Guardar Registro</button>
    </form>
    
    <a href="bienvenida.php" class="btn-back">Volver al menú</a>
  </div>
</body>
</html>