<?php
// ============================================================
// SIDEANFECA - Login
// Pantalla de inicio de sesión
// ============================================================

session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Procesar login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Credenciales hardcodeadas
    $credenciales = [
        'admin' => 'admin123',
        'anfeca' => 'anfeca2026'
    ];
    
    if (isset($credenciales[$usuario]) && $credenciales[$usuario] === $password) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = 'Admin ANFECA';
        $_SESSION['rol'] = 'Administrador';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de ANFECA - Iniciar Sesión</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ============================================================
           ESTILOS LOGIN
           ============================================================ */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f0f0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1100px;
            height: 650px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin: 1.5rem;
        }
        
        /* ============================================================
           LADO IZQUIERDO - IMAGEN DE FONDO (SIN ICONO)
           ============================================================ */
        
        .login-image {
            flex: 1;
            background: url('img/fondo.jpg') center center / cover no-repeat;
            position: relative;
            min-width: 300px;
        }
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(139, 0, 0, 0.35);
            pointer-events: none;
        }
        
        .login-image .image-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            text-align: center;
        }
        
        .login-image h1 {
            color: white;
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }
        
        .login-image h1 span {
            display: block;
            font-weight: 300;
            font-size: 1rem;
            letter-spacing: 4px;
            opacity: 0.9;
            margin-top: 0.3rem;
        }
        
        .login-image .brand-line {
            width: 60px;
            height: 3px;
            background: rgba(255,255,255,0.4);
            border-radius: 2px;
            margin: 1.2rem 0;
        }
        
        .login-image .brand-subtitle {
            color: rgba(255,255,255,0.85);
            font-size: 0.95rem;
            font-weight: 300;
            max-width: 300px;
            line-height: 1.6;
            text-shadow: 0 1px 10px rgba(0,0,0,0.2);
        }
        
        /* ============================================================
           LADO DERECHO - FORMULARIO
           ============================================================ */
        
        .login-form {
            flex: 1;
            padding: 3rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 320px;
            max-width: 480px;
        }
        
        .login-form .form-header {
            margin-bottom: 2rem;
        }
        
        .login-form .form-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.3rem;
        }
        
        .login-form .form-header p {
            color: #888;
            font-size: 0.95rem;
        }
        
        .login-form .form-group {
            margin-bottom: 1.25rem;
        }
        
        .login-form label {
            display: block;
            font-weight: 600;
            font-size: 0.8rem;
            color: #3a3a3a;
            margin-bottom: 0.3rem;
        }
        
        .login-form .input-wrapper {
            position: relative;
        }
        
        .login-form .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }
        
        .login-form .input-wrapper input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 3rem;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fafafa;
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
        }
        
        .login-form .input-wrapper input:focus {
            outline: none;
            border-color: #8B0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
        }
        
        .login-form .input-wrapper input:focus ~ i {
            color: #8B0000;
        }
        
        .login-form .input-wrapper input::placeholder {
            color: #bbb;
        }
        
        .login-form .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
        
        .login-form .form-options .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            cursor: pointer;
        }
        
        .login-form .form-options .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #8B0000;
            cursor: pointer;
        }
        
        .login-form .form-options .forgot-link {
            color: #8B0000;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .login-form .form-options .forgot-link:hover {
            color: #5C0000;
            text-decoration: underline;
        }
        
        .login-form .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #8B0000, #5C0000);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
        }
        
        .login-form .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(139, 0, 0, 0.35);
        }
        
        .login-form .btn-login:active {
            transform: translateY(0);
        }
        
        .login-form .error-message {
            background: #fdf0f0;
            color: #7a1a1a;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            border-left: 4px solid #c62828;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        
        .login-form .error-message i {
            color: #c62828;
            font-size: 1.1rem;
        }
        
        .login-form .form-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.8rem;
            color: #999;
        }
        
        .login-form .form-footer .brand-name {
            color: #8B0000;
            font-weight: 600;
        }
        
        /* ============================================================
           RESPONSIVE
           ============================================================ */
        
        @media (max-width: 820px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-width: 480px;
                border-radius: 20px;
            }
            
            .login-image {
                min-height: 200px;
                min-width: auto;
            }
            
            .login-image .image-content {
                padding: 2.5rem 2rem;
            }
            
            .login-image h1 {
                font-size: 1.8rem;
            }
            
            .login-image h1 span {
                font-size: 0.85rem;
            }
            
            .login-image .brand-subtitle {
                font-size: 0.85rem;
            }
            
            .login-form {
                padding: 2rem 1.5rem;
                max-width: 100%;
                min-width: auto;
            }
            
            .login-form .form-header h2 {
                font-size: 1.4rem;
            }
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 1rem;
                border-radius: 16px;
            }
            
            .login-image {
                min-height: 150px;
            }
            
            .login-image .image-content {
                padding: 1.5rem 1.5rem;
            }
            
            .login-image h1 {
                font-size: 1.4rem;
            }
            
            .login-image h1 span {
                font-size: 0.7rem;
            }
            
            .login-image .brand-subtitle {
                font-size: 0.75rem;
            }
            
            .login-image .brand-line {
                margin: 0.8rem 0;
            }
            
            .login-form {
                padding: 1.5rem 1rem;
            }
            
            .login-form .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .login-form .input-wrapper input {
                padding: 0.7rem 1rem 0.7rem 2.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        
        <!-- Lado Izquierdo - Imagen de fondo (sin icono) -->
        <div class="login-image">
            <div class="image-content">
                <h1>
                    Sistema de ANFECA
                    <span>SISTEMA INTEGRAL DE DIRECTORIOS</span>
                </h1>
                <div class="brand-line"></div>
                <p class="brand-subtitle">
                    Asociación Nacional de Facultades y Escuelas de Contaduría y Administración
                </p>
            </div>
        </div>
        
        <!-- Lado Derecho - Formulario -->
        <div class="login-form">
            <div class="form-header">
                <h2>Bienvenido</h2>
                <p>Ingresa tus credenciales para acceder al sistema</p>
            </div>
            
            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <div class="input-wrapper">
                        <input type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario" value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>" required autofocus>
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="recordar"> Recordarme
                    </label>
                    <!--<a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>-->
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </button>
            </form>
            
            <div class="form-footer">
                <span class="brand-name">ANFECA</span> &bull; Sistema de Directorios v1.0
            </div>
        </div>
        
    </div>
</body>
</html>