<?php
// ============================================================
// SIDEANFECA - Dashboard Principal
// Sistema Integral de Directorios ANFECA
// ============================================================

// Configuración básica
session_start();

// Configurar zona horaria CDMX
date_default_timezone_set('America/Mexico_City');

// Configurar locale para español
setlocale(LC_TIME, 'es_ES.UTF-8', 'spanish');

// Simulación de sesión
$_SESSION['usuario'] = 'Administrador';
$_SESSION['nombre'] = 'Admin ANFECA';
$_SESSION['rol'] = 'Administrador';

// ============================================================
// DATOS ESTADÍSTICOS (SIMULADOS)
// ============================================================

$stats = [
    'personas' => [
        'total' => 1284,
        'activas' => 1156,
        'inactivas' => 128
    ],
    'instituciones' => [
        'total' => 87,
        'afiliadas' => 63,
        'observadoras' => 24
    ],
    'cargos' => [
        'total' => 45
    ],
    'coordinaciones' => [
        'total' => 24,
        'activas' => 22
    ]
];

// Actividad reciente (con fechas y horas reales)
$actividad_reciente = [
    [
        'icono' => 'user-plus',
        'color' => '#2e7d32',
        'bg' => '#e8f5e9',
        'accion' => 'registró una nueva persona',
        'usuario' => 'María González',
        'fecha' => '15 de agosto de 2026',
        'hora' => '09:30 hrs'
    ],
    [
        'icono' => 'edit',
        'color' => '#1565c0',
        'bg' => '#e3f2fd',
        'accion' => 'modificó la institución "UNAM"',
        'usuario' => 'Juan Pérez',
        'fecha' => '15 de agosto de 2026',
        'hora' => '09:15 hrs'
    ],
    [
        'icono' => 'user-check',
        'color' => '#e65100',
        'bg' => '#fff3e0',
        'accion' => 'asignó un cargo a una persona',
        'usuario' => 'Carlos López',
        'fecha' => '14 de agosto de 2026',
        'hora' => '16:45 hrs'
    ],
    [
        'icono' => 'user-times',
        'color' => '#c62828',
        'bg' => '#fce4ec',
        'accion' => 'desactivó una persona',
        'usuario' => 'Admin',
        'fecha' => '14 de agosto de 2026',
        'hora' => '14:20 hrs'
    ]
];

// Incluir templates
include 'template/header.php';
include 'template/menu.php';
?>

<!-- ============================================================
MAIN CONTENT
============================================================ -->
<main class="main-content">
    <div class="dashboard-container">

        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-text">
                <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre'] ?? 'Administrador') ?></h1>
                <p>Sistema Integral de Directorios ANFECA - Panel de Control</p>
            </div>
            <div class="welcome-date" id="reloj">
                <i class="fas fa-calendar-alt"></i>
                <span id="fecha_hora"></span>
            </div>
        </section>

        <!-- Stats Grid (SOLO 4 - sin tendencias) -->
        <section class="stats-grid">

            <!-- Personas -->
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['personas']['total']) ?></h3>
                    <span class="stat-label">Personas</span>
                    <div class="stat-detail">
                        <span><span class="dot" style="background:#2e7d32;"></span> Activas: <?= number_format($stats['personas']['activas']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Instituciones -->
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-university"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['instituciones']['total']) ?></h3>
                    <span class="stat-label">Instituciones</span>
                    <div class="stat-detail">
                        <span><span class="dot" style="background:#2e7d32;"></span> Afiliadas: <?= number_format($stats['instituciones']['afiliadas']) ?></span>
                        <span><span class="dot" style="background:#ffc107;"></span> Observadoras: <?= number_format($stats['instituciones']['observadoras']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Cargos -->
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['cargos']['total']) ?></h3>
                    <span class="stat-label">Cargos</span>
                </div>
            </div>

            <!-- Coordinaciones -->
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['coordinaciones']['total']) ?></h3>
                    <span class="stat-label">Coordinaciones</span>
                    <div class="stat-detail">
                        <span><span class="dot" style="background:#2e7d32;"></span> Activas: <?= number_format($stats['coordinaciones']['activas']) ?></span>
                    </div>
                </div>
            </div>

        </section>

        <!-- Actividad Reciente -->
        <section class="activity-section">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i>
                    Actividad reciente
                </h3>
                <a href="#" class="btn btn-sm btn-outline">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <?php foreach ($actividad_reciente as $actividad): ?>
                    <div class="activity-item">
                        <div class="activity-icon" style="background: <?= $actividad['bg'] ?>; color: <?= $actividad['color'] ?>;">
                            <i class="fas fa-<?= $actividad['icono'] ?>"></i>
                        </div>
                        <div class="activity-content">
                            <p><strong><?= htmlspecialchars($actividad['usuario']) ?></strong> <?= htmlspecialchars($actividad['accion']) ?></p>
                            <div class="activity-datetime">
                                <i class="far fa-calendar-alt"></i> <?= $actividad['fecha'] ?>
                                <i class="far fa-clock" style="margin-left: 0.5rem;"></i> <?= $actividad['hora'] ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </div>
</main>

<?php include 'template/footer.php'; ?>