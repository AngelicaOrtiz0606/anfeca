<?php
// ============================================================
// SIDEANFECA - Directorios
// Generación de directorios por año y tipo
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS DE REFERENCIA
// ============================================================

$tipos_directorio = [
    1 => 'CND',
    2 => 'Coordinación Nacional',
    3 => 'Regional',
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

$entidades_federativas = [
    'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche',
    'Chiapas', 'Chihuahua', 'CDMX', 'Coahuila', 'Colima', 'Durango',
    'Estado de México', 'Guanajuato', 'Guerrero', 'Hidalgo', 'Jalisco',
    'Michoacán', 'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca',
    'Puebla', 'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa',
    'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz',
    'Yucatán', 'Zacatecas'
];

$participaciones = [
    'afiliada' => 'Afiliada',
    'observadora' => 'Observadora',
    'matriz' => 'Matriz'
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

$años_disponibles = [2024, 2025, 2026];

// ============================================================
// DATOS DE PERSONAS CON CARGOS
// ============================================================

$personas = [
    // ============ CND - Consejo Nacional Directivo ============
    [
        'id' => 1,
        'num_afiliacion' => '9807033',
        'nombre' => 'Armando Tomé González',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 7,
        'telefonos' => ['55 56161561'],
        'emails' => ['direccion@fca.unam.mx'],
        'cargos' => [
            [
                'nombre' => 'Presidente',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 2,
        'num_afiliacion' => '9802008',
        'nombre' => 'Adriana Garza Elizondo',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Nuevo León',
        'facultad' => 'Facultad de Contaduría Pública y Administración',
        'zona' => 2,
        'telefonos' => ['81 83294080 ext.5500'],
        'emails' => ['adriana.garzae@uanl.mx'],
        'cargos' => [
            [
                'nombre' => 'Vicepresidenta',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 3,
        'num_afiliacion' => '9807033',
        'nombre' => 'Carlos Lobo Sánchez',
        'grado' => 'M.A.',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 7,
        'telefonos' => ['55 56161519', '55 56161919'],
        'emails' => ['anfeca.sec.general@fca.unam.mx'],
        'cargos' => [
            [
                'nombre' => 'Secretario General',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 4,
        'num_afiliacion' => '9807033',
        'nombre' => 'Lourdes Mata Romero',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 7,
        'telefonos' => ['55 56162209 ext.146', '55 56228380', '55 56161919'],
        'emails' => ['anfeca.dir.ejecutiva@fca.unam.mx', 'loromero@fca.unam.mx'],
        'cargos' => [
            [
                'nombre' => 'Directora Ejecutiva',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 5,
        'num_afiliacion' => '9801018',
        'nombre' => 'Leobardo Berrelleza Reyes',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Sinaloa',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 1,
        'telefonos' => ['667 7160303 ext.108'],
        'emails' => ['leobardobr37@fca.uas.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Director Regional Zona 1',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 1,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 6,
        'num_afiliacion' => '9802020',
        'nombre' => 'Laura María del Pilar Macías Amozurrutia',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Iberoamericana Torreón',
        'facultad' => 'Departamento de Negocios',
        'zona' => 2,
        'telefonos' => ['871 705 1010 ext.1031'],
        'emails' => ['laura.macias@iberotorreon.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Directora Regional Zona 2',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 2,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 7,
        'num_afiliacion' => '9803004',
        'nombre' => 'Ismael Manuel Rodríguez Herrera',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Aguascalientes',
        'facultad' => 'Centro de Ciencias Económicas y Administrativas',
        'zona' => 3,
        'telefonos' => ['449 910 7400'],
        'emails' => ['ismael.rodriguez@edu.uaa.mx'],
        'cargos' => [
            [
                'nombre' => 'Director Regional Zona 3',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 3,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 8,
        'num_afiliacion' => '9804001',
        'nombre' => 'Cristian Omar Alcantar López',
        'grado' => 'Dr.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'División de Contaduría',
        'zona' => 4,
        'telefonos' => ['33 3770 3300'],
        'emails' => ['cristian_alcantar@hotmail.com'],
        'cargos' => [
            [
                'nombre' => 'Director Regional Zona 4',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 4,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 9,
        'num_afiliacion' => '9805012',
        'nombre' => 'Mario Franz Subieta Zecua',
        'grado' => 'M.A.',
        'institucion' => 'Universidad Autónoma de Tlaxcala',
        'facultad' => 'Facultad de Ciencias Económico Administrativas',
        'zona' => 5,
        'telefonos' => ['246 2464643308'],
        'emails' => ['subietamario@hotmail.com'],
        'cargos' => [
            [
                'nombre' => 'Director Regional Zona 5',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 5,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 10,
        'num_afiliacion' => '9806023',
        'nombre' => 'Anabel Galván Sarabia',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Veracruzana',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 6,
        'telefonos' => ['228 228 842 1742 ext.11611'],
        'emails' => ['angalvan@uv.mx'],
        'cargos' => [
            [
                'nombre' => 'Directora Regional Zona 6',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 6,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 11,
        'num_afiliacion' => '9807025',
        'nombre' => 'Giannina Sampieri Laguna',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad Intercontinental',
        'facultad' => 'División de Negocios',
        'zona' => 7,
        'telefonos' => ['55 54871412', '55 54871413'],
        'emails' => ['giannina.sampieri@universidad-uic.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Directora Regional Zona 7',
                'nivel' => 1,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [1],
                'zona' => 7,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],

    // ============ COORDINACIONES NACIONALES ============
    [
        'id' => 12,
        'num_afiliacion' => '9806012',
        'nombre' => 'David Roberto Suárez Pacheco',
        'grado' => 'M.F.',
        'institucion' => 'Universidad Autónoma de Yucatán',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 6,
        'telefonos' => ['999 9810926', '999 9810932', '999 9810975'],
        'emails' => ['david.suarez@correo.uady.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Certificación Académica',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 1,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 13,
        'num_afiliacion' => '9806018',
        'nombre' => 'José Juan Paz Reyes',
        'grado' => 'Mtro.',
        'institucion' => 'Universidad Juárez Autónoma de Tabasco',
        'facultad' => 'División Académica de Ciencias Económico Administrativas',
        'zona' => 6,
        'telefonos' => ['993 3581500 ext.6201'],
        'emails' => ['direccion.dacea@ujat.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de la Academia ANFECA',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 2,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 14,
        'num_afiliacion' => '9802009',
        'nombre' => 'Mónica Sánchez Limón',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Tamaulipas',
        'facultad' => 'Facultad de Comercio y Administración Victoria',
        'zona' => 2,
        'telefonos' => ['834 3181800 ext.103'],
        'emails' => ['msanchel@docentes.uat.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Emprendimiento Social',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 3,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 15,
        'num_afiliacion' => '1906067',
        'nombre' => 'Lenin Martínez Pérez',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Tecnológica de Tabasco',
        'facultad' => '',
        'zona' => 6,
        'telefonos' => ['993 9931471704'],
        'emails' => ['leninmartinez@outlook.com', 'secretariatecnica@uttab.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Planes y Programas de Estudio',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 4,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 16,
        'num_afiliacion' => '9807012',
        'nombre' => 'Ivett Guillén Morales',
        'grado' => 'Dra.',
        'institucion' => 'Instituto Politécnico Nacional',
        'facultad' => 'Escuela Superior de Comercio y Administración Unidad Tepepan',
        'zona' => 7,
        'telefonos' => ['55 56242000 ext.73500', '55 56242000 ext.73502'],
        'emails' => ['direcciontep@ipn.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Investigación',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 5,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 17,
        'num_afiliacion' => '407049',
        'nombre' => 'José Ernesto Amorós Espinosa',
        'grado' => 'Dr.',
        'institucion' => 'Tecnológico de Monterrey',
        'facultad' => 'División de Negocios Campus Ciudad de México',
        'zona' => 7,
        'telefonos' => ['55 91778000 ext.7997'],
        'emails' => ['amoros@itesm.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Posgrado',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 6,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 18,
        'num_afiliacion' => '9801017',
        'nombre' => 'Cristina Cabrera Ramos',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Chihuahua',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 1,
        'telefonos' => ['614 4420010', '614 4420011'],
        'emails' => ['cristycabrera85@gmail.com', 'ccabrera@uach.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Maratones',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 7,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 19,
        'num_afiliacion' => '9806012',
        'nombre' => 'Aureliano Martínez Castillo',
        'grado' => 'M.F.',
        'institucion' => 'Universidad Autónoma de Yucatán',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 6,
        'telefonos' => ['999 95519339'],
        'emails' => ['aureliano.martinez@correo.uady.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Historia',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 8,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 20,
        'num_afiliacion' => '9803007',
        'nombre' => 'Juan Antonio Zapata Zapata',
        'grado' => 'C.P. C.',
        'institucion' => 'Universidad Autónoma de San Luis Potosí',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 3,
        'telefonos' => ['444 814 9380', '444 188 4509'],
        'emails' => ['direccion@fca.uaslp.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Vinculación Nacional e Internacional',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 9,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 21,
        'num_afiliacion' => '904065',
        'nombre' => 'Laura Ofelia Robles Sahagún',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Campus Puerto Vallarta',
        'zona' => 4,
        'telefonos' => ['322 2261212 ext.3401'],
        'emails' => ['laura.robles@univa.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Universidad Empresa',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 10,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 22,
        'num_afiliacion' => '9802016',
        'nombre' => 'Cecilia Morales del Río',
        'grado' => 'Dra.',
        'institucion' => 'Universidad de Monterrey',
        'facultad' => 'División de Negocios',
        'zona' => 2,
        'telefonos' => ['81 8215 1000 ext.1230'],
        'emails' => ['cecilia.moralesd@udem.edu'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Formación Profesional y Académica',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 11,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 23,
        'num_afiliacion' => '9805002',
        'nombre' => 'María Antonieta Monserrat Vera Muñoz',
        'grado' => 'Dra.',
        'institucion' => 'Benemérita Universidad Autónoma de Puebla',
        'facultad' => 'Facultad de Contaduría Pública',
        'zona' => 5,
        'telefonos' => ['222 465 2475'],
        'emails' => ['monseveram@hotmail.com', 'monserrat.vera@correo.buap.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Responsabilidad Social Universitaria',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 12,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 24,
        'num_afiliacion' => '9802001',
        'nombre' => 'Lorena Argentina Medina Bocanegra',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Coahuila',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 2,
        'telefonos' => ['87 17122383'],
        'emails' => ['lorena_medina@uadec.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Igualdad de Género',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 13,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 25,
        'num_afiliacion' => '9804009',
        'nombre' => 'Idi Amin Germán Silva Jug',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Nayarit',
        'facultad' => 'Unidad Académica de Contaduría y Administración',
        'zona' => 4,
        'telefonos' => ['311 211 8818'],
        'emails' => ['idiamin@uan.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Nacional de Desarrollo Académico Estudiantil',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [3],
                'zona' => null,
                'coordinacion' => 14,
                'titular' => true
            ]
        ]
    ],

    // ============ REGIONALES ============
    [
        'id' => 26,
        'num_afiliacion' => '9801020',
        'nombre' => 'Leticia María González Velásquez',
        'grado' => 'Dra.',
        'institucion' => 'Universidad de Sonora',
        'facultad' => 'División de Ciencias Económicas y Sociales',
        'zona' => 1,
        'telefonos' => ['642 425 9968'],
        'emails' => ['leticiamaria.gonzale@unison.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Regional Zona 1 de Certificación Académica',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 1,
                'coordinacion' => 1,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 27,
        'num_afiliacion' => '9803007',
        'nombre' => 'Patricia Hernández García',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de San Luis Potosí',
        'facultad' => 'Facultad de Contaduría y Administración',
        'zona' => 3,
        'telefonos' => ['444 8262300 ext.3427', '444 1887093'],
        'emails' => ['patricia.hernandez@uaslp.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Regional Zona 3 de Certificación Académica',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 3,
                'coordinacion' => 1,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 28,
        'num_afiliacion' => '9802008',
        'nombre' => 'Mónica Blanco Jiménez',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Nuevo León',
        'facultad' => 'Facultad de Contaduría Pública y Administración',
        'zona' => 2,
        'telefonos' => ['81 83171697 ext.5550', '81 83294080 ext.551'],
        'emails' => ['monica.blancojm@uanl.edu.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Regional Zona 2 de Certificación Académica',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 2,
                'coordinacion' => 1,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 29,
        'num_afiliacion' => '9804001',
        'nombre' => 'José Sánchez Gutiérrez',
        'grado' => 'Dr.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'Departamento de Mercadotécnia y Negocios Internacionales',
        'zona' => 4,
        'telefonos' => ['33 3337703343 ext.5190'],
        'emails' => ['jsanchez0202@hotmail.com', 'jsanchez@cucea.udg.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Regional Zona 4 de Investigación',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 4,
                'coordinacion' => 5,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 30,
        'num_afiliacion' => '9803004',
        'nombre' => 'Alfonso Martin Rodríguez',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Aguascalientes',
        'facultad' => 'Centro de Ciencias Económicas y Administrativas',
        'zona' => 3,
        'telefonos' => ['449 4491396552 ext.8465'],
        'emails' => ['alfonso.martin@edu.uaa.mx'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Regional Zona 3 de Responsabilidad Social Universitaria',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 3,
                'coordinacion' => 12,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 31,
        'num_afiliacion' => '9805011',
        'nombre' => 'Emigdio Larios Gómez',
        'grado' => 'Dr.',
        'institucion' => 'Benemérita Universidad Autónoma de Puebla',
        'facultad' => 'Facultad de Administración',
        'zona' => 5,
        'telefonos' => ['222 2223250711'],
        'emails' => ['herr.larios@gmail.com'],
        'cargos' => [
            [
                'nombre' => 'Coordinador Regional Zona 5 de Posgrado',
                'nivel' => 2,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [2],
                'zona' => 5,
                'coordinacion' => 6,
                'titular' => true
            ]
        ]
    ],

    // ============ INSTITUCIONES ============
    [
        'id' => 32,
        'num_afiliacion' => '9804001',
        'nombre' => 'Cristian Omar Alcantar López',
        'grado' => 'Dr.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'División de Contaduría',
        'zona' => 4,
        'telefonos' => ['33 3770 3300'],
        'emails' => ['cristian_alcantar@hotmail.com'],
        'cargos' => [
            [
                'nombre' => 'Director de División',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 33,
        'num_afiliacion' => '9804005',
        'nombre' => 'Luis Edmundo Garrido Sánchez',
        'grado' => 'Dr.',
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'facultad' => 'Departamento de Economía, Administración y Finanzas',
        'zona' => 4,
        'telefonos' => ['33 36693516'],
        'emails' => ['dcastaneda@iteso.mx'],
        'cargos' => [
            [
                'nombre' => 'Jefe de Departamento',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 34,
        'num_afiliacion' => '9804006',
        'nombre' => 'Maria Margarita Villareal Treviño',
        'grado' => 'Mtra.',
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'facultad' => 'Escuela de Contaduría Pública',
        'zona' => 4,
        'telefonos' => ['33 36693434'],
        'emails' => ['marymar@iteso.mx'],
        'cargos' => [
            [
                'nombre' => 'Directora',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 35,
        'num_afiliacion' => '9804007',
        'nombre' => 'Esmeralda Brito Cervantes',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Guadalajara',
        'facultad' => 'Facultad de Administración',
        'zona' => 4,
        'telefonos' => ['33 36488824 ext.32235'],
        'emails' => ['esmeralda.brito@edu.uag.mx'],
        'cargos' => [
            [
                'nombre' => 'Directora del Programa de Administración',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 36,
        'num_afiliacion' => '9804014',
        'nombre' => 'Nadia Natasha Reus González',
        'grado' => 'Dra.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'Centro Universitario de los Altos',
        'zona' => 4,
        'telefonos' => ['378 3781091005 ext.56943'],
        'emails' => ['nreus@hotmail.com'],
        'cargos' => [
            [
                'nombre' => 'Secretario de la División de Ciencias Sociales y de la Cultura',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 37,
        'num_afiliacion' => '9804019',
        'nombre' => 'Salvador Cervantes Cervantes',
        'grado' => 'Dr.',
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Dirección General Académica',
        'zona' => 4,
        'telefonos' => ['33 31340800 ext.1205'],
        'emails' => ['salvador.servantes@univa.mx'],
        'cargos' => [
            [
                'nombre' => 'Director General Académico',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ],
    [
        'id' => 38,
        'num_afiliacion' => '9804024',
        'nombre' => 'María Guadalupe Jiménez Hernández',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Departamento de Administración y Contaduría Plantel Vallarta',
        'zona' => 4,
        'telefonos' => ['313 40800 ext.1312'],
        'emails' => ['mguadalupe.jimenez@univa.mx'],
        'cargos' => [
            [
                'nombre' => 'Director General de Plantel',
                'nivel' => 3,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => null,
                'directorios' => [4],
                'zona' => null,
                'coordinacion' => null,
                'titular' => true
            ]
        ]
    ]
];

// ============================================================
// FUNCIÓN PARA VERIFICAR VIGENCIA DE CARGO
// ============================================================

function cargoVigenteEnAnio($cargo, $anio) {
    if ($cargo === null) return false;
    $fecha_inicio = strtotime($cargo['fecha_inicio']);
    $fecha_fin = $cargo['fecha_fin'] ? strtotime($cargo['fecha_fin']) : null;
    $anio_inicio = (int)date('Y', $fecha_inicio);
    $anio_fin = $fecha_fin ? (int)date('Y', $fecha_fin) : null;
    
    if ($anio_inicio > $anio) return false;
    if ($anio_fin !== null && $anio_fin < $anio) return false;
    return true;
}

// ============================================================
// PROCESAR FILTROS
// ============================================================

$directorio_tipo = isset($_GET['tipo']) ? (int)$_GET['tipo'] : 0;
$anio = isset($_GET['anio']) ? (int)$_GET['anio'] : 2026;
$zona_filtro = isset($_GET['zona']) ? (int)$_GET['zona'] : 0;
$entidad_filtro = isset($_GET['entidad']) ? $_GET['entidad'] : '';
$participacion_filtro = isset($_GET['participacion']) ? $_GET['participacion'] : '';
$coordinacion_filtro = isset($_GET['coordinacion']) ? (int)$_GET['coordinacion'] : 0;

$resultados = [];
$mostrar_tabla = $directorio_tipo > 0;

if ($mostrar_tabla) {
    foreach ($personas as $persona) {
        foreach ($persona['cargos'] as $cargo) {
            // Verificar vigencia
            if (!cargoVigenteEnAnio($cargo, $anio)) continue;
            
            // Verificar según tipo de directorio
            $mostrar = false;
            
            if ($directorio_tipo == 1) { // CND
                if (in_array(1, $cargo['directorios']) && $cargo['nivel'] == 1) {
                    $mostrar = true;
                }
            } elseif ($directorio_tipo == 2) { // Coordinación Nacional
                if (in_array(3, $cargo['directorios']) && $cargo['nivel'] == 2) {
                    if ($coordinacion_filtro == 0 || $cargo['coordinacion'] == $coordinacion_filtro) {
                        $mostrar = true;
                    }
                }
            } elseif ($directorio_tipo == 3) { // Regional
                if (in_array(2, $cargo['directorios']) && $cargo['nivel'] == 2) {
                    if ($zona_filtro == 0 || $cargo['zona'] == $zona_filtro) {
                        $mostrar = true;
                    }
                }
            } elseif ($directorio_tipo == 4) { // Instituciones
                if (in_array(4, $cargo['directorios']) && $cargo['nivel'] == 3) {
                    if ($zona_filtro > 0 && $persona['zona'] != $zona_filtro) continue;
                    if (!empty($entidad_filtro) && $persona['entidad'] != $entidad_filtro) continue;
                    if (!empty($participacion_filtro)) {
                        if ($participacion_filtro == 'afiliada') $mostrar = true;
                        elseif ($participacion_filtro == 'observadora' && $persona['id'] % 2 == 0) $mostrar = true;
                        elseif ($participacion_filtro == 'matriz' && $persona['id'] == 1) $mostrar = true;
                    } else {
                        $mostrar = true;
                    }
                }
            }
            
            if ($mostrar) {
                $resultados[] = [
                    'num_afiliacion' => $persona['num_afiliacion'],
                    'institucion' => $persona['institucion'],
                    'facultad' => $persona['facultad'] ?? '',
                    'nombre' => $persona['nombre'],
                    'cargo' => $cargo['nombre'],
                    'telefonos' => implode('<br>', $persona['telefonos']),
                    'emails' => implode('<br>', $persona['emails']),
                    'telefonos_plain' => implode('; ', $persona['telefonos']),
                    'emails_plain' => implode('; ', $persona['emails']),
                    'persona_id' => $persona['id'],
                    'institucion_nombre' => $persona['institucion']
                ];
            }
        }
    }

    // Ordenar por número de afiliación
    usort($resultados, function($a, $b) {
        return strcmp($a['num_afiliacion'], $b['num_afiliacion']);
    });
}

// ============================================================
// PAGINACIÓN
// ============================================================

$total_registros = count($resultados);
$registros_por_pagina = 10;
$total_paginas = ceil($total_registros / $registros_por_pagina);

$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

$offset = ($pagina_actual - 1) * $registros_por_pagina;
$resultados_paginados = array_slice($resultados, $offset, $registros_por_pagina);

// ============================================================
// OBTENER EMAILS PARA COPIAR
// ============================================================

$emails_para_copiar = [];
foreach ($resultados as $r) {
    $emails = explode('; ', $r['emails_plain']);
    foreach ($emails as $email) {
        if (!empty($email) && !in_array($email, $emails_para_copiar)) {
            $emails_para_copiar[] = $email;
        }
    }
}
$emails_texto = implode('; ', $emails_para_copiar);
$total_correos = count($emails_para_copiar);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-address-book"></i>
                </div>
                <div>
                    <h1 class="page-title">Directorios</h1>
                    <p class="page-subtitle">Generación de directorios por año y tipo</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="abrirModalCorreos()" class="btn-outline-modern" <?= empty($emails_texto) ? 'disabled' : '' ?>>
                    <i class="fas fa-copy"></i> Copiar correos
                </button>
                <button onclick="descargarCSV()" class="btn-outline-modern" <?= empty($resultados) ? 'disabled' : '' ?>>
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Tipo de Directorio</label>
                        <select name="tipo" class="filter-select" id="filtroTipo">
                            <option value="0">Seleccione un tipo...</option>
                            <?php foreach ($tipos_directorio as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $directorio_tipo == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Año</label>
                        <select name="anio" class="filter-select" id="filtroAnio">
                            <?php foreach ($años_disponibles as $a): ?>
                                <option value="<?= $a ?>" <?= $anio == $a ? 'selected' : '' ?>>
                                    <?= $a ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filtros dinámicos según tipo -->
                    <?php if ($directorio_tipo == 2): // Coordinación Nacional ?>
                    <div class="filter-group">
                        <label class="filter-label">Coordinación</label>
                        <select name="coordinacion" class="filter-select">
                            <option value="0">Todas</option>
                            <?php foreach ($coordinaciones_nacionales as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $coordinacion_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if ($directorio_tipo == 3 || $directorio_tipo == 4): // Regional o Instituciones ?>
                    <div class="filter-group">
                        <label class="filter-label">Zona</label>
                        <select name="zona" class="filter-select">
                            <option value="0">Todas</option>
                            <?php foreach ($zonas_regionales as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $zona_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if ($directorio_tipo == 4): // Instituciones ?>
                    <div class="filter-group">
                        <label class="filter-label">Entidad</label>
                        <select name="entidad" class="filter-select">
                            <option value="">Todas</option>
                            <?php foreach ($entidades_federativas as $entidad): ?>
                                <option value="<?= $entidad ?>" <?= $entidad_filtro == $entidad ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($entidad) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Participación</label>
                        <select name="participacion" class="filter-select">
                            <option value="">Todas</option>
                            <?php foreach ($participaciones as $key => $nombre): ?>
                                <option value="<?= $key ?>" <?= $participacion_filtro == $key ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    <a href="directorios.php" class="btn-filter-clear <?= $directorio_tipo == 0 ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <?php if ($directorio_tipo == 0): ?>
                    <span class="results-count">
                        <i class="fas fa-info-circle"></i> 
                        Seleccione un tipo de directorio para comenzar
                    </span>
                <?php else: ?>
                    <span class="results-count">
                        <i class="fas fa-address-book"></i> 
                        <strong><?= $total_registros ?></strong> 
                        registro(s) encontrado(s)
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <?php if ($directorio_tipo == 0): ?>
                <div class="empty-directorio">
                    <i class="fas fa-hand-pointer"></i>
                    <h3>Seleccione un tipo de directorio</h3>
                    <p>Elija el tipo de directorio que desea generar en el filtro superior</p>
                    <div class="empty-directorio-opciones">
                        <span class="opcion-tag">CND</span>
                        <span class="opcion-tag">Coordinación Nacional</span>
                        <span class="opcion-tag">Regional</span>
                        <span class="opcion-tag">Instituciones</span>
                    </div>
                </div>
            <?php elseif (count($resultados_paginados) > 0): ?>
                <div class="table-modern-wrapper">
                    <table class="table-modern" id="tablaDirectorios">
                        <thead>
                            <tr>
                                <th>No. afiliación</th>
                                <th>Institución</th>
                                <th>Facultad/Escuela</th>
                                <th>Nombre</th>
                                <th>Cargo</th>
                                <th>Teléfono(s)</th>
                                <th>Email(s)</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDirectorios">
                            <?php foreach ($resultados_paginados as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['num_afiliacion']) ?></td>
                                <td>
                                    <a href="institucion_consulta.php?id=<?= $row['persona_id'] ?>" class="institucion-link">
                                        <?= htmlspecialchars($row['institucion']) ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="institucion_consulta.php?id=<?= $row['persona_id'] ?>" class="facultad-link">
                                        <?= htmlspecialchars($row['facultad']) ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="persona_consulta.php?id=<?= $row['persona_id'] ?>" class="persona-link">
                                        <?= htmlspecialchars($row['nombre']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($row['cargo']) ?></td>
                                <td><?= $row['telefonos'] ?></td>
                                <td><?= $row['emails'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <?php if ($total_paginas > 1): ?>
                <div class="pagination-container">
                    <div class="pagination-info">
                        Mostrando <strong><?= count($resultados_paginados) ?></strong> de <strong><?= $total_registros ?></strong> registros
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
                
            <?php else: ?>
                <div class="empty-directorio">
                    <i class="fas fa-search"></i>
                    <h3>No se encontraron resultados</h3>
                    <p>No hay registros para los filtros seleccionados</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<!-- Modal de correos -->
<div class="modal-overlay" id="modalCorreos" style="display:none;">
    <div class="modal-card modal-card-correos">
        <div class="modal-header">
            <i class="fas fa-envelope" style="color:#8B0000;"></i>
            <h3>Correos a copiar</h3>
            <button onclick="cerrarModalCorreos()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom:0.75rem; color:#666; font-size:0.9rem;">
                Se copiarán al portapapeles <strong><?= $total_correos ?></strong> correo(s):
            </p>
            <div class="correos-container">
                <?php foreach ($emails_para_copiar as $email): ?>
                    <div class="correo-item"><?= htmlspecialchars($email) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-modal-cancel" onclick="cerrarModalCorreos()">Cancelar</button>
            <button class="btn-modal-primary" onclick="copiarCorreosDesdeModal()">
                <i class="fas fa-copy"></i> Copiar todos
            </button>
        </div>
    </div>
</div>

<style>
/* ============================================================
   ESTILOS - DIRECTORIOS
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

.btn-outline-modern:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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

.table-modern-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-modern {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.85rem;
    min-width: 800px;
}

.table-modern thead {
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 0.6rem 0.8rem;
    font-weight: 600;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
    white-space: nowrap;
}

.table-modern tbody td {
    padding: 0.5rem 0.8rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
    font-size: 0.8rem;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

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

.facultad-link {
    color: #8B0000;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.facultad-link:hover {
    color: #5C0000;
    text-decoration: underline;
}

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

/* Modal de correos */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

.modal-card-correos {
    background: white;
    border-radius: 16px;
    max-width: 550px;
    width: 90%;
    max-height: 80vh;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
    display: flex;
    flex-direction: column;
}

.modal-card-correos .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card-correos .modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card-correos .modal-body {
    flex: 1;
    overflow-y: auto;
    margin-bottom: 1rem;
}

.modal-card-correos .modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #f5f0f0;
}

.correos-container {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    max-height: 300px;
    overflow-y: auto;
    padding: 0.5rem;
    background: #faf8f8;
    border-radius: 10px;
    border: 1px solid #f0ecec;
}

.correo-item {
    padding: 0.3rem 0.6rem;
    font-size: 0.85rem;
    color: #1a1a1a;
    border-bottom: 1px solid #f0ecec;
    font-family: monospace;
}

.correo-item:last-child {
    border-bottom: none;
}

.btn-modal-cancel {
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

.btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.btn-modal-primary {
    padding: 0.6rem 1.8rem;
    background: linear-gradient(135deg, #8B0000, #5C0000);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-modal-primary:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}

/* Empty states */
.empty-directorio {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-directorio i {
    font-size: 4rem;
    color: #d0d0d0;
    display: block;
    margin-bottom: 1rem;
}

.empty-directorio h3 {
    font-size: 1.3rem;
    color: #4a4a4a;
    margin-bottom: 0.5rem;
}

.empty-directorio p {
    color: #999;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
}

.empty-directorio-opciones {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    flex-wrap: wrap;
}

.opcion-tag {
    display: inline-block;
    padding: 0.3rem 1.2rem;
    background: #f5edec;
    color: #8B0000;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid #e0d6d6;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
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

    .filters-container {
        padding: 1rem;
    }

    .table-modern {
        min-width: 650px;
        font-size: 0.75rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.5rem;
    }

    .empty-directorio {
        padding: 2rem 1rem;
    }

    .empty-directorio-opciones {
        flex-direction: column;
        align-items: center;
    }

    .pagination-container {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .modal-card-correos {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-card-correos .modal-footer {
        flex-direction: column;
    }

    .modal-card-correos .modal-footer button {
        width: 100%;
        justify-content: center;
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
        min-width: 550px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.3rem 0.4rem;
    }

    .modal-card-correos {
        padding: 1rem;
        margin: 0.5rem;
    }
}
</style>

<script>
// ============================================================
// FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const formFiltros = document.getElementById('formFiltros');
    
    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('change', function() {
            formFiltros.submit();
        });
    });
});

// ============================================================
// MODAL DE CORREOS
// ============================================================

const emailsTexto = <?= json_encode($emails_texto) ?>;

function abrirModalCorreos() {
    if (!emailsTexto) {
        alert('No hay correos para copiar');
        return;
    }
    document.getElementById('modalCorreos').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModalCorreos() {
    document.getElementById('modalCorreos').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function copiarCorreosDesdeModal() {
    if (!emailsTexto) {
        alert('No hay correos para copiar');
        return;
    }
    
    navigator.clipboard.writeText(emailsTexto).then(function() {
        cerrarModalCorreos();
        mostrarMensaje('Correos copiados al portapapeles', 'success');
    }).catch(function() {
        // Fallback
        const textarea = document.createElement('textarea');
        textarea.value = emailsTexto;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        cerrarModalCorreos();
        mostrarMensaje('Correos copiados al portapapeles', 'success');
    });
}

// Cerrar modal al hacer clic fuera
document.addEventListener('click', function(e) {
    const modal = document.getElementById('modalCorreos');
    if (e.target === modal) {
        cerrarModalCorreos();
    }
});

// ============================================================
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    const datos = <?= json_encode($resultados) ?>;
    
    if (datos.length === 0) {
        alert('No hay datos para exportar');
        return;
    }
    
    let csv = 'No. afiliación,Institución,Facultad/Escuela,Nombre,Cargo,Teléfono(s),Email(s)\n';
    
    datos.forEach(function(row) {
        const telefonos = row.telefonos_plain || '';
        const emails = row.emails_plain || '';
        
        csv += `"${row.num_afiliacion}","${row.institucion}","${row.facultad}","${row.nombre}","${row.cargo}","${telefonos}","${emails}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `directorio_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
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
</script>

<?php include 'template/footer.php'; ?>