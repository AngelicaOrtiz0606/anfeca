<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Listado de instituciones
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'institucion_datos.php';

// ============================================================
// FILTROS
// ============================================================

$tipo_filtro = isset($_GET['tipo']) ? (int)$_GET['tipo'] : 0;
$participacion_filtro = isset($_GET['participacion']) ? $_GET['participacion'] : '';
$zona_filtro = isset($_GET['zona']) ? (int)$_GET['zona'] : 0;
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$busqueda_filtro = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

$instituciones_filtradas = $instituciones;

if ($tipo_filtro > 0) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($tipo_filtro) {
        return $i['tipo'] == $tipo_filtro;
    });
}

if (!empty($participacion_filtro)) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($participacion_filtro) {
        // Matriz: filtra por es_matriz
        if ($participacion_filtro === 'matriz') {
            return $i['es_matriz'] ?? false;
        }
        
        // Si es matriz, no aplica filtro de afiliada u observadora
        if ($i['es_matriz'] ?? false) {
            return false;
        }
        
        $part = getParticipacionesDe($i);
        
        // Afiliada: participación vigente de tipo Afiliada
        if ($participacion_filtro === 'afiliada') {
            return $part['vigente'] && $part['vigente']['tipo'] === 'Afiliada';
        }
        
        // Observadora: participación vigente de tipo Observadora
        if ($participacion_filtro === 'observadora') {
            return $part['vigente'] && $part['vigente']['tipo'] === 'Observadora';
        }
        
        return false;
    });
}

if ($zona_filtro > 0) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($zona_filtro) {
        return $i['id_zona'] == $zona_filtro;
    });
}

if (!empty($estado_filtro)) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($estado_filtro) {
        $estado = getEstadoInstitucion($i);
        return $estado === $estado_filtro;
    });
}

if (!empty($busqueda_filtro)) {
    $busqueda = strtolower($busqueda_filtro);
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($busqueda) {
        return strpos(strtolower($i['nombre']), $busqueda) !== false;
    });
}

// Ordenar por nombre
usort($instituciones_filtradas, function($a, $b) {
    return strcmp($a['nombre'], $b['nombre']);
});

// ============================================================
// PAGINACIÓN
// ============================================================

$total_registros = count($instituciones_filtradas);
$registros_por_pagina = 10;
$total_paginas = ceil($total_registros / $registros_por_pagina);

$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

$offset = ($pagina_actual - 1) * $registros_por_pagina;
$instituciones_paginadas = array_slice($instituciones_filtradas, $offset, $registros_por_pagina);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <h1 class="page-title">Instituciones</h1>
                    <p class="page-subtitle">Gestión de instituciones educativas registradas en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern" <?= empty($instituciones_filtradas) ? 'disabled' : '' ?>>
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <a href="institucion_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nueva Institución
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Buscar</label>
                        <input type="text" name="busqueda" id="filtroBusqueda" class="filter-input" placeholder="Nombre..." value="<?= htmlspecialchars($busqueda_filtro) ?>">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Participación</label>
                        <select name="participacion" id="filtroParticipacion" class="filter-select">
                            <option value="">Todas</option>
                            <option value="afiliada" <?= $participacion_filtro == 'afiliada' ? 'selected' : '' ?>>Afiliada</option>
                            <option value="observadora" <?= $participacion_filtro == 'observadora' ? 'selected' : '' ?>>Observadora</option>
                            <option value="matriz" <?= $participacion_filtro == 'matriz' ? 'selected' : '' ?>>Matriz</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Zona</label>
                        <select name="zona" id="filtroZona" class="filter-select">
                            <option value="0">Todas</option>
                            <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $zona_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Estado</label>
                        <select name="estado" id="filtroEstado" class="filter-select">
                            <option value="">Todos</option>
                            <option value="activa" <?= $estado_filtro == 'activa' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactiva" <?= $estado_filtro == 'inactiva' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    
                    <a href="instituciones.php" class="btn-filter-clear">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-address-book"></i> 
                    <strong><?= $total_registros ?></strong> 
                    institución(es) encontrada(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <?php if (count($instituciones_paginadas) > 0): ?>
                <div class="table-modern-wrapper">
                    <table class="table-modern" id="tablaInstituciones">
                        <thead>
                            <tr>
                                <th>Núm. Afiliación</th>
                                <th>Institución</th>
                                <th>Dependencia</th>
                                <th>Participación</th>
                                <th>Zona</th>
                                <th>Personas</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($instituciones_paginadas as $institucion): 
                                $es_matriz = $institucion['es_matriz'] ?? false;
                                $estado = getEstadoInstitucion($institucion);
                                $esta_activa = ($estado === 'activa');
                                
                                // ============================
                                // Número de afiliación
                                // ============================
                                $num_afiliacion_mostrar = '---';
                                $participaciones = getParticipacionesDe($institucion);
                                $participacion_vigente = $participaciones['vigente'];
                                
                                if ($es_matriz) {
                                    $num_afiliacion_mostrar = 'N/A';
                                } elseif ($participacion_vigente && !empty($participacion_vigente['num_afiliacion'])) {
                                    $num_afiliacion_mostrar = $participacion_vigente['num_afiliacion'];
                                } elseif (!$esta_activa && !empty($participaciones['anteriores'])) {
                                    // Inactiva: mostrar el último número que tuvo
                                    foreach ($participaciones['anteriores'] as $p) {
                                        if (!empty($p['num_afiliacion'])) {
                                            $num_afiliacion_mostrar = $p['num_afiliacion'];
                                            break;
                                        }
                                    }
                                }
                                
                                // ============================
                                // Participación (badge)
                                // ============================
                                if ($es_matriz) {
                                    $participacion_badge = 'matriz';
                                    $participacion_texto = 'Matriz';
                                } elseif ($participacion_vigente) {
                                    $participacion_badge = strtolower($participacion_vigente['tipo']);
                                    $participacion_texto = $participacion_vigente['tipo'];
                                } else {
                                    // Inactiva: usar la última participación
                                    $ultima = !empty($participaciones['anteriores']) ? $participaciones['anteriores'][0] : null;
                                    $participacion_badge = $ultima ? strtolower($ultima['tipo']) : 'observadora';
                                    $participacion_texto = $ultima ? $ultima['tipo'] : '---';
                                }
                                
                                // ============================
                                // Dependencia
                                // ============================
                                $dependencia_nombre = '';
                                if ($institucion['id_universidad']) {
                                    $dependencia_nombre = getNombreInstitucion($institucion['id_universidad']);
                                }
                                
                                // ============================
                                // Zona
                                // ============================
                                $zona_mostrar = getZonaNumero($institucion['id_zona']);
                                
                                // ============================
                                // Estado (texto)
                                // ============================
                                if ($esta_activa) {
                                    $estado_texto = 'Activo';
                                    $estado_clase = 'status-active';
                                } else {
                                    $estado_texto = 'Inactivo';
                                    $estado_clase = 'status-inactive';
                                }
                                
                                // ============================
                                // ¿Se puede eliminar?
                                // ============================
                                $dependencias = getDependenciasDe($institucion['id']);
                                $puede_eliminar = (count($dependencias) == 0 && $institucion['personas_relacionadas'] == 0);
                                $tooltip_eliminar = $puede_eliminar ? '' : 'No se puede eliminar porque tiene instituciones o personas asociadas';
                            ?>
                                <tr>
                                    <td>
                                        <span class="num-afiliacion <?= $es_matriz ? 'num-afiliacion-na' : '' ?>">
                                            <?= htmlspecialchars($num_afiliacion_mostrar) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="institucion-nombre">
                                            <?= htmlspecialchars($institucion['nombre']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($institucion['id_universidad']): ?>
                                            <a href="institucion_consulta.php?id=<?= $institucion['id_universidad'] ?>" class="dependencia-link">
                                                <?= htmlspecialchars($dependencia_nombre) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="dependencia-na">---</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge-participacion badge-<?= $participacion_badge ?>">
                                            <?= htmlspecialchars($participacion_texto) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-zona <?= $zona_mostrar === '---' ? 'badge-zona-na' : '' ?>">
                                            <?= htmlspecialchars($zona_mostrar) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-personas <?= $institucion['personas_relacionadas'] > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                                            <?= $institucion['personas_relacionadas'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?= $estado_clase ?>">
                                            <span class="status-dot"></span> <?= $estado_texto ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="institucion_consulta.php?id=<?= $institucion['id'] ?>" class="btn-action btn-view" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="institucion_edicion.php?id=<?= $institucion['id'] ?>" class="btn-action btn-edit" title="Editar">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button class="btn-action btn-delete <?= !$puede_eliminar ? 'btn-delete-disabled' : '' ?>" 
                                                    title="<?= $tooltip_eliminar ?>"
                                                    <?= !$puede_eliminar ? 'disabled' : '' ?>
                                                    onclick="<?= $puede_eliminar ? "abrirModalEliminar({$institucion['id']}, '" . htmlspecialchars(addslashes($institucion['nombre'])) . "')" : '' ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <?php if ($total_paginas > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        Mostrando <strong><?= count($instituciones_paginadas) ?></strong> de <strong><?= $total_registros ?></strong> registros
                        (Página <?= $pagina_actual ?> de <?= $total_paginas ?>)
                    </div>
                    <div class="pagination-controls">
                        <?php if ($pagina_actual > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina_actual - 1])) ?>" class="pagination-btn">
                                <i class="fas fa-chevron-left"></i> Anterior
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                <i class="fas fa-chevron-left"></i> Anterior
                            </span>
                        <?php endif; ?>
                        
                        <?php
                        $rango = 2;
                        $inicio = max(1, $pagina_actual - $rango);
                        $fin = min($total_paginas, $pagina_actual + $rango);
                        
                        if ($inicio > 1) {
                            echo '<a href="?' . http_build_query(array_merge($_GET, ['pagina' => 1])) . '" class="pagination-num">1</a>';
                            if ($inicio > 2) echo '<span class="pagination-dots">...</span>';
                        }
                        
                        for ($i = $inicio; $i <= $fin; $i++) {
                            $active = $i == $pagina_actual ? 'active' : '';
                            echo '<a href="?' . http_build_query(array_merge($_GET, ['pagina' => $i])) . '" class="pagination-num ' . $active . '">' . $i . '</a>';
                        }
                        
                        if ($fin < $total_paginas) {
                            if ($fin < $total_paginas - 1) echo '<span class="pagination-dots">...</span>';
                            echo '<a href="?' . http_build_query(array_merge($_GET, ['pagina' => $total_paginas])) . '" class="pagination-num">' . $total_paginas . '</a>';
                        }
                        ?>
                        
                        <?php if ($pagina_actual < $total_paginas): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina_actual + 1])) ?>" class="pagination-btn">
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="pagination-btn disabled">
                                Siguiente <i class="fas fa-chevron-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-university"></i>
                    <h3>No hay instituciones registradas</h3>
                    <p>Comienza registrando una nueva institución educativa</p>
                    <a href="institucion_registro.php" class="btn-primary-modern">
                        <i class="fas fa-plus-circle"></i> Registrar Institución
                    </a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<!-- Modal de Eliminación -->
<div class="modal-overlay" id="modalEliminar" style="display:none;">
    <div class="modal-card modal-card-eliminar">
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" style="color:#c62828; font-size:1.5rem;"></i>
            <h3>Confirmar eliminación</h3>
            <button onclick="cerrarModalEliminar()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro de que desea eliminar la institución <strong id="nombreEliminar"></strong>?</p>
            <p style="color:#999; font-size:0.85rem; margin-top:0.5rem;">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-cancel" onclick="cerrarModalEliminar()">Cancelar</button>
            <button class="btn-modal-danger" id="btnConfirmarEliminar">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - INSTITUCIONES
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
    flex-wrap: wrap;
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

.btn-outline-modern:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    min-width: 140px;
    max-width: 200px;
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

.filter-input,
.filter-select {
    width: 100%;
    padding: 0.5rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #1a1a1a;
}

.filter-input:focus,
.filter-select:focus {
    outline: none;
    border-color: #8B0000;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
}

.filter-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b6b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
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
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
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
    font-size: 0.95rem;
    min-width: 900px;
}

.table-modern thead {
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 0.9rem 1.2rem;
    font-weight: 700;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
    white-space: nowrap;
}

.table-modern tbody td {
    padding: 0.8rem 1.2rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

/* Badges */
.num-afiliacion {
    font-family: monospace;
    font-weight: 600;
    font-size: 0.9rem;
    color: #1a1a1a;
    background: #f0ecec;
    padding: 0.15rem 0.6rem;
    border-radius: 4px;
}

.num-afiliacion-na {
    color: #999;
    background: transparent;
    font-family: inherit;
    font-weight: 400;
}

.institucion-nombre {
    font-weight: 500;
    color: #1a1a1a;
    font-size: 0.95rem;
}

.badge-participacion {
    display: inline-block;
    padding: 0.25rem 0.8rem;
    border-radius: 14px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-participacion.badge-afiliada {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-participacion.badge-observadora {
    background: #fff3e0;
    color: #e65100;
}

.badge-participacion.badge-matriz {
    background: #e3f2fd;
    color: #0d47a1;
}

.badge-zona {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    background: #f5edec;
    color: #5a3a3a;
    border-radius: 14px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-zona-na {
    background: transparent;
    color: #ccc;
    font-weight: 400;
}

.badge-personas {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    border-radius: 14px;
    font-size: 0.85rem;
    font-weight: 600;
    min-width: 32px;
    text-align: center;
}

.badge-personas-activo {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-personas-vacio {
    background: #f5f5f5;
    color: #999;
}

/* Enlaces */
.dependencia-link {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.2s ease;
}

.dependencia-link:hover {
    color: #0a58ca;
    text-decoration: underline;
}

.dependencia-na {
    color: #ccc;
    font-size: 0.9rem;
}

/* Status badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.2rem 0.8rem;
    border-radius: 20px;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-badge.status-active {
    background: #e8f5e9;
    color: #2e7d32;
}

.status-badge.status-active .status-dot {
    background: #2e7d32;
}

.status-badge.status-inactive {
    background: #fce4ec;
    color: #c62828;
}

.status-badge.status-inactive .status-dot {
    background: #c62828;
}

/* Acciones */
.action-buttons {
    display: flex;
    gap: 0.4rem;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-action i {
    font-size: 0.9rem;
}

.btn-view {
    background: #e8f0fe;
    color: #1a3a6b;
}

.btn-view:hover {
    background: #1a3a6b;
    color: white;
}

.btn-edit {
    background: #f0e8e8;
    color: #6b1a1a;
}

.btn-edit:hover {
    background: #8B0000;
    color: white;
}

.btn-delete {
    background: #fce4ec;
    color: #c62828;
}

.btn-delete:hover:not(:disabled) {
    background: #c62828;
    color: white;
}

.btn-delete-disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.btn-delete:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* Paginación */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 1.25rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.pagination-info {
    font-size: 0.85rem;
    color: #6b6b6b;
}

.pagination-controls {
    display: flex;
    gap: 0.35rem;
    align-items: center;
    flex-wrap: wrap;
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.8rem;
    background: white;
    color: #4a4a4a;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.pagination-btn:hover:not(.disabled) {
    background: #f5edec;
    border-color: #8B0000;
    color: #8B0000;
}

.pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    color: #4a4a4a;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.pagination-num:hover:not(.active) {
    background: #f5edec;
    border-color: #e0d6d6;
}

.pagination-num.active {
    background: #8B0000;
    color: white;
    border-color: #8B0000;
}

.pagination-dots {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    color: #999;
    font-size: 0.8rem;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 4rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.3rem;
    color: #4a4a4a;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #999;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
}

.empty-state .btn-primary-modern {
    display: inline-flex;
}

/* Modal Eliminar */
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

.modal-card-eliminar {
    background: white;
    border-radius: 16px;
    max-width: 480px;
    width: 90%;
    padding: 1.75rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

.modal-card-eliminar .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card-eliminar .modal-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card-eliminar .modal-body {
    margin-bottom: 1.5rem;
}

.modal-card-eliminar .modal-body p {
    font-size: 0.95rem;
    color: #4a4a4a;
}

.modal-card-eliminar .modal-footer {
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
    padding: 0.6rem 1.8rem;
    background: #c62828;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-modal-danger:hover {
    background: #b71c1c;
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
        min-width: 750px;
        font-size: 0.85rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.6rem 0.8rem;
    }

    .empty-state {
        padding: 2rem 1rem;
    }

    .pagination-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .modal-card-eliminar {
        padding: 1.25rem;
    }

    .modal-card-eliminar .modal-footer {
        flex-direction: column;
    }

    .modal-card-eliminar .modal-footer button {
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
        min-width: 600px;
        font-size: 0.75rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.5rem;
    }

    .action-buttons .btn-action {
        width: 28px;
        height: 28px;
    }

    .action-buttons .btn-action i {
        font-size: 0.7rem;
    }

    .pagination-controls {
        justify-content: center;
    }

    .modal-card-eliminar {
        padding: 1rem;
        margin: 0.5rem;
    }
}
</style>

<script>
// ============================================================
// FILTRADO AUTOMÁTICO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formFiltros');
    
    const selects = document.querySelectorAll('#filtroParticipacion, #filtroZona, #filtroEstado');
    selects.forEach(function(select) {
        select.addEventListener('change', function() {
            form.submit();
        });
    });
    
    const busqueda = document.getElementById('filtroBusqueda');
    let timeoutId = null;
    
    busqueda.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            form.submit();
        }, 400);
    });
    
    busqueda.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
    });
});

// ============================================================
// MODAL ELIMINAR
// ============================================================

let idEliminar = null;

function abrirModalEliminar(id, nombre) {
    idEliminar = id;
    document.getElementById('nombreEliminar').textContent = nombre;
    document.getElementById('modalEliminar').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    document.getElementById('btnConfirmarEliminar').onclick = function() {
        if (idEliminar) {
            window.location.href = 'instituciones.php?eliminar=' + idEliminar;
        }
    };
}

function cerrarModalEliminar() {
    document.getElementById('modalEliminar').style.display = 'none';
    document.body.style.overflow = 'auto';
    idEliminar = null;
}

document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalEliminar');
    if (e.target === modal) {
        cerrarModalEliminar();
    }
});

// ============================================================
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    const datos = <?= json_encode(array_map(function($i) {
        $es_matriz = $i['es_matriz'] ?? false;
        $estado_general = getEstadoInstitucion($i);
        $esta_activa = ($estado_general === 'activa');
        
        // Número de afiliación
        $participaciones = getParticipacionesDe($i);
        $participacion_vigente = $participaciones['vigente'];
        
        $num_afiliacion_mostrar = '---';
        if ($es_matriz) {
            $num_afiliacion_mostrar = 'N/A';
        } elseif ($participacion_vigente && !empty($participacion_vigente['num_afiliacion'])) {
            $num_afiliacion_mostrar = $participacion_vigente['num_afiliacion'];
        } elseif (!$esta_activa && !empty($participaciones['anteriores'])) {
            foreach ($participaciones['anteriores'] as $p) {
                if (!empty($p['num_afiliacion'])) {
                    $num_afiliacion_mostrar = $p['num_afiliacion'];
                    break;
                }
            }
        }
        
        // Participación
        if ($es_matriz) {
            $participacion_texto = 'Matriz';
        } elseif ($participacion_vigente) {
            $participacion_texto = $participacion_vigente['tipo'];
        } else {
            $ultima = !empty($participaciones['anteriores']) ? $participaciones['anteriores'][0] : null;
            $participacion_texto = $ultima ? $ultima['tipo'] : '---';
        }
        
        // Dependencia
        $dependencia_nombre = '';
        if ($i['id_universidad']) {
            $dependencia_nombre = getNombreInstitucion($i['id_universidad']);
        }
        
        // Estado
        $estado_texto = $esta_activa ? 'Activo' : 'Inactivo';
        
        // Zona
        $zona_num = getZonaNumero($i['id_zona']);
        
        return [
            'num_afiliacion' => $num_afiliacion_mostrar,
            'nombre' => $i['nombre'],
            'dependencia' => $dependencia_nombre ?: '---',
            'participacion' => $participacion_texto,
            'zona' => $zona_num,
            'personas' => $i['personas_relacionadas'],
            'estado' => $estado_texto
        ];
    }, $instituciones_filtradas)) ?>;
    
    if (datos.length === 0) {
        alert('No hay datos para exportar');
        return;
    }
    
    let csv = 'Núm. Afiliación,Institución,Dependencia,Participación,Zona,Personas,Estado\n';
    
    datos.forEach(function(row) {
        csv += `"${row.num_afiliacion}","${row.nombre}","${row.dependencia}","${row.participacion}","${row.zona}","${row.personas}","${row.estado}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `instituciones_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
}
</script>

<?php include 'template/footer.php'; ?>