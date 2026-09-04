<?php
// ============================================================
// SIDEANFECA - Catálogo de Niveles Académicos
// Consultar detalle de nivel académico
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DEL NIVEL ACADÉMICO
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// ============================================================
// DATOS SIMULADOS
// ============================================================

// Niveles Académicos
$niveles_academicos = [
    [
        'id' => 1,
        'nombre' => 'Licenciatura',
        'abr_m' => 'Lic.',
        'abr_f' => 'Lic.',
        'activo' => true
    ],
    [
        'id' => 2,
        'nombre' => 'Maestría',
        'abr_m' => 'Mtro.',
        'abr_f' => 'Mtra.',
        'activo' => true
    ],
    [
        'id' => 3,
        'nombre' => 'Doctorado',
        'abr_m' => 'Dr.',
        'abr_f' => 'Dra.',
        'activo' => true
    ],
    [
        'id' => 4,
        'nombre' => 'Especialidad',
        'abr_m' => 'Esp.',
        'abr_f' => 'Esp.',
        'activo' => false
    ],
    [
        'id' => 5,
        'nombre' => 'Técnico Superior Universitario',
        'abr_m' => 'T.S.U.',
        'abr_f' => 'T.S.U.',
        'activo' => true
    ],
    [
        'id' => 6,
        'nombre' => 'Ingeniería',
        'abr_m' => 'Ing.',
        'abr_f' => 'Ing.',
        'activo' => true
    ]
];

// Personas asociadas a niveles académicos (simuladas)
$personas_asociadas = [
    1 => [
        ['id' => 1, 'nombre' => 'María González Pérez', 'institucion' => 'UNAM - Facultad de Contaduría', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'institucion' => 'IPN - ESCOM', 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'fecha_inicio' => '2024-02-01', 'fecha_fin' => '2024-12-31', 'activo' => false],
        ['id' => 4, 'nombre' => 'Ana Sánchez Ramírez', 'institucion' => 'UAQ - Querétaro', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 5, 'nombre' => 'Laura Torres Vega', 'institucion' => 'UABC - Mexicali', 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 6, 'nombre' => 'Patricia Flores Reyes', 'institucion' => 'UAEH - Pachuca', 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 7, 'nombre' => 'Sofía Reyes Gil', 'institucion' => 'UAM - Iztapalapa', 'fecha_inicio' => '2024-12-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 8, 'nombre' => 'Gabriela Mendoza Soto', 'institucion' => 'UDG - Guadalajara', 'fecha_inicio' => '2024-08-15', 'fecha_fin' => null, 'activo' => true],
    ],
    2 => [
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'institucion' => 'IPN - ESCOM', 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 9, 'nombre' => 'Luis Méndez Vargas', 'institucion' => 'UABC - Tijuana', 'fecha_inicio' => '2023-06-01', 'fecha_fin' => '2024-05-31', 'activo' => false],
        ['id' => 10, 'nombre' => 'Andrés Moreno Rojas', 'institucion' => 'UANL - San Nicolás', 'fecha_inicio' => '2024-10-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
    ],
    3 => [
        ['id' => 12, 'nombre' => 'Carmen Rivera Morales', 'institucion' => 'UDG - Guadalajara', 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'institucion' => 'UAEM - Toluca', 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
    ],
    6 => [
        ['id' => 14, 'nombre' => 'Ricardo Peña Fuentes', 'institucion' => 'UABJO - Oaxaca', 'fecha_inicio' => '2023-12-01', 'fecha_fin' => '2024-11-30', 'activo' => false],
        ['id' => 15, 'nombre' => 'Elena Castro Ramos', 'institucion' => 'UASLP - San Luis Potosí', 'fecha_inicio' => '2024-09-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 16, 'nombre' => 'Fernando Cruz Salazar', 'institucion' => 'UAQ - Querétaro', 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
    ]
];

// Buscar el nivel académico
$nivel = null;
foreach ($niveles_academicos as $n) {
    if ($n['id'] == $id) {
        $nivel = $n;
        break;
    }
}

if (!$nivel) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró el nivel académico solicitado.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// Obtener datos adicionales
$estado_texto = $nivel['activo'] ? 'Activo' : 'Inactivo';
$estado_class = $nivel['activo'] ? 'status-active' : 'status-inactive';
$personas = $personas_asociadas[$nivel['id']] ?? [];
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
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="page-title">Detalle del Nivel Académico</h1>
                    <p class="page-subtitle">Información completa del nivel académico registrado en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="abrirModalEdicion(<?= $nivel['id'] ?>)" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <a href="niveles_academicos.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <!-- Tarjeta de información general -->
        <div class="detail-card profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php 
                    $letras = explode(' ', $nivel['nombre']);
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
                    <h2><?= htmlspecialchars($nivel['nombre']) ?></h2>
                    <div class="profile-meta">
                        <span class="profile-status <?= $estado_class ?>">
                            <span class="status-dot"></span> <?= $estado_texto ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="profile-item">
                    <span class="profile-label">Abreviatura (Masculino)</span>
                    <span class="profile-value"><?= htmlspecialchars($nivel['abr_m']) ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-label">Abreviatura (Femenino)</span>
                    <span class="profile-value"><?= htmlspecialchars($nivel['abr_f']) ?></span>
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
                                        <th>Institución</th>
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
                                        <td><?= htmlspecialchars($persona['institucion']) ?></td>
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
                        <p>No hay personas asignadas a este nivel académico</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<!-- Modal Edición -->
<div class="modal-overlay" id="modalNivel" style="display:none;">
    <div class="modal-card modal-card-nivel">
        <div class="modal-header">
            <i class="fas fa-edit" id="modalIcon"></i>
            <h3 id="modalTitulo">Editar Nivel Académico</h3>
            <button onclick="cerrarModal()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="niveles_academicos.php" id="formNivel">
            <input type="hidden" name="id_nivel" id="id_nivel" value="0">
            
            <div class="modal-body">
                <div class="form-grid-modal">
                    <div class="form-group">
                        <label class="form-label required">Nombre del Nivel</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Licenciatura" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Abreviatura (Masculino)</label>
                        <input type="text" name="abr_m" id="abr_m" class="form-control" placeholder="Ej. Lic." required>
                        <small class="form-hint">Ejemplo: Lic., Mtro., Dr., etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Abreviatura (Femenino)</label>
                        <input type="text" name="abr_f" id="abr_f" class="form-control" placeholder="Ej. Lic." required>
                        <small class="form-hint">Ejemplo: Lic., Mtra., Dra., etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo" value="1">
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar el nivel en los listados</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-modal-primary" id="btnGuardar">
                    <i class="fas fa-save"></i> Actualizar Nivel
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - CONSULTA NIVEL ACADÉMICO
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

/* ============================================================
   ESTILOS - MODAL EDICIÓN
   ============================================================ */

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

.modal-card-nivel {
    background: white;
    border-radius: 16px;
    max-width: 580px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

.modal-card-nivel .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card-nivel .modal-header i {
    font-size: 1.5rem;
    color: #8B0000;
}

.modal-card-nivel .modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card-nivel .modal-body {
    margin-bottom: 1.5rem;
}

.modal-card-nivel .modal-footer {
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

/* Toggle Switch en modal */
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

.modal-card-nivel .btn-modal-cancel {
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

.modal-card-nivel .btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.modal-card-nivel .btn-modal-primary {
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

.modal-card-nivel .btn-modal-primary:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Responsive */
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

    .modal-card-nivel {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-card-nivel .modal-footer {
        flex-direction: column;
    }

    .modal-card-nivel .modal-footer button {
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
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const nivelesData = <?= json_encode($niveles_academicos) ?>;

// ============================================================
// TOGGLE VISIBILITY
// ============================================================

function toggleVisibility(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (checkbox && !checkbox.disabled) {
        checkbox.checked = !checkbox.checked;
        const event = new Event('change', { bubbles: true });
        checkbox.dispatchEvent(event);
    }
}

// ============================================================
// MODAL - EDICIÓN
// ============================================================

function abrirModalEdicion(id) {
    const nivel = nivelesData.find(n => n.id === id);
    if (!nivel) {
        mostrarMensaje('No se encontró el nivel académico', 'error');
        return;
    }
    
    const modal = document.getElementById('modalNivel');
    const titulo = document.getElementById('modalTitulo');
    const icon = document.getElementById('modalIcon');
    const btnGuardar = document.getElementById('btnGuardar');
    const idNivel = document.getElementById('id_nivel');
    const nombre = document.getElementById('nombre');
    const abrM = document.getElementById('abr_m');
    const abrF = document.getElementById('abr_f');
    const activo = document.getElementById('activo');
    
    titulo.textContent = 'Editar Nivel Académico';
    icon.className = 'fas fa-edit';
    btnGuardar.innerHTML = '<i class="fas fa-save"></i> Actualizar Nivel';
    idNivel.value = nivel.id;
    nombre.value = nivel.nombre;
    abrM.value = nivel.abr_m;
    abrF.value = nivel.abr_f;
    activo.checked = nivel.activo;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => nombre.focus(), 100);
}

function cerrarModal() {
    const modal = document.getElementById('modalNivel');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalNivel');
    if (modal && e.target === modal) {
        cerrarModal();
    }
});

// ============================================================
// MENSAJES FLOTANTES
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