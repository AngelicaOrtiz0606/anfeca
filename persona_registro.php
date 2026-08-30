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

$tipos_institucion = [
    1 => 'Universidad',
    2 => 'Facultad',
    3 => 'Campus'
];

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

$num_afiliacion_por_institucion = [
    'UABC - Mexicali' => '9801001',
    'UABC - Tijuana' => '9801002',
    'ITSON - Cd. Obregón' => '9801003',
    'UAS - Culiacán' => '9801004',
    'UANL - San Nicolás' => '9801005',
    'UAT - Ciudad Victoria' => '9801006',
    'UAdeC - Saltillo' => '9801007',
    'UACH - Chihuahua' => '9801008',
    'UAQ - Querétaro' => '9801009',
    'UASLP - San Luis Potosí' => '9801010',
    'UAZ - Zacatecas' => '9801011',
    'UAA - Aguascalientes' => '9801012',
    'UDG - Guadalajara' => '9801013',
    'UMSNH - Morelia' => '9801014',
    'UGTO - Guanajuato' => '9801015',
    'UdeC - Colima' => '9801016',
    'UAGro - Chilpancingo' => '9801017',
    'UAEH - Pachuca' => '9801018',
    'UAEM - Toluca' => '9801019',
    'UAEMor - Cuernavaca' => '9801020',
    'UNACH - Tuxtla Gutiérrez' => '9801021',
    'UABJO - Oaxaca' => '9801022',
    'UJAT - Villahermosa' => '9801023',
    'UV - Xalapa' => '9801024',
    'UNAM - Facultad de Contaduría' => '9801025',
    'UAM - Azcapotzalco' => '9801026',
    'IPN - ESCOM' => '9801027',
    'UAM - Iztapalapa' => '9801028'
];

$niveles_academicos = [
    ['id' => 1, 'nombre' => 'Licenciatura', 'abr_m' => 'Lic.', 'abr_f' => 'Lic.'],
    ['id' => 2, 'nombre' => 'Maestría', 'abr_m' => 'Mtro.', 'abr_f' => 'Mtra.'],
    ['id' => 3, 'nombre' => 'Doctorado', 'abr_m' => 'Dr.', 'abr_f' => 'Dra.']
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

$tipos_directorio = [
    1 => 'Consejo Nacional Directivo',
    2 => 'Consejos Regionales',
    3 => 'Coordinaciones Nacionales',
    4 => 'Instituciones'
];

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    if (empty($_POST['nombre'])) $errores[] = 'Nombre(s)';
    if (empty($_POST['apellido_paterno'])) $errores[] = 'Apellido Paterno';
    if (empty($_POST['genero'])) $errores[] = 'Género';
    if (empty($_POST['tipo_institucion'])) $errores[] = 'Tipo de Institución';
    if (empty($_POST['zona'])) $errores[] = 'Zona Regional';
    if (empty($_POST['institucion'])) $errores[] = 'Institución';
    if (empty($_POST['nivel_academico'])) $errores[] = 'Nivel Académico';
    if (empty($_POST['cargos'])) $errores[] = 'Al menos un cargo';
    if (empty($_POST['telefono_numero']) || empty(array_filter($_POST['telefono_numero']))) $errores[] = 'Teléfono';
    if (empty($_POST['correo_valor']) || empty(array_filter($_POST['correo_valor']))) $errores[] = 'Correo Electrónico';
    
    if (!empty($errores)) {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
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
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h1 class="page-title">Registrar Nueva Persona</h1>
                    <p class="page-subtitle">Complete los datos para registrar una persona en el sistema de directorios</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="personas.php" class="btn-outline-modern">
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
            
            <form method="POST" id="formRegistro">
                
                <!-- SECCIÓN 1: DATOS PERSONALES -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">01</span>
                        <h3>Datos Personales</h3>
                        <span class="section-line"></span>
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
                            <select name="genero" id="genero" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Nivel Académico</label>
                            <select name="nivel_academico" id="nivel_academico" class="form-control" required>
                                <option value="">Primero seleccione un género</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 2: INSTITUCIÓN -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">02</span>
                        <h3>Institución</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Tipo de Institución</label>
                            <select name="tipo_institucion" id="tipo_institucion" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                <?php foreach ($tipos_institucion as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

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

                        <!-- Número de afiliación (solo lectura) -->
                        <div class="form-group">
                            <label class="form-label">Núm. Afiliación</label>
                            <div class="afiliacion-display">
                                <span class="afiliacion-value" id="num_afiliacion_mostrado">- - - -</span>
                                <span class="afiliacion-hint">(Asignado por la institución)</span>
                            </div>
                            <input type="hidden" name="num_afiliacion" id="num_afiliacion" value="">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: CARGOS -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">03</span>
                        <h3>Cargos</h3>
                        <span class="section-line"></span>
                    </div>
                    <p class="section-hint">Seleccione el nivel, el cargo y las fechas de designación.</p>

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
                                
                                <!-- Campos dinámicos para Regional (se muestran aquí antes de las fechas) -->
                                <div class="cargo-detalle-regional" style="display:none; grid-column: span 2;">
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
                                
                                <div class="form-group">
                                    <label class="form-label required">Fecha Inicio</label>
                                    <input type="date" name="cargo_fecha_inicio[]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Fecha Fin</label>
                                    <input type="date" name="cargo_fecha_fin[]" class="form-control">
                                </div>
                                <div class="form-group" style="justify-content:flex-end; align-self:center; padding-top:1.2rem;">
                                    <button type="button" class="btn-remove" onclick="eliminarCargo(this)" style="display:none;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Directorios -->
                            <div class="cargo-directorios" style="margin-top:1rem; padding-top:1rem; border-top:1px dashed #e0e0e0;">
                                <label class="form-label required">Directorios</label>
                                <p class="section-hint" style="margin:0 0 0.5rem 0; font-size:0.8rem;">Seleccione uno o más directorios donde se mostrará este cargo</p>
                                <div class="directorios-grid">
                                    <?php foreach ($tipos_directorio as $id => $nombre): ?>
                                        <div class="checkbox-directorio">
                                            <input type="checkbox" name="cargo_directorios[<?= $id ?>][]" value="<?= $id ?>" id="directorio_<?= $id ?>">
                                            <label for="directorio_<?= $id ?>"><?= htmlspecialchars($nombre) ?></label>
                                        </div>
                                    <?php endforeach; ?>
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
                        <span class="section-number">04</span>
                        <h3>Contactos</h3>
                        <span class="section-line"></span>
                    </div>
                    <p class="section-hint">
                        <span class="hint-asterisk">*</span> Debe registrar al menos un <strong>Teléfono</strong> y un <strong>Correo Electrónico</strong>.
                        Puede agregar múltiples contactos de cada tipo.
                    </p>

                    <!-- Teléfonos -->
                    <div class="contactos-grupo">
                        <div class="contactos-grupo-header">
                            <h4>Teléfonos <span class="required-badge">Obligatorio</span></h4>
                        </div>
                        
                        <div id="telefonos-container">
                            <div class="contacto-item contacto-obligatorio" data-tipo="telefono">
                                <div class="contacto-grid-telefono">
                                    <div class="form-group">
                                        <label class="form-label required">LADA</label>
                                        <input type="text" name="telefono_lada[]" class="form-control" placeholder="55" required style="max-width:80px;" pattern="[0-9]*" inputmode="numeric">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">Número</label>
                                        <input type="text" name="telefono_numero[]" class="form-control" placeholder="1234 5678" required pattern="[0-9\s]*" inputmode="numeric">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Extensión</label>
                                        <input type="text" name="telefono_extension[]" class="form-control" placeholder="1234" pattern="[0-9]*" inputmode="numeric">
                                    </div>
                                    <div class="form-group" style="justify-content:center;">
                                        <label class="form-label">Visible</label>
                                        <div class="toggle-modern" onclick="toggleVisibility(this)">
                                            <input type="checkbox" name="telefono_visible[]" value="1" checked disabled>
                                            <span class="toggle-slider"></span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="justify-content:flex-end;">
                                        <button type="button" class="btn-remove" onclick="eliminarContacto(this, 'telefonos-container')" style="display:none;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-add-contacto" onclick="agregarContacto('telefonos-container', 'telefono')">
                            <i class="fas fa-plus-circle"></i> Agregar otro teléfono
                        </button>
                    </div>

                    <!-- Correos -->
                    <div class="contactos-grupo" style="margin-top:1.5rem;">
                        <div class="contactos-grupo-header">
                            <h4>Correos Electrónicos <span class="required-badge">Obligatorio</span></h4>
                        </div>
                        
                        <div id="correos-container">
                            <div class="contacto-item contacto-obligatorio" data-tipo="correo">
                                <div class="contacto-grid-correo">
                                    <div class="form-group">
                                        <label class="form-label required">Correo</label>
                                        <input type="email" name="correo_valor[]" class="form-control" placeholder="ejemplo@correo.com" required>
                                    </div>
                                    <div class="form-group" style="justify-content:center;">
                                        <label class="form-label">Visible</label>
                                        <div class="toggle-modern" onclick="toggleVisibility(this)">
                                            <input type="checkbox" name="correo_visible[]" value="1" checked disabled>
                                            <span class="toggle-slider"></span>
                                        </div>
                                    </div>
                                    <div class="form-group" style="justify-content:flex-end;">
                                        <button type="button" class="btn-remove" onclick="eliminarContacto(this, 'correos-container')" style="display:none;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn-add-contacto" onclick="agregarContacto('correos-container', 'correo')">
                            <i class="fas fa-plus-circle"></i> Agregar otro correo
                        </button>
                    </div>

                    <!-- Celulares -->
                    <div class="contactos-grupo" style="margin-top:1.5rem;">
                        <div class="contactos-grupo-header">
                            <h4>Celulares <span class="required-badge opcional">Opcional</span></h4>
                        </div>
                        
                        <div id="celulares-container">
                            <!-- No hay celular por defecto, solo el botón para agregar -->
                        </div>
                        <button type="button" class="btn-add-contacto" onclick="agregarCelular()">
                            <i class="fas fa-plus-circle"></i> Agregar celular
                        </button>
                    </div>
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
    font-size: 0.7rem;
    font-weight: 700;
    color: #8B0000;
    background: #f5edec;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

.section-header h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.section-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, #e0d6d6, transparent);
}

.section-hint {
    color: #888;
    font-size: 0.85rem;
    margin: -0.5rem 0 1.25rem 2.5rem;
}

.hint-asterisk {
    color: #c62828;
    font-weight: 700;
}

/* Grids */
.form-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.cargo-grid-base {
    display: grid;
    grid-template-columns: 1fr 1.2fr 1fr 1fr auto;
    gap: 1rem;
    align-items: start;
}

.cargo-grid-base .cargo-detalle-regional {
    grid-column: span 2;
}

.cargo-grid-detalle {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.directorios-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
}

/* Afiliación (solo lectura) */
.afiliacion-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1rem;
    background: #f8f6f6;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    min-height: 46px;
}

.afiliacion-value {
    font-weight: 600;
    color: #1a1a1a;
    font-family: monospace;
    font-size: 1rem;
}

.afiliacion-hint {
    color: #999;
    font-size: 0.7rem;
}

/* Contactos */
.contactos-grupo {
    background: #faf8f8;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    border: 1px solid #f0ecec;
}

.contactos-grupo-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.contactos-grupo-header h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0;
}

.required-badge {
    font-size: 0.6rem;
    font-weight: 700;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
    background: #e8f5e9;
    color: #2e7d32;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.required-badge.opcional {
    background: #fff3e0;
    color: #e65100;
}

.contacto-item {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 0.75rem;
    border: 1px solid #f0ecec;
    transition: all 0.2s ease;
}

.contacto-item:last-child {
    margin-bottom: 0;
}

.contacto-item.contacto-obligatorio {
    background: #fafcfa;
}

.contacto-item.contacto-opcional {
    background: #fafafa;
}

.contacto-grid-telefono {
    display: grid;
    grid-template-columns: 0.7fr 1.2fr 0.8fr 0.7fr auto;
    gap: 0.75rem;
    align-items: end;
}

.contacto-grid-correo {
    display: grid;
    grid-template-columns: 1.5fr 0.7fr auto;
    gap: 0.75rem;
    align-items: end;
}

.contacto-grid-celular {
    display: grid;
    grid-template-columns: 0.7fr 1.2fr 0.7fr auto;
    gap: 0.75rem;
    align-items: end;
}

.btn-add-contacto {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 1rem;
    background: transparent;
    color: #8B0000;
    border: 1px dashed #8B0000;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
}

.btn-add-contacto:hover {
    background: #f5edec;
    border-color: #8B0000;
}

/* Toggle Modern - FUNCIONAL */
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

.toggle-modern input:disabled + .toggle-slider {
    opacity: 0.6;
    cursor: not-allowed;
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

.form-control::placeholder {
    color: #bbb;
}

/* Checkbox Directorios */
.checkbox-directorio {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.6rem;
    background: #faf8f8;
    border-radius: 8px;
    border: 1px solid #f0ecec;
    transition: all 0.2s ease;
}

.checkbox-directorio:hover {
    background: #f5edec;
    border-color: #d4c5c4;
}

.checkbox-directorio input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #8B0000;
    cursor: pointer;
}

.checkbox-directorio label {
    font-size: 0.85rem;
    color: #4a4a4a;
    cursor: pointer;
    margin: 0;
}

/* Items dinámicos */
.cargo-item {
    background: #faf8f8;
    padding: 1.25rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #f0ecec;
}

.cargo-item:last-child {
    margin-bottom: 0;
}

.btn-remove {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 0.8rem;
    background: #fce8e8;
    color: #c62828;
    border: none;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
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
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

/* Responsive */
@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .cargo-grid-base {
        grid-template-columns: 1fr 1fr;
    }
    
    .cargo-grid-base .cargo-detalle-regional {
        grid-column: span 2;
    }
    
    .contacto-grid-telefono {
        grid-template-columns: 0.7fr 1fr 0.8fr 0.7fr;
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

    .cargo-grid-base {
        grid-template-columns: 1fr;
    }
    
    .cargo-grid-base .cargo-detalle-regional {
        grid-column: span 1;
    }

    .cargo-grid-detalle {
        grid-template-columns: 1fr;
    }

    .directorios-grid {
        grid-template-columns: 1fr;
    }

    .contacto-grid-telefono {
        grid-template-columns: 1fr 1fr;
    }

    .contacto-grid-correo {
        grid-template-columns: 1fr 0.7fr;
    }

    .contacto-grid-celular {
        grid-template-columns: 1fr 1fr;
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
const nivelesAcademicos = <?= json_encode($niveles_academicos) ?>;
const institucionesPorZona = <?= json_encode($instituciones_por_zona) ?>;
const numAfiliacionPorInstitucion = <?= json_encode($num_afiliacion_por_institucion) ?>;

// ============================================================
// FUNCIÓN PARA ALTERNAR VISIBILIDAD DEL TOGGLE
// ============================================================

function toggleVisibility(element) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    if (checkbox && !checkbox.disabled) {
        checkbox.checked = !checkbox.checked;
        // Disparar evento change para actualizar visualmente
        const event = new Event('change', { bubbles: true });
        checkbox.dispatchEvent(event);
    }
}

// ============================================================
// NIVEL ACADÉMICO SEGÚN GÉNERO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const generoSelect = document.getElementById('genero');
    const nivelSelect = document.getElementById('nivel_academico');
    
    if (generoSelect && nivelSelect) {
        generoSelect.addEventListener('change', function() {
            const genero = this.value;
            nivelSelect.innerHTML = '<option value="">Seleccionar nivel...</option>';
            
            if (genero) {
                nivelesAcademicos.forEach(function(nivel) {
                    const option = document.createElement('option');
                    option.value = nivel.id;
                    const abreviatura = genero === 'F' ? nivel.abr_f : nivel.abr_m;
                    option.textContent = nivel.nombre + ' (' + abreviatura + ')';
                    option.dataset.abrM = nivel.abr_m;
                    option.dataset.abrF = nivel.abr_f;
                    nivelSelect.appendChild(option);
                });
                nivelSelect.disabled = false;
            } else {
                nivelSelect.innerHTML = '<option value="">Primero seleccione un género</option>';
                nivelSelect.disabled = true;
            }
        });
        
        nivelSelect.disabled = true;
    }
});

// ============================================================
// INSTITUCIONES POR ZONA Y NÚMERO DE AFILIACIÓN
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const zonaSelect = document.getElementById('zona');
    const institucionSelect = document.getElementById('institucion');
    const numAfiliacionDisplay = document.getElementById('num_afiliacion_mostrado');
    const numAfiliacionInput = document.getElementById('num_afiliacion');
    
    if (zonaSelect && institucionSelect) {
        zonaSelect.addEventListener('change', function() {
            const zonaId = parseInt(this.value);
            institucionSelect.innerHTML = '<option value="">Seleccionar institución...</option>';
            numAfiliacionDisplay.textContent = '- - - -';
            numAfiliacionInput.value = '';
            
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
    
    if (institucionSelect) {
        institucionSelect.addEventListener('change', function() {
            const institucion = this.value;
            if (institucion && numAfiliacionPorInstitucion[institucion]) {
                numAfiliacionDisplay.textContent = numAfiliacionPorInstitucion[institucion];
                numAfiliacionInput.value = numAfiliacionPorInstitucion[institucion];
            } else {
                numAfiliacionDisplay.textContent = '- - - -';
                numAfiliacionInput.value = '';
            }
        });
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
        
        selectCargo.innerHTML = '<option value="">Primero seleccione un nivel</option>';
        selectCargo.disabled = true;
        detalleRegional.style.display = 'none';
        
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
            
            if (nivelId === 2) {
                detalleRegional.style.display = 'block';
                const zonaSelect = detalleRegional.querySelector('select[name="cargo_zona[]"]');
                if (zonaSelect) zonaSelect.setAttribute('required', 'required');
            }
        }
    }
});

// ============================================================
// CARGOS - AGREGAR / ELIMINAR
// ============================================================

function agregarCargo() {
    const container = document.getElementById('cargos-container');
    const primerCargo = container.querySelector('.cargo-item');
    const nuevoCargo = primerCargo.cloneNode(true);
    
    nuevoCargo.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
        if (select.classList.contains('select-cargo-nombre')) {
            select.disabled = true;
        }
    });
    
    nuevoCargo.querySelectorAll('input[type="date"]').forEach(input => {
        input.value = '';
    });
    
    nuevoCargo.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });
    
    const detalleRegional = nuevoCargo.querySelector('.cargo-detalle-regional');
    detalleRegional.style.display = 'none';
    detalleRegional.querySelectorAll('select').forEach(sel => {
        sel.selectedIndex = 0;
        sel.removeAttribute('required');
    });
    
    const btnEliminar = nuevoCargo.querySelector('.btn-remove');
    if (btnEliminar) btnEliminar.style.display = 'flex';
    
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

// Ocultar botón eliminar del primer cargo al cargar
document.addEventListener('DOMContentLoaded', function() {
    const primerCargo = document.querySelector('#cargos-container .cargo-item');
    if (primerCargo) {
        const btnEliminar = primerCargo.querySelector('.btn-remove');
        if (btnEliminar) btnEliminar.style.display = 'none';
    }
});

// ============================================================
// CONTACTOS - AGREGAR / ELIMINAR
// ============================================================

function agregarContacto(containerId, tipo) {
    const container = document.getElementById(containerId);
    const primerContacto = container.querySelector('.contacto-item');
    const nuevoContacto = primerContacto.cloneNode(true);
    
    // Limpiar inputs
    nuevoContacto.querySelectorAll('input[type="text"]').forEach(input => {
        input.value = '';
    });
    nuevoContacto.querySelectorAll('input[type="email"]').forEach(input => {
        input.value = '';
    });
    
    // Buscar el toggle y habilitar el checkbox
    const toggle = nuevoContacto.querySelector('.toggle-modern');
    if (toggle) {
        const checkbox = toggle.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = true;
            checkbox.disabled = false;
        }
    }
    
    // Mostrar botón eliminar
    const btnEliminar = nuevoContacto.querySelector('.btn-remove');
    if (btnEliminar) btnEliminar.style.display = 'flex';
    
    // Cambiar a contacto opcional (quitar clase obligatorio)
    nuevoContacto.classList.remove('contacto-obligatorio');
    nuevoContacto.classList.add('contacto-opcional');
    
    container.appendChild(nuevoContacto);
}

function eliminarContacto(btn, containerId) {
    const container = document.getElementById(containerId);
    if (container.querySelectorAll('.contacto-item').length > 1) {
        btn.closest('.contacto-item').remove();
    } else {
        alert('Debe tener al menos un contacto de este tipo');
    }
}

// ============================================================
// CELULARES - AGREGAR / ELIMINAR
// ============================================================

function agregarCelular() {
    const container = document.getElementById('celulares-container');
    
    const nuevoCelular = document.createElement('div');
    nuevoCelular.className = 'contacto-item contacto-opcional';
    nuevoCelular.dataset.tipo = 'celular';
    nuevoCelular.innerHTML = `
        <div class="contacto-grid-celular">
            <div class="form-group">
                <label class="form-label">LADA</label>
                <input type="text" name="celular_lada[]" class="form-control" placeholder="55" style="max-width:80px;" pattern="[0-9]*" inputmode="numeric">
            </div>
            <div class="form-group">
                <label class="form-label required">Número</label>
                <input type="text" name="celular_numero[]" class="form-control" placeholder="9876 5432" required pattern="[0-9\s]*" inputmode="numeric">
            </div>
            <div class="form-group" style="justify-content:center;">
                <label class="form-label">Visible</label>
                <div class="toggle-modern" onclick="toggleVisibility(this)">
                    <input type="checkbox" name="celular_visible[]" value="1" checked>
                    <span class="toggle-slider"></span>
                </div>
            </div>
            <div class="form-group" style="justify-content:flex-end;">
                <button type="button" class="btn-remove" onclick="eliminarCelular(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoCelular);
}

function eliminarCelular(btn) {
    btn.closest('.contacto-item').remove();
}

// Ocultar botones eliminar de los primeros contactos
document.addEventListener('DOMContentLoaded', function() {
    const primerTelefono = document.querySelector('#telefonos-container .contacto-item');
    if (primerTelefono) {
        const btn = primerTelefono.querySelector('.btn-remove');
        if (btn) btn.style.display = 'none';
    }
    
    const primerCorreo = document.querySelector('#correos-container .contacto-item');
    if (primerCorreo) {
        const btn = primerCorreo.querySelector('.btn-remove');
        if (btn) btn.style.display = 'none';
    }
});

// ============================================================
// VALIDACIÓN DE NÚMEROS EN INPUTS
// ============================================================

document.addEventListener('input', function(e) {
    if (e.target.matches('input[pattern="[0-9]*"]') || e.target.matches('input[pattern="[0-9\\s]*"]')) {
        // Solo permitir números y espacios
        e.target.value = e.target.value.replace(/[^0-9\s]/g, '');
    }
});
</script>

<?php include 'template/footer.php'; ?>