<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Editar institución existente
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once 'institucion_datos.php';

// ============================================================
// OBTENER INSTITUCIÓN
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$institucion = getInstitucionPorId($id);

if (!$institucion) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró la institución solicitada.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// Universidades para select de dependencia
$universidades_existentes = [];
foreach ($instituciones as $inst) {
    if ($inst['tipo'] == 1) {
        $universidades_existentes[$inst['id']] = $inst['nombre'];
    }
}

$mensaje = '';
$error = '';

// ============================================================
// PROCESAR ACCIONES
// ============================================================

$accion = $_POST['accion'] ?? '';

$es_matriz = $institucion['es_matriz'] ?? false;

// --- Guardar cambios maestros ---
if ($accion === 'guardar_datos' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];
    
    if (empty($_POST['sector'])) $errores[] = 'Sector';
    
    // Si NO es matriz, validar dirección
    if (!$es_matriz) {
        if (empty($_POST['tipo'])) $errores[] = 'Tipo de institución';
        if (empty($_POST['cp'])) $errores[] = 'Código postal';
        if (empty($_POST['calle'])) $errores[] = 'Calle';
        if (empty($_POST['numero_exterior'])) $errores[] = 'Número exterior';
        if (empty($_POST['colonia'])) $errores[] = 'Colonia';
        if (empty($_POST['municipio'])) $errores[] = 'Alcaldía/Municipio';
        if (empty($_POST['entidad'])) $errores[] = 'Entidad federativa';
        if (empty($_POST['zona'])) $errores[] = 'Zona regional';
        
        if (($_POST['tipo'] == 2 || $_POST['tipo'] == 3) && empty($_POST['universidad_padre'])) {
            $errores[] = 'Universidad de la que depende';
        }
    }
    
    if (empty($errores)) {
        $institucion['sector'] = $_POST['sector'];
        
        // Solo actualizar tipo, zona, entidad y dirección si NO es matriz
        if (!$es_matriz) {
            $institucion['tipo'] = (int)$_POST['tipo'];
            $institucion['id_zona'] = (int)$_POST['zona'];
            $institucion['id_entidad'] = (int)$_POST['entidad'];
            $institucion['id_universidad'] = ($institucion['tipo'] == 2 || $institucion['tipo'] == 3)
                ? (int)$_POST['universidad_padre'] : null;
            
            $institucion['direccion'] = [
                'calle' => trim($_POST['calle']),
                'numero_exterior' => trim($_POST['numero_exterior']),
                'numero_interior' => trim($_POST['numero_interior'] ?? ''),
                'colonia' => trim($_POST['colonia']),
                'cp' => trim($_POST['cp']),
                'municipio' => trim($_POST['municipio'])
            ];
        }
        
        $sitios = array_filter($_POST['sitios_web'] ?? [], function($u) {
            return !empty(trim($u));
        });
        $institucion['sitios_web'] = array_values($sitios);
        
        $mensaje = 'Datos de la institución actualizados exitosamente';
    } else {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    }
}

// --- Corregir nombre (sin histórico) ---
if ($accion === 'corregir_nombre' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_corregido = trim($_POST['nombre_corregido'] ?? '');
    
    if (empty($nombre_corregido)) {
        $error = 'Debe indicar el nombre';
    } elseif (mb_strlen($nombre_corregido) > 60) {
        $error = 'El nombre no puede exceder 60 caracteres';
    } else {
        // Actualizar el nombre en el historial vigente (sin crear uno nuevo)
        foreach ($institucion['historial_nombres'] as &$h) {
            if ($h['fecha_fin'] === null) {
                $h['nombre'] = $nombre_corregido;
                break;
            }
        }
        unset($h);
        
        $institucion['nombre'] = $nombre_corregido;
        
        $mensaje = 'Nombre corregido exitosamente';
    }
}

// --- Cambiar razón social (con histórico) ---
if ($accion === 'cambiar_nombre' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = trim($_POST['nuevo_nombre'] ?? '');
    $fecha_cambio = $_POST['fecha_cambio_nombre'] ?? date('Y-m-d');
    
    if (empty($nuevo_nombre)) {
        $error = 'Debe indicar el nuevo nombre de la institución';
    } elseif ($nuevo_nombre === $institucion['nombre']) {
        $error = 'El nuevo nombre debe ser diferente al actual';
    } elseif (mb_strlen($nuevo_nombre) > 60) {
        $error = 'El nombre no puede exceder 60 caracteres';
    } else {
        $fecha_fin_anterior = date('Y-m-d', strtotime($fecha_cambio . ' -1 day'));
        
        foreach ($institucion['historial_nombres'] as &$h) {
            if ($h['fecha_fin'] === null) {
                $h['fecha_fin'] = $fecha_fin_anterior;
                break;
            }
        }
        unset($h);
        
        $nuevo_id = empty($institucion['historial_nombres'])
            ? 1
            : max(array_column($institucion['historial_nombres'], 'id')) + 1;
        
        $institucion['historial_nombres'][] = [
            'id' => $nuevo_id,
            'nombre' => $nuevo_nombre,
            'fecha_inicio' => $fecha_cambio,
            'fecha_fin' => null
        ];
        
        $institucion['nombre'] = $nuevo_nombre;
        
        $mensaje = 'Razón social actualizada. El nombre anterior se conserva en el historial.';
    }
}

// --- Convertir en matriz ---
if ($accion === 'convertir_matriz' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_conversion = $_POST['fecha_conversion_matriz'] ?? date('Y-m-d');
    
    // Validar que sea Universidad
    if ($institucion['tipo'] != 1) {
        $error = 'Solo las universidades pueden convertirse en matriz';
    } elseif ($es_matriz) {
        $error = 'Esta institución ya es matriz';
    } else {
        // Marcar como matriz
        $institucion['es_matriz'] = true;
        $institucion['fecha_matriz'] = $fecha_conversion;
        
        // Eliminar dirección, zona y entidad
        $institucion['direccion'] = null;
        $institucion['id_zona'] = null;
        $institucion['id_entidad'] = null;
        
        $mensaje = 'La universidad ha sido convertida en matriz. Ahora puede registrar sus sedes.';
    }
}

// --- Revertir conversión a matriz ---
if ($accion === 'revertir_matriz' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que no tenga sedes
    $sedes = getDependenciasDe($institucion['id']);
    
    if (count($sedes) > 0) {
        $error = 'No se puede revertir la conversión porque la universidad tiene sedes registradas';
    } else {
        $institucion['es_matriz'] = false;
        $institucion['fecha_matriz'] = null;
        
        $mensaje = 'Conversión revertida. La universidad vuelve a ser una institución normal. Complete su dirección.';
    }
}

// --- Desafiliar / Finalizar observación ---
if ($accion === 'cerrar_participacion' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    
    $indice_vigente = null;
    foreach ($institucion['historial_participacion'] as $i => $p) {
        if ($p['fecha_fin'] === null) {
            $indice_vigente = $i;
            break;
        }
    }
    
    if ($indice_vigente === null) {
        $error = 'No hay una participación vigente para cerrar';
    } elseif (empty($fecha_fin)) {
        $error = 'Debe indicar la fecha en que finaliza la participación';
    } elseif ($fecha_fin < $institucion['historial_participacion'][$indice_vigente]['fecha_inicio']) {
        $error = 'La fecha de fin no puede ser anterior a la fecha de inicio del período';
    } else {
        $institucion['historial_participacion'][$indice_vigente]['fecha_fin'] = $fecha_fin;
        $mensaje = 'La participación ha sido cerrada. La institución queda inactiva pero conserva su historial.';
    }
}

// --- Convertir Observadora a Afiliada ---
if ($accion === 'convertir_afiliada' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_cambio = $_POST['fecha_cambio'] ?? date('Y-m-d');
    $nuevo_num_afiliacion = trim($_POST['nuevo_num_afiliacion'] ?? '');
    
    $indice_vigente = null;
    foreach ($institucion['historial_participacion'] as $i => $p) {
        if ($p['fecha_fin'] === null) {
            $indice_vigente = $i;
            break;
        }
    }
    
    if ($indice_vigente === null) {
        $error = 'No hay una participación vigente';
    } elseif ($institucion['historial_participacion'][$indice_vigente]['tipo'] !== 'Observadora') {
        $error = 'Solo las Observadoras pueden convertirse en Afiliadas';
    } elseif ($fecha_cambio <= $institucion['historial_participacion'][$indice_vigente]['fecha_inicio']) {
        $error = 'La fecha del cambio debe ser posterior al inicio del período actual';
    } elseif (empty($nuevo_num_afiliacion)) {
        $error = 'Debe asignar un número de afiliación';
    } elseif (!preg_match('/^[0-9]{7}$/', $nuevo_num_afiliacion)) {
        $error = 'El número de afiliación debe tener 7 dígitos';
    } else {
        $info_numero = buscarNumeroAfiliacion($nuevo_num_afiliacion);
        // Solo se rechaza si el número pertenece a OTRA institución.
        // Si pertenece a esta misma institución, se permite reutilizarlo.
        if ($info_numero && $info_numero['institucion_id'] != $id) {
            $sufijo = $info_numero['activo'] ? 'está vigente en' : 'pertenece a';
            $error = 'Este número ' . $sufijo . ' "' . $info_numero['institucion_nombre'] . '". No puede reutilizarse en otra institución.';
        }
    }
    
    if (empty($error)) {
        $fecha_fin_actual = date('Y-m-d', strtotime($fecha_cambio . ' -1 day'));
        
        $institucion['historial_participacion'][$indice_vigente]['fecha_fin'] = $fecha_fin_actual;
        
        $nuevo_id = max(array_column($institucion['historial_participacion'], 'id')) + 1;
        $institucion['historial_participacion'][] = [
            'id' => $nuevo_id,
            'tipo' => 'Afiliada',
            'num_afiliacion' => $nuevo_num_afiliacion,
            'fecha_inicio' => $fecha_cambio,
            'fecha_fin' => null
        ];
        
        $mensaje = 'La institución ha sido convertida en Afiliada exitosamente.';
    }
}

// --- Corregir datos de participación ---
if ($accion === 'corregir_participacion' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_corregido = $_POST['tipo_corregido'] ?? '';
    $num_corregido = trim($_POST['num_corregido'] ?? '');
    $fecha_inicio_corregida = $_POST['fecha_inicio_corregida'] ?? '';
    
    $indice_vigente = null;
    foreach ($institucion['historial_participacion'] as $i => $p) {
        if ($p['fecha_fin'] === null) {
            $indice_vigente = $i;
            break;
        }
    }
    
    if ($indice_vigente === null) {
        $error = 'No hay una participación vigente para corregir';
    } elseif (empty($tipo_corregido)) {
        $error = 'Debe indicar el tipo de participación';
    } elseif (empty($fecha_inicio_corregida)) {
        $error = 'Debe indicar la fecha de inicio';
    } elseif ($tipo_corregido === 'Afiliada') {
        if (empty($num_corregido)) {
            $error = 'Debe asignar un número de afiliación';
        } elseif (!preg_match('/^[0-9]{7}$/', $num_corregido)) {
            $error = 'El número de afiliación debe tener 7 dígitos';
        } else {
            $info_numero = buscarNumeroAfiliacion($num_corregido);
            // Solo valida si el número pertenece a OTRA institución.
            if ($info_numero && $info_numero['institucion_id'] != $id) {
                $sufijo = $info_numero['activo'] ? 'está vigente en' : 'pertenece a';
                $error = 'Este número ' . $sufijo . ' "' . $info_numero['institucion_nombre'] . '". No puede reutilizarse en otra institución.';
            }
        }
    }
    
    if (empty($error)) {
        $institucion['historial_participacion'][$indice_vigente]['tipo'] = $tipo_corregido;
        $institucion['historial_participacion'][$indice_vigente]['num_afiliacion'] = ($tipo_corregido === 'Afiliada') ? $num_corregido : null;
        $institucion['historial_participacion'][$indice_vigente]['fecha_inicio'] = $fecha_inicio_corregida;
        
        $mensaje = 'Datos de participación corregidos exitosamente.';
    }
}

// --- Agregar período ---
if ($accion === 'agregar_periodo' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_periodo = $_POST['periodo_tipo'] ?? '';
    $fecha_inicio = $_POST['periodo_fecha_inicio'] ?? '';
    $fecha_fin = $_POST['periodo_fecha_fin'] ?? '';
    $num_afiliacion = trim($_POST['periodo_num_afiliacion'] ?? '');
    
    $tiene_vigente = false;
    foreach ($institucion['historial_participacion'] as $p) {
        if ($p['fecha_fin'] === null) {
            $tiene_vigente = true;
            break;
        }
    }
    
    if ($tiene_vigente) {
        $error = 'Ya existe un período vigente. Debe cerrarlo antes de agregar uno nuevo.';
    } elseif (empty($tipo_periodo)) {
        $error = 'Debe indicar el tipo de participación';
    } elseif (empty($fecha_inicio)) {
        $error = 'Debe indicar la fecha de inicio';
    } elseif (!empty($fecha_fin) && $fecha_fin < $fecha_inicio) {
        $error = 'La fecha de fin no puede ser anterior a la fecha de inicio';
    } elseif ($tipo_periodo === 'Afiliada') {
        if (empty($num_afiliacion)) {
            $error = 'Debe asignar un número de afiliación';
        } elseif (!preg_match('/^[0-9]{7}$/', $num_afiliacion)) {
            $error = 'El número de afiliación debe tener 7 dígitos';
        } else {
            $info_numero = buscarNumeroAfiliacion($num_afiliacion);
            // Solo se rechaza si el número pertenece a OTRA institución.
            // Si es el mismo número que esta institución tuvo antes, se permite (reactivación).
            if ($info_numero && $info_numero['institucion_id'] != $id) {
                $sufijo = $info_numero['activo'] ? 'está vigente en' : 'pertenece a';
                $error = 'Este número ' . $sufijo . ' "' . $info_numero['institucion_nombre'] . '". No puede reutilizarse en otra institución.';
            }
        }
    }
    
    if (empty($error)) {
        $nuevo_id = empty($institucion['historial_participacion'])
            ? 1
            : max(array_column($institucion['historial_participacion'], 'id')) + 1;
        
        $institucion['historial_participacion'][] = [
            'id' => $nuevo_id,
            'tipo' => $tipo_periodo,
            'num_afiliacion' => $tipo_periodo === 'Afiliada' ? $num_afiliacion : null,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => !empty($fecha_fin) ? $fecha_fin : null
        ];
        
        $mensaje = 'Período de participación agregado exitosamente.';
    }
}

// ============================================================
// RECALCULAR DATOS DERIVADOS
// ============================================================

$es_matriz = $institucion['es_matriz'] ?? false;
$participaciones = getParticipacionesDe($institucion);
$participacion_vigente = $participaciones['vigente'];
$participaciones_anteriores = $participaciones['anteriores'];

$nombres = getNombresDe($institucion);
$nombre_vigente = $nombres['vigente'];
$nombres_anteriores = $nombres['anteriores'];

$estado_institucion = getEstadoInstitucion($institucion);
$sedes = getDependenciasDe($institucion['id']);
$tiene_sedes = count($sedes) > 0;

// Último número de afiliación de esta institución (para prellenar reactivaciones)
$ultimo_num_institucion = getUltimoNumeroDeInstitucion($institucion);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div>
                    <h1 class="page-title">Editar Institución</h1>
                    <p class="page-subtitle">Modifique los datos y gestione la participación en ANFECA</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="instituciones.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <!-- Estado general -->
        <div class="estado-banner estado-<?= $estado_institucion ?>">
            <div class="estado-banner-content">
                <span class="estado-banner-label">Estado actual</span>
                <span class="estado-banner-valor">
                    <?php if ($es_matriz): ?>
                        Matriz · <?= $estado_institucion === 'activa' ? 'con ' . count($sedes) . ' sede(s) activa(s)' : 'sin sedes activas' ?>
                    <?php elseif ($participacion_vigente): ?>
                        Activa · <?= htmlspecialchars($participacion_vigente['tipo']) ?>
                    <?php else: ?>
                        Inactiva · sin participación vigente
                    <?php endif; ?>
                </span>
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

        <!-- Formulario principal -->
        <form method="POST" id="formEdicion">
            <input type="hidden" name="accion" value="guardar_datos">
            
            <div class="form-container">
                <div class="form-legend">
                    <span class="legend-asterisk">*</span>
                    <span>Campos obligatorios</span>
                </div>

                <!-- SECCIÓN 01: IDENTIFICACIÓN -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">01</span>
                        <h3>Identificación</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="nombre-actual-bloque">
                        <div class="nombre-actual-info">
                            <span class="nombre-actual-label">Nombre actual</span>
                            <span class="nombre-actual-valor"><?= htmlspecialchars($institucion['nombre']) ?></span>
                            <?php if ($nombre_vigente): ?>
                                <span class="nombre-actual-desde">Vigente desde <?= formatearFecha($nombre_vigente['fecha_inicio']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="nombre-actual-actions">
                            <button type="button" class="btn-corregir-nombre" onclick="abrirModal('modalCorregirNombre')">
                                Corregir nombre
                            </button>
                            <button type="button" class="btn-cambiar-nombre" onclick="abrirModal('modalCambiarNombre')">
                                Cambiar razón social
                            </button>
                        </div>
                    </div>
                    
                    <?php if (count($nombres_anteriores) > 0): ?>
                    <div class="nombres-anteriores">
                        <span class="nombres-anteriores-label">Nombres anteriores</span>
                        <?php foreach ($nombres_anteriores as $h): ?>
                            <div class="nombre-anterior-item">
                                <span class="nombre-anterior-valor"><?= htmlspecialchars($h['nombre']) ?></span>
                                <span class="nombre-anterior-fechas"><?= formatearFecha($h['fecha_inicio']) ?> al <?= formatearFecha($h['fecha_fin']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- SECCIÓN 02: TIPO -->
                <?php if (!$es_matriz): ?>
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">02</span>
                        <h3>Tipo de Institución</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                <?php foreach ($tipos_institucion as $id_tipo => $nombre): ?>
                                    <option value="<?= $id_tipo ?>" <?= $institucion['tipo'] == $id_tipo ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Sector</label>
                            <select name="sector" id="sector" class="form-control" required>
                                <option value="">Seleccionar sector...</option>
                                <?php foreach ($sectores as $key => $nombre): ?>
                                    <option value="<?= $key ?>" <?= $institucion['sector'] == $key ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="universidad_padre_container" style="<?= $institucion['tipo'] != 1 ? 'display:flex; margin-top:1.5rem;' : 'display:none; margin-top:1.5rem;' ?>">
                        <label class="form-label required">Universidad de la que depende</label>
                        <select name="universidad_padre" id="universidad_padre" class="form-control" <?= $institucion['tipo'] != 1 ? 'required' : '' ?>>
                            <option value="">Seleccionar universidad...</option>
                            <?php foreach ($universidades_existentes as $id_uni => $nombre): ?>
                                <option value="<?= $id_uni ?>" <?= $institucion['id_universidad'] == $id_uni ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-hint">Institución matriz a la que pertenece esta facultad o campus</small>
                    </div>
                </div>
                <?php else: ?>
                <!-- Matriz: solo mostrar el sector -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">02</span>
                        <h3>Datos Generales</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Sector</label>
                            <select name="sector" id="sector" class="form-control" required>
                                <option value="">Seleccionar sector...</option>
                                <?php foreach ($sectores as $key => $nombre): ?>
                                    <option value="<?= $key ?>" <?= $institucion['sector'] == $key ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="matriz-info">
                        <p><strong>Esta institución es una matriz.</strong></p>
                        <p>Desde <?= formatearFecha($institucion['fecha_matriz']) ?>. No tiene dirección propia porque su rol es agrupar a sus sedes.</p>
                        <p>Actualmente tiene <strong><?= count($sedes) ?></strong> sede(s) registrada(s).</p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- SECCIÓN 03: SITIOS WEB -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">03</span>
                        <h3>Sitios Web</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-group">
                        <div id="sitios_web_container">
                            <?php if (empty($institucion['sitios_web'])): ?>
                                <div class="sitio-web-item">
                                    <div class="sitio-web-input-group">
                                        <input type="url" name="sitios_web[]" class="form-control" placeholder="https://www.ejemplo.com">
                                        <button type="button" class="btn-remove-sitio" onclick="eliminarSitioWeb(this)" style="display:none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($institucion['sitios_web'] as $index => $web): ?>
                                    <div class="sitio-web-item">
                                        <div class="sitio-web-input-group">
                                            <input type="url" name="sitios_web[]" class="form-control" 
                                                   placeholder="https://www.ejemplo.com" 
                                                   value="<?= htmlspecialchars($web) ?>">
                                            <button type="button" class="btn-remove-sitio" onclick="eliminarSitioWeb(this)" 
                                                    style="<?= $index == 0 ? 'display:none;' : 'display:flex;' ?>">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn-add-sitio" onclick="agregarSitioWeb()">
                            <i class="fas fa-plus-circle"></i> Agregar otro sitio web
                        </button>
                        <small class="form-hint">Opcional</small>
                    </div>
                </div>

                <!-- SECCIÓN 04: DIRECCIÓN (solo si NO es matriz) -->
                <?php if (!$es_matriz): ?>
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">04</span>
                        <h3>Dirección</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Código Postal</label>
                            <input type="text" name="cp" id="cp" class="form-control cp-input" 
                                   value="<?= htmlspecialchars($institucion['direccion']['cp'] ?? '') ?>" 
                                   placeholder="Ej. 04510" pattern="[0-9]{5}" maxlength="5" 
                                   inputmode="numeric" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Entidad</label>
                            <select name="entidad" id="entidad" class="form-control" required>
                                <option value="">Seleccionar entidad...</option>
                                <?php foreach ($entidades_federativas as $id_ent => $nombre): ?>
                                    <option value="<?= $id_ent ?>" <?= $institucion['id_entidad'] == $id_ent ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Alcaldía / Municipio</label>
                            <input type="text" name="municipio" id="municipio" class="form-control" 
                                   value="<?= htmlspecialchars($institucion['direccion']['municipio'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Colonia</label>
                            <input type="text" name="colonia" id="colonia" class="form-control" 
                                   value="<?= htmlspecialchars($institucion['direccion']['colonia'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Zona Regional</label>
                            <select name="zona" id="zona" class="form-control" required>
                                <option value="">Seleccionar zona...</option>
                                <?php foreach ($zonas_regionales as $id_zona => $nombre): ?>
                                    <option value="<?= $id_zona ?>" <?= $institucion['id_zona'] == $id_zona ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Calle</label>
                            <input type="text" name="calle" class="form-control" 
                                   value="<?= htmlspecialchars($institucion['direccion']['calle'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Número Exterior</label>
                            <input type="text" name="numero_exterior" class="form-control" 
                                   value="<?= htmlspecialchars($institucion['direccion']['numero_exterior'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Número Interior</label>
                            <input type="text" name="numero_interior" class="form-control" 
                                   value="<?= htmlspecialchars($institucion['direccion']['numero_interior'] ?? '') ?>">
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                    <a href="instituciones.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>

        <!-- SECCIÓN: CONVERSIÓN A MATRIZ -->
        <?php if (!$es_matriz && $institucion['tipo'] == 1): ?>
        <div class="matriz-section">
            <div class="matriz-section-content">
                <div>
                    <h2 class="matriz-section-title">Conversión a matriz</h2>
                    <p class="matriz-section-desc">
                        Si esta universidad va a operar como contenedora de facultades y campus, puede convertirla en matriz. 
                        Conservará su número de afiliación para históricos, pero no aparecerá como institución participante en los directorios nuevos.
                    </p>
                </div>
                <button type="button" class="btn-convertir-matriz" onclick="abrirModal('modalConvertirMatriz')">
                    Convertir en matriz
                </button>
            </div>
        </div>
        <?php endif; ?>

        <!-- SECCIÓN: INFORMACIÓN DE MATRIZ -->
        <?php if ($es_matriz): ?>
        <div class="matriz-section matriz-section-active">
            <div class="matriz-section-content">
                <div>
                    <h2 class="matriz-section-title">
                        Institución matriz
                        <span class="badge-matriz-inline">Desde <?= formatearFecha($institucion['fecha_matriz']) ?></span>
                    </h2>
                    <p class="matriz-section-desc">
                        Esta universidad agrupa a <?= count($sedes) ?> sede(s). Aparece en los directorios históricos anteriores a <?= formatearFecha($institucion['fecha_matriz']) ?>.
                    </p>
                </div>
                <?php if (!$tiene_sedes): ?>
                    <button type="button" class="btn-revertir-matriz" onclick="abrirModal('modalRevertirMatriz')">
                        Revertir conversión
                    </button>
                <?php else: ?>
                    <span class="matriz-section-info">Con sedes registradas, la conversión es permanente</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- SECCIÓN: PARTICIPACIÓN -->
        <?php if (!$es_matriz): ?>
        <div class="participacion-section">
            <div class="participacion-header">
                <div>
                    <h2 class="participacion-title">Participación en ANFECA</h2>
                    <p class="participacion-subtitle">
                        Cada cambio genera un nuevo período. Los anteriores se conservan para consultas históricas y los directorios de años anteriores.
                    </p>
                </div>
            </div>

            <?php if ($participacion_vigente): ?>
                <div class="participacion-vigente">
                    <div class="participacion-vigente-header">
                        <span class="badge-vigente">Activa</span>
                        <span class="badge-tipo-participacion <?= $participacion_vigente['tipo'] === 'Afiliada' ? 'badge-afiliada' : 'badge-observadora' ?>">
                            <?= htmlspecialchars($participacion_vigente['tipo']) ?>
                        </span>
                    </div>
                    <div class="participacion-vigente-body">
                        <div class="participacion-dato">
                            <span class="participacion-dato-label">Número de afiliación</span>
                            <span class="participacion-dato-valor">
                                <?= $participacion_vigente['num_afiliacion'] ? htmlspecialchars($participacion_vigente['num_afiliacion']) : 'No aplica' ?>
                            </span>
                        </div>
                        <div class="participacion-dato">
                            <span class="participacion-dato-label">Vigente desde</span>
                            <span class="participacion-dato-valor"><?= formatearFecha($participacion_vigente['fecha_inicio']) ?></span>
                        </div>
                    </div>
                    <div class="participacion-vigente-actions">
                        <button type="button" class="btn-accion btn-corregir" onclick="abrirModal('modalCorregirParticipacion')">
                            Corregir datos
                        </button>
                        <?php if ($participacion_vigente['tipo'] === 'Observadora'): ?>
                            <button type="button" class="btn-accion btn-convertir" onclick="abrirModal('modalConvertirAfiliada')">
                                Convertir en afiliada
                            </button>
                            <button type="button" class="btn-accion btn-desafiliar" onclick="abrirModal('modalDesafiliar')">
                                Finalizar proceso de observación
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn-accion btn-desafiliar" onclick="abrirModal('modalDesafiliar')">
                                Desafiliar institución
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="participacion-inactiva">
                    <div class="participacion-inactiva-header">
                        <span class="badge-inactiva">Inactiva</span>
                    </div>
                    <?php if (!empty($participaciones_anteriores)): 
                        $ultima = $participaciones_anteriores[0];
                        $ultimo_num = null;
                        foreach ($participaciones_anteriores as $p) {
                            if (!empty($p['num_afiliacion'])) {
                                $ultimo_num = $p['num_afiliacion'];
                                break;
                            }
                        }
                    ?>
                        <p class="participacion-inactiva-info">
                            Última participación registrada: <strong><?= htmlspecialchars($ultima['tipo']) ?></strong>
                            <?php if ($ultimo_num): ?>
                                · Núm. <strong><?= htmlspecialchars($ultimo_num) ?></strong>
                            <?php endif; ?>
                            <br>
                            <span class="participacion-inactiva-fechas">
                                <?= formatearFecha($ultima['fecha_inicio']) ?> al <?= formatearFecha($ultima['fecha_fin']) ?>
                            </span>
                        </p>
                        <p class="participacion-inactiva-nota">
                            Puede reutilizar su número de afiliación anterior si la institución regresa a ANFECA.
                        </p>
                    <?php endif; ?>
                    <button type="button" class="btn-agregar-periodo" onclick="abrirModal('modalAgregarPeriodo')">
                        Agregar nuevo período
                    </button>
                </div>
            <?php endif; ?>

            <?php if (count($participaciones_anteriores) > 0): ?>
                <div class="participacion-historial">
                    <h3 class="participacion-historial-title">Historial de participación</h3>
                    <div class="participacion-historial-list">
                        <?php foreach ($participaciones_anteriores as $p): ?>
                            <div class="participacion-historial-item">
                                <div class="participacion-historial-info">
                                    <span class="badge-tipo-participacion <?= $p['tipo'] === 'Afiliada' ? 'badge-afiliada' : 'badge-observadora' ?>">
                                        <?= htmlspecialchars($p['tipo']) ?>
                                    </span>
                                    <span class="participacion-historial-fechas">
                                        <?= formatearFecha($p['fecha_inicio']) ?> al <?= formatearFecha($p['fecha_fin']) ?>
                                    </span>
                                    <?php if ($p['num_afiliacion']): ?>
                                        <span class="participacion-historial-num">Núm. <?= htmlspecialchars($p['num_afiliacion']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- SECCIÓN: SEDES (solo si es matriz) -->
        <?php if ($es_matriz && $tiene_sedes): ?>
        <div class="participacion-section">
            <div class="participacion-header">
                <div>
                    <h2 class="participacion-title">Sedes registradas</h2>
                    <p class="participacion-subtitle">
                        Estas son las instituciones que dependen de esta matriz y participan directamente en ANFECA.
                    </p>
                </div>
            </div>

            <div class="sedes-list">
                <?php foreach ($sedes as $sede): 
                    $sede_estado = getEstadoInstitucion($sede);
                    $sede_participaciones = getParticipacionesDe($sede);
                    $sede_vigente = $sede_participaciones['vigente'];
                ?>
                    <div class="sede-item">
                        <div class="sede-info">
                            <a href="institucion_consulta.php?id=<?= $sede['id'] ?>" class="sede-nombre">
                                <?= htmlspecialchars($sede['nombre']) ?>
                            </a>
                            <div class="sede-meta">
                                <span class="badge-tipo-institucion"><?= getTipoNombre($sede['tipo']) ?></span>
                                <?php if ($sede_vigente): ?>
                                    <span class="badge-tipo-participacion <?= $sede_vigente['tipo'] === 'Afiliada' ? 'badge-afiliada' : 'badge-observadora' ?>">
                                        <?= htmlspecialchars($sede_vigente['tipo']) ?>
                                    </span>
                                    <?php if ($sede_vigente['num_afiliacion']): ?>
                                        <span class="sede-num">Núm. <?= htmlspecialchars($sede_vigente['num_afiliacion']) ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge-inactiva-small">Inactiva</span>
                                <?php endif; ?>
                                <?php if ($sede_estado === 'activa'): ?>
                                    <span class="status-badge status-active">
                                        <span class="status-dot"></span> Activa
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-inactive">
                                        <span class="status-dot"></span> Inactiva
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="institucion_edicion.php?id=<?= $sede['id'] ?>" class="btn-sede-editar">
                            Editar
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>

<!-- ============================================================ -->
<!-- MODAL: CORREGIR NOMBRE -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalCorregirNombre" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="corregir_nombre">
            
            <div class="modal-header">
                <h3>Corregir nombre</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalCorregirNombre')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    Corrige errores de captura en el nombre actual. <strong>No se genera histórico.</strong> Si el nombre cambia porque cambió la razón social, usa "Cambiar razón social".
                </p>
                
                <div class="form-group">
                    <label class="form-label required">Nombre correcto</label>
                    <input type="text" name="nombre_corregido" class="form-control" 
                           value="<?= htmlspecialchars($institucion['nombre']) ?>"
                           maxlength="60" required autocomplete="off">
                    <small class="form-hint">Máximo 60 caracteres</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalCorregirNombre')">Cancelar</button>
                <button type="submit" class="btn-modal-primary">Guardar corrección</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: CAMBIAR RAZÓN SOCIAL -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalCambiarNombre" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="cambiar_nombre">
            
            <div class="modal-header">
                <h3>Cambiar razón social</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalCambiarNombre')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    Registra un cambio formal de razón social. El nombre anterior se conserva en el historial y los directorios de años anteriores seguirán mostrándolo.
                </p>
                
                <div class="modal-resumen-resalte">
                    <span class="modal-resumen-resalte-label">Nombre actual</span>
                    <span class="modal-resumen-resalte-valor"><?= htmlspecialchars($institucion['nombre']) ?></span>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Nuevo nombre</label>
                    <input type="text" name="nuevo_nombre" class="form-control" 
                           maxlength="60" required autocomplete="off">
                    <small class="form-hint">Máximo 60 caracteres</small>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Fecha del cambio</label>
                    <input type="date" name="fecha_cambio_nombre" class="form-control" 
                           value="<?= date('Y-m-d') ?>" required>
                    <small class="form-hint">A partir de esta fecha la institución se llamará así</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalCambiarNombre')">Cancelar</button>
                <button type="submit" class="btn-modal-primary">Confirmar cambio</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: CONVERTIR EN MATRIZ -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalConvertirMatriz" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="convertir_matriz">
            
            <div class="modal-header">
                <h3>Convertir en matriz</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalConvertirMatriz')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    Al convertir esta universidad en matriz:
                </p>
                <ul class="modal-list">
                    <li>Conservará su número de afiliación para históricos.</li>
                    <li><strong>Se eliminará su dirección actual</strong> (la matriz no tiene dirección propia).</li>
                    <li>No aparecerá como institución participante en directorios nuevos (a partir de la fecha indicada).</li>
                    <li>En su lugar aparecerán sus sedes.</li>
                    <li>Podrá registrar sus sedes después de la conversión.</li>
                </ul>
                
                <div class="form-group">
                    <label class="form-label required">Fecha de conversión</label>
                    <input type="date" name="fecha_conversion_matriz" class="form-control" 
                           value="<?= date('Y-m-d') ?>" required>
                    <small class="form-hint">A partir de este año la universidad no aparecerá en directorios</small>
                </div>
                
                <div class="modal-aviso">
                    Esta acción no se puede deshacer si después registras sedes. Asegúrate de que esta universidad realmente va a operar como contenedora.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalConvertirMatriz')">Cancelar</button>
                <button type="submit" class="btn-modal-primary">Confirmar conversión</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: REVERTIR CONVERSIÓN A MATRIZ -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalRevertirMatriz" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="revertir_matriz">
            
            <div class="modal-header">
                <h3>Revertir conversión a matriz</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalRevertirMatriz')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    Esta universidad dejará de ser matriz. Volverá a ser una institución normal y aparecerá en directorios como antes.
                </p>
                
                <div class="modal-aviso">
                    Tendrás que capturar su dirección de nuevo después de la reversión.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalRevertirMatriz')">Cancelar</button>
                <button type="submit" class="btn-modal-danger">Revertir conversión</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: DESAFILIAR / FINALIZAR OBSERVACIÓN -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalDesafiliar" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="cerrar_participacion">
            
            <div class="modal-header">
                <h3><?= ($participacion_vigente && $participacion_vigente['tipo'] === 'Observadora') ? 'Finalizar proceso de observación' : 'Desafiliar institución' ?></h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalDesafiliar')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    La institución dejará de participar en ANFECA a partir de la fecha que indique. Su historial y número de afiliación se conservarán.
                </p>
                
                <?php if ($participacion_vigente && $participacion_vigente['num_afiliacion']): ?>
                    <div class="modal-aviso-info">
                        El número <strong><?= htmlspecialchars($participacion_vigente['num_afiliacion']) ?></strong> quedará reservado para esta institución. No podrá ser utilizado por otra, pero podrá reutilizarlo si la institución regresa.
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label required">Fecha de fin</label>
                    <input type="date" name="fecha_fin" class="form-control" 
                           value="<?= date('Y-m-d') ?>" required>
                    <small class="form-hint">A partir de esta fecha la institución queda inactiva</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalDesafiliar')">Cancelar</button>
                <button type="submit" class="btn-modal-danger">Confirmar</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: CONVERTIR OBSERVADORA A AFILIADA -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalConvertirAfiliada" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="convertir_afiliada">
            
            <?php 
            $zona_para_num = $institucion['id_zona'] ?? 1;
            $num_auto = generarNumAfiliacion($zona_para_num, date('y'));
            ?>
            
            <div class="modal-header">
                <h3>Convertir en afiliada</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalConvertirAfiliada')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    La institución aprueba su proceso de observación y se convierte en Afiliada. Se cerrará el período actual y comenzará uno nuevo.
                </p>
                
                <div class="modal-resumen">
                    <div class="modal-resumen-item">
                        <span class="modal-resumen-label">Tipo actual</span>
                        <span class="modal-resumen-valor">Observadora</span>
                    </div>
                    <div class="modal-resumen-item">
                        <span class="modal-resumen-label">Nuevo tipo</span>
                        <span class="modal-resumen-valor nuevo-valor">Afiliada</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Fecha del cambio</label>
                    <input type="date" name="fecha_cambio" class="form-control" 
                           value="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Número de afiliación</label>
                    <input type="text" name="nuevo_num_afiliacion" class="form-control afiliacion-input" 
                           value="<?= htmlspecialchars($num_auto) ?>"
                           pattern="[0-9]{7}" maxlength="7" required>
                    <small class="form-hint">Formato: Año(2) + Zona(2) + Consecutivo(3). Puede modificarlo si es necesario.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalConvertirAfiliada')">Cancelar</button>
                <button type="submit" class="btn-modal-primary">Confirmar conversión</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: CORREGIR PARTICIPACIÓN -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalCorregirParticipacion" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="corregir_participacion">
            
            <div class="modal-header">
                <h3>Corregir datos de participación</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalCorregirParticipacion')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    Corrige errores de captura en el período vigente. <strong>No se genera histórico.</strong> Si el cambio es real (afiliación, desafiliación), usa las acciones correspondientes.
                </p>
                
                <?php if ($participacion_vigente): ?>
                <div class="form-group">
                    <label class="form-label required">Tipo de participación</label>
                    <select name="tipo_corregido" id="tipo_corregido" class="form-control" required onchange="toggleNumCorregido()">
                        <option value="Observadora" <?= $participacion_vigente['tipo'] === 'Observadora' ? 'selected' : '' ?>>Observadora</option>
                        <option value="Afiliada" <?= $participacion_vigente['tipo'] === 'Afiliada' ? 'selected' : '' ?>>Afiliada</option>
                    </select>
                </div>
                
                <div class="form-group" id="num_corregido_container" style="<?= $participacion_vigente['tipo'] === 'Afiliada' ? 'display:flex;' : 'display:none;' ?>">
                    <label class="form-label required">Número de afiliación</label>
                    <input type="text" name="num_corregido" class="form-control afiliacion-input" 
                           value="<?= htmlspecialchars($participacion_vigente['num_afiliacion'] ?? '') ?>"
                           pattern="[0-9]{7}" maxlength="7">
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio_corregida" class="form-control" 
                           value="<?= htmlspecialchars($participacion_vigente['fecha_inicio']) ?>" required>
                </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalCorregirParticipacion')">Cancelar</button>
                <button type="submit" class="btn-modal-primary">Guardar corrección</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================ -->
<!-- MODAL: AGREGAR PERÍODO -->
<!-- ============================================================ -->
<div class="modal-overlay" id="modalAgregarPeriodo" style="display:none;">
    <div class="modal-card">
        <form method="POST">
            <input type="hidden" name="accion" value="agregar_periodo">
            
            <?php 
            $zona_para_num2 = $institucion['id_zona'] ?? 1;
            // Si la institución ya tuvo número, prellenar con ese número para reactivación
            if (!empty($ultimo_num_institucion)) {
                $num_auto_agregar = $ultimo_num_institucion;
            } else {
                $num_auto_agregar = generarNumAfiliacion($zona_para_num2, date('y'));
            }
            ?>
            
            <div class="modal-header">
                <h3>Agregar período de participación</h3>
                <button type="button" class="modal-close" onclick="cerrarModal('modalAgregarPeriodo')">&times;</button>
            </div>
            <div class="modal-body">
                <p class="modal-intro">
                    Útil para reactivar una institución inactiva o registrar períodos históricos que no se capturaron en su momento.
                </p>
                
                <div class="form-group">
                    <label class="form-label required">Tipo de participación</label>
                    <select name="periodo_tipo" id="periodo_tipo" class="form-control" required onchange="toggleNumAfiliacion()">
                        <option value="">Seleccionar tipo...</option>
                        <option value="Afiliada">Afiliada</option>
                        <option value="Observadora">Observadora</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label required">Fecha de inicio</label>
                    <input type="date" name="periodo_fecha_inicio" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Fecha de fin</label>
                    <input type="date" name="periodo_fecha_fin" class="form-control">
                    <small class="form-hint">Dejar en blanco si es el período vigente (reactivación)</small>
                </div>
                
                <div class="form-group" id="periodo_num_afiliacion_container" style="display:none;">
                    <label class="form-label required">Número de afiliación</label>
                    <input type="text" name="periodo_num_afiliacion" class="form-control afiliacion-input" 
                           value="<?= htmlspecialchars($num_auto_agregar) ?>"
                           pattern="[0-9]{7}" maxlength="7">
                    <small class="form-hint">Formato: Año(2) + Zona(2) + Consecutivo(3)
                        <?php if (!empty($ultimo_num_institucion)): ?>
                            · Número anterior de esta institución: <strong><?= htmlspecialchars($ultimo_num_institucion) ?></strong> (puede reutilizarlo)
                        <?php endif; ?>
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-secondary" onclick="cerrarModal('modalAgregarPeriodo')">Cancelar</button>
                <button type="submit" class="btn-modal-primary">Guardar período</button>
            </div>
        </form>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - EDICIÓN INSTITUCIÓN
   ============================================================ */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.page-header-content {
    display: flex;
    align-items: stretch;
    gap: 1rem;
}

.page-header-content::before {
    content: '';
    display: block;
    width: 4px;
    background: linear-gradient(180deg, #8B0000, #5C0000);
    border-radius: 4px;
    flex-shrink: 0;
}

.page-header-content > div {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 0.15rem 0;
}

.page-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    letter-spacing: -0.01em;
    line-height: 1.2;
}

.page-subtitle {
    color: #888;
    margin: 0.25rem 0 0 0;
    font-size: 0.9rem;
    line-height: 1.3;
}

.page-header-right {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    padding-top: 0.35rem;
}

.btn-primary-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.8rem 1.9rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
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
    padding: 0.8rem 1.6rem;
    background: white;
    color: #4a4a4a;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-outline-modern:hover {
    border-color: #8B0000;
    color: #8B0000;
}

/* Estado banner */
.estado-banner {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border: 1.5px solid;
}

.estado-banner.estado-activa {
    background: linear-gradient(135deg, #f0f9f0, #e8f5e9);
    border-color: #a5d6a7;
}

.estado-banner.estado-inactiva {
    background: #fafafa;
    border-color: #e0e0e0;
}

.estado-banner-content {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.estado-banner-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #888;
}

.estado-banner-valor {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1a1a1a;
}

.estado-banner.estado-activa .estado-banner-label {
    color: #2e7d32;
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

.alert-success i { color: #2e7d32; }

.alert-error {
    background: #fdf0f0;
    color: #7a1a1a;
    border-left: 4px solid #c62828;
}

.alert-error i { color: #c62828; }

/* Formulario */
.form-container {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.form-legend {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.55rem 1rem;
    background: #faf8f8;
    border-radius: 8px;
    margin-bottom: 2rem;
    font-size: 0.88rem;
    color: #6b6b6b;
}

.legend-asterisk {
    color: #c62828;
    font-weight: 700;
    font-size: 1rem;
}

.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid #f5f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
}

.section-number {
    font-size: 0.72rem;
    font-weight: 700;
    color: #8B0000;
    background: #f5edec;
    padding: 0.22rem 0.65rem;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

.section-header h3 {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.section-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, #e0d6d6, transparent);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

/* Bloque del nombre */
.nombre-actual-bloque {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    padding: 1.25rem 1.5rem;
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    flex-wrap: wrap;
}

.nombre-actual-info {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    flex: 1;
    min-width: 0;
}

.nombre-actual-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nombre-actual-valor {
    font-size: 1.05rem;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.3;
    word-break: break-word;
}

.nombre-actual-desde {
    font-size: 0.8rem;
    color: #888;
    margin-top: 0.15rem;
}

.nombre-actual-actions {
    display: flex;
    gap: 0.6rem;
    flex-wrap: wrap;
    flex-shrink: 0;
}

.btn-corregir-nombre {
    padding: 0.65rem 1.2rem;
    background: white;
    color: #6b6b6b;
    border: 1.5px solid #d0d0d0;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.btn-corregir-nombre:hover {
    background: #f5f5f5;
    border-color: #999;
    color: #4a4a4a;
}

.btn-cambiar-nombre {
    padding: 0.65rem 1.4rem;
    background: white;
    color: #8B0000;
    border: 1.5px solid #8B0000;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.btn-cambiar-nombre:hover {
    background: #8B0000;
    color: white;
}

/* Nombres anteriores */
.nombres-anteriores {
    margin-top: 1rem;
    padding: 1rem 1.25rem;
    background: #f5f0f0;
    border-radius: 10px;
}

.nombres-anteriores-label {
    display: block;
    font-size: 0.72rem;
    font-weight: 700;
    color: #6b5a5a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.6rem;
}

.nombre-anterior-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e8e0e0;
    flex-wrap: wrap;
}

.nombre-anterior-item:last-child {
    border-bottom: none;
}

.nombre-anterior-valor {
    font-size: 0.88rem;
    color: #4a3a3a;
    font-weight: 500;
}

.nombre-anterior-fechas {
    font-size: 0.78rem;
    color: #888;
}

/* Form Groups */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    width: 100%;
}

.form-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #3a3a3a;
    white-space: nowrap;
}

.form-label.required::after {
    content: ' *';
    color: #c62828;
}

.form-hint {
    font-size: 0.75rem;
    color: #999;
    margin-top: 0.15rem;
    line-height: 1.4;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.95rem;
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

.form-control::placeholder { color: #bbb; }

.cp-input {
    font-weight: 600;
    letter-spacing: 1px;
}

.afiliacion-input {
    font-family: monospace;
    font-size: 1.15rem;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* Sitios Web */
.sitio-web-item {
    margin-bottom: 0.5rem;
    width: 100%;
}

.sitio-web-input-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    width: 100%;
}

.sitio-web-input-group .form-control {
    flex: 1;
    min-width: 0;
}

.btn-remove-sitio {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background: #fce8e8;
    color: #c62828;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.btn-remove-sitio:hover {
    background: #c62828;
    color: white;
}

.btn-add-sitio {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 1rem;
    background: transparent;
    color: #8B0000;
    border: 1px dashed #8B0000;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.25rem;
}

.btn-add-sitio:hover {
    background: #f5edec;
    border-color: #8B0000;
}

/* Matriz info */
.matriz-info {
    background: #f5f0f0;
    border-radius: 10px;
    padding: 1.25rem 1.5rem;
    margin-top: 1rem;
}

.matriz-info p {
    margin: 0 0 0.5rem 0;
    color: #4a3a3a;
    font-size: 0.9rem;
    line-height: 1.5;
}

.matriz-info p:last-child {
    margin-bottom: 0;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

/* Sección Conversión a Matriz */
.matriz-section {
    background: white;
    border-radius: 16px;
    padding: 1.75rem 2rem;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    margin-top: 2rem;
}

.matriz-section-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
}

.matriz-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.4rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.matriz-section-desc {
    color: #6b6b6b;
    font-size: 0.9rem;
    margin: 0;
    line-height: 1.55;
    max-width: 700px;
}

.btn-convertir-matriz {
    padding: 0.75rem 1.75rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
}

.btn-convertir-matriz:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(139, 0, 0, 0.35);
}

.btn-revertir-matriz {
    padding: 0.7rem 1.5rem;
    background: white;
    color: #c62828;
    border: 1.5px solid #c62828;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.btn-revertir-matriz:hover {
    background: #c62828;
    color: white;
}

.matriz-section-info {
    font-size: 0.8rem;
    color: #888;
    font-style: italic;
    white-space: nowrap;
}

.matriz-section-active {
    background: linear-gradient(135deg, #f0f7fa, #e8f2f7);
    border-color: #b8d8e8;
}

.badge-matriz-inline {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    background: #0d47a1;
    color: white;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    vertical-align: middle;
}

/* Participación */
.participacion-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    margin-top: 2rem;
}

.participacion-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    margin-bottom: 1.75rem;
    padding-bottom: 1.25rem;
    border-bottom: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

.participacion-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.participacion-subtitle {
    font-size: 0.85rem;
    color: #888;
    margin: 0.25rem 0 0 0;
    line-height: 1.4;
    max-width: 600px;
}

.participacion-vigente {
    background: linear-gradient(135deg, #f0f9f0, #e8f5e9);
    border: 1.5px solid #a5d6a7;
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.participacion-vigente-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.badge-vigente {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.85rem;
    background: #2e7d32;
    color: white;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-vigente::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

.badge-tipo-participacion {
    display: inline-block;
    padding: 0.3rem 0.85rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
}

.badge-tipo-participacion.badge-afiliada {
    background: #d4edda;
    color: #1b5e20;
}

.badge-tipo-participacion.badge-observadora {
    background: #fff3e0;
    color: #b25000;
}

.participacion-vigente-body {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}

.participacion-dato {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.participacion-dato-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #2e7d32;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.participacion-dato-valor {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.participacion-vigente-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    padding-top: 1rem;
    border-top: 1px solid rgba(46, 125, 50, 0.15);
}

.btn-accion {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.25rem;
    background: white;
    border: 1.5px solid #d0d0d0;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    color: #4a4a4a;
}

.btn-accion:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.btn-corregir {
    border-color: #999;
    color: #6b6b6b;
}

.btn-corregir:hover {
    background: #f5f5f5;
    border-color: #6b6b6b;
    color: #4a4a4a;
}

.btn-convertir {
    border-color: #2e7d32;
    color: #2e7d32;
}

.btn-convertir:hover {
    background: #2e7d32;
    color: white;
}

.btn-desafiliar {
    border-color: #c62828;
    color: #c62828;
}

.btn-desafiliar:hover {
    background: #c62828;
    color: white;
}

/* Inactiva */
.participacion-inactiva {
    background: #fafafa;
    border: 1.5px dashed #d0d0d0;
    border-radius: 14px;
    padding: 1.75rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

.participacion-inactiva-header {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
}

.badge-inactiva {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.85rem;
    background: #888;
    color: white;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-inactiva::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
}

.badge-inactiva-small {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    background: #f5f5f5;
    color: #888;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.participacion-inactiva-info {
    color: #4a4a4a;
    font-size: 0.9rem;
    margin: 0 0 0.5rem 0;
    line-height: 1.6;
}

.participacion-inactiva-fechas {
    font-size: 0.82rem;
    color: #888;
}

.participacion-inactiva-nota {
    color: #888;
    font-size: 0.85rem;
    margin: 0.75rem 0 1.25rem 0;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.5;
}

.btn-agregar-periodo {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    color: #8B0000;
    border: 1.5px solid #8B0000;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
}

.btn-agregar-periodo:hover {
    background: #8B0000;
    color: white;
}

/* Historial */
.participacion-historial {
    margin-top: 1.5rem;
}

.participacion-historial-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin: 0 0 1rem 0;
}

.participacion-historial-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.participacion-historial-item {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    transition: all 0.2s ease;
}

.participacion-historial-item:hover {
    background: #f5f0f0;
    border-color: #e0d6d6;
}

.participacion-historial-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.participacion-historial-fechas {
    font-size: 0.88rem;
    color: #4a4a4a;
    font-weight: 500;
}

.participacion-historial-num {
    font-size: 0.82rem;
    color: #888;
    font-family: monospace;
    padding: 0.15rem 0.55rem;
    background: #f0ecec;
    border-radius: 4px;
}

/* Sedes */
.sedes-list {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.sede-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    transition: all 0.2s ease;
    flex-wrap: wrap;
}

.sede-item:hover {
    background: #f5f0f0;
    border-color: #e0d6d6;
}

.sede-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
    min-width: 0;
}

.sede-nombre {
    font-size: 0.98rem;
    font-weight: 600;
    color: #8B0000;
    text-decoration: none;
    transition: color 0.2s ease;
}

.sede-nombre:hover {
    color: #5C0000;
    text-decoration: underline;
}

.sede-meta {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.badge-tipo-institucion {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    background: #f0ecec;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.sede-num {
    font-size: 0.75rem;
    color: #888;
    font-family: monospace;
    padding: 0.1rem 0.5rem;
    background: #f0ecec;
    border-radius: 4px;
}

.btn-sede-editar {
    padding: 0.5rem 1.25rem;
    background: white;
    color: #6b1a1a;
    border: 1.5px solid #d0d0d0;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s ease;
    white-space: nowrap;
}

.btn-sede-editar:hover {
    background: #8B0000;
    color: white;
    border-color: #8B0000;
}

/* Status badge en sedes */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
}

.status-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
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
    animation: fadeIn 0.25s ease;
    padding: 1rem;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-card {
    background: white;
    border-radius: 16px;
    max-width: 520px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 1.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-header h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    line-height: 1;
    color: #999;
    cursor: pointer;
    padding: 0.15rem 0.5rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #f5f0f0;
    color: #8B0000;
}

.modal-body {
    padding: 1.5rem 1.75rem;
}

.modal-intro {
    color: #6b6b6b;
    font-size: 0.9rem;
    line-height: 1.55;
    margin: 0 0 1.5rem 0;
}

.modal-body .form-group {
    margin-bottom: 1.25rem;
}

.modal-body .form-group:last-child {
    margin-bottom: 0;
}

.modal-list {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 1rem 1.25rem 1rem 2.25rem;
    margin: 0 0 1.5rem 0;
    color: #4a4a4a;
    font-size: 0.88rem;
    line-height: 1.7;
}

.modal-list li {
    margin-bottom: 0.35rem;
}

.modal-list li:last-child {
    margin-bottom: 0;
}

.modal-resumen {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}

.modal-resumen-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.modal-resumen-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modal-resumen-valor {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.modal-resumen-valor.nuevo-valor {
    color: #8B0000;
}

.modal-resumen-resalte {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    background: #fafafa;
    border-left: 4px solid #8B0000;
    border-radius: 8px;
    padding: 0.9rem 1.1rem;
    margin-bottom: 1.5rem;
}

.modal-resumen-resalte-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modal-resumen-resalte-valor {
    font-size: 0.98rem;
    font-weight: 600;
    color: #1a1a1a;
    word-break: break-word;
}

.modal-aviso {
    background: #fff8e1;
    border: 1px solid #ffe082;
    border-radius: 10px;
    padding: 0.9rem 1.1rem;
    font-size: 0.85rem;
    color: #7a5a1a;
    line-height: 1.5;
    margin-top: 0.5rem;
}

.modal-aviso-info {
    background: #e3f2fd;
    border: 1px solid #90caf9;
    border-radius: 10px;
    padding: 0.9rem 1.1rem;
    font-size: 0.85rem;
    color: #0d47a1;
    line-height: 1.5;
    margin-bottom: 1.25rem;
}

.modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding: 1.25rem 1.75rem;
    border-top: 1px solid #f5f0f0;
    background: #fafafa;
    border-radius: 0 0 16px 16px;
}

.btn-modal-secondary {
    padding: 0.7rem 1.5rem;
    background: white;
    color: #4a4a4a;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
}

.btn-modal-secondary:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.btn-modal-primary {
    padding: 0.7rem 1.75rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
}

.btn-modal-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(139, 0, 0, 0.3);
}

.btn-modal-danger {
    padding: 0.7rem 1.75rem;
    background: #c62828;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(198, 40, 40, 0.2);
}

.btn-modal-danger:hover {
    background: #b71c1c;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(198, 40, 40, 0.3);
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 992px) {
    .form-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
    }

    .page-header-right {
        flex-direction: column;
        align-items: stretch;
    }

    .page-header-right .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }

    .form-container {
        padding: 1.25rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn-primary-modern,
    .form-actions .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }

    .sitio-web-input-group {
        flex-direction: column;
    }

    .participacion-section {
        padding: 1.25rem;
    }

    .participacion-vigente-body {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .participacion-vigente-actions {
        flex-direction: column;
    }

    .btn-accion {
        width: 100%;
        justify-content: center;
    }

    .nombre-actual-bloque {
        flex-direction: column;
        align-items: stretch;
    }

    .nombre-actual-actions {
        flex-direction: column;
    }

    .btn-corregir-nombre,
    .btn-cambiar-nombre {
        width: 100%;
    }

    .matriz-section-content {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
    }

    .btn-convertir-matriz,
    .btn-revertir-matriz {
        width: 100%;
    }

    .modal-resumen {
        grid-template-columns: 1fr;
    }

    .modal-footer {
        flex-direction: column;
    }

    .modal-footer button {
        width: 100%;
        justify-content: center;
    }

    .sede-item {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-sede-editar {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.2rem;
    }

    .form-container,
    .participacion-section,
    .matriz-section {
        padding: 1rem;
    }

    .form-label {
        font-size: 0.8rem;
        white-space: normal;
    }

    .form-control {
        padding: 0.6rem 0.9rem;
        font-size: 0.9rem;
    }

    .afiliacion-input {
        font-size: 1rem;
    }

    .btn-remove-sitio {
        width: 34px;
        height: 34px;
    }

    .modal-header,
    .modal-body,
    .modal-footer {
        padding-left: 1.25rem;
        padding-right: 1.25rem;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const zonaPorEntidad = <?= json_encode($zona_por_entidad) ?>;
const datosPorCP = <?= json_encode($datos_por_cp) ?>;

// ============================================================
// MODALES
// ============================================================

function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = 'auto';
}

document.querySelectorAll('.modal-overlay').forEach(function(modal) {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
});

// ============================================================
// TOGGLE NÚMERO DE AFILIACIÓN EN MODALES
// ============================================================

function toggleNumAfiliacion() {
    const tipo = document.getElementById('periodo_tipo').value;
    const container = document.getElementById('periodo_num_afiliacion_container');
    const input = container.querySelector('input');
    
    if (tipo === 'Afiliada') {
        container.style.display = 'flex';
        input.setAttribute('required', 'required');
    } else {
        container.style.display = 'none';
        input.removeAttribute('required');
    }
}

function toggleNumCorregido() {
    const tipo = document.getElementById('tipo_corregido').value;
    const container = document.getElementById('num_corregido_container');
    const input = container.querySelector('input');
    
    if (tipo === 'Afiliada') {
        container.style.display = 'flex';
        input.setAttribute('required', 'required');
    } else {
        container.style.display = 'none';
        input.removeAttribute('required');
        input.value = '';
    }
}

// ============================================================
// TIPO DE INSTITUCIÓN → MOSTRAR UNIVERSIDAD PADRE
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const universidadContainer = document.getElementById('universidad_padre_container');
    const universidadSelect = document.getElementById('universidad_padre');
    
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            const tipo = parseInt(this.value);
            
            if (tipo === 2 || tipo === 3) {
                universidadContainer.style.display = 'flex';
                universidadSelect.setAttribute('required', 'required');
            } else {
                universidadContainer.style.display = 'none';
                universidadSelect.removeAttribute('required');
                universidadSelect.value = '';
            }
        });
    }
});

// ============================================================
// CÓDIGO POSTAL → AUTOCOMPLETAR
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const cpInput = document.getElementById('cp');
    if (!cpInput) return;
    
    const entidadSelect = document.getElementById('entidad');
    const zonaSelect = document.getElementById('zona');
    const coloniaInput = document.getElementById('colonia');
    const municipioInput = document.getElementById('municipio');
    
    function cargarDatosPorCP() {
        const cp = cpInput.value.trim();
        const existing = document.querySelector('.cp-mensaje');
        if (existing) existing.remove();
        
        if (cp.length === 5 && datosPorCP[cp]) {
            const datos = datosPorCP[cp];
            if (datos.entidad) entidadSelect.value = datos.entidad;
            if (datos.municipio) municipioInput.value = datos.municipio;
            if (datos.colonia) coloniaInput.value = datos.colonia;
            if (datos.zona) zonaSelect.value = datos.zona;
            
            mostrarMensajeCP('Datos cargados correctamente', 'success');
        } else if (cp.length === 5) {
            mostrarMensajeCP('No se encontraron datos para este código postal', 'error');
        }
    }
    
    function mostrarMensajeCP(mensaje, tipo) {
        const existing = document.querySelector('.cp-mensaje');
        if (existing) existing.remove();
        const div = document.createElement('div');
        div.className = 'cp-mensaje';
        div.style.cssText = `
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 6px;
            margin-top: 0.25rem;
            color: ${tipo === 'success' ? '#2e7d32' : '#c62828'};
            background: ${tipo === 'success' ? '#e8f5e9' : '#fce4ec'};
        `;
        div.textContent = mensaje;
        cpInput.parentNode.appendChild(div);
    }
    
    cpInput.addEventListener('blur', cargarDatosPorCP);
    cpInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); cargarDatosPorCP(); }
    });
    
    if (entidadSelect && zonaSelect) {
        entidadSelect.addEventListener('change', function() {
            const entidadId = parseInt(this.value);
            if (entidadId && zonaPorEntidad[entidadId]) {
                zonaSelect.value = zonaPorEntidad[entidadId];
            }
        });
    }
});

// ============================================================
// SITIOS WEB
// ============================================================

function agregarSitioWeb() {
    const container = document.getElementById('sitios_web_container');
    const nuevoItem = document.createElement('div');
    nuevoItem.className = 'sitio-web-item';
    nuevoItem.innerHTML = `
        <div class="sitio-web-input-group">
            <input type="url" name="sitios_web[]" class="form-control" placeholder="https://www.ejemplo.com">
            <button type="button" class="btn-remove-sitio" onclick="eliminarSitioWeb(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(nuevoItem);
    container.querySelectorAll('.btn-remove-sitio').forEach(function(btn) {
        btn.style.display = 'flex';
    });
}

function eliminarSitioWeb(btn) {
    const container = document.getElementById('sitios_web_container');
    if (container.querySelectorAll('.sitio-web-item').length > 1) {
        btn.closest('.sitio-web-item').remove();
    }
}
</script>

<?php include 'template/footer.php'; ?>