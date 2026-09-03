<?php
// ============================================================
// SIDEANFECA - Catálogo de Zonas Regionales
// Registrar nueva zona regional
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

// Entidades federativas disponibles (todas)
$todas_entidades = [
    'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche', 'Chiapas', 
    'Chihuahua', 'Ciudad de México', 'Coahuila', 'Colima', 'Durango', 'Estado de México', 
    'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco', 'Michoacán', 'Morelos', 'Nayarit', 
    'Nuevo León', 'Oaxaca', 'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 
    'Sinaloa', 'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz', 'Yucatán', 'Zacatecas'
];

// Entidades por zona (para saber dónde están actualmente)
$entidades_por_zona = [
    1 => ['Baja California', 'Baja California Sur', 'Chihuahua', 'Sinaloa', 'Sonora'],
    2 => ['Coahuila', 'Nuevo León', 'Tamaulipas'],
    3 => ['Aguascalientes', 'Durango', 'Querétaro', 'San Luis Potosí', 'Zacatecas'],
    4 => ['Colima', 'Guanajuato', 'Jalisco', 'Michoacán', 'Nayarit'],
    5 => ['Guerrero', 'Hidalgo', 'Estado de México', 'Morelos', 'Puebla', 'Tlaxcala'],
    6 => ['Chiapas', 'Oaxaca', 'Tabasco', 'Veracruz', 'Campeche', 'Yucatán', 'Quintana Roo'],
    7 => ['Ciudad de México']
];

// Mapeo inverso: entidad -> zona
$zona_por_entidad = [];
foreach ($entidades_por_zona as $zona_num => $entidades) {
    foreach ($entidades as $entidad) {
        $zona_por_entidad[$entidad] = $zona_num;
    }
}

// Nombres de zonas
$nombres_zonas = [
    1 => 'Noroeste',
    2 => 'Norte',
    3 => 'Centro',
    4 => 'Centro Occidente',
    5 => 'Centro Sur',
    6 => 'Sur',
    7 => 'Ciudad de México'
];

// Zonas existentes para validar duplicados
$zonas_existentes = [
    ['id' => 1, 'numero' => 1, 'nombre' => 'Noroeste', 'activo' => true],
    ['id' => 2, 'numero' => 2, 'nombre' => 'Norte', 'activo' => true],
    ['id' => 3, 'numero' => 3, 'nombre' => 'Centro', 'activo' => true],
    ['id' => 4, 'numero' => 4, 'nombre' => 'Centro Occidente', 'activo' => true],
    ['id' => 5, 'numero' => 5, 'nombre' => 'Centro Sur', 'activo' => true],
    ['id' => 6, 'numero' => 6, 'nombre' => 'Sur', 'activo' => true],
    ['id' => 7, 'numero' => 7, 'nombre' => 'Ciudad de México', 'activo' => true]
];

$mensaje = '';
$error = '';
$entidades_seleccionadas = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $numero = (int)($_POST['numero'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $activo = isset($_POST['activo']) ? true : false;
    $entidades_seleccionadas = isset($_POST['entidades']) ? $_POST['entidades'] : [];
    
    if ($numero <= 0) $errores[] = 'Número de zona';
    if (empty($nombre)) $errores[] = 'Nombre de la zona';
    if (empty($entidades_seleccionadas)) $errores[] = 'Seleccionar al menos una entidad federativa';
    
    // Validar duplicados
    foreach ($zonas_existentes as $z) {
        if ($z['numero'] == $numero) {
            $errores[] = 'El número ' . $numero . ' ya está asignado a otra zona';
            break;
        }
        if (strtolower($z['nombre']) == strtolower($nombre)) {
            $errores[] = 'El nombre "' . $nombre . '" ya está registrado';
            break;
        }
    }
    
    // Validar que las entidades seleccionadas no estén ya asignadas a otras zonas
    $entidades_ocupadas = [];
    foreach ($entidades_seleccionadas as $entidad) {
        if (isset($zona_por_entidad[$entidad]) && $zona_por_entidad[$entidad] != $numero) {
            $zona_actual = $zona_por_entidad[$entidad];
            $nombre_zona_actual = $nombres_zonas[$zona_actual] ?? 'desconocida';
            $entidades_ocupadas[] = $entidad . ' (Zona ' . $zona_actual . ' - ' . $nombre_zona_actual . ')';
        }
    }
    
    if (!empty($entidades_ocupadas)) {
        $errores[] = 'Las siguientes entidades ya están asignadas a otras zonas: ' . implode(', ', $entidades_ocupadas);
    }
    
    if (empty($errores)) {
        $mensaje = 'Zona regional registrada exitosamente';
        // Limpiar formulario
        $_POST = [];
        $entidades_seleccionadas = [];
    } else {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
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
                <div class="page-header-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h1 class="page-title">Registrar Nueva Zona Regional</h1>
                    <p class="page-subtitle">Complete los datos para registrar una nueva zona regional en el sistema</p>
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

        <?php if ($error): ?>
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
            
            <form method="POST" id="formRegistro">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Número de Zona</label>
                        <input type="number" name="numero" class="form-control" placeholder="Ej. 8" 
                               value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>" min="1" max="99" required>
                        <small class="form-hint">Número único que identifica la zona (1-99)</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Nombre de la Zona</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Noroeste" 
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo" value="1" 
                                       <?= isset($_POST['activo']) ? 'checked' : 'checked' ?>>
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar la zona en los listados</small>
                    </div>
                    
                    <div class="form-group form-group-full">
                        <label class="form-label required">Entidades Federativas</label>
                        <div class="entidades-select-container">
                            <?php 
                            // Ordenar entidades alfabéticamente
                            sort($todas_entidades);
                            $seleccionadas = isset($_POST['entidades']) ? $_POST['entidades'] : [];
                            
                            foreach ($todas_entidades as $entidad): 
                                $seleccionada = in_array($entidad, $seleccionadas);
                                $zona_actual = isset($zona_por_entidad[$entidad]) ? $zona_por_entidad[$entidad] : null;
                                $nombre_zona_actual = $zona_actual ? $nombres_zonas[$zona_actual] : 'Sin zona';
                            ?>
                                <label class="entidad-checkbox <?= $seleccionada ? 'selected' : '' ?>" 
                                       title="Zona actual: <?= $nombre_zona_actual ?>">
                                    <input type="checkbox" name="entidades[]" value="<?= htmlspecialchars($entidad) ?>" 
                                           <?= $seleccionada ? 'checked' : '' ?>
                                           onchange="marcarSeleccion(this)">
                                    <span><?= htmlspecialchars($entidad) ?></span>
                                    <?php if ($zona_actual): ?>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <small class="form-hint">Seleccione las entidades que pertenecerán a esta zona</small>
                        <div id="mensajeSeleccion" style="display:none; margin-top:0.5rem; padding:0.5rem 1rem; background:#e3f2fd; border-radius:8px; border-left:4px solid #0d47a1; font-size:0.85rem; color:#0d47a1;">
                            <i class="fas fa-info-circle"></i> <span id="contadorEntidades">0</span> entidad(es) seleccionada(s)
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Guardar Zona
                    </button>
                    <button type="reset" class="btn-outline-modern">
                        <i class="fas fa-undo"></i> Limpiar
                    </button>
                    <a href="zonas_regionales.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - REGISTRO ZONA
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

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
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
// CONTADOR DE ENTIDADES SELECCIONADAS
// ============================================================

function marcarSeleccion(checkbox) {
    const label = checkbox.closest('.entidad-checkbox');
    if (checkbox.checked) {
        label.classList.add('selected');
    } else {
        label.classList.remove('selected');
    }
    actualizarContador();
}

function actualizarContador() {
    const checkboxes = document.querySelectorAll('input[name="entidades[]"]');
    let seleccionadas = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) seleccionadas++;
    });
    
    const mensaje = document.getElementById('mensajeSeleccion');
    const contador = document.getElementById('contadorEntidades');
    
    if (seleccionadas > 0) {
        mensaje.style.display = 'block';
        contador.textContent = seleccionadas;
    } else {
        mensaje.style.display = 'none';
    }
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
// VALIDACIÓN DEL FORMULARIO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRegistro');
    actualizarContador();
    
    form.addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('input[name="entidades[]"]');
        let seleccionadas = false;
        checkboxes.forEach(cb => {
            if (cb.checked) seleccionadas = true;
        });
        
        if (!seleccionadas) {
            e.preventDefault();
            alert('Debe seleccionar al menos una entidad federativa para la zona.');
            return false;
        }
        
        return true;
    });
});
</script>

<?php include 'template/footer.php'; ?>