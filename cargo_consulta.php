<?php
// ============================================================
// SIDEANFECA - Catálogo de Cargos
// Consultar detalle de cargo
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS DE REFERENCIA (coinciden con directorios.php)
// ============================================================

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

// ============================================================
// DATOS DE PERSONAS REALES (tomados de directorios.php)
// ============================================================

$personas_reales = [
    1 => ['nombre' => 'Armando Tomé González', 'institucion' => 'Universidad Nacional Autónoma de México', 'cargo' => 'Presidente'],
    2 => ['nombre' => 'Adriana Garza Elizondo', 'institucion' => 'Universidad Autónoma de Nuevo León', 'cargo' => 'Vicepresidenta'],
    3 => ['nombre' => 'Carlos Lobo Sánchez', 'institucion' => 'Universidad Nacional Autónoma de México', 'cargo' => 'Secretario General'],
    4 => ['nombre' => 'Lourdes Mata Romero', 'institucion' => 'Universidad Nacional Autónoma de México', 'cargo' => 'Directora Ejecutiva'],
    5 => ['nombre' => 'Leobardo Berrelleza Reyes', 'institucion' => 'Universidad Autónoma de Sinaloa', 'cargo' => 'Director Regional Zona 1'],
    6 => ['nombre' => 'Laura María del Pilar Macías Amozurrutia', 'institucion' => 'Universidad Iberoamericana Torreón', 'cargo' => 'Directora Regional Zona 2'],
    7 => ['nombre' => 'Ismael Manuel Rodríguez Herrera', 'institucion' => 'Universidad Autónoma de Aguascalientes', 'cargo' => 'Director Regional Zona 3'],
    8 => ['nombre' => 'Cristian Omar Alcantar López', 'institucion' => 'Universidad de Guadalajara', 'cargo' => 'Director Regional Zona 4'],
    9 => ['nombre' => 'Mario Franz Subieta Zecua', 'institucion' => 'Universidad Autónoma de Tlaxcala', 'cargo' => 'Director Regional Zona 5'],
    10 => ['nombre' => 'Anabel Galván Sarabia', 'institucion' => 'Universidad Veracruzana', 'cargo' => 'Directora Regional Zona 6'],
    11 => ['nombre' => 'Giannina Sampieri Laguna', 'institucion' => 'Universidad Intercontinental', 'cargo' => 'Directora Regional Zona 7'],
    12 => ['nombre' => 'David Roberto Suárez Pacheco', 'institucion' => 'Universidad Autónoma de Yucatán', 'cargo' => 'Coordinador Nacional de Certificación Académica'],
    13 => ['nombre' => 'José Juan Paz Reyes', 'institucion' => 'Universidad Juárez Autónoma de Tabasco', 'cargo' => 'Coordinador Nacional de la Academia ANFECA'],
    14 => ['nombre' => 'Mónica Sánchez Limón', 'institucion' => 'Universidad Autónoma de Tamaulipas', 'cargo' => 'Coordinador Nacional de Emprendimiento Social'],
    15 => ['nombre' => 'Lenin Martínez Pérez', 'institucion' => 'Universidad Tecnológica de Tabasco', 'cargo' => 'Coordinador Nacional de Planes y Programas de Estudio'],
    16 => ['nombre' => 'Ivett Guillén Morales', 'institucion' => 'Instituto Politécnico Nacional', 'cargo' => 'Coordinador Nacional de Investigación'],
    17 => ['nombre' => 'José Ernesto Amorós Espinosa', 'institucion' => 'Tecnológico de Monterrey', 'cargo' => 'Coordinador Nacional de Posgrado'],
    18 => ['nombre' => 'Cristina Cabrera Ramos', 'institucion' => 'Universidad Autónoma de Chihuahua', 'cargo' => 'Coordinador Nacional de Maratones'],
    19 => ['nombre' => 'Aureliano Martínez Castillo', 'institucion' => 'Universidad Autónoma de Yucatán', 'cargo' => 'Coordinador Nacional de Historia'],
    20 => ['nombre' => 'Juan Antonio Zapata Zapata', 'institucion' => 'Universidad Autónoma de San Luis Potosí', 'cargo' => 'Coordinador Nacional de Vinculación Nacional e Internacional'],
    21 => ['nombre' => 'Laura Ofelia Robles Sahagún', 'institucion' => 'Universidad del Valle de Atemajac', 'cargo' => 'Coordinador Nacional de Universidad Empresa'],
    22 => ['nombre' => 'Cecilia Morales del Río', 'institucion' => 'Universidad de Monterrey', 'cargo' => 'Coordinador Nacional de Formación Profesional y Académica'],
    23 => ['nombre' => 'María Antonieta Monserrat Vera Muñoz', 'institucion' => 'Benemérita Universidad Autónoma de Puebla', 'cargo' => 'Coordinador Nacional de Responsabilidad Social Universitaria'],
    24 => ['nombre' => 'Lorena Argentina Medina Bocanegra', 'institucion' => 'Universidad Autónoma de Coahuila', 'cargo' => 'Coordinador Nacional de Igualdad de Género'],
    25 => ['nombre' => 'Idi Amin Germán Silva Jug', 'institucion' => 'Universidad Autónoma de Nayarit', 'cargo' => 'Coordinador Nacional de Desarrollo Académico Estudiantil'],
    26 => ['nombre' => 'Leticia María González Velásquez', 'institucion' => 'Universidad de Sonora', 'cargo' => 'Coordinador Regional Zona 1 de Certificación Académica'],
    27 => ['nombre' => 'Patricia Hernández García', 'institucion' => 'Universidad Autónoma de San Luis Potosí', 'cargo' => 'Coordinador Regional Zona 3 de Certificación Académica'],
    28 => ['nombre' => 'Mónica Blanco Jiménez', 'institucion' => 'Universidad Autónoma de Nuevo León', 'cargo' => 'Coordinador Regional Zona 2 de Certificación Académica'],
    29 => ['nombre' => 'José Sánchez Gutiérrez', 'institucion' => 'Universidad de Guadalajara', 'cargo' => 'Coordinador Regional Zona 4 de Investigación'],
    30 => ['nombre' => 'Alfonso Martin Rodríguez', 'institucion' => 'Universidad Autónoma de Aguascalientes', 'cargo' => 'Coordinador Regional Zona 3 de Responsabilidad Social Universitaria'],
    31 => ['nombre' => 'Emigdio Larios Gómez', 'institucion' => 'Benemérita Universidad Autónoma de Puebla', 'cargo' => 'Coordinador Regional Zona 5 de Posgrado'],
    32 => ['nombre' => 'Cristian Omar Alcantar López', 'institucion' => 'Universidad de Guadalajara', 'cargo' => 'Director de División'],
    33 => ['nombre' => 'Luis Edmundo Garrido Sánchez', 'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente', 'cargo' => 'Jefe de Departamento'],
    34 => ['nombre' => 'Maria Margarita Villareal Treviño', 'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente', 'cargo' => 'Directora'],
    35 => ['nombre' => 'Esmeralda Brito Cervantes', 'institucion' => 'Universidad Autónoma de Guadalajara', 'cargo' => 'Directora del Programa de Administración'],
    36 => ['nombre' => 'Nadia Natasha Reus González', 'institucion' => 'Universidad de Guadalajara', 'cargo' => 'Secretario de la División de Ciencias Sociales y de la Cultura'],
    37 => ['nombre' => 'Salvador Cervantes Cervantes', 'institucion' => 'Universidad del Valle de Atemajac', 'cargo' => 'Director General Académico'],
    38 => ['nombre' => 'María Guadalupe Jiménez Hernández', 'institucion' => 'Universidad del Valle de Atemajac', 'cargo' => 'Director General de Plantel']
];

// ============================================================
// DATOS DE CARGOS (con personas asociadas reales)
// ============================================================

$cargos = [
    [
        'id' => 1,
        'nombre_m' => 'Presidente',
        'nombre_f' => 'Presidenta',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [1]
    ],
    [
        'id' => 2,
        'nombre_m' => 'Vicepresidente',
        'nombre_f' => 'Vicepresidenta',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [2]
    ],
    [
        'id' => 3,
        'nombre_m' => 'Secretario General',
        'nombre_f' => 'Secretaria General',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [3]
    ],
    [
        'id' => 4,
        'nombre_m' => 'Director Ejecutivo',
        'nombre_f' => 'Directora Ejecutiva',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [4]
    ],
    [
        'id' => 5,
        'nombre_m' => 'Director Regional',
        'nombre_f' => 'Directora Regional',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 7,
        'personas_ids' => [5, 6, 7, 8, 9, 10, 11]
    ],
    [
        'id' => 6,
        'nombre_m' => 'Coordinador Nacional',
        'nombre_f' => 'Coordinadora Nacional',
        'id_nivel' => 2,
        'activo' => true,
        'personas' => 14,
        'personas_ids' => [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25]
    ],
    [
        'id' => 7,
        'nombre_m' => 'Coordinador Regional',
        'nombre_f' => 'Coordinadora Regional',
        'id_nivel' => 2,
        'activo' => true,
        'personas' => 6,
        'personas_ids' => [26, 27, 28, 29, 30, 31]
    ],
    [
        'id' => 8,
        'nombre_m' => 'Director de División',
        'nombre_f' => 'Directora de División',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [32]
    ],
    [
        'id' => 9,
        'nombre_m' => 'Jefe de Departamento',
        'nombre_f' => 'Jefa de Departamento',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [33]
    ],
    [
        'id' => 10,
        'nombre_m' => 'Director',
        'nombre_f' => 'Directora',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [34]
    ],
    [
        'id' => 11,
        'nombre_m' => 'Director de Programa',
        'nombre_f' => 'Directora de Programa',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [35]
    ],
    [
        'id' => 12,
        'nombre_m' => 'Secretario de División',
        'nombre_f' => 'Secretaria de División',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [36]
    ],
    [
        'id' => 13,
        'nombre_m' => 'Director General Académico',
        'nombre_f' => 'Directora General Académica',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [37]
    ],
    [
        'id' => 14,
        'nombre_m' => 'Director General de Plantel',
        'nombre_f' => 'Directora General de Plantel',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1,
        'personas_ids' => [38]
    ],
    [
        'id' => 15,
        'nombre_m' => 'Representante ANFECA ante ALAFEC',
        'nombre_f' => 'Representante ANFECA ante ALAFEC',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 0,
        'personas_ids' => []
    ],
    [
        'id' => 16,
        'nombre_m' => 'Director General CACECA',
        'nombre_f' => 'Directora General CACECA',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 0,
        'personas_ids' => []
    ]
];

// ============================================================
// OBTENER ID DEL CARGO
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Buscar el cargo
$cargo = null;
foreach ($cargos as $c) {
    if ($c['id'] == $id) {
        $cargo = $c;
        break;
    }
}

if (!$cargo) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró el cargo solicitado.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// Obtener personas asociadas reales
$personas_asociadas = [];
foreach ($cargo['personas_ids'] as $id_persona) {
    if (isset($personas_reales[$id_persona])) {
        $personas_asociadas[] = [
            'id' => $id_persona,
            'nombre' => $personas_reales[$id_persona]['nombre'],
            'institucion' => $personas_reales[$id_persona]['institucion'],
            'cargo' => $personas_reales[$id_persona]['cargo'],
            'fecha_inicio' => '2024-01-01',
            'fecha_fin' => null,
            'activo' => true
        ];
    }
}

// Obtener datos adicionales
$nivel_nombre = $niveles_cargo[$cargo['id_nivel']] ?? 'Sin nivel';
$estado_texto = $cargo['activo'] ? 'Activo' : 'Inactivo';
$estado_class = $cargo['activo'] ? 'status-active' : 'status-inactive';
$total_personas = count($personas_asociadas);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <h1 class="page-title">Detalle del Cargo</h1>
                    <p class="page-subtitle">Información completa del cargo registrado en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="abrirModalEdicion(<?= $cargo['id'] ?>)" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <a href="cargos.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <!-- Tarjeta de información general -->
        <div class="detail-card profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php 
                    $letras = explode(' ', $cargo['nombre_m']);
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
                    <h2><?= htmlspecialchars($cargo['nombre_m']) ?> / <?= htmlspecialchars($cargo['nombre_f']) ?></h2>
                    <div class="profile-meta">
                        <span class="profile-status <?= $cargo['activo'] ? 'status-active' : 'status-inactive' ?>">
                            <span class="status-dot"></span> <?= $estado_texto ?>
                        </span>
                        <span class="badge-nivel 
                            <?= $cargo['id_nivel'] == 1 ? 'badge-nacional' : '' ?>
                            <?= $cargo['id_nivel'] == 2 ? 'badge-regional' : '' ?>
                            <?= $cargo['id_nivel'] == 3 ? 'badge-institucional' : '' ?>">
                            <?= htmlspecialchars($nivel_nombre) ?>
                        </span>
                        <span class="badge-personas <?= $total_personas > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                            <i class="fas fa-users"></i> <?= $total_personas ?>
                        </span>
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
                                        <th>Institución</th>
                                        <th>Cargo</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($personas_asociadas as $persona): 
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
                                        <td><?= htmlspecialchars($persona['cargo']) ?></td>
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
                        <p>No hay personas asignadas con este cargo</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<!-- Modal Edición -->
<div class="modal-overlay" id="modalCargo" style="display:none;">
    <div class="modal-card modal-card-cargo">
        <div class="modal-header">
            <i class="fas fa-edit" id="modalIcon"></i>
            <h3 id="modalTitulo">Editar Cargo</h3>
            <button onclick="cerrarModal()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="cargos.php" id="formCargo">
            <input type="hidden" name="id_cargo" id="id_cargo" value="0">
            
            <div class="modal-body">
                <div class="form-grid-modal">
                    <div class="form-group">
                        <label class="form-label required">Nombre (Masculino)</label>
                        <input type="text" name="nombre_m" id="nombre_m" class="form-control" placeholder="Ej. Presidente" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Nombre (Femenino)</label>
                        <input type="text" name="nombre_f" id="nombre_f" class="form-control" placeholder="Ej. Presidenta" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Nivel de Cargo</label>
                        <select name="id_nivel" id="id_nivel" class="form-control" required>
                            <option value="">Seleccionar nivel...</option>
                            <?php foreach ($niveles_cargo as $id_nivel => $nombre): ?>
                                <option value="<?= $id_nivel ?>"><?= htmlspecialchars($nombre) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo" value="1" checked>
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar el cargo en los listados</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-modal-primary" id="btnGuardar">
                    <i class="fas fa-save"></i> Actualizar Cargo
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - CONSULTA CARGO
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

.badge-nivel {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-nacional {
    background: #e3f2fd;
    color: #0d47a1;
}

.badge-regional {
    background: #f3e5f5;
    color: #6a1b9a;
}

.badge-institucional {
    background: #e8f5e9;
    color: #1b5e20;
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

.modal-card-cargo {
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

.modal-card-cargo .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card-cargo .modal-header i {
    font-size: 1.5rem;
    color: #8B0000;
}

.modal-card-cargo .modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card-cargo .modal-body {
    margin-bottom: 1.5rem;
}

.modal-card-cargo .modal-footer {
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

.btn-modal-cancel {
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

.btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.btn-modal-primary {
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

.btn-modal-primary:hover {
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

    .modal-card-cargo {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-card-cargo .modal-footer {
        flex-direction: column;
    }

    .modal-card-cargo .modal-footer button {
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

const nivelesCargo = <?= json_encode($niveles_cargo) ?>;
const cargosData = <?= json_encode($cargos) ?>;

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
    const cargo = cargosData.find(c => c.id === id);
    if (!cargo) {
        mostrarMensaje('No se encontró el cargo', 'error');
        return;
    }
    
    const modal = document.getElementById('modalCargo');
    const titulo = document.getElementById('modalTitulo');
    const icon = document.getElementById('modalIcon');
    const btnGuardar = document.getElementById('btnGuardar');
    const idCargo = document.getElementById('id_cargo');
    const nombreM = document.getElementById('nombre_m');
    const nombreF = document.getElementById('nombre_f');
    const idNivel = document.getElementById('id_nivel');
    const activo = document.getElementById('activo');
    
    titulo.textContent = 'Editar Cargo';
    icon.className = 'fas fa-edit';
    btnGuardar.innerHTML = '<i class="fas fa-save"></i> Actualizar Cargo';
    idCargo.value = cargo.id;
    nombreM.value = cargo.nombre_m;
    nombreF.value = cargo.nombre_f;
    idNivel.value = cargo.id_nivel;
    activo.checked = cargo.activo;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => nombreM.focus(), 100);
}

function cerrarModal() {
    const modal = document.getElementById('modalCargo');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalCargo');
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