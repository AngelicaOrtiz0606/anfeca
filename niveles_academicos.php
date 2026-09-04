<?php
// ============================================================
// SIDEANFECA - Catálogo de Niveles Académicos
// Listado de niveles académicos registrados
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS (BASADOS EN DIRECTORIOS.PHP)
// ============================================================

// Niveles Académicos con personas asociadas
$niveles_academicos = [
    [
        'id' => 1,
        'nombre' => 'Doctorado',
        'abr_m' => 'Dr.',
        'abr_f' => 'Dra.',
        'activo' => true,
        'personas' => 22
    ],
    [
        'id' => 2,
        'nombre' => 'Maestría',
        'abr_m' => 'Mtro.',
        'abr_f' => 'Mtra.',
        'activo' => true,
        'personas' => 15
    ],
    [
        'id' => 3,
        'nombre' => 'Especialidad',
        'abr_m' => 'Esp.',
        'abr_f' => 'Esp.',
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 4,
        'nombre' => 'Licenciatura',
        'abr_m' => 'Lic.',
        'abr_f' => 'Lic.',
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 5,
        'nombre' => 'Técnico Superior Universitario',
        'abr_m' => 'T.S.U.',
        'abr_f' => 'T.S.U.',
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 6,
        'nombre' => 'Ingeniería',
        'abr_m' => 'Ing.',
        'abr_f' => 'Ing.',
        'activo' => true,
        'personas' => 0
    ]
];

// ID máximo para nuevos registros
$ultimo_id = count($niveles_academicos);

// Personas por nivel para validar eliminación (basado en directorios.php)
$personas_por_nivel = [
    1 => 22, // Doctorado
    2 => 15, // Maestría
    3 => 1,  // Especialidad
    4 => 0,  // Licenciatura
    5 => 0,  // TSU
    6 => 0   // Ingeniería
];

// ============================================================
// PROCESAR ACCIONES DEL CRUD (SIMULADO)
// ============================================================

$mensaje = '';
$error = '';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

// Eliminar nivel académico
if ($accion === 'eliminar' && isset($_GET['id'])) {
    $id_eliminar = (int)$_GET['id'];
    $nivel_encontrado = null;
    $indice_encontrado = null;
    
    foreach ($niveles_academicos as $key => $n) {
        if ($n['id'] == $id_eliminar) {
            $nivel_encontrado = $n;
            $indice_encontrado = $key;
            break;
        }
    }
    
    if ($nivel_encontrado) {
        // Verificar si tiene personas asociadas
        $personas_asociadas = $personas_por_nivel[$id_eliminar] ?? 0;
        
        if ($personas_asociadas > 0) {
            $error = 'No se puede eliminar el nivel académico porque tiene ' . $personas_asociadas . ' persona(s) asociada(s).';
        } else {
            // Eliminar el nivel
            unset($niveles_academicos[$indice_encontrado]);
            $niveles_academicos = array_values($niveles_academicos);
            // Actualizar personas_por_nivel
            unset($personas_por_nivel[$id_eliminar]);
            $mensaje = 'Nivel académico eliminado exitosamente';
        }
    }
}

// Procesar formulario (Registro/Edición)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $nombre = trim($_POST['nombre'] ?? '');
    $abr_m = trim($_POST['abr_m'] ?? '');
    $abr_f = trim($_POST['abr_f'] ?? '');
    $activo = isset($_POST['activo']) ? true : false;
    $id_nivel = isset($_POST['id_nivel']) ? (int)$_POST['id_nivel'] : 0;
    
    if (empty($nombre)) $errores[] = 'Nombre del nivel académico';
    if (empty($abr_m)) $errores[] = 'Abreviatura en masculino';
    if (empty($abr_f)) $errores[] = 'Abreviatura en femenino';
    
    if (empty($errores)) {
        if ($id_nivel > 0) {
            // Editar nivel existente
            $encontrado = false;
            foreach ($niveles_academicos as $key => $n) {
                if ($n['id'] == $id_nivel) {
                    // Validar duplicados (excepto el mismo)
                    $duplicado = false;
                    foreach ($niveles_academicos as $otro) {
                        if ($otro['id'] != $id_nivel && strtolower($otro['nombre']) == strtolower($nombre)) {
                            $duplicado = true;
                            break;
                        }
                    }
                    if ($duplicado) {
                        $error = 'El nombre "' . $nombre . '" ya está registrado como nivel académico';
                    } else {
                        $niveles_academicos[$key]['nombre'] = $nombre;
                        $niveles_academicos[$key]['abr_m'] = $abr_m;
                        $niveles_academicos[$key]['abr_f'] = $abr_f;
                        $niveles_academicos[$key]['activo'] = $activo;
                        $encontrado = true;
                        $mensaje = 'Nivel académico actualizado exitosamente';
                    }
                    break;
                }
            }
            if (!$encontrado && empty($error)) {
                $error = 'Nivel académico no encontrado';
            }
        } else {
            // Registrar nuevo nivel
            $duplicado = false;
            foreach ($niveles_academicos as $n) {
                if (strtolower($n['nombre']) == strtolower($nombre)) {
                    $duplicado = true;
                    break;
                }
            }
            if ($duplicado) {
                $error = 'El nombre "' . $nombre . '" ya está registrado como nivel académico';
            } else {
                $ultimo_id++;
                $niveles_academicos[] = [
                    'id' => $ultimo_id,
                    'nombre' => $nombre,
                    'abr_m' => $abr_m,
                    'abr_f' => $abr_f,
                    'activo' => $activo,
                    'personas' => 0
                ];
                $personas_por_nivel[$ultimo_id] = 0;
                $mensaje = 'Nivel académico registrado exitosamente';
            }
        }
        
        if (empty($error)) {
            header('Location: niveles_academicos.php?mensaje=' . urlencode($mensaje));
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

$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : '';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'asc';

$niveles_filtrados = $niveles_academicos;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $niveles_filtrados = array_filter($niveles_filtrados, function($n) use ($busqueda) {
        return strpos(strtolower($n['nombre']), $busqueda) !== false ||
               strpos(strtolower($n['abr_m']), $busqueda) !== false ||
               strpos(strtolower($n['abr_f']), $busqueda) !== false;
    });
}

if ($estado_filtro == 'activo') {
    $niveles_filtrados = array_filter($niveles_filtrados, function($n) {
        return $n['activo'] == true;
    });
} elseif ($estado_filtro == 'inactivo') {
    $niveles_filtrados = array_filter($niveles_filtrados, function($n) {
        return $n['activo'] == false;
    });
}

// Ordenar
if (!empty($orden_columna)) {
    usort($niveles_filtrados, function($a, $b) use ($orden_columna, $orden_direccion) {
        $valor_a = '';
        $valor_b = '';
        
        switch ($orden_columna) {
            case 'nombre':
                $valor_a = $a['nombre'];
                $valor_b = $b['nombre'];
                break;
            case 'abr_m':
                $valor_a = $a['abr_m'];
                $valor_b = $b['abr_m'];
                break;
            case 'abr_f':
                $valor_a = $a['abr_f'];
                $valor_b = $b['abr_f'];
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

$total_registros = count($niveles_filtrados);

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
                    <h1 class="page-title">Catálogo de Niveles Académicos</h1>
                    <p class="page-subtitle">Administre los niveles académicos que pueden ser asignados a las personas en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <button onclick="abrirModalRegistro()" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nuevo Nivel
                </button>
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
                               placeholder="Buscar por nombre o abreviatura..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarNivel"
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
                    
                    <a href="niveles_academicos.php" class="btn-filter-clear <?= (empty($busqueda) && empty($estado_filtro)) ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-graduation-cap"></i> 
                    <strong id="registrosMostrados"><?= count($niveles_filtrados) ?></strong> 
                    nivel(es) encontrado(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaNiveles">
                    <thead>
                        <tr>
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
                            <th class="col-abr-m">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'abr_m', 'orden_direccion' => ($orden_columna == 'abr_m' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'abr_m' ? 'active' : '' ?>">
                                    <span class="sort-label">Abrev. M</span>
                                    <?php if ($orden_columna == 'abr_m'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-abr-f">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'abr_f', 'orden_direccion' => ($orden_columna == 'abr_f' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
                                   class="sort-link <?= $orden_columna == 'abr_f' ? 'active' : '' ?>">
                                    <span class="sort-label">Abrev. F</span>
                                    <?php if ($orden_columna == 'abr_f'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-personas">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'personas', 'orden_direccion' => ($orden_columna == 'personas' && $orden_direccion == 'asc') ? 'desc' : 'asc'])) ?>" 
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
                    <tbody id="tbodyNiveles">
                        <?php if (count($niveles_filtrados) > 0): ?>
                            <?php foreach ($niveles_filtrados as $nivel): 
                                $personas_count = $personas_por_nivel[$nivel['id']] ?? 0;
                                $personas_class = $personas_count > 0 ? 'badge-personas-activo' : 'badge-personas-vacio';
                                $puede_eliminar = $personas_count == 0;
                                $estado_texto = $nivel['activo'] ? 'Activo' : 'Inactivo';
                                $estado_class = $nivel['activo'] ? 'status-active' : 'status-inactive';
                            ?>
                            <tr data-id="<?= $nivel['id'] ?>" data-personas="<?= $personas_count ?>" data-activo="<?= $nivel['activo'] ? '1' : '0' ?>">
                                <td>
                                    <div class="nivel-cell">
                                        <div class="nivel-nombre"><?= htmlspecialchars($nivel['nombre']) ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($nivel['abr_m']) ?></td>
                                <td><?= htmlspecialchars($nivel['abr_f']) ?></td>
                                <td>
                                    <span class="badge-personas <?= $personas_class ?>">
                                        <?= $personas_count ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= $estado_class ?>">
                                        <i class="fas fa-circle"></i> <?= $estado_texto ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="nivel_academico_consulta.php?id=<?= $nivel['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="abrirModalEdicion(<?= $nivel['id'] ?>)" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <?php if ($puede_eliminar): ?>
                                            <button onclick="eliminarNivel(<?= $nivel['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <button onclick="eliminarNivel(<?= $nivel['id'] ?>)" class="btn-accion btn-eliminar btn-eliminar-bloqueado" title="No se puede eliminar (tiene personas asociadas)">
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
                                    <i class="fas fa-graduation-cap"></i>
                                    <p>No se encontraron niveles académicos con los filtros aplicados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Footer con total de registros -->
            <div class="table-modern-footer">
                <span>Mostrando <strong><?= count($niveles_filtrados) ?></strong> de <strong><?= $total_registros ?></strong> registros</span>
            </div>
        </div>

    </div>
</main>

<!-- Modal Registro/Edición -->
<div class="modal-overlay" id="modalNivel" style="display:none;">
    <div class="modal-card modal-card-nivel">
        <div class="modal-header">
            <i class="fas fa-graduation-cap" id="modalIcon"></i>
            <h3 id="modalTitulo">Registrar Nuevo Nivel Académico</h3>
            <button onclick="cerrarModal()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" id="formNivel">
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
                                <input type="checkbox" name="activo" id="activo" value="1" checked>
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
                    <i class="fas fa-save"></i> Guardar Nivel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal-overlay" id="modalEliminar" style="display:none;">
    <div class="modal-card modal-card-nivel">
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" id="modalIconEliminar"></i>
            <h3 id="modalTituloEliminar">Confirmar eliminación</h3>
            <button onclick="cerrarModalEliminar()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBodyEliminar">
        </div>
        <div class="modal-footer" id="modalFooterEliminar">
        </div>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - LISTADO DE NIVELES ACADÉMICOS
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
    min-width: 200px;
    max-width: 280px;
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
    min-width: 750px;
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

.col-nombre {
    width: 28%;
    min-width: 150px;
}
.col-abr-m {
    width: 13%;
    min-width: 80px;
}
.col-abr-f {
    width: 13%;
    min-width: 80px;
}
.col-personas {
    width: 12%;
    min-width: 70px;
}
.col-estado {
    width: 14%;
    min-width: 80px;
}
.col-acciones {
    width: 18%;
    min-width: 120px;
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
.nivel-nombre {
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
   MODALES
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

/* Formulario en modal */
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

/* Botón peligroso en modal */
.modal-card-nivel .btn-modal-danger {
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

.modal-card-nivel .btn-modal-danger:hover {
    background: #c62828;
}

.modal-card-nivel .btn-modal-danger:disabled {
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

    .table-modern {
        min-width: 550px;
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
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const nivelesData = <?= json_encode($niveles_academicos) ?>;
const personasPorNivel = <?= json_encode($personas_por_nivel) ?>;

// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarNivel');
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
// MODAL - REGISTRO/EDICIÓN
// ============================================================

function abrirModalRegistro() {
    const modal = document.getElementById('modalNivel');
    const titulo = document.getElementById('modalTitulo');
    const icon = document.getElementById('modalIcon');
    const btnGuardar = document.getElementById('btnGuardar');
    const idNivel = document.getElementById('id_nivel');
    const nombre = document.getElementById('nombre');
    const abrM = document.getElementById('abr_m');
    const abrF = document.getElementById('abr_f');
    const activo = document.getElementById('activo');
    
    titulo.textContent = 'Registrar Nuevo Nivel Académico';
    icon.className = 'fas fa-graduation-cap';
    btnGuardar.innerHTML = '<i class="fas fa-save"></i> Guardar Nivel';
    idNivel.value = '0';
    nombre.value = '';
    abrM.value = '';
    abrF.value = '';
    activo.checked = true;
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => nombre.focus(), 100);
}

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
// ELIMINAR NIVEL ACADÉMICO
// ============================================================

function eliminarNivel(id) {
    const nivel = nivelesData.find(n => n.id === id);
    if (!nivel) {
        mostrarMensaje('No se encontró el nivel académico', 'error');
        return;
    }
    
    const totalPersonas = personasPorNivel[id] || 0;
    const modal = document.getElementById('modalEliminar');
    const modalIcon = document.getElementById('modalIconEliminar');
    const modalTitulo = document.getElementById('modalTituloEliminar');
    const modalBody = document.getElementById('modalBodyEliminar');
    const modalFooter = document.getElementById('modalFooterEliminar');
    
    if (totalPersonas > 0) {
        modalIcon.style.color = '#e65100';
        modalIcon.className = 'fas fa-lock';
        modalTitulo.textContent = 'No se puede eliminar';
        
        modalBody.innerHTML = `
            <p style="color:#e65100;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> 
                Este nivel académico tiene <strong>${totalPersonas} persona(s)</strong> asociada(s).
            </p>
            <p>Para poder eliminar este nivel, primero debe eliminar o reasignar todas las personas asociadas.</p>
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Nivel</span>
                    <span style="color:#1a1a1a;">${nivel.nombre}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Personas asociadas</span>
                    <span style="color:#e65100;font-weight:600;">${totalPersonas}</span>
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
        modalTitulo.textContent = '¿Eliminar nivel académico?';
        
        modalBody.innerHTML = `
            <p><strong>¡Advertencia!</strong> Esta acción eliminará el nivel académico del sistema. Esta operación <strong>no se puede deshacer</strong>.</p>
            
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Nombre</span>
                    <span style="color:#1a1a1a;">${nivel.nombre}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Abrev. M</span>
                    <span style="color:#1a1a1a;">${nivel.abr_m}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Abrev. F</span>
                    <span style="color:#1a1a1a;">${nivel.abr_f}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Personas</span>
                    <span style="color:#1a1a1a;">${totalPersonas}</span>
                </div>
            </div>
            
            <p style="color:#dc3545;font-weight:600;margin-top:0.75rem;">
                <i class="fas fa-exclamation-circle"></i> 
                Se perderá toda la información asociada a este nivel.
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
    window.location.href = `niveles_academicos.php?accion=eliminar&id=${id}`;
}

// Cerrar modal de eliminar al hacer clic fuera
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
    const filas = document.querySelectorAll('#tbodyNiveles tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Nombre,Abreviatura M,Abreviatura F,Personas,Estado\n';
    
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 6) return;
        
        const nombre = celdas[0].textContent.trim();
        const abrM = celdas[1].textContent.trim();
        const abrF = celdas[2].textContent.trim();
        const personas = celdas[3].textContent.trim();
        const estado = celdas[4].textContent.trim();
        
        csv += `"${nombre}","${abrM}","${abrF}","${personas}","${estado}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `niveles_academicos_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
    
    mostrarMensaje('CSV exportado exitosamente', 'success');
}
</script>

<?php include 'template/footer.php'; ?>