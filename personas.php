<?php
// ============================================================
// SIDEANFECA - Gestión de Personas
// Listado de personas registradas
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
        'id_zona' => 7,
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Presidente',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'direccion@fca.unam.mx',
        'telefono' => '55 56161561',
        'telefonos' => ['55 56161561'],
        'emails' => ['direccion@fca.unam.mx'],
        'directorios' => ['Consejo Nacional Directivo'],
        'activo' => true
    ],
    [
        'id' => 2,
        'num_afiliacion' => '9802008',
        'nombre' => 'Adriana',
        'apellido_paterno' => 'Garza',
        'apellido_materno' => 'Elizondo',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Nuevo León',
        'facultad' => 'Facultad de Contaduría Pública y Administración',
        'cargo' => 'Vicepresidenta',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'adriana.garzae@uanl.mx',
        'telefono' => '81 83294080 ext.5500',
        'telefonos' => ['81 83294080 ext.5500'],
        'emails' => ['adriana.garzae@uanl.mx'],
        'directorios' => ['Consejo Nacional Directivo'],
        'activo' => true
    ],
    [
        'id' => 3,
        'num_afiliacion' => '9807033',
        'nombre' => 'Carlos',
        'apellido_paterno' => 'Lobo',
        'apellido_materno' => 'Sánchez',
        'genero' => 'M',
        'grado' => 'M.A.',
        'id_zona' => 7,
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Secretario General',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'anfeca.sec.general@fca.unam.mx',
        'telefono' => '55 56161519',
        'telefonos' => ['55 56161519', '55 56161919'],
        'emails' => ['anfeca.sec.general@fca.unam.mx'],
        'directorios' => ['Consejo Nacional Directivo'],
        'activo' => true
    ],
    [
        'id' => 4,
        'num_afiliacion' => '9807033',
        'nombre' => 'Lourdes',
        'apellido_paterno' => 'Mata',
        'apellido_materno' => 'Romero',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_zona' => 7,
        'institucion' => 'Universidad Nacional Autónoma de México',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Directora Ejecutiva',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'anfeca.dir.ejecutiva@fca.unam.mx',
        'telefono' => '55 56162209 ext.146',
        'telefonos' => ['55 56162209 ext.146', '55 56228380', '55 56161919'],
        'emails' => ['anfeca.dir.ejecutiva@fca.unam.mx', 'loromero@fca.unam.mx'],
        'directorios' => ['Consejo Nacional Directivo'],
        'activo' => true
    ],
    [
        'id' => 5,
        'num_afiliacion' => '9801018',
        'nombre' => 'Leobardo',
        'apellido_paterno' => 'Berrelleza',
        'apellido_materno' => 'Reyes',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 1,
        'institucion' => 'Universidad Autónoma de Sinaloa',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Director Regional Zona 1',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'leobardobr37@fca.uas.edu.mx',
        'telefono' => '667 7160303 ext.108',
        'telefonos' => ['667 7160303 ext.108'],
        'emails' => ['leobardobr37@fca.uas.edu.mx'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 6,
        'num_afiliacion' => '9802020',
        'nombre' => 'Laura María del Pilar',
        'apellido_paterno' => 'Macías',
        'apellido_materno' => 'Amozurrutia',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 2,
        'institucion' => 'Universidad Iberoamericana Torreón',
        'facultad' => 'Departamento de Negocios',
        'cargo' => 'Directora Regional Zona 2',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'laura.macias@iberotorreon.edu.mx',
        'telefono' => '871 705 1010 ext.1031',
        'telefonos' => ['871 705 1010 ext.1031'],
        'emails' => ['laura.macias@iberotorreon.edu.mx'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 7,
        'num_afiliacion' => '9803004',
        'nombre' => 'Ismael Manuel',
        'apellido_paterno' => 'Rodríguez',
        'apellido_materno' => 'Herrera',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de Aguascalientes',
        'facultad' => 'Centro de Ciencias Económicas y Administrativas',
        'cargo' => 'Director Regional Zona 3',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'ismael.rodriguez@edu.uaa.mx',
        'telefono' => '449 910 7400',
        'telefonos' => ['449 910 7400'],
        'emails' => ['ismael.rodriguez@edu.uaa.mx'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 8,
        'num_afiliacion' => '9804001',
        'nombre' => 'Cristian Omar',
        'apellido_paterno' => 'Alcantar',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'División de Contaduría',
        'cargo' => 'Director Regional Zona 4',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'cristian_alcantar@hotmail.com',
        'telefono' => '33 3770 3300',
        'telefonos' => ['33 3770 3300'],
        'emails' => ['cristian_alcantar@hotmail.com'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales', 'Instituciones'],
        'activo' => true
    ],
    [
        'id' => 9,
        'num_afiliacion' => '9805012',
        'nombre' => 'Mario Franz',
        'apellido_paterno' => 'Subieta',
        'apellido_materno' => 'Zecua',
        'genero' => 'M',
        'grado' => 'M.A.',
        'id_zona' => 5,
        'institucion' => 'Universidad Autónoma de Tlaxcala',
        'facultad' => 'Facultad de Ciencias Económico Administrativas',
        'cargo' => 'Director Regional Zona 5',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'subietamario@hotmail.com',
        'telefono' => '246 2464643308',
        'telefonos' => ['246 2464643308'],
        'emails' => ['subietamario@hotmail.com'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 10,
        'num_afiliacion' => '9806023',
        'nombre' => 'Anabel',
        'apellido_paterno' => 'Galván',
        'apellido_materno' => 'Sarabia',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 6,
        'institucion' => 'Universidad Veracruzana',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Directora Regional Zona 6',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'angalvan@uv.mx',
        'telefono' => '228 228 842 1742 ext.11611',
        'telefonos' => ['228 228 842 1742 ext.11611'],
        'emails' => ['angalvan@uv.mx'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 11,
        'num_afiliacion' => '9807025',
        'nombre' => 'Giannina',
        'apellido_paterno' => 'Sampieri',
        'apellido_materno' => 'Laguna',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_zona' => 7,
        'institucion' => 'Universidad Intercontinental',
        'facultad' => 'División de Negocios',
        'cargo' => 'Directora Regional Zona 7',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'giannina.sampieri@universidad-uic.edu.mx',
        'telefono' => '55 54871412',
        'telefonos' => ['55 54871412', '55 54871413'],
        'emails' => ['giannina.sampieri@universidad-uic.edu.mx'],
        'directorios' => ['Consejo Nacional Directivo', 'Consejos Regionales'],
        'activo' => true
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
        'id_zona' => 6,
        'institucion' => 'Universidad Autónoma de Yucatán',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Coordinador Nacional de Certificación Académica',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'david.suarez@correo.uady.mx',
        'telefono' => '999 9810926',
        'telefonos' => ['999 9810926', '999 9810932', '999 9810975'],
        'emails' => ['david.suarez@correo.uady.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 13,
        'num_afiliacion' => '9806018',
        'nombre' => 'José Juan',
        'apellido_paterno' => 'Paz',
        'apellido_materno' => 'Reyes',
        'genero' => 'M',
        'grado' => 'Mtro.',
        'id_zona' => 6,
        'institucion' => 'Universidad Juárez Autónoma de Tabasco',
        'facultad' => 'División Académica de Ciencias Económico Administrativas',
        'cargo' => 'Coordinador Nacional de la Academia ANFECA',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'direccion.dacea@ujat.mx',
        'telefono' => '993 3581500 ext.6201',
        'telefonos' => ['993 3581500 ext.6201'],
        'emails' => ['direccion.dacea@ujat.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 14,
        'num_afiliacion' => '9802009',
        'nombre' => 'Mónica',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Limón',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Tamaulipas',
        'facultad' => 'Facultad de Comercio y Administración Victoria',
        'cargo' => 'Coordinador Nacional de Emprendimiento Social',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'msanchel@docentes.uat.edu.mx',
        'telefono' => '834 3181800 ext.103',
        'telefonos' => ['834 3181800 ext.103'],
        'emails' => ['msanchel@docentes.uat.edu.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 15,
        'num_afiliacion' => '1906067',
        'nombre' => 'Lenin',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'Pérez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 6,
        'institucion' => 'Universidad Tecnológica de Tabasco',
        'facultad' => '',
        'cargo' => 'Coordinador Nacional de Planes y Programas de Estudio',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'leninmartinez@outlook.com',
        'telefono' => '993 9931471704',
        'telefonos' => ['993 9931471704'],
        'emails' => ['leninmartinez@outlook.com', 'secretariatecnica@uttab.edu.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 16,
        'num_afiliacion' => '9807012',
        'nombre' => 'Ivett',
        'apellido_paterno' => 'Guillén',
        'apellido_materno' => 'Morales',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 7,
        'institucion' => 'Instituto Politécnico Nacional',
        'facultad' => 'Escuela Superior de Comercio y Administración Unidad Tepepan',
        'cargo' => 'Coordinador Nacional de Investigación',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'direcciontep@ipn.mx',
        'telefono' => '55 56242000 ext.73500',
        'telefonos' => ['55 56242000 ext.73500', '55 56242000 ext.73502'],
        'emails' => ['direcciontep@ipn.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 17,
        'num_afiliacion' => '407049',
        'nombre' => 'José Ernesto',
        'apellido_paterno' => 'Amorós',
        'apellido_materno' => 'Espinosa',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 7,
        'institucion' => 'Tecnológico de Monterrey',
        'facultad' => 'División de Negocios Campus Ciudad de México',
        'cargo' => 'Coordinador Nacional de Posgrado',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'amoros@itesm.mx',
        'telefono' => '55 91778000 ext.7997',
        'telefonos' => ['55 91778000 ext.7997'],
        'emails' => ['amoros@itesm.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 18,
        'num_afiliacion' => '9801017',
        'nombre' => 'Cristina',
        'apellido_paterno' => 'Cabrera',
        'apellido_materno' => 'Ramos',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 1,
        'institucion' => 'Universidad Autónoma de Chihuahua',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Coordinador Nacional de Maratones',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'cristycabrera85@gmail.com',
        'telefono' => '614 4420010',
        'telefonos' => ['614 4420010', '614 4420011'],
        'emails' => ['cristycabrera85@gmail.com', 'ccabrera@uach.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 19,
        'num_afiliacion' => '9806012',
        'nombre' => 'Aureliano',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'Castillo',
        'genero' => 'M',
        'grado' => 'M.F.',
        'id_zona' => 6,
        'institucion' => 'Universidad Autónoma de Yucatán',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Coordinador Nacional de Historia',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'aureliano.martinez@correo.uady.mx',
        'telefono' => '999 95519339',
        'telefonos' => ['999 95519339'],
        'emails' => ['aureliano.martinez@correo.uady.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 20,
        'num_afiliacion' => '9803007',
        'nombre' => 'Juan Antonio',
        'apellido_paterno' => 'Zapata',
        'apellido_materno' => 'Zapata',
        'genero' => 'M',
        'grado' => 'C.P. C.',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de San Luis Potosí',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Coordinador Nacional de Vinculación Nacional e Internacional',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'direccion@fca.uaslp.mx',
        'telefono' => '444 814 9380',
        'telefonos' => ['444 814 9380', '444 188 4509'],
        'emails' => ['direccion@fca.uaslp.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 21,
        'num_afiliacion' => '904065',
        'nombre' => 'Laura Ofelia',
        'apellido_paterno' => 'Robles',
        'apellido_materno' => 'Sahagún',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_zona' => 4,
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Campus Puerto Vallarta',
        'cargo' => 'Coordinador Nacional de Universidad Empresa',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'laura.robles@univa.mx',
        'telefono' => '322 2261212 ext.3401',
        'telefonos' => ['322 2261212 ext.3401'],
        'emails' => ['laura.robles@univa.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 22,
        'num_afiliacion' => '9802016',
        'nombre' => 'Cecilia',
        'apellido_paterno' => 'Morales',
        'apellido_materno' => 'del Río',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 2,
        'institucion' => 'Universidad de Monterrey',
        'facultad' => 'División de Negocios',
        'cargo' => 'Coordinador Nacional de Formación Profesional y Académica',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'cecilia.moralesd@udem.edu',
        'telefono' => '81 8215 1000 ext.1230',
        'telefonos' => ['81 8215 1000 ext.1230'],
        'emails' => ['cecilia.moralesd@udem.edu'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 23,
        'num_afiliacion' => '9805002',
        'nombre' => 'María Antonieta Monserrat',
        'apellido_paterno' => 'Vera',
        'apellido_materno' => 'Muñoz',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 5,
        'institucion' => 'Benemérita Universidad Autónoma de Puebla',
        'facultad' => 'Facultad de Contaduría Pública',
        'cargo' => 'Coordinador Nacional de Responsabilidad Social Universitaria',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'monseveram@hotmail.com',
        'telefono' => '222 465 2475',
        'telefonos' => ['222 465 2475'],
        'emails' => ['monseveram@hotmail.com', 'monserrat.vera@correo.buap.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 24,
        'num_afiliacion' => '9802001',
        'nombre' => 'Lorena Argentina',
        'apellido_paterno' => 'Medina',
        'apellido_materno' => 'Bocanegra',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Coahuila',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Coordinador Nacional de Igualdad de Género',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'lorena_medina@uadec.edu.mx',
        'telefono' => '87 17122383',
        'telefonos' => ['87 17122383'],
        'emails' => ['lorena_medina@uadec.edu.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
    ],
    [
        'id' => 25,
        'num_afiliacion' => '9804009',
        'nombre' => 'Idi Amin',
        'apellido_paterno' => 'Germán Silva',
        'apellido_materno' => 'Jug',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 4,
        'institucion' => 'Universidad Autónoma de Nayarit',
        'facultad' => 'Unidad Académica de Contaduría y Administración',
        'cargo' => 'Coordinador Nacional de Desarrollo Académico Estudiantil',
        'cargo_nivel' => 'Nacional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'idiamin@uan.edu.mx',
        'telefono' => '311 211 8818',
        'telefonos' => ['311 211 8818'],
        'emails' => ['idiamin@uan.edu.mx'],
        'directorios' => ['Coordinaciones Nacionales'],
        'activo' => true
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
        'id_zona' => 1,
        'institucion' => 'Universidad de Sonora',
        'facultad' => 'División de Ciencias Económicas y Sociales',
        'cargo' => 'Coordinador Regional Zona 1 de Certificación Académica',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'leticiamaria.gonzale@unison.mx',
        'telefono' => '642 425 9968',
        'telefonos' => ['642 425 9968'],
        'emails' => ['leticiamaria.gonzale@unison.mx'],
        'directorios' => ['Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 27,
        'num_afiliacion' => '9803007',
        'nombre' => 'Patricia',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'García',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de San Luis Potosí',
        'facultad' => 'Facultad de Contaduría y Administración',
        'cargo' => 'Coordinador Regional Zona 3 de Certificación Académica',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'patricia.hernandez@uaslp.mx',
        'telefono' => '444 8262300 ext.3427',
        'telefonos' => ['444 8262300 ext.3427', '444 1887093'],
        'emails' => ['patricia.hernandez@uaslp.mx'],
        'directorios' => ['Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 28,
        'num_afiliacion' => '9802008',
        'nombre' => 'Mónica',
        'apellido_paterno' => 'Blanco',
        'apellido_materno' => 'Jiménez',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 2,
        'institucion' => 'Universidad Autónoma de Nuevo León',
        'facultad' => 'Facultad de Contaduría Pública y Administración',
        'cargo' => 'Coordinador Regional Zona 2 de Certificación Académica',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'monica.blancojm@uanl.edu.mx',
        'telefono' => '81 83171697 ext.5550',
        'telefonos' => ['81 83171697 ext.5550', '81 83294080 ext.551'],
        'emails' => ['monica.blancojm@uanl.edu.mx'],
        'directorios' => ['Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 29,
        'num_afiliacion' => '9804001',
        'nombre' => 'José',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Gutiérrez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'Departamento de Mercadotécnia y Negocios Internacionales',
        'cargo' => 'Coordinador Regional Zona 4 de Investigación',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'jsanchez0202@hotmail.com',
        'telefono' => '33 3337703343 ext.5190',
        'telefonos' => ['33 3337703343 ext.5190'],
        'emails' => ['jsanchez0202@hotmail.com', 'jsanchez@cucea.udg.mx'],
        'directorios' => ['Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 30,
        'num_afiliacion' => '9803004',
        'nombre' => 'Alfonso Martin',
        'apellido_paterno' => 'Rodríguez',
        'apellido_materno' => '',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 3,
        'institucion' => 'Universidad Autónoma de Aguascalientes',
        'facultad' => 'Centro de Ciencias Económicas y Administrativas',
        'cargo' => 'Coordinador Regional Zona 3 de Responsabilidad Social Universitaria',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'alfonso.martin@edu.uaa.mx',
        'telefono' => '449 4491396552 ext.8465',
        'telefonos' => ['449 4491396552 ext.8465'],
        'emails' => ['alfonso.martin@edu.uaa.mx'],
        'directorios' => ['Consejos Regionales'],
        'activo' => true
    ],
    [
        'id' => 31,
        'num_afiliacion' => '9805011',
        'nombre' => 'Emigdio',
        'apellido_paterno' => 'Larios',
        'apellido_materno' => 'Gómez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 5,
        'institucion' => 'Benemérita Universidad Autónoma de Puebla',
        'facultad' => 'Facultad de Administración',
        'cargo' => 'Coordinador Regional Zona 5 de Posgrado',
        'cargo_nivel' => 'Regional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'herr.larios@gmail.com',
        'telefono' => '222 2223250711',
        'telefonos' => ['222 2223250711'],
        'emails' => ['herr.larios@gmail.com'],
        'directorios' => ['Consejos Regionales'],
        'activo' => true
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
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'División de Contaduría',
        'cargo' => 'Director de División',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'cristian_alcantar@hotmail.com',
        'telefono' => '33 3770 3300',
        'telefonos' => ['33 3770 3300'],
        'emails' => ['cristian_alcantar@hotmail.com'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ],
    [
        'id' => 33,
        'num_afiliacion' => '9804005',
        'nombre' => 'Luis Edmundo',
        'apellido_paterno' => 'Garrido',
        'apellido_materno' => 'Sánchez',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 4,
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'facultad' => 'Departamento de Economía, Administración y Finanzas',
        'cargo' => 'Jefe de Departamento',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'dcastaneda@iteso.mx',
        'telefono' => '33 36693516',
        'telefonos' => ['33 36693516'],
        'emails' => ['dcastaneda@iteso.mx'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ],
    [
        'id' => 34,
        'num_afiliacion' => '9804006',
        'nombre' => 'Maria Margarita',
        'apellido_paterno' => 'Villareal',
        'apellido_materno' => 'Treviño',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_zona' => 4,
        'institucion' => 'Instituto Tecnológico y de Estudios Superiores de Occidente',
        'facultad' => 'Escuela de Contaduría Pública',
        'cargo' => 'Directora',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'marymar@iteso.mx',
        'telefono' => '33 36693434',
        'telefonos' => ['33 36693434'],
        'emails' => ['marymar@iteso.mx'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ],
    [
        'id' => 35,
        'num_afiliacion' => '9804007',
        'nombre' => 'Esmeralda',
        'apellido_paterno' => 'Brito',
        'apellido_materno' => 'Cervantes',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 4,
        'institucion' => 'Universidad Autónoma de Guadalajara',
        'facultad' => 'Facultad de Administración',
        'cargo' => 'Directora del Programa de Administración',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'esmeralda.brito@edu.uag.mx',
        'telefono' => '33 36488824 ext.32235',
        'telefonos' => ['33 36488824 ext.32235'],
        'emails' => ['esmeralda.brito@edu.uag.mx'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ],
    [
        'id' => 36,
        'num_afiliacion' => '9804014',
        'nombre' => 'Nadia Natasha',
        'apellido_paterno' => 'Reus',
        'apellido_materno' => 'González',
        'genero' => 'F',
        'grado' => 'Dra.',
        'id_zona' => 4,
        'institucion' => 'Universidad de Guadalajara',
        'facultad' => 'Centro Universitario de los Altos',
        'cargo' => 'Secretario de la División de Ciencias Sociales y de la Cultura',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'nreus@hotmail.com',
        'telefono' => '378 3781091005 ext.56943',
        'telefonos' => ['378 3781091005 ext.56943'],
        'emails' => ['nreus@hotmail.com'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ],
    [
        'id' => 37,
        'num_afiliacion' => '9804019',
        'nombre' => 'Salvador',
        'apellido_paterno' => 'Cervantes',
        'apellido_materno' => 'Cervantes',
        'genero' => 'M',
        'grado' => 'Dr.',
        'id_zona' => 4,
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Dirección General Académica',
        'cargo' => 'Director General Académico',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'salvador.servantes@univa.mx',
        'telefono' => '33 31340800 ext.1205',
        'telefonos' => ['33 31340800 ext.1205'],
        'emails' => ['salvador.servantes@univa.mx'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ],
    [
        'id' => 38,
        'num_afiliacion' => '9804024',
        'nombre' => 'María Guadalupe',
        'apellido_paterno' => 'Jiménez',
        'apellido_materno' => 'Hernández',
        'genero' => 'F',
        'grado' => 'Mtra.',
        'id_zona' => 4,
        'institucion' => 'Universidad del Valle de Atemajac',
        'facultad' => 'Departamento de Administración y Contaduría Plantel Vallarta',
        'cargo' => 'Director General de Plantel',
        'cargo_nivel' => 'Institucional',
        'fecha_inicio' => '2024-01-01',
        'fecha_fin' => null,
        'correo' => 'mguadalupe.jimenez@univa.mx',
        'telefono' => '313 40800 ext.1312',
        'telefonos' => ['313 40800 ext.1312'],
        'emails' => ['mguadalupe.jimenez@univa.mx'],
        'directorios' => ['Instituciones'],
        'activo' => true
    ]
];

// ============================================================
// FUNCIÓN PARA VERIFICAR VIGENCIA DE CARGO
// ============================================================

function estaActivo($persona) {
    return $persona['fecha_fin'] === null;
}

// ============================================================
// PROCESAR FILTROS
// ============================================================

$zona_filtro = isset($_GET['zona']) ? (int)$_GET['zona'] : 0;
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$cargo_filtro = isset($_GET['cargo']) ? trim($_GET['cargo']) : '';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : '';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'asc';

// Paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 6;

$personas_filtradas = $personas;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $personas_filtradas = array_filter($personas_filtradas, function($p) use ($busqueda) {
        $nombre_completo = strtolower($p['nombre'] . ' ' . $p['apellido_paterno'] . ' ' . ($p['apellido_materno'] ?? ''));
        return strpos($nombre_completo, $busqueda) !== false || 
               strpos(strtolower($p['institucion']), $busqueda) !== false ||
               strpos(strtolower($p['cargo']), $busqueda) !== false ||
               strpos(strtolower($p['correo']), $busqueda) !== false ||
               strpos(strtolower($p['num_afiliacion']), $busqueda) !== false ||
               strpos(strtolower($p['facultad'] ?? ''), $busqueda) !== false;
    });
}

if ($zona_filtro > 0) {
    $personas_filtradas = array_filter($personas_filtradas, function($p) use ($zona_filtro) {
        return $p['id_zona'] == $zona_filtro;
    });
}

if (!empty($cargo_filtro)) {
    $cargo_filtro_lower = strtolower($cargo_filtro);
    $personas_filtradas = array_filter($personas_filtradas, function($p) use ($cargo_filtro_lower) {
        return strpos(strtolower($p['cargo']), $cargo_filtro_lower) !== false;
    });
}

if ($estado_filtro == 'activo') {
    $personas_filtradas = array_filter($personas_filtradas, function($p) {
        return estaActivo($p);
    });
} elseif ($estado_filtro == 'inactivo') {
    $personas_filtradas = array_filter($personas_filtradas, function($p) {
        return !estaActivo($p);
    });
}

// Ordenar solo si se selecciona una columna
if (!empty($orden_columna)) {
    usort($personas_filtradas, function($a, $b) use ($orden_columna, $orden_direccion) {
        $valor_a = '';
        $valor_b = '';
        
        switch ($orden_columna) {
            case 'num_afiliacion':
                $valor_a = $a['num_afiliacion'];
                $valor_b = $b['num_afiliacion'];
                break;
            case 'nombre':
                $valor_a = $a['nombre'] . ' ' . $a['apellido_paterno'] . ' ' . ($a['apellido_materno'] ?? '');
                $valor_b = $b['nombre'] . ' ' . $b['apellido_paterno'] . ' ' . ($b['apellido_materno'] ?? '');
                break;
            case 'institucion':
                $valor_a = $a['institucion'];
                $valor_b = $b['institucion'];
                break;
            case 'cargo':
                $valor_a = $a['cargo'];
                $valor_b = $b['cargo'];
                break;
            case 'zona':
                $valor_a = $a['id_zona'];
                $valor_b = $b['id_zona'];
                break;
            default:
                $valor_a = $a['nombre'] . ' ' . $a['apellido_paterno'];
                $valor_b = $b['nombre'] . ' ' . $b['apellido_paterno'];
        }
        
        if ($orden_direccion == 'asc') {
            return $valor_a <=> $valor_b;
        } else {
            return $valor_b <=> $valor_a;
        }
    });
}

// Calcular total de registros
$total_registros = count($personas_filtradas);
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Asegurar que la página actual sea válida
if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

// Obtener registros de la página actual
$offset = ($pagina_actual - 1) * $registros_por_pagina;
$personas_paginadas = array_slice($personas_filtradas, $offset, $registros_por_pagina);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h1 class="page-title">Gestión de Personas</h1>
                    <p class="page-subtitle">Administre las personas registradas en el sistema de directorios</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern" <?= empty($personas_filtradas) ? 'disabled' : '' ?>>
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <a href="persona_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nueva Persona
                </a>
            </div>
        </div>

        <!-- Filtros y búsqueda -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar por nombre, institución, cargo..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarPersona"
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
                        <label class="filter-label">Cargo</label>
                        <select name="cargo" class="filter-select" id="filtroCargo">
                            <option value="">Todos</option>
                            <?php 
                            $cargos_unicos = array_unique(array_column($personas, 'cargo'));
                            sort($cargos_unicos);
                            foreach ($cargos_unicos as $cargo): 
                            ?>
                                <option value="<?= htmlspecialchars($cargo) ?>" <?= $cargo_filtro == $cargo ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cargo) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Estado</label>
                        <select name="estado" class="filter-select" id="filtroEstado">
                            <option value="">Todos</option>
                            <option value="activo" <?= $estado_filtro == 'activo' ? 'selected' : '' ?>>Activos</option>
                            <option value="inactivo" <?= $estado_filtro == 'inactivo' ? 'selected' : '' ?>>Inactivos</option>
                        </select>
                    </div>
                    
                    <a href="personas.php" class="btn-filter-clear <?= (empty($busqueda) && $zona_filtro == 0 && empty($cargo_filtro) && empty($estado_filtro)) ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-users"></i> 
                    <strong id="registrosMostrados"><?= count($personas_filtradas) ?></strong> 
                    persona(s) encontrada(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaPersonas">
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
                                    <span class="sort-label">Nombre</span>
                                    <?php if ($orden_columna == 'nombre'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'institucion', 'orden_direccion' => ($orden_columna == 'institucion' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'institucion' ? 'active' : '' ?>">
                                    <span class="sort-label">Institución</span>
                                    <?php if ($orden_columna == 'institucion'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'cargo', 'orden_direccion' => ($orden_columna == 'cargo' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'cargo' ? 'active' : '' ?>">
                                    <span class="sort-label">Cargo</span>
                                    <?php if ($orden_columna == 'cargo'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
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
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyPersonas">
                        <?php if (count($personas_paginadas) > 0): ?>
                            <?php foreach ($personas_paginadas as $persona): 
                                $nombre_completo = $persona['nombre'] . ' ' . $persona['apellido_paterno'];
                                if (!empty($persona['apellido_materno'])) {
                                    $nombre_completo .= ' ' . $persona['apellido_materno'];
                                }
                                $zona_nombre = $zonas_regionales[$persona['id_zona']] ?? 'Sin zona';
                                $activo = estaActivo($persona);
                            ?>
                            <tr data-id="<?= $persona['id'] ?>" data-activo="<?= $activo ? 'true' : 'false' ?>">
                                <td><span class="badge-afiliacion"><?= htmlspecialchars($persona['num_afiliacion']) ?></span></td>
                                <td>
                                    <div class="persona-cell">
                                        <div class="persona-nombre"><?= htmlspecialchars($nombre_completo) ?></div>
                                        <?php if (!empty($persona['grado'])): ?>
                                            <div class="persona-grado"><?= htmlspecialchars($persona['grado']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="institucion-cell">
                                        <div><?= htmlspecialchars($persona['institucion']) ?></div>
                                        <?php if (!empty($persona['facultad'])): ?>
                                            <div class="facultad-nombre"><?= htmlspecialchars($persona['facultad']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($persona['cargo']) ?></td>
                                <td><span class="badge-zona"><?= htmlspecialchars($zona_nombre) ?></span></td>
                                <td><?= htmlspecialchars($persona['correo']) ?></td>
                                <td><?= htmlspecialchars($persona['telefono']) ?></td>
                                <td>
                                    <?php if ($activo): ?>
                                        <span class="status-active"><i class="fas fa-circle"></i> Activo</span>
                                    <?php else: ?>
                                        <span class="status-inactive"><i class="fas fa-circle"></i> Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="persona_consulta.php?id=<?= $persona['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="persona_edicion.php?id=<?= $persona['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button onclick="eliminarPersona(<?= $persona['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="empty-row">
                                    <i class="fas fa-search"></i>
                                    <p>No se encontraron personas con los filtros aplicados</p>
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
                    Mostrando <strong><?= count($personas_paginadas) ?></strong> de <strong><?= $total_registros ?></strong> registros
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
   ESTILOS MODERNOS - LISTADO PERSONAS
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
    flex-wrap: wrap;
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

.btn-outline-modern:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    min-width: 1100px;
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
    gap: 0.4rem;
    transition: color 0.2s ease;
    cursor: pointer;
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

.badge-zona {
    display: inline-block;
    padding: 0.25rem 0.9rem;
    background: #f0ebeb;
    color: #5a3a3a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.persona-nombre {
    font-weight: 600;
    color: #1a1a1a;
}

.persona-grado {
    font-size: 0.7rem;
    color: #888;
    margin-top: 0.1rem;
}

.institucion-cell {
    font-size: 0.85rem;
}

.facultad-nombre {
    font-size: 0.7rem;
    color: #888;
    margin-top: 0.1rem;
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

/* Modal */
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

.modal-card {
    background: white;
    border-radius: 16px;
    max-width: 550px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    padding: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

.modal-card .modal-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f5f0f0;
}

.modal-card .modal-header i {
    font-size: 1.5rem;
    color: #dc3545;
}

.modal-card .modal-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.modal-card .modal-body {
    margin-bottom: 1.5rem;
}

.modal-card .modal-body p {
    color: #4a4a4a;
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

.modal-card .modal-body .persona-info {
    background: #faf8f8;
    padding: 1rem;
    border-radius: 10px;
    border: 1px solid #f0ecec;
    margin: 0.75rem 0;
}

.modal-card .modal-body .persona-info .info-item {
    display: flex;
    padding: 0.3rem 0;
    border-bottom: 1px solid #f0ecec;
}

.modal-card .modal-body .persona-info .info-item:last-child {
    border-bottom: none;
}

.modal-card .modal-body .persona-info .info-label {
    font-weight: 600;
    color: #666;
    width: 140px;
    flex-shrink: 0;
}

.modal-card .modal-body .persona-info .info-value {
    color: #1a1a1a;
}

.modal-card .modal-body .persona-info .info-value .tag-directorio-modal {
    display: inline-block;
    padding: 0.1rem 0.5rem;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    font-size: 0.7rem;
    color: #666;
    margin: 0.1rem 0.2rem;
}

.modal-card .modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #f5f0f0;
}

.modal-card .btn-modal-cancel {
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

.modal-card .btn-modal-cancel:hover {
    border-color: #8B0000;
    color: #8B0000;
}

.modal-card .btn-modal-danger {
    padding: 0.6rem 1.5rem;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-card .btn-modal-danger:hover {
    background: #c62828;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideDown {
    from { transform: translateX(-50%) translateY(-20px); opacity: 0; }
    to { transform: translateX(-50%) translateY(0); opacity: 1; }
}

@keyframes slideUpMessage {
    from { transform: translateX(-50%) translateY(0); opacity: 1; }
    to { transform: translateX(-50%) translateY(-20px); opacity: 0; }
}

/* Mensajes flotantes */
.mensaje-flotante {
    position: fixed;
    top: 90px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9998;
    max-width: 600px;
    width: 90%;
    animation: slideDown 0.4s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.mensaje-flotante.success {
    background: #f0f7f0;
    color: #1a5a1a;
    border-left: 4px solid #2e7d32;
}

.mensaje-flotante.success i {
    color: #2e7d32;
}

.mensaje-flotante.error {
    background: #fdf0f0;
    color: #7a1a1a;
    border-left: 4px solid #c62828;
}

.mensaje-flotante.error i {
    color: #c62828;
}

.mensaje-flotante i {
    font-size: 1.25rem;
}

.mensaje-flotante .btn-cerrar-mensaje {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: auto;
    padding: 0 0.25rem;
}

.mensaje-flotante.success .btn-cerrar-mensaje {
    color: #1a5a1a;
}

.mensaje-flotante.error .btn-cerrar-mensaje {
    color: #7a1a1a;
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

    .modal-card {
        padding: 1.25rem;
        margin: 1rem;
    }

    .modal-card .modal-body .persona-info .info-item {
        flex-direction: column;
        padding: 0.5rem 0;
    }

    .modal-card .modal-body .persona-info .info-label {
        width: auto;
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

    .table-modern {
        min-width: 650px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.4rem;
    }

    .btn-accion {
        width: 24px;
        height: 24px;
        font-size: 0.55rem;
        border-radius: 6px;
    }

    .modal-card {
        padding: 1rem;
        margin: 0.5rem;
    }
}
</style>

<script>
// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarPersona');
    const filtroZona = document.getElementById('filtroZona');
    const filtroCargo = document.getElementById('filtroCargo');
    const filtroEstado = document.getElementById('filtroEstado');
    const formFiltros = document.getElementById('formFiltros');
    
    let timeoutId = null;
    
    buscarInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            formFiltros.submit();
        }, 500);
    });
    
    filtroZona.addEventListener('change', function() {
        formFiltros.submit();
    });
    
    filtroCargo.addEventListener('change', function() {
        formFiltros.submit();
    });
    
    filtroEstado.addEventListener('change', function() {
        formFiltros.submit();
    });
});

// ============================================================
// DATOS DE PERSONAS
// ============================================================

const personasData = <?= json_encode($personas) ?>;
const zonasRegionales = <?= json_encode($zonas_regionales) ?>;

// ============================================================
// ELIMINAR PERSONA (CON MODAL)
// ============================================================

function eliminarPersona(id) {
    const persona = personasData.find(p => p.id === id);
    if (!persona) {
        mostrarMensaje('No se encontró la persona', 'error');
        return;
    }
    
    const nombreCompleto = persona.nombre + ' ' + persona.apellido_paterno + ' ' + (persona.apellido_materno || '');
    const zonaNombre = zonasRegionales[persona.id_zona] || 'Sin zona';
    const directorios = persona.directorios || ['Sin directorios'];
    const estado = persona.activo ? 'Activo' : 'Inactivo';
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = 'modalEliminar';
    modal.innerHTML = `
        <div class="modal-card">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>¿Eliminar persona?</h3>
            </div>
            <div class="modal-body">
                <p><strong>¡Advertencia!</strong> Esta acción eliminará por completo el registro de la persona. Esta operación <strong>no se puede deshacer</strong>.</p>
                
                <div class="persona-info">
                    <div class="info-item">
                        <span class="info-label">Núm. Afiliación</span>
                        <span class="info-value">${persona.num_afiliacion}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nombre completo</span>
                        <span class="info-value">${nombreCompleto}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Institución</span>
                        <span class="info-value">${persona.institucion}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Facultad</span>
                        <span class="info-value">${persona.facultad || 'No especificada'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Zona</span>
                        <span class="info-value">${zonaNombre}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Cargo</span>
                        <span class="info-value">${persona.cargo}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Correo</span>
                        <span class="info-value">${persona.correo}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teléfono</span>
                        <span class="info-value">${persona.telefono}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Estado</span>
                        <span class="info-value">${estado}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Directorios</span>
                        <span class="info-value">
                            ${directorios.map(d => `<span class="tag-directorio-modal">${d}</span>`).join(' ')}
                        </span>
                    </div>
                </div>
                
                <p style="color:#c62828; font-weight:600; margin-top:0.75rem;">
                    <i class="fas fa-exclamation-circle"></i> 
                    Se perderá toda la información asociada a esta persona.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-modal-danger" onclick="confirmarEliminar(${id})">
                    <i class="fas fa-trash-alt"></i> Eliminar permanentemente
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });
}

function cerrarModal() {
    const modal = document.getElementById('modalEliminar');
    if (modal) {
        modal.remove();
    }
}

function confirmarEliminar(id) {
    const fila = document.querySelector(`tr[data-id="${id}"]`);
    if (fila) {
        fila.remove();
        
        const registrosMostrados = document.getElementById('registrosMostrados');
        if (registrosMostrados) {
            const actual = parseInt(registrosMostrados.textContent);
            registrosMostrados.textContent = actual - 1;
        }
        
        mostrarMensaje('Persona eliminada exitosamente', 'success');
    }
    
    cerrarModal();
}

// ============================================================
// MENSAJES EN LA PARTE SUPERIOR
// ============================================================

function mostrarMensaje(mensaje, tipo) {
    const mensajesAnteriores = document.querySelectorAll('.mensaje-flotante');
    mensajesAnteriores.forEach(el => el.remove());
    
    const div = document.createElement('div');
    div.className = `mensaje-flotante ${tipo}`;
    div.innerHTML = `
        <i class="fas ${tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        <div>
            <strong>${tipo === 'success' ? '¡Éxito!' : '¡Atención!'}</strong> ${mensaje}
        </div>
        <button class="btn-cerrar-mensaje" onclick="this.parentElement.remove()">
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

// ============================================================
// EXPORTAR CSV - TODOS LOS REGISTROS FILTRADOS
// ============================================================

function descargarCSV() {
    // Usar los datos filtrados completos (no solo los paginados)
    const datosFiltrados = <?= json_encode(array_values($personas_filtradas)) ?>;
    
    if (datosFiltrados.length === 0) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Núm. Afiliación,Nombre,Institución,Facultad,Cargo,Zona,Correo,Teléfono,Estado,Directorios\n';
    
    datosFiltrados.forEach(function(p) {
        const nombreCompleto = p.nombre + ' ' + p.apellido_paterno + (p.apellido_materno ? ' ' + p.apellido_materno : '');
        const zonaNombre = zonasRegionales[p.id_zona] || 'Sin zona';
        const directorios = p.directorios ? p.directorios.join('; ') : '';
        const estado = p.activo ? 'Activo' : 'Inactivo';
        const facultad = p.facultad || '';
        
        csv += `"${p.num_afiliacion}","${nombreCompleto}","${p.institucion}","${facultad}","${p.cargo}","${zonaNombre}","${p.correo}","${p.telefono}","${estado}","${directorios}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `personas_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
    
    mostrarMensaje('CSV exportado exitosamente', 'success');
}
</script>

<?php include 'template/footer.php'; ?>