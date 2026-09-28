<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Consulta de institución (vista de solo lectura)
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
    include 'template/header.php';
    include 'template/menu.php';
    echo '<main class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><div><strong>Error</strong> No se encontró la institución solicitada.</div></div></div></main>';
    include 'template/footer.php';
    exit;
}

// ============================================================
// DATOS DERIVADOS
// ============================================================

$es_matriz = $institucion['es_matriz'] ?? false;

$participaciones = getParticipacionesDe($institucion);
$participacion_vigente = $participaciones['vigente'];
$participaciones_anteriores = $participaciones['anteriores'];

$nombres = getNombresDe($institucion);
$nombre_vigente = $nombres['vigente'];
$nombres_anteriores = $nombres['anteriores'];

$estado_institucion = getEstadoInstitucion($institucion);
$esta_activa = ($estado_institucion === 'activa');

$sedes = getDependenciasDe($institucion['id']);
$tiene_sedes = count($sedes) > 0;

// Universidad padre
$universidad_padre = null;
if ($institucion['id_universidad']) {
    $universidad_padre = getInstitucionPorId($institucion['id_universidad']);
}

// Personas asociadas
$personas = $personas_asociadas[$institucion['id']] ?? [];
$personas_activas = array_filter($personas, function($p) { return !empty($p['activo']); });
$personas_inactivas = array_filter($personas, function($p) { return empty($p['activo']); });

$total_personas = count($personas);
$total_activas = count($personas_activas);
$total_inactivas = count($personas_inactivas);

// Dirección formateada
$direccion = $institucion['direccion'] ?? null;

// Número de afiliación vigente / último
$num_afiliacion_actual = null;
if ($participacion_vigente && !empty($participacion_vigente['num_afiliacion'])) {
    $num_afiliacion_actual = $participacion_vigente['num_afiliacion'];
} elseif (!$esta_activa && !empty($participaciones_anteriores)) {
    foreach ($participaciones_anteriores as $p) {
        if (!empty($p['num_afiliacion'])) {
            $num_afiliacion_actual = $p['num_afiliacion'];
            break;
        }
    }
}

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">

        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div>
                    <div class="page-eyebrow">
                        <?= $es_matriz ? 'Institución matriz' : getTipoNombre($institucion['tipo']) ?>
                    </div>
                    <h1 class="page-title"><?= htmlspecialchars($institucion['nombre']) ?></h1>
                    <div class="page-meta">
                        <span class="status-badge <?= $esta_activa ? 'status-active' : 'status-inactive' ?>">
                            <span class="status-dot"></span>
                            <?= $esta_activa ? 'Activa' : 'Inactiva' ?>
                        </span>
                        <?php if ($num_afiliacion_actual): ?>
                            <span class="meta-num">Núm. <?= htmlspecialchars($num_afiliacion_actual) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="page-header-right">
                <a href="instituciones.php" class="btn-outline-modern">
                    Volver al listado
                </a>
                <a href="institucion_edicion.php?id=<?= $institucion['id'] ?>" class="btn-primary-modern">
                    Editar institución
                </a>
            </div>
        </div>

        <!-- Pestañas -->
        <div class="tabs-container">
            <nav class="tabs-nav" role="tablist">
                <button class="tab-btn active" data-tab="tab-general" role="tab">General</button>
                <button class="tab-btn" data-tab="tab-participacion" role="tab">Participación</button>
                <button class="tab-btn" data-tab="tab-nombres" role="tab">Historial de nombres</button>
                <button class="tab-btn" data-tab="tab-personas" role="tab">
                    Personas
                    <?php if ($total_activas > 0): ?>
                        <span class="tab-badge"><?= $total_activas ?></span>
                    <?php endif; ?>
                </button>
                <?php if ($es_matriz && $tiene_sedes): ?>
                <button class="tab-btn" data-tab="tab-sedes" role="tab">
                    Sedes
                    <span class="tab-badge tab-badge-neutral"><?= count($sedes) ?></span>
                </button>
                <?php endif; ?>
            </nav>

            <!-- ============================================================ -->
            <!-- TAB: GENERAL -->
            <!-- ============================================================ -->
            <div class="tab-panel active" id="tab-general" role="tabpanel">

                <div class="info-grid">
                    <!-- Identificación -->
                    <div class="info-card">
                        <h3 class="info-card-title">Identificación</h3>
                        <dl class="info-list">
                            <div class="info-row">
                                <dt>Tipo</dt>
                                <dd><?= $es_matriz ? 'Matriz contenedora' : getTipoNombre($institucion['tipo']) ?></dd>
                            </div>
                            <div class="info-row">
                                <dt>Sector</dt>
                                <dd><?= htmlspecialchars($sectores[$institucion['sector']] ?? $institucion['sector']) ?></dd>
                            </div>
                            <?php if ($universidad_padre): ?>
                            <div class="info-row">
                                <dt>Depende de</dt>
                                <dd>
                                    <a href="institucion_consulta.php?id=<?= $universidad_padre['id'] ?>" class="link-institucion">
                                        <?= htmlspecialchars($universidad_padre['nombre']) ?>
                                    </a>
                                </dd>
                            </div>
                            <?php endif; ?>
                            <?php if ($es_matriz): ?>
                            <div class="info-row">
                                <dt>Matriz desde</dt>
                                <dd><?= formatearFecha($institucion['fecha_matriz']) ?></dd>
                            </div>
                            <?php endif; ?>
                            <?php if ($num_afiliacion_actual): ?>
                            <div class="info-row">
                                <dt>Núm. afiliación</dt>
                                <dd><span class="num-destacado"><?= htmlspecialchars($num_afiliacion_actual) ?></span></dd>
                            </div>
                            <?php endif; ?>
                        </dl>
                    </div>

                    <!-- Ubicación -->
                    <?php if (!$es_matriz && $direccion): ?>
                    <div class="info-card">
                        <h3 class="info-card-title">Ubicación</h3>
                        <dl class="info-list">
                            <div class="info-row">
                                <dt>Dirección</dt>
                                <dd>
                                    <?= htmlspecialchars($direccion['calle']) ?>
                                    <?= htmlspecialchars($direccion['numero_exterior']) ?>
                                    <?php if (!empty($direccion['numero_interior'])): ?>
                                        , Int. <?= htmlspecialchars($direccion['numero_interior']) ?>
                                    <?php endif; ?>
                                </dd>
                            </div>
                            <div class="info-row">
                                <dt>Colonia</dt>
                                <dd><?= htmlspecialchars($direccion['colonia']) ?></dd>
                            </div>
                            <div class="info-row">
                                <dt>Municipio</dt>
                                <dd><?= htmlspecialchars($direccion['municipio']) ?></dd>
                            </div>
                            <div class="info-row">
                                <dt>Entidad</dt>
                                <dd><?= htmlspecialchars(getEntidadNombre($institucion['id_entidad'])) ?></dd>
                            </div>
                            <div class="info-row">
                                <dt>C.P.</dt>
                                <dd><?= htmlspecialchars($direccion['cp']) ?></dd>
                            </div>
                            <div class="info-row">
                                <dt>Zona regional</dt>
                                <dd><?= htmlspecialchars(getZonaNombre($institucion['id_zona'])) ?></dd>
                            </div>
                        </dl>
                    </div>
                    <?php elseif ($es_matriz): ?>
                    <div class="info-card info-card-muted">
                        <h3 class="info-card-title">Ubicación</h3>
                        <p class="info-muted-text">
                            Las instituciones matriz no tienen dirección propia. Cada una de sus sedes registra su ubicación de manera independiente.
                        </p>
                    </div>
                    <?php endif; ?>

                    <!-- Sitios web -->
                    <div class="info-card">
                        <h3 class="info-card-title">Sitios web</h3>
                        <?php if (!empty($institucion['sitios_web'])): ?>
                            <ul class="sitios-list">
                                <?php foreach ($institucion['sitios_web'] as $web): ?>
                                    <li>
                                        <a href="<?= htmlspecialchars($web) ?>" target="_blank" rel="noopener" class="link-externo">
                                            <?= htmlspecialchars($web) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="info-muted-text">Sin sitios web registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- ============================================================ -->
            <!-- TAB: PARTICIPACIÓN -->
            <!-- ============================================================ -->
            <div class="tab-panel" id="tab-participacion" role="tabpanel">

                <?php if ($es_matriz): ?>
                    <div class="empty-tab">
                        <h3>Sin participación propia</h3>
                        <p>
                            Esta universidad opera como matriz contenedora. Su participación en ANFECA se refleja a través
                            de sus sedes, que son las que se afilian o participan como observadoras de manera individual.
                        </p>
                        <?php if ($tiene_sedes): ?>
                            <button type="button" class="btn-text" data-goto-tab="tab-sedes">Ver sedes registradas</button>
                        <?php endif; ?>
                    </div>
                <?php else: ?>

                    <!-- Participación vigente o estado inactivo -->
                    <?php if ($participacion_vigente): ?>
                        <div class="section-block">
                            <h3 class="section-block-title">Participación vigente</h3>
                            <div class="participacion-actual">
                                <div class="participacion-actual-head">
                                    <span class="badge-participacion badge-<?= strtolower($participacion_vigente['tipo']) ?>">
                                        <?= htmlspecialchars($participacion_vigente['tipo']) ?>
                                    </span>
                                    <span class="status-badge status-active">
                                        <span class="status-dot"></span> Activa
                                    </span>
                                </div>
                                <dl class="info-list info-list-horizontal">
                                    <?php if ($participacion_vigente['num_afiliacion']): ?>
                                    <div class="info-row">
                                        <dt>Núm. afiliación</dt>
                                        <dd><span class="num-destacado"><?= htmlspecialchars($participacion_vigente['num_afiliacion']) ?></span></dd>
                                    </div>
                                    <?php endif; ?>
                                    <div class="info-row">
                                        <dt>Vigente desde</dt>
                                        <dd><?= formatearFecha($participacion_vigente['fecha_inicio']) ?></dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="section-block">
                            <h3 class="section-block-title">Participación vigente</h3>
                            <div class="participacion-inactiva-box">
                                <span class="status-badge status-inactive">
                                    <span class="status-dot"></span> Sin participación vigente
                                </span>
                                <?php if (!empty($participaciones_anteriores)): 
                                    $ultima = $participaciones_anteriores[0];
                                ?>
                                    <p class="inactiva-nota">
                                        Última participación: <strong><?= htmlspecialchars($ultima['tipo']) ?></strong>
                                        del <?= formatearFecha($ultima['fecha_inicio']) ?> al <?= formatearFecha($ultima['fecha_fin']) ?>.
                                        Conserva su número de afiliación para una futura reactivación.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Historial completo -->
                    <div class="section-block">
                        <h3 class="section-block-title">
                            Historial de participación
                            <span class="count-tag"><?= count($participaciones['vigente'] ? array_merge([$participaciones['vigente']], $participaciones_anteriores) : $participaciones_anteriores) ?> período(s)</span>
                        </h3>

                        <?php 
                        $todos_periodos = [];
                        if ($participacion_vigente) $todos_periodos[] = $participacion_vigente;
                        foreach ($participaciones_anteriores as $p) $todos_periodos[] = $p;
                        ?>

                        <?php if (count($todos_periodos) > 0): ?>
                            <ol class="timeline">
                                <?php foreach ($todos_periodos as $p): 
                                    $es_vigente = ($p['fecha_fin'] === null);
                                ?>
                                    <li class="timeline-item <?= $es_vigente ? 'timeline-item-active' : '' ?>">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <div class="timeline-head">
                                                <span class="badge-participacion badge-<?= strtolower($p['tipo']) ?>">
                                                    <?= htmlspecialchars($p['tipo']) ?>
                                                </span>
                                                <?php if ($es_vigente): ?>
                                                    <span class="timeline-tag">Vigente</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="timeline-body">
                                                <div class="timeline-fechas">
                                                    <?= formatearFecha($p['fecha_inicio']) ?>
                                                    <?php if ($p['fecha_fin']): ?>
                                                        &ndash; <?= formatearFecha($p['fecha_fin']) ?>
                                                    <?php else: ?>
                                                        &ndash; actualidad
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($p['num_afiliacion']): ?>
                                                    <div class="timeline-num">Núm. <?= htmlspecialchars($p['num_afiliacion']) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        <?php else: ?>
                            <p class="info-muted-text">Sin registros de participación.</p>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

            </div>

            <!-- ============================================================ -->
            <!-- TAB: HISTORIAL DE NOMBRES -->
            <!-- ============================================================ -->
            <div class="tab-panel" id="tab-nombres" role="tabpanel">

                <div class="section-block">
                    <h3 class="section-block-title">
                        Nombre vigente
                    </h3>
                    <div class="nombre-vigente-box">
                        <div class="nombre-vigente-texto"><?= htmlspecialchars($institucion['nombre']) ?></div>
                        <?php if ($nombre_vigente): ?>
                            <div class="nombre-vigente-desde">
                                Vigente desde el <?= formatearFecha($nombre_vigente['fecha_inicio']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="section-block">
                    <h3 class="section-block-title">
                        Nombres anteriores
                        <?php if (count($nombres_anteriores) > 0): ?>
                            <span class="count-tag"><?= count($nombres_anteriores) ?></span>
                        <?php endif; ?>
                    </h3>

                    <?php if (count($nombres_anteriores) > 0): ?>
                        <ol class="timeline">
                            <?php foreach ($nombres_anteriores as $h): ?>
                                <li class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-body">
                                            <div class="timeline-nombre"><?= htmlspecialchars($h['nombre']) ?></div>
                                            <div class="timeline-fechas">
                                                <?= formatearFecha($h['fecha_inicio']) ?>
                                                <?php if ($h['fecha_fin']): ?>
                                                    &ndash; <?= formatearFecha($h['fecha_fin']) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php else: ?>
                        <p class="info-muted-text">Esta institución nunca ha cambiado de razón social.</p>
                    <?php endif; ?>
                </div>

            </div>

            <!-- ============================================================ -->
            <!-- TAB: PERSONAS -->
            <!-- ============================================================ -->
            <div class="tab-panel" id="tab-personas" role="tabpanel">

                <?php if ($total_personas === 0): ?>
                    <div class="empty-tab">
                        <h3>Sin personas asociadas</h3>
                        <p>
                            No hay personas registradas en esta institución. Las personas se asocian al registrar
                            representantes, titulares o coordinadores vinculados a la institución.
                        </p>
                    </div>
                <?php else: ?>

                    <?php if ($total_activas > 0): ?>
                    <div class="section-block">
                        <h3 class="section-block-title">
                            Personas activas
                            <span class="count-tag"><?= $total_activas ?></span>
                        </h3>
                        <div class="personas-list">
                            <?php foreach ($personas_activas as $p): ?>
                                <div class="persona-card">
                                    <div class="persona-head">
                                        <div class="persona-avatar">
                                            <?= htmlspecialchars(mb_substr($p['nombre'], 0, 1)) ?>
                                        </div>
                                        <div class="persona-identidad">
                                            <div class="persona-nombre"><?= htmlspecialchars($p['nombre']) ?></div>
                                            <div class="persona-cargo"><?= htmlspecialchars($p['cargo']) ?></div>
                                        </div>
                                        <?php if (!empty($p['titular'])): ?>
                                            <span class="persona-tag">Titular</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="persona-foot">
                                        Desde <?= formatearFecha($p['fecha_inicio']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($total_inactivas > 0): ?>
                    <div class="section-block">
                        <h3 class="section-block-title">
                            Personas con períodos finalizados
                            <span class="count-tag count-tag-neutral"><?= $total_inactivas ?></span>
                        </h3>
                        <div class="personas-list">
                            <?php foreach ($personas_inactivas as $p): ?>
                                <div class="persona-card persona-card-inactiva">
                                    <div class="persona-head">
                                        <div class="persona-avatar persona-avatar-inactiva">
                                            <?= htmlspecialchars(mb_substr($p['nombre'], 0, 1)) ?>
                                        </div>
                                        <div class="persona-identidad">
                                            <div class="persona-nombre"><?= htmlspecialchars($p['nombre']) ?></div>
                                            <div class="persona-cargo"><?= htmlspecialchars($p['cargo']) ?></div>
                                        </div>
                                        <?php if (!empty($p['titular'])): ?>
                                            <span class="persona-tag persona-tag-neutral">Titular</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="persona-foot">
                                        <?= formatearFecha($p['fecha_inicio']) ?> &ndash; <?= formatearFecha($p['fecha_fin']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                <?php endif; ?>

            </div>

            <!-- ============================================================ -->
            <!-- TAB: SEDES -->
            <!-- ============================================================ -->
            <?php if ($es_matriz && $tiene_sedes): ?>
            <div class="tab-panel" id="tab-sedes" role="tabpanel">

                <div class="section-block">
                    <h3 class="section-block-title">
                        Sedes registradas
                        <span class="count-tag"><?= count($sedes) ?></span>
                    </h3>
                    <p class="section-block-desc">
                        Estas instituciones dependen de esta matriz y participan directamente en ANFECA.
                    </p>

                    <div class="sedes-list">
                        <?php foreach ($sedes as $sede): 
                            $sede_estado = getEstadoInstitucion($sede);
                            $sede_esta_activa = ($sede_estado === 'activa');
                            $sede_participaciones = getParticipacionesDe($sede);
                            $sede_vigente = $sede_participaciones['vigente'];
                            
                            // Dirección corta de la sede
                            $sede_dir = $sede['direccion'] ?? null;
                            $sede_ubicacion = '';
                            if ($sede_dir) {
                                $sede_ubicacion = $sede_dir['municipio'] . ', ' . getEntidadNombre($sede['id_entidad']);
                            }
                        ?>
                            <div class="sede-card">
                                <div class="sede-card-head">
                                    <a href="institucion_consulta.php?id=<?= $sede['id'] ?>" class="sede-card-nombre">
                                        <?= htmlspecialchars($sede['nombre']) ?>
                                    </a>
                                    <span class="status-badge <?= $sede_esta_activa ? 'status-active' : 'status-inactive' ?>">
                                        <span class="status-dot"></span>
                                        <?= $sede_esta_activa ? 'Activa' : 'Inactiva' ?>
                                    </span>
                                </div>
                                <div class="sede-card-meta">
                                    <span class="meta-item"><?= getTipoNombre($sede['tipo']) ?></span>
                                    <?php if ($sede_ubicacion): ?>
                                        <span class="meta-sep"></span>
                                        <span class="meta-item"><?= htmlspecialchars($sede_ubicacion) ?></span>
                                    <?php endif; ?>
                                    <?php if ($sede_vigente): ?>
                                        <span class="meta-sep"></span>
                                        <span class="badge-participacion badge-<?= strtolower($sede_vigente['tipo']) ?>">
                                            <?= htmlspecialchars($sede_vigente['tipo']) ?>
                                        </span>
                                        <?php if ($sede_vigente['num_afiliacion']): ?>
                                            <span class="meta-num">Núm. <?= htmlspecialchars($sede_vigente['num_afiliacion']) ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
            <?php endif; ?>

        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - CONSULTA INSTITUCIÓN
   ============================================================ */

/* ---------- Page Header ---------- */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.75rem;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.page-header-content {
    display: flex;
    align-items: stretch;
    gap: 1rem;
    min-width: 0;
    flex: 1;
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
    min-width: 0;
}

.page-eyebrow {
    font-size: 0.72rem;
    font-weight: 700;
    color: #8B0000;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 0.3rem;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    letter-spacing: -0.01em;
    line-height: 1.2;
    word-break: break-word;
}

.page-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.5rem;
    flex-wrap: wrap;
}

.page-header-right {
    display: flex;
    gap: 0.6rem;
    align-items: center;
    padding-top: 0.35rem;
    flex-wrap: wrap;
}

/* ---------- Botones ---------- */

.btn-primary-modern {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
}

.btn-primary-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(139, 0, 0, 0.3);
    color: white;
}

.btn-outline-modern {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.7rem 1.4rem;
    background: white;
    color: #4a4a4a;
    border: 1.5px solid #e0e0e0;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
}

.btn-outline-modern:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.btn-text {
    background: none;
    border: none;
    color: #8B0000;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s ease;
}

.btn-text:hover {
    color: #5C0000;
}

/* ---------- Status badges ---------- */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    white-space: nowrap;
}

.status-dot {
    display: inline-block;
    width: 7px;
    height: 7px;
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
    background: #f5f5f5;
    color: #888;
}

.status-badge.status-inactive .status-dot {
    background: #999;
}

.meta-num {
    font-family: monospace;
    font-size: 0.82rem;
    color: #6b6b6b;
    background: #f5f0f0;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    font-weight: 600;
}

/* ---------- Tabs ---------- */

.tabs-container {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.tabs-nav {
    display: flex;
    gap: 0;
    border-bottom: 1.5px solid #f0f0f0;
    background: #fafafa;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.tabs-nav::-webkit-scrollbar {
    display: none;
}

.tab-btn {
    position: relative;
    padding: 1rem 1.5rem;
    background: none;
    border: none;
    font-size: 0.88rem;
    font-weight: 600;
    color: #888;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1.5px;
}

.tab-btn:hover {
    color: #4a4a4a;
}

.tab-btn.active {
    color: #8B0000;
    border-bottom-color: #8B0000;
    background: white;
}

.tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 0.4rem;
    background: #8B0000;
    color: white;
    border-radius: 10px;
    font-size: 0.68rem;
    font-weight: 700;
    line-height: 1;
}

.tab-badge-neutral {
    background: #c4c4c4;
}

.tab-panel {
    display: none;
    padding: 2rem;
    animation: fadeInPanel 0.25s ease;
}

.tab-panel.active {
    display: block;
}

@keyframes fadeInPanel {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ---------- Info Cards ---------- */

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}

.info-card {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 1.5rem;
}

.info-card-muted {
    background: #faf8f8;
    border-style: dashed;
    border-color: #e8e0e0;
}

.info-card-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin: 0 0 1rem 0;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #ececec;
}

.info-list {
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}

.info-list-horizontal {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1.25rem;
}

.info-row {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.info-row dt {
    font-size: 0.72rem;
    font-weight: 600;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.info-row dd {
    font-size: 0.92rem;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.4;
    word-break: break-word;
}

.info-muted-text {
    color: #999;
    font-size: 0.88rem;
    line-height: 1.55;
    margin: 0;
}

.num-destacado {
    font-family: monospace;
    font-weight: 700;
    font-size: 0.95rem;
    color: #8B0000;
    background: #f5edec;
    padding: 0.2rem 0.65rem;
    border-radius: 6px;
    display: inline-block;
}

.link-institucion {
    color: #8B0000;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.link-institucion:hover {
    color: #5C0000;
    text-decoration: underline;
}

.link-externo {
    color: #0d6efd;
    text-decoration: none;
    font-size: 0.88rem;
    transition: color 0.2s ease;
    word-break: break-all;
}

.link-externo:hover {
    color: #0a58ca;
    text-decoration: underline;
}

.sitios-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

/* ---------- Section blocks ---------- */

.section-block {
    margin-bottom: 2rem;
}

.section-block:last-child {
    margin-bottom: 0;
}

.section-block-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.35rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.section-block-desc {
    font-size: 0.85rem;
    color: #888;
    margin: 0 0 1.25rem 0;
    line-height: 1.5;
}

.count-tag {
    font-size: 0.72rem;
    font-weight: 700;
    color: #8B0000;
    background: #f5edec;
    padding: 0.15rem 0.55rem;
    border-radius: 10px;
}

.count-tag-neutral {
    color: #888;
    background: #f0f0f0;
}

/* ---------- Participación actual ---------- */

.participacion-actual {
    background: linear-gradient(135deg, #f7fbf7, #eef7ee);
    border: 1.5px solid #c8e6c9;
    border-radius: 12px;
    padding: 1.5rem;
}

.participacion-actual-head {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}

.participacion-inactiva-box {
    background: #fafafa;
    border: 1.5px dashed #e0e0e0;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
}

.inactiva-nota {
    color: #6b6b6b;
    font-size: 0.88rem;
    line-height: 1.55;
    margin: 1rem 0 0 0;
    max-width: 520px;
    margin-left: auto;
    margin-right: auto;
}

/* ---------- Badges de participación ---------- */

.badge-participacion {
    display: inline-block;
    padding: 0.3rem 0.85rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-participacion.badge-afiliada {
    background: #d4edda;
    color: #1b5e20;
}

.badge-participacion.badge-observadora {
    background: #fff3e0;
    color: #b25000;
}

.badge-participacion.badge-matriz {
    background: #e3f2fd;
    color: #0d47a1;
}

/* ---------- Timeline ---------- */

.timeline {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 6px;
    bottom: 6px;
    width: 2px;
    background: #ececec;
}

.timeline-item {
    position: relative;
    padding-left: 2rem;
    padding-bottom: 1.5rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: white;
    border: 2px solid #d0d0d0;
    z-index: 1;
}

.timeline-item-active .timeline-marker {
    border-color: #2e7d32;
    background: #2e7d32;
    box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
}

.timeline-content {
    padding: 0.15rem 0;
}

.timeline-head {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
}

.timeline-tag {
    font-size: 0.68rem;
    font-weight: 700;
    color: #2e7d32;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timeline-body {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.timeline-nombre {
    font-size: 0.98rem;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.35;
}

.timeline-fechas {
    font-size: 0.85rem;
    color: #6b6b6b;
}

.timeline-num {
    font-family: monospace;
    font-size: 0.8rem;
    color: #8B0000;
    background: #f5edec;
    padding: 0.15rem 0.55rem;
    border-radius: 4px;
    align-self: flex-start;
    font-weight: 600;
}

/* ---------- Nombre vigente ---------- */

.nombre-vigente-box {
    background: linear-gradient(135deg, #fdf5f5, #faf0ef);
    border: 1.5px solid #e8d0ce;
    border-radius: 12px;
    padding: 1.5rem;
}

.nombre-vigente-texto {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1.35;
    margin-bottom: 0.4rem;
    word-break: break-word;
}

.nombre-vigente-desde {
    font-size: 0.82rem;
    color: #8B0000;
    font-weight: 500;
}

/* ---------- Personas ---------- */

.personas-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 0.85rem;
}

.persona-card {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    transition: all 0.2s ease;
}

.persona-card:hover {
    background: #f5f0f0;
    border-color: #e8d8d6;
}

.persona-card-inactiva {
    opacity: 0.75;
}

.persona-head {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 0.75rem;
}

.persona-avatar {
    width: 40px;
    height: 40px;
    min-width: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
}

.persona-avatar-inactiva {
    background: #c4c4c4;
}

.persona-identidad {
    flex: 1;
    min-width: 0;
}

.persona-nombre {
    font-size: 0.92rem;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.3;
    word-break: break-word;
}

.persona-cargo {
    font-size: 0.78rem;
    color: #888;
    margin-top: 0.15rem;
}

.persona-tag {
    display: inline-block;
    padding: 0.15rem 0.55rem;
    background: #8B0000;
    color: white;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
}

.persona-tag-neutral {
    background: #d0d0d0;
    color: #4a4a4a;
}

.persona-foot {
    font-size: 0.78rem;
    color: #999;
    padding-top: 0.75rem;
    border-top: 1px solid #ececec;
}

/* ---------- Sedes ---------- */

.sedes-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.sede-card {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 1.15rem 1.35rem;
    transition: all 0.2s ease;
}

.sede-card:hover {
    background: #f5f0f0;
    border-color: #e8d8d6;
}

.sede-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 0.6rem;
    flex-wrap: wrap;
}

.sede-card-nombre {
    font-size: 0.98rem;
    font-weight: 600;
    color: #8B0000;
    text-decoration: none;
    transition: color 0.2s ease;
    line-height: 1.35;
}

.sede-card-nombre:hover {
    color: #5C0000;
    text-decoration: underline;
}

.sede-card-meta {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
    font-size: 0.82rem;
    color: #888;
}

.meta-item {
    font-size: 0.82rem;
    color: #6b6b6b;
}

.meta-sep {
    display: inline-block;
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: #d0d0d0;
}

/* ---------- Empty tab ---------- */

.empty-tab {
    text-align: center;
    padding: 3rem 1.5rem;
    max-width: 520px;
    margin: 0 auto;
}

.empty-tab h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #4a4a4a;
    margin: 0 0 0.75rem 0;
}

.empty-tab p {
    color: #888;
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0 0 1.25rem 0;
}

/* ---------- Alerta error ---------- */

.alert-modern {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.alert-error {
    background: #fdf0f0;
    color: #7a1a1a;
    border-left: 4px solid #c62828;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: stretch;
    }

    .page-header-right {
        flex-direction: column;
        align-items: stretch;
    }

    .page-header-right .btn-primary-modern,
    .page-header-right .btn-outline-modern {
        width: 100%;
    }

    .page-title {
        font-size: 1.25rem;
    }

    .tab-panel {
        padding: 1.25rem;
    }

    .tab-btn {
        padding: 0.85rem 1rem;
        font-size: 0.82rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .info-card {
        padding: 1.25rem;
    }

    .personas-list {
        grid-template-columns: 1fr;
    }

    .section-block-title {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.1rem;
    }

    .tab-panel {
        padding: 1rem;
    }

    .tab-btn {
        padding: 0.75rem 0.85rem;
        font-size: 0.78rem;
    }

    .info-card,
    .participacion-actual,
    .participacion-inactiva-box,
    .nombre-vigente-box {
        padding: 1rem;
    }

    .info-row dt {
        font-size: 0.68rem;
    }

    .info-row dd {
        font-size: 0.88rem;
    }

    .nombre-vigente-texto {
        font-size: 1rem;
    }
}
</style>

<script>
// ============================================================
// NAVEGACIÓN POR PESTAÑAS
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');
    
    function activarTab(tabId) {
        tabButtons.forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.tab === tabId);
        });
        tabPanels.forEach(function(panel) {
            panel.classList.toggle('active', panel.id === tabId);
        });
        
        // Actualizar hash sin scroll
        if (history.replaceState) {
            history.replaceState(null, '', '#' + tabId);
        }
    }
    
    tabButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            activarTab(this.dataset.tab);
        });
    });
    
    // Botones internos que llevan a otra pestaña
    document.querySelectorAll('[data-goto-tab]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            activarTab(this.dataset.gotoTab);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
    
    // Si hay hash en la URL, activar la pestaña correspondiente
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        const targetBtn = document.querySelector('.tab-btn[data-tab="' + hash + '"]');
        if (targetBtn) {
            activarTab(hash);
        }
    }
});
</script>

<?php include 'template/footer.php'; ?>