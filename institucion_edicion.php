<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Editar institución existente
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
    'observadora' => 'Observadora',
    'matriz' => 'Matriz'
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

// Direcciones simuladas
$direcciones = [
    1 => [
        'calle' => 'Avenida Universidad',
        'numero_exterior' => '3000',
        'numero_interior' => '',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '04510',
        'municipio' => 'Coyoacán'
    ],
    2 => [
        'calle' => 'Circuito Exterior',
        'numero_exterior' => 'S/N',
        'numero_interior' => 'Edificio A',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '04510',
        'municipio' => 'Coyoacán'
    ],
    3 => [
        'calle' => 'Avenida Instituto Politécnico Nacional',
        'numero_exterior' => 'S/N',
        'numero_interior' => '',
        'colonia' => 'Zacatenco',
        'cp' => '07738',
        'municipio' => 'Gustavo A. Madero'
    ],
    4 => [
        'calle' => 'Avenida Instituto Politécnico Nacional',
        'numero_exterior' => 'S/N',
        'numero_interior' => 'Edificio 8',
        'colonia' => 'Zacatenco',
        'cp' => '07738',
        'municipio' => 'Gustavo A. Madero'
    ],
    5 => [
        'calle' => 'Avenida Juárez',
        'numero_exterior' => '976',
        'numero_interior' => '',
        'colonia' => 'Centro',
        'cp' => '44100',
        'municipio' => 'Guadalajara'
    ],
    6 => [
        'calle' => 'Periférico Norte',
        'numero_exterior' => '799',
        'numero_interior' => 'Int. 301',
        'colonia' => 'Centro',
        'cp' => '44100',
        'municipio' => 'Guadalajara'
    ],
    7 => [
        'calle' => 'Carretera Transpeninsular',
        'numero_exterior' => 'S/N',
        'numero_interior' => '',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '21259',
        'municipio' => 'Mexicali'
    ],
    8 => [
        'calle' => 'Calzada Universidad',
        'numero_exterior' => '14418',
        'numero_interior' => '',
        'colonia' => 'Internacional Tijuana',
        'cp' => '22424',
        'municipio' => 'Tijuana'
    ],
    9 => [
        'calle' => 'Avenida Universidad',
        'numero_exterior' => 'S/N',
        'numero_interior' => '',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '66450',
        'municipio' => 'San Nicolás de los Garza'
    ],
    10 => [
        'calle' => 'Avenida Universidad',
        'numero_exterior' => 'S/N',
        'numero_interior' => '',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '66450',
        'municipio' => 'San Nicolás de los Garza'
    ],
    11 => [
        'calle' => 'Blv. Juan de Dios Batiz y 20 de Noviembre',
        'numero_exterior' => 'S/N',
        'numero_interior' => 'Apartado 766',
        'colonia' => 'Del Parque',
        'cp' => '81250',
        'municipio' => 'Ahome'
    ],
    12 => [
        'calle' => 'Blv. Cucapahcu',
        'numero_exterior' => '20100',
        'numero_interior' => '',
        'colonia' => 'Fracc. Lago',
        'cp' => '22100',
        'municipio' => 'Tijuana'
    ],
    13 => [
        'calle' => 'Calle Francisco Javier Mina',
        'numero_exterior' => '1000',
        'numero_interior' => '',
        'colonia' => 'Zona Centro',
        'cp' => '31000',
        'municipio' => 'Chihuahua'
    ],
    14 => [
        'calle' => 'Blv. Cucapahcu',
        'numero_exterior' => '20100',
        'numero_interior' => '',
        'colonia' => 'Fracc. Lago',
        'cp' => '22100',
        'municipio' => 'Tijuana'
    ],
    15 => [
        'calle' => 'Avenida Tecnológico',
        'numero_exterior' => 'S/N',
        'numero_interior' => '',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '76010',
        'municipio' => 'Querétaro'
    ],
    16 => [
        'calle' => 'Calle 60',
        'numero_exterior' => '491',
        'numero_interior' => '',
        'colonia' => 'Centro',
        'cp' => '97160',
        'municipio' => 'Mérida'
    ],
    17 => [
        'calle' => 'Blvd. Universitarios y Avenida las Américas',
        'numero_exterior' => 'S/N',
        'numero_interior' => '',
        'colonia' => 'Ciudad Universitaria',
        'cp' => '80013',
        'municipio' => 'Culiacán'
    ]
];

// Sitios web simulados
$sitios_web = [
    1 => ['https://www.unam.mx'],
    2 => ['https://www.fca.unam.mx'],
    3 => ['https://www.ipn.mx', 'https://www.tecnm.mx'],
    4 => ['https://www.escom.ipn.mx'],
    5 => ['https://www.udg.mx', 'https://www.cucea.udg.mx'],
    6 => ['https://www.cucea.udg.mx'],
    7 => ['https://www.uabc.mx', 'https://www.uabc.mx/ensenada'],
    8 => ['https://www.uabc.mx/planteles/mexicali'],
    9 => ['https://www.uanl.mx', 'https://www.uanl.mx/ciudad-universitaria'],
    10 => ['https://www.uanl.mx/campus-san-nicolas'],
    11 => ['https://www.itmochis.edu.mx'],
    12 => ['https://www.cesun.mx'],
    13 => ['https://www.iesch.edu.mx'],
    14 => ['https://www.cesun.mx/administrativas'],
    15 => ['https://www.uaq.mx'],
    16 => ['https://www.uady.mx'],
    17 => ['https://www.uas.edu.mx']
];

// Instituciones existentes
$instituciones = [
    [
        'id' => 1,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Nacional Autónoma de México',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 2,
        'num_afiliacion' => '2607002',
        'nombre' => 'Facultad de Contaduría y Administración (UNAM)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 1,
        'fecha_inicio' => '2024-01-15',
        'fecha_fin' => null
    ],
    [
        'id' => 3,
        'num_afiliacion' => null,
        'nombre' => 'Instituto Politécnico Nacional',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'fecha_inicio' => '2024-02-01',
        'fecha_fin' => null
    ],
    [
        'id' => 4,
        'num_afiliacion' => '2607004',
        'nombre' => 'ESCOM (IPN)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 3,
        'fecha_inicio' => '2024-02-15',
        'fecha_fin' => null
    ],
    [
        'id' => 5,
        'num_afiliacion' => '2601005',
        'nombre' => 'Universidad de Guadalajara',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'fecha_inicio' => '2024-03-01',
        'fecha_fin' => null
    ],
    [
        'id' => 6,
        'num_afiliacion' => '2604006',
        'nombre' => 'Facultad de Contaduría (UDG)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 5,
        'fecha_inicio' => '2024-03-15',
        'fecha_fin' => null
    ],
    [
        'id' => 7,
        'num_afiliacion' => '2601007',
        'nombre' => 'Universidad Autónoma de Baja California',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 2,
        'id_universidad' => null,
        'fecha_inicio' => '2024-04-01',
        'fecha_fin' => null
    ],
    [
        'id' => 8,
        'num_afiliacion' => '2601008',
        'nombre' => 'Campus UABC - Mexicali',
        'tipo' => 3,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 2,
        'id_universidad' => 7,
        'fecha_inicio' => '2024-04-15',
        'fecha_fin' => null
    ],
    [
        'id' => 9,
        'num_afiliacion' => '2602009',
        'nombre' => 'Universidad Autónoma de Nuevo León',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => null,
        'fecha_inicio' => '2024-05-01',
        'fecha_fin' => null
    ],
    [
        'id' => 10,
        'num_afiliacion' => '2605010',
        'nombre' => 'Campus UANL - San Nicolás',
        'tipo' => 3,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => 9,
        'fecha_inicio' => '2024-05-15',
        'fecha_fin' => null
    ],
    [
        'id' => 11,
        'num_afiliacion' => null,
        'nombre' => 'Instituto Tecnológico de los Mochis',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 1,
        'id_entidad' => 25,
        'id_universidad' => null,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 12,
        'num_afiliacion' => null,
        'nombre' => 'Centro de Estudios Superiores del Noroeste',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 1,
        'id_entidad' => 2,
        'id_universidad' => null,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => '2024-12-31'
    ],
    [
        'id' => 13,
        'num_afiliacion' => null,
        'nombre' => 'Instituto de Estudios Superiores de Chihuahua',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 1,
        'id_entidad' => 6,
        'id_universidad' => null,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 14,
        'num_afiliacion' => null,
        'nombre' => 'Facultad de Ciencias Administrativas (CESUN)',
        'tipo' => 2,
        'participacion' => 'observadora',
        'id_zona' => 1,
        'id_entidad' => 2,
        'id_universidad' => 12,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 15,
        'num_afiliacion' => '2603011',
        'nombre' => 'Universidad Autónoma de Querétaro',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 3,
        'id_entidad' => 22,
        'id_universidad' => null,
        'fecha_inicio' => '2024-06-01',
        'fecha_fin' => null
    ],
    [
        'id' => 16,
        'num_afiliacion' => '2606012',
        'nombre' => 'Universidad Autónoma de Yucatán',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 31,
        'id_universidad' => null,
        'fecha_inicio' => '2024-06-15',
        'fecha_fin' => null
    ],
    [
        'id' => 17,
        'num_afiliacion' => '2601013',
        'nombre' => 'Universidad Autónoma de Sinaloa',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 25,
        'id_universidad' => null,
        'fecha_inicio' => '2024-07-01',
        'fecha_fin' => null
    ]
];

// Obtener el ID de la institución a editar
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Buscar la institución
$institucion = null;
foreach ($instituciones as $i) {
    if ($i['id'] == $id) {
        $institucion = $i;
        break;
    }
}

if (!$institucion) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró la institución solicitada.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// Obtener dirección de la institución
$direccion = $direcciones[$id] ?? null;

// Obtener sitios web de la institución
$webs = $sitios_web[$id] ?? [''];

$mensaje = '';
$error = '';

// Procesar formulario de edición
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
    $participacion = $_POST['participacion'];
    $num_afiliacion = trim($_POST['num_afiliacion']);
    
    $requiere_numero = false;
    
    if ($tipo == 1) { // Universidad
        if ($participacion == 'afiliada') {
            $requiere_numero = true;
        }
    } elseif ($tipo == 2 || $tipo == 3) { // Facultad o Campus
        if ($participacion != 'observadora') {
            $requiere_numero = true;
        }
    }
    
    if ($requiere_numero) {
        if (empty($num_afiliacion)) {
            $errores[] = 'Número de afiliación';
        }
    }
    
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
        $mensaje = 'Institución actualizada exitosamente';
        // Aquí iría la lógica de actualización en BD
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
                    <h1 class="page-title">Editar Institución</h1>
                    <p class="page-subtitle">Modifique los datos de la institución educativa en el sistema</p>
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
            
            <form method="POST" id="formEdicion">
                <input type="hidden" name="id" value="<?= $id ?>">
                
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
                            <input type="text" name="nombre" class="form-control" 
                                   value="<?= htmlspecialchars($institucion['nombre']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Tipo de Institución</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccionar tipo...</option>
                                <?php foreach ($tipos_institucion as $id_tipo => $nombre): ?>
                                    <option value="<?= $id_tipo ?>" <?= $institucion['tipo'] == $id_tipo ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group" id="universidad_container" style="<?= $institucion['tipo'] != 1 ? 'display:block;' : 'display:none;' ?>">
                            <label class="form-label required">Universidad</label>
                            <select name="universidad" id="universidad" class="form-control" <?= $institucion['tipo'] != 1 ? 'required' : '' ?>>
                                <option value="">Seleccionar universidad...</option>
                                <?php foreach ($universidades as $id_uni => $nombre): ?>
                                    <option value="<?= $id_uni ?>" <?= $institucion['id_universidad'] == $id_uni ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Seleccione la universidad a la que pertenece</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Participación</label>
                            <select name="participacion" id="participacion" class="form-control" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($tipos_participacion as $key => $nombre): ?>
                                    <option value="<?= $key ?>" <?= $institucion['participacion'] == $key ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint" id="participacion_hint">
                                <?php if ($institucion['tipo'] == 1): ?>
                                    Para universidades matriz, seleccione "Matriz"
                                <?php endif; ?>
                            </small>
                        </div>

                        <!-- Número de afiliación -->
                        <div class="form-group" id="num_afiliacion_container" style="<?= ($institucion['participacion'] == 'afiliada' && $institucion['tipo'] != 1) || ($institucion['tipo'] == 1 && $institucion['participacion'] == 'afiliada') ? 'display:block;' : 'display:none;' ?>">
                            <label class="form-label" id="num_afiliacion_label">Número de Afiliación <span id="num_afiliacion_required" style="color:#c62828;">*</span></label>
                            <div class="afiliacion-display">
                                <span class="afiliacion-value" id="num_afiliacion_mostrado">
                                    <?= $institucion['num_afiliacion'] ?? '- - - - - - -' ?>
                                </span>
                            </div>
                            <input type="hidden" name="num_afiliacion" id="num_afiliacion" value="<?= $institucion['num_afiliacion'] ?? '' ?>">
                            <small class="form-hint" id="num_afiliacion_hint">Se genera con el año, zona y consecutivo</small>
                        </div>

                        <!-- Sitios Web -->
                        <div class="form-group">
                            <label class="form-label">Sitios Web</label>
                            <div id="sitios_web_container">
                                <?php if (empty($webs) || (count($webs) == 1 && empty($webs[0]))): ?>
                                    <div class="sitio-web-item">
                                        <div class="sitio-web-input-group">
                                            <input type="url" name="sitios_web[]" class="form-control" placeholder="https://www.ejemplo.com">
                                            <button type="button" class="btn-remove-sitio" onclick="eliminarSitioWeb(this)" style="display:none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($webs as $index => $web): ?>
                                        <div class="sitio-web-item">
                                            <div class="sitio-web-input-group">
                                                <input type="url" name="sitios_web[]" class="form-control" placeholder="https://www.ejemplo.com" value="<?= htmlspecialchars($web) ?>">
                                                <button type="button" class="btn-remove-sitio" onclick="eliminarSitioWeb(this)" style="<?= $index == 0 ? 'display:none;' : 'display:flex;' ?>">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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
                            <input type="text" name="cp" id="cp" class="form-control cp-input" 
                                   value="<?= $direccion ? htmlspecialchars($direccion['cp']) : '' ?>" 
                                   placeholder="Ej. 04510" pattern="[0-9]{5}" inputmode="numeric" required>
                            <small class="form-hint">Ejemplos: 04510 (UNAM), 07738 (IPN), 09340 (UAM)</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Entidad</label>
                            <select name="entidad" id="entidad" class="form-control" required>
                                <option value="">Seleccionar entidad...</option>
                                <?php foreach ($entidades_federativas as $id_ent => $nombre): ?>
                                    <option value="<?= $id_ent ?>" <?= $institucion['id_entidad'] == $id_ent ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Se carga automáticamente con el código postal</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Alcaldía / Municipio</label>
                            <select name="municipio" id="municipio" class="form-control" required>
                                <option value="">Seleccionar alcaldía/municipio...</option>
                                <?php if ($direccion && !empty($direccion['municipio'])): ?>
                                    <option value="<?= htmlspecialchars($direccion['municipio']) ?>" selected>
                                        <?= htmlspecialchars($direccion['municipio']) ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                            <small class="form-hint">Se carga automáticamente con el código postal</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Colonia</label>
                            <select name="colonia" id="colonia" class="form-control" required>
                                <option value="">Seleccionar colonia...</option>
                                <?php if ($direccion && !empty($direccion['colonia'])): ?>
                                    <option value="<?= htmlspecialchars($direccion['colonia']) ?>" selected>
                                        <?= htmlspecialchars($direccion['colonia']) ?>
                                    </option>
                                <?php endif; ?>
                            </select>
                            <small class="form-hint">Se carga automáticamente con el código postal</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Zona</label>
                            <select name="zona" id="zona" class="form-control" required>
                                <option value="">Seleccionar zona...</option>
                                <?php foreach ($zonas_regionales as $id_zona => $nombre): ?>
                                    <option value="<?= $id_zona ?>" <?= $institucion['id_zona'] == $id_zona ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($nombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-hint">Se carga con el código postal, puede modificarse</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Calle</label>
                            <input type="text" name="calle" class="form-control" 
                                   value="<?= $direccion ? htmlspecialchars($direccion['calle']) : '' ?>" 
                                   placeholder="Ej. Calzada Universidad" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Número Exterior</label>
                            <input type="text" name="numero_exterior" class="form-control" 
                                   value="<?= $direccion ? htmlspecialchars($direccion['numero_exterior']) : '' ?>" 
                                   placeholder="Ej. 14418" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Número Interior</label>
                            <input type="text" name="numero_interior" class="form-control" 
                                   value="<?= $direccion && !empty($direccion['numero_interior']) ? htmlspecialchars($direccion['numero_interior']) : '' ?>" 
                                   placeholder="Ej. A-102">
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
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" 
                                   value="<?= $institucion['fecha_inicio'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" 
                                   value="<?= $institucion['fecha_fin'] ?>">
                            <small class="form-hint">Dejar vacío si está vigente</small>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary-modern">
                        <i class="fas fa-save"></i> Actualizar Institución
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
   ESTILOS MODERNOS - EDICIÓN INSTITUCIÓN
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

/* Grids - Responsive */
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
    width: 100%;
}

.afiliacion-value {
    font-weight: 600;
    color: #1a1a1a;
    font-family: monospace;
    font-size: 1.1rem;
    letter-spacing: 2px;
}

/* Form groups */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    width: 100%;
}

.form-label {
    font-weight: 600;
    font-size: 0.8rem;
    color: #3a3a3a;
    white-space: nowrap;
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

/* Sitios Web */
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

    .afiliacion-display {
        min-height: 40px;
        padding: 0.5rem 0.8rem;
    }

    .afiliacion-value {
        font-size: 0.95rem;
    }

    .form-label {
        white-space: normal;
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
    }

    .form-control {
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
    }

    .afiliacion-display {
        min-height: 36px;
        padding: 0.4rem 0.6rem;
    }

    .afiliacion-value {
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .btn-remove-sitio {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const datosPorCP = <?= json_encode($datos_por_cp) ?>;
const zonaPorEntidad = <?= json_encode($zona_por_entidad) ?>;
const tiposInstitucion = <?= json_encode($tipos_institucion) ?>;
const tiposParticipacion = <?= json_encode($tipos_participacion) ?>;

// ============================================================
// FUNCIÓN PARA GENERAR NÚMERO DE AFILIACIÓN
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
    
    // Números existentes para esta zona (simulado)
    const numerosExistentes = {
        1: [1, 3, 5, 7, 8, 13, 17],
        2: [9, 10],
        3: [11, 15],
        4: [5, 6],
        6: [12, 16],
        7: [1, 2, 3, 4]
    };
    
    let numeros = numerosExistentes[zona] || [];
    let consecutivo = 1;
    if (numeros.length > 0) {
        consecutivo = Math.max(...numeros) + 1;
    }
    
    return prefijo + String(consecutivo).padStart(3, '0');
}

// ============================================================
// ACTUALIZAR CAMPOS SEGÚN TIPO Y PARTICIPACIÓN
// ============================================================

function actualizarCampos() {
    const tipoSelect = document.getElementById('tipo');
    const participacionSelect = document.getElementById('participacion');
    const universidadContainer = document.getElementById('universidad_container');
    const universidadSelect = document.getElementById('universidad');
    const numContainer = document.getElementById('num_afiliacion_container');
    const numRequired = document.getElementById('num_afiliacion_required');
    const numDisplay = document.getElementById('num_afiliacion_mostrado');
    const numInput = document.getElementById('num_afiliacion');
    const participacionHint = document.getElementById('participacion_hint');
    const zonaSelect = document.getElementById('zona');
    
    const tipo = parseInt(tipoSelect.value);
    const participacion = participacionSelect.value;
    
    // Universidad
    if (tipo === 1) {
        universidadContainer.style.display = 'none';
        universidadSelect.removeAttribute('required');
        universidadSelect.value = '';
        participacionHint.textContent = 'Para universidades matriz, seleccione "Matriz"';
    } else {
        universidadContainer.style.display = 'block';
        universidadSelect.setAttribute('required', 'required');
        participacionHint.textContent = '';
    }
    
    // Número de afiliación
    let requiereNumero = false;
    let mostrarNumero = false;
    let numeroActual = numInput.value;
    
    if (tipo === 1) { // Universidad
        if (participacion === 'afiliada') {
            requiereNumero = true;
            mostrarNumero = true;
        } else {
            requiereNumero = false;
            mostrarNumero = false;
        }
    } else if (tipo === 2 || tipo === 3) { // Facultad o Campus
        if (participacion === 'observadora') {
            requiereNumero = false;
            mostrarNumero = false;
        } else {
            requiereNumero = true;
            mostrarNumero = true;
        }
    }
    
    if (mostrarNumero) {
        numContainer.style.display = 'block';
        numRequired.style.display = requiereNumero ? 'inline' : 'none';
        
        const zona = parseInt(zonaSelect.value);
        if (zona && zona > 0 && !numeroActual) {
            const nuevoNum = generarNumeroAfiliacion(zona);
            numDisplay.textContent = nuevoNum;
            numInput.value = nuevoNum;
        } else if (numeroActual) {
            numDisplay.textContent = numeroActual;
        } else {
            numDisplay.textContent = '- - - - - - -';
        }
    } else {
        numContainer.style.display = 'none';
        numDisplay.textContent = '- - - - - - -';
        numInput.value = '';
    }
}

// ============================================================
// EVENTOS
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const participacionSelect = document.getElementById('participacion');
    const zonaSelect = document.getElementById('zona');
    const cpInput = document.getElementById('cp');
    const entidadSelect = document.getElementById('entidad');
    const municipioSelect = document.getElementById('municipio');
    const coloniaSelect = document.getElementById('colonia');
    
    // Eventos para actualizar campos
    if (tipoSelect) {
        tipoSelect.addEventListener('change', actualizarCampos);
    }
    
    if (participacionSelect) {
        participacionSelect.addEventListener('change', actualizarCampos);
    }
    
    if (zonaSelect) {
        zonaSelect.addEventListener('change', actualizarCampos);
    }
    
    // Código postal → cargar datos
    if (cpInput) {
        cpInput.addEventListener('blur', function() {
            const cp = this.value.trim();
            
            if (cp.length === 5 && datosPorCP[cp]) {
                const datos = datosPorCP[cp];
                
                if (datos.entidad) {
                    entidadSelect.value = datos.entidad;
                    // Disparar cambio para actualizar municipio y colonia
                    entidadSelect.dispatchEvent(new Event('change'));
                }
                
                if (datos.municipio) {
                    municipioSelect.innerHTML = '<option value="">Seleccionar alcaldía/municipio...</option>';
                    const option = document.createElement('option');
                    option.value = datos.municipio;
                    option.textContent = datos.municipio;
                    option.selected = true;
                    municipioSelect.appendChild(option);
                    municipioSelect.disabled = false;
                }
                
                if (datos.colonia) {
                    coloniaSelect.innerHTML = '<option value="">Seleccionar colonia...</option>';
                    const option = document.createElement('option');
                    option.value = datos.colonia;
                    option.textContent = datos.colonia;
                    option.selected = true;
                    coloniaSelect.appendChild(option);
                    coloniaSelect.disabled = false;
                }
                
                if (datos.zona) {
                    zonaSelect.value = datos.zona;
                    actualizarCampos();
                }
            }
        });
    }
    
    // Entidad → zona
    if (entidadSelect && zonaSelect) {
        entidadSelect.addEventListener('change', function() {
            const entidadId = parseInt(this.value);
            if (entidadId && zonaPorEntidad[entidadId]) {
                zonaSelect.value = zonaPorEntidad[entidadId];
                actualizarCampos();
            }
        });
    }
    
    // Inicializar
    actualizarCampos();
});

// ============================================================
// SITIOS WEB - AGREGAR / ELIMINAR
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
// VALIDACIÓN DEL FORMULARIO
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEdicion');
    if (form) {
        form.onsubmit = function() {
            const numAfiliacion = document.getElementById('num_afiliacion');
            const tipo = parseInt(document.getElementById('tipo').value);
            const participacion = document.getElementById('participacion').value;
            
            let requiereNumero = false;
            
            if (tipo === 1 && participacion === 'afiliada') {
                requiereNumero = true;
            } else if ((tipo === 2 || tipo === 3) && participacion !== 'observadora') {
                requiereNumero = true;
            }
            
            if (requiereNumero && !numAfiliacion.value) {
                alert('Por favor, seleccione una zona para generar el número de afiliación.');
                return false;
            }
            
            return true;
        };
    }
});
</script>

<?php include 'template/footer.php'; ?>