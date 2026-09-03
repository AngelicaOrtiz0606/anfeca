<?php
// ============================================================
// SIDEANFECA - Catálogo de Niveles Académicos
// Editar nivel académico existente
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DEL NIVEL
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: niveles_academicos.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

$niveles_academicos = [
    ['id' => 1, 'nombre' => 'Licenciatura', 'abr_m' => 'Lic.', 'abr_f' => 'Lic.'],
    ['id' => 2, 'nombre' => 'Maestría', 'abr_m' => 'Mtro.', 'abr_f' => 'Mtra.'],
    ['id' => 3, 'nombre' => 'Doctorado', 'abr_m' => 'Dr.', 'abr_f' => 'Dra.'],
    ['id' => 4, 'nombre' => 'Especialidad', 'abr_m' => 'Esp.', 'abr_f' => 'Esp.'],
    ['id' => 5, 'nombre' => 'Técnico Superior Universitario', 'abr_m' => 'T.S.U.', 'abr_f' => 'T.S.U.'],
    ['id' => 6, 'nombre' => 'Ingeniería', 'abr_m' => 'Ing.', 'abr_f' => 'Ing.']
];

// Buscar el nivel
$nivel = null;
foreach ($niveles_academicos as $n) {
    if ($n['id'] == $id) {
        $nivel = $n;
        break;
    }
}

if (!$nivel) {
    header('Location: niveles_academicos.php?error=' . urlencode('Nivel académico no encontrado'));
    exit;
}

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $nombre = trim($_POST['nombre'] ?? '');
    $abr_m = trim($_POST['abr_m'] ?? '');
    $abr_f = trim($_POST['abr_f'] ?? '');
    
    if (empty($nombre)) $errores[] = 'Nombre del nivel académico';
    if (empty($abr_m)) $errores[] = 'Abreviatura en masculino';
    if (empty($abr_f)) $errores[] = 'Abreviatura en femenino';
    
    // Validar duplicados (excepto el mismo nivel)
    foreach ($niveles_academicos as $n) {
        if ($n['id'] != $id && strtolower($n['nombre']) == strtolower($nombre)) {
            $errores[] = 'El nombre "' . $nombre . '" ya está registrado como nivel académico';
            break;
        }
    }
    
    if (empty($errores)) {
        // Simular actualización exitosa
        $mensaje = 'Nivel académico actualizado exitosamente';
        // Actualizar datos del nivel para mostrarlos
        $nivel['nombre'] = $nombre;
        $nivel['abr_m'] = $abr_m;
        $nivel['abr_f'] = $abr_f;
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
                    <h1 class="page-title">Editar Nivel Académico</h1>
                    <p class="page-subtitle">Modifique los datos del nivel académico registrado en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="nivel_academico_consulta.php?id=<?= $id ?>" class="btn-outline-modern">
                    <i class="fas fa-eye"></i> Ver detalle
                </a>
                <a href="niveles_academicos.php" class="btn-outline-modern">
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
            
            <form method="POST" id="formEdicion">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Nombre del Nivel</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Licenciatura" 
                               value="<?= htmlspecialchars($nivel['nombre']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Abreviatura (Masculino)</label>
                        <input type="text" name="abr_m" class="form-control" placeholder="Ej. Lic." 
                               value="<?= htmlspecialchars($nivel['abr_m']) ?>" required>
                        <small class="form-hint">Ejemplo: Lic., Mtro., Dr., etc.</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">Abreviatura (Femenino)</label>
                        <input type="text" name="abr_f" class="form-control" placeholder="Ej. Lic." 
                               value="<?= htmlspecialchars($nivel['abr_f']) ?>" required>
                        <small class="form-hint">Ejemplo: Lic., Mtra., Dra., etc.</small>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Actualizar Nivel
                    </button>
                    <button type="reset" class="btn-outline-modern">
                        <i class="fas fa-undo"></i> Restablecer
                    </button>
                    <a href="niveles_academicos.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - EDICIÓN NIVEL ACADÉMICO
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
    grid-template-columns: repeat(3, 1fr);
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

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: repeat(2, 1fr);
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

@media (max-width: 480px) {
    .page-header-icon {
        width: 44px;
        height: 44px;
        font-size: 1.2rem;
    }

    .page-title {
        font-size: 1.2rem;
    }

    .form-container {
        padding: 1rem;
    }

    .form-label {
        font-size: 0.75rem;
        white-space: normal;
    }

    .form-control {
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
    }
}
</style>

<?php include 'template/footer.php'; ?>