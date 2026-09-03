<?php
// ============================================================
// SIDEANFECA - Catálogo de Cargos
// Editar cargo existente
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DEL CARGO
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: cargos.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

// Datos simulados de cargos
$cargos = [
    ['id' => 1, 'nombre_m' => 'Presidente', 'nombre_f' => 'Presidenta', 'id_nivel' => 1, 'activo' => true],
    ['id' => 2, 'nombre_m' => 'Vicepresidente', 'nombre_f' => 'Vicepresidenta', 'id_nivel' => 1, 'activo' => true],
    ['id' => 3, 'nombre_m' => 'Secretario General', 'nombre_f' => 'Secretaria General', 'id_nivel' => 1, 'activo' => true],
    ['id' => 4, 'nombre_m' => 'Director Ejecutivo', 'nombre_f' => 'Directora Ejecutiva', 'id_nivel' => 1, 'activo' => true],
    ['id' => 5, 'nombre_m' => 'Coordinador Nacional', 'nombre_f' => 'Coordinadora Nacional', 'id_nivel' => 1, 'activo' => true],
    ['id' => 6, 'nombre_m' => 'Director Regional', 'nombre_f' => 'Directora Regional', 'id_nivel' => 2, 'activo' => true],
    ['id' => 7, 'nombre_m' => 'Secretario Regional', 'nombre_f' => 'Secretaria Regional', 'id_nivel' => 2, 'activo' => true],
    ['id' => 8, 'nombre_m' => 'Coordinador Regional', 'nombre_f' => 'Coordinadora Regional', 'id_nivel' => 2, 'activo' => true],
    ['id' => 9, 'nombre_m' => 'Director', 'nombre_f' => 'Directora', 'id_nivel' => 3, 'activo' => true],
    ['id' => 10, 'nombre_m' => 'Director General', 'nombre_f' => 'Directora General', 'id_nivel' => 3, 'activo' => true],
    ['id' => 11, 'nombre_m' => 'Coordinador Académico', 'nombre_f' => 'Coordinadora Académica', 'id_nivel' => 3, 'activo' => true],
    ['id' => 12, 'nombre_m' => 'Jefe de Departamento', 'nombre_f' => 'Jefa de Departamento', 'id_nivel' => 3, 'activo' => true],
    ['id' => 13, 'nombre_m' => 'Rector', 'nombre_f' => 'Rectora', 'id_nivel' => 3, 'activo' => true],
    ['id' => 14, 'nombre_m' => 'Secretario Técnico General', 'nombre_f' => 'Secretaria Técnica General', 'id_nivel' => 1, 'activo' => false],
];

// Buscar el cargo
$cargo = null;
foreach ($cargos as $c) {
    if ($c['id'] == $id) {
        $cargo = $c;
        break;
    }
}

if (!$cargo) {
    header('Location: cargos.php?error=' . urlencode('Cargo no encontrado'));
    exit;
}

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $nombre_m = trim($_POST['nombre_m'] ?? '');
    $nombre_f = trim($_POST['nombre_f'] ?? '');
    $id_nivel = (int)($_POST['id_nivel'] ?? 0);
    $activo = isset($_POST['activo']) ? true : false;
    
    if (empty($nombre_m)) $errores[] = 'Nombre en masculino';
    if (empty($nombre_f)) $errores[] = 'Nombre en femenino';
    if ($id_nivel <= 0) $errores[] = 'Nivel de cargo';
    
    // Validar duplicados (excepto el mismo cargo)
    foreach ($cargos as $c) {
        if ($c['id'] != $id && strtolower($c['nombre_m']) == strtolower($nombre_m)) {
            $errores[] = 'El nombre "' . $nombre_m . '" ya está registrado como cargo';
            break;
        }
    }
    
    if (empty($errores)) {
        // Simular actualización exitosa
        $mensaje = 'Cargo actualizado exitosamente';
        // Actualizar datos del cargo para mostrarlos
        $cargo['nombre_m'] = $nombre_m;
        $cargo['nombre_f'] = $nombre_f;
        $cargo['id_nivel'] = $id_nivel;
        $cargo['activo'] = $activo;
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
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="page-title">Editar Cargo</h1>
                    <p class="page-subtitle">Modifique los datos del cargo registrado en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="cargo_consulta.php?id=<?= $id ?>" class="btn-outline-modern">
                    <i class="fas fa-eye"></i> Ver detalle
                </a>
                <a href="cargos.php" class="btn-outline-modern">
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
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor revise</strong> <?= $error ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="form-container">
            <div class="form-legend">
                <span class="legend-asterisk">*</span>
                <span>Campos obligatorios</span>
            </div>
            
            <form method="POST" id="formEdicion">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Nombre (Masculino)</label>
                        <input type="text" name="nombre_m" class="form-control" placeholder="Ej. Presidente" 
                               value="<?= htmlspecialchars($cargo['nombre_m']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Nombre (Femenino)</label>
                        <input type="text" name="nombre_f" class="form-control" placeholder="Ej. Presidenta" 
                               value="<?= htmlspecialchars($cargo['nombre_f']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Nivel de Cargo</label>
                        <select name="id_nivel" class="form-control" required>
                            <option value="">Seleccionar nivel...</option>
                            <?php foreach ($niveles_cargo as $nid => $nombre): ?>
                                <option value="<?= $nid ?>" <?= $cargo['id_nivel'] == $nid ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="checkbox-container">
                            <div class="toggle-modern" onclick="toggleVisibility(this)">
                                <input type="checkbox" name="activo" id="activo" value="1" 
                                       <?= $cargo['activo'] ? 'checked' : '' ?>>
                                <span class="toggle-slider"></span>
                            </div>
                            <label for="activo" style="font-size:0.85rem;color:#4a4a4a;cursor:pointer;">Activo</label>
                        </div>
                        <small class="form-hint">Desactive para ocultar el cargo en los listados</small>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Actualizar Cargo
                    </button>
                    <button type="reset" class="btn-outline-modern">
                        <i class="fas fa-undo"></i> Restablecer
                    </button>
                    <a href="cargos.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - EDICIÓN CARGO
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
}
</style>

<script>
function toggleVisibility(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (checkbox && !checkbox.disabled) {
        checkbox.checked = !checkbox.checked;
        const event = new Event('change', { bubbles: true });
        checkbox.dispatchEvent(event);
    }
}
</script>

<?php include 'template/footer.php'; ?>