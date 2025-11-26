<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Proyecto CC</title>
  <!-- Fuentes modernas de Google -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    /* Reset y Base */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: 'Inter', sans-serif;
      /* Degradado moderno de fondo */
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Tarjeta tipo Glass/Card */
    .login-container {
      background: rgba(255, 255, 255, 0.95);
      width: 100%;
      max-width: 400px;
      padding: 40px;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s ease;
    }
    
    .login-container:hover {
        transform: translateY(-5px);
    }

    h1 {
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 10px;
      font-size: 28px;
    }
    
    p.subtitle {
        color: #718096;
        font-size: 14px;
        margin-bottom: 30px;
    }

    .input-group {
      text-align: left;
      margin-bottom: 20px;
    }

    label {
      font-size: 13px;
      font-weight: 600;
      color: #4a5568;
      margin-bottom: 8px;
      display: block;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 14px 18px;
      background: #edf2f7;
      border: 2px solid transparent;
      border-radius: 12px;
      font-size: 15px;
      color: #2d3748;
      transition: all 0.3s ease;
    }

    input:focus {
      background: #fff;
      border-color: #667eea;
      outline: none;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .remember {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
      margin: 10px 0 25px 0;
      color: #4a5568;
      cursor: pointer;
    }
    
    input[type="checkbox"] {
        accent-color: #667eea;
        width: 16px;
        height: 16px;
    }

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
      transition: transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 10px 20px rgba(118, 75, 162, 0.25);
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 25px rgba(118, 75, 162, 0.4);
    }
    
    button:active {
        transform: scale(0.98);
    }
    
    .error-msg {
        background: #fed7d7;
        color: #c53030;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        margin-top: 15px;
        border: 1px solid #feb2b2;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <?php
      session_start();
      if (isset($_GET['error']) && $_GET['error'] == 2) {
            echo '<div class="error-msg">⚠️ Sesión expirada. Ingresa nuevamente.</div>';
            setcookie("usuario", "", time() - 100000);
            setcookie("pass", "", time() - 100000);
            $_SESSION = [];
      }elseif(isset($_COOKIE["usuario"]) && isset($_COOKIE["pass"])){
          header("Location: autentica.php");
          exit();
      }
    ?>
    
    <h1>Bienvenido</h1>
    <p class="subtitle">Ingresa tus credenciales para continuar</p>

    <form method="post" action="autentica.php">
        <div class="input-group">
            <label>Usuario</label>
            <input type="text" placeholder="ej. NoobMaster69" name="usuario" required/>
        </div>

        <div class="input-group">
            <label>Contraseña</label>
            <input type="password" placeholder="••••••••" name="pass" required/>
        </div>

        <label class="remember">
            <input type="checkbox" name="recordar"/>
            <span>Recordar mi usuario</span>
        </label>

        <button type="submit">Iniciar Sesión</button>
    </form>
    
    <?php
      if (isset($_GET['error']) && $_GET['error'] == 1) {
          echo '<div class="error-msg">❌ Usuario o contraseña incorrectos.</div>';
      }
    ?>
  </div>
</body>
</html>