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

// Cargar datos desde sesión
if (!isset($_SESSION['coordinaciones'])) {
    header('Location: coordinaciones_nacionales.php');
    exit;
}

$coordinaciones = $_SESSION['coordinaciones'];

$zonas_regionales = [
    1 => '1 - Noroeste',
    2 => '2 - Norte',
    3 => '3 - Centro',
    4 => '4 - Centro Occidente',
    5 => '5 - Centro Sur',
    6 => '6 - Sur',
    7 => '7 - Ciudad de México'
];

// ============================================================
// PERSONAS ASOCIADAS A COORDINACIONES
// Basado en directorios.php
// ============================================================

$personas_asociadas = [
    // Certificación Académica (id 1 en coordinaciones)
    1 => [
        ['id' => 12, 'nombre' => 'David Roberto Suárez Pacheco', 'cargo' => 'Coordinador Nacional de Certificación Académica', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 26, 'nombre' => 'Leticia María González Velásquez', 'cargo' => 'Coordinador Regional Zona 1 de Certificación Académica', 'zona' => 1, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 27, 'nombre' => 'Patricia Hernández García', 'cargo' => 'Coordinador Regional Zona 3 de Certificación Académica', 'zona' => 3, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 28, 'nombre' => 'Mónica Blanco Jiménez', 'cargo' => 'Coordinador Regional Zona 2 de Certificación Académica', 'zona' => 2, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Academia ANFECA (id 2 en coordinaciones)
    2 => [
        ['id' => 13, 'nombre' => 'José Juan Paz Reyes', 'cargo' => 'Coordinador Nacional de la Academia ANFECA', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Emprendimiento Social (id 3 en coordinaciones)
    3 => [
        ['id' => 14, 'nombre' => 'Mónica Sánchez Limón', 'cargo' => 'Coordinador Nacional de Emprendimiento Social', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Planes y Programas de Estudio (id 4 en coordinaciones)
    4 => [
        ['id' => 15, 'nombre' => 'Lenin Martínez Pérez', 'cargo' => 'Coordinador Nacional de Planes y Programas de Estudio', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Investigación (id 5 en coordinaciones)
    5 => [
        ['id' => 16, 'nombre' => 'Ivett Guillén Morales', 'cargo' => 'Coordinador Nacional de Investigación', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 29, 'nombre' => 'José Sánchez Gutiérrez', 'cargo' => 'Coordinador Regional Zona 4 de Investigación', 'zona' => 4, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Posgrado (id 6 en coordinaciones)
    6 => [
        ['id' => 17, 'nombre' => 'José Ernesto Amorós Espinosa', 'cargo' => 'Coordinador Nacional de Posgrado', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 31, 'nombre' => 'Emigdio Larios Gómez', 'cargo' => 'Coordinador Regional Zona 5 de Posgrado', 'zona' => 5, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Maratones (id 7 en coordinaciones)
    7 => [
        ['id' => 18, 'nombre' => 'Cristina Cabrera Ramos', 'cargo' => 'Coordinador Nacional de Maratones', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Historia (id 8 en coordinaciones)
    8 => [
        ['id' => 19, 'nombre' => 'Aureliano Martínez Castillo', 'cargo' => 'Coordinador Nacional de Historia', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Vinculación Nacional e Internacional (id 9 en coordinaciones)
    9 => [
        ['id' => 20, 'nombre' => 'Juan Antonio Zapata Zapata', 'cargo' => 'Coordinador Nacional de Vinculación Nacional e Internacional', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Universidad-Empresa (id 10 en coordinaciones)
    10 => [
        ['id' => 21, 'nombre' => 'Laura Ofelia Robles Sahagún', 'cargo' => 'Coordinador Nacional de Universidad Empresa', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Formación Profesional Académica (id 11 en coordinaciones)
    11 => [
        ['id' => 22, 'nombre' => 'Cecilia Morales del Río', 'cargo' => 'Coordinador Nacional de Formación Profesional y Académica', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Responsabilidad Social Universitaria (id 12 en coordinaciones)
    12 => [
        ['id' => 23, 'nombre' => 'María Antonieta Monserrat Vera Muñoz', 'cargo' => 'Coordinador Nacional de Responsabilidad Social Universitaria', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 30, 'nombre' => 'Alfonso Martin Rodríguez', 'cargo' => 'Coordinador Regional Zona 3 de Responsabilidad Social Universitaria', 'zona' => 3, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Igualdad de Género (id 13 en coordinaciones)
    13 => [
        ['id' => 24, 'nombre' => 'Lorena Argentina Medina Bocanegra', 'cargo' => 'Coordinador Nacional de Igualdad de Género', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    // Desarrollo Académico Estudiantil (id 14 en coordinaciones)
    14 => [
        ['id' => 25, 'nombre' => 'Idi Amin Germán Silva Jug', 'cargo' => 'Coordinador Nacional de Desarrollo Académico Estudiantil', 'zona' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ]
];

// ============================================================
// OBTENER ID DE LA COORDINACIÓN
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

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
                <button onclick="abrirModalEdicion(<?= $coordinacion['id'] ?>)" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <a href="coordinaciones_nacionales.php" class="btn-outline-modern">
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
                    </div>
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
                                        <th>Zona</th>
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
                                        $zona_texto = $persona['zona'] ? ($zonas_regionales[$persona['zona']] ?? 'Sin zona') : 'Nacional';
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="persona_consulta.php?id=<?= $persona['id'] ?>" class="persona-link">
                                                <?= htmlspecialchars($persona['nombre']) ?>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($persona['cargo']) ?></td>
                                        <td>
                                            <span class="badge-zona <?= $persona['zona'] === null ? 'badge-nacional' : '' ?>">
                                                <?= htmlspecialchars($zona_texto) ?>
                                            </span>
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

<!-- Modal Edición -->
<div class="modal-overlay" id="modalEdicion" style="display:none;">
    <div class="modal-card modal-card-coordinacion">
        <div class="modal-header">
            <i class="fas fa-edit" id="modalIcon"></i>
            <h3 id="modalTitulo">Editar Coordinación</h3>
            <button onclick="cerrarModalEdicion()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="coordinacion_editar.php" id="formEdicion">
            <input type="hidden" name="editar" value="1">
            <input type="hidden" name="id_coordinacion" id="id_coordinacion" value="0">
            
            <div class="modal-body">
                <div class="form-grid-modal">
                    <div class="form-group">
                        <label class="form-label required">Nombre de la Coordinación</label>
                        <input type="text" name="nombre" id="nombre_edicion" class="form-control" placeholder="Ej. Certificación Académica" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <input type="hidden" name="activo" value="0">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo_edicion" value="1" checked>
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo_edicion" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar la coordinación en los listados</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="cerrarModalEdicion()">Cancelar</button>
                <button type="submit" class="btn-modal-primary">
                    <i class="fas fa-save"></i> Actualizar Coordinación
                </button>
            </div>
        </form>
    </div>
</div>

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
    gap: 0.75rem;
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

.badge-zona {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    background: #f0ebeb;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-nacional {
    background: #e3f2fd;
    color: #0d47a1;
    font-weight: 600;
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

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

.modal-card-coordinacion {
    background: white;
    border-radius: 16px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

.modal-card-coordinacion .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card-coordinacion .modal-header i {
    font-size: 1.5rem;
    color: #8B0000;
}

.modal-card-coordinacion .modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card-coordinacion .modal-body {
    margin-bottom: 1.5rem;
}

.modal-card-coordinacion .modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #f5f0f0;
}

.form-grid-modal {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}

.form-grid-modal .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.8rem;
    color: #3a3a3a;
}

.form-label.required::after {
    content: ' *';
    color: #c62828;
}

.form-hint {
    font-size: 0.7rem;
    color: #999;
    margin-top: 0.15rem;
}

.form-control {
    padding: 0.7rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #1a1a1a;
    width: 100%;
}

.form-control:focus {
    outline: none;
    border-color: #8B0000;
    background: white;
    box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
}

.form-control::placeholder {
    color: #bbb;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.4rem 0;
}

.toggle-modern {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 22px;
    cursor: pointer;
}

.toggle-modern input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-modern .toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #ccc;
    transition: 0.3s;
    border-radius: 22px;
}

.toggle-modern .toggle-slider:before {
    content: "";
    position: absolute;
    height: 16px;
    width: 16px;
    left: 3px;
    bottom: 3px;
    background: white;
    transition: 0.3s;
    border-radius: 50%;
}

.toggle-modern input:checked + .toggle-slider {
    background: #8B0000;
}

.toggle-modern input:checked + .toggle-slider:before {
    transform: translateX(18px);
}

.modal-card-coordinacion .btn-modal-cancel {
    padding: 0.6rem 1.5rem;
    background: white;
    color: #4a4a4a;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-card-coordinacion .btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.modal-card-coordinacion .btn-modal-primary {
    padding: 0.6rem 1.8rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-card-coordinacion .btn-modal-primary:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
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

    .modal-card-coordinacion {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-card-coordinacion .modal-footer {
        flex-direction: column;
    }

    .modal-card-coordinacion .modal-footer button {
        width: 100%;
        justify-content: center;
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

    .modal-card-coordinacion {
        padding: 1rem;
        margin: 0.5rem;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const coordinacionesData = <?= json_encode($coordinaciones) ?>;

// ============================================================
// MODAL - EDICIÓN
// ============================================================

function abrirModalEdicion(id) {
    const coord = coordinacionesData.find(c => c.id === id);
    if (!coord) {
        mostrarMensaje('No se encontró la coordinación', 'error');
        return;
    }
    
    const modal = document.getElementById('modalEdicion');
    document.getElementById('id_coordinacion').value = coord.id;
    document.getElementById('nombre_edicion').value = coord.nombre;
    document.getElementById('activo_edicion').checked = coord.activo;
    document.getElementById('modalTitulo').textContent = 'Editar Coordinación';
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('nombre_edicion').focus(), 100);
}

function cerrarModalEdicion() {
    const modal = document.getElementById('modalEdicion');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function toggleVisibility(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (checkbox && !checkbox.disabled) {
        checkbox.checked = !checkbox.checked;
        const event = new Event('change', { bubbles: true });
        checkbox.dispatchEvent(event);
    }
}

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(e) {
    const modalEdicion = document.getElementById('modalEdicion');
    if (e.target === modalEdicion) {
        cerrarModalEdicion();
    }
});

// ============================================================
// MENSAJES
// ============================================================

function mostrarMensaje(mensaje, tipo) {
    const mensajesAnteriores = document.querySelectorAll('.mensaje-flotante');
    mensajesAnteriores.forEach(el => el.remove());
    
    const div = document.createElement('div');
    div.className = `mensaje-flotante ${tipo}`;
    div.innerHTML = `
        <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        <div>
            <strong>${tipo === 'success' ? '¡Éxito!' : '¡Atención!'}</strong> ${mensaje}
        </div>
        <button class="btn-cerrar-mensaje" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(div);
    
    setTimeout(function() {
        if (div.parentElement) {
            div.style.animation = 'slideUpMessage 0.3s ease';
            setTimeout(function() {
                div.remove();
            }, 300);
        }
    }, 4000);
}
</script>

<?php include 'template/footer.php'; ?>