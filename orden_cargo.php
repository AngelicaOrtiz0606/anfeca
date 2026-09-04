<?php
// ============================================================
// SIDEANFECA - Orden de Cargos por Directorio
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS (BASADOS EN DIRECTORIOS.PHP)
// ============================================================

$tipos_directorio = [
    1 => 'Consejo Nacional Directivo',
    2 => 'Coordinaciones Regionales',
    3 => 'Coordinaciones Nacionales',
    4 => 'Instituciones'
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

// ============================================================
// PERSONAS CON SUS CARGOS (basado en directorios.php)
// ============================================================

$personas = [
    // ============ CND - Consejo Nacional Directivo ============
    [
        'id' => 1,
        'nombre' => 'Armando Tomé González',
        'genero' => 'M',
        'id_zona' => 7,
        'institucion' => 'Universidad Nacional Autónoma de México - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Presidente',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 2,
        'nombre' => 'Adriana Garza Elizondo',
        'genero' => 'F',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Nuevo León - Facultad de Contaduría Pública y Administración',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Vicepresidenta',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 3,
        'nombre' => 'Carlos Lobo Sánchez',
        'genero' => 'M',
        'id_zona' => 7,
        'institucion' => 'Universidad Nacional Autónoma de México - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Secretario General',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 4,
        'nombre' => 'Lourdes Mata Romero',
        'genero' => 'F',
        'id_zona' => 7,
        'institucion' => 'Universidad Nacional Autónoma de México - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Directora Ejecutiva',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 5,
        'nombre' => 'Leobardo Berrelleza Reyes',
        'genero' => 'M',
        'id_zona' => 1,
        'institucion' => 'Universidad Autónoma de Sinaloa - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Director Regional Zona 1',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 1,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 6,
        'nombre' => 'Laura María del Pilar Macías Amozurrutia',
        'genero' => 'F',
        'id_zona' => 2,
        'institucion' => 'Universidad Iberoamericana Torreón - Departamento de Negocios',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Directora Regional Zona 2',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 2,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 7,
        'nombre' => 'Ismael Manuel Rodríguez Herrera',
        'genero' => 'M',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de Aguascalientes - Centro de Ciencias Económicas y Administrativas',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Director Regional Zona 3',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 3,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 8,
        'nombre' => 'Cristian Omar Alcantar López',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara - División de Contaduría',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Director Regional Zona 4',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 4,
                'coordinacion' => null
            ],
            [
                'nivel' => 3,
                'nombre' => 'Director de División',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 9,
        'nombre' => 'Mario Franz Subieta Zecua',
        'genero' => 'M',
        'id_zona' => 5,
        'institucion' => 'Universidad Autónoma de Tlaxcala - Facultad de Ciencias Económico Administrativas',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Director Regional Zona 5',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 5,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 10,
        'nombre' => 'Anabel Galván Sarabia',
        'genero' => 'F',
        'id_zona' => 6,
        'institucion' => 'Universidad Veracruzana - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Directora Regional Zona 6',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 6,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 11,
        'nombre' => 'Giannina Sampieri Laguna',
        'genero' => 'F',
        'id_zona' => 7,
        'institucion' => 'Universidad Intercontinental - División de Negocios',
        'cargos' => [
            [
                'nivel' => 1,
                'nombre' => 'Directora Regional Zona 7',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1, 2],
                'zona' => 7,
                'coordinacion' => null
            ]
        ]
    ],

    // ============ COORDINACIONES NACIONALES ============
    [
        'id' => 12,
        'nombre' => 'David Roberto Suárez Pacheco',
        'genero' => 'M',
        'id_zona' => 6,
        'institucion' => 'Universidad Autónoma de Yucatán - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Certificación Académica',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 1
            ]
        ]
    ],
    [
        'id' => 13,
        'nombre' => 'José Juan Paz Reyes',
        'genero' => 'M',
        'id_zona' => 6,
        'institucion' => 'Universidad Juárez Autónoma de Tabasco - División Académica de Ciencias Económico Administrativas',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de la Academia ANFECA',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 2
            ]
        ]
    ],
    [
        'id' => 14,
        'nombre' => 'Mónica Sánchez Limón',
        'genero' => 'F',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Tamaulipas - Facultad de Comercio y Administración Victoria',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Emprendimiento Social',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 3
            ]
        ]
    ],
    [
        'id' => 15,
        'nombre' => 'Lenin Martínez Pérez',
        'genero' => 'M',
        'id_zona' => 6,
        'institucion' => 'Universidad Tecnológica de Tabasco',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Planes y Programas de Estudio',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 4
            ]
        ]
    ],
    [
        'id' => 16,
        'nombre' => 'Ivett Guillén Morales',
        'genero' => 'F',
        'id_zona' => 7,
        'institucion' => 'Instituto Politécnico Nacional - Escuela Superior de Comercio y Administración Unidad Tepepan',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Investigación',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 5
            ]
        ]
    ],
    [
        'id' => 17,
        'nombre' => 'José Ernesto Amorós Espinosa',
        'genero' => 'M',
        'id_zona' => 7,
        'institucion' => 'Tecnológico de Monterrey - División de Negocios Campus Ciudad de México',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Posgrado',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 6
            ]
        ]
    ],
    [
        'id' => 18,
        'nombre' => 'Cristina Cabrera Ramos',
        'genero' => 'F',
        'id_zona' => 1,
        'institucion' => 'Universidad Autónoma de Chihuahua - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Maratones',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 7
            ]
        ]
    ],
    [
        'id' => 19,
        'nombre' => 'Aureliano Martínez Castillo',
        'genero' => 'M',
        'id_zona' => 6,
        'institucion' => 'Universidad Autónoma de Yucatán - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Historia',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 8
            ]
        ]
    ],
    [
        'id' => 20,
        'nombre' => 'Juan Antonio Zapata Zapata',
        'genero' => 'M',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de San Luis Potosí - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Vinculación Nacional e Internacional',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 9
            ]
        ]
    ],
    [
        'id' => 21,
        'nombre' => 'Laura Ofelia Robles Sahagún',
        'genero' => 'F',
        'id_zona' => 4,
        'institucion' => 'Universidad del Valle de Atemajac - Campus Puerto Vallarta',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Universidad Empresa',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 10
            ]
        ]
    ],
    [
        'id' => 22,
        'nombre' => 'Cecilia Morales del Río',
        'genero' => 'F',
        'id_zona' => 2,
        'institucion' => 'Universidad de Monterrey - División de Negocios',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Formación Profesional y Académica',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 11
            ]
        ]
    ],
    [
        'id' => 23,
        'nombre' => 'María Antonieta Monserrat Vera Muñoz',
        'genero' => 'F',
        'id_zona' => 5,
        'institucion' => 'Benemérita Universidad Autónoma de Puebla - Facultad de Contaduría Pública',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Responsabilidad Social Universitaria',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 12
            ]
        ]
    ],
    [
        'id' => 24,
        'nombre' => 'Lorena Argentina Medina Bocanegra',
        'genero' => 'F',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Coahuila - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Igualdad de Género',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 13
            ]
        ]
    ],
    [
        'id' => 25,
        'nombre' => 'Idi Amin Germán Silva Jug',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'Universidad Autónoma de Nayarit - Unidad Académica de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Nacional de Desarrollo Académico Estudiantil',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 14
            ]
        ]
    ],

    // ============ COORDINADORES REGIONALES ============
    [
        'id' => 26,
        'nombre' => 'Leticia María González Velásquez',
        'genero' => 'F',
        'id_zona' => 1,
        'institucion' => 'Universidad de Sonora - División de Ciencias Económicas y Sociales',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Regional Zona 1 de Certificación Académica',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 1,
                'coordinacion' => 1
            ]
        ]
    ],
    [
        'id' => 27,
        'nombre' => 'Patricia Hernández García',
        'genero' => 'F',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de San Luis Potosí - Facultad de Contaduría y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Regional Zona 3 de Certificación Académica',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 3,
                'coordinacion' => 1
            ]
        ]
    ],
    [
        'id' => 28,
        'nombre' => 'Mónica Blanco Jiménez',
        'genero' => 'F',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Nuevo León - Facultad de Contaduría Pública y Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Regional Zona 2 de Certificación Académica',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 2,
                'coordinacion' => 1
            ]
        ]
    ],
    [
        'id' => 29,
        'nombre' => 'José Sánchez Gutiérrez',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara - Departamento de Mercadotécnia y Negocios Internacionales',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Regional Zona 4 de Investigación',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 4,
                'coordinacion' => 5
            ]
        ]
    ],
    [
        'id' => 30,
        'nombre' => 'Alfonso Martin Rodríguez',
        'genero' => 'M',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de Aguascalientes - Centro de Ciencias Económicas y Administrativas',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Regional Zona 3 de Responsabilidad Social Universitaria',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 3,
                'coordinacion' => 12
            ]
        ]
    ],
    [
        'id' => 31,
        'nombre' => 'Emigdio Larios Gómez',
        'genero' => 'M',
        'id_zona' => 5,
        'institucion' => 'Benemérita Universidad Autónoma de Puebla - Facultad de Administración',
        'cargos' => [
            [
                'nivel' => 2,
                'nombre' => 'Coordinador Regional Zona 5 de Posgrado',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 5,
                'coordinacion' => 6
            ]
        ]
    ],

    // ============ INSTITUCIONES ============
    [
        'id' => 33,
        'nombre' => 'Luis Edmundo Garrido Sánchez',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente - Departamento de Economía, Administración y Finanzas',
        'cargos' => [
            [
                'nivel' => 3,
                'nombre' => 'Jefe de Departamento',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 34,
        'nombre' => 'Maria Margarita Villareal Treviño',
        'genero' => 'F',
        'id_zona' => 4,
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente - Escuela de Contaduría Pública',
        'cargos' => [
            [
                'nivel' => 3,
                'nombre' => 'Directora',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 35,
        'nombre' => 'Esmeralda Brito Cervantes',
        'genero' => 'F',
        'id_zona' => 4,
        'institucion' => 'Universidad Autónoma de Guadalajara - Facultad de Administración',
        'cargos' => [
            [
                'nivel' => 3,
                'nombre' => 'Directora del Programa de Administración',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 36,
        'nombre' => 'Nadia Natasha Reus González',
        'genero' => 'F',
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara - Centro Universitario de los Altos',
        'cargos' => [
            [
                'nivel' => 3,
                'nombre' => 'Secretario de la División de Ciencias Sociales y de la Cultura',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 37,
        'nombre' => 'Salvador Cervantes Cervantes',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'Universidad del Valle de Atemajac - Dirección General Académica',
        'cargos' => [
            [
                'nivel' => 3,
                'nombre' => 'Director General Académico',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ],
    [
        'id' => 38,
        'nombre' => 'María Guadalupe Jiménez Hernández',
        'genero' => 'F',
        'id_zona' => 4,
        'institucion' => 'Universidad del Valle de Atemajac - Departamento de Administración y Contaduría Plantel Vallarta',
        'cargos' => [
            [
                'nivel' => 3,
                'nombre' => 'Director General de Plantel',
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null
            ]
        ]
    ]
];

// ============================================================
// FUNCIÓN PARA VERIFICAR SI UN CARGO ESTÁ ACTIVO
// ============================================================

function cargoActivo($cargo) {
    if ($cargo['fecha_fin'] !== null && strtotime($cargo['fecha_fin']) < time()) {
        return false;
    }
    return true;
}

// ============================================================
// PROCESAR FILTROS
// ============================================================

$directorio_seleccionado = isset($_GET['directorio']) ? (int)$_GET['directorio'] : 1;

$cargos_ordenables = [];

foreach ($personas as $persona) {
    foreach ($persona['cargos'] as $cargo) {
        if (!in_array($directorio_seleccionado, $cargo['directorios'])) {
            continue;
        }
        
        if (!cargoActivo($cargo)) {
            continue;
        }
        
        $nombre_cargo = $cargo['nombre'];
        if ($cargo['zona'] !== null && isset($zonas_regionales[$cargo['zona']])) {
            $nombre_cargo .= ' - ' . $zonas_regionales[$cargo['zona']];
        }
        
        $nivel_cargo = '';
        if ($cargo['nivel'] == 1) $nivel_cargo = 'Nacional';
        elseif ($cargo['nivel'] == 2) $nivel_cargo = 'Regional';
        elseif ($cargo['nivel'] == 3) $nivel_cargo = 'Institucional';
        
        $cargos_ordenables[] = [
            'persona_id' => $persona['id'],
            'persona_nombre' => $persona['nombre'],
            'cargo_nombre' => $cargo['nombre'],
            'cargo_completo' => $nombre_cargo,
            'nivel' => $nivel_cargo,
            'institucion' => $persona['institucion'],
            'fecha_inicio' => $cargo['fecha_inicio'],
            'fecha_fin' => $cargo['fecha_fin'] ?? 'Actual',
            'id_unico' => $persona['id'] . '_' . md5($cargo['nombre'] . $cargo['fecha_inicio'])
        ];
    }
}

$no_cargos = empty($cargos_ordenables);

// ============================================================
// GUARDAR ORDEN (vía POST)
// ============================================================

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'guardar_orden') {
    $orden = isset($_POST['orden']) ? json_decode($_POST['orden'], true) : [];
    
    if (!isset($_SESSION['orden_cargos'])) {
        $_SESSION['orden_cargos'] = [];
    }
    
    $_SESSION['orden_cargos'][$directorio_seleccionado] = $orden;
    $mensaje = 'Orden guardado exitosamente';
}

$orden_guardado = [];
if (isset($_SESSION['orden_cargos'][$directorio_seleccionado])) {
    $orden_guardado = $_SESSION['orden_cargos'][$directorio_seleccionado];
}

if (!empty($orden_guardado)) {
    $cargos_ordenados = [];
    foreach ($orden_guardado as $id_unico) {
        foreach ($cargos_ordenables as $cargo) {
            if ($cargo['id_unico'] == $id_unico) {
                $cargos_ordenados[] = $cargo;
                break;
            }
        }
    }
    foreach ($cargos_ordenables as $cargo) {
        $existe = false;
        foreach ($cargos_ordenados as $c) {
            if ($c['id_unico'] == $cargo['id_unico']) {
                $existe = true;
                break;
            }
        }
        if (!$existe) {
            $cargos_ordenados[] = $cargo;
        }
    }
    $cargos_ordenables = $cargos_ordenados;
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
                    <i class="fas fa-sort-amount-down-alt"></i>
                </div>
                <div>
                    <h1 class="page-title">Ordenar Cargos</h1>
                    <p class="page-subtitle">Arrastre los cargos para definir el orden en que aparecerán en los directorios</p>
                </div>
            </div>
        </div>

        <?php if (isset($mensaje)): ?>
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>¡Excelente!</strong> <?= $mensaje ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filtros -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group filter-group-directorio">
                        <label class="filter-label">Directorio</label>
                        <select name="directorio" class="filter-select" id="filtroDirectorio">
                            <?php foreach ($tipos_directorio as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $directorio_seleccionado == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-users"></i> 
                    <strong><?= count($cargos_ordenables) ?></strong> 
                    cargo(s) en <?= $tipos_directorio[$directorio_seleccionado] ?>
                </span>
            </div>
        </div>

        <!-- Lista ordenable -->
        <div class="table-modern-container">
            <div class="orden-container">
                <div class="orden-header">
                    <div class="orden-header-info">
                        <span class="orden-titulo"><?= $tipos_directorio[$directorio_seleccionado] ?></span>
                    </div>
                    <div class="orden-header-actions">
                        <span class="orden-instruction"><i class="fas fa-grip-vertical"></i> Arrastre para reordenar</span>
                        <button onclick="guardarOrden()" class="btn-primary-modern btn-guardar-orden" <?= $no_cargos ? 'disabled' : '' ?>>
                            <i class="fas fa-save"></i> Guardar Orden
                        </button>
                    </div>
                </div>
                
                <?php if ($no_cargos): ?>
                    <div class="orden-vacio">
                        <i class="fas fa-inbox"></i>
                        <p>No hay cargos activos para este directorio</p>
                        <p class="orden-vacio-sub">Los cargos deben estar vigentes para aparecer aquí.</p>
                    </div>
                <?php else: ?>
                    <div class="orden-lista" id="ordenLista">
                        <?php foreach ($cargos_ordenables as $index => $cargo): ?>
                            <div class="orden-item" data-id="<?= $cargo['id_unico'] ?>" draggable="true">
                                <div class="orden-item-handle">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="orden-item-info">
                                    <div class="orden-item-numero"><?= $index + 1 ?></div>
                                    <div class="orden-item-contenido">
                                        <div class="orden-item-cargo"><?= htmlspecialchars($cargo['cargo_completo']) ?></div>
                                        <div class="orden-item-persona">
                                            <span class="orden-item-nombre"><?= htmlspecialchars($cargo['persona_nombre']) ?></span>
                                            <span class="orden-item-institucion"><?= htmlspecialchars($cargo['institucion']) ?></span>
                                        </div>
                                        <div class="orden-item-detalles">
                                            <span class="badge-nivel"><?= htmlspecialchars($cargo['nivel']) ?></span>
                                            <span class="orden-item-fechas">
                                                <i class="fas fa-calendar-alt"></i> 
                                                Desde <?= date('d/m/Y', strtotime($cargo['fecha_inicio'])) ?>
                                                <?php if ($cargo['fecha_fin'] !== 'Actual'): ?>
                                                    - hasta <?= date('d/m/Y', strtotime($cargo['fecha_fin'])) ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="orden-footer">
                        <span class="orden-total">Total: <strong><?= count($cargos_ordenables) ?></strong> cargo(s)</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - ORDENAR CARGOS
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

.btn-primary-modern:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

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

.filter-group-directorio {
    min-width: 240px;
    max-width: 300px;
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

.table-modern-container {
    background: white;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.orden-container {
    padding: 1.5rem;
}

.orden-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.orden-header-info {
    display: flex;
    align-items: center;
}

.orden-titulo {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
}

.orden-header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.orden-instruction {
    font-size: 0.8rem;
    color: #999;
}

.orden-instruction i {
    color: #bbb;
    margin-right: 0.3rem;
}

.btn-guardar-orden {
    padding: 0.5rem 1.25rem;
    font-size: 0.85rem;
}

.btn-guardar-orden:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.orden-lista {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    min-height: 100px;
    padding: 0.25rem;
}

.orden-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: #faf8f8;
    border: 2px solid #e8e8e8;
    border-radius: 10px;
    cursor: grab;
    transition: all 0.2s ease;
}

.orden-item:hover {
    border-color: #d4c5c4;
    background: #f5f0f0;
}

.orden-item.dragging {
    opacity: 0.5;
    border-style: dashed;
}

.orden-item.drag-over {
    border-color: #8B0000;
    background: #f5edec;
}

.orden-item-handle {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #bbb;
    font-size: 1rem;
    cursor: grab;
    flex-shrink: 0;
}

.orden-item-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}

.orden-item-numero {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    background: #e8e0e0;
    color: #4a3a3a;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: 700;
    flex-shrink: 0;
}

.orden-item-contenido {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    flex: 1;
    min-width: 0;
}

.orden-item-cargo {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1a1a1a;
}

.orden-item-persona {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.orden-item-nombre {
    font-size: 0.85rem;
    color: #4a4a4a;
}

.orden-item-institucion {
    font-size: 0.75rem;
    color: #888;
    background: #f0ecec;
    padding: 0.1rem 0.5rem;
    border-radius: 4px;
}

.orden-item-detalles {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.badge-nivel {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: #f5edec;
    color: #8B0000;
    border-radius: 4px;
    font-size: 0.65rem;
    font-weight: 600;
}

.orden-item-fechas {
    font-size: 0.7rem;
    color: #999;
}

.orden-item-fechas i {
    font-size: 0.6rem;
    margin-right: 0.2rem;
}

.orden-vacio {
    text-align: center;
    padding: 3rem 1rem;
}

.orden-vacio i {
    font-size: 3rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 1rem;
}

.orden-vacio p {
    color: #999;
    font-size: 1rem;
    margin: 0;
}

.orden-vacio-sub {
    font-size: 0.85rem !important;
    color: #bbb !important;
    margin-top: 0.3rem !important;
}

.orden-footer {
    margin-top: 1.25rem;
    padding-top: 0.75rem;
    border-top: 1px solid #f0f0f0;
}

.orden-total {
    font-size: 0.85rem;
    color: #6b6b6b;
}

.orden-total strong {
    color: #1a1a1a;
}

@media (max-width: 992px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: auto;
        max-width: none;
    }

    .filter-group-directorio {
        min-width: auto;
        max-width: none;
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

    .filters-container {
        padding: 1rem;
    }

    .orden-container {
        padding: 1rem;
    }

    .orden-header {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .orden-header-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .orden-header-actions .btn-guardar-orden {
        width: 100%;
        justify-content: center;
    }

    .orden-item {
        flex-wrap: wrap;
        padding: 0.6rem 0.8rem;
    }

    .orden-item-info {
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .orden-item-persona {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.2rem;
    }

    .orden-item-detalles {
        flex-wrap: wrap;
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

    .orden-item {
        padding: 0.5rem 0.6rem;
    }

    .orden-item-numero {
        min-width: 22px;
        height: 22px;
        font-size: 0.65rem;
    }

    .orden-item-cargo {
        font-size: 0.85rem;
    }

    .orden-item-nombre {
        font-size: 0.8rem;
    }

    .orden-item-institucion {
        font-size: 0.7rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Drag & Drop
    const items = document.querySelectorAll('.orden-item');
    
    items.forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
        item.addEventListener('dragover', handleDragOver);
        item.addEventListener('dragenter', handleDragEnter);
        item.addEventListener('dragleave', handleDragLeave);
        item.addEventListener('drop', handleDrop);
    });

    // Filtro directorio
    const filtroDirectorio = document.getElementById('filtroDirectorio');
    const formFiltros = document.getElementById('formFiltros');
    
    if (filtroDirectorio) {
        filtroDirectorio.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
});

let draggedItem = null;

function handleDragStart(e) {
    draggedItem = this;
    this.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', this.dataset.id);
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    document.querySelectorAll('.orden-item.drag-over').forEach(el => {
        el.classList.remove('drag-over');
    });
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function handleDragEnter(e) {
    e.preventDefault();
    if (this !== draggedItem) {
        this.classList.add('drag-over');
    }
}

function handleDragLeave(e) {
    this.classList.remove('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    this.classList.remove('drag-over');
    
    if (this === draggedItem) return;
    
    const lista = document.getElementById('ordenLista');
    const items = lista.querySelectorAll('.orden-item');
    
    const draggedIndex = Array.from(items).indexOf(draggedItem);
    const targetIndex = Array.from(items).indexOf(this);
    
    if (draggedIndex < targetIndex) {
        lista.insertBefore(draggedItem, items[targetIndex + 1]);
    } else {
        lista.insertBefore(draggedItem, items[targetIndex]);
    }
    
    actualizarNumeros();
}

function actualizarNumeros() {
    const items = document.querySelectorAll('.orden-item');
    items.forEach((item, index) => {
        const numero = item.querySelector('.orden-item-numero');
        if (numero) {
            numero.textContent = index + 1;
        }
    });
}

function guardarOrden() {
    const items = document.querySelectorAll('.orden-item');
    const orden = [];
    
    items.forEach(item => {
        orden.push(item.dataset.id);
    });
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '';
    
    const inputAccion = document.createElement('input');
    inputAccion.type = 'hidden';
    inputAccion.name = 'accion';
    inputAccion.value = 'guardar_orden';
    
    const inputOrden = document.createElement('input');
    inputOrden.type = 'hidden';
    inputOrden.name = 'orden';
    inputOrden.value = JSON.stringify(orden);
    
    form.appendChild(inputAccion);
    form.appendChild(inputOrden);
    document.body.appendChild(form);
    form.submit();
}
</script>

<?php include 'template/footer.php'; ?>