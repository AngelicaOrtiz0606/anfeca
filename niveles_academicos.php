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
// DATOS SIMULADOS
// ============================================================

// Niveles Académicos con personas asociadas (hardcodeados)
$niveles_academicos = [
    [
        'id' => 1,
        'nombre' => 'Licenciatura',
        'abr_m' => 'Lic.',
        'abr_f' => 'Lic.',
        'personas' => 8
    ],
    [
        'id' => 2,
        'nombre' => 'Maestría',
        'abr_m' => 'Mtro.',
        'abr_f' => 'Mtra.',
        'personas' => 4
    ],
    [
        'id' => 3,
        'nombre' => 'Doctorado',
        'abr_m' => 'Dr.',
        'abr_f' => 'Dra.',
        'personas' => 2
    ],
    [
        'id' => 4,
        'nombre' => 'Especialidad',
        'abr_m' => 'Esp.',
        'abr_f' => 'Esp.',
        'personas' => 0
    ],
    [
        'id' => 5,
        'nombre' => 'Técnico Superior Universitario',
        'abr_m' => 'T.S.U.',
        'abr_f' => 'T.S.U.',
        'personas' => 0
    ],
    [
        'id' => 6,
        'nombre' => 'Ingeniería',
        'abr_m' => 'Ing.',
        'abr_f' => 'Ing.',
        'personas' => 3
    ]
];

// ID máximo para nuevos registros
$ultimo_id = count($niveles_academicos);

// Personas simuladas para validar eliminación
$personas_por_nivel = [
    1 => 8,
    2 => 4,
    3 => 2,
    4 => 0,
    5 => 0,
    6 => 3
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

// ============================================================
// FILTROS Y ORDENAMIENTO
// ============================================================

$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

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
                <a href="nivel_academico_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nuevo Nivel
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
                               placeholder="Buscar por nombre o abreviatura..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarNivel"
                               autocomplete="off">
                    </div>
                    
                    <button type="submit" class="btn-filter-apply">
                        <i class="fas fa-sliders-h"></i> Aplicar
                    </button>
                    
                    <a href="niveles_academicos.php" class="btn-filter-clear <?= empty($busqueda) ? 'disabled' : '' ?>">
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
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nombre', 'orden_direccion' => ($orden_columna == 'nombre' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
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
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'abr_m', 'orden_direccion' => ($orden_columna == 'abr_m' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
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
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'abr_f', 'orden_direccion' => ($orden_columna == 'abr_f' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
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
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyNiveles">
                        <?php if (count($niveles_filtrados) > 0): ?>
                            <?php foreach ($niveles_filtrados as $nivel): 
                                $personas_count = $personas_por_nivel[$nivel['id']] ?? 0;
                                $personas_class = $personas_count > 0 ? 'badge-personas-activo' : 'badge-personas-vacio';
                                $puede_eliminar = $personas_count == 0;
                            ?>
                            <tr data-id="<?= $nivel['id'] ?>" data-personas="<?= $personas_count ?>">
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
                                    <div class="acciones-group">
                                        <a href="nivel_academico_consulta.php?id=<?= $nivel['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="nivel_academico_edicion.php?id=<?= $nivel['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
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
                                <td colspan="5" class="empty-row">
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
    min-width: 220px;
    max-width: 350px;
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
    min-width: 650px;
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
    width: 35%;
    min-width: 180px;
}
.col-abr-m {
    width: 15%;
    min-width: 90px;
}
.col-abr-f {
    width: 15%;
    min-width: 90px;
}
.col-personas {
    width: 15%;
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
    const modalIcon = document.getElementById('modalIcon');
    const modalTitulo = document.getElementById('modalTitulo');
    const modalBody = document.getElementById('modalBody');
    const modalFooter = document.getElementById('modalFooter');
    
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
    const filas = document.querySelectorAll('#tbodyNiveles tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Nombre,Abreviatura M,Abreviatura F,Personas\n';
    
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 5) return;
        
        const nombre = celdas[0].textContent.trim();
        const abrM = celdas[1].textContent.trim();
        const abrF = celdas[2].textContent.trim();
        const personas = celdas[3].textContent.trim();
        
        csv += `"${nombre}","${abrM}","${abrF}","${personas}"\n`;
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