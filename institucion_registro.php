<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Registrar nueva institución
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

$entidades_federativas = [
    1 => 'Aguascalientes',
    2 => 'Baja California',
    3 => 'Baja California Sur',
    4 => 'Campeche',
    5 => 'Chiapas',
    6 => 'Chihuahua',
    7 => 'Ciudad de México',
    8 => 'Coahuila',
    9 => 'Colima',
    10 => 'Durango',
    11 => 'Estado de México',
    12 => 'Guanajuato',
    13 => 'Guerrero',
    14 => 'Hidalgo',
    15 => 'Jalisco',
    16 => 'Michoacán',
    17 => 'Morelos',
    18 => 'Nayarit',
    19 => 'Nuevo León',
    20 => 'Oaxaca',
    21 => 'Puebla',
    22 => 'Querétaro',
    23 => 'Quintana Roo',
    24 => 'San Luis Potosí',
    25 => 'Sinaloa',
    26 => 'Sonora',
    27 => 'Tabasco',
    28 => 'Tamaulipas',
    29 => 'Tlaxcala',
    30 => 'Veracruz',
    31 => 'Yucatán',
    32 => 'Zacatecas'
];

$zonas_regionales = [
    1 => '1 - Noroeste',
    2 => '2 - Norte',
    3 => '3 - Centro',
    4 => '4 - Centro Occidente',
    5 => '5 - Centro Sur',
    6 => '6 - Sur',
    7 => '7 - Ciudad de México'
];

$tipos_institucion = [
    1 => 'Universidad',
    2 => 'Facultad',
    3 => 'Campus'
];

$tipos_participacion = [
    'afiliada' => 'Afiliada',
    'observadora' => 'Observadora'
];

$sectores = [
    'Publica' => 'Pública',
    'Privada' => 'Privada'
];

// ============================================================
// MAPEO DE ENTIDAD A ZONA
// ============================================================

$zona_por_entidad = [
    1 => 3, 2 => 1, 3 => 1, 4 => 6, 5 => 6, 6 => 1, 7 => 7, 8 => 2,
    9 => 4, 10 => 3, 11 => 5, 12 => 4, 13 => 5, 14 => 5, 15 => 4, 16 => 4,
    17 => 5, 18 => 4, 19 => 2, 20 => 6, 21 => 5, 22 => 3, 23 => 6, 24 => 3,
    25 => 1, 26 => 1, 27 => 6, 28 => 2, 29 => 5, 30 => 6, 31 => 6, 32 => 3
];

// ============================================================
// MAPEO DE CÓDIGO POSTAL A DATOS
// ============================================================

$datos_por_cp = [
    '04510' => ['entidad' => 7, 'municipio' => 'Coyoacán', 'colonia' => 'Ciudad Universitaria', 'zona' => 7],
    '07738' => ['entidad' => 7, 'municipio' => 'Gustavo A. Madero', 'colonia' => 'Zacatenco', 'zona' => 7],
    '09340' => ['entidad' => 7, 'municipio' => 'Iztapalapa', 'colonia' => 'San Rafael Atlixco', 'zona' => 7],
    '44100' => ['entidad' => 15, 'municipio' => 'Guadalajara', 'colonia' => 'Centro', 'zona' => 4],
    '21259' => ['entidad' => 2, 'municipio' => 'Mexicali', 'colonia' => 'Rivera', 'zona' => 1],
    '22424' => ['entidad' => 2, 'municipio' => 'Tijuana', 'colonia' => 'Internacional Tijuana', 'zona' => 1],
    '66450' => ['entidad' => 19, 'municipio' => 'San Nicolás de los Garza', 'colonia' => 'Ciudad Universitaria', 'zona' => 2],
    '42080' => ['entidad' => 14, 'municipio' => 'Pachuca', 'colonia' => 'Ciudad Universitaria', 'zona' => 5],
    '76010' => ['entidad' => 22, 'municipio' => 'Querétaro', 'colonia' => 'Centro', 'zona' => 3],
    '72570' => ['entidad' => 21, 'municipio' => 'Puebla', 'colonia' => 'Ciudad Universitaria', 'zona' => 5],
    '80020' => ['entidad' => 25, 'municipio' => 'Culiacán', 'colonia' => 'Ciudad Universitaria', 'zona' => 1],
    '97160' => ['entidad' => 31, 'municipio' => 'Mérida', 'colonia' => 'Centro', 'zona' => 6],
    '64849' => ['entidad' => 19, 'municipio' => 'Monterrey', 'colonia' => 'Tecnológico', 'zona' => 2],
    '14420' => ['entidad' => 7, 'municipio' => 'Tlalpan', 'colonia' => 'Santa Úrsula Xitla', 'zona' => 7],
    '20100' => ['entidad' => 1, 'municipio' => 'Aguascalientes', 'colonia' => 'Ciudad Universitaria', 'zona' => 3],
    '27010' => ['entidad' => 8, 'municipio' => 'Torreón', 'colonia' => 'Residencial las Haciendas', 'zona' => 2],
    '78290' => ['entidad' => 24, 'municipio' => 'San Luis Potosí', 'colonia' => 'Zona Universitaria', 'zona' => 3],
    '90000' => ['entidad' => 29, 'municipio' => 'Tlaxcala', 'colonia' => 'Col. San José', 'zona' => 5],
    '91000' => ['entidad' => 30, 'municipio' => 'Xalapa', 'colonia' => 'Zona Universitaria', 'zona' => 6],
    '86000' => ['entidad' => 27, 'municipio' => 'Villahermosa', 'colonia' => 'Zona de la Cultura', 'zona' => 6],
    '87000' => ['entidad' => 28, 'municipio' => 'Ciudad Victoria', 'colonia' => 'Ciudad Victoria', 'zona' => 2],
    '31000' => ['entidad' => 6, 'municipio' => 'Chihuahua', 'colonia' => 'Zona Centro', 'zona' => 1],
    '83000' => ['entidad' => 26, 'municipio' => 'Hermosillo', 'colonia' => 'Zona Centro', 'zona' => 1],
    '63000' => ['entidad' => 18, 'municipio' => 'Tepic', 'colonia' => 'Cd. de la Cultura', 'zona' => 4],
    '45010' => ['entidad' => 15, 'municipio' => 'Guadalajara', 'colonia' => 'Camino Real', 'zona' => 4],
    '45030' => ['entidad' => 15, 'municipio' => 'Zapopan', 'colonia' => 'Jardines de Guadalupe', 'zona' => 4],
    '47600' => ['entidad' => 15, 'municipio' => 'Tepatitlán de Morelos', 'colonia' => 'Los Altos', 'zona' => 4],
    '45000' => ['entidad' => 15, 'municipio' => 'Guadalajara', 'colonia' => 'Monraz', 'zona' => 4],
    '25000' => ['entidad' => 8, 'municipio' => 'Saltillo', 'colonia' => 'Ciudad Universitaria', 'zona' => 2],
    '64610' => ['entidad' => 19, 'municipio' => 'San Pedro Garza García', 'colonia' => 'Cumbres', 'zona' => 2],
    '72420' => ['entidad' => 21, 'municipio' => 'Puebla', 'colonia' => 'Cuauhtémoc', 'zona' => 5]
];

// ============================================================
// UNIVERSIDADES EXISTENTES
// ============================================================

$universidades_existentes = [
    1 => 'Universidad Nacional Autónoma de México',
    3 => 'Instituto Politécnico Nacional',
    5 => 'Universidad de Guadalajara',
    7 => 'Universidad Autónoma de Baja California',
    9 => 'Universidad Autónoma de Nuevo León',
    15 => 'Universidad Autónoma de Querétaro',
    16 => 'Universidad Autónoma de Yucatán',
    17 => 'Universidad Autónoma de Sinaloa',
    19 => 'Tecnológico de Monterrey',
    20 => 'Universidad Intercontinental',
    21 => 'Universidad Autónoma de Aguascalientes',
    22 => 'Universidad Iberoamericana Torreón',
    23 => 'Universidad Autónoma de San Luis Potosí',
    24 => 'Universidad Autónoma de Tlaxcala',
    25 => 'Universidad Veracruzana',
    26 => 'Universidad Juárez Autónoma de Tabasco',
    27 => 'Universidad Autónoma de Tamaulipas',
    28 => 'Universidad Tecnológica de Tabasco',
    29 => 'Universidad Autónoma de Chihuahua',
    30 => 'Universidad de Sonora',
    31 => 'Universidad Autónoma de Nayarit',
    32 => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
    33 => 'Universidad Autónoma de Guadalajara',
    34 => 'Centro Universitario de los Altos (UDG)',
    35 => 'Universidad del Valle de Atemajac',
    36 => 'Universidad Autónoma de Coahuila',
    37 => 'Universidad de Monterrey',
    38 => 'Benemérita Universidad Autónoma de Puebla'
];

// ============================================================
// NÚMEROS DE AFILIACIÓN EXISTENTES
// ============================================================

$numeros_afiliacion_existentes = [
    '2601005', '2601007', '2602009', '2603011', '2606012',
    '2601013', '9807033', '9803004', '9802020', '9803007',
    '9805012', '9806001', '9806018', '9802009', '1906067',
    '9801017', '9801020', '9804009', '9804005', '9804007',
    '9804014', '9804019', '9802001', '9802016', '9805002',
    '2607002', '2607004', '2604006', '2601008', '2605010',
    '9807033', '9802008', '9801018', '9806012', '9805011',
    '9805002', '9806023', '9803004', '9804001', '9804009',
    '9804005', '9804019'
];

$numeros_por_zona = [];
foreach ($numeros_afiliacion_existentes as $num) {
    $zona = (int)substr($num, 2, 2);
    if (!isset($numeros_por_zona[$zona])) {
        $numeros_por_zona[$zona] = [];
    }
    $numeros_por_zona[$zona][] = (int)substr($num, 4);
}

$mensaje = '';
$error = '';

// ============================================================
// FUNCIONES
// ============================================================

function generarNumAfiliacion($zona, $existentes_por_zona, $anio) {
    $prefijo = $anio . str_pad($zona, 2, '0', STR_PAD_LEFT);
    $numeros = isset($existentes_por_zona[$zona]) ? $existentes_por_zona[$zona] : [];
    $numero = 1;
    if (!empty($numeros)) {
        $numero = max($numeros) + 1;
    }
    return $prefijo . str_pad($numero, 3, '0', STR_PAD_LEFT);
}

// ============================================================
// PROCESAR FORMULARIO
// ============================================================

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $tipo = (int)($_POST['tipo'] ?? 0);
    if (empty($tipo)) $errores[] = 'Tipo de institución';
    
    $rol_universidad = null;
    $id_universidad_padre = null;
    
    if ($tipo == 1) {
        $rol_universidad = $_POST['rol_universidad'] ?? '';
        if (empty($rol_universidad)) {
            $errores[] = 'Rol de la universidad';
        }
    } elseif ($tipo == 2 || $tipo == 3) {
        $id_universidad_padre = (int)($_POST['universidad_padre'] ?? 0);
        if (empty($id_universidad_padre)) {
            $errores[] = 'Universidad de la que depende';
        }
    }
    
    $sector = $_POST['sector'] ?? '';
    if (empty($sector)) $errores[] = 'Sector';
    
    $nombre = trim($_POST['nombre'] ?? '');
    if (empty($nombre)) $errores[] = 'Nombre de la institución';
    
    $cp = trim($_POST['cp'] ?? '');
    if (empty($cp)) $errores[] = 'Código postal';
    if (empty($_POST['calle'])) $errores[] = 'Calle';
    if (empty($_POST['numero_exterior'])) $errores[] = 'Número exterior';
    if (empty($_POST['colonia'])) $errores[] = 'Colonia';
    if (empty($_POST['municipio'])) $errores[] = 'Alcaldía/Municipio';
    if (empty($_POST['entidad'])) $errores[] = 'Entidad federativa';
    if (empty($_POST['zona'])) $errores[] = 'Zona regional';
    
    $participacion = null;
    $fecha_inicio_participacion = null;
    $num_afiliacion = null;
    
    $requiere_participacion = (
        $tipo == 2 || $tipo == 3 ||
        ($tipo == 1 && $rol_universidad === 'directa')
    );
    
    if ($requiere_participacion) {
        $participacion = $_POST['participacion'] ?? '';
        if (empty($participacion)) $errores[] = 'Tipo de participación';
        
        $fecha_inicio_participacion = $_POST['fecha_inicio_participacion'] ?? '';
        if (empty($fecha_inicio_participacion)) $errores[] = 'Fecha de inicio de participación';
        
        if ($participacion === 'afiliada') {
            $num_afiliacion = trim($_POST['num_afiliacion'] ?? '');
            if (empty($num_afiliacion)) {
                $errores[] = 'Número de afiliación';
            } elseif (!preg_match('/^[0-9]{7}$/', $num_afiliacion)) {
                $errores[] = 'El número de afiliación debe tener 7 dígitos';
            } elseif (in_array($num_afiliacion, $numeros_afiliacion_existentes)) {
                $errores[] = 'El número de afiliación ya está registrado';
            }
        }
    }
    
    $sitios_web = $_POST['sitios_web'] ?? [];
    foreach ($sitios_web as $url) {
        if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            $errores[] = 'URL inválida: ' . htmlspecialchars($url);
            break;
        }
    }
    
    if (empty($errores)) {
        $mensaje = 'Institución registrada exitosamente';
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
                <div>
                    <h1 class="page-title">Registrar Institución</h1>
                    <p class="page-subtitle">Complete los datos para registrar una institución educativa en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="instituciones.php" class="btn-outline-modern">
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
                
                <!-- SECCIÓN 01: TIPO DE INSTITUCIÓN -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">01</span>
                        <h3>Tipo de Institución</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                <?php foreach ($tipos_institucion as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Sector</label>
                            <select name="sector" id="sector" class="form-control" required>
                                <option value="">Seleccionar sector...</option>
                                <?php foreach ($sectores as $key => $nombre): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Rol de Universidad -->
                    <div class="form-group" id="rol_universidad_container" style="display:none; margin-top:1.5rem;">
                        <label class="form-label required">¿Cómo participa esta universidad en ANFECA?</label>
                        <div class="role-selector">
                            <label class="role-option">
                                <input type="radio" name="rol_universidad" value="directa">
                                <div class="role-option-inner">
                                    <span class="role-option-radio"></span>
                                    <div class="role-option-text">
                                        <span class="role-option-title">Tiene su propia afiliación</span>
                                    </div>
                                </div>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="rol_universidad" value="contenedora">
                                <div class="role-option-inner">
                                    <span class="role-option-radio"></span>
                                    <div class="role-option-text">
                                        <span class="role-option-title">Solo agrupa sus facultades</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Universidad padre con autocomplete -->
                    <div class="form-group" id="universidad_padre_container" style="display:none; margin-top:1.5rem;">
                        <label class="form-label required">Universidad de la que depende</label>
                        <div class="autocomplete-container" id="universidad_autocomplete">
                            <div class="autocomplete-input-wrapper">
                                <i class="fas fa-search autocomplete-input-icon"></i>
                                <input type="text" 
                                       class="form-control autocomplete-input" 
                                       id="universidad_buscar" 
                                       placeholder="Escribe el nombre de la universidad..." 
                                       autocomplete="off">
                                <i class="fas fa-check-circle autocomplete-input-check" id="universidad_check_icon"></i>
                            </div>
                            <input type="hidden" 
                                   name="universidad_padre" 
                                   id="universidad_padre" 
                                   value="">
                            <div class="autocomplete-results" id="universidad_resultados"></div>
                        </div>
                        
                        <!-- Banner de selección confirmada -->
                        <div class="selection-confirm" id="universidad_seleccionada">
                            <div class="selection-confirm-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="selection-confirm-content">
                                <span class="selection-confirm-label">Universidad seleccionada</span>
                                <span class="selection-confirm-name" id="universidad_seleccionada_nombre"></span>
                            </div>
                            <button type="button" class="selection-confirm-change" onclick="cambiarUniversidad()">
                                Cambiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 02: DATOS GENERALES -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">02</span>
                        <h3>Datos Generales</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Nombre de la Institución</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" 
                                   placeholder="Ej. Facultad de Contaduría y Administración" required>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Sitios Web</label>
                            <div id="sitios_web_container">
                                <div class="sitio-web-item">
                                    <div class="sitio-web-input-group">
                                        <input type="url" name="sitios_web[]" class="form-control" placeholder="https://www.ejemplo.com">
                                        <button type="button" class="btn-remove-sitio" onclick="eliminarSitioWeb(this)" style="display:none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-add-sitio" onclick="agregarSitioWeb()">
                                <i class="fas fa-plus-circle"></i> Agregar otro sitio web
                            </button>
                            <small class="form-hint">Opcional</small>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 03: DIRECCIÓN -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">03</span>
                        <h3>Dirección</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Código Postal</label>
                            <input type="text" name="cp" id="cp" class="form-control cp-input" 
                                   placeholder="Ej. 04510" pattern="[0-9]{5}" maxlength="5" 
                                   inputmode="numeric" required>
                            <small class="form-hint">Autocompleta los siguientes campos</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Entidad</label>
                            <select name="entidad" id="entidad" class="form-control" required>
                                <option value="">Seleccionar entidad...</option>
                                <?php foreach ($entidades_federativas as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Alcaldía / Municipio</label>
                            <input type="text" name="municipio" id="municipio" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Colonia</label>
                            <input type="text" name="colonia" id="colonia" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Zona Regional</label>
                            <select name="zona" id="zona" class="form-control" required>
                                <option value="">Seleccionar zona...</option>
                                <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Puede modificarla si la institución lo requiere</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Calle</label>
                            <input type="text" name="calle" class="form-control" 
                                   placeholder="Ej. Calzada Universidad" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Número Exterior</label>
                            <input type="text" name="numero_exterior" class="form-control" 
                                   placeholder="Ej. 14418" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Número Interior</label>
                            <input type="text" name="numero_interior" class="form-control" 
                                   placeholder="Ej. A-102">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 04: PARTICIPACIÓN INICIAL -->
                <div class="form-section" id="participacion_section" style="display:none;">
                    <div class="section-header">
                        <span class="section-number">04</span>
                        <h3>Participación Inicial</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Tipo de Participación</label>
                            <select name="participacion" id="participacion" class="form-control">
                                <option value="">Seleccionar tipo...</option>
                                <?php foreach ($tipos_participacion as $key => $nombre): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Las Observadoras pueden pasar a Afiliadas después de un año</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio_participacion" id="fecha_inicio_participacion" 
                                   class="form-control">
                            <small class="form-hint">Cuándo comienza a estar activa</small>
                        </div>

                        <div class="form-group" id="num_afiliacion_container" style="display:none;">
                            <label class="form-label required">Número de Afiliación</label>
                            <input type="text" name="num_afiliacion" id="num_afiliacion_input" 
                                   class="form-control afiliacion-input" 
                                   placeholder="Se genera automáticamente"
                                   pattern="[0-9]{7}" maxlength="7" autocomplete="off">
                            <small class="form-hint" id="num_afiliacion_hint">Formato: Año(2) + Zona(2) + Consecutivo(3)</small>
                            <small class="form-hint" id="num_afiliacion_status" style="display:none;"></small>
                        </div>
                    </div>
                </div>

                <!-- Aviso contenedora -->
                <div class="form-section" id="aviso_contenedora" style="display:none; padding-bottom:0; border-bottom:none;">
                    <div class="info-banner">
                        <div class="info-banner-icon">
                            <i class="fas fa-info"></i>
                        </div>
                        <div class="info-banner-content">
                            <strong>Sin número de afiliación propio</strong>
                            <p>Una vez guardada, podrás agregar sus facultades y campus desde un formulario nuevo en el listado de instituciones.</p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Guardar Institución
                    </button>
                    <button type="reset" class="btn-outline-modern">
                        <i class="fas fa-undo"></i> Limpiar
                    </button>
                    <a href="instituciones.php" class="btn-outline-modern">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - REGISTRO INSTITUCIÓN
   ============================================================ */

/* ---------- Page Header ---------- */

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

/* ---------- Botones ---------- */

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

/* ---------- Alertas ---------- */

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

/* ---------- Formulario ---------- */

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

/* ---------- Selector de Rol ---------- */

.role-selector {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    margin-top: 0.5rem;
}

.role-option {
    position: relative;
    cursor: pointer;
    display: block;
}

.role-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.role-option-inner {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 1rem 1.15rem;
    background: white;
    border: 2px solid #e8e8e8;
    border-radius: 12px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.role-option:hover .role-option-inner {
    border-color: #8B0000;
    background: #fafafa;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

.role-option input[type="radio"]:checked + .role-option-inner {
    background: linear-gradient(135deg, #fdf5f5, #faf0ef);
    border-color: #8B0000;
    box-shadow: 0 4px 16px rgba(139, 0, 0, 0.12);
}

.role-option input[type="radio"]:focus-visible + .role-option-inner {
    outline: 3px solid rgba(139, 0, 0, 0.15);
    outline-offset: 2px;
}

.role-option-radio {
    width: 22px;
    height: 22px;
    min-width: 22px;
    border: 2px solid #d4c5c4;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
}

.role-option-radio::after {
    content: '';
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #8B0000;
    transform: scale(0);
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.role-option:hover .role-option-radio {
    border-color: #8B0000;
}

.role-option input[type="radio"]:checked + .role-option-inner .role-option-radio {
    border-color: #8B0000;
    background: white;
}

.role-option input[type="radio"]:checked + .role-option-inner .role-option-radio::after {
    transform: scale(1);
}

.role-option-text {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    flex: 1;
    min-width: 0;
}

.role-option-title {
    font-weight: 600;
    font-size: 0.95rem;
    color: #1a1a1a;
    line-height: 1.3;
}

/* ---------- Autocomplete Universidad ---------- */

.autocomplete-container {
    position: relative;
}

.autocomplete-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.autocomplete-input {
    width: 100%;
    padding-left: 2.75rem !important;
    padding-right: 2.75rem !important;
}

.autocomplete-input-icon {
    position: absolute;
    left: 1rem;
    color: #999;
    font-size: 0.9rem;
    pointer-events: none;
    transition: color 0.2s ease;
}

.autocomplete-input-check {
    position: absolute;
    right: 1rem;
    color: #2e7d32;
    font-size: 1rem;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    pointer-events: none;
}

.autocomplete-input-wrapper.has-selection .autocomplete-input-check {
    opacity: 1;
    transform: scale(1);
}

.autocomplete-input-wrapper.has-selection .autocomplete-input-icon {
    color: #2e7d32;
}

.autocomplete-input.autocomplete-selected {
    border-color: #2e7d32;
    background: #f7fdf7;
}

.autocomplete-input.autocomplete-selected:focus {
    border-color: #2e7d32;
    box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
}

.autocomplete-results {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: white;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    max-height: 260px;
    overflow-y: auto;
    z-index: 100;
    display: none;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
}

.autocomplete-results.show {
    display: block;
}

.autocomplete-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: #1a1a1a;
    border-bottom: 1px solid #f5f0f0;
    transition: background 0.15s ease;
}

.autocomplete-item:last-child {
    border-bottom: none;
}

.autocomplete-item:hover,
.autocomplete-item.highlighted {
    background: #f5edec;
    color: #8B0000;
}

.autocomplete-item .match {
    font-weight: 700;
    color: #8B0000;
}

.autocomplete-item:hover .match,
.autocomplete-item.highlighted .match {
    color: #5C0000;
}

.autocomplete-empty {
    padding: 1.25rem;
    text-align: center;
    color: #999;
    font-size: 0.85rem;
}

/* ---------- Banner de selección confirmada ---------- */

.selection-confirm {
    display: none;
    align-items: center;
    gap: 0.9rem;
    padding: 0.9rem 1.15rem;
    margin-top: 0.6rem;
    background: linear-gradient(135deg, #f0f9f0, #e8f5e9);
    border: 1.5px solid #a5d6a7;
    border-radius: 12px;
    animation: slideInSelection 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.selection-confirm.show {
    display: flex;
}

@keyframes slideInSelection {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.selection-confirm-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    background: #2e7d32;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    box-shadow: 0 3px 10px rgba(46, 125, 50, 0.25);
    flex-shrink: 0;
}

.selection-confirm-content {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    flex: 1;
    min-width: 0;
}

.selection-confirm-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #2e7d32;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.selection-confirm-name {
    font-size: 0.92rem;
    font-weight: 600;
    color: #1a1a1a;
    line-height: 1.3;
    word-break: break-word;
}

.selection-confirm-change {
    padding: 0.45rem 0.95rem;
    background: white;
    color: #2e7d32;
    border: 1.5px solid #a5d6a7;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    flex-shrink: 0;
}

.selection-confirm-change:hover {
    background: #2e7d32;
    border-color: #2e7d32;
    color: white;
}

/* ---------- Info Banner (aviso contenedora) ---------- */

.info-banner {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 0.75rem;
    padding: 1.75rem 1.5rem;
    background: linear-gradient(135deg, #faf8f8, #f5f0f0);
    border-radius: 14px;
    border: 1px solid #f0ecec;
    animation: slideInBanner 0.35s ease;
}

@keyframes slideInBanner {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.info-banner-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #8B0000;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
}

.info-banner-content {
    max-width: 520px;
}

.info-banner-content strong {
    display: block;
    color: #1a1a1a;
    font-size: 0.95rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.info-banner-content p {
    color: #6b6b6b;
    font-size: 0.88rem;
    margin: 0;
    line-height: 1.55;
}

/* ---------- Form Groups ---------- */

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

.form-hint.error { color: #c62828; }
.form-hint.success { color: #2e7d32; }

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

/* ---------- Sitios Web ---------- */

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

/* ---------- Form Actions ---------- */

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #f5f0f0;
    flex-wrap: wrap;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 992px) {
    .form-grid { grid-template-columns: repeat(2, 1fr); }
    .form-group[style*="span 2"] { grid-column: span 2 !important; }
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

    .form-group[style*="span 2"] {
        grid-column: span 1 !important;
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

    .selection-confirm {
        flex-wrap: wrap;
        padding: 0.8rem 1rem;
    }

    .selection-confirm-change {
        width: 100%;
        margin-top: 0.3rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.2rem;
    }

    .form-container {
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

    .role-option-inner {
        padding: 0.9rem 1rem;
    }

    .role-option-radio {
        width: 20px;
        height: 20px;
        min-width: 20px;
    }

    .role-option-radio::after {
        width: 9px;
        height: 9px;
    }

    .role-option-title {
        font-size: 0.9rem;
    }

    .autocomplete-results {
        max-height: 200px;
    }

    .selection-confirm {
        flex-wrap: wrap;
        padding: 0.8rem 1rem;
    }

    .selection-confirm-change {
        width: 100%;
        margin-top: 0.3rem;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const datosPorCP = <?= json_encode($datos_por_cp) ?>;
const zonaPorEntidad = <?= json_encode($zona_por_entidad) ?>;
const numerosPorZona = <?= json_encode($numeros_por_zona) ?>;
const numerosExistentes = <?= json_encode($numeros_afiliacion_existentes) ?>;
const universidadesData = <?= json_encode($universidades_existentes) ?>;

// ============================================================
// AUTOCOMPLETE DE UNIVERSIDAD
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('universidad_buscar');
    const hidden = document.getElementById('universidad_padre');
    const results = document.getElementById('universidad_resultados');
    const inputWrapper = document.querySelector('.autocomplete-input-wrapper');
    const banner = document.getElementById('universidad_seleccionada');
    const bannerNombre = document.getElementById('universidad_seleccionada_nombre');
    
    if (!input || !hidden || !results) return;
    
    const universidades = Object.entries(universidadesData).map(([id, nombre]) => ({
        id: parseInt(id),
        nombre: nombre
    }));
    
    let highlightedIndex = -1;
    let currentFiltered = [];
    
    function normalize(str) {
        return str.toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '');
    }
    
    function renderResults(filtered, query) {
        if (filtered.length === 0) {
            results.innerHTML = '<div class="autocomplete-empty">No se encontraron universidades</div>';
            results.classList.add('show');
            return;
        }
        
        const normalizedQuery = normalize(query);
        
        results.innerHTML = filtered.map((u, idx) => {
            const normalizedNombre = normalize(u.nombre);
            const matchIndex = normalizedNombre.indexOf(normalizedQuery);
            
            let display = u.nombre;
            if (matchIndex !== -1 && normalizedQuery.length > 0) {
                const before = u.nombre.substring(0, matchIndex);
                const match = u.nombre.substring(matchIndex, matchIndex + normalizedQuery.length);
                const after = u.nombre.substring(matchIndex + normalizedQuery.length);
                display = `${before}<span class="match">${match}</span>${after}`;
            }
            
            return `<div class="autocomplete-item ${idx === highlightedIndex ? 'highlighted' : ''}" 
                         data-id="${u.id}" 
                         data-nombre="${u.nombre.replace(/"/g, '&quot;')}">
                        ${display}
                    </div>`;
        }).join('');
        
        results.classList.add('show');
        
        results.querySelectorAll('.autocomplete-item').forEach(item => {
            item.addEventListener('click', function() {
                seleccionar(this.dataset.id, this.dataset.nombre);
            });
        });
    }
    
    function seleccionar(id, nombre) {
        hidden.value = id;
        input.value = nombre;
        results.classList.remove('show');
        input.classList.add('autocomplete-selected');
        inputWrapper.classList.add('has-selection');
        
        // Mostrar banner de confirmación
        bannerNombre.textContent = nombre;
        banner.classList.add('show');
    }
    
    window.cambiarUniversidad = function() {
        hidden.value = '';
        input.value = '';
        input.classList.remove('autocomplete-selected');
        inputWrapper.classList.remove('has-selection');
        banner.classList.remove('show');
        input.focus();
    };
    
    function buscar(query) {
        if (!query || query.trim().length === 0) {
            results.classList.remove('show');
            currentFiltered = [];
            return;
        }
        
        const normalizedQuery = normalize(query.trim());
        currentFiltered = universidades.filter(u => 
            normalize(u.nombre).includes(normalizedQuery)
        );
        
        currentFiltered = currentFiltered.slice(0, 30);
        highlightedIndex = -1;
        renderResults(currentFiltered, query);
    }
    
    input.addEventListener('input', function() {
        // Si el usuario edita, limpiar la selección y el banner
        if (hidden.value && input.value !== universidadesData[hidden.value]) {
            hidden.value = '';
            input.classList.remove('autocomplete-selected');
            inputWrapper.classList.remove('has-selection');
            banner.classList.remove('show');
        }
        buscar(this.value);
    });
    
    input.addEventListener('focus', function() {
        if (this.value.trim().length > 0) {
            buscar(this.value);
        }
    });
    
    input.addEventListener('keydown', function(e) {
        const items = results.querySelectorAll('.autocomplete-item');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (items.length === 0) return;
            highlightedIndex = Math.min(highlightedIndex + 1, items.length - 1);
            updateHighlight(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (items.length === 0) return;
            highlightedIndex = Math.max(highlightedIndex - 1, 0);
            updateHighlight(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (highlightedIndex >= 0 && items[highlightedIndex]) {
                const item = items[highlightedIndex];
                seleccionar(item.dataset.id, item.dataset.nombre);
            }
        } else if (e.key === 'Escape') {
            results.classList.remove('show');
        }
    });
    
    function updateHighlight(items) {
        items.forEach((item, idx) => {
            item.classList.toggle('highlighted', idx === highlightedIndex);
        });
        if (items[highlightedIndex]) {
            items[highlightedIndex].scrollIntoView({ block: 'nearest' });
        }
    }
    
    // Cerrar al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#universidad_autocomplete')) {
            results.classList.remove('show');
        }
    });
});

// ============================================================
// VALIDAR AUTOCOMPLETE AL ENVIAR
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRegistro');
    const tipoSelect = document.getElementById('tipo');
    const hiddenUniversidad = document.getElementById('universidad_padre');
    const inputUniversidad = document.getElementById('universidad_buscar');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const tipo = parseInt(tipoSelect.value);
            
            if (tipo === 2 || tipo === 3) {
                if (!hiddenUniversidad.value) {
                    e.preventDefault();
                    alert('Debe seleccionar una universidad de la lista de sugerencias.');
                    inputUniversidad.focus();
                }
            }
        });
        
        // Reset del formulario: limpiar también el autocomplete
        form.addEventListener('reset', function() {
            setTimeout(function() {
                const inputWrapper = document.querySelector('.autocomplete-input-wrapper');
                if (inputWrapper) inputWrapper.classList.remove('has-selection');
                const banner = document.getElementById('universidad_seleccionada');
                if (banner) banner.classList.remove('show');
                const input = document.getElementById('universidad_buscar');
                if (input) input.classList.remove('autocomplete-selected');
            }, 10);
        });
    }
});

// ============================================================
// CÓDIGO POSTAL → AUTOCOMPLETAR
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const cpInput = document.getElementById('cp');
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
            if (datos.zona) {
                zonaSelect.value = datos.zona;
                actualizarNumeroAfiliacion();
            }
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
    
    if (cpInput) {
        cpInput.addEventListener('blur', cargarDatosPorCP);
        cpInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') { e.preventDefault(); cargarDatosPorCP(); }
        });
    }
    
    if (entidadSelect) {
        entidadSelect.addEventListener('change', function() {
            const entidadId = parseInt(this.value);
            if (entidadId && zonaPorEntidad[entidadId]) {
                zonaSelect.value = zonaPorEntidad[entidadId];
                actualizarNumeroAfiliacion();
            }
        });
    }
    
    if (zonaSelect) zonaSelect.addEventListener('change', actualizarNumeroAfiliacion);
});

// ============================================================
// TIPO → MOSTRAR CAMPOS CONDICIONALES
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const rolContainer = document.getElementById('rol_universidad_container');
    const universidadPadreContainer = document.getElementById('universidad_padre_container');
    const participacionSection = document.getElementById('participacion_section');
    const avisoContenedora = document.getElementById('aviso_contenedora');
    const participacionSelect = document.getElementById('participacion');
    const fechaInicio = document.getElementById('fecha_inicio_participacion');
    
    function actualizarEstado() {
        const tipo = parseInt(tipoSelect.value);
        const rolSeleccionado = document.querySelector('input[name="rol_universidad"]:checked');
        const rol = rolSeleccionado ? rolSeleccionado.value : '';
        
        rolContainer.style.display = 'none';
        universidadPadreContainer.style.display = 'none';
        participacionSection.style.display = 'none';
        avisoContenedora.style.display = 'none';
        
        if (participacionSelect) participacionSelect.removeAttribute('required');
        if (fechaInicio) fechaInicio.removeAttribute('required');
        
        if (tipo === 1) {
            rolContainer.style.display = 'block';
            if (rol === 'contenedora') {
                avisoContenedora.style.display = 'block';
            } else if (rol === 'directa') {
                participacionSection.style.display = 'block';
                if (participacionSelect) participacionSelect.setAttribute('required', 'required');
                if (fechaInicio) fechaInicio.setAttribute('required', 'required');
            }
        } else if (tipo === 2 || tipo === 3) {
            universidadPadreContainer.style.display = 'flex';
            participacionSection.style.display = 'block';
            if (participacionSelect) participacionSelect.setAttribute('required', 'required');
            if (fechaInicio) fechaInicio.setAttribute('required', 'required');
        }
    }
    
    if (tipoSelect) tipoSelect.addEventListener('change', actualizarEstado);
    
    document.querySelectorAll('input[name="rol_universidad"]').forEach(function(radio) {
        radio.addEventListener('change', actualizarEstado);
    });
});

// ============================================================
// PARTICIPACIÓN → MOSTRAR NÚMERO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const participacionSelect = document.getElementById('participacion');
    const numAfiliacionContainer = document.getElementById('num_afiliacion_container');
    const numAfiliacionInput = document.getElementById('num_afiliacion_input');
    
    if (participacionSelect) {
        participacionSelect.addEventListener('change', function() {
            if (this.value === 'afiliada') {
                numAfiliacionContainer.style.display = 'flex';
                if (numAfiliacionInput) numAfiliacionInput.setAttribute('required', 'required');
                actualizarNumeroAfiliacion();
            } else {
                numAfiliacionContainer.style.display = 'none';
                if (numAfiliacionInput) {
                    numAfiliacionInput.removeAttribute('required');
                    numAfiliacionInput.value = '';
                }
                actualizarStatusNumeroAfiliacion();
            }
        });
    }
});

// ============================================================
// GENERAR NÚMERO DE AFILIACIÓN
// ============================================================

function generarNumeroAfiliacion(zona, anio) {
    const zonaStr = String(zona).padStart(2, '0');
    const prefijo = anio + zonaStr;
    
    let numeros = [];
    numerosExistentes.forEach(function(num) {
        if (num.substring(0, 4) === prefijo) {
            const n = parseInt(num.substring(4));
            if (!numeros.includes(n)) numeros.push(n);
        }
    });
    
    if (numerosPorZona[zona]) {
        numerosPorZona[zona].forEach(function(n) {
            if (!numeros.includes(n)) numeros.push(n);
        });
    }
    
    let consecutivo = 1;
    if (numeros.length > 0) consecutivo = Math.max(...numeros) + 1;
    
    return prefijo + String(consecutivo).padStart(3, '0');
}

function actualizarNumeroAfiliacion() {
    const zonaSelect = document.getElementById('zona');
    const fechaInicio = document.getElementById('fecha_inicio_participacion');
    const numInput = document.getElementById('num_afiliacion_input');
    const participacionSelect = document.getElementById('participacion');
    
    if (!numInput || !participacionSelect || participacionSelect.value !== 'afiliada') return;
    
    const zona = parseInt(zonaSelect.value);
    let anio = new Date().getFullYear().toString().slice(-2);
    if (fechaInicio && fechaInicio.value) {
        const fecha = new Date(fechaInicio.value);
        if (!isNaN(fecha.getTime())) anio = fecha.getFullYear().toString().slice(-2);
    }
    
    if (zona > 0 && anio) {
        const nuevoNumero = generarNumeroAfiliacion(zona, anio);
        if (!numInput.value || !numInput.dataset.editado) {
            numInput.value = nuevoNumero;
        }
        actualizarStatusNumeroAfiliacion();
    }
}

// ============================================================
// VALIDAR NÚMERO
// ============================================================

function validarNumeroAfiliacion(numero) {
    if (!numero || numero.length === 0) return { valido: false, mensaje: '', clase: '' };
    if (!/^[0-9]{7}$/.test(numero)) return { valido: false, mensaje: 'Formato inválido. Use 7 dígitos', clase: 'error' };
    if (numerosExistentes.includes(numero)) return { valido: false, mensaje: 'Este número ya está registrado', clase: 'error' };
    
    const zona = parseInt(numero.substring(2, 4));
    if (isNaN(zona) || zona < 1 || zona > 7) return { valido: false, mensaje: 'Zona inválida', clase: 'error' };
    
    const anio = parseInt(numero.substring(0, 2));
    const anioActual = parseInt(new Date().getFullYear().toString().slice(-2));
    if (anio > anioActual + 1) return { valido: false, mensaje: 'Año futuro', clase: 'error' };
    
    return { valido: true, mensaje: 'Número disponible', clase: 'success' };
}

function actualizarStatusNumeroAfiliacion() {
    const input = document.getElementById('num_afiliacion_input');
    const status = document.getElementById('num_afiliacion_status');
    if (!input || !status) return;
    
    const numero = input.value.trim();
    if (!numero) { status.style.display = 'none'; return; }
    
    const resultado = validarNumeroAfiliacion(numero);
    status.style.display = 'block';
    status.textContent = resultado.mensaje;
    status.className = 'form-hint ' + (resultado.clase || '');
    
    if (resultado.clase === 'error') input.style.borderColor = '#c62828';
    else if (resultado.clase === 'success') input.style.borderColor = '#2e7d32';
    else input.style.borderColor = '';
}

document.addEventListener('DOMContentLoaded', function() {
    const numInput = document.getElementById('num_afiliacion_input');
    if (numInput) {
        numInput.addEventListener('input', function() {
            this.dataset.editado = 'true';
            actualizarStatusNumeroAfiliacion();
        });
        numInput.addEventListener('blur', actualizarStatusNumeroAfiliacion);
    }
    
    const fechaInicio = document.getElementById('fecha_inicio_participacion');
    if (fechaInicio) {
        fechaInicio.addEventListener('change', function() {
            const numInput = document.getElementById('num_afiliacion_input');
            if (numInput) delete numInput.dataset.editado;
            actualizarNumeroAfiliacion();
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