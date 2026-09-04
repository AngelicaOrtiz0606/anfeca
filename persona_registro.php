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
    1 => '1 - Noroeste',
    2 => '2 - Norte',
    3 => '3 - Centro',
    4 => '4 - Centro Occidente',
    5 => '5 - Centro Sur',
    6 => '6 - Sur',
    7 => '7 - Ciudad de México'
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

// Universidades por zona
$universidades_por_zona = [
    1 => ['Universidad Autónoma de Baja California', 'Universidad de Sonora', 'Instituto Tecnológico de Sonora'],
    2 => ['Universidad Autónoma de Nuevo León', 'Universidad Autónoma de Coahuila', 'Instituto Tecnológico de Nuevo León'],
    3 => ['Universidad Autónoma de Querétaro', 'Universidad Autónoma de San Luis Potosí', 'Universidad Autónoma de Zacatecas'],
    4 => ['Universidad de Guadalajara', 'Universidad Michoacana de San Nicolás de Hidalgo', 'Universidad de Guanajuato'],
    5 => ['Universidad Autónoma de Guerrero', 'Universidad Autónoma del Estado de Hidalgo', 'Universidad Autónoma del Estado de México'],
    6 => ['Universidad Autónoma de Yucatán', 'Universidad Autónoma de Chiapas', 'Universidad Veracruzana'],
    7 => ['Universidad Nacional Autónoma de México', 'Instituto Politécnico Nacional', 'Universidad Autónoma Metropolitana']
];

// Facultades por universidad
$facultades_por_universidad = [
    'Universidad Nacional Autónoma de México' => [
        'Facultad de Contaduría y Administración',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'Facultad de Medicina',
        'Facultad de Ciencias Políticas y Sociales'
    ],
    'Instituto Politécnico Nacional' => [
        'Escuela Superior de Cómputo (ESCOM)',
        'Escuela Superior de Ingeniería Mecánica y Eléctrica (ESIME)',
        'Escuela Superior de Física y Matemáticas (ESFM)',
        'Centro de Estudios Científicos y Tecnológicos (CECyT)'
    ],
    'Universidad de Guadalajara' => [
        'Facultad de Contaduría y Administración',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'Centro Universitario de Ciencias Económico Administrativas (CUCEA)'
    ],
    'Universidad Autónoma Metropolitana' => [
        'División de Ciencias Sociales y Humanidades',
        'División de Ciencias Naturales e Ingeniería',
        'Unidad Azcapotzalco',
        'Unidad Iztapalapa',
        'Unidad Xochimilco'
    ],
    'Universidad Autónoma de Baja California' => [
        'Facultad de Ciencias Administrativas y Sociales',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'Facultad de Ciencias Marinas'
    ],
    'Universidad de Sonora' => [
        'Facultad de Contaduría y Administración',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'División de Ciencias Económicas y Sociales'
    ],
    'Universidad Autónoma de Nuevo León' => [
        'Facultad de Contaduría Pública y Administración',
        'Facultad de Ingeniería Mecánica y Eléctrica',
        'Facultad de Derecho y Criminología',
        'Facultad de Ciencias de la Comunicación'
    ],
    'Universidad Autónoma de Querétaro' => [
        'Facultad de Contaduría y Administración',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'Facultad de Ciencias Políticas y Sociales'
    ],
    'Universidad Autónoma de Yucatán' => [
        'Facultad de Contaduría y Administración',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'Facultad de Ciencias Antropológicas'
    ],
    'Universidad Veracruzana' => [
        'Facultad de Contaduría y Administración',
        'Facultad de Ingeniería',
        'Facultad de Derecho',
        'Facultad de Ciencias Administrativas y Sociales'
    ]
];

// Campus por universidad
$campus_por_universidad = [
    'Universidad Nacional Autónoma de México' => [
        'Ciudad Universitaria (CU)',
        'Campus Juriquilla',
        'Campus Morelos',
        'Campus Ensenada',
        'Campus Mérida'
    ],
    'Instituto Politécnico Nacional' => [
        'Unidad Profesional Zacatenco',
        'Unidad Profesional Adolfo López Mateos',
        'Unidad Profesional Ticomán',
        'Unidad Profesional Santo Tomás'
    ],
    'Universidad de Guadalajara' => [
        'Campus Centro',
        'Campus CUCEA',
        'Campus CUCBA',
        'Campus CUCSH'
    ],
    'Universidad Autónoma Metropolitana' => [
        'Unidad Azcapotzalco',
        'Unidad Iztapalapa',
        'Unidad Xochimilco',
        'Unidad Cuajimalpa'
    ],
    'Universidad Autónoma de Baja California' => [
        'Campus Mexicali',
        'Campus Tijuana',
        'Campus Ensenada',
        'Campus San Quintín',
        'Campus Tecate'
    ],
    'Universidad de Sonora' => [
        'Campus Hermosillo',
        'Campus Cajeme',
        'Campus Navojoa',
        'Campus Caborca'
    ],
    'Universidad Autónoma de Nuevo León' => [
        'Ciudad Universitaria',
        'Campus Mederos',
        'Campus Escobedo',
        'Campus Linares'
    ],
    'Universidad Autónoma de Querétaro' => [
        'Campus Centro',
        'Campus Juriquilla',
        'Campus Aeropuerto',
        'Campus San Juan del Río'
    ],
    'Universidad Autónoma de Yucatán' => [
        'Campus Ciencias Sociales',
        'Campus Ciencias Biológicas',
        'Campus Ciencias de la Salud',
        'Campus Norte'
    ],
    'Universidad Veracruzana' => [
        'Campus Xalapa',
        'Campus Veracruz',
        'Campus Orizaba',
        'Campus Poza Rica',
        'Campus Coatzacoalcos'
    ]
];

// Números de afiliación por institución
$num_afiliacion_por_institucion = [
    'Universidad Nacional Autónoma de México' => '2601001',
    'Instituto Politécnico Nacional' => '2601003',
    'Universidad de Guadalajara' => '2601005',
    'Universidad Autónoma Metropolitana' => '2601008',
    'Universidad Autónoma de Baja California' => '2601007',
    'Universidad de Sonora' => '2601013',
    'Instituto Tecnológico de Sonora' => '2601015',
    'Universidad Autónoma de Nuevo León' => '2602009',
    'Universidad Autónoma de Coahuila' => '2602010',
    'Instituto Tecnológico de Nuevo León' => '2602011',
    'Universidad Autónoma de Querétaro' => '2603011',
    'Universidad Autónoma de San Luis Potosí' => '2603012',
    'Universidad Autónoma de Zacatecas' => '2603013',
    'Universidad Michoacana de San Nicolás de Hidalgo' => '2604007',
    'Universidad de Guanajuato' => '2604008',
    'Universidad Autónoma de Guerrero' => '2605014',
    'Universidad Autónoma del Estado de Hidalgo' => '2605015',
    'Universidad Autónoma del Estado de México' => '2605016',
    'Universidad Autónoma de Yucatán' => '2606012',
    'Universidad Autónoma de Chiapas' => '2606016',
    'Universidad Veracruzana' => '2606017',
    'Facultad de Contaduría y Administración (UNAM)' => '2607002',
    'Escuela Superior de Cómputo (ESCOM)' => '2607004',
    'Facultad de Contaduría y Administración (UDG)' => '2604006',
    'Campus UABC - Mexicali' => '2601008',
    'Campus UANL - San Nicolás' => '2605010'
];

$tipos_institucion = [
    1 => 'Universidad',
    2 => 'Facultad',
    3 => 'Campus'
];

// Niveles académicos desde el catálogo
$niveles_academicos = [
    ['id' => 1, 'nombre' => 'Licenciatura'],
    ['id' => 2, 'nombre' => 'Maestría'],
    ['id' => 3, 'nombre' => 'Maestría'],
    ['id' => 4, 'nombre' => 'Doctorado'],
    ['id' => 5, 'nombre' => 'Doctorado'],
    ['id' => 6, 'nombre' => 'Especialidad'],
    ['id' => 7, 'nombre' => 'Técnico Superior Universitario'],
    ['id' => 8, 'nombre' => 'Bachillerato'],
    ['id' => 9, 'nombre' => 'Ingeniería'],
    ['id' => 10, 'nombre' => 'Arquitectura']
];

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

// Cargos por nivel y género
$cargos_por_nivel = [
    1 => [ // Nacional - Femenino
        'Presidenta',
        'Vicepresidenta',
        'Secretaria General',
        'Directora Ejecutiva',
        'Coordinadora Nacional',
        'Secretaria Técnica General',
        'Representante de ANFECA ante ALAFEC'
    ],
    '1m' => [ // Nacional - Masculino
        'Presidente',
        'Vicepresidente',
        'Secretario General',
        'Director Ejecutivo',
        'Coordinador Nacional',
        'Secretario Técnico General',
        'Representante de ANFECA ante ALAFEC'
    ],
    2 => [ // Regional - Femenino
        'Directora Regional',
        'Secretaria Regional',
        'Coordinadora Regional',
        'Secretaria Técnica'
    ],
    '2m' => [ // Regional - Masculino
        'Director Regional',
        'Secretario Regional',
        'Coordinador Regional',
        'Secretario Técnico'
    ],
    3 => [ // Institucional - Femenino
        'Directora',
        'Directora Académica',
        'Directora de Área',
        'Directora General',
        'Directora de Contaduría',
        'Directora de División',
        'Directora de División Económico-Administrativa',
        'Directora de Carrera de LIN',
        'Coordinadora Académica',
        'Coordinadora de Licenciatura en Administración',
        'Coordinadora de Contaduría y Administración',
        'Coordinadora de Licenciatura en Contaduría Pública',
        'Coordinadora de la Facultad',
        'Coordinadora General',
        'Coordinadora de Negocios',
        'Coordinadora de Proyectos y Vinculación Institucional',
        'Coordinadora de Unidad Académica',
        'Coordinadora de Área Económico-Administrativa',
        'Coordinadora de Ciencias Económico Administrativas',
        'Coordinadora de Contaduría',
        'Jefa de Departamento',
        'Jefa de Departamento de Ciencias Administrativas',
        'Jefa de Departamento de Ciencias Económico Administrativas',
        'Jefa del Departamento de Contabilidad',
        'Rectora',
        'Encargada de la Dirección',
        'Secretaria'
    ],
    '3m' => [ // Institucional - Masculino
        'Director',
        'Director Académico',
        'Director de Área',
        'Director General',
        'Director de Contaduría',
        'Director de División',
        'Director de División Económico-Administrativa',
        'Director de Carrera de LIN',
        'Coordinador Académico',
        'Coordinador de Licenciatura en Administración',
        'Coordinador de Contaduría y Administración',
        'Coordinador de Licenciatura en Contaduría Pública',
        'Coordinador de la Facultad',
        'Coordinador General',
        'Coordinador de Negocios',
        'Coordinador de Proyectos y Vinculación Institucional',
        'Coordinador de Unidad Académica',
        'Coordinador de Área Económico-Administrativa',
        'Coordinador de Ciencias Económico Administrativas',
        'Coordinador de Contaduría',
        'Jefe de Departamento',
        'Jefe de Departamento de Ciencias Administrativas',
        'Jefe de Departamento de Ciencias Económico Administrativas',
        'Jefe del Departamento de Contabilidad',
        'Rector',
        'Encargado de la Dirección',
        'Secretario'
    ]
];

$tipos_directorio = [
    1 => 'Consejo Nacional Directivo',
    2 => 'Consejos Regionales',
    3 => 'Coordinaciones Nacionales',
    4 => 'Instituciones'
];

// ============================================================
// DATOS EXISTENTES PARA VALIDAR TITULARIDAD
// ============================================================

$personas_existentes = [
    [
        'id' => 1,
        'nombre' => 'María',
        'apellido_paterno' => 'González',
        'apellido_materno' => 'Pérez',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'cargo' => 'Directora',
        'titular' => true,
        'activo' => true
    ],
    [
        'id' => 2,
        'nombre' => 'Juan',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'López',
        'institucion' => 'Instituto Politécnico Nacional',
        'cargo' => 'Director',
        'titular' => true,
        'activo' => true
    ],
    [
        'id' => 3,
        'nombre' => 'Ana',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Ramírez',
        'institucion' => 'Universidad de Guadalajara',
        'cargo' => 'Directora',
        'titular' => true,
        'activo' => true
    ]
];

$mensaje = '';
$error = '';
$mostrar_modal_titular = false;
$titular_existente = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    if (empty($_POST['nombre'])) $errores[] = 'Nombre(s)';
    if (empty($_POST['apellido_paterno'])) $errores[] = 'Apellido Paterno';
    if (empty($_POST['genero'])) $errores[] = 'Género';
    if (empty($_POST['tipo_institucion'])) $errores[] = 'Tipo de Institución';
    if (empty($_POST['zona'])) $errores[] = 'Zona Regional';
    if (empty($_POST['institucion'])) $errores[] = 'Institución';
    if (empty($_POST['niveles_academicos']) || !is_array($_POST['niveles_academicos']) || count(array_filter($_POST['niveles_academicos'])) == 0) {
        $errores[] = 'Nivel(es) Académico(s)';
    }
    if (empty($_POST['cargos'])) $errores[] = 'Al menos un cargo';
    if (empty($_POST['telefono_numero']) || empty(array_filter($_POST['telefono_numero']))) $errores[] = 'Teléfono';
    if (empty($_POST['correo_valor']) || empty(array_filter($_POST['correo_valor']))) $errores[] = 'Correo Electrónico';
    
    $titular_institucional = false;
    $institucion_seleccionada = $_POST['institucion'] ?? '';
    
    if (!empty($_POST['cargo_titular']) && is_array($_POST['cargo_titular'])) {
        foreach ($_POST['cargo_titular'] as $index => $titular) {
            if ($titular == '1' && isset($_POST['cargo_nivel'][$index]) && $_POST['cargo_nivel'][$index] == '3') {
                $titular_institucional = true;
                break;
            }
        }
    }
    
    if ($titular_institucional && !empty($institucion_seleccionada)) {
        foreach ($personas_existentes as $persona) {
            if ($persona['institucion'] == $institucion_seleccionada && $persona['titular'] && $persona['activo']) {
                $titular_existente = $persona;
                break;
            }
        }
    }
    
    if (!empty($errores)) {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    } else if ($titular_existente) {
        $mostrar_modal_titular = true;
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

        <?php if ($mostrar_modal_titular && $titular_existente): ?>
        <div class="modal-overlay modal-titular" id="modalTitular">
            <div class="modal-card modal-card-titular">
                <div class="modal-header">
                    <i class="fas fa-user-check" style="color:#e65100;"></i>
                    <h3>Ya existe un titular para esta institución</h3>
                </div>
                <div class="modal-body">
                    <p>La persona <strong><?= htmlspecialchars($titular_existente['nombre'] . ' ' . $titular_existente['apellido_paterno']) ?></strong> ya está registrada como titular de <strong><?= htmlspecialchars($titular_existente['institucion']) ?></strong> con el cargo de <strong><?= htmlspecialchars($titular_existente['cargo']) ?></strong>.</p>
                    
                    <div class="modal-opciones">
                        <div class="modal-opcion">
                            <div class="modal-opcion-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h4>Reemplazar titular</h4>
                                <p>La persona actual dejará de ser titular y la nueva persona ocupará su lugar.</p>
                            </div>
                        </div>
                        <div class="modal-opcion">
                            <div class="modal-opcion-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h4>Registrar sin titular</h4>
                                <p>La nueva persona se registrará sin el rol de titular. La titularidad permanecerá con la persona actual.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal-cancel" onclick="cerrarModalTitular('sin_titular')">Registrar sin titular</button>
                    <button class="btn-modal-danger" onclick="cerrarModalTitular('reemplazar')">
                        <i class="fas fa-exchange-alt"></i> Reemplazar titular
                    </button>
                </div>
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
                            <label class="form-label required">Nivel(es) Académico(s)</label>
                            <div class="niveles-container">
                                <div class="niveles-select-group">
                                    <select name="nivel_select" id="nivel_select" class="form-control">
                                        <option value="">Seleccionar nivel académico...</option>
                                        <?php foreach ($niveles_academicos as $nivel): ?>
                                            <option value="<?= $nivel['id'] ?>" data-nombre="<?= htmlspecialchars($nivel['nombre']) ?>">
                                                <?= htmlspecialchars($nivel['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" class="btn-add-nivel" onclick="agregarNivel()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div id="niveles_seleccionados" class="niveles-tags">
                                    <!-- Las tags se agregan aquí dinámicamente -->
                                </div>
                                <input type="hidden" name="niveles_academicos[]" id="niveles_academicos_hidden" value="">
                            </div>
                            <small class="form-hint">Seleccione un nivel y presione el botón + para agregarlo</small>
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

                        <div class="form-group" id="universidad_container" style="display:none;">
                            <label class="form-label required">Universidad</label>
                            <select name="universidad" id="universidad" class="form-control">
                                <option value="">Seleccionar universidad...</option>
                            </select>
                            <small class="form-hint">Seleccione la universidad a la que pertenece</small>
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
                                <span class="afiliacion-value" id="num_afiliacion_mostrado">- - - - - - -</span>
                            </div>
                            <input type="hidden" name="num_afiliacion" id="num_afiliacion" value="">
                            <small class="form-hint">Asignado por la institución</small>
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
                                    <select name="cargo_nivel[]" id="cargo_nivel_0" class="form-control select-cargo-nivel" required>
                                        <option value="">Seleccionar nivel...</option>
                                        <?php foreach ($niveles_cargo as $id => $nombre): ?>
                                            <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label required">Cargo</label>
                                    <select name="cargo_nombre[]" id="cargo_nombre_0" class="form-control select-cargo-nombre" required>
                                        <option value="">Primero seleccione un nivel y género</option>
                                    </select>
                                </div>
                                
                                <!-- Campos dinámicos para Nacional y Regional -->
                                <div class="cargo-detalle-zona-coordinacion" style="display:none; grid-column: span 2;">
                                    <div class="cargo-grid-detalle">
                                        <div class="form-group">
                                            <label class="form-label">Zona</label>
                                            <select name="cargo_zona[]" class="form-control">
                                                <option value="">Seleccionar zona...</option>
                                                <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="form-hint">Opcional</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Coordinación</label>
                                            <select name="cargo_coordinacion[]" class="form-control">
                                                <option value="">Sin coordinación</option>
                                                <?php foreach ($coordinaciones_nacionales as $id => $nombre): ?>
                                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <small class="form-hint">Opcional</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Titular de institución (solo para cargos institucionales) -->
                                <div class="form-group cargo-titular" style="display:none; align-self:flex-end; padding-bottom:0;">
                                    <div class="checkbox-titular">
                                        <input type="checkbox" name="cargo_titular[]" value="1" id="titular_actual">
                                        <label for="titular_actual">Titular</label>
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
                                            <input type="checkbox" name="cargo_directorios[<?= $id ?>][]" value="<?= $id ?>" id="directorio_<?= $id ?>_0">
                                            <label for="directorio_<?= $id ?>_0"><?= htmlspecialchars($nombre) ?></label>
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

/* Niveles Académicos - Select con botón + */
.niveles-container {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.niveles-select-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.niveles-select-group .form-control {
    flex: 1;
}

.btn-add-nivel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #8B0000;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.btn-add-nivel:hover {
    background: #5C0000;
    transform: scale(1.05);
}

.btn-add-nivel:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.niveles-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    min-height: 32px;
    padding: 0.25rem 0;
}

.nivel-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.25rem 0.6rem 0.25rem 0.8rem;
    background: #f5edec;
    border: 1px solid #d4c5c4;
    border-radius: 20px;
    font-size: 0.8rem;
    color: #4a3a3a;
    animation: fadeInTag 0.3s ease;
}

.nivel-tag .nivel-tag-nombre {
    font-weight: 500;
}

.nivel-tag .btn-remove-tag {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    background: #c62828;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 0.6rem;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    line-height: 1;
}

.nivel-tag .btn-remove-tag:hover {
    background: #8B0000;
    transform: scale(1.1);
}

@keyframes fadeInTag {
    from { opacity: 0; transform: scale(0.8); }
    to { opacity: 1; transform: scale(1); }
}

/* Afiliación Display */
.afiliacion-display {
    display: flex;
    align-items: center;
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

/* Cargos */
.cargo-grid-base {
    display: grid;
    grid-template-columns: 1fr 1.2fr 0.7fr 1fr 1fr auto;
    gap: 1rem;
    align-items: start;
}

.cargo-grid-base .cargo-detalle-zona-coordinacion {
    grid-column: span 2;
}

.cargo-grid-detalle {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.cargo-grid-detalle .form-hint {
    font-size: 0.65rem;
    color: #999;
}

/* Checkbox Titular */
.cargo-titular {
    display: flex;
    align-items: flex-end;
    padding-bottom: 0;
}

.checkbox-titular {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1rem;
    background: #faf8f8;
    border-radius: 10px;
    border: 2px solid #e8e8e8;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 46px;
    width: 100%;
}

.checkbox-titular:hover {
    background: #f5edec;
    border-color: #d4c5c4;
}

.checkbox-titular input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #8B0000;
    cursor: pointer;
}

.checkbox-titular label {
    font-size: 0.85rem;
    color: #4a4a4a;
    cursor: pointer;
    margin: 0;
    font-weight: 500;
}

/* Modal Titular */
.modal-titular .modal-card {
    max-width: 580px;
}

.modal-card-titular .modal-header i {
    font-size: 1.5rem;
}

.modal-opciones {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-top: 1rem;
}

.modal-opcion {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 0.75rem 1rem;
    background: #faf8f8;
    border-radius: 10px;
    border: 1px solid #f0ecec;
}

.modal-opcion-icon {
    width: 40px;
    height: 40px;
    min-width: 40px;
    background: #f5edec;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8B0000;
    font-size: 1rem;
}

.modal-opcion h4 {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0 0 0.15rem 0;
    color: #1a1a1a;
}

.modal-opcion p {
    font-size: 0.8rem;
    color: #666;
    margin: 0;
}

.modal-card-titular .modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #f5f0f0;
    flex-wrap: wrap;
}

.modal-card-titular .btn-modal-cancel {
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

.modal-card-titular .btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.modal-card-titular .btn-modal-danger {
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

.modal-card-titular .btn-modal-danger:hover {
    background: #c62828;
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

/* Toggle Modern */
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

.directorios-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
}

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
    
    .cargo-grid-base .cargo-detalle-zona-coordinacion {
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
    
    .cargo-grid-base .cargo-detalle-zona-coordinacion {
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
const universidadesPorZona = <?= json_encode($universidades_por_zona) ?>;
const facultadesPorUniversidad = <?= json_encode($facultades_por_universidad) ?>;
const campusPorUniversidad = <?= json_encode($campus_por_universidad) ?>;
const nivelesCargo = <?= json_encode($niveles_cargo) ?>;
const numAfiliacionPorInstitucion = <?= json_encode($num_afiliacion_por_institucion) ?>;
const nivelesAcademicos = <?= json_encode($niveles_academicos) ?>;

// ============================================================
// FUNCIÓN PARA ALTERNAR VISIBILIDAD DEL TOGGLE
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
// ACTUALIZAR NÚMERO DE AFILIACIÓN
// ============================================================

function actualizarNumeroAfiliacion() {
    const institucionSelect = document.getElementById('institucion');
    const numDisplay = document.getElementById('num_afiliacion_mostrado');
    const numInput = document.getElementById('num_afiliacion');
    const institucion = institucionSelect.value;
    
    if (institucion && numAfiliacionPorInstitucion[institucion]) {
        numDisplay.textContent = numAfiliacionPorInstitucion[institucion];
        numInput.value = numAfiliacionPorInstitucion[institucion];
    } else {
        numDisplay.textContent = '- - - - - - -';
        numInput.value = '';
    }
}

// ============================================================
// CERRAR MODAL DE TITULAR
// ============================================================

function cerrarModalTitular(accion) {
    const modal = document.getElementById('modalTitular');
    if (modal) {
        modal.remove();
    }
    
    if (accion === 'reemplazar') {
        mostrarMensaje('Titular reemplazado exitosamente', 'success');
    } else {
        mostrarMensaje('Persona registrada sin rol de titular', 'success');
    }
}

// ============================================================
// INSTITUCIONES POR ZONA Y TIPO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const zonaSelect = document.getElementById('zona');
    const tipoSelect = document.getElementById('tipo_institucion');
    const institucionSelect = document.getElementById('institucion');
    const universidadContainer = document.getElementById('universidad_container');
    const universidadSelect = document.getElementById('universidad');
    
    function cargarUniversidades() {
        const zonaId = parseInt(zonaSelect.value);
        universidadSelect.innerHTML = '<option value="">Seleccionar universidad...</option>';
        
        if (zonaId && universidadesPorZona[zonaId]) {
            universidadesPorZona[zonaId].forEach(function(uni) {
                const option = document.createElement('option');
                option.value = uni;
                option.textContent = uni;
                universidadSelect.appendChild(option);
            });
            universidadSelect.disabled = false;
        } else {
            universidadSelect.disabled = true;
        }
    }
    
    function cargarInstituciones() {
        const tipo = parseInt(tipoSelect.value);
        const universidad = universidadSelect.value;
        
        institucionSelect.innerHTML = '<option value="">Seleccionar institución...</option>';
        
        if (tipo === 1) {
            // Universidad: mostrar universidades de la zona
            const zonaId = parseInt(zonaSelect.value);
            if (zonaId && universidadesPorZona[zonaId]) {
                universidadesPorZona[zonaId].forEach(function(uni) {
                    const option = document.createElement('option');
                    option.value = uni;
                    option.textContent = uni;
                    institucionSelect.appendChild(option);
                });
                institucionSelect.disabled = false;
            } else {
                institucionSelect.disabled = true;
            }
        } else if (tipo === 2) {
            // Facultad: mostrar facultades de la universidad seleccionada
            if (universidad && facultadesPorUniversidad[universidad]) {
                facultadesPorUniversidad[universidad].forEach(function(facultad) {
                    const option = document.createElement('option');
                    option.value = facultad;
                    option.textContent = facultad;
                    institucionSelect.appendChild(option);
                });
                institucionSelect.disabled = false;
            } else {
                institucionSelect.disabled = true;
            }
        } else if (tipo === 3) {
            // Campus: mostrar campus de la universidad seleccionada
            if (universidad && campusPorUniversidad[universidad]) {
                campusPorUniversidad[universidad].forEach(function(campus) {
                    const option = document.createElement('option');
                    option.value = campus;
                    option.textContent = campus;
                    institucionSelect.appendChild(option);
                });
                institucionSelect.disabled = false;
            } else {
                institucionSelect.disabled = true;
            }
        } else {
            institucionSelect.disabled = true;
        }
        
        // Actualizar número de afiliación
        actualizarNumeroAfiliacion();
    }
    
    // Evento: cambio de zona
    if (zonaSelect) {
        zonaSelect.addEventListener('change', function() {
            cargarUniversidades();
            cargarInstituciones();
        });
    }
    
    // Evento: cambio de tipo
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            const tipo = parseInt(this.value);
            
            if (tipo === 1) {
                universidadContainer.style.display = 'none';
                universidadSelect.removeAttribute('required');
                universidadSelect.value = '';
                cargarInstituciones();
            } else if (tipo === 2 || tipo === 3) {
                universidadContainer.style.display = 'block';
                universidadSelect.setAttribute('required', 'required');
                cargarUniversidades();
                cargarInstituciones();
            } else {
                universidadContainer.style.display = 'none';
                universidadSelect.removeAttribute('required');
                universidadSelect.value = '';
                institucionSelect.innerHTML = '<option value="">Primero seleccione tipo</option>';
                institucionSelect.disabled = true;
            }
        });
    }
    
    // Evento: cambio de universidad
    if (universidadSelect) {
        universidadSelect.addEventListener('change', function() {
            cargarInstituciones();
        });
    }
    
    // Evento: cambio de institución
    if (institucionSelect) {
        institucionSelect.addEventListener('change', function() {
            actualizarNumeroAfiliacion();
        });
    }
    
    // Inicializar
    institucionSelect.disabled = true;
    universidadSelect.disabled = true;
    universidadContainer.style.display = 'none';
});

// ============================================================
// CARGOS DINÁMICOS POR NIVEL Y GÉNERO
// ============================================================

function cargarCargos(selectNivel, selectCargo, container, genero) {
    const nivelId = parseInt(selectNivel.value);
    const detalleZona = container.querySelector('.cargo-detalle-zona-coordinacion');
    const titularContainer = container.querySelector('.cargo-titular');
    
    selectCargo.innerHTML = '<option value="">Primero seleccione un nivel y género</option>';
    selectCargo.disabled = true;
    detalleZona.style.display = 'none';
    titularContainer.style.display = 'none';
    
    // Limpiar requeridos de zona y coordinación
    const zonaSelect = detalleZona.querySelector('select[name="cargo_zona[]"]');
    const coordSelect = detalleZona.querySelector('select[name="cargo_coordinacion[]"]');
    if (zonaSelect) zonaSelect.removeAttribute('required');
    if (coordSelect) coordSelect.removeAttribute('required');
    
    if (nivelId && genero) {
        let key = nivelId;
        if (genero === 'M') {
            key = nivelId + 'm';
        }
        
        if (cargosPorNivel[key]) {
            cargosPorNivel[key].forEach(function(cargo) {
                const option = document.createElement('option');
                option.value = cargo;
                option.textContent = cargo;
                selectCargo.appendChild(option);
            });
            selectCargo.disabled = false;
        }
        
        // Nacional (1) - zona y coordinación opcionales
        if (nivelId === 1) {
            detalleZona.style.display = 'block';
            if (zonaSelect) zonaSelect.removeAttribute('required');
            if (coordSelect) coordSelect.removeAttribute('required');
            // Actualizar hint
            const hints = detalleZona.querySelectorAll('.form-hint');
            hints.forEach(h => h.textContent = 'Opcional');
        }
        
        // Regional (2) - zona requerida, coordinación opcional
        if (nivelId === 2) {
            detalleZona.style.display = 'block';
            if (zonaSelect) zonaSelect.setAttribute('required', 'required');
            if (coordSelect) coordSelect.removeAttribute('required');
            // Actualizar hint
            const hints = detalleZona.querySelectorAll('.form-hint');
            if (hints.length > 0) hints[0].textContent = 'Obligatorio';
            if (hints.length > 1) hints[1].textContent = 'Opcional';
        }
        
        // Institucional (3) - sin zona ni coordinación
        if (nivelId === 3) {
            detalleZona.style.display = 'none';
            titularContainer.style.display = 'flex';
        }
    }
}

// Evento: cambio de nivel
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('select-cargo-nivel')) {
        const selectNivel = e.target;
        const container = selectNivel.closest('.cargo-item');
        const selectCargo = container.querySelector('.select-cargo-nombre');
        const generoSelect = document.getElementById('genero');
        const genero = generoSelect ? generoSelect.value : '';
        
        cargarCargos(selectNivel, selectCargo, container, genero);
    }
});

// Evento: cambio de género (actualiza todos los cargos)
document.addEventListener('DOMContentLoaded', function() {
    const generoSelect = document.getElementById('genero');
    if (generoSelect) {
        generoSelect.addEventListener('change', function() {
            const genero = this.value;
            const cargosItems = document.querySelectorAll('.cargo-item');
            cargosItems.forEach(function(item, index) {
                const selectNivel = item.querySelector('.select-cargo-nivel');
                const selectCargo = item.querySelector('.select-cargo-nombre');
                if (selectNivel && selectCargo) {
                    cargarCargos(selectNivel, selectCargo, item, genero);
                }
            });
        });
    }
});

// ============================================================
// NIVELES ACADÉMICOS - SELECT CON BOTÓN +
// ============================================================

let nivelesSeleccionados = [];

function agregarNivel() {
    const select = document.getElementById('nivel_select');
    const valor = select.value;
    
    if (!valor) {
        mostrarMensaje('Seleccione un nivel académico', 'error');
        return;
    }
    
    const option = select.options[select.selectedIndex];
    const id = parseInt(valor);
    const nombre = option.dataset.nombre;
    
    if (nivelesSeleccionados.some(n => n.id === id)) {
        mostrarMensaje('Este nivel ya ha sido agregado', 'error');
        return;
    }
    
    nivelesSeleccionados.push({ id: id, nombre: nombre });
    renderizarTags();
    select.selectedIndex = 0;
    select.focus();
    actualizarHiddenInput();
}

function eliminarNivel(id) {
    nivelesSeleccionados = nivelesSeleccionados.filter(n => n.id !== id);
    renderizarTags();
    actualizarHiddenInput();
}

function renderizarTags() {
    const container = document.getElementById('niveles_seleccionados');
    container.innerHTML = '';
    
    nivelesSeleccionados.forEach(nivel => {
        const tag = document.createElement('span');
        tag.className = 'nivel-tag';
        tag.innerHTML = `
            <span class="nivel-tag-nombre">${nivel.nombre}</span>
            <button type="button" class="btn-remove-tag" onclick="eliminarNivel(${nivel.id})" title="Eliminar">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(tag);
    });
}

function actualizarHiddenInput() {
    const hidden = document.getElementById('niveles_academicos_hidden');
    const ids = nivelesSeleccionados.map(n => n.id);
    hidden.value = ids.join(',');
}

// ============================================================
// CARGOS - AGREGAR / ELIMINAR
// ============================================================

let cargoCounter = 0;

function agregarCargo() {
    cargoCounter++;
    const container = document.getElementById('cargos-container');
    const primerCargo = container.querySelector('.cargo-item');
    const nuevoCargo = primerCargo.cloneNode(true);
    
    // Actualizar IDs
    nuevoCargo.querySelectorAll('[id]').forEach(el => {
        const id = el.id;
        if (id) {
            const parts = id.split('_');
            if (parts.length > 1) {
                parts[parts.length - 1] = cargoCounter;
                el.id = parts.join('_');
            } else {
                el.id = id + '_' + cargoCounter;
            }
        }
    });
    
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
    
    const detalleZona = nuevoCargo.querySelector('.cargo-detalle-zona-coordinacion');
    detalleZona.style.display = 'none';
    detalleZona.querySelectorAll('select').forEach(sel => {
        sel.selectedIndex = 0;
        sel.removeAttribute('required');
    });
    
    const titularContainer = nuevoCargo.querySelector('.cargo-titular');
    titularContainer.style.display = 'none';
    const titularCheckbox = titularContainer.querySelector('input[type="checkbox"]');
    if (titularCheckbox) titularCheckbox.checked = true;
    
    const btnEliminar = nuevoCargo.querySelector('.btn-remove');
    if (btnEliminar) btnEliminar.style.display = 'flex';
    
    // Actualizar for de labels en directorios
    nuevoCargo.querySelectorAll('.checkbox-directorio label').forEach(label => {
        const forAttr = label.getAttribute('for');
        if (forAttr) {
            const parts = forAttr.split('_');
            if (parts.length > 1) {
                parts[parts.length - 1] = cargoCounter;
                label.setAttribute('for', parts.join('_'));
            } else {
                label.setAttribute('for', forAttr + '_' + cargoCounter);
            }
        }
    });
    
    nuevoCargo.querySelectorAll('.checkbox-directorio input[type="checkbox"]').forEach(input => {
        const id = input.id;
        if (id) {
            const parts = id.split('_');
            if (parts.length > 1) {
                parts[parts.length - 1] = cargoCounter;
                input.id = parts.join('_');
            } else {
                input.id = id + '_' + cargoCounter;
            }
        }
    });
    
    container.appendChild(nuevoCargo);
    
    // Aplicar género actual
    const generoSelect = document.getElementById('genero');
    if (generoSelect) {
        const genero = generoSelect.value;
        const selectNivel = nuevoCargo.querySelector('.select-cargo-nivel');
        const selectCargo = nuevoCargo.querySelector('.select-cargo-nombre');
        if (selectNivel && selectCargo) {
            cargarCargos(selectNivel, selectCargo, nuevoCargo, genero);
        }
    }
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
// CONTACTOS - AGREGAR / ELIMINAR
// ============================================================

function agregarContacto(containerId, tipo) {
    const container = document.getElementById(containerId);
    const primerContacto = container.querySelector('.contacto-item');
    const nuevoContacto = primerContacto.cloneNode(true);
    
    nuevoContacto.querySelectorAll('input[type="text"]').forEach(input => {
        input.value = '';
    });
    nuevoContacto.querySelectorAll('input[type="email"]').forEach(input => {
        input.value = '';
    });
    
    const toggle = nuevoContacto.querySelector('.toggle-modern');
    if (toggle) {
        const checkbox = toggle.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = true;
            checkbox.disabled = false;
        }
    }
    
    const btnEliminar = nuevoContacto.querySelector('.btn-remove');
    if (btnEliminar) btnEliminar.style.display = 'flex';
    
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

// ============================================================
// MENSAJES FLOTANTES
// ============================================================

function mostrarMensaje(mensaje, tipo) {
    const mensajesAnteriores = document.querySelectorAll('.mensaje-flotante');
    mensajesAnteriores.forEach(el => el.remove());
    
    const div = document.createElement('div');
    div.className = `mensaje-flotante ${tipo}`;
    div.style.cssText = `
        position: fixed;
        top: 90px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9998;
        max-width: 600px;
        width: 90%;
        animation: slideDown 0.4s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        background: ${tipo === 'success' ? '#f0f7f0' : '#fdf0f0'};
        color: ${tipo === 'success' ? '#1a5a1a' : '#7a1a1a'};
        border-left: 4px solid ${tipo === 'success' ? '#2e7d32' : '#c62828'};
    `;
    div.innerHTML = `
        <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}" style="font-size:1.25rem; color:${tipo === 'success' ? '#2e7d32' : '#c62828'};"></i>
        <div>
            <strong>${tipo === 'success' ? '¡Éxito!' : '¡Atención!'}</strong> ${mensaje}
        </div>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:${tipo === 'success' ? '#1a5a1a' : '#7a1a1a'};margin-left:auto;">
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
// VALIDACIÓN DE NÚMEROS EN INPUTS
// ============================================================

document.addEventListener('input', function(e) {
    if (e.target.matches('input[pattern="[0-9]*"]') || e.target.matches('input[pattern="[0-9\\s]*"]')) {
        e.target.value = e.target.value.replace(/[^0-9\s]/g, '');
    }
});

// ============================================================
// INICIALIZAR CON GÉNERO POR DEFECTO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const generoSelect = document.getElementById('genero');
    if (generoSelect && generoSelect.value) {
        const event = new Event('change', { bubbles: true });
        generoSelect.dispatchEvent(event);
    }
});
</script>

<?php include 'template/footer.php'; ?>