<?php
// ============================================================
// SIDEANFECA - Catálogo de Zonas Regionales
// Consultar detalle de zona
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DE LA ZONA
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// ============================================================
// DATOS SIMULADOS
// ============================================================

// Entidades federativas con su zona correspondiente
$entidades_por_zona = [
    1 => ['Baja California', 'Baja California Sur', 'Chihuahua', 'Sinaloa', 'Sonora'],
    2 => ['Coahuila', 'Nuevo León', 'Tamaulipas'],
    3 => ['Aguascalientes', 'Durango', 'Querétaro', 'San Luis Potosí', 'Zacatecas'],
    4 => ['Colima', 'Guanajuato', 'Jalisco', 'Michoacán', 'Nayarit'],
    5 => ['Guerrero', 'Hidalgo', 'Estado de México', 'Morelos', 'Puebla', 'Tlaxcala'],
    6 => ['Chiapas', 'Oaxaca', 'Tabasco', 'Veracruz', 'Campeche', 'Yucatán', 'Quintana Roo'],
    7 => ['Ciudad de México']
];

// Zonas Regionales
$zonas_regionales = [
    [
        'id' => 1,
        'numero' => 1,
        'nombre' => 'Noroeste',
        'activo' => true,
        'instituciones_asociadas' => [7, 8, 11, 12, 13, 14, 17]
    ],
    [
        'id' => 2,
        'numero' => 2,
        'nombre' => 'Norte',
        'activo' => true,
        'instituciones_asociadas' => [9, 10]
    ],
    [
        'id' => 3,
        'numero' => 3,
        'nombre' => 'Centro',
        'activo' => true,
        'instituciones_asociadas' => [15]
    ],
    [
        'id' => 4,
        'numero' => 4,
        'nombre' => 'Centro Occidente',
        'activo' => true,
        'instituciones_asociadas' => [5, 6]
    ],
    [
        'id' => 5,
        'numero' => 5,
        'nombre' => 'Centro Sur',
        'activo' => true,
        'instituciones_asociadas' => []
    ],
    [
        'id' => 6,
        'numero' => 6,
        'nombre' => 'Sur',
        'activo' => true,
        'instituciones_asociadas' => [16]
    ],
    [
        'id' => 7,
        'numero' => 7,
        'nombre' => 'Ciudad de México',
        'activo' => true,
        'instituciones_asociadas' => [1, 2, 3, 4]
    ]
];

// Instituciones completas
$instituciones = [
    ['id' => 1, 'nombre' => 'Universidad Nacional Autónoma de México', 'personas_relacionadas' => 5],
    ['id' => 2, 'nombre' => 'Facultad de Contaduría y Administración (UNAM)', 'personas_relacionadas' => 3],
    ['id' => 3, 'nombre' => 'Instituto Politécnico Nacional', 'personas_relacionadas' => 2],
    ['id' => 4, 'nombre' => 'ESCOM (IPN)', 'personas_relacionadas' => 2],
    ['id' => 5, 'nombre' => 'Universidad de Guadalajara', 'personas_relacionadas' => 1],
    ['id' => 6, 'nombre' => 'Facultad de Contaduría (UDG)', 'personas_relacionadas' => 1],
    ['id' => 7, 'nombre' => 'Universidad Autónoma de Baja California', 'personas_relacionadas' => 2],
    ['id' => 8, 'nombre' => 'Campus UABC - Mexicali', 'personas_relacionadas' => 1],
    ['id' => 9, 'nombre' => 'Universidad Autónoma de Nuevo León', 'personas_relacionadas' => 0],
    ['id' => 10, 'nombre' => 'Campus UANL - San Nicolás', 'personas_relacionadas' => 0],
    ['id' => 11, 'nombre' => 'Instituto Tecnológico de los Mochis', 'personas_relacionadas' => 1],
    ['id' => 12, 'nombre' => 'Centro de Estudios Superiores del Noroeste', 'personas_relacionadas' => 0],
    ['id' => 13, 'nombre' => 'Instituto de Estudios Superiores de Chihuahua', 'personas_relacionadas' => 1],
    ['id' => 14, 'nombre' => 'Facultad de Ciencias Administrativas (CESUN)', 'personas_relacionadas' => 1],
    ['id' => 15, 'nombre' => 'Universidad Autónoma de Querétaro', 'personas_relacionadas' => 0],
    ['id' => 16, 'nombre' => 'Universidad Autónoma de Yucatán', 'personas_relacionadas' => 0],
    ['id' => 17, 'nombre' => 'Universidad Autónoma de Sinaloa', 'personas_relacionadas' => 1]
];

// Buscar la zona
$zona = null;
foreach ($zonas_regionales as $z) {
    if ($z['id'] == $id) {
        $zona = $z;
        break;
    }
}

if (!$zona) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró la zona regional solicitada.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// Obtener datos adicionales
$estado_texto = $zona['activo'] ? 'Activo' : 'Inactivo';
$estado_class = $zona['activo'] ? 'status-active' : 'status-inactive';
$total_instituciones = count($zona['instituciones_asociadas']);
$entidades = isset($entidades_por_zona[$zona['numero']]) ? $entidades_por_zona[$zona['numero']] : [];
$total_entidades = count($entidades);

// Obtener instituciones asociadas con sus datos completos
$instituciones_asociadas = [];
$total_personas = 0;

foreach ($zona['instituciones_asociadas'] as $id_institucion) {
    foreach ($instituciones as $inst) {
        if ($inst['id'] == $id_institucion) {
            $instituciones_asociadas[] = $inst;
            $total_personas += $inst['personas_relacionadas'];
            break;
        }
    }
}

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h1 class="page-title">Detalle de Zona Regional</h1>
                    <p class="page-subtitle">Información completa de la zona regional registrada en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="zona_edicion.php?id=<?= $zona['id'] ?>" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="zonas_regionales.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <!-- Tarjeta de información general -->
        <div class="detail-card profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <span><?= $zona['numero'] ?></span>
                </div>
                <div class="profile-info">
                    <h2><?= htmlspecialchars($zona['nombre']) ?></h2>
                    <div class="profile-meta">
                        <span class="profile-status <?= $estado_class ?>">
                            <span class="status-dot"></span> <?= $estado_texto ?>
                        </span>
                        <span class="badge-entidades <?= $total_entidades > 0 ? 'badge-entidades-activo' : 'badge-entidades-vacio' ?>">
                             <?= $total_entidades ?> entidades
                        </span>
                        <span class="badge-instituciones <?= $total_instituciones > 0 ? 'badge-instituciones-activo' : 'badge-instituciones-vacio' ?>">
                            <?= $total_instituciones ?> institución(es)
                        </span>
                        <!--<span class="badge-personas <?= $total_personas > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                            <i class="fas fa-users"></i> <?= $total_personas ?> persona(s)
                        </span>-->
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="profile-item">
                    <span class="profile-label">Número de Zona</span>
                    <span class="profile-value"><?= $zona['numero'] ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Nombre</span>
                    <span class="profile-value"><?= htmlspecialchars($zona['nombre']) ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Estado</span>
                    <span class="profile-value <?= $zona['activo'] ? 'text-success' : 'text-danger' ?>">
                        <?= $estado_texto ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Entidades Federativas -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3>Entidades Federativas</h3>
                <span class="detail-badge"><?= $total_entidades ?> entidad(es)</span>
            </div>
            <div class="detail-card-body">
                <?php if ($total_entidades > 0): ?>
                    <div class="entidades-grid">
                        <?php foreach ($entidades as $entidad): ?>
                            <div class="entidad-item">
                                <span><?= htmlspecialchars($entidad) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-entidades">
                        <p>No hay entidades federativas asociadas a esta zona</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Instituciones Asociadas -->
        <div class="detail-card">
            <div class="detail-card-header">
                <h3>Instituciones Asociadas</h3>
                <span class="detail-badge"><?= $total_instituciones ?> institución(es)</span>
            </div>
            <div class="detail-card-body">
                <?php if ($total_instituciones > 0): ?>
                    <div class="table-modern-container">
                        <div class="table-modern-wrapper">
                            <table class="table-modern">
                                <thead>
                                    <tr>
                                        <th>Institución</th>
                                        <th>Personas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($instituciones_asociadas as $inst): ?>
                                    <tr>
                                        <td>
                                            <a href="institucion_consulta.php?id=<?= $inst['id'] ?>" class="institucion-link">
                                                <?= htmlspecialchars($inst['nombre']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge-personas <?= $inst['personas_relacionadas'] > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                                                <?= $inst['personas_relacionadas'] ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-instituciones">
                        <i class="fas fa-university"></i>
                        <p>No hay instituciones asociadas a esta zona regional</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - CONSULTA ZONA
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
    font-size: 2rem;
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

.badge-entidades {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-entidades-activo {
    background: #e3f2fd;
    color: #0d47a1;
}

.badge-entidades-vacio {
    background: #f5f5f5;
    color: #999;
}

.badge-instituciones {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-instituciones-activo {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-instituciones-vacio {
    background: #f5f5f5;
    color: #999;
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

/* Entidades Grid */
.entidades-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 0.75rem;
}

.entidad-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.5rem 0.8rem;
    background: #faf8f8;
    border-radius: 8px;
    border: 1px solid #f0ecec;
    transition: all 0.2s ease;
}

.entidad-item:hover {
    background: #f5edec;
    border-color: #8B0000;
}

.entidad-item i {
    color: #8B0000;
    font-size: 0.9rem;
    width: 16px;
    text-align: center;
}

.entidad-item span {
    font-size: 0.9rem;
    color: #1a1a1a;
}

.empty-entidades {
    text-align: center;
    padding: 2rem 0;
}

.empty-entidades i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-entidades p {
    color: #999;
    margin: 0;
    font-size: 0.95rem;
}

/* Instituciones */
.institucion-link {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.institucion-link:hover {
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

.empty-instituciones {
    text-align: center;
    padding: 2rem 0;
}

.empty-instituciones i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-instituciones p {
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

    .entidades-grid {
        grid-template-columns: 1fr 1fr;
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
        font-size: 1.5rem;
    }

    .profile-info h2 {
        font-size: 1.1rem;
    }

    .profile-meta {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .entidades-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include 'template/footer.php'; ?>