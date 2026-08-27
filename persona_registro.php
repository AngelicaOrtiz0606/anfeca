<?php
// ============================================================
// SIDEANFECA - Gestión de Personas
// Registrar nueva persona
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

$zonas_regionales = [
    1 => 'Noroeste',
    2 => 'Norte',
    3 => 'Centro',
    4 => 'Centro Occidente',
    5 => 'Centro Sur',
    6 => 'Sur',
    7 => 'Ciudad de México'
];

$coordinaciones_nacionales = [
    1 => 'Certificación Académica',
    2 => 'Academia ANFECA',
    3 => 'Emprendimiento Social',
    4 => 'Planes y Programas de Estudio',
    5 => 'Investigación',
    6 => 'Posgrado',
    7 => 'Maratones',
    8 => 'Historia',
    9 => 'Vinculación Nacional e Internacional',
    10 => 'Universidad-Empresa',
    11 => 'Formación Profesional Académica',
    12 => 'Responsabilidad Social Universitaria',
    13 => 'Igualdad de Género',
    14 => 'Desarrollo Académico Estudiantil'
];

$instituciones_por_zona = [
    1 => ['UABC - Mexicali', 'UABC - Tijuana', 'ITSON - Cd. Obregón', 'UAS - Culiacán'],
    2 => ['UANL - San Nicolás', 'UAT - Ciudad Victoria', 'UAdeC - Saltillo', 'UACH - Chihuahua'],
    3 => ['UAQ - Querétaro', 'UASLP - San Luis Potosí', 'UAZ - Zacatecas', 'UAA - Aguascalientes'],
    4 => ['UDG - Guadalajara', 'UMSNH - Morelia', 'UGTO - Guanajuato', 'UdeC - Colima'],
    5 => ['UAGro - Chilpancingo', 'UAEH - Pachuca', 'UAEM - Toluca', 'UAEMor - Cuernavaca'],
    6 => ['UNACH - Tuxtla Gutiérrez', 'UABJO - Oaxaca', 'UJAT - Villahermosa', 'UV - Xalapa'],
    7 => ['UNAM - Facultad de Contaduría', 'UAM - Azcapotzalco', 'IPN - ESCOM', 'UAM - Iztapalapa']
];

$niveles_academicos = [
    ['id' => 1, 'nombre' => 'Licenciatura', 'abr_m' => 'Lic.', 'abr_f' => 'Lic.'],
    ['id' => 2, 'nombre' => 'Maestría', 'abr_m' => 'Mtro.', 'abr_f' => 'Mtra.'],
    ['id' => 3, 'nombre' => 'Doctorado', 'abr_m' => 'Dr.', 'abr_f' => 'Dra.']
];

$tipos_contacto = [
    ['id' => 1, 'nombre' => 'Correo Electrónico'],
    ['id' => 2, 'nombre' => 'Teléfono Fijo'],
    ['id' => 3, 'nombre' => 'Teléfono Móvil']
];

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

$cargos_por_nivel = [
    1 => [ // Nacional
        'Presidente', 'Presidenta',
        'Vicepresidente', 'Vicepresidenta',
        'Secretario General', 'Secretaria General',
        'Director Ejecutivo', 'Directora Ejecutiva',
        'Coordinador Nacional', 'Coordinadora Nacional',
        'Secretario Técnico General', 'Secretaria Técnica General',
        'Representante de ANFECA ante ALAFEC'
    ],
    2 => [ // Regional
        'Director Regional', 'Directora Regional',
        'Secretario Regional', 'Secretaria Regional',
        'Coordinador Regional', 'Coordinadora Regional',
        'Secretario Técnico', 'Secretaria Técnica'
    ],
    3 => [ // Institucional
        'Director', 'Directora',
        'Director Académico', 'Directora Académica',
        'Director de Área', 'Directora de Área',
        'Director General', 'Directora General',
        'Director de Contaduría', 'Directora de Contaduría',
        'Director de División', 'Directora de División',
        'Director de División Económico-Administrativa', 'Directora de División Económico-Administrativa',
        'Director de Carrera de LIN', 'Directora de Carrera de LIN',
        'Coordinador Académico', 'Coordinadora Académica',
        'Coordinador de Licenciatura en Administración', 'Coordinadora de Licenciatura en Administración',
        'Coordinador de Contaduría y Administración', 'Coordinadora de Contaduría y Administración',
        'Coordinador de Licenciatura en Contaduría Pública', 'Coordinadora de Licenciatura en Contaduría Pública',
        'Coordinador de la Facultad', 'Coordinadora de la Facultad',
        'Coordinador General', 'Coordinadora General',
        'Coordinador de Negocios', 'Coordinadora de Negocios',
        'Coordinador de Proyectos y Vinculación Institucional', 'Coordinadora de Proyectos y Vinculación Institucional',
        'Coordinador de Unidad Académica', 'Coordinadora de Unidad Académica',
        'Coordinador de Área Económico-Administrativa', 'Coordinadora de Área Económico-Administrativa',
        'Coordinador de Ciencias Económico Administrativas', 'Coordinadora de Ciencias Económico Administrativas',
        'Coordinador de Contaduría', 'Coordinadora de Contaduría',
        'Jefe de Departamento', 'Jefa de Departamento',
        'Jefe de Departamento de Ciencias Administrativas', 'Jefa de Departamento de Ciencias Administrativas',
        'Jefe de Departamento de Ciencias Económico Administrativas', 'Jefa de Departamento de Ciencias Económico Administrativas',
        'Jefe del Departamento de Contabilidad', 'Jefa del Departamento de Contabilidad',
        'Rector', 'Rectora',
        'Encargado de la Dirección', 'Encargada de la Dirección',
        'Secretario', 'Secretaria'
    ]
];

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    if (empty($_POST['nombre'])) $errores[] = 'Nombre(s)';
    if (empty($_POST['apellido_paterno'])) $errores[] = 'Apellido Paterno';
    if (empty($_POST['genero'])) $errores[] = 'Género';
    if (empty($_POST['zona'])) $errores[] = 'Zona Regional';
    if (empty($_POST['institucion'])) $errores[] = 'Institución';
    if (empty($_POST['nivel_academico'])) $errores[] = 'Nivel Académico';
    if (empty($_POST['estado'])) $errores[] = 'Estado';
    if (empty($_POST['cargos'])) $errores[] = 'Al menos un cargo';
    
    if (!empty($errores)) {
        $error = 'Complete los siguientes campos obligatorios: ' . implode(', ', $errores);
    } else {
        $mensaje = 'Persona registrada exitosamente';
    }
}

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Registrar Persona</h1>
                <p class="page-subtitle">Complete los datos para registrar una nueva persona en el sistema</p>
            </div>
            <div class="page-header-right">
                <a href="personas.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>¡Éxito!</strong> <?= $mensaje ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Error</strong> <?= $error ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="form-container">
            <form method="POST" id="formRegistro">
                
                <!-- SECCIÓN 1: DATOS PERSONALES -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-user"></i>
                        <h3>Datos Personales</h3>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Nombre(s)</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Género</label>
                            <select name="genero" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Nivel Académico</label>
                            <select name="nivel_academico" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($niveles_academicos as $nivel): ?>
                                    <option value="<?= $nivel['id'] ?>"><?= htmlspecialchars($nivel['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Estado</label>
                            <select name="estado" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: INSTITUCIÓN -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-university"></i>
                        <h3>Institución</h3>
                        <span class="section-badge">Obligatorio</span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Zona Regional</label>
                            <select name="zona" id="zona" class="form-control" required>
                                <option value="">Seleccionar zona...</option>
                                <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Institución</label>
                            <select name="institucion" id="institucion" class="form-control" required>
                                <option value="">Primero seleccione una zona</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: CARGOS -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Cargos</h3>
                        <span class="section-badge">Múltiple</span>
                    </div>
                    <p class="section-hint">Seleccione el nivel y el cargo. Para cargos regionales deberá especificar zona y coordinación.</p>

                    <div id="cargos-container">
                        <div class="cargo-item">
                            <div class="cargo-grid-base">
                                <div class="form-group">
                                    <label class="form-label required">Nivel</label>
                                    <select name="cargo_nivel[]" class="form-control select-cargo-nivel" required>
                                        <option value="">Seleccionar nivel...</option>
                                        <?php foreach ($niveles_cargo as $id => $nombre): ?>
                                            <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label required">Cargo</label>
                                    <select name="cargo_nombre[]" class="form-control select-cargo-nombre" required>
                                        <option value="">Primero seleccione un nivel</option>
                                    </select>
                                </div>
                                <div class="form-group" style="justify-content:flex-end;">
                                    <button type="button" class="btn-remove" onclick="eliminarCargo(this)">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Campos dinámicos para Regional -->
                            <div class="cargo-detalle-regional" style="display:none; margin-top:1rem; padding-top:1rem; border-top:1px dashed #e0e0e0;">
                                <div class="cargo-grid-detalle">
                                    <div class="form-group">
                                        <label class="form-label required">Zona</label>
                                        <select name="cargo_zona[]" class="form-control">
                                            <option value="">Seleccionar zona...</option>
                                            <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                                <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Coordinación</label>
                                        <select name="cargo_coordinacion[]" class="form-control">
                                            <option value="">Sin coordinación</option>
                                            <?php foreach ($coordinaciones_nacionales as $id => $nombre): ?>
                                                <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-add" onclick="agregarCargo()">
                        <i class="fas fa-plus-circle"></i> Agregar otro cargo
                    </button>
                </div>

                <!-- SECCIÓN 4: CONTACTOS -->
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-address-card"></i>
                        <h3>Contactos</h3>
                        <span class="section-badge">Obligatorio</span>
                    </div>
                    <p class="section-hint">Agregue al menos un contacto principal.</p>

                    <div id="contactos-container">
                        <div class="contacto-item">
                            <div class="contacto-grid">
                                <div class="form-group">
                                    <label class="form-label required">Tipo</label>
                                    <select name="contacto_tipo[]" class="form-control" required>
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($tipos_contacto as $tipo): ?>
                                            <option value="<?= $tipo['id'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label required">Valor</label>
                                    <input type="text" name="contacto_valor[]" class="form-control" required>
                                </div>
                                <div class="form-group" style="justify-content:center;">
                                    <label class="form-label">Principal</label>
                                    <div class="checkbox-modern">
                                        <input type="checkbox" name="contacto_principal[]" value="1" checked>
                                        <span class="checkmark"></span>
                                    </div>
                                </div>
                                <div class="form-group" style="justify-content:flex-end;">
                                    <button type="button" class="btn-remove" onclick="eliminarContacto(this)">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-add" onclick="agregarContacto()">
                        <i class="fas fa-plus-circle"></i> Agregar contacto
                    </button>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Guardar Persona
                    </button>
                    <button type="reset" class="btn-outline-modern">
                        <i class="fas fa-undo"></i> Limpiar
                    </button>
                    <a href="personas.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS MODERNOS - REGISTRO
   ============================================================ */

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.75rem;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.page-subtitle {
    color: #6b6b6b;
    margin: 0.2rem 0 0 0;
    font-size: 0.95rem;
}

.page-header-right {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

/* Botones */
.btn-primary-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.7rem 1.5rem;
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
    padding: 0.7rem 1.5rem;
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

/* Formulario */
.form-container {
    background: white;
    border-radius: 14px;
    padding: 2rem 2.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
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
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.section-header i {
    font-size: 1.1rem;
    color: #8B0000;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5edec;
    border-radius: 10px;
}

.section-header h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.section-badge {
    background: #8B0000;
    color: white;
    font-size: 0.55rem;
    font-weight: 700;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.section-hint {
    color: #888;
    font-size: 0.85rem;
    margin: -0.5rem 0 1.25rem 3rem;
}

/* Grids */
.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.cargo-grid-base {
    display: grid;
    grid-template-columns: 1fr 1.5fr auto;
    gap: 1rem;
    align-items: end;
}

.cargo-grid-detalle {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.contacto-grid {
    display: grid;
    grid-template-columns: 1fr 1.5fr auto auto;
    gap: 1rem;
    align-items: end;
}

/* Form groups */
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

.form-control:disabled {
    background: #f5f5f5;
    color: #999;
    cursor: not-allowed;
}

/* Checkbox */
.checkbox-modern {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 0.25rem;
}

.checkbox-modern input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkbox-modern .checkmark {
    height: 22px;
    width: 22px;
    background: #fafafa;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.checkbox-modern input:checked + .checkmark {
    background: #8B0000;
    border-color: #8B0000;
}

.checkbox-modern input:checked + .checkmark::after {
    content: '✓';
    color: white;
    font-size: 14px;
    font-weight: 700;
}

/* Items dinámicos */
.cargo-item, .contacto-item {
    background: #faf8f8;
    padding: 1.25rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #f0ecec;
}

.cargo-item:last-child, .contacto-item:last-child {
    margin-bottom: 0;
}

.btn-remove {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: #fce8e8;
    color: #c62828;
    border: none;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-remove:hover {
    background: #c62828;
    color: white;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: transparent;
    color: #8B0000;
    border: 2px dashed #8B0000;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.btn-add:hover {
    background: #f5edec;
    border-color: #8B0000;
}

/* Form actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

/* Responsive */
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

    .form-container {
        padding: 1.25rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .cargo-grid-base {
        grid-template-columns: 1fr;
    }

    .cargo-grid-detalle {
        grid-template-columns: 1fr;
    }

    .contacto-grid {
        grid-template-columns: 1fr;
    }

    .section-hint {
        margin-left: 0;
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
// ============================================================
// DATOS
// ============================================================

const coordinacionesNacionales = <?= json_encode($coordinaciones_nacionales) ?>;
const cargosPorNivel = <?= json_encode($cargos_por_nivel) ?>;
const zonasRegionales = <?= json_encode($zonas_regionales) ?>;

// ============================================================
// INSTITUCIONES POR ZONA
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const zonaSelect = document.getElementById('zona');
    const institucionSelect = document.getElementById('institucion');
    const institucionesPorZona = <?= json_encode($instituciones_por_zona) ?>;
    
    if (zonaSelect && institucionSelect) {
        zonaSelect.addEventListener('change', function() {
            const zonaId = parseInt(this.value);
            institucionSelect.innerHTML = '<option value="">Seleccionar institución...</option>';
            
            if (zonaId && institucionesPorZona[zonaId]) {
                institucionesPorZona[zonaId].forEach(function(inst) {
                    const option = document.createElement('option');
                    option.value = inst;
                    option.textContent = inst;
                    institucionSelect.appendChild(option);
                });
                institucionSelect.disabled = false;
            } else {
                institucionSelect.disabled = true;
            }
        });
        institucionSelect.disabled = true;
    }
});

// ============================================================
// CARGOS DINÁMICOS POR NIVEL
// ============================================================

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('select-cargo-nivel')) {
        const selectNivel = e.target;
        const container = selectNivel.closest('.cargo-item');
        const selectCargo = container.querySelector('.select-cargo-nombre');
        const detalleRegional = container.querySelector('.cargo-detalle-regional');
        const nivelId = parseInt(selectNivel.value);
        
        // Limpiar cargo
        selectCargo.innerHTML = '<option value="">Primero seleccione un nivel</option>';
        selectCargo.disabled = true;
        
        // Ocultar detalle regional
        detalleRegional.style.display = 'none';
        
        // Marcar campos de detalle como no requeridos
        const selectsDetalle = detalleRegional.querySelectorAll('select');
        selectsDetalle.forEach(sel => sel.removeAttribute('required'));
        
        if (nivelId && cargosPorNivel[nivelId]) {
            cargosPorNivel[nivelId].forEach(function(cargo) {
                const option = document.createElement('option');
                option.value = cargo;
                option.textContent = cargo;
                selectCargo.appendChild(option);
            });
            selectCargo.disabled = false;
            
            // Si es Regional, mostrar campos de detalle
            if (nivelId === 2) {
                detalleRegional.style.display = 'block';
                // Marcar zona como requerida
                const zonaSelect = detalleRegional.querySelector('select[name="cargo_zona[]"]');
                if (zonaSelect) zonaSelect.setAttribute('required', 'required');
            }
        }
    }
});

// ============================================================
// AGREGAR / ELIMINAR CARGOS
// ============================================================

function agregarCargo() {
    const container = document.getElementById('cargos-container');
    const primerCargo = container.querySelector('.cargo-item');
    const nuevoCargo = primerCargo.cloneNode(true);
    
    // Limpiar selects
    nuevoCargo.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
        if (select.classList.contains('select-cargo-nombre')) {
            select.disabled = true;
        }
    });
    
    // Ocultar detalle regional y limpiar sus selects
    const detalleRegional = nuevoCargo.querySelector('.cargo-detalle-regional');
    detalleRegional.style.display = 'none';
    detalleRegional.querySelectorAll('select').forEach(sel => {
        sel.selectedIndex = 0;
        sel.removeAttribute('required');
    });
    
    container.appendChild(nuevoCargo);
}

function eliminarCargo(btn) {
    const container = document.getElementById('cargos-container');
    if (container.querySelectorAll('.cargo-item').length > 1) {
        btn.closest('.cargo-item').remove();
    } else {
        alert('Debe tener al menos un cargo');
    }
}

// ============================================================
// AGREGAR / ELIMINAR CONTACTOS
// ============================================================

function agregarContacto() {
    const container = document.getElementById('contactos-container');
    const primerContacto = container.querySelector('.contacto-item');
    const nuevoContacto = primerContacto.cloneNode(true);
    
    nuevoContacto.querySelectorAll('input').forEach(input => {
        if (input.type === 'checkbox') {
            input.checked = false;
        } else {
            input.value = '';
        }
    });
    nuevoContacto.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });
    
    container.appendChild(nuevoContacto);
}

function eliminarContacto(btn) {
    const container = document.getElementById('contactos-container');
    if (container.querySelectorAll('.contacto-item').length > 1) {
        btn.closest('.contacto-item').remove();
    } else {
        alert('Debe tener al menos un contacto');
    }
}
</script>

<?php include 'template/footer.php'; ?>