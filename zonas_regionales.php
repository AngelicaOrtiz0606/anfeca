<?php
// ============================================================
// SIDEANFECA - Catálogo de Zonas Regionales
// Listado de zonas regionales registradas
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

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

// Zonas Regionales (datos principales) - TODAS ACTIVAS
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

// Instituciones simuladas (para contar asociadas)
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

// ============================================================
// PROCESAR ACCIONES DEL CRUD (SIMULADO)
// ============================================================

$mensaje = '';
$error = '';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

// Eliminar zona
if ($accion === 'eliminar' && isset($_GET['id'])) {
    $id_eliminar = (int)$_GET['id'];
    $zona_encontrada = null;
    $indice_encontrado = null;
    
    foreach ($zonas_regionales as $key => $z) {
        if ($z['id'] == $id_eliminar) {
            $zona_encontrada = $z;
            $indice_encontrado = $key;
            break;
        }
    }
    
    if ($zona_encontrada) {
        // Verificar si tiene instituciones asociadas
        if (count($zona_encontrada['instituciones_asociadas']) > 0) {
            $error = 'No se puede eliminar la zona porque tiene ' . count($zona_encontrada['instituciones_asociadas']) . ' institución(es) asociada(s).';
        } else {
            // Eliminar la zona
            unset($zonas_regionales[$indice_encontrado]);
            $zonas_regionales = array_values($zonas_regionales);
            $mensaje = 'Zona regional eliminada exitosamente';
        }
    }
}

// ============================================================
// FILTROS Y ORDENAMIENTO
// ============================================================

$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : 'numero';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'asc';

$zonas_filtradas = $zonas_regionales;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $zonas_filtradas = array_filter($zonas_filtradas, function($z) use ($busqueda) {
        return strpos(strtolower($z['nombre']), $busqueda) !== false ||
               strpos(strtolower((string)$z['numero']), $busqueda) !== false;
    });
}

if ($estado_filtro == 'activo') {
    $zonas_filtradas = array_filter($zonas_filtradas, function($z) {
        return $z['activo'] == true;
    });
} elseif ($estado_filtro == 'inactivo') {
    $zonas_filtradas = array_filter($zonas_filtradas, function($z) {
        return $z['activo'] == false;
    });
}

// Ordenar
if (!empty($orden_columna)) {
    usort($zonas_filtradas, function($a, $b) use ($orden_columna, $orden_direccion) {
        $valor_a = '';
        $valor_b = '';
        
        switch ($orden_columna) {
            case 'numero':
                $valor_a = $a['numero'];
                $valor_b = $b['numero'];
                break;
            case 'nombre':
                $valor_a = $a['nombre'];
                $valor_b = $b['nombre'];
                break;
            case 'instituciones':
                $valor_a = count($a['instituciones_asociadas']);
                $valor_b = count($b['instituciones_asociadas']);
                break;
            case 'entidades':
                global $entidades_por_zona;
                $valor_a = isset($entidades_por_zona[$a['numero']]) ? count($entidades_por_zona[$a['numero']]) : 0;
                $valor_b = isset($entidades_por_zona[$b['numero']]) ? count($entidades_por_zona[$b['numero']]) : 0;
                break;
            case 'activo':
                $valor_a = $a['activo'] ? 1 : 0;
                $valor_b = $b['activo'] ? 1 : 0;
                break;
            default:
                $valor_a = $a['id'];
                $valor_b = $b['id'];
        }
        
        if ($orden_direccion == 'asc') {
            return $valor_a <=> $valor_b;
        } else {
            return $valor_b <=> $valor_a;
        }
    });
}

$total_registros = count($zonas_filtradas);

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
                    <h1 class="page-title">Catálogo de Zonas Regionales</h1>
                    <p class="page-subtitle">Administre las zonas regionales del sistema ANFECA</p>
                </div>
            </div>
            <div class="page-header-right">
                <!--<button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>-->
                <a href="zona_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nueva Zona
                </a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>¡Excelente!</strong> <?= htmlspecialchars($mensaje) ?>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor revise</strong> <?= htmlspecialchars($error) ?>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Filtros y búsqueda -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar por nombre o ID..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarZona"
                               autocomplete="off">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Estado</label>
                        <select name="estado" class="filter-select" id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="activo" <?= $estado_filtro == 'activo' ? 'selected' : '' ?>>Activos</option>
                            <option value="inactivo" <?= $estado_filtro == 'inactivo' ? 'selected' : '' ?>>Inactivos</option>
                        </select>
                    </div>
                    
                    
                    
                    <a href="zonas_regionales.php" class="btn-filter-clear <?= (empty($busqueda) && empty($estado_filtro)) ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-map-marker-alt"></i> 
                    <strong id="registrosMostrados"><?= count($zonas_filtradas) ?></strong> 
                    zona(s) encontrada(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaZonas">
                    <thead>
                        <tr>
                            <th class="col-numero">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'numero', 'orden_direccion' => ($orden_columna == 'numero' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'numero' ? 'active' : '' ?>">
                                    <span class="sort-label">Número</span>
                                    <?php if ($orden_columna == 'numero'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-nombre">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nombre', 'orden_direccion' => ($orden_columna == 'nombre' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'nombre' ? 'active' : '' ?>">
                                    <span class="sort-label">Nombre</span>
                                    <?php if ($orden_columna == 'nombre'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-entidades">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'entidades', 'orden_direccion' => ($orden_columna == 'entidades' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'entidades' ? 'active' : '' ?>">
                                    <span class="sort-label">Entidades</span>
                                    <?php if ($orden_columna == 'entidades'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-instituciones">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'instituciones', 'orden_direccion' => ($orden_columna == 'instituciones' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'instituciones' ? 'active' : '' ?>">
                                    <span class="sort-label">Instituciones</span>
                                    <?php if ($orden_columna == 'instituciones'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-estado">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'activo', 'orden_direccion' => ($orden_columna == 'activo' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'activo' ? 'active' : '' ?>">
                                    <span class="sort-label">Estado</span>
                                    <?php if ($orden_columna == 'activo'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyZonas">
                        <?php if (count($zonas_filtradas) > 0): ?>
                            <?php foreach ($zonas_filtradas as $zona): 
                                $total_instituciones = count($zona['instituciones_asociadas']);
                                $total_entidades = isset($entidades_por_zona[$zona['numero']]) ? count($entidades_por_zona[$zona['numero']]) : 0;
                                $estado_texto = $zona['activo'] ? 'Activo' : 'Inactivo';
                                $estado_class = $zona['activo'] ? 'status-active' : 'status-inactive';
                                $puede_eliminar = $total_instituciones == 0;
                            ?>
                            <tr data-id="<?= $zona['id'] ?>" data-instituciones="<?= $total_instituciones ?>" data-entidades="<?= $total_entidades ?>">
                                <td>
                                    <div class="zona-cell">
                                        <div class="zona-numero"><?= $zona['numero'] ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($zona['nombre']) ?></td>
                                <td>
                                    <span class="badge-entidades <?= $total_entidades > 0 ? 'badge-entidades-activo' : 'badge-entidades-vacio' ?>">
                                        <?= $total_entidades ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-instituciones <?= $total_instituciones > 0 ? 'badge-instituciones-activo' : 'badge-instituciones-vacio' ?>">
                                        <?= $total_instituciones ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= $estado_class ?>">
                                        <i class="fas fa-circle"></i> <?= $estado_texto ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="zona_consulta.php?id=<?= $zona['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="zona_edicion.php?id=<?= $zona['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <?php if ($puede_eliminar): ?>
                                            <button onclick="eliminarZona(<?= $zona['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <button onclick="eliminarZona(<?= $zona['id'] ?>)" class="btn-accion btn-eliminar btn-eliminar-bloqueado" title="No se puede eliminar (tiene instituciones asociadas)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-row">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p>No se encontraron zonas con los filtros aplicados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Footer con total de registros -->
            <div class="table-modern-footer">
                <span>Mostrando <strong><?= count($zonas_filtradas) ?></strong> de <strong><?= $total_registros ?></strong> registros</span>
            </div>
        </div>

    </div>
</main>

<!-- Modal para eliminar -->
<div class="modal-overlay" id="modalEliminar" style="display:none;">
    <div class="modal-card">
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" id="modalIcon"></i>
            <h3 id="modalTitulo">Confirmar eliminación</h3>
            <button class="modal-close" onclick="cerrarModalEliminar()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBody">
        </div>
        <div class="modal-footer" id="modalFooter">
        </div>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - LISTADO DE ZONAS REGIONALES
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

/* Alertas */
.alert-modern {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
    position: relative;
}

.alert-modern i {
    font-size: 1.25rem;
    margin-top: 0.1rem;
}

.alert-success {
    background: #f0f7f0;
    color: #1a5a1a;
    border-left: 4px solid #2e7d32;
}

.alert-success i {
    color: #2e7d32;
}

.alert-error {
    background: #fdf0f0;
    color: #7a1a1a;
    border-left: 4px solid #c62828;
}

.alert-error i {
    color: #c62828;
}

.alert-close {
    background: none;
    border: none;
    font-size: 1.1rem;
    cursor: pointer;
    margin-left: auto;
    padding: 0.2rem 0.5rem;
    color: inherit;
    opacity: 0.6;
    transition: opacity 0.2s ease;
}

.alert-close:hover {
    opacity: 1;
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
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group {
    position: relative;
    flex: 0 1 auto;
    min-width: 160px;
    max-width: 220px;
}

.filter-label {
    font-size: 0.65rem;
    font-weight: 600;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.15rem;
    display: block;
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
    padding: 0.5rem 1rem 0.5rem 3rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.85rem;
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
    padding: 0.5rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.85rem;
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
    padding: 0.5rem 1.25rem;
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
    padding: 0.5rem 1.25rem;
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

.btn-filter-clear.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
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

/* Tabla */
.table-modern-container {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-modern-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    table-layout: fixed;
    min-width: 700px;
}

.table-modern thead {
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 0.8rem 0.8rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.col-numero {
    width: 10%;
    min-width: 65px;
}
.col-nombre {
    width: 25%;
    min-width: 140px;
}
.col-entidades {
    width: 12%;
    min-width: 80px;
}
.col-instituciones {
    width: 14%;
    min-width: 90px;
}
.col-estado {
    width: 12%;
    min-width: 80px;
}
.col-acciones {
    width: 16%;
    min-width: 110px;
}

.table-modern tbody td {
    padding: 0.7rem 0.8rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

/* Sort links */
.sort-link {
    color: #6b6b6b;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    transition: color 0.2s ease;
    cursor: pointer;
    white-space: nowrap;
}

.sort-link .sort-label {
    display: inline-block;
}

.sort-link .sort-icon-inactive {
    color: #c0c0c0;
    font-size: 0.6rem;
}

.sort-link:hover {
    color: #8B0000;
}

.sort-link.active {
    color: #8B0000;
}

.sort-link.active .sort-icon-inactive {
    display: none;
}

.sort-link i {
    font-size: 0.6rem;
}

/* Badges */
.zona-numero {
    font-weight: 700;
    color: #1a1a1a;
    font-size: 1.05rem;
}

.badge-entidades {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    min-width: 28px;
    text-align: center;
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
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    min-width: 28px;
    text-align: center;
}

.badge-instituciones-activo {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-instituciones-vacio {
    background: #f5f5f5;
    color: #999;
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
    gap: 0.3rem;
    flex-wrap: wrap;
}

.btn-accion {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    flex-shrink: 0;
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

.btn-eliminar-bloqueado {
    opacity: 0.5;
    cursor: pointer !important;
}

.btn-eliminar-bloqueado:hover {
    background: #fce8e8 !important;
    color: #dc3545 !important;
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

/* Footer de tabla */
.table-modern-footer {
    padding: 0.8rem 1.25rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    font-size: 0.85rem;
    color: #6b6b6b;
}

/* ============================================================
   MODAL DE ELIMINACIÓN
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

.modal-card {
    background: white;
    border-radius: 16px;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

.modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-header i {
    font-size: 1.5rem;
}

.modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #999;
    margin-left: auto;
    padding: 0 0.25rem;
    transition: color 0.2s ease;
}

.modal-close:hover {
    color: #1a1a1a;
}

.modal-body {
    margin-bottom: 1.5rem;
}

.modal-body p {
    color: #4a4a4a;
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #f5f0f0;
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

.btn-modal-danger {
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

.btn-modal-danger:hover {
    background: #c62828;
}

.btn-modal-danger:disabled {
    background: #cccccc;
    color: #666666;
    cursor: not-allowed;
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
@media (max-width: 992px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: auto;
        max-width: none;
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

    .table-modern {
        min-width: 650px;
        font-size: 0.8rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.5rem 0.6rem;
    }

    .btn-accion {
        width: 28px;
        height: 28px;
        font-size: 0.65rem;
    }

    .modal-card {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-footer {
        flex-direction: column;
    }

    .modal-footer button {
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

    .table-modern {
        min-width: 550px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.4rem;
    }

    .col-numero {
        min-width: 50px;
    }
    .col-nombre {
        min-width: 110px;
    }
    .col-entidades {
        min-width: 65px;
    }
    .col-instituciones {
        min-width: 65px;
    }
    .col-estado {
        min-width: 65px;
    }
    .col-acciones {
        min-width: 90px;
    }

    .btn-accion {
        width: 24px;
        height: 24px;
        font-size: 0.55rem;
        border-radius: 6px;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const zonasData = <?= json_encode($zonas_regionales) ?>;
const institucionesData = <?= json_encode($instituciones) ?>;
const entidadesPorZona = <?= json_encode($entidades_por_zona) ?>;

// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarZona');
    const filtroEstado = document.getElementById('filtroEstado');
    const formFiltros = document.getElementById('formFiltros');
    
    let timeoutId = null;
    
    if (buscarInput) {
        buscarInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                formFiltros.submit();
            }, 500);
        });
    }
    
    if (filtroEstado) {
        filtroEstado.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
});

// ============================================================
// ELIMINAR ZONA
// ============================================================

function eliminarZona(id) {
    const zona = zonasData.find(z => z.id === id);
    if (!zona) {
        mostrarMensaje('No se encontró la zona', 'error');
        return;
    }
    
    const totalInstituciones = zona.instituciones_asociadas ? zona.instituciones_asociadas.length : 0;
    const modal = document.getElementById('modalEliminar');
    const modalIcon = document.getElementById('modalIcon');
    const modalTitulo = document.getElementById('modalTitulo');
    const modalBody = document.getElementById('modalBody');
    const modalFooter = document.getElementById('modalFooter');
    
    if (totalInstituciones > 0) {
        modalIcon.style.color = '#e65100';
        modalIcon.className = 'fas fa-lock';
        modalTitulo.textContent = 'No se puede eliminar';
        
        modalBody.innerHTML = `
            <p style="color:#e65100;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> 
                Esta zona tiene <strong>${totalInstituciones} institución(es)</strong> asociada(s).
            </p>
            <p>Para poder eliminar esta zona, primero debe eliminar o reasignar todas las instituciones asociadas.</p>
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Zona</span>
                    <span style="color:#1a1a1a;">${zona.numero} - ${zona.nombre}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Instituciones asociadas</span>
                    <span style="color:#e65100;font-weight:600;">${totalInstituciones}</span>
                </div>
            </div>
        `;
        
        modalFooter.innerHTML = `
            <button class="btn-modal-cancel" onclick="cerrarModalEliminar()">Entendido</button>
            <button class="btn-modal-danger" disabled>
                <i class="fas fa-lock"></i> No se puede eliminar
            </button>
        `;
    } else {
        modalIcon.style.color = '#dc3545';
        modalIcon.className = 'fas fa-exclamation-triangle';
        modalTitulo.textContent = '¿Eliminar zona?';
        
        modalBody.innerHTML = `
            <p><strong>¡Advertencia!</strong> Esta acción eliminará la zona del sistema. Esta operación <strong>no se puede deshacer</strong>.</p>
            
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Número</span>
                    <span style="color:#1a1a1a;">${zona.numero}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Nombre</span>
                    <span style="color:#1a1a1a;">${zona.nombre}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Estado</span>
                    <span style="color:#1a1a1a;">${zona.activo ? 'Activo' : 'Inactivo'}</span>
                </div>
            </div>
            
            <p style="color:#dc3545;font-weight:600;margin-top:0.75rem;">
                <i class="fas fa-exclamation-circle"></i> 
                Se perderá toda la información asociada a esta zona.
            </p>
        `;
        
        modalFooter.innerHTML = `
            <button class="btn-modal-cancel" onclick="cerrarModalEliminar()">Cancelar</button>
            <button class="btn-modal-danger" onclick="confirmarEliminar(${id})">
                <i class="fas fa-trash-alt"></i> Eliminar permanentemente
            </button>
        `;
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalEliminar() {
    const modal = document.getElementById('modalEliminar');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

function confirmarEliminar(id) {
    window.location.href = `zonas_regionales.php?accion=eliminar&id=${id}`;
}

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalEliminar');
    if (modal && e.target === modal) {
        cerrarModalEliminar();
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

// ============================================================
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    const filas = document.querySelectorAll('#tbodyZonas tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Número,Nombre,Entidades,Instituciones,Estado\n';
    
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 6) return;
        
        const numero = celdas[0].textContent.trim();
        const nombre = celdas[1].textContent.trim();
        const entidades = celdas[2].textContent.trim();
        const instituciones = celdas[3].textContent.trim();
        const estado = celdas[4].textContent.trim();
        
        csv += `"${numero}","${nombre}","${entidades}","${instituciones}","${estado}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `zonas_regionales_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
    
    mostrarMensaje('CSV exportado exitosamente', 'success');
}
</script>

<?php include 'template/footer.php'; ?>