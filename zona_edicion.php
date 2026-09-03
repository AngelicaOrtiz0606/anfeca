<?php
// ============================================================
// SIDEANFECA - Catálogo de Zonas Regionales
// Editar zona regional existente
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DE LA ZONA
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: zonas_regionales.php');
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

// Mapeo inverso: entidad -> zona (para saber dónde está actualmente)
$zona_por_entidad = [];
foreach ($entidades_por_zona as $zona_num => $entidades) {
    foreach ($entidades as $entidad) {
        $zona_por_entidad[$entidad] = $zona_num;
    }
}

// Nombres de zonas para mostrar
$nombres_zonas = [
    1 => 'Noroeste',
    2 => 'Norte',
    3 => 'Centro',
    4 => 'Centro Occidente',
    5 => 'Centro Sur',
    6 => 'Sur',
    7 => 'Ciudad de México'
];

// Todas las entidades disponibles (ordenadas alfabéticamente)
$todas_entidades = [
    'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas', 
    'Chihuahua', 'Ciudad de México', 'Coahuila', 'Colima', 'Durango', 'Estado de México', 
    'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Michoacán', 'Morelos', 'Nayarit', 
    'Nuevo León', 'Oaxaca', 'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 
    'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 'Yucatán', 'Zacatecas'
];

// Zonas existentes
$zonas_existentes = [
    ['id' => 1, 'numero' => 1, 'nombre' => 'Noroeste', 'activo' => true],
    ['id' => 2, 'numero' => 2, 'nombre' => 'Norte', 'activo' => true],
    ['id' => 3, 'numero' => 3, 'nombre' => 'Centro', 'activo' => true],
    ['id' => 4, 'numero' => 4, 'nombre' => 'Centro Occidente', 'activo' => true],
    ['id' => 5, 'numero' => 5, 'nombre' => 'Centro Sur', 'activo' => true],
    ['id' => 6, 'numero' => 6, 'nombre' => 'Sur', 'activo' => true],
    ['id' => 7, 'numero' => 7, 'nombre' => 'Ciudad de México', 'activo' => true]
];

// Buscar la zona
$zona = null;
foreach ($zonas_existentes as $z) {
    if ($z['id'] == $id) {
        $zona = $z;
        break;
    }
}

if (!$zona) {
    header('Location: zonas_regionales.php?error=' . urlencode('Zona no encontrada'));
    exit;
}

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $numero = (int)($_POST['numero'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $activo = isset($_POST['activo']) ? true : false;
    
    // Obtener entidades seleccionadas
    $entidades_seleccionadas = isset($_POST['entidades']) ? $_POST['entidades'] : [];
    
    if ($numero <= 0) $errores[] = 'Número de zona';
    if (empty($nombre)) $errores[] = 'Nombre de la zona';
    
    // Validar duplicados (excepto la misma zona)
    foreach ($zonas_existentes as $z) {
        if ($z['id'] == $id) continue;
        if ($z['numero'] == $numero) {
            $errores[] = 'El número ' . $numero . ' ya está asignado a otra zona';
            break;
        }
        if (strtolower($z['nombre']) == strtolower($nombre)) {
            $errores[] = 'El nombre "' . $nombre . '" ya está registrado';
            break;
        }
    }
    
    // Verificar entidades seleccionadas vs entidades actuales de la zona
    $entidades_actuales = isset($entidades_por_zona[$zona['numero']]) ? $entidades_por_zona[$zona['numero']] : [];
    $entidades_agregadas = array_diff($entidades_seleccionadas, $entidades_actuales);
    $entidades_eliminadas = array_diff($entidades_actuales, $entidades_seleccionadas);
    
    $tiene_cambios_entidades = !empty($entidades_agregadas) || !empty($entidades_eliminadas);
    
    if (empty($errores)) {
        if ($tiene_cambios_entidades && !isset($_POST['confirmar_entidades'])) {
            $error = 'cambios_entidades';
            // Guardar datos para mostrar en la alerta
            $entidades_agregadas_data = $entidades_agregadas;
            $entidades_eliminadas_data = $entidades_eliminadas;
        } else {
            $mensaje = 'Zona regional actualizada exitosamente';
            // Actualizar datos de la zona
            $zona['numero'] = $numero;
            $zona['nombre'] = $nombre;
            $zona['activo'] = $activo;
        }
    } else {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    }
}

// Obtener entidades actuales de la zona
$entidades_actuales = isset($entidades_por_zona[$zona['numero']]) ? $entidades_por_zona[$zona['numero']] : [];

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="page-title">Editar Zona Regional</h1>
                    <p class="page-subtitle">Modifique los datos de la zona regional registrada en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="zonas_regionales.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>¡Excelente!</strong> <?= $mensaje ?>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($error === 'cambios_entidades'): ?>
            <!-- Mensaje de advertencia por cambios en entidades -->
            <div class="alert-modern alert-warning" id="alertaEntidades">
                <i class="fas fa-exclamation-triangle"></i>
                <div style="flex:1;">
                    <strong>¡Atención! Ha realizado cambios en las entidades federativas de esta zona.</strong>
                    
                    <?php if (!empty($entidades_agregadas_data)): ?>
                        <div style="margin:0.75rem 0 0 0; padding:0.5rem 0.75rem; background:#e8f5e9; border-radius:6px; border-left:3px solid #2e7d32;">
                            <div style="font-weight:600; color:#2e7d32; margin-bottom:0.25rem;">
                                <i class="fas fa-plus-circle"></i> Nuevas entidades que se agregarán a <strong>Zona <?= $zona['numero'] ?> - <?= htmlspecialchars($zona['nombre']) ?></strong>:
                            </div>
                            <?php foreach ($entidades_agregadas_data as $entidad): 
                                $zona_origen = isset($zona_por_entidad[$entidad]) ? $zona_por_entidad[$entidad] : null;
                                $nombre_zona_origen = $zona_origen ? $nombres_zonas[$zona_origen] : 'Sin zona';
                            ?>
                                <div style="display:flex; justify-content:space-between; padding:0.15rem 0; font-size:0.9rem; border-bottom:1px solid rgba(0,0,0,0.05);">
                                    <span><?= htmlspecialchars($entidad) ?></span>
                                    <span style="color:#666; font-size:0.8rem;">
                                        Actualmente en <strong>Zona <?= $zona_origen ?> - <?= htmlspecialchars($nombre_zona_origen) ?></strong>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($entidades_eliminadas_data)): ?>
                        <div style="margin:0.5rem 0 0 0; padding:0.5rem 0.75rem; background:#fce4ec; border-radius:6px; border-left:3px solid #c62828;">
                            <div style="font-weight:600; color:#c62828; margin-bottom:0.25rem;">
                                <i class="fas fa-minus-circle"></i> Entidades que se eliminarán de <strong>Zona <?= $zona['numero'] ?> - <?= htmlspecialchars($zona['nombre']) ?></strong>:
                            </div>
                            <?php foreach ($entidades_eliminadas_data as $entidad): ?>
                                <div style="display:flex; justify-content:space-between; padding:0.15rem 0; font-size:0.9rem; border-bottom:1px solid rgba(0,0,0,0.05);">
                                    <span><?= htmlspecialchars($entidad) ?></span>
                                    <span style="color:#666; font-size:0.8rem;">
                                        <i class="fas fa-arrow-right"></i> 
                                        Pasará a <strong>Sin zona asignada</strong>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div style="margin-top:0.75rem; padding:0.5rem 0.75rem; background:#fff3e0; border-radius:6px; border-left:3px solid #e65100;">
                        <span style="color:#e65100; font-weight:500;">
                            <i class="fas fa-info-circle"></i> 
                            ¿Desea confirmar estos cambios?
                        </span>
                    </div>
                </div>
                <div style="display:flex; gap:0.75rem; align-items:center; margin-left:auto; flex-shrink:0;">
                    <button onclick="confirmarCambiosEntidades()" class="btn-primary-modern" style="padding:0.4rem 1.2rem; font-size:0.8rem;">
                        <i class="fas fa-check"></i> Sí, confirmar
                    </button>
                    <button onclick="cancelarCambiosEntidades()" class="btn-outline-modern" style="padding:0.4rem 1.2rem; font-size:0.8rem;">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error && $error !== 'cambios_entidades'): ?>
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor revise</strong> <?= $error ?>
                </div>
                <button class="alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="form-container">
            <div class="form-legend">
                <span class="legend-asterisk">*</span>
                <span>Campos obligatorios</span>
            </div>
            
            <form method="POST" id="formEdicion">
                <input type="hidden" name="confirmar_entidades" id="confirmarEntidades" value="">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Número de Zona</label>
                        <input type="number" name="numero" class="form-control" placeholder="Ej. 1" 
                               value="<?= $zona['numero'] ?>" min="1" max="99" required>
                        <small class="form-hint">Número único que identifica la zona (1-99)</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Nombre de la Zona</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Noroeste" 
                               value="<?= htmlspecialchars($zona['nombre']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo" value="1" 
                                       <?= $zona['activo'] ? 'checked' : '' ?>>
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar la zona en los listados</small>
                    </div>
                    
                    <div class="form-group form-group-full">
                        <label class="form-label">Entidades Federativas</label>
                        <div class="entidades-select-container">
                            <?php 
                            // Ordenar entidades alfabéticamente
                            sort($todas_entidades);
                            foreach ($todas_entidades as $entidad): 
                                $seleccionada = in_array($entidad, $entidades_actuales);
                                $zona_actual = isset($zona_por_entidad[$entidad]) ? $zona_por_entidad[$entidad] : null;
                                $nombre_zona_actual = $zona_actual ? $nombres_zonas[$zona_actual] : 'Sin zona';
                            ?>
                                <label class="entidad-checkbox <?= $seleccionada ? 'selected' : '' ?>" 
                                       title="Zona actual: <?= $nombre_zona_actual ?>">
                                    <input type="checkbox" name="entidades[]" value="<?= htmlspecialchars($entidad) ?>" 
                                           <?= $seleccionada ? 'checked' : '' ?>
                                           data-zona-actual="<?= $zona_actual ?>"
                                           data-nombre-zona-actual="<?= htmlspecialchars($nombre_zona_actual) ?>"
                                           onchange="marcarCambioEntidad(this)">
                                    <span><?= htmlspecialchars($entidad) ?></span>
                                    <?php if ($zona_actual && $zona_actual != $zona['numero']): ?>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <small class="form-hint">Seleccione las entidades que pertenecen a esta zona</small>
                        <div id="mensajeCambios" style="display:none; margin-top:0.5rem; padding:0.5rem 1rem; background:#fff3e0; border-radius:8px; border-left:4px solid #e65100; font-size:0.85rem; color:#e65100;">
                            <i class="fas fa-info-circle"></i> Ha realizado cambios en las entidades. Guarde los cambios para aplicar.
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern" id="btnActualizar">
                        <i class="fas fa-save"></i> Actualizar Zona
                    </button>
                    <button type="reset" class="btn-outline-modern">
                        <i class="fas fa-undo"></i> Restablecer
                    </button>
                    <a href="zonas_regionales.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<!-- Modal de confirmación de cambios en entidades -->
<div class="modal-overlay" id="modalConfirmarEntidades" style="display:none;">
    <div class="modal-card" style="max-width:550px;">
        <div class="modal-header">
            <i class="fas fa-exclamation-triangle" style="color:#e65100;"></i>
            <h3 style="color:#e65100;">Confirmar cambios en entidades</h3>
            <button class="modal-close" onclick="cerrarModalConfirmar()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p style="font-weight:500; color:#1a1a1a;">
                Está a punto de modificar las entidades de la <strong>Zona <?= $zona['numero'] ?> - <?= htmlspecialchars($zona['nombre']) ?></strong>
            </p>
            <div id="resumenCambios" style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <!-- Se llena con JavaScript -->
            </div>
            <p style="color:#e65100;font-weight:600;font-size:0.9rem;">
                <i class="fas fa-info-circle"></i> Esta acción afectará la asignación de entidades a esta zona.
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-cancel" onclick="cerrarModalConfirmar()">Cancelar</button>
            <button class="btn-modal-primary" style="background:#e65100;" onclick="confirmarCambios()">
                <i class="fas fa-check"></i> Sí, realizar cambios
            </button>
        </div>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - EDICIÓN ZONA
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
    flex-wrap: wrap;
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

.alert-warning {
    background: #fff8e1;
    color: #5d4e37;
    border-left: 4px solid #e65100;
}

.alert-warning i {
    color: #e65100;
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
    padding: 0.5rem 1rem;
    background: #faf8f8;
    border-radius: 8px;
    margin-bottom: 2rem;
    font-size: 0.85rem;
    color: #6b6b6b;
}

.legend-asterisk {
    color: #c62828;
    font-weight: 700;
    font-size: 1rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.form-group-full {
    grid-column: 1 / -1;
}

.form-group {
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

.form-control[type="number"] {
    -moz-appearance: textfield;
}

.form-control[type="number"]::-webkit-outer-spin-button,
.form-control[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
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

/* Entidades Selector - SIN BANDERAS */
.entidades-select-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 0.5rem;
    padding: 0.75rem;
    background: #faf8f8;
    border-radius: 10px;
    border: 2px solid #e8e8e8;
    max-height: 260px;
    overflow-y: auto;
}

.entidad-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.6rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid transparent;
    background: white;
}

.entidad-checkbox:hover {
    background: #f0ecec;
}

.entidad-checkbox.selected {
    background: #e8f5e9;
    border-color: #2e7d32;
}

.entidad-checkbox input[type="checkbox"] {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #8B0000;
    flex-shrink: 0;
}

.entidad-checkbox span {
    font-size: 0.85rem;
    color: #1a1a1a;
}

.entidad-checkbox small {
    font-size: 0.6rem;
    color: #999;
    margin-left: auto;
    white-space: nowrap;
}

/* Botón principal */
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

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

/* Modal */
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
    max-width: 550px;
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

.modal-body .cambio-item {
    display: flex;
    justify-content: space-between;
    padding: 0.3rem 0;
    border-bottom: 1px solid #f0ecec;
    font-size: 0.9rem;
}

.modal-body .cambio-item:last-child {
    border-bottom: none;
}

.modal-body .cambio-item .entidad-nombre {
    font-weight: 500;
}

.modal-body .cambio-item .entidad-origen {
    color: #666;
    font-size: 0.8rem;
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

.btn-modal-primary {
    padding: 0.6rem 1.5rem;
    background: #8B0000;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-primary:hover {
    background: #5C0000;
}

.btn-modal-primary:disabled {
    background: #cccccc;
    color: #666666;
    cursor: not-allowed;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
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

    .entidades-select-container {
        grid-template-columns: 1fr 1fr;
        max-height: 200px;
    }

    .alert-warning {
        flex-direction: column;
        align-items: stretch;
    }

    .alert-warning > div:last-child {
        margin-left: 0 !important;
        margin-top: 0.75rem;
        flex-direction: column;
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

    .entidades-select-container {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// ============================================================
// DATOS DE ZONAS Y ENTIDADES
// ============================================================

const zonaActual = <?= $zona['numero'] ?>;
const zonaNombreActual = <?= json_encode($zona['nombre']) ?>;
const entidadesPorZona = <?= json_encode($entidades_por_zona) ?>;
const zonaPorEntidad = <?= json_encode($zona_por_entidad) ?>;
const nombresZonas = <?= json_encode($nombres_zonas) ?>;

let entidadesModificadas = false;
let cambiosDetectados = [];

// ============================================================
// DETECTAR CAMBIOS EN ENTIDADES
// ============================================================

function marcarCambioEntidad(checkbox) {
    const label = checkbox.closest('.entidad-checkbox');
    if (checkbox.checked) {
        label.classList.add('selected');
    } else {
        label.classList.remove('selected');
    }
    
    entidadesModificadas = true;
    document.getElementById('mensajeCambios').style.display = 'block';
    
    // Guardar cambios para el modal
    detectarCambios();
}

function detectarCambios() {
    const checkboxes = document.querySelectorAll('input[name="entidades[]"]');
    const entidadesActuales = entidadesPorZona[zonaActual] || [];
    const seleccionadas = [];
    
    checkboxes.forEach(cb => {
        if (cb.checked) {
            seleccionadas.push(cb.value);
        }
    });
    
    const agregadas = seleccionadas.filter(e => !entidadesActuales.includes(e));
    const eliminadas = entidadesActuales.filter(e => !seleccionadas.includes(e));
    
    cambiosDetectados = {
        agregadas: agregadas,
        eliminadas: eliminadas,
        tieneCambios: agregadas.length > 0 || eliminadas.length > 0
    };
}

// ============================================================
// CONFIRMAR CAMBIOS DE ENTIDADES - MODAL
// ============================================================

function mostrarModalConfirmacion() {
    const checkboxes = document.querySelectorAll('input[name="entidades[]"]');
    const entidadesActuales = entidadesPorZona[zonaActual] || [];
    const seleccionadas = [];
    
    checkboxes.forEach(cb => {
        if (cb.checked) {
            seleccionadas.push(cb.value);
        }
    });
    
    const agregadas = seleccionadas.filter(e => !entidadesActuales.includes(e));
    const eliminadas = entidadesActuales.filter(e => !seleccionadas.includes(e));
    
    let resumenHtml = '';
    let tieneCambios = false;
    
    if (agregadas.length > 0) {
        tieneCambios = true;
        resumenHtml += `<div style="color:#2e7d32; font-weight:600; margin-bottom:0.5rem;">
            <i class="fas fa-plus-circle"></i> Entidades que se agregarán a <strong>Zona ${zonaActual} - ${zonaNombreActual}</strong>:
        </div>`;
        resumenHtml += `<div style="margin-left:0.5rem;">`;
        agregadas.forEach(entidad => {
            const zonaOrigen = zonaPorEntidad[entidad] || null;
            const nombreZonaOrigen = zonaOrigen ? nombresZonas[zonaOrigen] : 'Sin zona';
            resumenHtml += `
                <div class="cambio-item" style="display:flex; justify-content:space-between; padding:0.25rem 0; border-bottom:1px solid #f0ecec;">
                    <span class="entidad-nombre">${entidad}</span>
                    <span class="entidad-origen" style="color:#666; font-size:0.8rem;">
                        <i class="fas fa-arrow-right"></i> 
                        Actualmente en <strong>Zona ${zonaOrigen || '?'} - ${nombreZonaOrigen}</strong>
                    </span>
                </div>
            `;
        });
        resumenHtml += `</div>`;
    }
    
    if (eliminadas.length > 0) {
        tieneCambios = true;
        if (agregadas.length > 0) resumenHtml += `<div style="margin-top:0.75rem;"></div>`;
        resumenHtml += `<div style="color:#c62828; font-weight:600; margin-bottom:0.5rem;">
            <i class="fas fa-minus-circle"></i> Entidades que se eliminarán de <strong>Zona ${zonaActual} - ${zonaNombreActual}</strong>:
        </div>`;
        resumenHtml += `<div style="margin-left:0.5rem;">`;
        eliminadas.forEach(entidad => {
            resumenHtml += `
                <div class="cambio-item" style="display:flex; justify-content:space-between; padding:0.25rem 0; border-bottom:1px solid #f0ecec;">
                    <span class="entidad-nombre">${entidad}</span>
                    <span class="entidad-origen" style="color:#666; font-size:0.8rem;">
                        <i class="fas fa-arrow-right"></i> 
                        Pasará a <strong>Sin zona asignada</strong>
                    </span>
                </div>
            `;
        });
        resumenHtml += `</div>`;
    }
    
    if (!tieneCambios) {
        resumenHtml = '<div style="color:#666; padding:0.5rem 0;">No se detectaron cambios en las entidades.</div>';
        document.querySelector('#modalConfirmarEntidades .btn-modal-primary').disabled = true;
    } else {
        document.querySelector('#modalConfirmarEntidades .btn-modal-primary').disabled = false;
        resumenHtml = `<div style="margin-bottom:0.5rem; font-weight:500; color:#1a1a1a;">
            Resumen de cambios para <strong>Zona ${zonaActual} - ${zonaNombreActual}</strong>:
        </div>` + resumenHtml;
    }
    
    document.getElementById('resumenCambios').innerHTML = resumenHtml;
    document.getElementById('modalConfirmarEntidades').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalConfirmar() {
    document.getElementById('modalConfirmarEntidades').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function confirmarCambios() {
    document.getElementById('confirmarEntidades').value = '1';
    document.getElementById('formEdicion').submit();
}

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
// INTERCEPTAR ENVÍO DEL FORMULARIO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEdicion');
    
    form.addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('input[name="entidades[]"]');
        const entidadesActuales = entidadesPorZona[zonaActual] || [];
        const seleccionadas = [];
        
        checkboxes.forEach(cb => {
            if (cb.checked) {
                seleccionadas.push(cb.value);
            }
        });
        
        const agregadas = seleccionadas.filter(e => !entidadesActuales.includes(e));
        const eliminadas = entidadesActuales.filter(e => !seleccionadas.includes(e));
        
        const hayCambios = agregadas.length > 0 || eliminadas.length > 0;
        const confirmado = document.getElementById('confirmarEntidades').value === '1';
        
        if (hayCambios && !confirmado) {
            e.preventDefault();
            mostrarModalConfirmacion();
            return false;
        }
        
        return true;
    });
});

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalConfirmarEntidades');
    if (modal && e.target === modal) {
        cerrarModalConfirmar();
    }
});

// Funciones para los botones de la alerta de cambios en entidades
function confirmarCambiosEntidades() {
    document.getElementById('confirmarEntidades').value = '1';
    document.getElementById('formEdicion').submit();
}

function cancelarCambiosEntidades() {
    window.location.reload();
}
</script>

<?php include 'template/footer.php'; ?>