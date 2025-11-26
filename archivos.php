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

    $directorio = "descargas/";
    $archivos_encontrados = [];

    $archivos = array_diff(scandir($directorio), array('.', '..'));
    
    foreach($archivos as $archivo){
        $archivos_encontrados[] = $archivo;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Repositorio de Archivos</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* Reset y Estilos Base */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: 'Inter', sans-serif;
      /* Mismo gradiente que en bienvenida.php */
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
      max-width: 500px; /* Un poco más ancho para que quepan nombres largos */
      padding: 40px;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    h1 {
      font-family: 'Poppins', sans-serif;
      color: #2d3748;
      font-size: 24px;
      margin-bottom: 10px;
      text-align: center;
    }

    p.subtitle {
        text-align: center;
        color: #718096;
        font-size: 14px;
        margin-bottom: 30px;
    }

    /* Estilo de la Lista */
    ul { list-style: none; }

    li { 
        background: #f7fafc;
        margin-bottom: 12px;
        padding: 15px 20px;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #edf2f7;
        transition: all 0.2s ease;
    }

    li:hover {
        background: #fff;
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transform: translateY(-2px);
    }

    /* Nombre del archivo e icono */
    .file-info {
        display: flex;
        align-items: center;
        overflow: hidden; /* Evita que nombres largos rompan el diseño */
    }

    .file-icon {
        width: 40px;
        height: 40px;
        background: #ebf4ff;
        color: #5a67d8;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .file-name {
        font-weight: 500;
        color: #2d3748;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px; /* Ajusta esto según necesites */
    }

    /* Botón de descarga (Icono) */
    a.download-btn {
        background: #edf2f7;
        color: #4a5568;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    a.download-btn:hover {
        background: #667eea;
        color: white;
    }

    /* Botón Volver */
    .btn-back {
      display: block;
      width: 100%;
      padding: 15px;
      margin-top: 30px;
      background: transparent;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      color: #718096;
      font-size: 15px;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      transition: all 0.3s;
    }
    .btn-back:hover { 
        border-color: #cbd5e0;
        color: #2d3748;
        background: #f7fafc;
    }

    .empty-state {
        text-align: center;
        color: #a0aec0;
        padding: 20px;
        font-style: italic;
    }

    .error-msg {
        background: #fff5f5;
        color: #c53030;
        padding: 10px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
        border: 1px solid #feb2b2;
    }

  </style>
</head>
<body>
  <div class="card">
    <h1>Repositorio de Archivos</h1>
    <p class="subtitle">Descarga los documentos disponibles</p>

    <?php if(isset($error_dir)): ?>
        <div class="error-msg"><?php echo $error_dir; ?></div>
    <?php else: ?>
        <ul>
        <?php foreach($archivos_encontrados as $file): ?>
            <li>
                <div class="file-info">
                    <div class="file-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    </div>
                    <span class="file-name" title="<?php echo $file; ?>"><?php echo $file; ?></span>
                </div>
                
                <a href="<?php echo $directorio . $file; ?>" class="download-btn" download title="Descargar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
 

    <?php endif; ?>

    <a href="bienvenida.php" class="btn-back">← Volver al Menú Principal</a>
  </div>
</body>
</html>