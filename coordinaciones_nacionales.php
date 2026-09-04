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
// DATOS SIMULADOS - COORDINACIONES FIJAS (se guardan en sesión)
// ============================================================

// Si no existen en sesión, cargar los datos iniciales
if (!isset($_SESSION['coordinaciones'])) {
    $_SESSION['coordinaciones'] = [
        [
            'id' => 1,
            'nombre' => 'Certificación Académica',
            'orden' => 1,
            'activo' => true,
            'personas' => 2
        ],
        [
            'id' => 2,
            'nombre' => 'Academia ANFECA',
            'orden' => 2,
            'activo' => true,
            'personas' => 1
        ],
        [
            'id' => 3,
            'nombre' => 'Emprendimiento Social',
            'orden' => 3,
            'activo' => true,
            'personas' => 0
        ],
        [
            'id' => 4,
            'nombre' => 'Planes y Programas de Estudio',
            'orden' => 4,
            'activo' => true,
            'personas' => 3
        ],
        [
            'id' => 5,
            'nombre' => 'Investigación',
            'orden' => 5,
            'activo' => true,
            'personas' => 1
        ],
        [
            'id' => 6,
            'nombre' => 'Posgrado',
            'orden' => 6,
            'activo' => true,
            'personas' => 0
        ],
        [
            'id' => 7,
            'nombre' => 'Maratones',
            'orden' => 7,
            'activo' => true,
            'personas' => 0
        ],
        [
            'id' => 8,
            'nombre' => 'Historia',
            'orden' => 8,
            'activo' => true,
            'personas' => 0
        ],
        [
            'id' => 9,
            'nombre' => 'Vinculación Nacional e Internacional',
            'orden' => 9,
            'activo' => true,
            'personas' => 1
        ],
        [
            'id' => 10,
            'nombre' => 'Universidad-Empresa',
            'orden' => 10,
            'activo' => true,
            'personas' => 0
        ],
        [
            'id' => 11,
            'nombre' => 'Formación Profesional Académica',
            'orden' => 11,
            'activo' => true,
            'personas' => 2
        ],
        [
            'id' => 12,
            'nombre' => 'Responsabilidad Social Universitaria',
            'orden' => 12,
            'activo' => true,
            'personas' => 0
        ],
        [
            'id' => 13,
            'nombre' => 'Igualdad de Género',
            'orden' => 13,
            'activo' => true,
            'personas' => 1
        ],
        [
            'id' => 14,
            'nombre' => 'Desarrollo Académico Estudiantil',
            'orden' => 14,
            'activo' => true,
            'personas' => 0
        ]
    ];
}

// Cargar datos desde sesión
$coordinaciones = &$_SESSION['coordinaciones'];

// ID máximo para nuevos registros
$ultimo_id = count($coordinaciones);

// ============================================================
// PROCESAR ACCIONES
// ============================================================

$mensaje = '';
$error = '';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

// Función para verificar si un nombre ya existe (excluyendo un ID opcional)
function nombreExiste($nombre, $excluir_id = null) {
    global $coordinaciones;
    $nombre = trim(strtolower($nombre));
    foreach ($coordinaciones as $c) {
        if ($excluir_id !== null && $c['id'] == $excluir_id) {
            continue;
        }
        if (strtolower(trim($c['nombre'])) === $nombre) {
            return true;
        }
    }
    return false;
}

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
        $_SESSION['error'] = 'No se puede eliminar la coordinación porque tiene personas asociadas.';
    } else {
        foreach ($coordinaciones as $key => $c) {
            if ($c['id'] == $id_eliminar) {
                unset($coordinaciones[$key]);
                $_SESSION['mensaje'] = 'Coordinación eliminada exitosamente';
                break;
            }
        }
        $coordinaciones = array_values($coordinaciones);
        // Reordenar
        foreach ($coordinaciones as $index => &$c) {
            $c['orden'] = $index + 1;
        }
        unset($c);
    }
    header('Location: coordinaciones_nacionales.php');
    exit;
}

// Procesar reordenamiento vía POST (AJAX - Drag & Drop)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'reordenar') {
    $ordenes = isset($_POST['ordenes']) ? json_decode($_POST['ordenes'], true) : [];
    $response = ['success' => false, 'message' => 'Error al reordenar'];
    
    if (!empty($ordenes)) {
        // Actualizar órdenes
        foreach ($coordinaciones as &$c) {
            foreach ($ordenes as $item) {
                if ($c['id'] == $item['id']) {
                    $c['orden'] = (int)$item['orden'];
                    break;
                }
            }
        }
        unset($c);
        
        // Reordenar array por orden
        usort($coordinaciones, function($a, $b) {
            return $a['orden'] <=> $b['orden'];
        });
        
        $response = ['success' => true, 'message' => ''];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Registrar nueva coordinación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar']) && $_POST['registrar'] == '1') {
    $errores = [];
    
    $nombre = trim($_POST['nombre'] ?? '');
    $activo = isset($_POST['activo']) ? true : false;
    
    if (empty($nombre)) {
        $errores[] = 'Nombre de la coordinación';
    } elseif (nombreExiste($nombre)) {
        $errores[] = 'Ya existe una coordinación con ese nombre';
    }
    
    if (empty($errores)) {
        $ultimo_id++;
        $nuevo_orden = count($coordinaciones) + 1;
        $coordinaciones[] = [
            'id' => $ultimo_id,
            'nombre' => $nombre,
            'orden' => $nuevo_orden,
            'activo' => $activo,
            'personas' => 0
        ];
        $_SESSION['mensaje'] = 'Coordinación registrada exitosamente';
        header('Location: coordinaciones_nacionales.php');
        exit;
    } else {
        $_SESSION['error'] = 'Complete los campos obligatorios: ' . implode(', ', $errores);
        header('Location: coordinaciones_nacionales.php');
        exit;
    }
}

// Editar coordinación (solo nombre y estado)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar']) && $_POST['editar'] == '1') {
    $errores = [];
    
    $nombre = trim($_POST['nombre'] ?? '');
    $activo = isset($_POST['activo']) ? true : false;
    $id_coordinacion = isset($_POST['id_coordinacion']) ? (int)$_POST['id_coordinacion'] : 0;
    
    if (empty($nombre)) {
        $errores[] = 'Nombre de la coordinación';
    } elseif (nombreExiste($nombre, $id_coordinacion)) {
        $errores[] = 'Ya existe una coordinación con ese nombre';
    }
    
    if (empty($errores)) {
        $encontrado = false;
        foreach ($coordinaciones as $key => $c) {
            if ($c['id'] == $id_coordinacion) {
                $coordinaciones[$key]['nombre'] = $nombre;
                $coordinaciones[$key]['activo'] = $activo;
                $encontrado = true;
                $_SESSION['mensaje'] = 'Coordinación actualizada exitosamente';
                break;
            }
        }
        if (!$encontrado) {
            $_SESSION['error'] = 'Coordinación no encontrada';
        }
    } else {
        $_SESSION['error'] = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    }
    header('Location: coordinaciones_nacionales.php');
    exit;
}

// Mostrar mensajes desde sesión
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

// ============================================================
// FILTROS
// ============================================================

$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$coordinaciones_filtradas = $coordinaciones;



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

$total_registros = count($coordinaciones_filtradas);

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
                    
                    
                    
                    <a href="coordinaciones_nacionales.php" class="btn-filter-clear <?= (empty($busqueda) && empty($estado_filtro)) ? 'disabled' : '' ?>">
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

        <!-- Tabla con Drag & Drop -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaCoordinaciones">
                    <thead>
                        <tr>
                            <th class="col-nombre">Coordinación</th>
                            <th class="col-orden">#</th>
                            <th class="col-personas">Personas</th>
                            <th class="col-estado">Estado</th>
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCoordinaciones">
                        <?php if (count($coordinaciones_filtradas) > 0): ?>
                            <?php foreach ($coordinaciones_filtradas as $coord): 
                                $estado_texto = $coord['activo'] ? 'Activo' : 'Inactivo';
                                $estado_class = $coord['activo'] ? 'status-active' : 'status-inactive';
                                $tiene_personas = $coord['personas'] > 0;
                            ?>
                            <tr data-id="<?= $coord['id'] ?>" data-orden="<?= $coord['orden'] ?>" draggable="true">
                                <td>
                                    <div class="coord-cell">
                                        <div class="drag-handle" title="Arrastrar para reordenar">
                                            <i class="fas fa-grip-vertical"></i>
                                        </div>
                                        <div class="coord-nombre"><?= htmlspecialchars($coord['nombre']) ?></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-orden"><?= $coord['orden'] ?></span>
                                </td>
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
                                    <div class="acciones-group">
                                        <a href="coordinacion_consulta.php?id=<?= $coord['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="abrirModalEdicion(<?= $coord['id'] ?>)" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button onclick="eliminarCoordinacion(<?= $coord['id'] ?>)" class="btn-accion btn-eliminar <?= $tiene_personas ? 'btn-eliminar-bloqueado' : '' ?>" title="<?= $tiene_personas ? 'No se puede eliminar (tiene personas asociadas)' : 'Eliminar' ?>">
                                            <i class="fas <?= $tiene_personas ? 'fa-trash-alt' : 'fa-trash-alt' ?>"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-row">
                                    <i class="fas fa-sitemap"></i>
                                    <p>No se encontraron coordinaciones con los filtros aplicados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<!-- Modal Registro -->
<div class="modal-overlay" id="modalRegistro" style="display:none;">
    <div class="modal-card modal-card-coordinacion">
        <div class="modal-header">
            <i class="fas fa-plus-circle"></i>
            <h3>Registrar Nueva Coordinación</h3>
            <button onclick="cerrarModalRegistro()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="coordinaciones_nacionales.php" id="formRegistro">
            <input type="hidden" name="registrar" value="1">
            
            <div class="modal-body">
                <div class="form-grid-modal">
                    <div class="form-group">
                        <label class="form-label required">Nombre de la Coordinación</label>
                        <input type="text" name="nombre" id="nombre_registro" class="form-control" placeholder="Ej. Certificación Académica" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <input type="hidden" name="activo" value="0">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo_registro" value="1" checked>
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo_registro" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar la coordinación en los listados</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="cerrarModalRegistro()">Cancelar</button>
                <button type="submit" class="btn-modal-primary">
                    <i class="fas fa-save"></i> Guardar Coordinación
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edición (solo nombre y estado) -->
<div class="modal-overlay" id="modalEdicion" style="display:none;">
    <div class="modal-card modal-card-coordinacion">
        <div class="modal-header">
            <i class="fas fa-edit" id="modalIcon"></i>
            <h3 id="modalTitulo">Editar Coordinación</h3>
            <button onclick="cerrarModalEdicion()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="coordinaciones_nacionales.php" id="formEdicion">
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

<!-- Modal Eliminar -->
<div class="modal-overlay" id="modalEliminar" style="display:none;">
    <div class="modal-card modal-card-coordinacion">
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
    min-width: 600px;
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
    width: 38%;
    min-width: 180px;
}
.col-orden {
    width: 10%;
    min-width: 50px;
}
.col-personas {
    width: 12%;
    min-width: 70px;
}
.col-estado {
    width: 15%;
    min-width: 80px;
}
.col-acciones {
    width: 25%;
    min-width: 130px;
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

.table-modern tbody tr.dragging {
    opacity: 0.5;
}

.table-modern tbody tr.drag-over {
    border-bottom: 3px solid #8B0000;
}

.drag-handle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    color: #bbb;
    cursor: grab;
    transition: color 0.2s ease;
    flex-shrink: 0;
}

.drag-handle:hover {
    color: #8B0000;
}

.drag-handle:active {
    cursor: grabbing;
}

.coord-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.coord-nombre {
    font-weight: 600;
    color: #1a1a1a;
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

.modal-card-coordinacion .btn-modal-danger {
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

.modal-card-coordinacion .btn-modal-danger:hover {
    background: #c62828;
}

.modal-card-coordinacion .btn-modal-danger:disabled {
    background: #cccccc;
    color: #666666;
    cursor: not-allowed;
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

    .page-header-right .btn-primary-modern {
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
        min-width: 480px;
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

    .drag-handle {
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
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
// MODAL - REGISTRO
// ============================================================

function abrirModalRegistro() {
    const modal = document.getElementById('modalRegistro');
    document.getElementById('nombre_registro').value = '';
    document.getElementById('activo_registro').checked = true;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('nombre_registro').focus(), 100);
}

function cerrarModalRegistro() {
    const modal = document.getElementById('modalRegistro');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar modal de registro al hacer clic fuera
document.addEventListener('click', function(e) {
    const modalRegistro = document.getElementById('modalRegistro');
    if (modalRegistro && e.target === modalRegistro) {
        cerrarModalRegistro();
    }
});

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

// Cerrar modal de edición al hacer clic fuera
document.addEventListener('click', function(e) {
    const modalEdicion = document.getElementById('modalEdicion');
    if (modalEdicion && e.target === modalEdicion) {
        cerrarModalEdicion();
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
    
    const tienePersonas = coord.personas > 0;
    
    const modal = document.getElementById('modalEliminar');
    const modalIcon = document.getElementById('modalIconEliminar');
    const modalTitulo = document.getElementById('modalTituloEliminar');
    const modalBody = document.getElementById('modalBodyEliminar');
    const modalFooter = document.getElementById('modalFooterEliminar');
    
    if (tienePersonas) {
        modalIcon.style.color = '#e65100';
        modalIcon.className = 'fas fa-lock';
        modalTitulo.textContent = 'No se puede eliminar';
        
        modalBody.innerHTML = `
            <p style="color:#e65100;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> 
                Esta coordinación tiene <strong>${coord.personas} persona(s)</strong> asociada(s).
            </p>
            <p>Para poder eliminar esta coordinación, primero debe eliminar o reasignar todas las personas asociadas.</p>
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
                    <span style="font-weight:600;color:#666;width:120px;">Personas asociadas</span>
                    <span style="color:#e65100;font-weight:600;">${coord.personas}</span>
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
        modalTitulo.textContent = '¿Eliminar coordinación?';
        
        modalBody.innerHTML = `
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
            
            <p style="color:#dc3545;font-weight:600;margin-top:0.75rem;">
                <i class="fas fa-exclamation-circle"></i> 
                Se perderá toda la información asociada a esta coordinación.
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
    window.location.href = `coordinaciones_nacionales.php?accion=eliminar&id=${id}`;
}

// Cerrar modal de eliminar al hacer clic fuera
document.addEventListener('click', function(e) {
    const modalEliminar = document.getElementById('modalEliminar');
    if (modalEliminar && e.target === modalEliminar) {
        cerrarModalEliminar();
    }
});

// ============================================================
// DRAG & DROP - REORDENAR
// ============================================================

let draggedRow = null;
let draggedId = null;

document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('tbodyCoordinaciones');
    const filas = tbody.querySelectorAll('tr[data-id]');
    
    filas.forEach(fila => {
        fila.addEventListener('dragstart', handleDragStart);
        fila.addEventListener('dragend', handleDragEnd);
        fila.addEventListener('dragover', handleDragOver);
        fila.addEventListener('dragenter', handleDragEnter);
        fila.addEventListener('dragleave', handleDragLeave);
        fila.addEventListener('drop', handleDrop);
    });
});

function handleDragStart(e) {
    draggedRow = this;
    draggedId = parseInt(this.dataset.id);
    this.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', this.dataset.id);
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    document.querySelectorAll('#tbodyCoordinaciones tr.drag-over').forEach(el => {
        el.classList.remove('drag-over');
    });
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function handleDragEnter(e) {
    e.preventDefault();
    if (this !== draggedRow) {
        this.classList.add('drag-over');
    }
}

function handleDragLeave(e) {
    this.classList.remove('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    this.classList.remove('drag-over');
    
    if (this === draggedRow) return;
    
    const targetId = parseInt(this.dataset.id);
    if (draggedId === targetId) return;
    
    const tbody = document.getElementById('tbodyCoordinaciones');
    const filas = tbody.querySelectorAll('tr[data-id]');
    
    let draggedIndex = -1;
    let targetIndex = -1;
    filas.forEach((fila, index) => {
        if (parseInt(fila.dataset.id) === draggedId) draggedIndex = index;
        if (parseInt(fila.dataset.id) === targetId) targetIndex = index;
    });
    
    if (draggedIndex === -1 || targetIndex === -1) return;
    
    if (draggedIndex < targetIndex) {
        tbody.insertBefore(draggedRow, filas[targetIndex + 1]);
    } else {
        tbody.insertBefore(draggedRow, filas[targetIndex]);
    }
    
    actualizarOrdenes();
}

function actualizarOrdenes() {
    const tbody = document.getElementById('tbodyCoordinaciones');
    const filas = tbody.querySelectorAll('tr[data-id]');
    const ordenes = [];
    
    filas.forEach((fila, index) => {
        const nuevoOrden = index + 1;
        const badge = fila.querySelector('.badge-orden');
        if (badge) {
            badge.textContent = nuevoOrden;
        }
        fila.dataset.orden = nuevoOrden;
        ordenes.push({
            id: parseInt(fila.dataset.id),
            orden: nuevoOrden
        });
    });
    
    fetch('coordinaciones_nacionales.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'accion=reordenar&ordenes=' + encodeURIComponent(JSON.stringify(ordenes))
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Error al reordenar:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
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
</script>

<?php include 'template/footer.php'; ?>