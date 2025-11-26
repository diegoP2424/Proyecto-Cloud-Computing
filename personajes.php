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

    $conexion = mysqli_connect("localhost", "root", "", "proyecto_cc", 3306);
    $registros = [];
    
    if($conexion){
        $consulta = "SELECT * FROM Personajes ORDER BY idPersonaje DESC";
        $resultado = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_assoc($resultado)){
            $registros[] = $fila;
        }
        mysqli_close($conexion);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Galería de Personajes</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    /* Reset y Base */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 40px 20px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Encabezado */
    .header-title {
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }
    .header-title h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 32px;
        text-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .header-title p {
        opacity: 0.9;
        margin-top: 5px;
    }

    /* GRID: Cuadrícula de tarjetas */
    .char-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    /* TARJETA DE PERSONAJE */
    .char-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .char-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.25);
    }

    /* Imagen del Personaje */
    .card-img-container {
        width: 100%;
        height: 200px;
        background-color: #e2e8f0;
        position: relative;
    }
    
    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Recorta la imagen para llenar el espacio sin deformar */
        object-position: center top;
    }

    /* Badge del ROL */
    .role-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        backdrop-filter: blur(4px);
    }

    /* Colores específicos según el rol (Opcional, se ve genial) */
    .role-Tanque { background: #e53e3e; } /* Rojo */
    .role-DPS { background: #d69e2e; }    /* Amarillo */
    .role-Support { background: #38a169; } /* Verde */

    /* Contenido de la tarjeta */
    .card-body {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .char-name {
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .char-desc {
        font-size: 14px;
        color: #718096;
        line-height: 1.6;
        margin-bottom: 15px;
        
        
        height: 120px; 
        overflow-y: auto; 
        padding-right: 5px; 
    }

    .char-desc::-webkit-scrollbar {
        width: 6px;
    }
    .char-desc::-webkit-scrollbar-track {
        background: #f1f1f1; 
        border-radius: 4px;
    }
    .char-desc::-webkit-scrollbar-thumb {
        background: #cbd5e0; 
        border-radius: 4px;
    }
    .char-desc::-webkit-scrollbar-thumb:hover {
        background: #a0aec0; 
    }

    .char-id {
        font-size: 11px;
        color: #a0aec0;
        text-align: right;
        margin-top: auto;
    }

    /* Botón flotante de volver */
    .btn-back-container {
        text-align: center;
        margin-top: 50px;
    }
    
    .btn-back {
        display: inline-block;
        padding: 12px 30px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background: white;
        color: #667eea;
    }

    /* Estado vacío */
    .empty-state {
        grid-column: 1 / -1;
        background: white;
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        color: #718096;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header-title">
        <h1>Galería de Personajes</h1>
        <p>Listado completo de héroes registrados</p>
    </div>

    <div class="char-grid">
        
        <?php if(count($registros) > 0): ?>
            <?php foreach($registros as $pj): ?>
                <div class="char-card">
                    <div class="card-img-container">
                        <?php 
                            $ruta_imagen = "img/" . $pj['imagen'];
                            
                            if(empty($pj['imagen'])) { $ruta_imagen = "img/default.jpg"; }
                        ?>
                        <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $pj['nombre']; ?>" class="card-img"/>
                        
                        <span class="role-badge role-<?php echo $pj['rol']; ?>">
                            <?php echo $pj['rol']; ?>
                        </span>
                    </div>

                    <div class="card-body">
                        <h2 class="char-name"><?php echo $pj['nombre']; ?></h2>
                        <p class="char-desc">
                            <?php 
                                echo $pj['descripcion'];
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <h3>No hay personajes en la base de datos</h3>
                <p>Ve a la sección de "Ingresar" para añadir el primero.</p>
            </div>
        <?php endif; ?>

    </div>

    <div class="btn-back-container">
        <a href="bienvenida.php" class="btn-back">← Volver al Menú Principal</a>
    </div>

  </div>

</body>
</html>