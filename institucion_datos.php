<?php
// ============================================================
// SIDEANFECA - Datos compartidos
// Fuente única de instituciones y personas
// ============================================================

// ============================================================
// ENTIDADES FEDERATIVAS
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

// ============================================================
// ZONAS REGIONALES
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

// ============================================================
// TIPOS DE INSTITUCIÓN
// ============================================================

$tipos_institucion = [
    1 => 'Universidad',
    2 => 'Facultad',
    3 => 'Campus'
];

// ============================================================
// TIPOS DE PARTICIPACIÓN
// ============================================================

$tipos_participacion = [
    'afiliada' => 'Afiliada',
    'observadora' => 'Observadora',
    'matriz' => 'Matriz'
];

// ============================================================
// SECTORES
// ============================================================

$sectores = [
    'Publica' => 'Pública',
    'Privada' => 'Privada'
];

// ============================================================
// NIVELES DE CARGO
// ============================================================

$niveles_cargo = [
    'Nacional' => 'Nacional',
    'Regional' => 'Regional',
    'Institucional' => 'Institucional'
];

// ============================================================
// DIRECTORIOS DISPONIBLES
// ============================================================

$directorios_disponibles = [
    'Consejo Nacional Directivo',
    'Consejos Regionales',
    'Coordinaciones Nacionales',
    'Instituciones'
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
    '44100' => ['entidad' => 15, 'municipio' => 'Guadalajara', 'colonia' => 'Centro', 'zona' => 4],
    '21259' => ['entidad' => 2, 'municipio' => 'Mexicali', 'colonia' => 'Rivera', 'zona' => 1],
    '22424' => ['entidad' => 2, 'municipio' => 'Tijuana', 'colonia' => 'Internacional Tijuana', 'zona' => 1],
    '66450' => ['entidad' => 19, 'municipio' => 'San Nicolás de los Garza', 'colonia' => 'Ciudad Universitaria', 'zona' => 2],
    '76010' => ['entidad' => 22, 'municipio' => 'Querétaro', 'colonia' => 'Centro', 'zona' => 3],
    '97160' => ['entidad' => 31, 'municipio' => 'Mérida', 'colonia' => 'Centro', 'zona' => 6],
    '31000' => ['entidad' => 6, 'municipio' => 'Chihuahua', 'colonia' => 'Zona Centro', 'zona' => 1],
    '83000' => ['entidad' => 26, 'municipio' => 'Hermosillo', 'colonia' => 'Zona Centro', 'zona' => 1],
    '72420' => ['entidad' => 21, 'municipio' => 'Puebla', 'colonia' => 'Cuauhtémoc', 'zona' => 5],
    '20100' => ['entidad' => 1, 'municipio' => 'Aguascalientes', 'colonia' => 'Ciudad Universitaria', 'zona' => 3]
];

// ============================================================
// CATÁLOGO UNIFICADO DE INSTITUCIONES
// ============================================================

$instituciones = [
    // ============================================================
    // UNAM - Matriz contenedora pura (siempre fue matriz)
    // ============================================================
    [
        'id' => 1,
        'nombre' => 'Universidad Nacional Autónoma de México',
        'tipo' => 1,
        'id_zona' => null,
        'id_entidad' => null,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.unam.mx'],
        'es_matriz' => true,
        'fecha_matriz' => null,
        'direccion' => null,
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Universidad Nacional Autónoma de México', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => []
    ],

    // ============================================================
    // UNAM - Hijas
    // ============================================================
    [
        'id' => 2,
        'nombre' => 'Facultad de Contaduría y Administración (UNAM)',
        'tipo' => 2,
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 1,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.fca.unam.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Circuito Exterior',
            'numero_exterior' => 'S/N',
            'numero_interior' => 'Edificio A',
            'colonia' => 'Ciudad Universitaria',
            'cp' => '04510',
            'municipio' => 'Coyoacán'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Facultad de Contaduría y Administración (UNAM)', 'fecha_inicio' => '2024-01-15', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Observadora', 'num_afiliacion' => null, 'fecha_inicio' => '2023-01-01', 'fecha_fin' => '2023-12-31'],
            ['id' => 2, 'tipo' => 'Afiliada', 'num_afiliacion' => '2607002', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ]
    ],
    [
        'id' => 51,
        'nombre' => 'Facultad de Ingeniería (UNAM)',
        'tipo' => 2,
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 1,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.ingenieria.unam.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Circuito Exterior',
            'numero_exterior' => 'S/N',
            'numero_interior' => 'Edificio 1',
            'colonia' => 'Ciudad Universitaria',
            'cp' => '04510',
            'municipio' => 'Coyoacán'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Facultad de Ingeniería (UNAM)', 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2607005', 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null]
        ]
    ],
    [
        'id' => 52,
        'nombre' => 'Facultad de Derecho (UNAM)',
        'tipo' => 2,
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 1,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.derecho.unam.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Circuito Interior',
            'numero_exterior' => 'S/N',
            'numero_interior' => '',
            'colonia' => 'Ciudad Universitaria',
            'cp' => '04510',
            'municipio' => 'Coyoacán'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Facultad de Derecho (UNAM)', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2607006', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // IPN - Matriz contenedora pura
    // ============================================================
    [
        'id' => 3,
        'nombre' => 'Instituto Politécnico Nacional',
        'tipo' => 1,
        'id_zona' => null,
        'id_entidad' => null,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.ipn.mx'],
        'es_matriz' => true,
        'fecha_matriz' => null,
        'direccion' => null,
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Instituto Politécnico Nacional', 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => []
    ],

    // ============================================================
    // IPN - Hijas
    // ============================================================
    [
        'id' => 4,
        'nombre' => 'ESCOM (IPN)',
        'tipo' => 2,
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 3,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.escom.ipn.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Avenida Instituto Politécnico Nacional',
            'numero_exterior' => 'S/N',
            'numero_interior' => 'Edificio 8',
            'colonia' => 'Zacatenco',
            'cp' => '07738',
            'municipio' => 'Gustavo A. Madero'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'ESCOM (IPN)', 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2607004', 'fecha_inicio' => '2024-02-15', 'fecha_fin' => null]
        ]
    ],
    [
        'id' => 39,
        'nombre' => 'ESCA Unidad Tepepan (IPN)',
        'tipo' => 2,
        'id_zona' => 7,
        'id_entidad' => 7,
        'id_universidad' => 3,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.esca.ipn.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Prolongación de Carpio',
            'numero_exterior' => '471',
            'numero_interior' => '',
            'colonia' => 'Santa María Tepepan',
            'cp' => '07738',
            'municipio' => 'Xochimilco'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'ESCA Unidad Tepepan (IPN)', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '9807033', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // UDG - Universidad afiliada (activa con número)
    // ============================================================
    [
        'id' => 5,
        'nombre' => 'Universidad de Guadalajara',
        'tipo' => 1,
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.udg.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Avenida Juárez',
            'numero_exterior' => '976',
            'numero_interior' => '',
            'colonia' => 'Centro',
            'cp' => '44100',
            'municipio' => 'Guadalajara'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Universidad de Guadalajara', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2601005', 'fecha_inicio' => '2024-03-01', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // UDG - Hija
    // ============================================================
    [
        'id' => 6,
        'nombre' => 'Facultad de Contaduría (UDG)',
        'tipo' => 2,
        'id_zona' => 4,
        'id_entidad' => 15,
        'id_universidad' => 5,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.cucea.udg.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Periférico Norte',
            'numero_exterior' => '799',
            'numero_interior' => 'Int. 301',
            'colonia' => 'Centro',
            'cp' => '44100',
            'municipio' => 'Guadalajara'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Facultad de Contaduría (UDG)', 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2604006', 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // UANL - Universidad afiliada (activa con número)
    // ============================================================
    [
        'id' => 9,
        'nombre' => 'Universidad Autónoma de Nuevo León',
        'tipo' => 1,
        'id_zona' => 2,
        'id_entidad' => 19,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.uanl.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Avenida Universidad',
            'numero_exterior' => 'S/N',
            'numero_interior' => '',
            'colonia' => 'Ciudad Universitaria',
            'cp' => '66450',
            'municipio' => 'San Nicolás de los Garza'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Universidad Autónoma de Nuevo León', 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2602009', 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // CESUN - Universidad observadora (inactiva)
    // ============================================================
    [
        'id' => 12,
        'nombre' => 'Centro de Estudios Superiores del Noroeste',
        'tipo' => 1,
        'id_zona' => 1,
        'id_entidad' => 2,
        'id_universidad' => null,
        'sector' => 'Privada',
        'sitios_web' => ['https://www.cesun.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Blv. Cucapahcu',
            'numero_exterior' => '20100',
            'numero_interior' => '',
            'colonia' => 'Fracc. Lago',
            'cp' => '22424',
            'municipio' => 'Tijuana'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Centro de Estudios Superiores del Noroeste', 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Observadora', 'num_afiliacion' => null, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => '2024-12-31']
        ]
    ],

    // ============================================================
    // UABC - Universidad afiliada
    // ============================================================
    [
        'id' => 7,
        'nombre' => 'Universidad Autónoma de Baja California',
        'tipo' => 1,
        'id_zona' => 1,
        'id_entidad' => 2,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.uabc.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Carretera Transpeninsular',
            'numero_exterior' => 'S/N',
            'numero_interior' => '',
            'colonia' => 'Ciudad Universitaria',
            'cp' => '21259',
            'municipio' => 'Mexicali'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Universidad Autónoma de Baja California', 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2601007', 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // UAQ - Universidad afiliada (sin hijas)
    // ============================================================
    [
        'id' => 15,
        'nombre' => 'Universidad Autónoma de Querétaro',
        'tipo' => 1,
        'id_zona' => 3,
        'id_entidad' => 22,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.uaq.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Avenida Tecnológico',
            'numero_exterior' => 'S/N',
            'numero_interior' => '',
            'colonia' => 'Ciudad Universitaria',
            'cp' => '76010',
            'municipio' => 'Querétaro'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Universidad Autónoma de Querétaro', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2603011', 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null]
        ]
    ],

    // ============================================================
    // UADY - Universidad afiliada (sin hijas)
    // ============================================================
    [
        'id' => 16,
        'nombre' => 'Universidad Autónoma de Yucatán',
        'tipo' => 1,
        'id_zona' => 6,
        'id_entidad' => 31,
        'id_universidad' => null,
        'sector' => 'Publica',
        'sitios_web' => ['https://www.uady.mx'],
        'es_matriz' => false,
        'fecha_matriz' => null,
        'direccion' => [
            'calle' => 'Calle 60',
            'numero_exterior' => '491',
            'numero_interior' => '',
            'colonia' => 'Centro',
            'cp' => '97160',
            'municipio' => 'Mérida'
        ],
        'historial_nombres' => [
            ['id' => 1, 'nombre' => 'Universidad Autónoma de Yucatán', 'fecha_inicio' => '2024-06-15', 'fecha_fin' => null]
        ],
        'historial_participacion' => [
            ['id' => 1, 'tipo' => 'Afiliada', 'num_afiliacion' => '2606012', 'fecha_inicio' => '2024-06-15', 'fecha_fin' => null]
        ]
    ]
];

// ============================================================
// PERSONAS
//
// Fuente única. Cada persona:
//   - id_institucion: OBLIGATORIA. Institución fija a la que pertenece.
//   - datos personales fijos (nombre, correos, teléfonos, género, grado).
//   - cargos[]: array de cargos/designaciones. Cada cargo tiene su
//     propia zona, nivel, fechas y directorios. Una persona puede
//     tener N cargos simultáneos o históricos.
//   - telefonos[] y correos[]: el primero es el principal.
// ============================================================

$personas = [
    // ============================================================
    // 1. Armando Tomé González - Presidente Nacional
    // ============================================================
    [
        'id' => 1,
        'nombre' => 'Armando',
        'apellido_paterno' => 'Tomé',
        'apellido_materno' => 'González',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => 2, // FCA UNAM
        'correos' => ['direccion@fca.unam.mx'],
        'telefonos' => ['55 56161561'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Presidente',
                'nivel' => 'Nacional',
                'id_zona' => 7,
                'directorios' => ['Consejo Nacional Directivo'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 2. Adriana Garza Elizondo - Vicepresidenta Nacional
    // ============================================================
    [
        'id' => 2,
        'nombre' => 'Adriana',
        'apellido_paterno' => 'Garza',
        'apellido_materno' => 'Elizondo',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => 9, // UANL
        'correos' => ['adriana.garzae@uanl.mx'],
        'telefonos' => ['81 83294080 ext.5500'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Vicepresidenta',
                'nivel' => 'Nacional',
                'id_zona' => 2,
                'directorios' => ['Consejo Nacional Directivo'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 3. Carlos Lobo Sánchez - Secretario General Nacional
    // ============================================================
    [
        'id' => 3,
        'nombre' => 'Carlos',
        'apellido_paterno' => 'Lobo',
        'apellido_materno' => 'Sánchez',
        'genero' => 'M',
        'grado' => 'M.A.',
        'id_institucion' => 2, // FCA UNAM
        'correos' => ['anfeca.sec.general@fca.unam.mx'],
        'telefonos' => ['55 56161519', '55 56161919'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Secretario General',
                'nivel' => 'Nacional',
                'id_zona' => 7,
                'directorios' => ['Consejo Nacional Directivo'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 4. Lourdes Mata Romero - Directora Ejecutiva Nacional
    // ============================================================
    [
        'id' => 4,
        'nombre' => 'Lourdes',
        'apellido_paterno' => 'Mata',
        'apellido_materno' => 'Romero',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_institucion' => 2, // FCA UNAM
        'correos' => ['anfeca.dir.ejecutiva@fca.unam.mx', 'loromero@fca.unam.mx'],
        'telefonos' => ['55 56162209 ext.146', '55 56228380', '55 56161919'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Directora Ejecutiva',
                'nivel' => 'Nacional',
                'id_zona' => 7,
                'directorios' => ['Consejo Nacional Directivo'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 5. Leobardo Berrelleza Reyes - Director Regional Z1 + Consejo
    // ============================================================
    [
        'id' => 5,
        'nombre' => 'Leobardo',
        'apellido_paterno' => 'Berrelleza',
        'apellido_materno' => 'Reyes',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // Universidad Autónoma de Sinaloa (no está en catálogo aún)
        'correos' => ['leobardobr37@fca.uas.edu.mx'],
        'telefonos' => ['667 7160303 ext.108'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Director Regional Zona 1',
                'nivel' => 'Regional',
                'id_zona' => 1,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 6. Laura María del Pilar Macías Amozurrutia - Directora Regional Z2
    // ============================================================
    [
        'id' => 6,
        'nombre' => 'Laura María del Pilar',
        'apellido_paterno' => 'Macías',
        'apellido_materno' => 'Amozurrutia',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // Universidad Iberoamericana Torreón
        'correos' => ['laura.macias@iberotorreon.edu.mx'],
        'telefonos' => ['871 705 1010 ext.1031'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Directora Regional Zona 2',
                'nivel' => 'Regional',
                'id_zona' => 2,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 7. Ismael Manuel Rodríguez Herrera - Director Regional Z3
    // ============================================================
    [
        'id' => 7,
        'nombre' => 'Ismael Manuel',
        'apellido_paterno' => 'Rodríguez',
        'apellido_materno' => 'Herrera',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // Universidad Autónoma de Aguascalientes
        'correos' => ['ismael.rodriguez@edu.uaa.mx'],
        'telefonos' => ['449 910 7400'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Director Regional Zona 3',
                'nivel' => 'Regional',
                'id_zona' => 3,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 8. Cristian Omar Alcantar López - Director Regional Z4 + Director de División
    //    (dos cargos)
    // ============================================================
    [
        'id' => 8,
        'nombre' => 'Cristian Omar',
        'apellido_paterno' => 'Alcantar',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => 5, // UDG
        'correos' => ['cristian_alcantar@hotmail.com'],
        'telefonos' => ['33 3770 3300'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Director Regional Zona 4',
                'nivel' => 'Regional',
                'id_zona' => 4,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ],
            [
                'id' => 2,
                'cargo' => 'Director de División',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 9. Mario Franz Subieta Zecua - Director Regional Z5
    // ============================================================
    [
        'id' => 9,
        'nombre' => 'Mario Franz',
        'apellido_paterno' => 'Subieta',
        'apellido_materno' => 'Zecua',
        'genero' => 'M',
        'grado' => 'M.A.',
        'id_institucion' => null, // Universidad Autónoma de Tlaxcala
        'correos' => ['subietamario@hotmail.com'],
        'telefonos' => ['246 2464643308'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Director Regional Zona 5',
                'nivel' => 'Regional',
                'id_zona' => 5,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 10. Anabel Galván Sarabia - Directora Regional Z6
    // ============================================================
    [
        'id' => 10,
        'nombre' => 'Anabel',
        'apellido_paterno' => 'Galván',
        'apellido_materno' => 'Sarabia',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // Universidad Veracruzana
        'correos' => ['angalvan@uv.mx'],
        'telefonos' => ['228 228 842 1742 ext.11611'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Directora Regional Zona 6',
                'nivel' => 'Regional',
                'id_zona' => 6,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 11. Giannina Sampieri Laguna - Directora Regional Z7
    // ============================================================
    [
        'id' => 11,
        'nombre' => 'Giannina',
        'apellido_paterno' => 'Sampieri',
        'apellido_materno' => 'Laguna',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_institucion' => null, // Universidad Intercontinental
        'correos' => ['giannina.sampieri@universidad-uic.edu.mx'],
        'telefonos' => ['55 54871412', '55 54871413'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Directora Regional Zona 7',
                'nivel' => 'Regional',
                'id_zona' => 7,
                'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 12. David Roberto Suárez Pacheco - Coordinador Nacional
    // ============================================================
    [
        'id' => 12,
        'nombre' => 'David Roberto',
        'apellido_paterno' => 'Suárez',
        'apellido_materno' => 'Pacheco',
        'genero' => 'M',
        'grado' => 'M.F.',
        'id_institucion' => 16, // UADY
        'correos' => ['david.suarez@correo.uady.mx'],
        'telefonos' => ['999 9810926', '999 9810932', '999 9810975'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Certificación Académica',
                'nivel' => 'Nacional',
                'id_zona' => 6,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 13. José Juan Paz Reyes - Coordinador Nacional Academia
    // ============================================================
    [
        'id' => 13,
        'nombre' => 'José Juan',
        'apellido_paterno' => 'Paz',
        'apellido_materno' => 'Reyes',
        'genero' => 'M',
        'grado' => 'Mtro.',
        'id_institucion' => null, // Universidad Juárez Autónoma de Tabasco
        'correos' => ['direccion.dacea@ujat.mx'],
        'telefonos' => ['993 3581500 ext.6201'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de la Academia ANFECA',
                'nivel' => 'Nacional',
                'id_zona' => 6,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 14. Mónica Sánchez Limón - Coordinadora Nacional Emprendimiento
    // ============================================================
    [
        'id' => 14,
        'nombre' => 'Mónica',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Limón',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // Universidad Autónoma de Tamaulipas
        'correos' => ['msanchel@docentes.uat.edu.mx'],
        'telefonos' => ['834 3181800 ext.103'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Emprendimiento Social',
                'nivel' => 'Nacional',
                'id_zona' => 2,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 15. Lenin Martínez Pérez - Coordinador Nacional Planes
    // ============================================================
    [
        'id' => 15,
        'nombre' => 'Lenin',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'Pérez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // Universidad Tecnológica de Tabasco
        'correos' => ['leninmartinez@outlook.com', 'secretariatecnica@uttab.edu.mx'],
        'telefonos' => ['993 9931471704'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Planes y Programas de Estudio',
                'nivel' => 'Nacional',
                'id_zona' => 6,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 16. Ivett Guillén Morales - Coordinadora Nacional Investigación
    //     (pertenece a ESCA Tepepan - IPN)
    // ============================================================
    [
        'id' => 16,
        'nombre' => 'Ivett',
        'apellido_paterno' => 'Guillén',
        'apellido_materno' => 'Morales',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => 39, // ESCA Tepepan (IPN)
        'correos' => ['direcciontep@ipn.mx'],
        'telefonos' => ['55 56242000 ext.73500', '55 56242000 ext.73502'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Investigación',
                'nivel' => 'Nacional',
                'id_zona' => 7,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 17. José Ernesto Amorós Espinosa - Coordinador Nacional Posgrado
    // ============================================================
    [
        'id' => 17,
        'nombre' => 'José Ernesto',
        'apellido_paterno' => 'Amorós',
        'apellido_materno' => 'Espinosa',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // Tecnológico de Monterrey
        'correos' => ['amoros@itesm.mx'],
        'telefonos' => ['55 91778000 ext.7997'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Posgrado',
                'nivel' => 'Nacional',
                'id_zona' => 7,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 18. Cristina Cabrera Ramos - Coordinadora Nacional Maratones
    // ============================================================
    [
        'id' => 18,
        'nombre' => 'Cristina',
        'apellido_paterno' => 'Cabrera',
        'apellido_materno' => 'Ramos',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // Universidad Autónoma de Chihuahua
        'correos' => ['cristycabrera85@gmail.com', 'ccabrera@uach.mx'],
        'telefonos' => ['614 4420010', '614 4420011'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Maratones',
                'nivel' => 'Nacional',
                'id_zona' => 1,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 19. Aureliano Martínez Castillo - Coordinador Nacional Historia
    // ============================================================
    [
        'id' => 19,
        'nombre' => 'Aureliano',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'Castillo',
        'genero' => 'M',
        'grado' => 'M.F.',
        'id_institucion' => 16, // UADY
        'correos' => ['aureliano.martinez@correo.uady.mx'],
        'telefonos' => ['999 95519339'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Historia',
                'nivel' => 'Nacional',
                'id_zona' => 6,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 20. Juan Antonio Zapata Zapata - Coordinador Nacional Vinculación
    // ============================================================
    [
        'id' => 20,
        'nombre' => 'Juan Antonio',
        'apellido_paterno' => 'Zapata',
        'apellido_materno' => 'Zapata',
        'genero' => 'M',
        'grado' => 'C.P. C.',
        'id_institucion' => null, // UASLP
        'correos' => ['direccion@fca.uaslp.mx'],
        'telefonos' => ['444 814 9380', '444 188 4509'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Vinculación Nacional e Internacional',
                'nivel' => 'Nacional',
                'id_zona' => 3,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 21. Laura Ofelia Robles Sahagún - Coordinadora Nacional Universidad Empresa
    // ============================================================
    [
        'id' => 21,
        'nombre' => 'Laura Ofelia',
        'apellido_paterno' => 'Robles',
        'apellido_materno' => 'Sahagún',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_institucion' => null, // UNIVA
        'correos' => ['laura.robles@univa.mx'],
        'telefonos' => ['322 2261212 ext.3401'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Universidad Empresa',
                'nivel' => 'Nacional',
                'id_zona' => 4,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 22. Cecilia Morales del Río - Coordinadora Nacional Formación
    // ============================================================
    [
        'id' => 22,
        'nombre' => 'Cecilia',
        'apellido_paterno' => 'Morales',
        'apellido_materno' => 'del Río',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // UDEM
        'correos' => ['cecilia.moralesd@udem.edu'],
        'telefonos' => ['81 8215 1000 ext.1230'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Formación Profesional y Académica',
                'nivel' => 'Nacional',
                'id_zona' => 2,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 23. María Antonieta Monserrat Vera Muñoz - Coordinadora Nacional RSU
    // ============================================================
    [
        'id' => 23,
        'nombre' => 'María Antonieta Monserrat',
        'apellido_paterno' => 'Vera',
        'apellido_materno' => 'Muñoz',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // BUAP
        'correos' => ['monseveram@hotmail.com', 'monserrat.vera@correo.buap.mx'],
        'telefonos' => ['222 465 2475'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Responsabilidad Social Universitaria',
                'nivel' => 'Nacional',
                'id_zona' => 5,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 24. Lorena Argentina Medina Bocanegra - Coordinadora Nacional Igualdad
    // ============================================================
    [
        'id' => 24,
        'nombre' => 'Lorena Argentina',
        'apellido_paterno' => 'Medina',
        'apellido_materno' => 'Bocanegra',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // UADEC
        'correos' => ['lorena_medina@uadec.edu.mx'],
        'telefonos' => ['87 17122383'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Igualdad de Género',
                'nivel' => 'Nacional',
                'id_zona' => 2,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 25. Idi Amin Germán Silva Jug - Coordinador Nacional Desarrollo
    // ============================================================
    [
        'id' => 25,
        'nombre' => 'Idi Amin',
        'apellido_paterno' => 'Germán Silva',
        'apellido_materno' => 'Jug',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // UAN
        'correos' => ['idiamin@uan.edu.mx'],
        'telefonos' => ['311 211 8818'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Nacional de Desarrollo Académico Estudiantil',
                'nivel' => 'Nacional',
                'id_zona' => 4,
                'directorios' => ['Coordinaciones Nacionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 26. Leticia María González Velásquez - Coordinadora Regional Z1
    // ============================================================
    [
        'id' => 26,
        'nombre' => 'Leticia María',
        'apellido_paterno' => 'González',
        'apellido_materno' => 'Velásquez',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // Universidad de Sonora
        'correos' => ['leticiamaria.gonzale@unison.mx'],
        'telefonos' => ['642 425 9968'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Regional Zona 1 de Certificación Académica',
                'nivel' => 'Regional',
                'id_zona' => 1,
                'directorios' => ['Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 27. Patricia Hernández García - Coordinadora Regional Z3
    // ============================================================
    [
        'id' => 27,
        'nombre' => 'Patricia',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'García',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // UASLP
        'correos' => ['patricia.hernandez@uaslp.mx'],
        'telefonos' => ['444 8262300 ext.3427', '444 1887093'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Regional Zona 3 de Certificación Académica',
                'nivel' => 'Regional',
                'id_zona' => 3,
                'directorios' => ['Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 28. Mónica Blanco Jiménez - Coordinadora Regional Z2
    // ============================================================
    [
        'id' => 28,
        'nombre' => 'Mónica',
        'apellido_paterno' => 'Blanco',
        'apellido_materno' => 'Jiménez',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => 9, // UANL
        'correos' => ['monica.blancojm@uanl.edu.mx'],
        'telefonos' => ['81 83171697 ext.5550', '81 83294080 ext.551'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Regional Zona 2 de Certificación Académica',
                'nivel' => 'Regional',
                'id_zona' => 2,
                'directorios' => ['Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 29. José Sánchez Gutiérrez - Coordinador Regional Z4
    // ============================================================
    [
        'id' => 29,
        'nombre' => 'José',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Gutiérrez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => 5, // UDG
        'correos' => ['jsanchez0202@hotmail.com', 'jsanchez@cucea.udg.mx'],
        'telefonos' => ['33 3337703343 ext.5190'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Regional Zona 4 de Investigación',
                'nivel' => 'Regional',
                'id_zona' => 4,
                'directorios' => ['Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 30. Alfonso Martin Rodríguez - Coordinador Regional Z3
    // ============================================================
    [
        'id' => 30,
        'nombre' => 'Alfonso Martin',
        'apellido_paterno' => 'Rodríguez',
        'apellido_materno' => '',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // UAA
        'correos' => ['alfonso.martin@edu.uaa.mx'],
        'telefonos' => ['449 4491396552 ext.8465'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Regional Zona 3 de Responsabilidad Social Universitaria',
                'nivel' => 'Regional',
                'id_zona' => 3,
                'directorios' => ['Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 31. Emigdio Larios Gómez - Coordinador Regional Z5
    // ============================================================
    [
        'id' => 31,
        'nombre' => 'Emigdio',
        'apellido_paterno' => 'Larios',
        'apellido_materno' => 'Gómez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // BUAP
        'correos' => ['herr.larios@gmail.com'],
        'telefonos' => ['222 2223250711'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Coordinador Regional Zona 5 de Posgrado',
                'nivel' => 'Regional',
                'id_zona' => 5,
                'directorios' => ['Consejos Regionales'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 32. Luis Edmundo Garrido Sánchez - Jefe de Departamento ITESO
    // ============================================================
    [
        'id' => 32,
        'nombre' => 'Luis Edmundo',
        'apellido_paterno' => 'Garrido',
        'apellido_materno' => 'Sánchez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // ITESO
        'correos' => ['dcastaneda@iteso.mx'],
        'telefonos' => ['33 36693516'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Jefe de Departamento',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 33. Maria Margarita Villareal Treviño - Directora ITESO
    // ============================================================
    [
        'id' => 33,
        'nombre' => 'Maria Margarita',
        'apellido_paterno' => 'Villareal',
        'apellido_materno' => 'Treviño',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_institucion' => null, // ITESO
        'correos' => ['marymar@iteso.mx'],
        'telefonos' => ['33 36693434'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Directora',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 34. Esmeralda Brito Cervantes - Directora UAG
    // ============================================================
    [
        'id' => 34,
        'nombre' => 'Esmeralda',
        'apellido_paterno' => 'Brito',
        'apellido_materno' => 'Cervantes',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => null, // UAG
        'correos' => ['esmeralda.brito@edu.uag.mx'],
        'telefonos' => ['33 36488824 ext.32235'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Directora del Programa de Administración',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 35. Nadia Natasha Reus González - Secretaria UDG
    // ============================================================
    [
        'id' => 35,
        'nombre' => 'Nadia Natasha',
        'apellido_paterno' => 'Reus',
        'apellido_materno' => 'González',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_institucion' => 5, // UDG
        'correos' => ['nreus@hotmail.com'],
        'telefonos' => ['378 3781091005 ext.56943'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Secretario de la División de Ciencias Sociales y de la Cultura',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 36. Salvador Cervantes Cervantes - Director UNIVA
    // ============================================================
    [
        'id' => 36,
        'nombre' => 'Salvador',
        'apellido_paterno' => 'Cervantes',
        'apellido_materno' => 'Cervantes',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_institucion' => null, // UNIVA
        'correos' => ['salvador.servantes@univa.mx'],
        'telefonos' => ['33 31340800 ext.1205'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Director General Académico',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ],

    // ============================================================
    // 37. María Guadalupe Jiménez Hernández - Directora UNIVA Vallarta
    // ============================================================
    [
        'id' => 37,
        'nombre' => 'María Guadalupe',
        'apellido_paterno' => 'Jiménez',
        'apellido_materno' => 'Hernández',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_institucion' => null, // UNIVA
        'correos' => ['mguadalupe.jimenez@univa.mx'],
        'telefonos' => ['313 40800 ext.1312'],
        'cargos' => [
            [
                'id' => 1,
                'cargo' => 'Director General de Plantel',
                'nivel' => 'Institucional',
                'id_zona' => 4,
                'directorios' => ['Instituciones'],
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null
            ]
        ]
    ]
];

// ============================================================
// FUNCIONES AUXILIARES - INSTITUCIONES
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

function getNombreInstitucion($id) {
    global $instituciones;
    foreach ($instituciones as $i) {
        if ($i['id'] == $id) {
            return $i['nombre'];
        }
    }
    return 'Sin nombre';
}

function getEntidadNombre($id) {
    global $entidades_federativas;
    if ($id === null) return '---';
    return $entidades_federativas[$id] ?? 'Sin entidad';
}

function getZonaNombre($id) {
    global $zonas_regionales;
    if ($id === null) return '---';
    return $zonas_regionales[$id] ?? 'Sin zona';
}

function getZonaNumero($id) {
    global $zonas_regionales;
    if ($id === null || $id === 0) return '---';
    return explode(' - ', $zonas_regionales[$id] ?? '0')[0];
}

function getTipoNombre($id) {
    global $tipos_institucion;
    return $tipos_institucion[$id] ?? 'No definido';
}

function getParticipacionNombre($key) {
    global $tipos_participacion;
    return $tipos_participacion[$key] ?? 'No definido';
}

function getNivelCargoNombre($key) {
    global $niveles_cargo;
    return $niveles_cargo[$key] ?? $key;
}

function formatearFecha($fecha) {
    if (!$fecha) return '---';
    $d = DateTime::createFromFormat('Y-m-d', $fecha);
    return $d ? $d->format('d/m/Y') : $fecha;
}

function getParticipacionesDe($institucion) {
    $vigente = null;
    $anteriores = [];
    
    if (!isset($institucion['historial_participacion'])) {
        return ['vigente' => null, 'anteriores' => []];
    }
    
    foreach ($institucion['historial_participacion'] as $p) {
        if ($p['fecha_fin'] === null) {
            $vigente = $p;
        } else {
            $anteriores[] = $p;
        }
    }
    
    usort($anteriores, function($a, $b) {
        return strcmp($b['fecha_inicio'], $a['fecha_inicio']);
    });
    
    return ['vigente' => $vigente, 'anteriores' => $anteriores];
}

function getNombresDe($institucion) {
    $vigente = null;
    $anteriores = [];
    
    if (!isset($institucion['historial_nombres'])) {
        return ['vigente' => null, 'anteriores' => []];
    }
    
    foreach ($institucion['historial_nombres'] as $h) {
        if ($h['fecha_fin'] === null) {
            $vigente = $h;
        } else {
            $anteriores[] = $h;
        }
    }
    
    usort($anteriores, function($a, $b) {
        return strcmp($b['fecha_inicio'], $a['fecha_inicio']);
    });
    
    return ['vigente' => $vigente, 'anteriores' => $anteriores];
}

function matrizTieneSedesActivas($matriz_id) {
    global $instituciones;
    
    foreach ($instituciones as $inst) {
        if ($inst['id_universidad'] == $matriz_id) {
            $participaciones = getParticipacionesDe($inst);
            if ($participaciones['vigente']) {
                return true;
            }
        }
    }
    
    return false;
}

function getEstadoInstitucion($institucion) {
    if ($institucion['es_matriz'] ?? false) {
        return matrizTieneSedesActivas($institucion['id']) ? 'activa' : 'inactiva';
    }
    
    $participaciones = getParticipacionesDe($institucion);
    return $participaciones['vigente'] ? 'activa' : 'inactiva';
}

function esMatrizEnAnio($institucion, $anio) {
    if (!($institucion['es_matriz'] ?? false)) {
        return false;
    }
    
    if (empty($institucion['fecha_matriz'])) {
        return true;
    }
    
    $anio_matriz = (int)date('Y', strtotime($institucion['fecha_matriz']));
    
    if ($anio < $anio_matriz) {
        return false;
    }
    
    return true;
}

function generarNumAfiliacion($zona, $anio) {
    global $instituciones;
    
    $prefijo = $anio . str_pad($zona, 2, '0', STR_PAD_LEFT);
    $numeros = [];
    
    foreach ($instituciones as $inst) {
        if (isset($inst['historial_participacion'])) {
            foreach ($inst['historial_participacion'] as $p) {
                if (!empty($p['num_afiliacion']) && substr($p['num_afiliacion'], 0, 4) === $prefijo) {
                    $numeros[] = (int)substr($p['num_afiliacion'], 4);
                }
            }
        }
    }
    
    $consecutivo = 1;
    if (!empty($numeros)) {
        $consecutivo = max($numeros) + 1;
    }
    
    return $prefijo . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);
}

function getUltimoNumeroDeInstitucion($institucion) {
    $numeros = [];
    
    if (isset($institucion['historial_participacion'])) {
        foreach ($institucion['historial_participacion'] as $p) {
            if (!empty($p['num_afiliacion'])) {
                $numeros[] = [
                    'num' => $p['num_afiliacion'],
                    'fecha_inicio' => $p['fecha_inicio']
                ];
            }
        }
    }
    
    if (empty($numeros)) {
        return null;
    }
    
    usort($numeros, function($a, $b) {
        return strcmp($b['fecha_inicio'], $a['fecha_inicio']);
    });
    
    return $numeros[0]['num'];
}

function buscarNumeroAfiliacion($numero) {
    global $instituciones;
    
    foreach ($instituciones as $inst) {
        if (isset($inst['historial_participacion'])) {
            foreach ($inst['historial_participacion'] as $p) {
                if ($p['num_afiliacion'] === $numero) {
                    return [
                        'institucion_id' => $inst['id'],
                        'institucion_nombre' => $inst['nombre'],
                        'fecha_inicio' => $p['fecha_inicio'],
                        'fecha_fin' => $p['fecha_fin'],
                        'activo' => $p['fecha_fin'] === null
                    ];
                }
            }
        }
    }
    
    return null;
}

// ============================================================
// FUNCIONES AUXILIARES - PERSONAS
// ============================================================

/**
 * Devuelve todas las personas registradas.
 */
function getPersonas() {
    global $personas;
    return $personas;
}

/**
 * Busca una persona por su ID.
 */
function getPersonaPorId($id) {
    global $personas;
    foreach ($personas as $p) {
        if ($p['id'] == $id) {
            return $p;
        }
    }
    return null;
}

/**
 * Devuelve todas las personas asociadas a una institución.
 */
function getPersonasDeInstitucion($id_institucion) {
    global $personas;
    $resultado = [];
    foreach ($personas as $p) {
        if (($p['id_institucion'] ?? null) == $id_institucion) {
            $resultado[] = $p;
        }
    }
    return $resultado;
}

/**
 * Cuenta las personas asociadas a una institución.
 */
function contarPersonasDeInstitucion($id_institucion) {
    return count(getPersonasDeInstitucion($id_institucion));
}

/**
 * Devuelve el nombre completo de una persona.
 */
function getNombreCompleto($persona, $incluir_grado = false) {
    $partes = [];
    if ($incluir_grado && !empty($persona['grado'])) {
        $partes[] = $persona['grado'];
    }
    $partes[] = $persona['nombre'];
    $partes[] = $persona['apellido_paterno'];
    if (!empty($persona['apellido_materno'])) {
        $partes[] = $persona['apellido_materno'];
    }
    return trim(implode(' ', $partes));
}

/**
 * Devuelve el teléfono principal (el primero del array).
 */
function getTelefonoPrincipal($persona) {
    if (!empty($persona['telefonos']) && is_array($persona['telefonos'])) {
        return $persona['telefonos'][0];
    }
    return '';
}

/**
 * Devuelve el correo principal (el primero del array).
 */
function getCorreoPrincipal($persona) {
    if (!empty($persona['correos']) && is_array($persona['correos'])) {
        return $persona['correos'][0];
    }
    return '';
}

/**
 * Devuelve el cargo vigente principal (el primero sin fecha_fin).
 * Si no hay ninguno vigente, devuelve el más reciente.
 */
function getCargoPrincipal($persona) {
    $vigentes = [];
    $historicos = [];
    
    foreach ($persona['cargos'] ?? [] as $c) {
        if ($c['fecha_fin'] === null) {
            $vigentes[] = $c;
        } else {
            $historicos[] = $c;
        }
    }
    
    if (!empty($vigentes)) {
        return $vigentes[0];
    }
    
    if (!empty($historicos)) {
        usort($historicos, function($a, $b) {
            return strcmp($b['fecha_inicio'], $a['fecha_inicio']);
        });
        return $historicos[0];
    }
    
    return null;
}

/**
 * Devuelve todos los cargos vigentes de una persona.
 */
function getCargosVigentes($persona) {
    $vigentes = [];
    foreach ($persona['cargos'] ?? [] as $c) {
        if ($c['fecha_fin'] === null) {
            $vigentes[] = $c;
        }
    }
    return $vigentes;
}

/**
 * Devuelve todos los cargos históricos (finalizados) de una persona.
 */
function getCargosHistoricos($persona) {
    $historicos = [];
    foreach ($persona['cargos'] ?? [] as $c) {
        if ($c['fecha_fin'] !== null) {
            $historicos[] = $c;
        }
    }
    usort($historicos, function($a, $b) {
        return strcmp($b['fecha_inicio'], $a['fecha_inicio']);
    });
    return $historicos;
}

/**
 * Indica si una persona tiene al menos un cargo vigente.
 */
function personaEstaActiva($persona) {
    return count(getCargosVigentes($persona)) > 0;
}

/**
 * Devuelve todas las zonas en las que participa una persona (según sus cargos).
 */
function getZonasDePersona($persona) {
    $zonas = [];
    foreach ($persona['cargos'] ?? [] as $c) {
        if (!empty($c['id_zona']) && !in_array($c['id_zona'], $zonas)) {
            $zonas[] = $c['id_zona'];
        }
    }
    return $zonas;
}

/**
 * Devuelve todos los directorios en los que aparece una persona.
 */
function getDirectoriosDePersona($persona) {
    $directorios = [];
    foreach ($persona['cargos'] ?? [] as $c) {
        foreach ($c['directorios'] ?? [] as $d) {
            if (!in_array($d, $directorios)) {
                $directorios[] = $d;
            }
        }
    }
    return $directorios;
}