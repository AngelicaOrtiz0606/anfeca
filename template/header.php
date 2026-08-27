<?php
/**
 * SIDEANFECA - Header
 * Template del encabezado
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDEANFECA - Sistema de Directorios</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Estilos propios -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ============================================================
HEADER (CON IMAGEN DE FONDO)
============================================================ -->
<header class="header">
    <div class="header-content">
        <div class="logo-container">
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            <img src="img/logo_anfeca.png" alt="ANFECA" class="logo-img">
            <div class="logo-divider"></div>
            <a href="index.php" class="logo-text" style="text-decoration: none;">
                <span class="logo-title">SIDEANFECA</span>
                <span class="logo-subtitle">SISTEMA INTEGRAL DE DIRECTORIOS ANFECA</span>
            </a>
        </div>
        <div class="header-actions">
            <div class="user-info">
                <span class="user-name"><?= htmlspecialchars($_SESSION['nombre'] ?? 'Administrador') ?></span>
                <span class="user-role"><?= htmlspecialchars($_SESSION['rol'] ?? 'Administrador') ?></span>
            </div>
            <button class="btn-logout" title="Cerrar sesión" onclick="confirmarLogout()">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>
</header>