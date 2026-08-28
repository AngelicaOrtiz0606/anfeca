<?php
// ============================================================
// SIDEANFECA - Gestión de Personas
// Listado de personas registradas
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS PARA DEMOSTRACIÓN
// ============================================================

$zonas_regionales = [
    1 => 'Noroeste',
    2 => 'Norte',
    3 => 'Centro',
    4 => 'Centro Occidente',
    5 => 'Centro Sur',
    6 => 'Sur',
    7 => 'Ciudad de México'
];

// Personas simuladas (sin estado activo/inactivo)
$personas = [
    [
        'id' => 1,
        'num_afiliacion' => '9801001',
        'nombre' => 'María',
        'apellido_paterno' => 'González',
        'apellido_materno' => 'Pérez',
        'genero' => 'F',
        'id_zona' => 7,
        'institucion' => 'UNAM - Facultad de Contaduría',
        'cargo' => 'Presidenta',
        'correo' => 'maria.gonzalez@example.com',
        'telefono' => '55 1234 5678',
        'directorios' => ['Consejo Nacional Directivo', 'Coordinaciones Nacionales']
    ],
    [
        'id' => 2,
        'num_afiliacion' => '9801002',
        'nombre' => 'Juan',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'id_zona' => 7,
        'institucion' => 'IPN - ESCOM',
        'cargo' => 'Coordinador Nacional',
        'correo' => 'juan.martinez@example.com',
        'telefono' => '55 9876 5432',
        'directorios' => ['Consejo Nacional Directivo']
    ],
    [
        'id' => 3,
        'num_afiliacion' => '9801003',
        'nombre' => 'Ana',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Ramírez',
        'genero' => 'F',
        'id_zona' => 3,
        'institucion' => 'UAQ - Querétaro',
        'cargo' => 'Secretaria General',
        'correo' => 'ana.sanchez@example.com',
        'telefono' => '44 1234 5678',
        'directorios' => ['Consejos Regionales']
    ],
    [
        'id' => 4,
        'num_afiliacion' => '9801004',
        'nombre' => 'Carlos',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'Díaz',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'UDG - Guadalajara',
        'cargo' => 'Director Regional',
        'correo' => 'carlos.hernandez@example.com',
        'telefono' => '33 1234 5678',
        'directorios' => ['Consejos Regionales']
    ],
    [
        'id' => 5,
        'num_afiliacion' => '9801005',
        'nombre' => 'Laura',
        'apellido_paterno' => 'Torres',
        'apellido_materno' => 'Vega',
        'genero' => 'F',
        'id_zona' => 1,
        'institucion' => 'UABC - Mexicali',
        'cargo' => 'Coordinadora Regional',
        'correo' => 'laura.torres@example.com',
        'telefono' => '66 1234 5678',
        'directorios' => ['Coordinaciones Nacionales']
    ],
    [
        'id' => 6,
        'num_afiliacion' => '9801006',
        'nombre' => 'Roberto',
        'apellido_paterno' => 'Mendoza',
        'apellido_materno' => 'Cruz',
        'genero' => 'M',
        'id_zona' => 2,
        'institucion' => 'UANL - San Nicolás',
        'cargo' => 'Secretario Regional',
        'correo' => 'roberto.mendoza@example.com',
        'telefono' => '81 1234 5678',
        'directorios' => ['Instituciones']
    ],
    [
        'id' => 7,
        'num_afiliacion' => '9801007',
        'nombre' => 'Patricia',
        'apellido_paterno' => 'Flores',
        'apellido_materno' => 'Reyes',
        'genero' => 'F',
        'id_zona' => 5,
        'institucion' => 'UAEH - Pachuca',
        'cargo' => 'Coordinadora Regional',
        'correo' => 'patricia.flores@example.com',
        'telefono' => '77 1234 5678',
        'directorios' => ['Coordinaciones Nacionales', 'Instituciones']
    ]
];

// Procesar filtros
$zona_filtro = isset($_GET['zona']) ? (int)$_GET['zona'] : 0;
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'asc';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$personas_filtradas = $personas;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $personas_filtradas = array_filter($personas_filtradas, function($p) use ($busqueda) {
        $nombre_completo = strtolower($p['nombre'] . ' ' . $p['apellido_paterno'] . ' ' . $p['apellido_materno']);
        return strpos($nombre_completo, $busqueda) !== false || 
               strpos(strtolower($p['institucion']), $busqueda) !== false ||
               strpos(strtolower($p['cargo']), $busqueda) !== false ||
               strpos(strtolower($p['correo']), $busqueda) !== false ||
               strpos(strtolower($p['num_afiliacion']), $busqueda) !== false;
    });
}

if ($zona_filtro > 0) {
    $personas_filtradas = array_filter($personas_filtradas, function($p) use ($zona_filtro) {
        return $p['id_zona'] == $zona_filtro;
    });
}

// Ordenar
usort($personas_filtradas, function($a, $b) use ($orden) {
    $nombre_a = $a['nombre'] . ' ' . $a['apellido_paterno'] . ' ' . $a['apellido_materno'];
    $nombre_b = $b['nombre'] . ' ' . $b['apellido_paterno'] . ' ' . $b['apellido_materno'];
    
    if ($orden == 'asc') {
        return strcmp($nombre_a, $nombre_b);
    } else {
        return strcmp($nombre_b, $nombre_a);
    }
});

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h1 class="page-title">Gestión de Personas</h1>
                    <p class="page-subtitle">Administre las personas registradas en el sistema de directorios</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <button onclick="descargarCorreos()" class="btn-outline-modern">
                    <i class="fas fa-envelope"></i> Exportar Correos
                </button>
                <a href="persona_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nueva Persona
                </a>
            </div>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar por nombre, institución, cargo, correo o afiliación..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarPersona">
                    </div>
                    
                    <div class="filter-group">
                        <select name="zona" class="filter-select" id="filtroZona">
                            <option value="0">Todas las zonas</option>
                            <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $zona_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <select name="orden" class="filter-select" id="filtroOrden">
                            <option value="asc" <?= $orden == 'asc' ? 'selected' : '' ?>>A - Z</option>
                            <option value="desc" <?= $orden == 'desc' ? 'selected' : '' ?>>Z - A</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-filter-apply">
                        <i class="fas fa-sliders-h"></i> Aplicar
                    </button>
                    
                    <?php if (!empty($busqueda) || $zona_filtro > 0): ?>
                        <a href="personas.php" class="btn-filter-clear">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-users"></i> 
                    <strong id="registrosMostrados"><?= count($personas_filtradas) ?></strong> 
                    persona(s) encontrada(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaPersonas">
                    <thead>
                        <tr>
                            <th>Núm. Afiliación</th>
                            <th>Nombre</th>
                            <th>Institución</th>
                            <th>Zona</th>
                            <th>Cargo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyPersonas">
                        <?php if (count($personas_filtradas) > 0): ?>
                            <?php foreach ($personas_filtradas as $persona): 
                                $nombre_completo = $persona['nombre'] . ' ' . $persona['apellido_paterno'];
                                if (!empty($persona['apellido_materno'])) {
                                    $nombre_completo .= ' ' . $persona['apellido_materno'];
                                }
                                $zona_nombre = $zonas_regionales[$persona['id_zona']] ?? 'Sin zona';
                            ?>
                            <tr data-id="<?= $persona['id'] ?>">
                                <td><span class="badge-afiliacion"><?= htmlspecialchars($persona['num_afiliacion']) ?></span></td>
                                <td>
                                    <div class="persona-cell">
                                        <div class="persona-nombre"><?= htmlspecialchars($nombre_completo) ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($persona['institucion']) ?></td>
                                <td><span class="badge-zona"><?= htmlspecialchars($zona_nombre) ?></span></td>
                                <td><?= htmlspecialchars($persona['cargo']) ?></td>
                                <td><a href="mailto:<?= htmlspecialchars($persona['correo']) ?>" class="correo-link"><?= htmlspecialchars($persona['correo']) ?></a></td>
                                <td><?= htmlspecialchars($persona['telefono']) ?></td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="persona_consulta.php?id=<?= $persona['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="persona_edicion.php?id=<?= $persona['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button onclick="eliminarPersona(<?= $persona['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="empty-row">
                                    <i class="fas fa-search"></i>
                                    <p>No se encontraron personas con los filtros aplicados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-modern-footer">
                <span>Mostrando <strong><?= count($personas_filtradas) ?></strong> de <strong><?= count($personas) ?></strong> registros</span>
            </div>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS MODERNOS - LISTADO
   ============================================================ */

/* Page Header */
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
    flex-wrap: wrap;
}

/* Botones */
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

/* Filtros */
.filters-container {
    background: white;
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.75rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.filters-form {
    width: 100%;
}

.filters-row {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
}

.filter-group {
    position: relative;
    flex: 1;
    min-width: 160px;
}

.filter-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #8B0000;
    font-size: 0.9rem;
    opacity: 0.5;
}

.filter-input {
    width: 100%;
    padding: 0.6rem 1rem 0.6rem 3rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #1a1a1a;
}

.filter-input:focus {
    outline: none;
    border-color: #8B0000;
    background: white;
    box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
}

.filter-select {
    width: 100%;
    padding: 0.6rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #1a1a1a;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b6b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
}

.filter-select:focus {
    outline: none;
    border-color: #8B0000;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
}

.btn-filter-apply {
    padding: 0.6rem 1.25rem;
    background: #8B0000;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-filter-apply:hover {
    background: #5C0000;
    transform: translateY(-1px);
}

.btn-filter-clear {
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #6b6b6b;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    white-space: nowrap;
}

.btn-filter-clear:hover {
    border-color: #c62828;
    color: #c62828;
}

.filters-results {
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px solid #f0f0f0;
}

.results-count {
    font-size: 0.85rem;
    color: #6b6b6b;
}

.results-count i {
    color: #8B0000;
    margin-right: 0.3rem;
}

/* Tabla moderna */
.table-modern-container {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    overflow: hidden;
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
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 1rem 1.25rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
}

.table-modern tbody td {
    padding: 0.9rem 1.25rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

/* Persona cell */
.persona-cell {
    display: flex;
    align-items: center;
}

.persona-nombre {
    font-weight: 600;
    color: #1a1a1a;
}

/* Badges */
.badge-afiliacion {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    background: #e8e0e0;
    color: #4a3a3a;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: monospace;
}

.badge-zona {
    display: inline-block;
    padding: 0.25rem 0.9rem;
    background: #f0ebeb;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Correo link */
.correo-link {
    color: #0d6efd;
    text-decoration: none;
    font-size: 0.85rem;
}

.correo-link:hover {
    text-decoration: underline;
}

/* Acciones */
.acciones-group {
    display: flex;
    gap: 0.35rem;
    flex-wrap: wrap;
}

.btn-accion {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
}

.btn-ver {
    background: #f0f7fa;
    color: #0d6efd;
}

.btn-ver:hover {
    background: #0d6efd;
    color: white;
}

.btn-editar {
    background: #f5edec;
    color: #8B0000;
}

.btn-editar:hover {
    background: #8B0000;
    color: white;
}

.btn-eliminar {
    background: #fce8e8;
    color: #dc3545;
}

.btn-eliminar:hover {
    background: #dc3545;
    color: white;
}

/* Empty row */
.empty-row {
    text-align: center;
    padding: 3rem 0;
}

.empty-row i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-row p {
    color: #999;
    margin: 0;
    font-size: 0.95rem;
}

/* Table footer */
.table-modern-footer {
    padding: 0.9rem 1.25rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    font-size: 0.85rem;
    color: #6b6b6b;
}

/* Modal de confirmación */
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

.modal-card {
    background: white;
    border-radius: 16px;
    max-width: 650px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

.modal-card .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card .modal-header i {
    font-size: 1.5rem;
    color: #dc3545;
}

.modal-card .modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card .modal-body {
    margin-bottom: 1.5rem;
}

.modal-card .modal-body p {
    color: #4a4a4a;
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.modal-card .modal-body .persona-info {
    background: #faf8f8;
    padding: 1rem;
    border-radius: 10px;
    border: 1px solid #f0ecec;
    margin: 0.75rem 0;
}

.modal-card .modal-body .persona-info .info-item {
    display: flex;
    padding: 0.3rem 0;
    border-bottom: 1px solid #f0ecec;
}

.modal-card .modal-body .persona-info .info-item:last-child {
    border-bottom: none;
}

.modal-card .modal-body .persona-info .info-label {
    font-weight: 600;
    color: #666;
    width: 140px;
    flex-shrink: 0;
}

.modal-card .modal-body .persona-info .info-value {
    color: #1a1a1a;
}

.modal-card .modal-body .persona-info .info-value .tag-directorio-modal {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    font-size: 0.7rem;
    color: #666;
    margin: 0.1rem 0.2rem;
}

.modal-card .modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #f5f0f0;
}

.modal-card .btn-modal-cancel {
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

.modal-card .btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.modal-card .btn-modal-danger {
    padding: 0.6rem 1.5rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-card .btn-modal-danger:hover {
    background: #c62828;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideDown {
    from { transform: translateX(-50%) translateY(-20px); opacity: 0; }
    to { transform: translateX(-50%) translateY(0); opacity: 1; }
}

@keyframes slideUpMessage {
    from { transform: translateX(-50%) translateY(0); opacity: 1; }
    to { transform: translateX(-50%) translateY(-20px); opacity: 0; }
}

/* Mensajes flotantes */
.mensaje-flotante {
    position: fixed;
    top: 90px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9998;
    max-width: 600px;
    width: 90%;
    animation: slideDown 0.4s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.mensaje-flotante.success {
    background: #f0f7f0;
    color: #1a5a1a;
    border-left: 4px solid #2e7d32;
}

.mensaje-flotante.success i {
    color: #2e7d32;
}

.mensaje-flotante.error {
    background: #fdf0f0;
    color: #7a1a1a;
    border-left: 4px solid #c62828;
}

.mensaje-flotante.error i {
    color: #c62828;
}

.mensaje-flotante i {
    font-size: 1.25rem;
}

.mensaje-flotante .btn-cerrar-mensaje {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: auto;
    padding: 0 0.25rem;
}

.mensaje-flotante.success .btn-cerrar-mensaje {
    color: #1a5a1a;
}

.mensaje-flotante.error .btn-cerrar-mensaje {
    color: #7a1a1a;
}

/* Responsive */
@media (max-width: 992px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: auto;
    }

    .btn-filter-apply,
    .btn-filter-clear {
        width: 100%;
        justify-content: center;
    }
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

    .filters-container {
        padding: 1rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.7rem 0.75rem;
        font-size: 0.8rem;
    }

    .btn-accion {
        width: 30px;
        height: 30px;
        font-size: 0.7rem;
    }

    .modal-card {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-card .modal-body .persona-info .info-item {
        flex-direction: column;
        padding: 0.5rem 0;
    }

    .modal-card .modal-body .persona-info .info-label {
        width: auto;
        font-size: 0.8rem;
    }
}
</style>

<script>
// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarPersona');
    const filtroZona = document.getElementById('filtroZona');
    const filtroOrden = document.getElementById('filtroOrden');
    const formFiltros = document.getElementById('formFiltros');
    
    let timeoutId = null;
    
    buscarInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            formFiltros.submit();
        }, 400);
    });
    
    filtroZona.addEventListener('change', function() {
        formFiltros.submit();
    });
    
    filtroOrden.addEventListener('change', function() {
        formFiltros.submit();
    });
});

// ============================================================
// DATOS DE PERSONAS (para modal)
// ============================================================

const personasData = <?= json_encode($personas) ?>;

// ============================================================
// ELIMINAR PERSONA (CON MODAL)
// ============================================================

function eliminarPersona(id) {
    const persona = personasData.find(p => p.id === id);
    if (!persona) {
        mostrarMensaje('No se encontró la persona', 'error');
        return;
    }
    
    const nombreCompleto = persona.nombre + ' ' + persona.apellido_paterno + ' ' + (persona.apellido_materno || '');
    const zonaNombre = <?= json_encode($zonas_regionales) ?>[persona.id_zona] || 'Sin zona';
    const directorios = persona.directorios || ['Sin directorios'];
    
    // Crear modal
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = 'modalEliminar';
    modal.innerHTML = `
        <div class="modal-card">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>¿Eliminar persona?</h3>
            </div>
            <div class="modal-body">
                <p><strong>¡Advertencia!</strong> Esta acción eliminará por completo el registro de la persona. Esta operación <strong>no se puede deshacer</strong>.</p>
                
                <div class="persona-info">
                    <div class="info-item">
                        <span class="info-label">Núm. Afiliación</span>
                        <span class="info-value">${persona.num_afiliacion}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nombre completo</span>
                        <span class="info-value">${nombreCompleto}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Institución</span>
                        <span class="info-value">${persona.institucion}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Zona</span>
                        <span class="info-value">${zonaNombre}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cargo</span>
                        <span class="info-value">${persona.cargo}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Correo</span>
                        <span class="info-value">${persona.correo}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teléfono</span>
                        <span class="info-value">${persona.telefono}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Directorios</span>
                        <span class="info-value">
                            ${directorios.map(d => `<span class="tag-directorio-modal">${d}</span>`).join(' ')}
                        </span>
                    </div>
                </div>
                
                <p style="color:#c62828; font-weight:600; margin-top:0.75rem;">
                    <i class="fas fa-exclamation-circle"></i> 
                    Se perderá toda la información asociada a esta persona.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-modal-danger" onclick="confirmarEliminar(${id})">
                    <i class="fas fa-trash-alt"></i> Eliminar permanentemente
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });
}

function cerrarModal() {
    const modal = document.getElementById('modalEliminar');
    if (modal) {
        modal.remove();
    }
}

function confirmarEliminar(id) {
    const fila = document.querySelector(`tr[data-id="${id}"]`);
    if (fila) {
        fila.remove();
        
        const registrosMostrados = document.getElementById('registrosMostrados');
        if (registrosMostrados) {
            const actual = parseInt(registrosMostrados.textContent);
            registrosMostrados.textContent = actual - 1;
        }
        
        mostrarMensaje('Persona eliminada exitosamente', 'success');
    }
    
    cerrarModal();
}

// ============================================================
// MENSAJES EN LA PARTE SUPERIOR
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

// ============================================================
// EXPORTAR CSV (CON TODA LA INFO)
// ============================================================

function descargarCSV() {
    const filas = document.querySelectorAll('#tbodyPersonas tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Núm. Afiliación,Nombre,Institución,Zona,Cargo,Correo,Teléfono,Directorios\n';
    
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 8) return;
        
        // Obtener datos de la fila
        const numAfiliacion = celdas[0].textContent.trim();
        const nombre = celdas[1].textContent.trim();
        const institucion = celdas[2].textContent.trim();
        const zona = celdas[3].textContent.trim();
        const cargo = celdas[4].textContent.trim();
        const correo = celdas[5].textContent.trim();
        const telefono = celdas[6].textContent.trim();
        
        // Obtener directorios desde el data de la persona
        const id = parseInt(fila.dataset.id);
        const persona = personasData.find(p => p.id === id);
        const directorios = persona && persona.directorios ? persona.directorios.join('; ') : '';
        
        csv += `"${numAfiliacion}","${nombre}","${institucion}","${zona}","${cargo}","${correo}","${telefono}","${directorios}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `personas_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
    
    mostrarMensaje('CSV exportado exitosamente', 'success');
}

// ============================================================
// EXPORTAR CORREOS
// ============================================================

function descargarCorreos() {
    const filas = document.querySelectorAll('#tbodyPersonas tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay correos para exportar', 'error');
        return;
    }
    
    let correos = [];
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 6) return;
        
        const correo = celdas[5].textContent.trim();
        if (correo && correo.includes('@')) {
            correos.push(correo);
        }
    });
    
    if (correos.length === 0) {
        mostrarMensaje('No hay correos válidos para exportar', 'error');
        return;
    }
    
    const texto = correos.join('; ');
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(texto).then(() => {
            mostrarMensaje(`${correos.length} correos copiados al portapapeles`, 'success');
        }).catch(() => {
            descargarArchivoCorreos(texto, correos.length);
        });
    } else {
        descargarArchivoCorreos(texto, correos.length);
    }
}

function descargarArchivoCorreos(texto, cantidad) {
    const blob = new Blob([texto], { type: 'text/plain;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `correos_${new Date().toISOString().slice(0,10)}.txt`;
    link.click();
    mostrarMensaje(`${cantidad} correos exportados exitosamente`, 'success');
}
</script>

<?php include 'template/footer.php'; ?>