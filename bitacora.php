<?php
// ============================================================
// SIDEANFECA - Bitácora del Sistema
// Registro de todas las acciones realizadas en el sistema
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// MAPEO DE ACCIONES A COLORES Y VERBOS
// ============================================================

$acciones_map = [
    'Registro' => ['verbo' => 'registró', 'color' => '#e8f5e9', 'texto' => '#2e7d32'],
    'Modificacion' => ['verbo' => 'modificó', 'color' => '#e3f2fd', 'texto' => '#1565c0'],
    'Activacion' => ['verbo' => 'reactivó', 'color' => '#e8f5e9', 'texto' => '#2e7d32'],
    'Desactivacion' => ['verbo' => 'desactivó', 'color' => '#fce4ec', 'texto' => '#c62828'],
    'Asignacion' => ['verbo' => 'asignó', 'color' => '#fff3e0', 'texto' => '#e65100'],
    'Eliminacion' => ['verbo' => 'eliminó', 'color' => '#fce4ec', 'texto' => '#c62828']
];

// ============================================================
// DATOS SIMULADOS DE BITÁCORA (desde junio 2026)
// ============================================================

$bitacora_data = [
    [
        'id' => 1,
        'fecha_hora' => '2026-08-15 09:30:00',
        'usuario' => 'María González',
        'accion' => 'Registro',
        'descripcion' => 'Registró a Patricia Flores Reyes como nueva persona'
    ],
    [
        'id' => 2,
        'fecha_hora' => '2026-08-15 09:15:00',
        'usuario' => 'Juan Pérez',
        'accion' => 'Modificacion',
        'descripcion' => 'Modificó la información de la institución UNAM'
    ],
    [
        'id' => 3,
        'fecha_hora' => '2026-08-14 16:45:00',
        'usuario' => 'Carlos López',
        'accion' => 'Asignacion',
        'descripcion' => 'Asignó el cargo de Coordinadora Regional a Laura Torres Vega'
    ],
    [
        'id' => 4,
        'fecha_hora' => '2026-08-14 14:20:00',
        'usuario' => 'Roberto Mendoza',
        'accion' => 'Desactivacion',
        'descripcion' => 'Desactivó a Roberto Mendoza Cruz del sistema'
    ],
    [
        'id' => 5,
        'fecha_hora' => '2026-08-14 11:00:00',
        'usuario' => 'Ana Sánchez',
        'accion' => 'Registro',
        'descripcion' => 'Registró la institución Instituto Tecnológico de los Mochis'
    ],
    [
        'id' => 6,
        'fecha_hora' => '2026-08-13 17:30:00',
        'usuario' => 'Admin ANFECA',
        'accion' => 'Registro',
        'descripcion' => 'Agregó la coordinación Responsabilidad Social Universitaria'
    ],
    [
        'id' => 7,
        'fecha_hora' => '2026-08-13 15:00:00',
        'usuario' => 'María González',
        'accion' => 'Modificacion',
        'descripcion' => 'Modificó los datos de Juan Martínez López'
    ],
    [
        'id' => 8,
        'fecha_hora' => '2026-08-13 12:30:00',
        'usuario' => 'Admin ANFECA',
        'accion' => 'Activacion',
        'descripcion' => 'Reactivó a Ana Sánchez Ramírez en el sistema'
    ],
    [
        'id' => 9,
        'fecha_hora' => '2026-08-12 10:00:00',
        'usuario' => 'Carlos López',
        'accion' => 'Eliminacion',
        'descripcion' => 'Eliminó a un usuario inactivo del sistema'
    ],
    [
        'id' => 10,
        'fecha_hora' => '2026-08-11 08:30:00',
        'usuario' => 'María González',
        'accion' => 'Modificacion',
        'descripcion' => 'Modificó el nombre de la coordinación Investigación'
    ],
    [
        'id' => 11,
        'fecha_hora' => '2026-08-10 16:00:00',
        'usuario' => 'Admin ANFECA',
        'accion' => 'Registro',
        'descripcion' => 'Registró la institución Universidad Autónoma de Querétaro'
    ],
    [
        'id' => 12,
        'fecha_hora' => '2026-08-09 11:20:00',
        'usuario' => 'Juan Pérez',
        'accion' => 'Asignacion',
        'descripcion' => 'Asignó el cargo de Presidente a María González'
    ],
    [
        'id' => 13,
        'fecha_hora' => '2026-07-28 14:00:00',
        'usuario' => 'María González',
        'accion' => 'Registro',
        'descripcion' => 'Registró a Jorge Gómez García como nueva persona'
    ],
    [
        'id' => 14,
        'fecha_hora' => '2026-07-20 10:30:00',
        'usuario' => 'Carlos López',
        'accion' => 'Modificacion',
        'descripcion' => 'Modificó los datos de la institución IPN'
    ],
    [
        'id' => 15,
        'fecha_hora' => '2026-07-15 09:00:00',
        'usuario' => 'Admin ANFECA',
        'accion' => 'Desactivacion',
        'descripcion' => 'Desactivó a Carmen Rivera Morales del sistema'
    ],
    [
        'id' => 16,
        'fecha_hora' => '2026-07-10 16:30:00',
        'usuario' => 'Ana Sánchez',
        'accion' => 'Activacion',
        'descripcion' => 'Reactivó a Luis Méndez Vargas en el sistema'
    ],
    [
        'id' => 17,
        'fecha_hora' => '2026-07-05 11:00:00',
        'usuario' => 'Juan Pérez',
        'accion' => 'Registro',
        'descripcion' => 'Registró la institución Universidad Autónoma de Yucatán'
    ],
    [
        'id' => 18,
        'fecha_hora' => '2026-06-28 08:30:00',
        'usuario' => 'María González',
        'accion' => 'Asignacion',
        'descripcion' => 'Asignó el cargo de Secretaria General a Ana Sánchez'
    ],
    [
        'id' => 19,
        'fecha_hora' => '2026-06-20 13:00:00',
        'usuario' => 'Carlos López',
        'accion' => 'Modificacion',
        'descripcion' => 'Modificó los datos de la coordinación Planes y Programas'
    ],
    [
        'id' => 20,
        'fecha_hora' => '2026-06-15 10:00:00',
        'usuario' => 'Admin ANFECA',
        'accion' => 'Registro',
        'descripcion' => 'Registró la coordinación Vinculación Nacional e Internacional'
    ]
];

// ============================================================
// PROCESAR FILTROS Y ORDENAMIENTO
// ============================================================

$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$anio_filtro = isset($_GET['anio']) ? (int)$_GET['anio'] : 0;
$mes_filtro = isset($_GET['mes']) ? (int)$_GET['mes'] : 0;
$accion_filtro = isset($_GET['accion']) ? $_GET['accion'] : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : 'fecha_hora';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'desc';

// Paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 6;

$bitacora_filtrada = $bitacora_data;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $bitacora_filtrada = array_filter($bitacora_filtrada, function($r) use ($busqueda) {
        return strpos(strtolower($r['usuario']), $busqueda) !== false ||
               strpos(strtolower($r['descripcion']), $busqueda) !== false;
    });
}

if ($anio_filtro > 0) {
    $bitacora_filtrada = array_filter($bitacora_filtrada, function($r) use ($anio_filtro) {
        return (int)date('Y', strtotime($r['fecha_hora'])) == $anio_filtro;
    });
}

if ($mes_filtro > 0) {
    $bitacora_filtrada = array_filter($bitacora_filtrada, function($r) use ($mes_filtro) {
        return (int)date('m', strtotime($r['fecha_hora'])) == $mes_filtro;
    });
}

if (!empty($accion_filtro)) {
    $bitacora_filtrada = array_filter($bitacora_filtrada, function($r) use ($accion_filtro) {
        return $r['accion'] == $accion_filtro;
    });
}

// Ordenar
usort($bitacora_filtrada, function($a, $b) use ($orden_columna, $orden_direccion) {
    $valor_a = '';
    $valor_b = '';
    
    switch ($orden_columna) {
        case 'fecha_hora':
            $valor_a = strtotime($a['fecha_hora']);
            $valor_b = strtotime($b['fecha_hora']);
            break;
        case 'usuario':
            $valor_a = $a['usuario'];
            $valor_b = $b['usuario'];
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

$total_registros = count($bitacora_filtrada);
$total_paginas = ceil($total_registros / $registros_por_pagina);

if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

$offset = ($pagina_actual - 1) * $registros_por_pagina;
$bitacora_paginada = array_slice($bitacora_filtrada, $offset, $registros_por_pagina);

// Obtener años y meses disponibles
$anios_disponibles = [];
$meses_disponibles = [];
foreach ($bitacora_data as $r) {
    $anio = (int)date('Y', strtotime($r['fecha_hora']));
    $mes = (int)date('m', strtotime($r['fecha_hora']));
    if (!in_array($anio, $anios_disponibles)) $anios_disponibles[] = $anio;
    if (!in_array($mes, $meses_disponibles)) $meses_disponibles[] = $mes;
}
sort($anios_disponibles);
sort($meses_disponibles);

$meses_nombres = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

$acciones_disponibles = array_keys($acciones_map);
$mostrar_limpiar = !empty($busqueda) || $anio_filtro > 0 || $mes_filtro > 0 || !empty($accion_filtro);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <h1 class="page-title">Bitácora del Sistema</h1>
                    <p class="page-subtitle">Registro detallado de todas las acciones realizadas en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarBitacora"
                               autocomplete="off">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Año</label>
                        <select name="anio" class="filter-select" id="filtroAnio">
                            <option value="0">Todos</option>
                            <?php foreach ($anios_disponibles as $anio): ?>
                                <option value="<?= $anio ?>" <?= $anio_filtro == $anio ? 'selected' : '' ?>>
                                    <?= $anio ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Mes</label>
                        <select name="mes" class="filter-select" id="filtroMes">
                            <option value="0">Todos</option>
                            <?php foreach ($meses_disponibles as $mes): ?>
                                <option value="<?= $mes ?>" <?= $mes_filtro == $mes ? 'selected' : '' ?>>
                                    <?= $meses_nombres[$mes] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Acción</label>
                        <select name="accion" class="filter-select" id="filtroAccion">
                            <option value="">Todas</option>
                            <?php foreach ($acciones_disponibles as $accion): ?>
                                <option value="<?= $accion ?>" <?= $accion_filtro == $accion ? 'selected' : '' ?>>
                                    <?= $accion ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <a href="bitacora.php" class="btn-filter-clear <?= !$mostrar_limpiar ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-history"></i> 
                    <strong id="registrosMostrados"><?= $total_registros ?></strong> 
                    registro(s) encontrado(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaBitacora">
                    <thead>
                        <tr>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'fecha_hora', 'orden_direccion' => ($orden_columna == 'fecha_hora' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'fecha_hora' ? 'active' : '' ?>">
                                    <span class="sort-label">Fecha y Hora</span>
                                    <?php if ($orden_columna == 'fecha_hora'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'usuario', 'orden_direccion' => ($orden_columna == 'usuario' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'usuario' ? 'active' : '' ?>">
                                    <span class="sort-label">Usuario</span>
                                    <?php if ($orden_columna == 'usuario'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>Acción</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyBitacora">
                        <?php if ($total_registros > 0): ?>
                            <?php foreach ($bitacora_paginada as $registro): 
                                $accion_info = $acciones_map[$registro['accion']] ?? ['color' => '#f5f5f5', 'texto' => '#666'];
                                $fecha = date('d/m/Y', strtotime($registro['fecha_hora']));
                                $hora = date('H:i', strtotime($registro['fecha_hora']));
                            ?>
                            <tr>
                                <td>
                                    <div class="fecha-cell">
                                        <span><?= $fecha ?></span>
                                        <span class="hora-cell"><?= $hora ?> hrs</span>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($registro['usuario']) ?></td>
                                <td>
                                    <span class="badge-accion" style="background: <?= $accion_info['color'] ?>; color: <?= $accion_info['texto'] ?>;">
                                        <?= htmlspecialchars($registro['accion']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($registro['descripcion']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="empty-row">
                                    <i class="fas fa-search"></i>
                                    <p>No se encontraron registros con los filtros aplicados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <?php if ($total_paginas > 1): ?>
            <div class="pagination-container">
                <div class="pagination-info">
                    Mostrando <strong><?= count($bitacora_paginada) ?></strong> de <strong><?= $total_registros ?></strong> registros
                    <?php if ($total_paginas > 1): ?>
                        (Página <?= $pagina_actual ?> de <?= $total_paginas ?>)
                    <?php endif; ?>
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
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - BITÁCORA
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
    min-width: 650px;
}

.table-modern thead {
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 0.8rem 1rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
    white-space: nowrap;
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

.fecha-cell {
    display: flex;
    flex-direction: column;
    line-height: 1.4;
}

.hora-cell {
    font-size: 0.75rem;
    color: #999;
}

.badge-accion {
    display: inline-block;
    padding: 0.2rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

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

    .page-header-right .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }

    .filters-container {
        padding: 1rem;
    }

    .table-modern {
        min-width: 550px;
        font-size: 0.8rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.5rem 0.6rem;
    }

    .pagination-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
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
        min-width: 480px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.4rem;
    }
}
</style>

<script>
// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarBitacora');
    const filtroAnio = document.getElementById('filtroAnio');
    const filtroMes = document.getElementById('filtroMes');
    const filtroAccion = document.getElementById('filtroAccion');
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
    
    if (filtroAnio) {
        filtroAnio.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroMes) {
        filtroMes.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroAccion) {
        filtroAccion.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
});

// ============================================================
// EXPORTAR CSV - TODOS LOS REGISTROS FILTRADOS
// ============================================================

function descargarCSV() {
    const datosFiltrados = <?= json_encode(array_values($bitacora_filtrada)) ?>;
    
    if (datosFiltrados.length === 0) {
        alert('No hay datos para exportar');
        return;
    }
    
    let csv = 'Fecha,Hora,Usuario,Acción,Descripción\n';
    
    datosFiltrados.forEach(function(r) {
        const fecha = new Date(r.fecha_hora);
        const fechaStr = fecha.toLocaleDateString('es-MX');
        const horaStr = fecha.toLocaleTimeString('es-MX', {hour: '2-digit', minute: '2-digit'});
        
        csv += `"${fechaStr}","${horaStr}","${r.usuario}","${r.accion}","${r.descripcion}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `bitacora_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
}
</script>

<?php include 'template/footer.php'; ?>