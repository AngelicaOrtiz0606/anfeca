<?php
/**
 * SIDEANFECA - Menú Lateral
 * Template del sidebar
 */
?>
<!-- ============================================================
SIDEBAR
============================================================ -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-menu">
        <ul>
            <li class="menu-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
                <a href="index.php">
                    <i class="fas fa-home"></i>
                    <span>Panel de Control</span>
                </a>
            </li>
            <li class="menu-divider">GESTIÓN PRINCIPAL</li>
            <li class="menu-item <?= (strpos($_SERVER['PHP_SELF'], 'persona') !== false) ? 'active' : '' ?>">
                <a href="personas.php">
                    <i class="fas fa-users"></i>
                    <span>Personas</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="instituciones.php">
                    <i class="fas fa-university"></i>
                    <span>Instituciones</span>
                </a>
            </li>
            <li class="menu-divider">CATÁLOGOS</li>
            <li class="menu-item">
                <a href="cargos.php">
                    <i class="fas fa-briefcase"></i>
                    <span>Cargos</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="coordinaciones_nacionales.php">
                    <i class="fas fa-sitemap"></i>
                    <span>Coordinaciones Nacionales</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="zonas_regionales.php">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Zonas Regionales</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="niveles_academicos.php">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Niveles Académicos</span>
                </a>
            </li>
            <li class="menu-divider">DIRECTORIOS</li>
            <li class="menu-item">
                <a href="consultar_directorio.php">
                    <i class="fas fa-book"></i>
                    <span>Consultar Directorios</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="odernar_cargos.php">
                    <i class="fas fa-arrows-alt-v"></i>
                    <span>Ordenar Cargos</span>
                </a>
            </li>
            <li class="menu-divider">CUENTA</li>
            <li class="menu-item">
                <a href="cambiar_contrasenia">
                    <i class="fas fa-key"></i>
                    <span>Cambiar contraseña</span>
                </a>
            </li>
        </ul>
    </div>
</nav>