<?php
// ============================================================
// SIDEANFECA - Catálogo de Coordinaciones Nacionales
// Consultar detalle de coordinación
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DE LA COORDINACIÓN
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// ============================================================
// DATOS SIMULADOS
// ============================================================

$coordinaciones = [
    [
        'id' => 1,
        'nombre' => 'Certificación Académica',
        'descripcion' => 'Coordinación de Certificación Académica',
        'orden' => 1,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 2,
        'nombre' => 'Academia ANFECA',
        'descripcion' => 'Coordinación de la Academia ANFECA',
        'orden' => 2,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 3,
        'nombre' => 'Emprendimiento Social',
        'descripcion' => 'Coordinación de Emprendimiento Social',
        'orden' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 4,
        'nombre' => 'Planes y Programas de Estudio',
        'descripcion' => 'Coordinación de Planes y Programas de Estudio',
        'orden' => 4,
        'activo' => true,
        'personas' => 3
    ],
    [
        'id' => 5,
        'nombre' => 'Investigación',
        'descripcion' => 'Coordinación de Investigación',
        'orden' => 5,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 6,
        'nombre' => 'Posgrado',
        'descripcion' => 'Coordinación de Posgrado',
        'orden' => 6,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 7,
        'nombre' => 'Maratones',
        'descripcion' => 'Coordinación de Maratones',
        'orden' => 7,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 8,
        'nombre' => 'Historia',
        'descripcion' => 'Coordinación de Historia',
        'orden' => 8,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 9,
        'nombre' => 'Vinculación Nacional e Internacional',
        'descripcion' => 'Coordinación de Vinculación Nacional e Internacional',
        'orden' => 9,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 10,
        'nombre' => 'Universidad-Empresa',
        'descripcion' => 'Coordinación de Universidad-Empresa',
        'orden' => 10,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 11,
        'nombre' => 'Formación Profesional Académica',
        'descripcion' => 'Coordinación de Formación Profesional Académica',
        'orden' => 11,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 12,
        'nombre' => 'Responsabilidad Social Universitaria',
        'descripcion' => 'Coordinación de Responsabilidad Social Universitaria',
        'orden' => 12,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 13,
        'nombre' => 'Igualdad de Género',
        'descripcion' => 'Coordinación de Igualdad de Género',
        'orden' => 13,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 14,
        'nombre' => 'Desarrollo Académico Estudiantil',
        'descripcion' => 'Coordinación de Desarrollo Académico Estudiantil',
        'orden' => 14,
        'activo' => true,
        'personas' => 0
    ]
];

// Personas asociadas a coordinaciones
$personas_asociadas = [
    1 => [
        ['id' => 1, 'nombre' => 'María González Pérez', 'cargo' => 'Coordinadora Nacional', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 5, 'nombre' => 'Laura Torres Vega', 'cargo' => 'Coordinadora Nacional', 'titular' => false, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
    ],
    2 => [
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'cargo' => 'Coordinador Nacional', 'titular' => true, 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true],
    ],
    4 => [
        ['id' => 4, 'nombre' => 'Ana Sánchez Ramírez', 'cargo' => 'Coordinadora Nacional', 'titular' => true, 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 6, 'nombre' => 'Patricia Flores Reyes', 'cargo' => 'Coordinadora Nacional', 'titular' => false, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 7, 'nombre' => 'Sofía Reyes Gil', 'cargo' => 'Coordinadora Nacional', 'titular' => false, 'fecha_inicio' => '2024-12-01', 'fecha_fin' => null, 'activo' => true],
    ],
    5 => [
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'cargo' => 'Coordinador Nacional', 'titular' => true, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
    ],
    9 => [
        ['id' => 12, 'nombre' => 'Carmen Rivera Morales', 'cargo' => 'Coordinadora Nacional', 'titular' => true, 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null, 'activo' => true],
    ],
    11 => [
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'cargo' => 'Coordinadora Nacional', 'titular' => true, 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 14, 'nombre' => 'Ricardo Peña Fuentes', 'cargo' => 'Coordinador Nacional', 'titular' => false, 'fecha_inicio' => '2023-12-01', 'fecha_fin' => '2024-11-30', 'activo' => false],
    ],
    13 => [
        ['id' => 16, 'nombre' => 'Fernando Cruz Salazar', 'cargo' => 'Coordinador Nacional', 'titular' => true, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
    ]
];

// Buscar la coordinación
$coordinacion = null;
foreach ($coordinaciones as $c) {
    if ($c['id'] == $id) {
        $coordinacion = $c;
        break;
    }
}

if (!$coordinacion) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró la coordinación solicitada.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

$estado_texto = $coordinacion['activo'] ? 'Activo' : 'Inactivo';
$estado_class = $coordinacion['activo'] ? 'status-active' : 'status-inactive';
$personas = $personas_asociadas[$coordinacion['id']] ?? [];
$total_personas = count($personas);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-sitemap"></i>
                </div>
                <div>
                    <h1 class="page-title">Detalle de Coordinación</h1>
                    <p class="page-subtitle">Información completa de la coordinación nacional registrada en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="coordinacion_edicion.php?id=<?= $coordinacion['id'] ?>" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="coordinaciones.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <!-- Tarjeta de información general -->
        <div class="detail-card profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php 
                    $letras = explode(' ', $coordinacion['nombre']);
                    $iniciales = '';
                    foreach ($letras as $l) {
                        if (strlen($l) > 0) {
                            $iniciales .= substr($l, 0, 1);
                        }
                        if (strlen($iniciales) >= 2) break;
                    }
                    ?>
                    <span><?= strtoupper($iniciales) ?></span>
                </div>
                <div class="profile-info">
                    <h2><?= htmlspecialchars($coordinacion['nombre']) ?></h2>
                    <div class="profile-meta">
                        <span class="profile-status <?= $estado_class ?>">
                            <span class="status-dot"></span> <?= $estado_texto ?>
                        </span>
                        <span class="badge-orden">Orden #<?= $coordinacion['orden'] ?></span>
                        <span class="badge-personas <?= $total_personas > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                            <i class="fas fa-users"></i> <?= $total_personas ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="profile-item">
                    <span class="profile-label">Nombre</span>
                    <span class="profile-value"><?= htmlspecialchars($coordinacion['nombre']) ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Descripción</span>
                    <span class="profile-value"><?= htmlspecialchars($coordinacion['descripcion']) ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Orden</span>
                    <span class="profile-value">#<?= $coordinacion['orden'] ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Estado</span>
                    <span class="profile-value <?= $coordinacion['activo'] ? 'text-success' : 'text-danger' ?>">
                        <?= $estado_texto ?>
                    </span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Total de Personas Asignadas</span>
                    <span class="profile-value">
                        <span class="badge-personas <?= $total_personas > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                            <?= $total_personas ?>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Personas Asociadas -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3>Personas Asociadas</h3>
                <span class="detail-badge"><?= $total_personas ?> persona(s)</span>
            </div>
            <div class="detail-card-body">
                <?php if ($total_personas > 0): ?>
                    <div class="table-modern-container">
                        <div class="table-modern-wrapper">
                            <table class="table-modern">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cargo</th>
                                        <th>Titular</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($personas as $persona): 
                                        $fecha_inicio = date('d/m/Y', strtotime($persona['fecha_inicio']));
                                        $fecha_fin = $persona['fecha_fin'] ? date('d/m/Y', strtotime($persona['fecha_fin'])) : '---';
                                        $estado_persona = $persona['activo'] ? 'Activo' : 'Inactivo';
                                        $estado_persona_class = $persona['activo'] ? 'status-active' : 'status-inactive';
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="persona_consulta.php?id=<?= $persona['id'] ?>" class="persona-link">
                                                <?= htmlspecialchars($persona['nombre']) ?>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($persona['cargo']) ?></td>
                                        <td>
                                            <?php if ($persona['titular']): ?>
                                                <span class="badge-titular">Sí</span>
                                            <?php else: ?>
                                                <span class="badge-no-titular">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $fecha_inicio ?></td>
                                        <td><?= $fecha_fin ?></td>
                                        <td>
                                            <span class="<?= $estado_persona_class ?>">
                                                <i class="fas fa-circle"></i> <?= $estado_persona ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-personas">
                        <i class="fas fa-user-times"></i>
                        <p>No hay personas asignadas a esta coordinación</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - CONSULTA COORDINACIÓN
   ============================================================ */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.page-header-content {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.page-header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
}

.page-title {
    font-size: 1.65rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.page-subtitle {
    color: #888;
    margin: 0.1rem 0 0 0;
    font-size: 0.92rem;
}

.page-header-right {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.btn-primary-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.8rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(139, 0, 0, 0.35);
    color: white;
}

.btn-outline-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: #4a4a4a;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-outline-modern:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.detail-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    margin-bottom: 2rem;
}

.detail-card:last-child {
    margin-bottom: 0;
}

.detail-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.detail-card-header h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.detail-badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.8rem;
    background: #f5f0f0;
    color: #666;
    border-radius: 20px;
    font-weight: 600;
}

.profile-card {
    padding: 0;
    overflow: hidden;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 1.75rem;
    background: linear-gradient(135deg, #faf8f8, #f5f0f0);
    border-bottom: 1px solid #f0ecec;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
}

.profile-info {
    flex: 1;
}

.profile-info h2 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.3rem 0;
}

.profile-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.profile-status {
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.profile-status.status-active .status-dot {
    background: #2e7d32;
}

.profile-status.status-inactive .status-dot {
    background: #c62828;
}

.profile-status.status-active {
    color: #2e7d32;
}

.profile-status.status-inactive {
    color: #c62828;
}

.badge-orden {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    background: #e8e0e0;
    color: #4a3a3a;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-personas {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-personas-activo {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-personas-vacio {
    background: #f5f5f5;
    color: #999;
}

.profile-body {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    padding: 1.25rem 1.75rem;
}

.profile-item {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.profile-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #999;
}

.profile-value {
    font-size: 0.95rem;
    font-weight: 500;
    color: #1a1a1a;
}

.text-success {
    color: #2e7d32;
}

.text-danger {
    color: #c62828;
}

.persona-link {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.persona-link:hover {
    color: #0a58ca;
    text-decoration: underline;
}

.table-modern-container {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #f0ecec;
}

.table-modern-wrapper {
    overflow-x: auto;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.table-modern thead {
    background: #faf8f8;
}

.table-modern thead th {
    text-align: left;
    padding: 0.7rem 1rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
}

.table-modern tbody td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

.badge-titular {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: #e8f5e9;
    color: #2e7d32;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-no-titular {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: #f5f5f5;
    color: #999;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-active {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #2e7d32;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-active i {
    font-size: 0.5rem;
}

.status-inactive {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #c62828;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-inactive i {
    font-size: 0.5rem;
}

.empty-personas {
    text-align: center;
    padding: 2rem 0;
}

.empty-personas i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-personas p {
    color: #999;
    margin: 0;
    font-size: 0.95rem;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
    }

    .page-header-content {
        flex-direction: column;
        text-align: center;
    }

    .page-title {
        font-size: 1.4rem;
    }

    .page-header-right {
        flex-direction: column;
        align-items: stretch;
    }

    .page-header-right .btn-primary-modern,
    .page-header-right .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }

    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .profile-body {
        grid-template-columns: 1fr;
        gap: 0.75rem;
        padding: 1rem;
    }

    .detail-card {
        padding: 1.25rem;
    }

    .detail-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.5rem 0.6rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .page-header-icon {
        width: 44px;
        height: 44px;
        font-size: 1.2rem;
    }

    .page-title {
        font-size: 1.2rem;
    }

    .profile-avatar {
        width: 64px;
        height: 64px;
        font-size: 1.4rem;
    }

    .profile-info h2 {
        font-size: 1.1rem;
    }

    .profile-meta {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
}
</style>

<?php include 'template/footer.php'; ?>