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

// Personas simuladas (con estado que se puede modificar)
$personas = [
    [
        'id' => 1,
        'nombre' => 'María',
        'apellido_paterno' => 'González',
        'apellido_materno' => 'Pérez',
        'genero' => 'F',
        'id_zona' => 7,
        'institucion' => 'UNAM - Facultad de Contaduría',
        'cargo' => 'Presidenta',
        'activo' => true
    ],
    [
        'id' => 2,
        'nombre' => 'Juan',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'id_zona' => 7,
        'institucion' => 'IPN - ESCOM',
        'cargo' => 'Coordinador Nacional',
        'activo' => true
    ],
    [
        'id' => 3,
        'nombre' => 'Ana',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Ramírez',
        'genero' => 'F',
        'id_zona' => 3,
        'institucion' => 'UAQ - Querétaro',
        'cargo' => 'Secretaria General',
        'activo' => false
    ],
    [
        'id' => 4,
        'nombre' => 'Carlos',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'Díaz',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'UDG - Guadalajara',
        'cargo' => 'Director Regional',
        'activo' => true
    ],
    [
        'id' => 5,
        'nombre' => 'Laura',
        'apellido_paterno' => 'Torres',
        'apellido_materno' => 'Vega',
        'genero' => 'F',
        'id_zona' => 1,
        'institucion' => 'UABC - Mexicali',
        'cargo' => 'Coordinadora Regional',
        'activo' => true
    ],
    [
        'id' => 6,
        'nombre' => 'Roberto',
        'apellido_paterno' => 'Mendoza',
        'apellido_materno' => 'Cruz',
        'genero' => 'M',
        'id_zona' => 2,
        'institucion' => 'UANL - San Nicolás',
        'cargo' => 'Secretario Regional',
        'activo' => false
    ],
    [
        'id' => 7,
        'nombre' => 'Patricia',
        'apellido_paterno' => 'Flores',
        'apellido_materno' => 'Reyes',
        'genero' => 'F',
        'id_zona' => 5,
        'institucion' => 'UAEH - Pachuca',
        'cargo' => 'Coordinadora Regional',
        'activo' => true
    ]
];

// Procesar filtros
$zona_filtro = isset($_GET['zona']) ? (int)$_GET['zona'] : 0;
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
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
               strpos(strtolower($p['cargo']), $busqueda) !== false;
    });
}

if ($zona_filtro > 0) {
    $personas_filtradas = array_filter($personas_filtradas, function($p) use ($zona_filtro) {
        return $p['id_zona'] == $zona_filtro;
    });
}

if ($estado_filtro == 'activo') {
    $personas_filtradas = array_filter($personas_filtradas, function($p) {
        return $p['activo'] == true;
    });
} elseif ($estado_filtro == 'inactivo') {
    $personas_filtradas = array_filter($personas_filtradas, function($p) {
        return $p['activo'] == false;
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

// Guardar personas en sesión para persistencia (simulación)
if (!isset($_SESSION['personas'])) {
    $_SESSION['personas'] = $personas;
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
                               placeholder="Buscar por nombre, institución o cargo..." 
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
                        <select name="estado" class="filter-select" id="filtroEstado">
                            <option value="">Todos los estados</option>
                            <option value="activo" <?= $estado_filtro == 'activo' ? 'selected' : '' ?>>Activos</option>
                            <option value="inactivo" <?= $estado_filtro == 'inactivo' ? 'selected' : '' ?>>Inactivos</option>
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
                    
                    <?php if (!empty($busqueda) || $zona_filtro > 0 || !empty($estado_filtro)): ?>
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
                            <th>Nombre</th>
                            <th>Institución</th>
                            <th>Zona</th>
                            <th>Cargo</th>
                            <th>Estado</th>
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
                            <tr data-id="<?= $persona['id'] ?>" data-activo="<?= $persona['activo'] ? 'true' : 'false' ?>">
                                <td>
                                    <div class="persona-cell">
                                        <div class="persona-nombre"><?= htmlspecialchars($nombre_completo) ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($persona['institucion']) ?></td>
                                <td><span class="badge-zona"><?= htmlspecialchars($zona_nombre) ?></span></td>
                                <td><?= htmlspecialchars($persona['cargo']) ?></td>
                                <td>
                                    <?php if ($persona['activo']): ?>
                                        <span class="status-active"><i class="fas fa-circle"></i> Activo</span>
                                    <?php else: ?>
                                        <span class="status-inactive"><i class="fas fa-circle"></i> Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="persona_consulta.php?id=<?= $persona['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="persona_edicion.php?id=<?= $persona['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <?php if ($persona['activo']): ?>
                                            <button onclick="desactivarPersona(<?= $persona['id'] ?>)" class="btn-accion btn-desactivar" title="Desactivar">
                                                <i class="fas fa-user-slash"></i>
                                            </button>
                                        <?php else: ?>
                                            <button onclick="activarPersona(<?= $persona['id'] ?>)" class="btn-accion btn-activar" title="Activar">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-row">
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

/* Persona cell - SIN INICIALES */
.persona-cell {
    display: flex;
    align-items: center;
}

.persona-nombre {
    font-weight: 600;
    color: #1a1a1a;
}

/* Badge zona */
.badge-zona {
    display: inline-block;
    padding: 0.25rem 0.9rem;
    background: #f0ebeb;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Estados */
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

/* Acciones */
.acciones-group {
    display: flex;
    gap: 0.35rem;
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

.btn-desactivar {
    background: #fce8e8;
    color: #dc3545;
}

.btn-desactivar:hover {
    background: #dc3545;
    color: white;
}

.btn-activar {
    background: #e8f5e9;
    color: #2e7d32;
}

.btn-activar:hover {
    background: #2e7d32;
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
}
</style>

<script>
// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarPersona');
    const filtroZona = document.getElementById('filtroZona');
    const filtroEstado = document.getElementById('filtroEstado');
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
    
    filtroEstado.addEventListener('change', function() {
        formFiltros.submit();
    });
    
    filtroOrden.addEventListener('change', function() {
        formFiltros.submit();
    });
});

// ============================================================
// ACTIVAR / DESACTIVAR PERSONA (CON ACTUALIZACIÓN DINÁMICA)
// ============================================================

function desactivarPersona(id) {
    if (!confirm('¿Está seguro de desactivar esta persona?')) {
        return;
    }
    
    // Buscar la fila en la tabla
    const fila = document.querySelector(`tr[data-id="${id}"]`);
    if (!fila) {
        alert('Error: No se encontró la persona en la tabla');
        return;
    }
    
    // Actualizar en el arreglo de datos (simulación)
    // En un sistema real, aquí iría una llamada AJAX
    
    // Actualizar visualmente la fila
    const celdaEstado = fila.querySelectorAll('td')[4];
    const celdaAcciones = fila.querySelectorAll('td')[5];
    
    // Actualizar estado
    celdaEstado.innerHTML = `<span class="status-inactive"><i class="fas fa-circle"></i> Inactivo</span>`;
    
    // Actualizar botones de acción
    celdaAcciones.innerHTML = `
        <div class="acciones-group">
            <a href="persona_consulta.php?id=${id}" class="btn-accion btn-ver" title="Consultar">
                <i class="fas fa-eye"></i>
            </a>
            <a href="persona_edicion.php?id=${id}" class="btn-accion btn-editar" title="Editar">
                <i class="fas fa-pen"></i>
            </a>
            <button onclick="activarPersona(${id})" class="btn-accion btn-activar" title="Activar">
                <i class="fas fa-user-check"></i>
            </button>
        </div>
    `;
    
    // Actualizar data attribute
    fila.dataset.activo = 'false';
    
    // Mostrar notificación
    mostrarNotificacion('Persona desactivada exitosamente', 'success');
}

function activarPersona(id) {
    if (!confirm('¿Está seguro de activar esta persona?')) {
        return;
    }
    
    // Buscar la fila en la tabla
    const fila = document.querySelector(`tr[data-id="${id}"]`);
    if (!fila) {
        alert('Error: No se encontró la persona en la tabla');
        return;
    }
    
    // Actualizar visualmente la fila
    const celdaEstado = fila.querySelectorAll('td')[4];
    const celdaAcciones = fila.querySelectorAll('td')[5];
    
    // Actualizar estado
    celdaEstado.innerHTML = `<span class="status-active"><i class="fas fa-circle"></i> Activo</span>`;
    
    // Actualizar botones de acción
    celdaAcciones.innerHTML = `
        <div class="acciones-group">
            <a href="persona_consulta.php?id=${id}" class="btn-accion btn-ver" title="Consultar">
                <i class="fas fa-eye"></i>
            </a>
            <a href="persona_edicion.php?id=${id}" class="btn-accion btn-editar" title="Editar">
                <i class="fas fa-pen"></i>
            </a>
            <button onclick="desactivarPersona(${id})" class="btn-accion btn-desactivar" title="Desactivar">
                <i class="fas fa-user-slash"></i>
            </button>
        </div>
    `;
    
    // Actualizar data attribute
    fila.dataset.activo = 'true';
    
    // Mostrar notificación
    mostrarNotificacion('Persona activada exitosamente', 'success');
}

// ============================================================
// NOTIFICACIONES
// ============================================================

function mostrarNotificacion(mensaje, tipo) {
    // Crear notificación
    const notificacion = document.createElement('div');
    notificacion.className = `alert-modern alert-${tipo}`;
    notificacion.style.cssText = `
        position: fixed;
        top: 90px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        animation: slideInRight 0.5s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    `;
    notificacion.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <div>
            <strong>¡Éxito!</strong> ${mensaje}
        </div>
    `;
    
    document.body.appendChild(notificacion);
    
    // Eliminar después de 3 segundos
    setTimeout(function() {
        notificacion.style.animation = 'slideOutRight 0.5s ease';
        setTimeout(function() {
            notificacion.remove();
        }, 500);
    }, 3000);
}

// ============================================================
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    alert('Funcionalidad de exportación CSV en desarrollo.\nSe exportarán los datos mostrados actualmente.');
}

// ============================================================
// ANIMACIONES CSS PARA NOTIFICACIONES
// ============================================================

// Agregar estilos dinámicamente
const styleNotificaciones = document.createElement('style');
styleNotificaciones.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(styleNotificaciones);
</script>

<?php include 'template/footer.php'; ?>