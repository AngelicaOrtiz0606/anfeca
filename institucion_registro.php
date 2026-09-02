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

// Mapeo de entidad a zona
$zona_por_entidad = [
    1 => 3,  // Aguascalientes → Centro
    2 => 1,  // Baja California → Noroeste
    3 => 1,  // Baja California Sur → Noroeste
    4 => 6,  // Campeche → Sur
    5 => 6,  // Chiapas → Sur
    6 => 1,  // Chihuahua → Noroeste
    7 => 7,  // Ciudad de México → Ciudad de México
    8 => 2,  // Coahuila → Norte
    9 => 4,  // Colima → Centro Occidente
    10 => 3, // Durango → Centro
    11 => 5, // Estado de México → Centro Sur
    12 => 4, // Guanajuato → Centro Occidente
    13 => 5, // Guerrero → Centro Sur
    14 => 5, // Hidalgo → Centro Sur
    15 => 4, // Jalisco → Centro Occidente
    16 => 4, // Michoacán → Centro Occidente
    17 => 5, // Morelos → Centro Sur
    18 => 4, // Nayarit → Centro Occidente
    19 => 2, // Nuevo León → Norte
    20 => 6, // Oaxaca → Sur
    21 => 5, // Puebla → Centro Sur
    22 => 3, // Querétaro → Centro
    23 => 6, // Quintana Roo → Sur
    24 => 3, // San Luis Potosí → Centro
    25 => 1, // Sinaloa → Noroeste
    26 => 1, // Sonora → Noroeste
    27 => 6, // Tabasco → Sur
    28 => 2, // Tamaulipas → Norte
    29 => 5, // Tlaxcala → Centro Sur
    30 => 6, // Veracruz → Sur
    31 => 6, // Yucatán → Sur
    32 => 3  // Zacatecas → Centro
];

// Mapeo de código postal a datos
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
    '97160' => ['entidad' => 31, 'municipio' => 'Mérida', 'colonia' => 'Centro', 'zona' => 6]
];

// Universidades existentes
$universidades = [
    1 => 'Universidad Nacional Autónoma de México',
    2 => 'Instituto Politécnico Nacional',
    3 => 'Universidad de Guadalajara',
    4 => 'Universidad Autónoma Metropolitana',
    5 => 'Universidad Autónoma de Baja California',
    6 => 'Universidad de Sonora',
    7 => 'Universidad Autónoma de Nuevo León',
    8 => 'Universidad Autónoma de Querétaro',
    9 => 'Universidad Autónoma de Yucatán',
    10 => 'Universidad Veracruzana'
];

// Instituciones existentes para validar número de afiliación único
$instituciones_existentes = [
    '2601001', '2601002', '2601003', '2601004', '2601005',
    '2601006', '2601007', '2601008', '2601009', '2601010',
    '2607002', '2607004', '2604006', '2601008'
];

// Estructura para almacenar números por zona
$numeros_por_zona = [];
foreach ($instituciones_existentes as $num) {
    $zona = (int)substr($num, 2, 2);
    if (!isset($numeros_por_zona[$zona])) {
        $numeros_por_zona[$zona] = [];
    }
    $numeros_por_zona[$zona][] = (int)substr($num, 4);
}

$mensaje = '';
$error = '';

// Función para generar número de afiliación
function generarNumAfiliacion($zona, $existentes_por_zona) {
    $anio = date('y');
    $prefijo = $anio . str_pad($zona, 2, '0', STR_PAD_LEFT);
    
    $numeros = isset($existentes_por_zona[$zona]) ? $existentes_por_zona[$zona] : [];
    $numero = 1;
    
    if (!empty($numeros)) {
        $numero = max($numeros) + 1;
    }
    
    return $prefijo . str_pad($numero, 3, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    if (empty($_POST['nombre'])) $errores[] = 'Nombre de la institución';
    if (empty($_POST['tipo'])) $errores[] = 'Tipo de institución';
    if (empty($_POST['participacion'])) $errores[] = 'Tipo de participación';
    if (empty($_POST['fecha_inicio'])) $errores[] = 'Fecha de inicio';
    if (empty($_POST['cp'])) $errores[] = 'Código postal';
    if (empty($_POST['calle'])) $errores[] = 'Calle';
    if (empty($_POST['numero_exterior'])) $errores[] = 'Número exterior';
    if (empty($_POST['colonia'])) $errores[] = 'Colonia';
    if (empty($_POST['municipio'])) $errores[] = 'Alcaldía/Municipio';
    if (empty($_POST['entidad'])) $errores[] = 'Entidad federativa';
    if (empty($_POST['zona'])) $errores[] = 'Zona regional';
    
    // Validar número de afiliación
    $tipo = (int)$_POST['tipo'];
    $num_afiliacion = trim($_POST['num_afiliacion']);
    $tiene_num_propio = isset($_POST['tiene_num_propio']) ? $_POST['tiene_num_propio'] : '0';
    
    if ($tipo == 1 && $tiene_num_propio == '1') {
        // Universidad con número propio → obligatorio
        if (empty($num_afiliacion)) {
            $errores[] = 'Número de afiliación';
        } elseif (in_array($num_afiliacion, $instituciones_existentes) && $_POST['id'] != $num_afiliacion) {
            $errores[] = 'Número de afiliación ya existe';
        }
    } elseif ($tipo == 2 || $tipo == 3) {
        // Facultad o Campus → obligatorio
        if (empty($num_afiliacion)) {
            $errores[] = 'Número de afiliación';
        } elseif (in_array($num_afiliacion, $instituciones_existentes) && $_POST['id'] != $num_afiliacion) {
            $errores[] = 'Número de afiliación ya existe';
        }
    }
    // Universidad sin número propio → no se valida
    
    // Validar dependencia si es Facultad o Campus
    if ($tipo == 2 || $tipo == 3) {
        if (empty($_POST['universidad'])) {
            $errores[] = 'Universidad a la que pertenece';
        }
    }
    
    // Validar sitios web (opcionales)
    if (!empty($_POST['sitios_web'])) {
        foreach ($_POST['sitios_web'] as $url) {
            if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
                $errores[] = 'URL inválida: ' . htmlspecialchars($url);
                break;
            }
        }
    }
    
    if (!empty($errores)) {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    } else {
        $mensaje = 'Institución registrada exitosamente';
        if (!empty($num_afiliacion) && ($tipo == 2 || $tipo == 3 || ($tipo == 1 && $tiene_num_propio == '1'))) {
            $instituciones_existentes[] = $num_afiliacion;
            $zona = (int)substr($num_afiliacion, 2, 2);
            if (!isset($numeros_por_zona[$zona])) {
                $numeros_por_zona[$zona] = [];
            }
            $numeros_por_zona[$zona][] = (int)substr($num_afiliacion, 4);
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
                <div class="page-header-icon">
                    <i class="fas fa-university"></i>
                </div>
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
                
                <!-- SECCIÓN 1: DATOS GENERALES -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">01</span>
                        <h3>Datos Generales</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Nombre de la Institución</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej. Universidad Nacional Autónoma de México" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Tipo de Institución</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                <?php foreach ($tipos_institucion as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group" id="universidad_container" style="display:none;">
                            <label class="form-label required">Universidad</label>
                            <select name="universidad" id="universidad" class="form-control">
                                <option value="">Seleccionar universidad...</option>
                                <?php foreach ($universidades as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Seleccione la universidad a la que pertenece</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Participación</label>
                            <select name="participacion" id="participacion" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($tipos_participacion as $key => $nombre): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tiene número de afiliación propio (solo para Universidades) -->
                        <div class="form-group" id="tiene_num_propio_container" style="display:none;">
                            <div class="checkbox-tiene-num">
                                <input type="checkbox" name="tiene_num_propio" id="tiene_num_propio" value="1">
                                <label for="tiene_num_propio">Tiene número de afiliación propio</label>
                            </div>
                        </div>

                        <!-- Número de afiliación -->
                        <div class="form-group" id="num_afiliacion_container">
                            <label class="form-label" id="num_afiliacion_label">Número de Afiliación <span id="num_afiliacion_required" style="color:#c62828; display:none;">*</span></label>
                            <div class="afiliacion-display">
                                <span class="afiliacion-value" id="num_afiliacion_mostrado">- - - - - - -</span>
                            </div>
                            <input type="hidden" name="num_afiliacion" id="num_afiliacion" value="">
                            <small class="form-hint" id="num_afiliacion_hint">Se genera con el año, zona y consecutivo</small>
                        </div>

                        <!-- Sitios Web -->
                        <div class="form-group">
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

                <!-- SECCIÓN 2: DIRECCIÓN -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">02</span>
                        <h3>Dirección</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Código Postal</label>
                            <input type="text" name="cp" id="cp" class="form-control cp-input" placeholder="Ej. 04510" pattern="[0-9]{5}" inputmode="numeric" required>
                            <small class="form-hint">Ejemplos: 04510 (UNAM), 07738 (IPN), 09340 (UAM)</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Entidad</label>
                            <select name="entidad" id="entidad" class="form-control" required>
                                <option value="">Seleccionar entidad...</option>
                                <?php foreach ($entidades_federativas as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Se carga automáticamente con el código postal</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Alcaldía / Municipio</label>
                            <select name="municipio" id="municipio" class="form-control" required>
                                <option value="">Seleccionar alcaldía/municipio...</option>
                            </select>
                            <small class="form-hint">Se carga automáticamente con el código postal</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Colonia</label>
                            <select name="colonia" id="colonia" class="form-control" required>
                                <option value="">Seleccionar colonia...</option>
                            </select>
                            <small class="form-hint">Se carga automáticamente con el código postal</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Zona</label>
                            <select name="zona" id="zona" class="form-control" required>
                                <option value="">Seleccionar zona...</option>
                                <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Se carga con el código postal, puede modificarse</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Calle</label>
                            <input type="text" name="calle" class="form-control" placeholder="Ej. Calzada Universidad" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Número Exterior</label>
                            <input type="text" name="numero_exterior" class="form-control" placeholder="Ej. 14418" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Número Interior</label>
                            <input type="text" name="numero_interior" class="form-control" placeholder="Ej. A-102">
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN 3: VIGENCIA -->
                <div class="form-section">
                    <div class="section-header">
                        <span class="section-number">03</span>
                        <h3>Vigencia</h3>
                        <span class="section-line"></span>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                            <small class="form-hint">Dejar vacío si está vigente</small>
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
   ESTILOS MODERNOS - REGISTRO INSTITUCIÓN
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
    font-size: 1.1rem;
    letter-spacing: 2px;
}

/* Checkbox "Tiene número propio" */
.checkbox-tiene-num {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.6rem;
    background: #faf8f8;
    border-radius: 8px;
    border: 1px solid #f0ecec;
    cursor: pointer;
    transition: all 0.2s ease;
}

.checkbox-tiene-num:hover {
    background: #f5edec;
    border-color: #d4c5c4;
}

.checkbox-tiene-num input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #8B0000;
    cursor: pointer;
}

.checkbox-tiene-num label {
    font-size: 0.85rem;
    color: #4a4a4a;
    cursor: pointer;
    margin: 0;
    font-weight: 500;
}

/* Sitios Web */
.sitio-web-item {
    margin-bottom: 0.5rem;
}

.sitio-web-input-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.sitio-web-input-group .form-control {
    flex: 1;
}

.btn-remove-sitio {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
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
    padding: 0.4rem 1rem;
    background: transparent;
    color: #8B0000;
    border: 1px dashed #8B0000;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.25rem;
}

.btn-add-sitio:hover {
    background: #f5edec;
    border-color: #8B0000;
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

.cp-input {
    font-weight: 600;
    letter-spacing: 1px;
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

    .sitio-web-input-group {
        flex-direction: column;
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
const institucionesExistentes = <?= json_encode($instituciones_existentes) ?>;
const entidadesFederativas = <?= json_encode($entidades_federativas) ?>;
const tiposInstitucion = <?= json_encode($tipos_institucion) ?>;

// ============================================================
// GENERAR NÚMERO DE AFILIACIÓN
// ============================================================

function generarNumeroAfiliacion(zona) {
    const fechaInicio = document.getElementById('fecha_inicio');
    let anio = new Date().getFullYear().toString().slice(-2);
    
    if (fechaInicio && fechaInicio.value) {
        const fecha = new Date(fechaInicio.value);
        if (!isNaN(fecha.getTime())) {
            anio = fecha.getFullYear().toString().slice(-2);
        }
    }
    
    const zonaStr = String(zona).padStart(2, '0');
    const prefijo = anio + zonaStr;
    
    let numeros = [];
    if (numerosPorZona[zona]) {
        numeros = numerosPorZona[zona];
    }
    
    institucionesExistentes.forEach(function(num) {
        if (num.substring(0, 4) === prefijo) {
            const n = parseInt(num.substring(4));
            if (!numeros.includes(n)) {
                numeros.push(n);
            }
        }
    });
    
    let consecutivo = 1;
    if (numeros.length > 0) {
        consecutivo = Math.max(...numeros) + 1;
    }
    
    return prefijo + String(consecutivo).padStart(3, '0');
}

// ============================================================
// ACTUALIZAR NÚMERO DE AFILIACIÓN
// ============================================================

function actualizarNumeroAfiliacion() {
    const zonaSelect = document.getElementById('zona');
    const numDisplay = document.getElementById('num_afiliacion_mostrado');
    const numInput = document.getElementById('num_afiliacion');
    const tipoSelect = document.getElementById('tipo');
    const tieneNumPropio = document.getElementById('tiene_num_propio');
    const numContainer = document.getElementById('num_afiliacion_container');
    const numRequired = document.getElementById('num_afiliacion_required');
    
    const tipo = parseInt(tipoSelect.value);
    
    // Determinar si el número de afiliación es requerido
    let esRequerido = false;
    let mostrar = false;
    
    if (tipo === 1) { // Universidad
        if (tieneNumPropio && tieneNumPropio.checked) {
            esRequerido = true;
            mostrar = true;
        } else {
            esRequerido = false;
            mostrar = false;
            numDisplay.textContent = '- - - - - - -';
            numInput.value = '';
        }
    } else if (tipo === 2 || tipo === 3) { // Facultad o Campus
        esRequerido = true;
        mostrar = true;
    }
    
    // Mostrar/ocultar y requerir
    if (mostrar) {
        numContainer.style.display = 'block';
        numRequired.style.display = esRequerido ? 'inline' : 'none';
        const zona = parseInt(zonaSelect.value);
        if (zona && zona > 0) {
            const nuevoNum = generarNumeroAfiliacion(zona);
            numDisplay.textContent = nuevoNum;
            numInput.value = nuevoNum;
        } else {
            numDisplay.textContent = '- - - - - - -';
            numInput.value = '';
        }
    } else {
        numContainer.style.display = 'none';
        numDisplay.textContent = '- - - - - - -';
        numInput.value = '';
    }
}

// ============================================================
// MOSTRAR/OCULTAR CAMPOS SEGÚN TIPO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const universidadContainer = document.getElementById('universidad_container');
    const universidadSelect = document.getElementById('universidad');
    const tieneNumPropioContainer = document.getElementById('tiene_num_propio_container');
    const tieneNumPropioCheckbox = document.getElementById('tiene_num_propio');
    
    function actualizarCampos() {
        const tipo = parseInt(tipoSelect.value);
        
        if (tipo === 1) {
            universidadContainer.style.display = 'none';
            universidadSelect.removeAttribute('required');
            universidadSelect.value = '';
            tieneNumPropioContainer.style.display = 'block';
            actualizarNumeroAfiliacion();
        } else if (tipo === 2 || tipo === 3) {
            universidadContainer.style.display = 'block';
            universidadSelect.setAttribute('required', 'required');
            tieneNumPropioContainer.style.display = 'none';
            tieneNumPropioCheckbox.checked = false;
            actualizarNumeroAfiliacion();
        } else {
            universidadContainer.style.display = 'none';
            universidadSelect.removeAttribute('required');
            universidadSelect.value = '';
            tieneNumPropioContainer.style.display = 'none';
            tieneNumPropioCheckbox.checked = false;
            document.getElementById('num_afiliacion_container').style.display = 'none';
        }
    }
    
    if (tipoSelect) {
        tipoSelect.addEventListener('change', actualizarCampos);
    }
    
    if (tieneNumPropioCheckbox) {
        tieneNumPropioCheckbox.addEventListener('change', actualizarNumeroAfiliacion);
    }
    
    const zonaSelect = document.getElementById('zona');
    if (zonaSelect) {
        zonaSelect.addEventListener('change', actualizarNumeroAfiliacion);
    }
    
    const fechaInicio = document.getElementById('fecha_inicio');
    if (fechaInicio) {
        fechaInicio.addEventListener('change', actualizarNumeroAfiliacion);
    }
    
    actualizarCampos();
});

// ============================================================
// CÓDIGO POSTAL → ENTIDAD → ZONA → COLONIAS → MUNICIPIOS
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const cpInput = document.getElementById('cp');
    const entidadSelect = document.getElementById('entidad');
    const zonaSelect = document.getElementById('zona');
    const coloniaSelect = document.getElementById('colonia');
    const municipioSelect = document.getElementById('municipio');
    
    function cargarDatosPorCP() {
        const cp = cpInput.value.trim();
        
        const existing = document.querySelector('.cp-mensaje');
        if (existing) existing.remove();
        
        if (cp.length === 5 && datosPorCP[cp]) {
            const datos = datosPorCP[cp];
            
            if (datos.entidad) entidadSelect.value = datos.entidad;
            
            municipioSelect.innerHTML = '<option value="">Seleccionar alcaldía/municipio...</option>';
            if (datos.municipio) {
                const option = document.createElement('option');
                option.value = datos.municipio;
                option.textContent = datos.municipio;
                option.selected = true;
                municipioSelect.appendChild(option);
            }
            municipioSelect.disabled = false;
            
            coloniaSelect.innerHTML = '<option value="">Seleccionar colonia...</option>';
            if (datos.colonia) {
                const option = document.createElement('option');
                option.value = datos.colonia;
                option.textContent = datos.colonia;
                option.selected = true;
                coloniaSelect.appendChild(option);
            }
            coloniaSelect.disabled = false;
            
            if (datos.zona) {
                zonaSelect.value = datos.zona;
            }
            
            actualizarNumeroAfiliacion();
            
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
            padding: 0.3rem 0.5rem;
            border-radius: 4px;
            margin-top: 0.15rem;
            color: ${tipo === 'success' ? '#2e7d32' : '#c62828'};
            background: ${tipo === 'success' ? '#e8f5e9' : '#fce4ec'};
        `;
        div.textContent = mensaje;
        cpInput.parentNode.appendChild(div);
    }
    
    if (cpInput) {
        cpInput.addEventListener('blur', cargarDatosPorCP);
        cpInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                cargarDatosPorCP();
            }
        });
    }
});

// ============================================================
// ZONA SEGÚN ENTIDAD
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const entidadSelect = document.getElementById('entidad');
    const zonaSelect = document.getElementById('zona');
    
    if (entidadSelect && zonaSelect) {
        entidadSelect.addEventListener('change', function() {
            const entidadId = parseInt(this.value);
            if (entidadId && zonaPorEntidad[entidadId]) {
                zonaSelect.value = zonaPorEntidad[entidadId];
                actualizarNumeroAfiliacion();
            }
        });
    }
});

// ============================================================
// SITIOS WEB
// ============================================================

function agregarSitioWeb() {
    const container = document.getElementById('sitios_web_container');
    const items = container.querySelectorAll('.sitio-web-item');
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

// ============================================================
// VALIDACIÓN
// ============================================================

function validarFormulario() {
    const numAfiliacion = document.getElementById('num_afiliacion');
    const tipo = parseInt(document.getElementById('tipo').value);
    const tieneNumPropio = document.getElementById('tiene_num_propio');
    
    if (tipo === 1) {
        if (tieneNumPropio && tieneNumPropio.checked) {
            if (!numAfiliacion.value) {
                alert('Seleccione una zona para generar el número de afiliación.');
                return false;
            }
            if (institucionesExistentes.includes(numAfiliacion.value)) {
                alert('El número de afiliación ya existe. Verifique la zona.');
                return false;
            }
        }
        return true;
    }
    
    if (tipo === 2 || tipo === 3) {
        if (!numAfiliacion.value) {
            alert('Seleccione una zona para generar el número de afiliación.');
            return false;
        }
        if (institucionesExistentes.includes(numAfiliacion.value)) {
            alert('El número de afiliación ya existe. Verifique la zona.');
            return false;
        }
    }
    
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formRegistro');
    if (form) {
        form.onsubmit = validarFormulario;
    }
});
</script>

<?php include 'template/footer.php'; ?>