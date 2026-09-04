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
    'observadora' => 'Observadora',
    'matriz' => 'Matriz'
];

// ============================================================
// INSTITUCIONES COMPLETAS (coincidiendo con instituciones.php)
// ============================================================

$instituciones = [
    // ============ MATRICES (Universidades) ============
    [
        'id' => 1,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Nacional Autónoma de México',
        'tipo' => 1,
        'participacion' => 'matriz',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 5,
        'fecha_inicio' => '2024-01-01',
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
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-02-01',
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
    ],
    [
        'id' => 19,
        'num_afiliacion' => '9807033',
        'nombre' => 'Tecnológico de Monterrey',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 20,
        'num_afiliacion' => null,
        'nombre' => 'Universidad Intercontinental',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 21,
        'num_afiliacion' => '9803004',
        'nombre' => 'Universidad Autónoma de Aguascalientes',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 3,
        'id_entidad' => 1,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 22,
        'num_afiliacion' => '9802020',
        'nombre' => 'Universidad Iberoamericana Torreón',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 8,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 23,
        'num_afiliacion' => '9803007',
        'nombre' => 'Universidad Autónoma de San Luis Potosí',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 3,
        'id_entidad' => 24,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 24,
        'num_afiliacion' => '9805012',
        'nombre' => 'Universidad Autónoma de Tlaxcala',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 5,
        'id_entidad' => 29,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 25,
        'num_afiliacion' => '9806001',
        'nombre' => 'Universidad Veracruzana',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 30,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 26,
        'num_afiliacion' => '9806018',
        'nombre' => 'Universidad Juárez Autónoma de Tabasco',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 27,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 27,
        'num_afiliacion' => '9802009',
        'nombre' => 'Universidad Autónoma de Tamaulipas',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 28,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 28,
        'num_afiliacion' => '1906067',
        'nombre' => 'Universidad Tecnológica de Tabasco',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 27,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 29,
        'num_afiliacion' => '9801017',
        'nombre' => 'Universidad Autónoma de Chihuahua',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 6,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 30,
        'num_afiliacion' => '9801020',
        'nombre' => 'Universidad de Sonora',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 26,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 31,
        'num_afiliacion' => '9804009',
        'nombre' => 'Universidad Autónoma de Nayarit',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 18,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 32,
        'num_afiliacion' => '9804005',
        'nombre' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 33,
        'num_afiliacion' => '9804007',
        'nombre' => 'Universidad Autónoma de Guadalajara',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 34,
        'num_afiliacion' => '9804014',
        'nombre' => 'Centro Universitario de los Altos (UDG)',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 35,
        'num_afiliacion' => '9804019',
        'nombre' => 'Universidad del Valle de Atemajac',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 36,
        'num_afiliacion' => '9802001',
        'nombre' => 'Universidad Autónoma de Coahuila',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 8,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 37,
        'num_afiliacion' => '9802016',
        'nombre' => 'Universidad de Monterrey',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => null,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 38,
        'num_afiliacion' => '9805002',
        'nombre' => 'Benemérita Universidad Autónoma de Puebla',
        'tipo' => 1,
        'participacion' => 'afiliada',
        'id_zona' => 5,
        'id_entidad' => 21,
        'id_universidad' => null,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],

    // ============ FACULTADES (con dependencia) ============
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
        'id' => 39,
        'num_afiliacion' => '9807033',
        'nombre' => 'ESCA Unidad Tepepan (IPN)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 3,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 40,
        'num_afiliacion' => '9802008',
        'nombre' => 'Facultad de Contaduría Pública y Administración (UANL)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => 9,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 41,
        'num_afiliacion' => '9801018',
        'nombre' => 'Facultad de Contaduría y Administración (UAS)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 1,
        'id_entidad' => 25,
        'id_universidad' => 17,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 42,
        'num_afiliacion' => '9806012',
        'nombre' => 'Facultad de Contaduría y Administración (UADY)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 31,
        'id_universidad' => 16,
        'personas_relacionadas' => 2,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 43,
        'num_afiliacion' => '9805011',
        'nombre' => 'Facultad de Administración (BUAP)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 5,
        'id_entidad' => 21,
        'id_universidad' => 38,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 44,
        'num_afiliacion' => '9805002',
        'nombre' => 'Facultad de Contaduría Pública (BUAP)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 5,
        'id_entidad' => 21,
        'id_universidad' => 38,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 45,
        'num_afiliacion' => '9806023',
        'nombre' => 'Facultad de Contaduría y Administración (UV)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 6,
        'id_entidad' => 30,
        'id_universidad' => 25,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 46,
        'num_afiliacion' => '9803004',
        'nombre' => 'Centro de Ciencias Económicas y Administrativas (UAA)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 3,
        'id_entidad' => 1,
        'id_universidad' => 21,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 47,
        'num_afiliacion' => '9804001',
        'nombre' => 'División de Contaduría (UDG)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 5,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 48,
        'num_afiliacion' => '9804009',
        'nombre' => 'Unidad Académica de Contaduría y Administración (UAN)',
        'tipo' => 2,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 18,
        'id_universidad' => 31,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],

    // ============ CAMPUS (con dependencia) ============
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
        'id' => 49,
        'num_afiliacion' => '9804005',
        'nombre' => 'Campus Guadalajara (ITESO)',
        'tipo' => 3,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 32,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ],
    [
        'id' => 50,
        'num_afiliacion' => '9804019',
        'nombre' => 'Campus Puerto Vallarta (UNIVA)',
        'tipo' => 3,
        'participacion' => 'afiliada',
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 35,
        'personas_relacionadas' => 1,
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null
    ]
];

// ============================================================
// DIRECCIONES (actualizadas para todas las instituciones)
// ============================================================

$direcciones = [
    1 => ['calle' => 'Avenida Universidad', 'numero_exterior' => '3000', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '04510', 'municipio' => 'Coyoacán'],
    2 => ['calle' => 'Circuito Exterior', 'numero_exterior' => 'S/N', 'numero_interior' => 'Edificio A', 'colonia' => 'Ciudad Universitaria', 'cp' => '04510', 'municipio' => 'Coyoacán'],
    3 => ['calle' => 'Avenida Instituto Politécnico Nacional', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Zacatenco', 'cp' => '07738', 'municipio' => 'Gustavo A. Madero'],
    4 => ['calle' => 'Avenida Instituto Politécnico Nacional', 'numero_exterior' => 'S/N', 'numero_interior' => 'Edificio 8', 'colonia' => 'Zacatenco', 'cp' => '07738', 'municipio' => 'Gustavo A. Madero'],
    5 => ['calle' => 'Avenida Juárez', 'numero_exterior' => '976', 'numero_interior' => '', 'colonia' => 'Centro', 'cp' => '44100', 'municipio' => 'Guadalajara'],
    6 => ['calle' => 'Periférico Norte', 'numero_exterior' => '799', 'numero_interior' => 'Int. 301', 'colonia' => 'Centro', 'cp' => '44100', 'municipio' => 'Guadalajara'],
    7 => ['calle' => 'Carretera Transpeninsular', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '21259', 'municipio' => 'Mexicali'],
    8 => ['calle' => 'Calzada Universidad', 'numero_exterior' => '14418', 'numero_interior' => '', 'colonia' => 'Internacional Tijuana', 'cp' => '22424', 'municipio' => 'Tijuana'],
    9 => ['calle' => 'Avenida Universidad', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '66450', 'municipio' => 'San Nicolás de los Garza'],
    10 => ['calle' => 'Avenida Universidad', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '66450', 'municipio' => 'San Nicolás de los Garza'],
    11 => ['calle' => 'Blv. Juan de Dios Batiz y 20 de Noviembre', 'numero_exterior' => 'S/N', 'numero_interior' => 'Apartado 766', 'colonia' => 'Del Parque', 'cp' => '81250', 'municipio' => 'Ahome'],
    12 => ['calle' => 'Blv. Cucapahcu', 'numero_exterior' => '20100', 'numero_interior' => '', 'colonia' => 'Fracc. Lago', 'cp' => '22100', 'municipio' => 'Tijuana'],
    13 => ['calle' => 'Calle Francisco Javier Mina', 'numero_exterior' => '1000', 'numero_interior' => '', 'colonia' => 'Zona Centro', 'cp' => '31000', 'municipio' => 'Chihuahua'],
    14 => ['calle' => 'Blv. Cucapahcu', 'numero_exterior' => '20100', 'numero_interior' => '', 'colonia' => 'Fracc. Lago', 'cp' => '22100', 'municipio' => 'Tijuana'],
    15 => ['calle' => 'Avenida Tecnológico', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '76010', 'municipio' => 'Querétaro'],
    16 => ['calle' => 'Calle 60', 'numero_exterior' => '491', 'numero_interior' => '', 'colonia' => 'Centro', 'cp' => '97160', 'municipio' => 'Mérida'],
    17 => ['calle' => 'Blvd. Universitarios y Avenida las Américas', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '80013', 'municipio' => 'Culiacán'],
    19 => ['calle' => 'Av. Eugenio Garza Sada', 'numero_exterior' => '2501', 'numero_interior' => '', 'colonia' => 'Tecnológico', 'cp' => '64849', 'municipio' => 'Monterrey'],
    20 => ['calle' => 'Insurgentes Sur', 'numero_exterior' => '4303', 'numero_interior' => '', 'colonia' => 'Col. Santa Úrsula Xitla', 'cp' => '14420', 'municipio' => 'Tlalpan'],
    21 => ['calle' => 'Avenida Universidad', 'numero_exterior' => '940', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '20100', 'municipio' => 'Aguascalientes'],
    22 => ['calle' => 'Boulevard Torreón', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Residencial las Haciendas', 'cp' => '27010', 'municipio' => 'Torreón'],
    23 => ['calle' => 'Avenida Venustiano Carranza', 'numero_exterior' => '2405', 'numero_interior' => '', 'colonia' => 'Zona Universitaria', 'cp' => '78290', 'municipio' => 'San Luis Potosí'],
    24 => ['calle' => 'Autopista Tlaxcala-Puebla', 'numero_exterior' => 'Km 1.5', 'numero_interior' => '', 'colonia' => 'Col. San José', 'cp' => '90000', 'municipio' => 'Tlaxcala'],
    25 => ['calle' => 'Lomas del Estadio', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Zona Universitaria', 'cp' => '91000', 'municipio' => 'Xalapa'],
    26 => ['calle' => 'Avenida Universidad', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Zona de la Cultura', 'cp' => '86000', 'municipio' => 'Villahermosa'],
    27 => ['calle' => 'Centro Universitario', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Victoria', 'cp' => '87000', 'municipio' => 'Ciudad Victoria'],
    28 => ['calle' => 'Carretera Villahermosa-Cárdenas', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'El Cuyo', 'cp' => '86000', 'municipio' => 'Villahermosa'],
    29 => ['calle' => 'Avenida de las Américas', 'numero_exterior' => '1010', 'numero_interior' => '', 'colonia' => 'Zona Centro', 'cp' => '31000', 'municipio' => 'Chihuahua'],
    30 => ['calle' => 'Rosales', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Zona Centro', 'cp' => '83000', 'municipio' => 'Hermosillo'],
    31 => ['calle' => 'Ciudad de la Cultura', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Cd. de la Cultura', 'cp' => '63000', 'municipio' => 'Tepic'],
    32 => ['calle' => 'Periférico Sur', 'numero_exterior' => '3130', 'numero_interior' => '', 'colonia' => 'Camino Real', 'cp' => '45010', 'municipio' => 'Guadalajara'],
    33 => ['calle' => 'Av. Patria', 'numero_exterior' => '1390', 'numero_interior' => '', 'colonia' => 'Jardines de Guadalupe', 'cp' => '45030', 'municipio' => 'Zapopan'],
    34 => ['calle' => 'Carretera Lagos de Moreno', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Los Altos', 'cp' => '47600', 'municipio' => 'Tepatitlán de Morelos'],
    35 => ['calle' => 'Av. Tepeyac', 'numero_exterior' => '4800', 'numero_interior' => '', 'colonia' => 'Monraz', 'cp' => '45000', 'municipio' => 'Guadalajara'],
    36 => ['calle' => 'Blvd. Fundadores', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '25000', 'municipio' => 'Saltillo'],
    37 => ['calle' => 'Av. Ignacio Morones Prieto', 'numero_exterior' => '4500', 'numero_interior' => '', 'colonia' => 'Cumbres', 'cp' => '64610', 'municipio' => 'San Pedro Garza García'],
    38 => ['calle' => 'Calle 4 Sur', 'numero_exterior' => '1106', 'numero_interior' => '', 'colonia' => 'Cuauhtémoc', 'cp' => '72420', 'municipio' => 'Puebla'],
    39 => ['calle' => 'Avenida Instituto Politécnico Nacional', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Zacatenco', 'cp' => '07738', 'municipio' => 'Gustavo A. Madero'],
    40 => ['calle' => 'Avenida Universidad', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '66450', 'municipio' => 'San Nicolás de los Garza'],
    41 => ['calle' => 'Blvd. Universitarios', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '80013', 'municipio' => 'Culiacán'],
    42 => ['calle' => 'Calle 60', 'numero_exterior' => '491', 'numero_interior' => '', 'colonia' => 'Centro', 'cp' => '97160', 'municipio' => 'Mérida'],
    43 => ['calle' => 'Calle 4 Sur', 'numero_exterior' => '1106', 'numero_interior' => '', 'colonia' => 'Cuauhtémoc', 'cp' => '72420', 'municipio' => 'Puebla'],
    44 => ['calle' => 'Calle 4 Sur', 'numero_exterior' => '1106', 'numero_interior' => '', 'colonia' => 'Cuauhtémoc', 'cp' => '72420', 'municipio' => 'Puebla'],
    45 => ['calle' => 'Lomas del Estadio', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Zona Universitaria', 'cp' => '91000', 'municipio' => 'Xalapa'],
    46 => ['calle' => 'Avenida Universidad', 'numero_exterior' => '940', 'numero_interior' => '', 'colonia' => 'Ciudad Universitaria', 'cp' => '20100', 'municipio' => 'Aguascalientes'],
    47 => ['calle' => 'Avenida Juárez', 'numero_exterior' => '976', 'numero_interior' => '', 'colonia' => 'Centro', 'cp' => '44100', 'municipio' => 'Guadalajara'],
    48 => ['calle' => 'Ciudad de la Cultura', 'numero_exterior' => 'S/N', 'numero_interior' => '', 'colonia' => 'Cd. de la Cultura', 'cp' => '63000', 'municipio' => 'Tepic'],
    49 => ['calle' => 'Periférico Sur', 'numero_exterior' => '3130', 'numero_interior' => '', 'colonia' => 'Camino Real', 'cp' => '45010', 'municipio' => 'Guadalajara'],
    50 => ['calle' => 'Av. Tepeyac', 'numero_exterior' => '4800', 'numero_interior' => '', 'colonia' => 'Monraz', 'cp' => '45000', 'municipio' => 'Guadalajara']
];

// ============================================================
// SITIOS WEB (actualizados)
// ============================================================

$sitios_web = [
    1 => ['https://www.unam.mx'],
    2 => ['https://www.fca.unam.mx'],
    3 => ['https://www.ipn.mx'],
    4 => ['https://www.escom.ipn.mx'],
    5 => ['https://www.udg.mx'],
    6 => ['https://www.cucea.udg.mx'],
    7 => ['https://www.uabc.mx'],
    8 => ['https://www.uabc.mx/planteles/mexicali'],
    9 => ['https://www.uanl.mx'],
    10 => ['https://www.uanl.mx/campus-san-nicolas'],
    11 => ['https://www.itmochis.edu.mx'],
    12 => ['https://www.cesun.mx'],
    13 => ['https://www.iesch.edu.mx'],
    14 => ['https://www.cesun.mx/administrativas'],
    15 => ['https://www.uaq.mx'],
    16 => ['https://www.uady.mx'],
    17 => ['https://www.uas.edu.mx'],
    19 => ['https://www.tec.mx'],
    20 => ['https://www.uic.edu.mx'],
    21 => ['https://www.uaa.mx'],
    22 => ['https://www.iberotorreon.edu.mx'],
    23 => ['https://www.uaslp.mx'],
    24 => ['https://www.uatx.mx'],
    25 => ['https://www.uv.mx'],
    26 => ['https://www.ujat.mx'],
    27 => ['https://www.uat.edu.mx'],
    28 => ['https://www.utdt.mx'],
    29 => ['https://www.uach.mx'],
    30 => ['https://www.unison.mx'],
    31 => ['https://www.uan.mx'],
    32 => ['https://www.iteso.mx'],
    33 => ['https://www.uag.mx'],
    34 => ['https://www.cualtos.udg.mx'],
    35 => ['https://www.univa.mx'],
    36 => ['https://www.uadec.mx'],
    37 => ['https://www.udem.edu.mx'],
    38 => ['https://www.buap.mx'],
    39 => ['https://www.esca.ipn.mx'],
    40 => ['https://www.fcpya.uanl.mx'],
    41 => ['https://www.fca.uas.edu.mx'],
    42 => ['https://www.fca.uady.mx'],
    43 => ['https://www.fa.buap.mx'],
    44 => ['https://www.fcp.buap.mx'],
    45 => ['https://www.fca.uv.mx'],
    46 => ['https://www.ccea.uaa.mx'],
    47 => ['https://www.cucea.udg.mx/contaduria'],
    48 => ['https://www.uan.edu.mx/contaduria'],
    49 => ['https://www.iteso.mx/guadalajara'],
    50 => ['https://www.univa.mx/puerto-vallarta']
];

// ============================================================
// PERSONAS ASOCIADAS
// ============================================================

$personas_asociadas = [
    2 => [
        ['id' => 1, 'nombre' => 'María González Pérez', 'cargo' => 'Presidenta', 'titular' => true, 'fecha_inicio' => '2024-01-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'cargo' => 'Coordinador Nacional', 'titular' => false, 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 16, 'nombre' => 'Fernando Cruz Salazar', 'cargo' => 'Secretario Técnico General', 'titular' => false, 'fecha_inicio' => '2023-08-01', 'fecha_fin' => '2024-07-31', 'activo' => false]
    ],
    4 => [
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'cargo' => 'Coordinador Nacional', 'titular' => true, 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 4, 'nombre' => 'Carlos Hernández Díaz', 'cargo' => 'Director Regional', 'titular' => false, 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null, 'activo' => true]
    ],
    5 => [
        ['id' => 3, 'nombre' => 'Ana Sánchez Ramírez', 'cargo' => 'Secretaria General', 'titular' => true, 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null, 'activo' => true]
    ],
    6 => [
        ['id' => 3, 'nombre' => 'Ana Sánchez Ramírez', 'cargo' => 'Secretaria General', 'titular' => true, 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true]
    ],
    7 => [
        ['id' => 5, 'nombre' => 'Laura Torres Vega', 'cargo' => 'Coordinadora Regional', 'titular' => true, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 10, 'nombre' => 'Luis Méndez Vargas', 'cargo' => 'Secretario Técnico', 'titular' => false, 'fecha_inicio' => '2024-04-10', 'fecha_fin' => null, 'activo' => true]
    ],
    8 => [
        ['id' => 5, 'nombre' => 'Laura Torres Vega', 'cargo' => 'Coordinadora Regional', 'titular' => true, 'fecha_inicio' => '2024-04-15', 'fecha_fin' => null, 'activo' => true]
    ],
    11 => [
        ['id' => 9, 'nombre' => 'Carmen Rivera Morales', 'cargo' => 'Coordinadora Académica', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    13 => [
        ['id' => 6, 'nombre' => 'Roberto Mendoza Cruz', 'cargo' => 'Secretario Regional', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    14 => [
        ['id' => 6, 'nombre' => 'Roberto Mendoza Cruz', 'cargo' => 'Secretario Regional', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    17 => [
        ['id' => 8, 'nombre' => 'Jorge Gómez García', 'cargo' => 'Director Académico', 'titular' => true, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true]
    ],
    39 => [
        ['id' => 16, 'nombre' => 'Ivett Guillén Morales', 'cargo' => 'Coordinador Nacional de Investigación', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    40 => [
        ['id' => 2, 'nombre' => 'Adriana Garza Elizondo', 'cargo' => 'Vicepresidenta', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 28, 'nombre' => 'Mónica Blanco Jiménez', 'cargo' => 'Coordinador Regional Zona 2 de Certificación Académica', 'titular' => false, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    41 => [
        ['id' => 5, 'nombre' => 'Leobardo Berrelleza Reyes', 'cargo' => 'Director Regional Zona 1', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    42 => [
        ['id' => 12, 'nombre' => 'David Roberto Suárez Pacheco', 'cargo' => 'Coordinador Nacional de Certificación Académica', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 19, 'nombre' => 'Aureliano Martínez Castillo', 'cargo' => 'Coordinador Nacional de Historia', 'titular' => false, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    43 => [
        ['id' => 31, 'nombre' => 'Emigdio Larios Gómez', 'cargo' => 'Coordinador Regional Zona 5 de Posgrado', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    44 => [
        ['id' => 23, 'nombre' => 'María Antonieta Monserrat Vera Muñoz', 'cargo' => 'Coordinador Nacional de Responsabilidad Social Universitaria', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    45 => [
        ['id' => 10, 'nombre' => 'Anabel Galván Sarabia', 'cargo' => 'Directora Regional Zona 6', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    46 => [
        ['id' => 7, 'nombre' => 'Ismael Manuel Rodríguez Herrera', 'cargo' => 'Director Regional Zona 3', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    47 => [
        ['id' => 8, 'nombre' => 'Cristian Omar Alcantar López', 'cargo' => 'Director Regional Zona 4', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    48 => [
        ['id' => 25, 'nombre' => 'Idi Amin Germán Silva Jug', 'cargo' => 'Coordinador Nacional de Desarrollo Académico Estudiantil', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    49 => [
        ['id' => 33, 'nombre' => 'Luis Edmundo Garrido Sánchez', 'cargo' => 'Jefe de Departamento', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ],
    50 => [
        ['id' => 38, 'nombre' => 'María Guadalupe Jiménez Hernández', 'cargo' => 'Director General de Plantel', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true]
    ]
];

// ============================================================
// FUNCIONES AUXILIARES
// ============================================================

function getInstitucionPorId($id) {
    global $instituciones;
    foreach ($instituciones as $i) {
        if ($i['id'] == $id) {
            return $i;
        }
    }
    return null;
}

function getDependenciasDe($id) {
    global $instituciones;
    $dependencias = [];
    foreach ($instituciones as $i) {
        if ($i['id_universidad'] == $id) {
            $dependencias[] = $i;
        }
    }
    return $dependencias;
}

// ============================================================
// BUSCAR LA INSTITUCIÓN
// ============================================================

$institucion = getInstitucionPorId($id);

if (!$institucion) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró la institución solicitada.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// ============================================================
// OBTENER DATOS ADICIONALES
// ============================================================

$zona_nombre = $zonas_regionales[$institucion['id_zona']] ?? 'Sin zona';
$zona_numero = explode(' - ', $zona_nombre)[0] ?? '?';
$tipo_nombre = $tipos_institucion[$institucion['tipo']] ?? 'No definido';
$entidad_nombre = $entidades_federativas[$institucion['id_entidad']] ?? 'Sin entidad';
$participacion_nombre = $tipos_participacion[$institucion['participacion']] ?? 'No definido';
$estado = $institucion['fecha_fin'] === null ? 'Vigente' : 'Finalizada';
$es_matriz = $institucion['participacion'] == 'matriz';

// Número de afiliación
$num_afiliacion_mostrar = '---';
if ($es_matriz) {
    $num_afiliacion_mostrar = 'No aplica';
} elseif ($institucion['num_afiliacion']) {
    $num_afiliacion_mostrar = $institucion['num_afiliacion'];
}

// Obtener dependencia
$dependencia = '';
$dependencia_id = null;
if ($institucion['tipo'] != 1 && $institucion['id_universidad']) {
    $dependencia_obj = getInstitucionPorId($institucion['id_universidad']);
    if ($dependencia_obj) {
        $dependencia = $dependencia_obj['nombre'];
        $dependencia_id = $dependencia_obj['id'];
    }
}

// Si es matriz, obtener instituciones asociadas
$instituciones_asociadas = [];
if ($es_matriz) {
    $instituciones_asociadas = getDependenciasDe($institucion['id']);
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
                                <span class="afiliacion-value <?= $es_matriz ? 'afiliacion-no-aplica' : '' ?>">
                                    <?= htmlspecialchars($num_afiliacion_mostrar) ?>
                                </span>
                            </span>
                            <span class="profile-status <?= $estado == 'Vigente' ? 'status-active' : 'status-inactive' ?>">
                                <span class="status-dot"></span> <?= $estado ?>
                            </span>
                            <span class="profile-participacion <?= 
                                $institucion['participacion'] == 'afiliada' ? 'badge-afiliada' : 
                                ($institucion['participacion'] == 'matriz' ? 'badge-matriz' : 'badge-observadora') 
                            ?>">
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
                                <span class="dependencia-na"><?= $es_matriz ? 'Es matriz' : '---' ?></span>
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
                    <div class="profile-item">
                        <span class="profile-label">Personas asociadas</span>
                        <span class="profile-value">
                            <span class="badge-personas <?= $institucion['personas_relacionadas'] > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                                <?= $institucion['personas_relacionadas'] ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <?php if ($es_matriz): ?>
                <!-- Instituciones asociadas (solo para Matriz) -->
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h3>Instituciones asociadas</h3>
                        <span class="detail-badge"><?= count($instituciones_asociadas) ?> institución(es)</span>
                    </div>
                    <div class="detail-card-body">
                        <?php if (count($instituciones_asociadas) > 0): ?>
                            <div class="table-modern-container">
                                <div class="table-modern-wrapper">
                                    <table class="table-modern">
                                        <thead>
                                            <tr>
                                                <th>Institución</th>
                                                <th>Tipo</th>
                                                <th>Participación</th>
                                                <th>Zona</th>
                                                <th>Personas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($instituciones_asociadas as $asociada): 
                                                $tipo_asociada = $tipos_institucion[$asociada['tipo']] ?? 'No definido';
                                                $participacion_asociada = $tipos_participacion[$asociada['participacion']] ?? 'No definido';
                                                $zona_asociada = $zonas_regionales[$asociada['id_zona']] ?? 'Sin zona';
                                                $personas_count = $asociada['personas_relacionadas'] ?? 0;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <a href="institucion_consulta.php?id=<?= $asociada['id'] ?>" class="institucion-link">
                                                            <?= htmlspecialchars($asociada['nombre']) ?>
                                                        </a>
                                                    </td>
                                                    <td><?= htmlspecialchars($tipo_asociada) ?></td>
                                                    <td>
                                                        <span class="badge-participacion <?= 
                                                            $asociada['participacion'] == 'afiliada' ? 'badge-afiliada' : 
                                                            ($asociada['participacion'] == 'matriz' ? 'badge-matriz' : 'badge-observadora') 
                                                        ?>">
                                                            <?= htmlspecialchars($participacion_asociada) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-zona"><?= htmlspecialchars($zona_asociada) ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge-personas <?= $personas_count > 0 ? 'badge-personas-activo' : 'badge-personas-vacio' ?>">
                                                            <?= $personas_count ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="empty-instituciones">
                                <i class="fas fa-university"></i>
                                <p>Esta institución matriz no tiene facultades o campus asociados</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

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
            <?php if (count($personas) > 0): ?>
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Personas asociadas</h3>
                    <span class="detail-badge"><?= count($personas) ?> persona(s)</span>
                </div>
                <div class="detail-card-body">
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
                                            <td>
                                                <a href="persona_consulta.php?id=<?= $persona['id'] ?>" class="persona-link">
                                                    <?= htmlspecialchars($persona['nombre']) ?>
                                                </a>
                                            </td>
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
                </div>
            </div>
            <?php endif; ?>

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

.afiliacion-value.afiliacion-no-aplica {
    color: #999;
    font-family: inherit;
    background: transparent;
    font-weight: 500;
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

.profile-participacion.badge-matriz {
    background: #e3f2fd;
    color: #0d47a1;
}

.profile-body {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
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

.dependencia-na {
    color: #999;
}

/* Institución link */
.institucion-link {
    color: #8B0000;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.institucion-link:hover {
    color: #5C0000;
    text-decoration: underline;
}

/* Persona link */
.persona-link {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.persona-link:hover {
    color: #0a58ca;
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

/* Badge Participación en tabla */
.badge-participacion {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
}

.badge-participacion.badge-afiliada {
    background: #e8f5e9;
    color: #2e7d32;
}

.badge-participacion.badge-observadora {
    background: #fff3e0;
    color: #e65100;
}

.badge-participacion.badge-matriz {
    background: #e3f2fd;
    color: #0d47a1;
}

/* Badge Personas */
.badge-personas {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
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

/* Empty states */
.empty-instituciones {
    text-align: center;
    padding: 2rem 0;
}

.empty-instituciones i {
    font-size: 2.5rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 0.75rem;
}

.empty-instituciones p {
    color: #999;
    margin: 0;
    font-size: 0.95rem;
}

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
@media (max-width: 992px) {
    .profile-body {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .direccion-grid {
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