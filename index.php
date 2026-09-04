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
// DATOS ESTADÍSTICOS (actualizados con datos reales)
// ============================================================

// Personas: 38 registros (IDs 1-38)
// Activos: 37 (todos excepto quienes tienen fecha_fin)
// Inactivos: 0

$stats = [
    'personas' => [
        'total' => 38,
        'activas' => 37,
        'inactivas' => 1
    ],
    'instituciones' => [
        'total' => 38,
        'afiliadas' => 31,
        'observadoras' => 4,
        'matrices' => 3
    ],
    'cargos' => [
        'total' => 45
    ],
    'coordinaciones' => [
        'total' => 14,
        'activas' => 14
    ]
];

// ============================================================
// MAPEO DE ACCIONES A VERBOS E ICONOS
// ============================================================

$acciones_map = [
    'Registro' => ['verbo' => 'registró', 'icono' => 'fa-user-plus'],
    'Modificacion' => ['verbo' => 'modificó', 'icono' => 'fa-edit'],
    'Activacion' => ['verbo' => 'reactivó', 'icono' => 'fa-user-check'],
    'Desactivacion' => ['verbo' => 'desactivó', 'icono' => 'fa-user-times']
];

// ============================================================
// BITÁCORA RECIENTE - ÚLTIMOS 6 MOVIMIENTOS
// ============================================================

$bitacora_reciente = [
    [
        'fecha_hora' => '2026-08-15 09:30:00',
        'usuario' => 'Armando Tomé González',
        'accion' => 'Registro',
        'descripcion' => 'a la Facultad de Contaduría y Administración (UNAM)'
    ],
    [
        'fecha_hora' => '2026-08-15 09:15:00',
        'usuario' => 'Adriana Garza Elizondo',
        'accion' => 'Modificacion',
        'descripcion' => 'los datos de la Universidad Autónoma de Nuevo León'
    ],
    [
        'fecha_hora' => '2026-08-14 16:45:00',
        'usuario' => 'Carlos Lobo Sánchez',
        'accion' => 'Modificacion',
        'descripcion' => 'el cargo a Leobardo Berrelleza Reyes'
    ],
    [
        'fecha_hora' => '2026-08-14 14:20:00',
        'usuario' => 'Lourdes Mata Romero',
        'accion' => 'Desactivacion',
        'descripcion' => 'a la Especialidad (Esp.)'
    ],
    [
        'fecha_hora' => '2026-08-14 11:00:00',
        'usuario' => 'Cristian Omar Alcantar López',
        'accion' => 'Registro',
        'descripcion' => 'Instituto Tecnológico de los Mochis'
    ],
    [
        'fecha_hora' => '2026-08-13 17:30:00',
        'usuario' => 'Admin ANFECA',
        'accion' => 'Registro',
        'descripcion' => 'la Coordinación Nacional de Responsabilidad Social Universitaria'
    ]
];

// Limitar a los últimos 6 registros
$bitacora_reciente = array_slice($bitacora_reciente, 0, 6);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">

        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-text">
                <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre'] ?? 'Administrador') ?></h1>
                <p>Sistema de ANFECA - Panel de Control</p>
            </div>
            <div class="welcome-date" id="reloj">
                <i class="fas fa-calendar-alt"></i>
                <span id="fecha_hora"></span>
            </div>
        </section>

        <!-- Stats Grid -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['personas']['total']) ?></h3>
                    <span class="stat-label">Personas</span>
                    <div class="stat-detail">
                        <span><span class="dot" style="background:#2e7d32;"></span> Activas: <?= number_format($stats['personas']['activas']) ?></span>
                        <span><span class="dot" style="background:#c62828;"></span> Inactivas: <?= number_format($stats['personas']['inactivas']) ?></span>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-university"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['instituciones']['total']) ?></h3>
                    <span class="stat-label">Instituciones</span>
                    <div class="stat-detail">
                        <span><span class="dot" style="background:#2e7d32;"></span> Afiliadas: <?= number_format($stats['instituciones']['afiliadas']) ?></span>
                        <span><span class="dot" style="background:#e65100;"></span> Observadoras: <?= number_format($stats['instituciones']['observadoras']) ?></span>
                        <span><span class="dot" style="background:#0d47a1;"></span> Matrices: <?= number_format($stats['instituciones']['matrices']) ?></span>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($stats['cargos']['total']) ?></h3>
                    <span class="stat-label">Cargos</span>
                </div>
            </div>

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
                <a href="bitacora.php" class="btn btn-sm btn-outline">
                    Ver todas <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <?php foreach ($bitacora_reciente as $registro): 
                        $accion = $acciones_map[$registro['accion']] ?? ['verbo' => 'realizó', 'icono' => 'fa-edit'];
                    ?>
                    <div class="activity-item">
                        <div class="activity-icon" style="background: #f5f0f0; color: #8B0000;">
                            <i class="fas <?= $accion['icono'] ?>"></i>
                        </div>
                        <div class="activity-content">
                            <p>
                                <strong><?= htmlspecialchars($registro['usuario']) ?></strong>
                                <span class="verbo-rojo"><?= $accion['verbo'] ?></span>
                                <?= htmlspecialchars($registro['descripcion']) ?>
                            </p>
                            <div class="activity-datetime">
                                <i class="far fa-calendar-alt"></i>
                                <?= date('d/m/Y', strtotime($registro['fecha_hora'])) ?>
                                <i class="far fa-clock" style="margin-left: 0.5rem;"></i>
                                <?= date('H:i', strtotime($registro['fecha_hora'])) ?> hrs
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - BITÁCORA
   ============================================================ */

.activity-item p {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    flex-wrap: wrap;
    margin: 0;
    line-height: 1.6;
}

.verbo-rojo {
    color: #c62828;
    font-weight: 600;
}

.activity-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    background: #f5f0f0;
    color: #8B0000;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}

.activity-item:hover .activity-icon {
    background: #8B0000;
    color: white;
}

@media (max-width: 768px) {
    .activity-item p {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.1rem;
    }
}
</style>

<?php include 'template/footer.php'; ?>