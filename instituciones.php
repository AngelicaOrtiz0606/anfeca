<?php
// ============================================================
// SIDEANFECA - Gestión de Instituciones
// Listado de instituciones registradas
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

// ============================================================
// INSTITUCIONES (MEZCLADAS)
// ============================================================

$instituciones = [
    // Matriz
    [
        'id' => 1,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Nacional Autónoma de México',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 4,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (FCA UNAM)
    [
        'id' => 2,
        'num_afiliacion' => '9807033',
        'nombre' => 'Facultad de Contaduría y Administración (UNAM)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 1,
        'personas_relacionadas' => 4,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 3,
        'num_afiliacion' => null,
        'nombre' => 'Universidad de Guadalajara',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 4,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UDG)
    [
        'id' => 4,
        'num_afiliacion' => '9804001',
        'nombre' => 'División de Contaduría (UDG)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 3,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 5,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Tecnológica de Tabasco',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 6,
        'id_entidad' => 27,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 6,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Nuevo León',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => null,
        'personas_relacionadas' => 3,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UANL)
    [
        'id' => 7,
        'num_afiliacion' => '9802008',
        'nombre' => 'Facultad de Contaduría Pública y Administración (UANL)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => 6,
        'personas_relacionadas' => 3,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 8,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Iberoamericana Torreón',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 2,
        'id_entidad' => 8,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 9,
        'num_afiliacion' => null,
        'nombre' => 'Instituto Politécnico Nacional',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (IPN)
    [
        'id' => 10,
        'num_afiliacion' => '9807012',
        'nombre' => 'Escuela Superior de Comercio y Administración Unidad Tepepan (IPN)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 9,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 11,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Veracruzana',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 6,
        'id_entidad' => 30,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UV)
    [
        'id' => 12,
        'num_afiliacion' => '9806023',
        'nombre' => 'Facultad de Contaduría y Administración (UV)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 30,
        'id_universidad' => 11,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 13,
        'num_afiliacion' => null,
        'nombre' => 'Tecnológico de Monterrey',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 14,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Yucatán',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 6,
        'id_entidad' => 31,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UADY)
    [
        'id' => 15,
        'num_afiliacion' => '9806012',
        'nombre' => 'Facultad de Contaduría y Administración (UADY)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 31,
        'id_universidad' => 14,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 16,
        'num_afiliacion' => null,
        'nombre' => 'Benemérita Universidad Autónoma de Puebla',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 5,
        'id_entidad' => 21,
        'id_universidad' => null,
        'personas_relacionadas' => 3,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (BUAP)
    [
        'id' => 17,
        'num_afiliacion' => '9805002',
        'nombre' => 'Facultad de Contaduría Pública (BUAP)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 5,
        'id_entidad' => 21,
        'id_universidad' => 16,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 18,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Tlaxcala',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 5,
        'id_entidad' => 29,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 19,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de San Luis Potosí',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 3,
        'id_entidad' => 24,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UASLP)
    [
        'id' => 20,
        'num_afiliacion' => '9803007',
        'nombre' => 'Facultad de Contaduría y Administración (UASLP)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 3,
        'id_entidad' => 24,
        'id_universidad' => 19,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 21,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Aguascalientes',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 3,
        'id_entidad' => 1,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UAA)
    [
        'id' => 22,
        'num_afiliacion' => '9803004',
        'nombre' => 'Centro de Ciencias Económicas y Administrativas (UAA)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 3,
        'id_entidad' => 1,
        'id_universidad' => 21,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 23,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Tamaulipas',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 2,
        'id_entidad' => 28,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 24,
        'num_afiliacion' => null,
        'nombre' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (ITESO)
    [
        'id' => 25,
        'num_afiliacion' => '9804006',
        'nombre' => 'Escuela de Contaduría Pública (ITESO)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 24,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 26,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Sinaloa',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 1,
        'id_entidad' => 25,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UAS)
    [
        'id' => 27,
        'num_afiliacion' => '9801018',
        'nombre' => 'Facultad de Contaduría y Administración (UAS)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 25,
        'id_universidad' => 26,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 28,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Coahuila',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 2,
        'id_entidad' => 8,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 29,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Chihuahua',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 1,
        'id_entidad' => 6,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UACH)
    [
        'id' => 30,
        'num_afiliacion' => '9801017',
        'nombre' => 'Facultad de Contaduría y Administración (UACH)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 6,
        'id_universidad' => 29,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 31,
        'num_afiliacion' => null,
        'nombre' => 'Universidad del Valle de Atemajac',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 3,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UNIVA)
    [
        'id' => 32,
        'num_afiliacion' => '9804019',
        'nombre' => 'Dirección General Académica (UNIVA)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 31,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 33,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Intercontinental',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UNIVA Plantel Vallarta)
    [
        'id' => 34,
        'num_afiliacion' => '9804024',
        'nombre' => 'Departamento de Administración y Contaduría Plantel Vallarta (UNIVA)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 31,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UDG - Departamento de Mercadotécnia)
    [
        'id' => 35,
        'num_afiliacion' => '9804001',
        'nombre' => 'Departamento de Mercadotécnia y Negocios Internacionales (UDG)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 3,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 36,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Nayarit',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 4,
        'id_entidad' => 18,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UDG - Campus Altos)
    [
        'id' => 37,
        'num_afiliacion' => '9804014',
        'nombre' => 'Centro Universitario de los Altos (UDG)',
        'tipo' => 3,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 3,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 38,
        'num_afiliacion' => null,
        'nombre' => 'Universidad de Monterrey',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (BUAP - Facultad de Administración)
    [
        'id' => 39,
        'num_afiliacion' => '9805011',
        'nombre' => 'Facultad de Administración (BUAP)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 5,
        'id_entidad' => 21,
        'id_universidad' => 16,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 40,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Zacatecas',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 3,
        'id_entidad' => 32,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 41,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma del Estado de Hidalgo',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 5,
        'id_entidad' => 14,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (ITESO - Departamento)
    [
        'id' => 42,
        'num_afiliacion' => '9804005',
        'nombre' => 'Departamento de Economía, Administración y Finanzas (ITESO)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 24,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 43,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Autónoma de Guadalajara',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Afiliada (UAG)
    [
        'id' => 44,
        'num_afiliacion' => '9804007',
        'nombre' => 'Facultad de Administración (UAG)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 43,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Observadora
    [
        'id' => 45,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Juárez Autónoma de Tabasco',
        'tipo' => 1,
        'participacion' => 'observadora',
        'id_zona' => 6,
        'id_entidad' => 27,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    // Matriz
    [
        'id' => 46,
        'num_afiliacion' => null,
        'nombre' => 'Universidad de Sonora',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 1,
        'id_entidad' => 26,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ]
];

// Mezclar el orden de las instituciones para que no aparezcan agrupadas
shuffle($instituciones);
// Reasignar IDs después del shuffle para mantener consistencia
foreach ($instituciones as $index => &$inst) {
    $inst['id'] = $index + 1;
}
unset($inst);

// Calcular personas relacionadas para matrices (suma de sus asociadas)
foreach ($instituciones as &$inst) {
    if ($inst['participacion'] == 'matriz' && !empty($inst['instituciones_asociadas'])) {
        $total_personas = 0;
        foreach ($inst['instituciones_asociadas'] as $asociada_id) {
            foreach ($instituciones as $asociada) {
                if ($asociada['id'] == $asociada_id) {
                    $total_personas += $asociada['personas_relacionadas'];
                    break;
                }
            }
        }
        $inst['personas_relacionadas'] = $total_personas;
    }
}
unset($inst);

// Obtener nombres de universidades para mostrar
$universidades = array_filter($instituciones, function($i) {
    return $i['tipo'] == 1 && ($i['participacion'] == 'afiliada' || $i['participacion'] == 'matriz');
});
$universidades_nombres = [];
foreach ($universidades as $u) {
    $universidades_nombres[$u['id']] = $u['nombre'];
}

// Procesar filtros
$zona_filtro = isset($_GET['zona']) ? (int)$_GET['zona'] : 0;
$entidad_filtro = isset($_GET['entidad']) ? (int)$_GET['entidad'] : 0;
$participacion_filtro = isset($_GET['participacion']) ? $_GET['participacion'] : '';
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$anio_filtro = isset($_GET['anio']) ? (int)$_GET['anio'] : 0;
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : '';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'asc';

// Paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 10;

$instituciones_filtradas = $instituciones;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($busqueda) {
        return strpos(strtolower($i['nombre']), $busqueda) !== false ||
               strpos(strtolower($i['num_afiliacion'] ?? ''), $busqueda) !== false;
    });
}

if ($zona_filtro > 0) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($zona_filtro) {
        return $i['id_zona'] == $zona_filtro;
    });
}

if ($entidad_filtro > 0) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($entidad_filtro) {
        return $i['id_entidad'] == $entidad_filtro;
    });
}

if (!empty($participacion_filtro)) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($participacion_filtro) {
        return $i['participacion'] == $participacion_filtro;
    });
}

if ($estado_filtro == 'vigente') {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) {
        return $i['fecha_fin'] === null;
    });
} elseif ($estado_filtro == 'finalizada') {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) {
        return $i['fecha_fin'] !== null;
    });
}

if ($anio_filtro > 0) {
    $instituciones_filtradas = array_filter($instituciones_filtradas, function($i) use ($anio_filtro) {
        return (int)date('Y', strtotime($i['fecha_inicio'])) == $anio_filtro;
    });
}

// Ordenar
if (!empty($orden_columna)) {
    usort($instituciones_filtradas, function($a, $b) use ($orden_columna, $orden_direccion) {
        $valor_a = '';
        $valor_b = '';
        
        switch ($orden_columna) {
            case 'num_afiliacion':
                $valor_a = $a['num_afiliacion'] ?? '';
                $valor_b = $b['num_afiliacion'] ?? '';
                break;
            case 'nombre':
                $valor_a = $a['nombre'];
                $valor_b = $b['nombre'];
                break;
            case 'tipo':
                $valor_a = $a['tipo'];
                $valor_b = $b['tipo'];
                break;
            case 'zona':
                $valor_a = $a['id_zona'];
                $valor_b = $b['id_zona'];
                break;
            default:
                $valor_a = $a['id'];
                $valor_b = $b['id'];
        }
        
        if ($orden_direccion == 'asc') {
            return $valor_a <=> $valor_b;
        } else {
            return $valor_b <=> $valor_a;
        }
    });
}

// Calcular total de registros
$total_registros = count($instituciones_filtradas);
$total_paginas = ceil($total_registros / $registros_por_pagina);

if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

$offset = ($pagina_actual - 1) * $registros_por_pagina;
$instituciones_paginadas = array_slice($instituciones_filtradas, $offset, $registros_por_pagina);

// Obtener años disponibles para el filtro
$anios_disponibles = [];
foreach ($instituciones as $i) {
    $anio = (int)date('Y', strtotime($i['fecha_inicio']));
    if (!in_array($anio, $anios_disponibles)) {
        $anios_disponibles[] = $anio;
    }
}
sort($anios_disponibles);

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
                    <h1 class="page-title">Gestión de Instituciones</h1>
                    <p class="page-subtitle">Administre las instituciones educativas registradas en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <a href="institucion_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nueva Institución
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar por nombre o afiliación..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarInstitucion"
                               autocomplete="off">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Zona</label>
                        <select name="zona" class="filter-select" id="filtroZona">
                            <option value="0">Todas</option>
                            <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $zona_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Entidad</label>
                        <select name="entidad" class="filter-select" id="filtroEntidad">
                            <option value="0">Todas</option>
                            <?php foreach ($entidades_federativas as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $entidad_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Participación</label>
                        <select name="participacion" class="filter-select" id="filtroParticipacion">
                            <option value="">Todas</option>
                            <?php foreach ($tipos_participacion as $key => $nombre): ?>
                                <option value="<?= $key ?>" <?= $participacion_filtro == $key ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Año Registro</label>
                        <select name="anio" class="filter-select" id="filtroAnio">
                            <option value="0">Todos</option>
                            <?php foreach ($anios_disponibles as $anio): ?>
                                <option value="<?= $anio ?>" <?= $anio_filtro == $anio ? 'selected' : '' ?>>
                                    <?= $anio ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Estado</label>
                        <select name="estado" class="filter-select" id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="vigente" <?= $estado_filtro == 'vigente' ? 'selected' : '' ?>>Vigentes</option>
                            <option value="finalizada" <?= $estado_filtro == 'finalizada' ? 'selected' : '' ?>>Finalizadas</option>
                        </select>
                    </div>
                    
                    <a href="instituciones.php" class="btn-filter-clear <?= (empty($busqueda) && $zona_filtro == 0 && $entidad_filtro == 0 && empty($participacion_filtro) && empty($estado_filtro) && $anio_filtro == 0) ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-university"></i> 
                    <strong id="registrosMostrados"><?= count($instituciones_filtradas) ?></strong> 
                    institución(es) encontrada(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaInstituciones">
                    <thead>
                        <tr>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'num_afiliacion', 'orden_direccion' => ($orden_columna == 'num_afiliacion' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'num_afiliacion' ? 'active' : '' ?>">
                                    <span class="sort-label">Núm. Afiliación</span>
                                    <?php if ($orden_columna == 'num_afiliacion'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nombre', 'orden_direccion' => ($orden_columna == 'nombre' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'nombre' ? 'active' : '' ?>">
                                    <span class="sort-label">Institución</span>
                                    <?php if ($orden_columna == 'nombre'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'tipo', 'orden_direccion' => ($orden_columna == 'tipo' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'tipo' ? 'active' : '' ?>">
                                    <span class="sort-label">Tipo</span>
                                    <?php if ($orden_columna == 'tipo'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>Dependencia</th>
                            <th>Participación</th>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'zona', 'orden_direccion' => ($orden_columna == 'zona' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'zona' ? 'active' : '' ?>">
                                    <span class="sort-label">Zona</span>
                                    <?php if ($orden_columna == 'zona'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>Personas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyInstituciones">
                        <?php if (count($instituciones_paginadas) > 0): ?>
                            <?php foreach ($instituciones_paginadas as $institucion): 
                                $zona_nombre = $zonas_regionales[$institucion['id_zona']] ?? 'Sin zona';
                                $tipo_nombre = $tipos_institucion[$institucion['tipo']] ?? 'No definido';
                                $participacion_nombre = $tipos_participacion[$institucion['participacion']] ?? 'No definido';
                                $depende_de = '';
                                if ($institucion['tipo'] == 1) {
                                    $depende_de = '---';
                                } else {
                                    $depende_de = $universidades_nombres[$institucion['id_universidad']] ?? 'No especificado';
                                }
                                $estado = $institucion['fecha_fin'] === null ? 'Vigente' : 'Finalizada';
                                $estado_class = $institucion['fecha_fin'] === null ? 'status-active' : 'status-inactive';
                                $num_afiliacion = $institucion['num_afiliacion'] ?? '---';
                                $puede_eliminar = $institucion['personas_relacionadas'] == 0;
                                $personas_count = $institucion['personas_relacionadas'];
                            ?>
                            <tr data-id="<?= $institucion['id'] ?>" data-personas="<?= $personas_count ?>" 
                                data-es-matriz="<?= $institucion['participacion'] == 'matriz' ? 'true' : 'false' ?>">
                                <td>
                                    <?php if ($institucion['participacion'] == 'afiliada' && $num_afiliacion != '---'): ?>
                                        <span class="badge-afiliacion"><?= htmlspecialchars($num_afiliacion) ?></span>
                                    <?php elseif ($institucion['participacion'] == 'matriz'): ?>
                                        <span class="badge-afiliacion badge-matriz">No aplica</span>
                                    <?php else: ?>
                                        <span class="badge-afiliacion badge-observadora">---</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="institucion-cell">
                                        <div class="institucion-nombre"><?= htmlspecialchars($institucion['nombre']) ?></div>
                                        <?php if ($institucion['participacion'] == 'matriz'): ?>
                                            <span class="badge-matriz-label">Matriz</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($tipo_nombre) ?></td>
                                <td><?= htmlspecialchars($depende_de) ?></td>
                                <td>
                                    <span class="badge-participacion <?= 
                                        $institucion['participacion'] == 'afiliada' ? 'badge-afiliada' : 
                                        ($institucion['participacion'] == 'matriz' ? 'badge-matriz' : 'badge-observadora') 
                                    ?>">
                                        <?= htmlspecialchars($participacion_nombre) ?>
                                    </span>
                                </td>
                                <td><span class="badge-zona"><?= htmlspecialchars($zona_nombre) ?></span></td>
                                <td>
                                    <span class="badge-personas <?= $personas_count > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                                        <?= $personas_count ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= $estado_class ?>">
                                        <i class="fas fa-circle"></i> <?= $estado ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="institucion_consulta.php?id=<?= $institucion['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="institucion_edicion.php?id=<?= $institucion['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <?php if (!$puede_eliminar): ?>
                                            <button onclick="eliminarInstitucion(<?= $institucion['id'] ?>)" class="btn-accion btn-eliminar btn-eliminar-bloqueado" title="No se puede eliminar (tiene personas asociadas)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <button onclick="eliminarInstitucion(<?= $institucion['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="empty-row">
                                    <i class="fas fa-search"></i>
                                    <p>No se encontraron instituciones con los filtros aplicados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <?php if ($total_paginas > 1): ?>
            <div class="pagination-container">
                <div class="pagination-info">
                    Mostrando <strong><?= count($instituciones_paginadas) ?></strong> de <strong><?= $total_registros ?></strong> registros
                    <?php if ($total_paginas > 1): ?>
                        (Página <?= $pagina_actual ?> de <?= $total_paginas ?>)
                    <?php endif; ?>
                </div>
                <div class="pagination-controls">
                    <?php if ($pagina_actual > 1): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina_actual - 1])) ?>" class="pagination-btn">
                            <i class="fas fa-chevron-left"></i> Anterior
                        </a>
                    <?php else: ?>
                        <span class="pagination-btn disabled">
                            <i class="fas fa-chevron-left"></i> Anterior
                        </span>
                    <?php endif; ?>
                    
                    <?php
                    $rango = 2;
                    $inicio = max(1, $pagina_actual - $rango);
                    $fin = min($total_paginas, $pagina_actual + $rango);
                    
                    if ($inicio > 1) {
                        echo '<a href="?' . http_build_query(array_merge($_GET, ['pagina' => 1])) . '" class="pagination-num">1</a>';
                        if ($inicio > 2) echo '<span class="pagination-dots">...</span>';
                    }
                    
                    for ($i = $inicio; $i <= $fin; $i++) {
                        $active = $i == $pagina_actual ? 'active' : '';
                        echo '<a href="?' . http_build_query(array_merge($_GET, ['pagina' => $i])) . '" class="pagination-num ' . $active . '">' . $i . '</a>';
                    }
                    
                    if ($fin < $total_paginas) {
                        if ($fin < $total_paginas - 1) echo '<span class="pagination-dots">...</span>';
                        echo '<a href="?' . http_build_query(array_merge($_GET, ['pagina' => $total_paginas])) . '" class="pagination-num">' . $total_paginas . '</a>';
                    }
                    ?>
                    
                    <?php if ($pagina_actual < $total_paginas): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina_actual + 1])) ?>" class="pagination-btn">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <span class="pagination-btn disabled">
                            Siguiente <i class="fas fa-chevron-right"></i>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS MODERNOS - LISTADO INSTITUCIONES
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
    flex-wrap: wrap;
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

/* Filtros */
.filters-container {
    background: white;
    border-radius: 14px;
    padding: 1.25rem 1.75rem;
    margin-bottom: 1.75rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.filters-form {
    width: 100%;
}

.filters-row {
    display: flex;
    gap: 0.75rem;
    align-items: flex-end;
    flex-wrap: wrap;
}

.filter-group {
    position: relative;
    flex: 0 1 auto;
    min-width: 140px;
    max-width: 200px;
}

.filter-label {
    font-size: 0.65rem;
    font-weight: 600;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.15rem;
    display: block;
}

.filter-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #8B0000;
    font-size: 0.9rem;
    opacity: 0.5;
}

.filter-input {
    width: 100%;
    padding: 0.5rem 1rem 0.5rem 3rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #1a1a1a;
}

.filter-input:focus {
    outline: none;
    border-color: #8B0000;
    background: white;
    box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
}

.filter-select {
    width: 100%;
    padding: 0.5rem 1rem;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    background: #fafafa;
    color: #1a1a1a;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b6b6b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
}

.filter-select:focus {
    outline: none;
    border-color: #8B0000;
    background-color: white;
    box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.06);
}

.btn-filter-clear {
    padding: 0.5rem 1.25rem;
    background: transparent;
    color: #6b6b6b;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    white-space: nowrap;
}

.btn-filter-clear:hover {
    border-color: #c62828;
    color: #c62828;
}

.btn-filter-clear.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.filters-results {
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px solid #f0f0f0;
}

.results-count {
    font-size: 0.85rem;
    color: #6b6b6b;
}

.results-count i {
    color: #8B0000;
    margin-right: 0.3rem;
}

/* Tabla moderna */
.table-modern-container {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-modern-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
    min-width: 950px;
}

.table-modern thead {
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 0.8rem 1rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
    white-space: nowrap;
}

/* Sort links */
.sort-link {
    color: #6b6b6b;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    transition: color 0.2s ease;
    cursor: pointer;
    white-space: nowrap;
}

.sort-link .sort-label {
    display: inline-block;
}

.sort-link .sort-icon-inactive {
    color: #c0c0c0;
    font-size: 0.6rem;
}

.sort-link:hover {
    color: #8B0000;
}

.sort-link.active {
    color: #8B0000;
}

.sort-link.active .sort-icon-inactive {
    display: none;
}

.sort-link i {
    font-size: 0.6rem;
}

.table-modern tbody td {
    padding: 0.8rem 1rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

/* Badges */
.badge-afiliacion {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    background: #e8e0e0;
    color: #4a3a3a;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: monospace;
}

.badge-afiliacion.badge-matriz {
    background: #e3f2fd;
    color: #0d47a1;
    font-family: inherit;
    font-weight: 500;
}

.badge-afiliacion.badge-observadora {
    background: #f0ecec;
    color: #999;
    font-family: inherit;
    font-weight: 500;
}

.badge-matriz-label {
    display: inline-block;
    padding: 0.1rem 0.4rem;
    background: #e3f2fd;
    color: #0d47a1;
    border-radius: 4px;
    font-size: 0.6rem;
    font-weight: 600;
    margin-left: 0.4rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-zona {
    display: inline-block;
    padding: 0.25rem 0.9rem;
    background: #f0ebeb;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-participacion {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
}

.badge-afiliada {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-observadora {
    background: #fff3e0;
    color: #e65100;
}

.badge-matriz {
    background: #e3f2fd;
    color: #0d47a1;
}

.badge-personas {
    display: inline-block;
    padding: 0.25rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    min-width: 30px;
    text-align: center;
}

.badge-personas-activo {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-personas-vacio {
    background: #f5f5f5;
    color: #999;
}

/* Estados */
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

.institucion-nombre {
    font-weight: 600;
    color: #1a1a1a;
}

.institucion-cell {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.25rem;
}

/* Acciones */
.acciones-group {
    display: flex;
    gap: 0.35rem;
    flex-wrap: wrap;
}

.btn-accion {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
}

.btn-ver {
    background: #f0f7fa;
    color: #0d6efd;
}

.btn-ver:hover {
    background: #0d6efd;
    color: white;
}

.btn-editar {
    background: #f5edec;
    color: #8B0000;
}

.btn-editar:hover {
    background: #8B0000;
    color: white;
}

.btn-eliminar {
    background: #fce8e8;
    color: #dc3545;
}

.btn-eliminar:hover {
    background: #dc3545;
    color: white;
}

.btn-eliminar-bloqueado {
    opacity: 0.5;
    cursor: pointer !important;
}

.btn-eliminar-bloqueado:hover {
    background: #fce8e8 !important;
    color: #dc3545 !important;
}

/* Empty row */
.empty-row {
    text-align: center;
    padding: 3rem 0;
}

.empty-row i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-row p {
    color: #999;
    margin: 0;
    font-size: 0.95rem;
}

/* Paginación */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.8rem 1.25rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.pagination-info {
    font-size: 0.85rem;
    color: #6b6b6b;
}

.pagination-controls {
    display: flex;
    gap: 0.35rem;
    align-items: center;
    flex-wrap: wrap;
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.8rem;
    background: white;
    color: #4a4a4a;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.pagination-btn:hover:not(.disabled) {
    background: #f5edec;
    border-color: #8B0000;
    color: #8B0000;
}

.pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    color: #4a4a4a;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.pagination-num:hover:not(.active) {
    background: #f5edec;
    border-color: #e0d6d6;
}

.pagination-num.active {
    background: #8B0000;
    color: white;
    border-color: #8B0000;
}

.pagination-dots {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    color: #999;
    font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 992px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: auto;
        max-width: none;
    }

    .btn-filter-clear {
        width: 100%;
        justify-content: center;
    }
    
    .pagination-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
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

    .page-header-right .btn-primary-modern,
    .page-header-right .btn-outline-modern {
        width: 100%;
        justify-content: center;
    }

    .filters-container {
        padding: 1rem;
    }

    .table-modern {
        min-width: 750px;
        font-size: 0.8rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.5rem 0.6rem;
    }

    .btn-accion {
        width: 28px;
        height: 28px;
        font-size: 0.65rem;
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

    .table-modern {
        min-width: 650px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.4rem;
    }

    .badge-afiliacion {
        font-size: 0.65rem;
        padding: 0.1rem 0.4rem;
    }

    .badge-zona {
        font-size: 0.65rem;
        padding: 0.15rem 0.6rem;
    }

    .badge-personas {
        font-size: 0.7rem;
        padding: 0.15rem 0.6rem;
        min-width: 24px;
    }

    .btn-accion {
        width: 24px;
        height: 24px;
        font-size: 0.55rem;
        border-radius: 6px;
    }
}
</style>

<script>
// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarInstitucion');
    const filtroZona = document.getElementById('filtroZona');
    const filtroEntidad = document.getElementById('filtroEntidad');
    const filtroParticipacion = document.getElementById('filtroParticipacion');
    const filtroEstado = document.getElementById('filtroEstado');
    const filtroAnio = document.getElementById('filtroAnio');
    const formFiltros = document.getElementById('formFiltros');
    
    let timeoutId = null;
    
    if (buscarInput) {
        buscarInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(function() {
                formFiltros.submit();
            }, 500);
        });
    }
    
    if (filtroZona) {
        filtroZona.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroEntidad) {
        filtroEntidad.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroParticipacion) {
        filtroParticipacion.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroEstado) {
        filtroEstado.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroAnio) {
        filtroAnio.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
});

// ============================================================
// DATOS DE INSTITUCIONES
// ============================================================

const institucionesData = <?= json_encode($instituciones) ?>;
const tiposInstitucion = <?= json_encode($tipos_institucion) ?>;
const zonasRegionales = <?= json_encode($zonas_regionales) ?>;
const entidadesFederativas = <?= json_encode($entidades_federativas) ?>;
const tiposParticipacion = <?= json_encode($tipos_participacion) ?>;

// ============================================================
// ELIMINAR INSTITUCIÓN
// ============================================================

function eliminarInstitucion(id) {
    const institucion = institucionesData.find(i => i.id === id);
    if (!institucion) {
        mostrarMensaje('No se encontró la institución', 'error');
        return;
    }
    
    const tienePersonas = institucion.personas_relacionadas > 0;
    
    if (tienePersonas) {
        alert('No se puede eliminar esta institución porque tiene personas asociadas.');
        return;
    }
    
    if (confirm('¿Está seguro de eliminar la institución "' + institucion.nombre + '"? Esta acción no se puede deshacer.')) {
        const fila = document.querySelector(`tr[data-id="${id}"]`);
        if (fila) {
            fila.remove();
            actualizarContador();
            mostrarMensaje('Institución eliminada exitosamente', 'success');
        }
    }
}

function actualizarContador() {
    const registrosMostrados = document.getElementById('registrosMostrados');
    if (registrosMostrados) {
        const actual = parseInt(registrosMostrados.textContent);
        registrosMostrados.textContent = actual - 1;
    }
}

// ============================================================
// MENSAJES
// ============================================================

function mostrarMensaje(mensaje, tipo) {
    const div = document.createElement('div');
    div.className = `alert-modern alert-${tipo}`;
    div.style.cssText = `
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        background: ${tipo === 'success' ? '#f0f7f0' : '#fdf0f0'};
        color: ${tipo === 'success' ? '#1a5a1a' : '#7a1a1a'};
        border-left: 4px solid ${tipo === 'success' ? '#2e7d32' : '#c62828'};
    `;
    div.innerHTML = `
        <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}" style="font-size:1.25rem; color:${tipo === 'success' ? '#2e7d32' : '#c62828'};"></i>
        <div>
            <strong>${tipo === 'success' ? '¡Excelente!' : 'Por favor revise'}</strong> ${mensaje}
        </div>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:${tipo === 'success' ? '#1a5a1a' : '#7a1a1a'};margin-left:auto;">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    const container = document.querySelector('.filters-container');
    if (container) {
        container.parentNode.insertBefore(div, container);
    }
    
    setTimeout(function() {
        if (div.parentElement) {
            div.style.animation = 'fadeOut 0.3s ease';
            setTimeout(function() {
                div.remove();
            }, 300);
        }
    }, 5000);
}

// ============================================================
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    const datos = <?= json_encode(array_values($instituciones_filtradas)) ?>;
    
    if (datos.length === 0) {
        alert('No hay datos para exportar');
        return;
    }
    
    let csv = 'Núm. Afiliación,Institución,Tipo,Dependencia,Participación,Zona,Personas,Estado\n';
    
    const tiposInstitucion = <?= json_encode($tipos_institucion) ?>;
    const tiposParticipacion = <?= json_encode($tipos_participacion) ?>;
    const zonasRegionales = <?= json_encode($zonas_regionales) ?>;
    const universidadesNombres = <?= json_encode($universidades_nombres) ?>;
    
    datos.forEach(function(inst) {
        const zonaNombre = zonasRegionales[inst.id_zona] || 'Sin zona';
        const tipoNombre = tiposInstitucion[inst.tipo] || 'No definido';
        const participacionNombre = tiposParticipacion[inst.participacion] || 'No definido';
        let dependencia = '';
        if (inst.tipo == 1) {
            dependencia = '---';
        } else {
            dependencia = universidadesNombres[inst.id_universidad] || 'No especificado';
        }
        const estado = inst.fecha_fin === null ? 'Vigente' : 'Finalizada';
        const numAfiliacion = inst.num_afiliacion ?? '---';
        
        csv += `"${numAfiliacion}","${inst.nombre}","${tipoNombre}","${dependencia}","${participacionNombre}","${zonaNombre}","${inst.personas_relacionadas}","${estado}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `instituciones_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
}
</script>

<?php include 'template/footer.php'; ?>