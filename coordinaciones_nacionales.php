<?php
// ============================================================
// SIDEANFECA - Catálogo de Coordinaciones Nacionales
// Listado de coordinaciones registradas
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

// Coordinaciones Nacionales con orden
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

// ID máximo para nuevos registros
$ultimo_id = count($coordinaciones);

// ============================================================
// PROCESAR ACCIONES DEL CRUD
// ============================================================

$mensaje = '';
$error = '';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

// Eliminar coordinación
if ($accion === 'eliminar' && isset($_GET['id'])) {
    $id_eliminar = (int)$_GET['id'];
    
    // Verificar si tiene personas asociadas
    $tiene_personas = false;
    foreach ($coordinaciones as $c) {
        if ($c['id'] == $id_eliminar && $c['personas'] > 0) {
            $tiene_personas = true;
            break;
        }
    }
    
    if ($tiene_personas) {
        $error = 'No se puede eliminar la coordinación porque tiene personas asociadas.';
    } else {
        foreach ($coordinaciones as $key => $c) {
            if ($c['id'] == $id_eliminar) {
                unset($coordinaciones[$key]);
                $mensaje = 'Coordinación eliminada exitosamente';
                break;
            }
        }
        $coordinaciones = array_values($coordinaciones);
        // Reordenar
        foreach ($coordinaciones as $index => &$c) {
            $c['orden'] = $index + 1;
        }
    }
}

// Reordenar - Subir
if ($accion === 'subir' && isset($_GET['id'])) {
    $id_mover = (int)$_GET['id'];
    $index_actual = -1;
    foreach ($coordinaciones as $i => $c) {
        if ($c['id'] == $id_mover) {
            $index_actual = $i;
            break;
        }
    }
    
    if ($index_actual > 0) {
        // Intercambiar órdenes
        $temp_orden = $coordinaciones[$index_actual]['orden'];
        $coordinaciones[$index_actual]['orden'] = $coordinaciones[$index_actual - 1]['orden'];
        $coordinaciones[$index_actual - 1]['orden'] = $temp_orden;
        
        // Reordenar array por orden
        usort($coordinaciones, function($a, $b) {
            return $a['orden'] <=> $b['orden'];
        });
        
        $mensaje = 'Coordinación reordenada exitosamente';
    }
}

// Reordenar - Bajar
if ($accion === 'bajar' && isset($_GET['id'])) {
    $id_mover = (int)$_GET['id'];
    $index_actual = -1;
    foreach ($coordinaciones as $i => $c) {
        if ($c['id'] == $id_mover) {
            $index_actual = $i;
            break;
        }
    }
    
    if ($index_actual < count($coordinaciones) - 1) {
        // Intercambiar órdenes
        $temp_orden = $coordinaciones[$index_actual]['orden'];
        $coordinaciones[$index_actual]['orden'] = $coordinaciones[$index_actual + 1]['orden'];
        $coordinaciones[$index_actual + 1]['orden'] = $temp_orden;
        
        // Reordenar array por orden
        usort($coordinaciones, function($a, $b) {
            return $a['orden'] <=> $b['orden'];
        });
        
        $mensaje = 'Coordinación reordenada exitosamente';
    }
}

// Procesar formulario (Registro/Edición)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $activo = isset($_POST['activo']) ? true : false;
    $id_coordinacion = isset($_POST['id_coordinacion']) ? (int)$_POST['id_coordinacion'] : 0;
    
    if (empty($nombre)) $errores[] = 'Nombre de la coordinación';
    
    if (empty($errores)) {
        if ($id_coordinacion > 0) {
            // Editar coordinación existente
            $encontrado = false;
            foreach ($coordinaciones as $key => $c) {
                if ($c['id'] == $id_coordinacion) {
                    $coordinaciones[$key]['nombre'] = $nombre;
                    $coordinaciones[$key]['descripcion'] = $descripcion;
                    $coordinaciones[$key]['activo'] = $activo;
                    $encontrado = true;
                    $mensaje = 'Coordinación actualizada exitosamente';
                    break;
                }
            }
            if (!$encontrado) {
                $error = 'Coordinación no encontrada';
            }
        } else {
            // Registrar nueva coordinación
            $ultimo_id++;
            $nuevo_orden = count($coordinaciones) + 1;
            $coordinaciones[] = [
                'id' => $ultimo_id,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'orden' => $nuevo_orden,
                'activo' => $activo,
                'personas' => 0
            ];
            $mensaje = 'Coordinación registrada exitosamente';
        }
        
        if (empty($error)) {
            header('Location: coordinaciones.php?mensaje=' . urlencode($mensaje));
            exit;
        }
    } else {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    }
}

// Mostrar mensaje desde URL
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// ============================================================
// FILTROS Y ORDENAMIENTO
// ============================================================

$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : '';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'asc';

// Paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 6;

$coordinaciones_filtradas = $coordinaciones;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $coordinaciones_filtradas = array_filter($coordinaciones_filtradas, function($c) use ($busqueda) {
        return strpos(strtolower($c['nombre']), $busqueda) !== false ||
               strpos(strtolower($c['descripcion']), $busqueda) !== false;
    });
}

if ($estado_filtro == 'activo') {
    $coordinaciones_filtradas = array_filter($coordinaciones_filtradas, function($c) {
        return $c['activo'] == true;
    });
} elseif ($estado_filtro == 'inactivo') {
    $coordinaciones_filtradas = array_filter($coordinaciones_filtradas, function($c) {
        return $c['activo'] == false;
    });
}

// Ordenar por orden (predeterminado)
usort($coordinaciones_filtradas, function($a, $b) {
    return $a['orden'] <=> $b['orden'];
});

// Si se selecciona otra columna para ordenar
if (!empty($orden_columna) && $orden_columna != 'orden') {
    usort($coordinaciones_filtradas, function($a, $b) use ($orden_columna, $orden_direccion) {
        $valor_a = '';
        $valor_b = '';
        
        switch ($orden_columna) {
            case 'nombre':
                $valor_a = $a['nombre'];
                $valor_b = $b['nombre'];
                break;
            case 'personas':
                $valor_a = $a['personas'] ?? 0;
                $valor_b = $b['personas'] ?? 0;
                break;
            case 'activo':
                $valor_a = $a['activo'] ? 1 : 0;
                $valor_b = $b['activo'] ? 1 : 0;
                break;
            default:
                $valor_a = $a['orden'];
                $valor_b = $b['orden'];
        }
        
        if ($orden_direccion == 'asc') {
            return $valor_a <=> $valor_b;
        } else {
            return $valor_b <=> $valor_a;
        }
    });
}

// Calcular total de registros
$total_registros = count($coordinaciones_filtradas);
$total_paginas = ceil($total_registros / $registros_por_pagina);

if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

$offset = ($pagina_actual - 1) * $registros_por_pagina;
$coordinaciones_paginadas = array_slice($coordinaciones_filtradas, $offset, $registros_por_pagina);

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
                    <h1 class="page-title">Coordinaciones Nacionales</h1>
                    <p class="page-subtitle">Administre las coordinaciones nacionales de ANFECA</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <button onclick="abrirModalRegistro()" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nueva Coordinación
                </button>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>¡Excelente!</strong> <?= htmlspecialchars($mensaje) ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor revise</strong> <?= htmlspecialchars($error) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filtros y búsqueda -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar por nombre..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarCoordinacion"
                               autocomplete="off">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Estado</label>
                        <select name="estado" class="filter-select" id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="activo" <?= $estado_filtro == 'activo' ? 'selected' : '' ?>>Activas</option>
                            <option value="inactivo" <?= $estado_filtro == 'inactivo' ? 'selected' : '' ?>>Inactivas</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-filter-apply">
                        <i class="fas fa-sliders-h"></i> Aplicar
                    </button>
                    
                    <a href="coordinaciones.php" class="btn-filter-clear <?= (empty($busqueda) && empty($estado_filtro)) ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-sitemap"></i> 
                    <strong id="registrosMostrados"><?= count($coordinaciones_filtradas) ?></strong> 
                    coordinación(es) encontrada(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaCoordinaciones">
                    <thead>
                        <tr>
                            <th class="col-orden">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'orden', 'orden_direccion' => ($orden_columna == 'orden' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'orden' || empty($orden_columna) ? 'active' : '' ?>">
                                    <span class="sort-label">#</span>
                                    <?php if ($orden_columna == 'orden' || empty($orden_columna)): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-nombre">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nombre', 'orden_direccion' => ($orden_columna == 'nombre' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'nombre' ? 'active' : '' ?>">
                                    <span class="sort-label">Coordinación</span>
                                    <?php if ($orden_columna == 'nombre'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-descripcion">Descripción</th>
                            <th class="col-personas">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'personas', 'orden_direccion' => ($orden_columna == 'personas' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'personas' ? 'active' : '' ?>">
                                    <span class="sort-label">Personas</span>
                                    <?php if ($orden_columna == 'personas'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-estado">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'activo', 'orden_direccion' => ($orden_columna == 'activo' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'activo' ? 'active' : '' ?>">
                                    <span class="sort-label">Estado</span>
                                    <?php if ($orden_columna == 'activo'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-ordenar">Orden</th>
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCoordinaciones">
                        <?php if (count($coordinaciones_paginadas) > 0): ?>
                            <?php foreach ($coordinaciones_paginadas as $coord): 
                                $estado_texto = $coord['activo'] ? 'Activo' : 'Inactivo';
                                $estado_class = $coord['activo'] ? 'status-active' : 'status-inactive';
                                $puede_eliminar = $coord['personas'] == 0;
                                $es_primero = $coord['orden'] == 1;
                                $es_ultimo = $coord['orden'] == count($coordinaciones_filtradas);
                            ?>
                            <tr data-id="<?= $coord['id'] ?>" data-orden="<?= $coord['orden'] ?>">
                                <td>
                                    <span class="badge-orden"><?= $coord['orden'] ?></span>
                                </td>
                                <td>
                                    <div class="coord-cell">
                                        <div class="coord-nombre"><?= htmlspecialchars($coord['nombre']) ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($coord['descripcion']) ?></td>
                                <td>
                                    <span class="badge-personas <?= $coord['personas'] > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                                        <?= $coord['personas'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= $estado_class ?>">
                                        <i class="fas fa-circle"></i> <?= $estado_texto ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="orden-buttons">
                                        <?php if (!$es_primero): ?>
                                            <a href="coordinaciones.php?accion=subir&id=<?= $coord['id'] ?>" class="btn-orden btn-subir" title="Subir posición">
                                                <i class="fas fa-chevron-up"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="btn-orden btn-orden-disabled">
                                                <i class="fas fa-chevron-up" style="opacity:0.3;"></i>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (!$es_ultimo): ?>
                                            <a href="coordinaciones.php?accion=bajar&id=<?= $coord['id'] ?>" class="btn-orden btn-bajar" title="Bajar posición">
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="btn-orden btn-orden-disabled">
                                                <i class="fas fa-chevron-down" style="opacity:0.3;"></i>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="coordinacion_consulta.php?id=<?= $coord['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="abrirModalEdicion(<?= $coord['id'] ?>)" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <?php if ($puede_eliminar): ?>
                                            <button onclick="eliminarCoordinacion(<?= $coord['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn-accion btn-eliminar btn-eliminar-bloqueado" title="No se puede eliminar (tiene personas asociadas)">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="empty-row">
                                    <i class="fas fa-sitemap"></i>
                                    <p>No se encontraron coordinaciones con los filtros aplicados</p>
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
                    Mostrando <strong><?= count($coordinaciones_paginadas) ?></strong> de <strong><?= $total_registros ?></strong> registros
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

<!-- Modal Registro/Edición -->
<div class="modal-overlay" id="modalCoordinacion" style="display:none;">
    <div class="modal-card modal-card-coordinacion">
        <div class="modal-header">
            <i class="fas fa-sitemap" id="modalIcon"></i>
            <h3 id="modalTitulo">Registrar Nueva Coordinación</h3>
            <button onclick="cerrarModal()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" id="formCoordinacion">
            <input type="hidden" name="id_coordinacion" id="id_coordinacion" value="0">
            
            <div class="modal-body">
                <div class="form-grid-modal">
                    <div class="form-group">
                        <label class="form-label required">Nombre de la Coordinación</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Certificación Académica" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la coordinación">
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
                        <small class="form-hint">Desactive para ocultar la coordinación en los listados</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="cerrarModal()">Cancelar</button>
                <button type="submit" class="btn-modal-primary" id="btnGuardar">
                    <i class="fas fa-save"></i> Guardar Coordinación
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - COORDINACIONES NACIONALES
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

.alert-modern {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
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
    min-width: 850px;
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

.col-orden {
    width: 6%;
    min-width: 50px;
}
.col-nombre {
    width: 22%;
    min-width: 140px;
}
.col-descripcion {
    width: 25%;
    min-width: 150px;
}
.col-personas {
    width: 8%;
    min-width: 70px;
}
.col-estado {
    width: 10%;
    min-width: 80px;
}
.col-ordenar {
    width: 10%;
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

.badge-orden {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    background: #e8e0e0;
    color: #4a3a3a;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: monospace;
    text-align: center;
    min-width: 24px;
}

.coord-nombre {
    font-weight: 600;
    color: #1a1a1a;
}

.badge-personas {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    min-width: 28px;
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

.orden-buttons {
    display: flex;
    gap: 0.25rem;
    align-items: center;
}

.btn-orden {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
}

.btn-subir {
    background: #e8f5e9;
    color: #2e7d32;
}

.btn-subir:hover {
    background: #2e7d32;
    color: white;
}

.btn-bajar {
    background: #e3f2fd;
    color: #0d47a1;
}

.btn-bajar:hover {
    background: #0d47a1;
    color: white;
}

.btn-orden-disabled {
    opacity: 0.4;
    cursor: not-allowed;
    background: #f5f5f5;
    color: #999;
}

.acciones-group {
    display: flex;
    gap: 0.3rem;
    flex-wrap: wrap;
}

.btn-accion {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
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
    max-width: 580px;
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
    grid-template-columns: 1fr 1fr;
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
    
    .pagination-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .form-grid-modal {
        grid-template-columns: 1fr;
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

    .modal-card-coordinacion {
        padding: 1.25rem;
        margin: 1rem;
    }

    .form-grid-modal {
        grid-template-columns: 1fr;
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

    .table-modern {
        min-width: 650px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.4rem;
    }

    .btn-accion {
        width: 24px;
        height: 24px;
        font-size: 0.55rem;
        border-radius: 6px;
    }

    .modal-card-coordinacion {
        padding: 1rem;
        margin: 0.5rem;
    }

    .btn-orden {
        width: 24px;
        height: 24px;
        font-size: 0.6rem;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const coordinacionesData = <?= json_encode($coordinaciones) ?>;

// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarCoordinacion');
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
// TOGGLE VISIBILIDAD
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
// MODAL - REGISTRO/EDICIÓN
// ============================================================

function abrirModalRegistro() {
    const modal = document.getElementById('modalCoordinacion');
    const titulo = document.getElementById('modalTitulo');
    const icon = document.getElementById('modalIcon');
    const btnGuardar = document.getElementById('btnGuardar');
    const idCoord = document.getElementById('id_coordinacion');
    const nombre = document.getElementById('nombre');
    const descripcion = document.getElementById('descripcion');
    const activo = document.getElementById('activo');
    
    titulo.textContent = 'Registrar Nueva Coordinación';
    icon.className = 'fas fa-sitemap';
    btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar Coordinación';
    idCoord.value = '0';
    nombre.value = '';
    descripcion.value = '';
    activo.checked = true;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => nombre.focus(), 100);
}

function abrirModalEdicion(id) {
    const coord = coordinacionesData.find(c => c.id === id);
    if (!coord) {
        mostrarMensaje('No se encontró la coordinación', 'error');
        return;
    }
    
    const modal = document.getElementById('modalCoordinacion');
    const titulo = document.getElementById('modalTitulo');
    const icon = document.getElementById('modalIcon');
    const btnGuardar = document.getElementById('btnGuardar');
    const idCoord = document.getElementById('id_coordinacion');
    const nombre = document.getElementById('nombre');
    const descripcion = document.getElementById('descripcion');
    const activo = document.getElementById('activo');
    
    titulo.textContent = 'Editar Coordinación';
    icon.className = 'fas fa-edit';
    btnGuardar.innerHTML = '<i class="fas fa-save"></i> Actualizar Coordinación';
    idCoord.value = coord.id;
    nombre.value = coord.nombre;
    descripcion.value = coord.descripcion || '';
    activo.checked = coord.activo;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => nombre.focus(), 100);
}

function cerrarModal() {
    const modal = document.getElementById('modalCoordinacion');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalCoordinacion');
    if (e.target === modal) {
        cerrarModal();
    }
});

// ============================================================
// ELIMINAR COORDINACIÓN
// ============================================================

function eliminarCoordinacion(id) {
    const coord = coordinacionesData.find(c => c.id === id);
    if (!coord) {
        mostrarMensaje('No se encontró la coordinación', 'error');
        return;
    }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = 'modalEliminar';
    
    let contenidoBody = '';
    if (coord.personas > 0) {
        contenidoBody = `
            <p style="color:#c62828;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> 
                Esta coordinación tiene <strong>${coord.personas} persona(s)</strong> asociada(s).
            </p>
            <p>Para poder eliminar esta coordinación, primero debe eliminar o reasignar todas las personas asociadas.</p>
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Coordinación</span>
                    <span style="color:#1a1a1a;">${coord.nombre}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Personas asociadas</span>
                    <span style="color:#c62828;font-weight:600;">${coord.personas}</span>
                </div>
            </div>
        `;
    } else {
        contenidoBody = `
            <p><strong>¡Advertencia!</strong> Esta acción eliminará la coordinación del sistema. Esta operación <strong>no se puede deshacer</strong>.</p>
            
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Coordinación</span>
                    <span style="color:#1a1a1a;">${coord.nombre}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Orden</span>
                    <span style="color:#1a1a1a;">${coord.orden}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Estado</span>
                    <span style="color:#1a1a1a;">${coord.activo ? 'Activo' : 'Inactivo'}</span>
                </div>
            </div>
            
            <p style="color:#c62828;font-weight:600;margin-top:0.75rem;">
                <i class="fas fa-exclamation-circle"></i> 
                Se perderá toda la información asociada a esta coordinación.
            </p>
        `;
    }
    
    modal.innerHTML = `
        <div class="modal-card modal-card-coordinacion">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle" style="color:${coord.personas > 0 ? '#e65100' : '#dc3545'};"></i>
                <h3>${coord.personas > 0 ? 'No se puede eliminar' : '¿Eliminar coordinación?'}</h3>
                <button onclick="cerrarModalEliminar()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                ${contenidoBody}
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" onclick="cerrarModalEliminar()">${coord.personas > 0 ? 'Entendido' : 'Cancelar'}</button>
                ${coord.personas > 0 ? `
                    <button class="btn-modal-primary" style="background:#e65100;cursor:not-allowed;opacity:0.6;" disabled>
                        <i class="fas fa-lock"></i> No se puede eliminar
                    </button>
                ` : `
                    <button class="btn-modal-primary" style="background:#dc3545;" onclick="confirmarEliminar(${id})">
                        <i class="fas fa-trash-alt"></i> Eliminar permanentemente
                    </button>
                `}
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function cerrarModalEliminar() {
    const modal = document.getElementById('modalEliminar');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function confirmarEliminar(id) {
    window.location.href = `coordinaciones.php?accion=eliminar&id=${id}`;
}

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

// ============================================================
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    const filas = document.querySelectorAll('#tbodyCoordinaciones tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Orden,Nombre,Descripción,Personas,Estado\n';
    
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 7) return;
        
        const orden = celdas[0].textContent.trim();
        const nombre = celdas[1].textContent.trim();
        const descripcion = celdas[2].textContent.trim();
        const personas = celdas[3].textContent.trim();
        const estado = celdas[4].textContent.trim();
        
        csv += `"${orden}","${nombre}","${descripcion}","${personas}","${estado}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `coordinaciones_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
    
    mostrarMensaje('CSV exportado exitosamente', 'success');
}
</script>

<?php include 'template/footer.php'; ?>