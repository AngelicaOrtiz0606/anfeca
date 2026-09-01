<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Consultar detalle de institución
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// OBTENER ID DE LA INSTITUCIÓN
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

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

// Direcciones simuladas (con alcaldía/municipio)
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

// Sitios web simulados (UNAM solo uno)
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

// Instituciones
$instituciones = [
    [
        'id' => 1,
        'num_afiliacion' => '2601001',
        'nombre' => 'Universidad Nacional Autónoma de México',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 5,
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
        'personas_relacionadas' => 3,
        'fecha_inicio' => '2024-01-15',
        'fecha_fin' => null
    ],
    [
        'id' => 3,
        'num_afiliacion' => '2601003',
        'nombre' => 'Instituto Politécnico Nacional',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
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
        'personas_relacionadas' => 2,
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
        'personas_relacionadas' => 1,
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
        'personas_relacionadas' => 1,
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
        'personas_relacionadas' => 2,
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
        'personas_relacionadas' => 1,
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
        'personas_relacionadas' => 0,
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
        'personas_relacionadas' => 0,
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
        'personas_relacionadas' => 1,
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
        'personas_relacionadas' => 0,
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
        'personas_relacionadas' => 1,
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
        'personas_relacionadas' => 1,
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
        'personas_relacionadas' => 0,
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
        'personas_relacionadas' => 0,
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
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-07-01',
        'fecha_fin' => null
    ]
];

// Personas asociadas a instituciones (con cargos institucionales)
$personas_asociadas = [
    1 => [
        ['nombre' => 'María González', 'cargo' => 'Directora', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Juan Martínez', 'cargo' => 'Coordinador', 'titular' => false, 'fecha_inicio' => '2024-01-15', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Ana Sánchez', 'cargo' => 'Secretario', 'titular' => false, 'fecha_inicio' => '2023-06-01', 'fecha_fin' => '2024-05-31', 'activo' => false],
        ['nombre' => 'Carlos Hernández', 'cargo' => 'Director de División', 'titular' => false, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Laura Torres', 'cargo' => 'Coordinadora Académica', 'titular' => false, 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null, 'activo' => true]
    ],
    2 => [
        ['nombre' => 'Roberto Mendoza', 'cargo' => 'Director', 'titular' => true, 'fecha_inicio' => '2024-01-15', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Patricia Flores', 'cargo' => 'Subdirectora', 'titular' => false, 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Luis Reyes', 'cargo' => 'Coordinador', 'titular' => false, 'fecha_inicio' => '2023-08-01', 'fecha_fin' => '2024-07-31', 'activo' => false]
    ],
    3 => [
        ['nombre' => 'Carlos López', 'cargo' => 'Director General', 'titular' => true, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Ana Torres', 'cargo' => 'Secretaria', 'titular' => false, 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null, 'activo' => true]
    ],
    4 => [
        ['nombre' => 'Mario Salcido', 'cargo' => 'Director', 'titular' => true, 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Diana Ruiz', 'cargo' => 'Coordinadora', 'titular' => false, 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null, 'activo' => true]
    ],
    5 => [
        ['nombre' => 'Jesús Padilla', 'cargo' => 'Director', 'titular' => true, 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null, 'activo' => true]
    ],
    6 => [
        ['nombre' => 'Sósima Carrillo', 'cargo' => 'Directora', 'titular' => true, 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true]
    ],
    7 => [
        ['nombre' => 'Edith Montiel', 'cargo' => 'Directora', 'titular' => true, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['nombre' => 'Isidro Basantes', 'cargo' => 'Coordinador', 'titular' => false, 'fecha_inicio' => '2024-04-10', 'fecha_fin' => null, 'activo' => true]
    ],
    8 => [
        ['nombre' => 'Ana Vázquez', 'cargo' => 'Directora', 'titular' => true, 'fecha_inicio' => '2024-04-15', 'fecha_fin' => null, 'activo' => true]
    ],
    11 => [
        ['nombre' => 'Francisco Cupa', 'cargo' => 'Director', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    13 => [
        ['nombre' => 'Hermenegildo Lagarda', 'cargo' => 'Director', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    14 => [
        ['nombre' => 'Diana Woolsolk', 'cargo' => 'Directora', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    17 => [
        ['nombre' => 'Leobardo Berrelleza', 'cargo' => 'Director', 'titular' => true, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true]
    ]
];

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

// Obtener datos adicionales
$zona_nombre = $zonas_regionales[$institucion['id_zona']] ?? 'Sin zona';
$tipo_nombre = $tipos_institucion[$institucion['tipo']] ?? 'No definido';
$entidad_nombre = $entidades_federativas[$institucion['id_entidad']] ?? 'Sin entidad';
$participacion_nombre = $tipos_participacion[$institucion['participacion']] ?? 'No definido';
$estado = $institucion['fecha_fin'] === null ? 'Vigente' : 'Finalizada';

// Obtener dependencia y su ID para enlace
$dependencia = '';
$dependencia_id = null;
if ($institucion['tipo'] != 1 && $institucion['id_universidad']) {
    foreach ($instituciones as $i) {
        if ($i['id'] == $institucion['id_universidad']) {
            $dependencia = $i['nombre'];
            $dependencia_id = $i['id'];
            break;
        }
    }
}

// Obtener dirección
$direccion = $direcciones[$id] ?? null;

// Obtener sitios web
$webs = $sitios_web[$id] ?? [];

// Obtener personas asociadas
$personas = $personas_asociadas[$id] ?? [];

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
                    <h1 class="page-title">Detalle de Institución</h1>
                    <p class="page-subtitle">Información completa de la institución registrada en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="institucion_edicion.php?id=<?= $id ?>" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="instituciones.php" class="btn-outline-modern">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <!-- Contenido -->
        <div class="detail-container">
            
            <!-- Tarjeta de información general -->
            <div class="detail-card profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <?php 
                        $letras = explode(' ', $institucion['nombre']);
                        $iniciales = '';
                        foreach ($letras as $l) {
                            if (strlen($l) > 0) {
                                $iniciales .= substr($l, 0, 1);
                            }
                            if (strlen($iniciales) >= 3) break;
                        }
                        ?>
                        <span><?= strtoupper($iniciales) ?></span>
                    </div>
                    <div class="profile-info">
                        <h2><?= htmlspecialchars($institucion['nombre']) ?></h2>
                        <div class="profile-meta">
                            <span class="profile-afiliacion">
                                <span class="afiliacion-label">Núm. Afiliación:</span>
                                <span class="afiliacion-value"><?= htmlspecialchars($institucion['num_afiliacion'] ?? '--- (Observadora)') ?></span>
                            </span>
                            <span class="profile-status <?= $estado == 'Vigente' ? 'status-active' : 'status-inactive' ?>">
                                <span class="status-dot"></span> <?= $estado ?>
                            </span>
                            <span class="profile-participacion <?= $institucion['participacion'] == 'afiliada' ? 'badge-afiliada' : 'badge-observadora' ?>">
                                <?= htmlspecialchars($participacion_nombre) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="profile-item">
                        <span class="profile-label">Tipo</span>
                        <span class="profile-value"><?= htmlspecialchars($tipo_nombre) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Dependencia</span>
                        <span class="profile-value">
                            <?php if ($dependencia_id): ?>
                                <a href="institucion_consulta.php?id=<?= $dependencia_id ?>" class="dependencia-link">
                                    <?= htmlspecialchars($dependencia) ?>
                                </a>
                            <?php else: ?>
                                <?= htmlspecialchars($dependencia) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Entidad</span>
                        <span class="profile-value"><?= htmlspecialchars($entidad_nombre) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Zona</span>
                        <span class="profile-value">
                            <span class="badge-zona"><?= htmlspecialchars($zona_nombre) ?></span>
                        </span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Fecha Inicio</span>
                        <span class="profile-value"><?= date('d/m/Y', strtotime($institucion['fecha_inicio'])) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Fecha Fin</span>
                        <span class="profile-value"><?= $institucion['fecha_fin'] ? date('d/m/Y', strtotime($institucion['fecha_fin'])) : '---' ?></span>
                    </div>
                </div>
            </div>

            <!-- Dirección -->
            <?php if ($direccion): ?>
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Dirección</h3>
                </div>
                <div class="detail-card-body">
                    <div class="direccion-grid">
                        <div class="direccion-item">
                            <span class="direccion-label">Calle</span>
                            <span class="direccion-value"><?= htmlspecialchars($direccion['calle']) ?></span>
                        </div>
                        <div class="direccion-item">
                            <span class="direccion-label">Número Exterior</span>
                            <span class="direccion-value"><?= htmlspecialchars($direccion['numero_exterior']) ?></span>
                        </div>
                        <?php if (!empty($direccion['numero_interior'])): ?>
                        <div class="direccion-item">
                            <span class="direccion-label">Número Interior</span>
                            <span class="direccion-value"><?= htmlspecialchars($direccion['numero_interior']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="direccion-item">
                            <span class="direccion-label">Colonia</span>
                            <span class="direccion-value"><?= htmlspecialchars($direccion['colonia']) ?></span>
                        </div>
                        <div class="direccion-item">
                            <span class="direccion-label">Código Postal</span>
                            <span class="direccion-value"><?= htmlspecialchars($direccion['cp']) ?></span>
                        </div>
                        <div class="direccion-item">
                            <span class="direccion-label">Alcaldía / Municipio</span>
                            <span class="direccion-value"><?= htmlspecialchars($direccion['municipio']) ?></span>
                        </div>
                        <div class="direccion-item">
                            <span class="direccion-label">Entidad</span>
                            <span class="direccion-value"><?= htmlspecialchars($entidad_nombre) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Sitios Web -->
            <?php if (!empty($webs)): ?>
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Sitios Web</h3>
                </div>
                <div class="detail-card-body">
                    <div class="webs-list">
                        <?php foreach ($webs as $web): ?>
                            <a href="<?= htmlspecialchars($web) ?>" target="_blank" class="web-link">
                                <i class="fas fa-globe"></i> <?= htmlspecialchars($web) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Personas asociadas -->
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Personas asociadas</h3>
                    <span class="detail-badge"><?= count($personas) ?> persona(s)</span>
                </div>
                <div class="detail-card-body">
                    <?php if (count($personas) > 0): ?>
                        <div class="table-modern-container">
                            <div class="table-modern-wrapper">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Cargo</th>
                                            <th>Titular</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($personas as $persona): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($persona['nombre']) ?></td>
                                                <td><?= htmlspecialchars($persona['cargo']) ?></td>
                                                <td>
                                                    <?php if ($persona['titular']): ?>
                                                        <span class="badge-titular">Sí</span>
                                                    <?php else: ?>
                                                        <span class="badge-no-titular">No</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= date('d/m/Y', strtotime($persona['fecha_inicio'])) ?></td>
                                                <td><?= $persona['fecha_fin'] ? date('d/m/Y', strtotime($persona['fecha_fin'])) : '---' ?></td>
                                                <td>
                                                    <?php if ($persona['activo']): ?>
                                                        <span class="status-active"><i class="fas fa-circle"></i> Activo</span>
                                                    <?php else: ?>
                                                        <span class="status-inactive"><i class="fas fa-circle"></i> Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="empty-personas">
                            <i class="fas fa-user-times"></i>
                            <p>No hay personas asociadas a esta institución</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - CONSULTA INSTITUCIÓN
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

/* Detail Container */
.detail-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.detail-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.detail-card-header h3 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.detail-badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.8rem;
    background: #f5f0f0;
    color: #666;
    border-radius: 20px;
    font-weight: 600;
}

.detail-card-body {
    padding: 0;
}

/* Profile Card */
.profile-card {
    padding: 0;
    overflow: hidden;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 1.75rem;
    background: linear-gradient(135deg, #faf8f8, #f5f0f0);
    border-bottom: 1px solid #f0ecec;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(139, 0, 0, 0.25);
}

.profile-info {
    flex: 1;
}

.profile-info h2 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 0.3rem 0;
}

.profile-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.profile-afiliacion {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
}

.afiliacion-label {
    color: #888;
    font-weight: 500;
}

.afiliacion-value {
    font-weight: 600;
    color: #1a1a1a;
    font-family: monospace;
    background: #f0ecec;
    padding: 0.1rem 0.5rem;
    border-radius: 4px;
}

.profile-status {
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.profile-status.status-active .status-dot {
    background: #2e7d32;
}

.profile-status.status-inactive .status-dot {
    background: #c62828;
}

.profile-status.status-active {
    color: #2e7d32;
}

.profile-status.status-inactive {
    color: #c62828;
}

.profile-participacion {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
}

.profile-participacion.badge-afiliada {
    background: #e8f5e9;
    color: #2e7d32;
}

.profile-participacion.badge-observadora {
    background: #fff3e0;
    color: #e65100;
}

.profile-body {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    padding: 1.25rem 1.75rem;
}

.profile-item {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.profile-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #999;
}

.profile-value {
    font-size: 0.95rem;
    font-weight: 500;
    color: #1a1a1a;
}

/* Dependencia link */
.dependencia-link {
    color: #8B0000;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.dependencia-link:hover {
    color: #5C0000;
    text-decoration: underline;
}

/* Badge Zona */
.badge-zona {
    display: inline-block;
    padding: 0.2rem 0.8rem;
    background: #f0ebeb;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Dirección */
.direccion-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
}

.direccion-item {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}

.direccion-label {
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #999;
}

.direccion-value {
    font-size: 0.9rem;
    color: #1a1a1a;
}

/* Sitios Web */
.webs-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.web-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.8rem;
    background: #f0f7fa;
    color: #0d6efd;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}

.web-link:hover {
    background: #0d6efd;
    color: white;
}

/* Personas asociadas */
.table-modern-container {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #f0ecec;
}

.table-modern-wrapper {
    overflow-x: auto;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.table-modern thead {
    background: #faf8f8;
}

.table-modern thead th {
    text-align: left;
    padding: 0.7rem 1rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
}

.table-modern tbody td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

.badge-titular {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: #e8f5e9;
    color: #2e7d32;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

.badge-no-titular {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: #f5f5f5;
    color: #999;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

.status-active {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #2e7d32;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-active i {
    font-size: 0.5rem;
}

.status-inactive {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #c62828;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-inactive i {
    font-size: 0.5rem;
}

/* Empty personas */
.empty-personas {
    text-align: center;
    padding: 2rem 0;
}

.empty-personas i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-personas p {
    color: #999;
    margin: 0;
    font-size: 0.95rem;
}

/* Responsive */
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

    .page-header-right .btn-primary-modern,
    .page-header-right .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }

    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .profile-body {
        grid-template-columns: 1fr;
        gap: 0.75rem;
        padding: 1rem;
    }

    .direccion-grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }

    .detail-card {
        padding: 1.25rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.5rem 0.6rem;
        font-size: 0.8rem;
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

    .profile-avatar {
        width: 64px;
        height: 64px;
        font-size: 1.4rem;
    }

    .profile-info h2 {
        font-size: 1.1rem;
    }

    .profile-meta {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .direccion-grid {
        grid-template-columns: 1fr;
    }

    .webs-list {
        flex-direction: column;
    }
}
</style>

<?php include 'template/footer.php'; ?>