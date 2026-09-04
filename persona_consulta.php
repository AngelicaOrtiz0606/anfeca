<?php
// ============================================================
// SIDEANFECA - Gestión de Personas
// Consultar detalle de persona
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS DE REFERENCIA (coinciden con directorios.php)
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

$tipos_directorio = [
    1 => 'Consejo Nacional Directivo',
    2 => 'Consejos Regionales',
    3 => 'Coordinaciones Nacionales',
    4 => 'Instituciones'
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

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

// ============================================================
// DATOS DE PERSONAS (tomados de directorios.php)
// ============================================================

$personas = [
    // ============ CND - Consejo Nacional Directivo ============
    [
        'id' => 1,
        'num_afiliacion' => '9807033',
        'nombre' => 'Armando',
        'apellido_paterno' => 'Tomé',
        'apellido_materno' => 'González',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 7,
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
        'nombre' => 'Adriana',
        'apellido_paterno' => 'Garza',
        'apellido_materno' => 'Elizondo',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Nuevo León',
        'facultad' => 'Facultad de Contaduría Pública y Administración',
        'id_zona' => 2,
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
        'nombre' => 'Carlos',
        'apellido_paterno' => 'Lobo',
        'apellido_materno' => 'Sánchez',
        'genero' => 'M',
        'grado' => 'M.A.',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 7,
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
        'nombre' => 'Lourdes',
        'apellido_paterno' => 'Mata',
        'apellido_materno' => 'Romero',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 7,
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
        'nombre' => 'Leobardo',
        'apellido_paterno' => 'Berrelleza',
        'apellido_materno' => 'Reyes',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Sinaloa',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 1,
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
        'nombre' => 'Laura María del Pilar',
        'apellido_paterno' => 'Macías',
        'apellido_materno' => 'Amozurrutia',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Iberoamericana Torreón',
        'facultad' => 'Departamento de Negocios',
        'id_zona' => 2,
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
        'nombre' => 'Ismael Manuel',
        'apellido_paterno' => 'Rodríguez',
        'apellido_materno' => 'Herrera',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Aguascalientes',
        'facultad' => 'Centro de Ciencias Económicas y Administrativas',
        'id_zona' => 3,
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
        'nombre' => 'Cristian Omar',
        'apellido_paterno' => 'Alcantar',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'División de Contaduría',
        'id_zona' => 4,
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
            ],
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
        'id' => 9,
        'num_afiliacion' => '9805012',
        'nombre' => 'Mario Franz',
        'apellido_paterno' => 'Subieta',
        'apellido_materno' => 'Zecua',
        'genero' => 'M',
        'grado' => 'M.A.',
        'institucion' => 'Universidad Autónoma de Tlaxcala',
        'facultad' => 'Facultad de Ciencias Económico Administrativas',
        'id_zona' => 5,
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
        'nombre' => 'Anabel',
        'apellido_paterno' => 'Galván',
        'apellido_materno' => 'Sarabia',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Veracruzana',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 6,
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
        'nombre' => 'Giannina',
        'apellido_paterno' => 'Sampieri',
        'apellido_materno' => 'Laguna',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad Intercontinental',
        'facultad' => 'División de Negocios',
        'id_zona' => 7,
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
        'nombre' => 'David Roberto',
        'apellido_paterno' => 'Suárez',
        'apellido_materno' => 'Pacheco',
        'genero' => 'M',
        'grado' => 'M.F.',
        'institucion' => 'Universidad Autónoma de Yucatán',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 6,
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
        'nombre' => 'José Juan',
        'apellido_paterno' => 'Paz',
        'apellido_materno' => 'Reyes',
        'genero' => 'M',
        'grado' => 'Mtro.',
        'institucion' => 'Universidad Juárez Autónoma de Tabasco',
        'facultad' => 'División Académica de Ciencias Económico Administrativas',
        'id_zona' => 6,
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
        'nombre' => 'Mónica',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Limón',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Tamaulipas',
        'facultad' => 'Facultad de Comercio y Administración Victoria',
        'id_zona' => 2,
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
        'nombre' => 'Lenin',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'Pérez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Tecnológica de Tabasco',
        'facultad' => '',
        'id_zona' => 6,
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
        'nombre' => 'Ivett',
        'apellido_paterno' => 'Guillén',
        'apellido_materno' => 'Morales',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Instituto Politécnico Nacional',
        'facultad' => 'Escuela Superior de Comercio y Administración Unidad Tepepan',
        'id_zona' => 7,
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
        'nombre' => 'José Ernesto',
        'apellido_paterno' => 'Amorós',
        'apellido_materno' => 'Espinosa',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Tecnológico de Monterrey',
        'facultad' => 'División de Negocios Campus Ciudad de México',
        'id_zona' => 7,
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
        'nombre' => 'Cristina',
        'apellido_paterno' => 'Cabrera',
        'apellido_materno' => 'Ramos',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Chihuahua',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 1,
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
        'nombre' => 'Aureliano',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'Castillo',
        'genero' => 'M',
        'grado' => 'M.F.',
        'institucion' => 'Universidad Autónoma de Yucatán',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 6,
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
        'nombre' => 'Juan Antonio',
        'apellido_paterno' => 'Zapata',
        'apellido_materno' => 'Zapata',
        'genero' => 'M',
        'grado' => 'C.P. C.',
        'institucion' => 'Universidad Autónoma de San Luis Potosí',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 3,
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
        'nombre' => 'Laura Ofelia',
        'apellido_paterno' => 'Robles',
        'apellido_materno' => 'Sahagún',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Campus Puerto Vallarta',
        'id_zona' => 4,
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
        'nombre' => 'Cecilia',
        'apellido_paterno' => 'Morales',
        'apellido_materno' => 'del Río',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad de Monterrey',
        'facultad' => 'División de Negocios',
        'id_zona' => 2,
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
        'nombre' => 'María Antonieta Monserrat',
        'apellido_paterno' => 'Vera',
        'apellido_materno' => 'Muñoz',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Benemérita Universidad Autónoma de Puebla',
        'facultad' => 'Facultad de Contaduría Pública',
        'id_zona' => 5,
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
        'nombre' => 'Lorena Argentina',
        'apellido_paterno' => 'Medina',
        'apellido_materno' => 'Bocanegra',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Coahuila',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 2,
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
        'nombre' => 'Idi Amin',
        'apellido_paterno' => 'Germán Silva',
        'apellido_materno' => 'Jug',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Nayarit',
        'facultad' => 'Unidad Académica de Contaduría y Administración',
        'id_zona' => 4,
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
        'nombre' => 'Leticia María',
        'apellido_paterno' => 'González',
        'apellido_materno' => 'Velásquez',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad de Sonora',
        'facultad' => 'División de Ciencias Económicas y Sociales',
        'id_zona' => 1,
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
        'nombre' => 'Patricia',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'García',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de San Luis Potosí',
        'facultad' => 'Facultad de Contaduría y Administración',
        'id_zona' => 3,
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
        'nombre' => 'Mónica',
        'apellido_paterno' => 'Blanco',
        'apellido_materno' => 'Jiménez',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Nuevo León',
        'facultad' => 'Facultad de Contaduría Pública y Administración',
        'id_zona' => 2,
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
        'nombre' => 'José',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Gutiérrez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'Departamento de Mercadotécnia y Negocios Internacionales',
        'id_zona' => 4,
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
        'nombre' => 'Alfonso Martin',
        'apellido_paterno' => 'Rodríguez',
        'apellido_materno' => '',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad Autónoma de Aguascalientes',
        'facultad' => 'Centro de Ciencias Económicas y Administrativas',
        'id_zona' => 3,
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
        'nombre' => 'Emigdio',
        'apellido_paterno' => 'Larios',
        'apellido_materno' => 'Gómez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Benemérita Universidad Autónoma de Puebla',
        'facultad' => 'Facultad de Administración',
        'id_zona' => 5,
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

    // ============ INSTITUCIONES (cargos de nivel 3) ============
    [
        'id' => 32,
        'num_afiliacion' => '9804001',
        'nombre' => 'Cristian Omar',
        'apellido_paterno' => 'Alcantar',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'División de Contaduría',
        'id_zona' => 4,
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
        'nombre' => 'Luis Edmundo',
        'apellido_paterno' => 'Garrido',
        'apellido_materno' => 'Sánchez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'facultad' => 'Departamento de Economía, Administración y Finanzas',
        'id_zona' => 4,
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
        'nombre' => 'Maria Margarita',
        'apellido_paterno' => 'Villareal',
        'apellido_materno' => 'Treviño',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'facultad' => 'Escuela de Contaduría Pública',
        'id_zona' => 4,
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
        'nombre' => 'Esmeralda',
        'apellido_paterno' => 'Brito',
        'apellido_materno' => 'Cervantes',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad Autónoma de Guadalajara',
        'facultad' => 'Facultad de Administración',
        'id_zona' => 4,
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
        'nombre' => 'Nadia Natasha',
        'apellido_paterno' => 'Reus',
        'apellido_materno' => 'González',
        'genero' => 'F',
        'grado' => 'Dra.',
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'Centro Universitario de los Altos',
        'id_zona' => 4,
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
        'nombre' => 'Salvador',
        'apellido_paterno' => 'Cervantes',
        'apellido_materno' => 'Cervantes',
        'genero' => 'M',
        'grado' => 'Dr.',
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Dirección General Académica',
        'id_zona' => 4,
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
        'nombre' => 'María Guadalupe',
        'apellido_paterno' => 'Jiménez',
        'apellido_materno' => 'Hernández',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Departamento de Administración y Contaduría Plantel Vallarta',
        'id_zona' => 4,
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
// OBTENER ID DE LA PERSONA
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Buscar la persona por ID
$persona = null;
foreach ($personas as $p) {
    if ($p['id'] == $id) {
        $persona = $p;
        break;
    }
}

// Si no se encuentra la persona, mostrar error
if (!$persona) {
    echo '<div class="main-content"><div class="dashboard-container"><div class="alert-modern alert-error"><i class="fas fa-exclamation-circle"></i><div><strong>Error</strong> No se encontró la persona solicitada.</div></div></div></div>';
    include 'template/footer.php';
    exit;
}

// ============================================================
// FUNCIONES AUXILIARES
// ============================================================

function getZonaNombre($id) {
    global $zonas_regionales;
    return $zonas_regionales[$id] ?? 'Sin zona';
}

function getNivelNombre($nivel) {
    global $niveles_cargo;
    return $niveles_cargo[$nivel] ?? 'N/A';
}

function getDirectoriosNombres($directorios_ids) {
    global $tipos_directorio;
    $nombres = [];
    foreach ($directorios_ids as $id) {
        if (isset($tipos_directorio[$id])) {
            $nombres[] = $tipos_directorio[$id];
        }
    }
    return $nombres;
}

function getCoordinacionNombre($id) {
    global $coordinaciones_nacionales;
    return $coordinaciones_nacionales[$id] ?? 'N/A';
}

function getGeneroNombre($genero) {
    return $genero == 'F' ? 'Femenino' : 'Masculino';
}

function estaActivo($persona) {
    foreach ($persona['cargos'] as $cargo) {
        if ($cargo['fecha_fin'] === null) {
            return true;
        }
    }
    return false;
}

// ============================================================
// PROCESAR DATOS DE LA PERSONA
// ============================================================

$activo = estaActivo($persona);
$zona_nombre = getZonaNombre($persona['id_zona']);
$nombre_completo = trim($persona['nombre'] . ' ' . $persona['apellido_paterno'] . ' ' . ($persona['apellido_materno'] ?? ''));
$iniciales = substr($persona['nombre'], 0, 1) . substr($persona['apellido_paterno'], 0, 1);

// Formatear cargos para mostrar
$cargos_formateados = [];
foreach ($persona['cargos'] as $cargo) {
    $directorios_nombres = getDirectoriosNombres($cargo['directorios']);
    $cargos_formateados[] = [
        'nombre' => $cargo['nombre'],
        'nivel_nombre' => getNivelNombre($cargo['nivel']),
        'zona_nombre' => $cargo['zona'] ? getZonaNombre($cargo['zona']) : '---',
        'coordinacion_nombre' => $cargo['coordinacion'] ? getCoordinacionNombre($cargo['coordinacion']) : '---',
        'fecha_inicio' => $cargo['fecha_inicio'],
        'fecha_fin' => $cargo['fecha_fin'] ?? '---',
        'directorios' => implode(', ', $directorios_nombres),
        'activo' => $cargo['fecha_fin'] === null
    ];
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
                    <i class="fas fa-user-circle"></i>
                </div>
                <div>
                    <h1 class="page-title">Detalle de Persona</h1>
                    <p class="page-subtitle">Información completa de la persona registrada en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <a href="persona_edicion.php?id=<?= $id ?>" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="personas.php" class="btn-outline-modern">
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
                        <span><?= $iniciales ?></span>
                    </div>
                    <div class="profile-info">
                        <h2><?= htmlspecialchars(trim(($persona['grado'] ?? '') . ' ' . $nombre_completo)) ?></h2>
                        <div class="profile-meta">
                            <span class="profile-status <?= $activo ? 'status-active' : 'status-inactive' ?>">
                                <span class="status-dot"></span> <?= $activo ? 'Activo' : 'Inactivo' ?>
                            </span>
                            <span class="profile-gender">
                                <?= getGeneroNombre($persona['genero']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="profile-item">
                        <span class="profile-label">Núm. Afiliación</span>
                        <span class="profile-value"><?= htmlspecialchars($persona['num_afiliacion']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Zona Regional</span>
                        <span class="profile-value">
                            <span class="badge-zona"><?= htmlspecialchars($zona_nombre) ?></span>
                        </span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Institución</span>
                        <span class="profile-value"><?= htmlspecialchars($persona['institucion']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Facultad / Escuela</span>
                        <span class="profile-value"><?= htmlspecialchars($persona['facultad'] ?: 'No especificada') ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Grado Académico</span>
                        <span class="profile-value"><?= htmlspecialchars($persona['grado'] ?? 'No especificado') ?></span>
                    </div>
                </div>
            </div>

            <!-- Contactos -->
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Contactos</h3>
                </div>
                <div class="detail-card-body">
                    <?php if (!empty($persona['telefonos']) || !empty($persona['emails'])): ?>
                        <div class="contactos-grid-detail">
                            <?php if (!empty($persona['telefonos'])): ?>
                                <div class="contactos-grupo-detail">
                                    <h4>Teléfonos</h4>
                                    <?php foreach ($persona['telefonos'] as $telefono): ?>
                                        <div class="contacto-detail">
                                            <span><?= htmlspecialchars($telefono) ?></span>
                                            <span class="badge-visible">Visible</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($persona['emails'])): ?>
                                <div class="contactos-grupo-detail">
                                    <h4>Correos Electrónicos</h4>
                                    <?php foreach ($persona['emails'] as $email): ?>
                                        <div class="contacto-detail">
                                            <span><?= htmlspecialchars($email) ?></span>
                                            <span class="badge-visible">Visible</span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-3">No hay contactos registrados</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cargos (tabla) -->
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Cargos</h3>
                    <span class="detail-badge"><?= count($cargos_formateados) ?> cargo(s)</span>
                </div>
                <div class="detail-card-body">
                    <?php if (!empty($cargos_formateados)): ?>
                        <div class="table-modern-container">
                            <div class="table-modern-wrapper">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Nivel</th>
                                            <th>Cargo</th>
                                            <th>Zona</th>
                                            <th>Coordinación</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Estado</th>
                                            <th>Directorios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cargos_formateados as $cargo): ?>
                                        <tr>
                                            <td>
                                                <span class="badge-nivel"><?= htmlspecialchars($cargo['nivel_nombre']) ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($cargo['nombre']) ?></td>
                                            <td><?= htmlspecialchars($cargo['zona_nombre']) ?></td>
                                            <td><?= htmlspecialchars($cargo['coordinacion_nombre']) ?></td>
                                            <td><?= htmlspecialchars($cargo['fecha_inicio']) ?></td>
                                            <td><?= htmlspecialchars($cargo['fecha_fin']) ?></td>
                                            <td>
                                                <span class="<?= $cargo['activo'] ? 'status-active' : 'status-inactive' ?>">
                                                    <i class="fas fa-circle"></i> <?= $cargo['activo'] ? 'Activo' : 'Finalizado' ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($cargo['directorios']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-3">No hay cargos asignados</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - CONSULTA
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
    font-size: 2rem;
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
    gap: 1.5rem;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 0.3rem;
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

.profile-gender {
    font-size: 0.8rem;
    color: #666;
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

/* Badge Nivel en tabla */
.badge-nivel {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    background: #f5edec;
    color: #8B0000;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 600;
}

/* Contactos Grid */
.contactos-grid-detail {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.contactos-grupo-detail h4 {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 0.5rem 0;
}

.contacto-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.4rem 0;
    border-bottom: 1px solid #f5f0f0;
    font-size: 0.9rem;
}

.contacto-detail:last-child {
    border-bottom: none;
}

.badge-visible {
    font-size: 0.65rem;
    padding: 0.15rem 0.5rem;
    background: #e8f5e9;
    color: #2e7d32;
    border-radius: 12px;
    font-weight: 600;
}

.badge-hidden {
    font-size: 0.65rem;
    padding: 0.15rem 0.5rem;
    background: #fce4ec;
    color: #c62828;
    border-radius: 12px;
    font-weight: 600;
}

/* Tabla moderna */
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

.text-muted {
    color: #999;
}

.text-center {
    text-align: center;
}

.py-3 {
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
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

    .contactos-grid-detail {
        grid-template-columns: 1fr;
    }

    .detail-card {
        padding: 1.25rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.5rem 0.6rem;
        font-size: 0.8rem;
    }

    .detail-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>

<?php include 'template/footer.php'; ?>