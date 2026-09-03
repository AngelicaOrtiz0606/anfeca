<?php
// ============================================================
// SIDEANFECA - Catálogo de Cargos
// Listado de cargos registrados
// ============================================================

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// ============================================================
// DATOS SIMULADOS
// ============================================================

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

// Datos simulados de cargos
$cargos = [
    [
        'id' => 1,
        'nombre_m' => 'Presidente',
        'nombre_f' => 'Presidenta',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 2,
        'nombre_m' => 'Vicepresidente',
        'nombre_f' => 'Vicepresidenta',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 3,
        'nombre_m' => 'Secretario General',
        'nombre_f' => 'Secretaria General',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 4,
        'nombre_m' => 'Director Ejecutivo',
        'nombre_f' => 'Directora Ejecutiva',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 5,
        'nombre_m' => 'Coordinador Nacional',
        'nombre_f' => 'Coordinadora Nacional',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 3
    ],
    [
        'id' => 6,
        'nombre_m' => 'Director Regional',
        'nombre_f' => 'Directora Regional',
        'id_nivel' => 2,
        'activo' => true,
        'personas' => 4
    ],
    [
        'id' => 7,
        'nombre_m' => 'Secretario Regional',
        'nombre_f' => 'Secretaria Regional',
        'id_nivel' => 2,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 8,
        'nombre_m' => 'Coordinador Regional',
        'nombre_f' => 'Coordinadora Regional',
        'id_nivel' => 2,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 9,
        'nombre_m' => 'Director',
        'nombre_f' => 'Directora',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 5
    ],
    [
        'id' => 10,
        'nombre_m' => 'Director General',
        'nombre_f' => 'Directora General',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 11,
        'nombre_m' => 'Coordinador Académico',
        'nombre_f' => 'Coordinadora Académica',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 3
    ],
    [
        'id' => 12,
        'nombre_m' => 'Jefe de Departamento',
        'nombre_f' => 'Jefa de Departamento',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 6
    ],
    [
        'id' => 13,
        'nombre_m' => 'Rector',
        'nombre_f' => 'Rectora',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 14,
        'nombre_m' => 'Secretario Técnico General',
        'nombre_f' => 'Secretaria Técnica General',
        'id_nivel' => 1,
        'activo' => false,
        'personas' => 0
    ],
    [
        'id' => 15,
        'nombre_m' => 'Representante ANFECA ante ALAFEC',
        'nombre_f' => 'Representante ANFECA ante ALAFEC',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 16,
        'nombre_m' => 'Director General CACECA',
        'nombre_f' => 'Directora General CACECA',
        'id_nivel' => 1,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 17,
        'nombre_m' => 'Secretario Técnico',
        'nombre_f' => 'Secretaria Técnica',
        'id_nivel' => 2,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 18,
        'nombre_m' => 'Director Académico',
        'nombre_f' => 'Directora Académica',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 19,
        'nombre_m' => 'Director de Área',
        'nombre_f' => 'Directora de Área',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 20,
        'nombre_m' => 'Director de Contaduría',
        'nombre_f' => 'Directora de Contaduría',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 21,
        'nombre_m' => 'Director de División',
        'nombre_f' => 'Directora de División',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 3
    ],
    [
        'id' => 22,
        'nombre_m' => 'Director de División Económico-Administrativa',
        'nombre_f' => 'Directora de División Económico-Administrativa',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 23,
        'nombre_m' => 'Director de Carrera de LIN',
        'nombre_f' => 'Directora de Carrera de LIN',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 24,
        'nombre_m' => 'Coordinador de Licenciatura en Administración',
        'nombre_f' => 'Coordinadora de Licenciatura en Administración',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 25,
        'nombre_m' => 'Coordinador de Contaduría y Administración',
        'nombre_f' => 'Coordinadora de Contaduría y Administración',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 26,
        'nombre_m' => 'Coordinador de Licenciatura en Contaduría Pública',
        'nombre_f' => 'Coordinadora de Licenciatura en Contaduría Pública',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 27,
        'nombre_m' => 'Coordinador de la Facultad',
        'nombre_f' => 'Coordinadora de la Facultad',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 3
    ],
    [
        'id' => 28,
        'nombre_m' => 'Coordinador General',
        'nombre_f' => 'Coordinadora General',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 29,
        'nombre_m' => 'Coordinador de Negocios',
        'nombre_f' => 'Coordinadora de Negocios',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 30,
        'nombre_m' => 'Coordinador de Proyectos y Vinculación Institucional',
        'nombre_f' => 'Coordinadora de Proyectos y Vinculación Institucional',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 31,
        'nombre_m' => 'Coordinador de Unidad Académica',
        'nombre_f' => 'Coordinadora de Unidad Académica',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 32,
        'nombre_m' => 'Coordinador de Área Económico-Administrativa',
        'nombre_f' => 'Coordinadora de Área Económico-Administrativa',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 33,
        'nombre_m' => 'Coordinador de Ciencias Económico Administrativas',
        'nombre_f' => 'Coordinadora de Ciencias Económico Administrativas',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1
    ],
    [
        'id' => 34,
        'nombre_m' => 'Coordinador de Contaduría',
        'nombre_f' => 'Coordinadora de Contaduría',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 35,
        'nombre_m' => 'Jefe de Departamento de Ciencias Administrativas',
        'nombre_f' => 'Jefa de Departamento de Ciencias Administrativas',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 4
    ],
    [
        'id' => 36,
        'nombre_m' => 'Jefe de Departamento de Ciencias Económico Administrativas',
        'nombre_f' => 'Jefa de Departamento de Ciencias Económico Administrativas',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 37,
        'nombre_m' => 'Jefe del Departamento de Contabilidad',
        'nombre_f' => 'Jefa del Departamento de Contabilidad',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 2
    ],
    [
        'id' => 38,
        'nombre_m' => 'Encargado de la Dirección',
        'nombre_f' => 'Encargada de la Dirección',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 0
    ],
    [
        'id' => 39,
        'nombre_m' => 'Secretario',
        'nombre_f' => 'Secretaria',
        'id_nivel' => 3,
        'activo' => true,
        'personas' => 1
    ]
];

// Personas asociadas a cargos (para el historial)
$personas_asociadas = [
    1 => [
        ['id' => 1, 'nombre' => 'María González Pérez', 'institucion' => 'UNAM - Facultad de Contaduría', 'cargo' => 'Presidenta', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
    ],
    2 => [
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'institucion' => 'IPN - ESCOM', 'cargo' => 'Vicepresidente', 'titular' => true, 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Vicepresidente', 'titular' => false, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => '2024-12-31', 'activo' => false],
    ],
    4 => [
        ['id' => 4, 'nombre' => 'Ana Sánchez Ramírez', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Directora Ejecutiva', 'titular' => true, 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null, 'activo' => true],
    ],
    5 => [
        ['id' => 5, 'nombre' => 'Laura Torres Vega', 'institucion' => 'UABC - Mexicali', 'cargo' => 'Coordinadora Nacional', 'titular' => true, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 6, 'nombre' => 'Patricia Flores Reyes', 'institucion' => 'UAEH - Pachuca', 'cargo' => 'Coordinadora Nacional', 'titular' => false, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 7, 'nombre' => 'Sofía Reyes Gil', 'institucion' => 'UAM - Iztapalapa', 'cargo' => 'Coordinadora Nacional', 'titular' => true, 'fecha_inicio' => '2024-12-01', 'fecha_fin' => null, 'activo' => true],
    ],
    6 => [
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Director Regional', 'titular' => true, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 8, 'nombre' => 'Gabriela Mendoza Soto', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Directora Regional', 'titular' => false, 'fecha_inicio' => '2024-08-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 9, 'nombre' => 'Luis Méndez Vargas', 'institucion' => 'UABC - Tijuana', 'cargo' => 'Director Regional', 'titular' => false, 'fecha_inicio' => '2023-06-01', 'fecha_fin' => '2024-05-31', 'activo' => false],
        ['id' => 10, 'nombre' => 'Andrés Moreno Rojas', 'institucion' => 'UANL - San Nicolás', 'cargo' => 'Coordinador Regional', 'titular' => true, 'fecha_inicio' => '2024-10-01', 'fecha_fin' => null, 'activo' => true],
    ],
    8 => [
        ['id' => 6, 'nombre' => 'Patricia Flores Reyes', 'institucion' => 'UAEH - Pachuca', 'cargo' => 'Coordinadora Regional', 'titular' => true, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 10, 'nombre' => 'Andrés Moreno Rojas', 'institucion' => 'UANL - San Nicolás', 'cargo' => 'Coordinador Regional', 'titular' => false, 'fecha_inicio' => '2024-10-01', 'fecha_fin' => null, 'activo' => true],
    ],
    9 => [
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'cargo' => 'Director Académico', 'titular' => true, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 12, 'nombre' => 'Carmen Rivera Morales', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Coordinadora Académica', 'titular' => true, 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'institucion' => 'UAEM - Toluca', 'cargo' => 'Director de División', 'titular' => true, 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 14, 'nombre' => 'Ricardo Peña Fuentes', 'institucion' => 'UABJO - Oaxaca', 'cargo' => 'Jefe de Departamento', 'titular' => false, 'fecha_inicio' => '2023-12-01', 'fecha_fin' => '2024-11-30', 'activo' => false],
        ['id' => 15, 'nombre' => 'Elena Castro Ramos', 'institucion' => 'UASLP - San Luis Potosí', 'cargo' => 'Directora General', 'titular' => true, 'fecha_inicio' => '2024-09-01', 'fecha_fin' => null, 'activo' => true],
    ],
    10 => [
        ['id' => 15, 'nombre' => 'Elena Castro Ramos', 'institucion' => 'UASLP - San Luis Potosí', 'cargo' => 'Directora General', 'titular' => true, 'fecha_inicio' => '2024-09-01', 'fecha_fin' => null, 'activo' => true],
    ],
    11 => [
        ['id' => 12, 'nombre' => 'Carmen Rivera Morales', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Coordinadora Académica', 'titular' => true, 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'institucion' => 'UAEM - Toluca', 'cargo' => 'Directora de División', 'titular' => false, 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'cargo' => 'Director Académico', 'titular' => false, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
    ],
    12 => [
        ['id' => 14, 'nombre' => 'Ricardo Peña Fuentes', 'institucion' => 'UABJO - Oaxaca', 'cargo' => 'Jefe de Departamento', 'titular' => false, 'fecha_inicio' => '2023-12-01', 'fecha_fin' => '2024-11-30', 'activo' => false],
        ['id' => 1, 'nombre' => 'María González Pérez', 'institucion' => 'UNAM - Facultad de Contaduría', 'cargo' => 'Jefa de Departamento', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Jefe de Departamento', 'titular' => false, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 4, 'nombre' => 'Ana Sánchez Ramírez', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Jefa de Departamento', 'titular' => true, 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 6, 'nombre' => 'Patricia Flores Reyes', 'institucion' => 'UAEH - Pachuca', 'cargo' => 'Jefa de Departamento', 'titular' => false, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 16, 'nombre' => 'Fernando Cruz Salazar', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Jefe de Departamento', 'titular' => true, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
    ],
    15 => [
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Representante ANFECA ante ALAFEC', 'titular' => true, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
    ],
    17 => [
        ['id' => 9, 'nombre' => 'Luis Méndez Vargas', 'institucion' => 'UABC - Tijuana', 'cargo' => 'Secretario Técnico', 'titular' => false, 'fecha_inicio' => '2023-06-01', 'fecha_fin' => '2024-05-31', 'activo' => false],
        ['id' => 10, 'nombre' => 'Andrés Moreno Rojas', 'institucion' => 'UANL - San Nicolás', 'cargo' => 'Secretario Técnico', 'titular' => true, 'fecha_inicio' => '2024-10-01', 'fecha_fin' => null, 'activo' => true],
    ],
    18 => [
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'cargo' => 'Director Académico', 'titular' => true, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
    ],
    19 => [
        ['id' => 12, 'nombre' => 'Carmen Rivera Morales', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Directora de Área', 'titular' => true, 'fecha_inicio' => '2024-05-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'institucion' => 'UAEM - Toluca', 'cargo' => 'Directora de Área', 'titular' => false, 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
    ],
    21 => [
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'cargo' => 'Director de División', 'titular' => false, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 14, 'nombre' => 'Ricardo Peña Fuentes', 'institucion' => 'UABJO - Oaxaca', 'cargo' => 'Director de División', 'titular' => false, 'fecha_inicio' => '2023-12-01', 'fecha_fin' => '2024-11-30', 'activo' => false],
        ['id' => 15, 'nombre' => 'Elena Castro Ramos', 'institucion' => 'UASLP - San Luis Potosí', 'cargo' => 'Directora de División', 'titular' => true, 'fecha_inicio' => '2024-09-01', 'fecha_fin' => null, 'activo' => true],
    ],
    23 => [
        ['id' => 1, 'nombre' => 'María González Pérez', 'institucion' => 'UNAM - Facultad de Contaduría', 'cargo' => 'Directora de Carrera de LIN', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
    ],
    25 => [
        ['id' => 4, 'nombre' => 'Ana Sánchez Ramírez', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Coordinadora de Contaduría y Administración', 'titular' => true, 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 16, 'nombre' => 'Fernando Cruz Salazar', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Coordinador de Contaduría y Administración', 'titular' => false, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
    ],
    27 => [
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'institucion' => 'UAEM - Toluca', 'cargo' => 'Coordinadora de la Facultad', 'titular' => true, 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'cargo' => 'Coordinador de la Facultad', 'titular' => false, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 14, 'nombre' => 'Ricardo Peña Fuentes', 'institucion' => 'UABJO - Oaxaca', 'cargo' => 'Coordinador de la Facultad', 'titular' => false, 'fecha_inicio' => '2023-12-01', 'fecha_fin' => '2024-11-30', 'activo' => false],
    ],
    28 => [
        ['id' => 7, 'nombre' => 'Sofía Reyes Gil', 'institucion' => 'UAM - Iztapalapa', 'cargo' => 'Coordinadora General', 'titular' => true, 'fecha_inicio' => '2024-12-01', 'fecha_fin' => null, 'activo' => true],
    ],
    31 => [
        ['id' => 13, 'nombre' => 'Teresa Ortega Luna', 'institucion' => 'UAEM - Toluca', 'cargo' => 'Coordinadora de Unidad Académica', 'titular' => false, 'fecha_inicio' => '2024-11-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 11, 'nombre' => 'Jorge Gómez García', 'institucion' => 'UADY - Mérida', 'cargo' => 'Coordinador de Unidad Académica', 'titular' => true, 'fecha_inicio' => '2024-08-01', 'fecha_fin' => null, 'activo' => true],
    ],
    33 => [
        ['id' => 16, 'nombre' => 'Fernando Cruz Salazar', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Coordinador de Ciencias Económico Administrativas', 'titular' => true, 'fecha_inicio' => '2024-07-01', 'fecha_fin' => null, 'activo' => true],
    ],
    35 => [
        ['id' => 4, 'nombre' => 'Ana Sánchez Ramírez', 'institucion' => 'UAQ - Querétaro', 'cargo' => 'Jefa de Departamento de Ciencias Administrativas', 'titular' => false, 'fecha_inicio' => '2024-06-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 1, 'nombre' => 'María González Pérez', 'institucion' => 'UNAM - Facultad de Contaduría', 'cargo' => 'Jefa de Departamento de Ciencias Administrativas', 'titular' => true, 'fecha_inicio' => '2024-01-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Jefe de Departamento de Ciencias Administrativas', 'titular' => false, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
        ['id' => 6, 'nombre' => 'Patricia Flores Reyes', 'institucion' => 'UAEH - Pachuca', 'cargo' => 'Jefa de Departamento de Ciencias Administrativas', 'titular' => true, 'fecha_inicio' => '2024-04-01', 'fecha_fin' => null, 'activo' => true],
    ],
    37 => [
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'institucion' => 'IPN - ESCOM', 'cargo' => 'Jefe del Departamento de Contabilidad', 'titular' => true, 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true],
        ['id' => 3, 'nombre' => 'Carlos Hernández Díaz', 'institucion' => 'UDG - Guadalajara', 'cargo' => 'Jefe del Departamento de Contabilidad', 'titular' => false, 'fecha_inicio' => '2024-02-01', 'fecha_fin' => null, 'activo' => true],
    ],
    39 => [
        ['id' => 2, 'nombre' => 'Juan Martínez López', 'institucion' => 'IPN - ESCOM', 'cargo' => 'Secretario', 'titular' => true, 'fecha_inicio' => '2024-03-15', 'fecha_fin' => null, 'activo' => true],
    ]
];

// ID máximo para nuevos registros
$ultimo_id = count($cargos);

// ============================================================
// PROCESAR ACCIONES DEL CRUD (SIMULADO)
// ============================================================

$mensaje = '';
$error = '';
$accion = isset($_GET['accion']) ? $_GET['accion'] : '';
$id_editar = isset($_GET['editar']) ? (int)$_GET['editar'] : 0;
$cargo_editar = null;

// Eliminar cargo
if ($accion === 'eliminar' && isset($_GET['id'])) {
    $id_eliminar = (int)$_GET['id'];
    $en_uso = [1, 2, 3];
    
    if (in_array($id_eliminar, $en_uso)) {
        $error = 'No se puede eliminar el cargo porque está siendo utilizado en puestos.';
    } else {
        if (isset($personas_asociadas[$id_eliminar]) && count($personas_asociadas[$id_eliminar]) > 0) {
            $error = 'No se puede eliminar el cargo porque tiene ' . count($personas_asociadas[$id_eliminar]) . ' persona(s) asociada(s).';
        } else {
            foreach ($cargos as $key => $c) {
                if ($c['id'] == $id_eliminar) {
                    unset($cargos[$key]);
                    $mensaje = 'Cargo eliminado exitosamente';
                    break;
                }
            }
            $cargos = array_values($cargos);
        }
    }
}

// Obtener cargo para editar
if ($id_editar > 0) {
    foreach ($cargos as $c) {
        if ($c['id'] == $id_editar) {
            $cargo_editar = $c;
            break;
        }
    }
}

// Procesar formulario (Registro/Edición)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];
    
    $nombre_m = trim($_POST['nombre_m'] ?? '');
    $nombre_f = trim($_POST['nombre_f'] ?? '');
    $id_nivel = (int)($_POST['id_nivel'] ?? 0);
    $activo = isset($_POST['activo']) ? true : false;
    $id_cargo = isset($_POST['id_cargo']) ? (int)$_POST['id_cargo'] : 0;
    
    if (empty($nombre_m)) $errores[] = 'Nombre en masculino';
    if (empty($nombre_f)) $errores[] = 'Nombre en femenino';
    if ($id_nivel <= 0) $errores[] = 'Nivel de cargo';
    
    if (empty($errores)) {
        if ($id_cargo > 0) {
            $cargo_encontrado = false;
            foreach ($cargos as $key => $c) {
                if ($c['id'] == $id_cargo) {
                    $cargos[$key]['nombre_m'] = $nombre_m;
                    $cargos[$key]['nombre_f'] = $nombre_f;
                    $cargos[$key]['id_nivel'] = $id_nivel;
                    $cargos[$key]['activo'] = $activo;
                    $cargo_encontrado = true;
                    $mensaje = 'Cargo actualizado exitosamente';
                    break;
                }
            }
            if (!$cargo_encontrado) {
                $error = 'Cargo no encontrado';
            }
        } else {
            $ultimo_id++;
            $cargos[] = [
                'id' => $ultimo_id,
                'nombre_m' => $nombre_m,
                'nombre_f' => $nombre_f,
                'id_nivel' => $id_nivel,
                'activo' => $activo,
                'personas' => 0
            ];
            $mensaje = 'Cargo registrado exitosamente';
        }
    } else {
        $error = 'Complete los campos obligatorios: ' . implode(', ', $errores);
    }
}

// ============================================================
// FILTROS Y ORDENAMIENTO
// ============================================================

$nivel_filtro = isset($_GET['nivel']) ? (int)$_GET['nivel'] : 0;
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : '';
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

$orden_columna = isset($_GET['orden_columna']) ? $_GET['orden_columna'] : '';
$orden_direccion = isset($_GET['orden_direccion']) ? $_GET['orden_direccion'] : 'asc';

// Paginación
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registros_por_pagina = 6;

$cargos_filtrados = $cargos;

// Aplicar filtros
if (!empty($busqueda)) {
    $busqueda = strtolower($busqueda);
    $cargos_filtrados = array_filter($cargos_filtrados, function($c) use ($busqueda) {
        return strpos(strtolower($c['nombre_m']), $busqueda) !== false ||
               strpos(strtolower($c['nombre_f']), $busqueda) !== false;
    });
}

if ($nivel_filtro > 0) {
    $cargos_filtrados = array_filter($cargos_filtrados, function($c) use ($nivel_filtro) {
        return $c['id_nivel'] == $nivel_filtro;
    });
}

if ($estado_filtro == 'activo') {
    $cargos_filtrados = array_filter($cargos_filtrados, function($c) {
        return $c['activo'] == true;
    });
} elseif ($estado_filtro == 'inactivo') {
    $cargos_filtrados = array_filter($cargos_filtrados, function($c) {
        return $c['activo'] == false;
    });
}

// Ordenar
if (!empty($orden_columna)) {
    usort($cargos_filtrados, function($a, $b) use ($orden_columna, $orden_direccion) {
        $valor_a = '';
        $valor_b = '';
        
        switch ($orden_columna) {
            case 'nombre_m':
                $valor_a = $a['nombre_m'];
                $valor_b = $b['nombre_m'];
                break;
            case 'nombre_f':
                $valor_a = $a['nombre_f'];
                $valor_b = $b['nombre_f'];
                break;
            case 'nivel':
                $valor_a = $a['id_nivel'];
                $valor_b = $b['id_nivel'];
                break;
            case 'personas':
                $valor_a = $a['personas'] ?? 0;
                $valor_b = $b['personas'] ?? 0;
                break;
            case 'activo':
                $valor_a = $a['activo'] ? 1 : 0;
                $valor_b = $b['activo'] ? 1 : 0;
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
$total_registros = count($cargos_filtrados);
$total_paginas = ceil($total_registros / $registros_por_pagina);

if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $total_paginas && $total_paginas > 0) $pagina_actual = $total_paginas;

$offset = ($pagina_actual - 1) * $registros_por_pagina;
$cargos_paginados = array_slice($cargos_filtrados, $offset, $registros_por_pagina);

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-header-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div>
                    <h1 class="page-title">Catálogo de Cargos</h1>
                    <p class="page-subtitle">Administre los cargos que pueden ser asignados a las personas en el sistema</p>
                </div>
            </div>
            <div class="page-header-right">
                <button onclick="descargarCSV()" class="btn-outline-modern">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </button>
                <a href="cargo_registro.php" class="btn-primary-modern">
                    <i class="fas fa-plus-circle"></i> Nuevo Cargo
                </a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="alert-modern alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>¡Excelente!</strong> <?= htmlspecialchars($mensaje) ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-modern alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Por favor revise</strong> <?= htmlspecialchars($error) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filtros y búsqueda -->
        <div class="filters-container">
            <form method="GET" id="formFiltros" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <i class="fas fa-search filter-icon"></i>
                        <input type="text" name="buscar" class="filter-input" 
                               placeholder="Buscar por nombre..." 
                               value="<?= htmlspecialchars($busqueda) ?>" id="buscarCargo"
                               autocomplete="off">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Nivel</label>
                        <select name="nivel" class="filter-select" id="filtroNivel">
                            <option value="0">Todos</option>
                            <?php foreach ($niveles_cargo as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= $nivel_filtro == $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombre) ?>
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
                    
                    <button type="submit" class="btn-filter-apply">
                        <i class="fas fa-sliders-h"></i> Aplicar
                    </button>
                    
                    <a href="cargos.php" class="btn-filter-clear <?= (empty($busqueda) && $nivel_filtro == 0 && empty($estado_filtro)) ? 'disabled' : '' ?>">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
            
            <div class="filters-results">
                <span class="results-count">
                    <i class="fas fa-briefcase"></i> 
                    <strong id="registrosMostrados"><?= count($cargos_filtrados) ?></strong> 
                    cargo(s) encontrado(s)
                </span>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-modern-container">
            <div class="table-modern-wrapper">
                <table class="table-modern" id="tablaCargos">
                    <thead>
                        <tr>
                            <th class="col-nombre-m">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nombre_m', 'orden_direccion' => ($orden_columna == 'nombre_m' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'nombre_m' ? 'active' : '' ?>">
                                    <span class="sort-label">Nombre (Masculino)</span>
                                    <?php if ($orden_columna == 'nombre_m'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-nombre-f">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nombre_f', 'orden_direccion' => ($orden_columna == 'nombre_f' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'nombre_f' ? 'active' : '' ?>">
                                    <span class="sort-label">Nombre (Femenino)</span>
                                    <?php if ($orden_columna == 'nombre_f'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-nivel">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'nivel', 'orden_direccion' => ($orden_columna == 'nivel' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'nivel' ? 'active' : '' ?>">
                                    <span class="sort-label">Nivel</span>
                                    <?php if ($orden_columna == 'nivel'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-personas">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'personas', 'orden_direccion' => ($orden_columna == 'personas' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'personas' ? 'active' : '' ?>">
                                    <span class="sort-label">Personas</span>
                                    <?php if ($orden_columna == 'personas'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-estado">
                                <a href="?<?= http_build_query(array_merge($_GET, ['orden_columna' => 'activo', 'orden_direccion' => ($orden_columna == 'activo' && $orden_direccion == 'asc') ? 'desc' : 'asc', 'pagina' => 1])) ?>" 
                                   class="sort-link <?= $orden_columna == 'activo' ? 'active' : '' ?>">
                                    <span class="sort-label">Estado</span>
                                    <?php if ($orden_columna == 'activo'): ?>
                                        <i class="fas fa-chevron-<?= $orden_direccion == 'asc' ? 'up' : 'down' ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-sort sort-icon-inactive"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyCargos">
                        <?php if (count($cargos_paginados) > 0): ?>
                            <?php foreach ($cargos_paginados as $cargo): 
                                $nivel_nombre = $niveles_cargo[$cargo['id_nivel']] ?? 'Sin nivel';
                                $estado_texto = $cargo['activo'] ? 'Activo' : 'Inactivo';
                                $estado_class = $cargo['activo'] ? 'status-active' : 'status-inactive';
                                $puede_eliminar = !in_array($cargo['id'], [1, 2, 3]);
                                $personas = $cargo['personas'] ?? 0;
                                $personas_class = $personas > 0 ? 'badge-personas-activo' : 'badge-personas-vacio';
                            ?>
                            <tr data-id="<?= $cargo['id'] ?>">
                                <td>
                                    <div class="cargo-cell">
                                        <div class="cargo-nombre"><?= htmlspecialchars($cargo['nombre_m']) ?></div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($cargo['nombre_f']) ?></td>
                                <td>
                                    <span class="badge-nivel 
                                        <?= $cargo['id_nivel'] == 1 ? 'badge-nacional' : '' ?>
                                        <?= $cargo['id_nivel'] == 2 ? 'badge-regional' : '' ?>
                                        <?= $cargo['id_nivel'] == 3 ? 'badge-institucional' : '' ?>">
                                        <?= htmlspecialchars($nivel_nombre) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-personas <?= $personas_class ?>">
                                        <?= $personas ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="<?= $estado_class ?>">
                                        <i class="fas fa-circle"></i> <?= $estado_texto ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="acciones-group">
                                        <a href="cargo_consulta.php?id=<?= $cargo['id'] ?>" class="btn-accion btn-ver" title="Consultar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="cargo_edicion.php?id=<?= $cargo['id'] ?>" class="btn-accion btn-editar" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <?php if ($puede_eliminar): ?>
                                            <button onclick="eliminarCargo(<?= $cargo['id'] ?>)" class="btn-accion btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn-accion btn-eliminar btn-eliminar-bloqueado" title="No se puede eliminar (en uso)">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-row">
                                    <i class="fas fa-briefcase"></i>
                                    <p>No se encontraron cargos con los filtros aplicados</p>
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
                    Mostrando <strong><?= count($cargos_paginados) ?></strong> de <strong><?= $total_registros ?></strong> registros
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
            
            <div class="table-modern-footer">
                <span>Mostrando <strong><?= count($cargos_paginados) ?></strong> de <strong><?= $total_registros ?></strong> registros</span>
            </div>
        </div>

    </div>
</main>

<style>
/* ============================================================
   ESTILOS - LISTADO DE CARGOS
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

.btn-filter-apply {
    padding: 0.5rem 1.25rem;
    background: #8B0000;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-filter-apply:hover {
    background: #5C0000;
    transform: translateY(-1px);
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
    table-layout: fixed;
    min-width: 700px;
}

.table-modern thead {
    background: #f8f6f6;
}

.table-modern thead th {
    text-align: left;
    padding: 0.8rem 0.8rem;
    font-weight: 600;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6b6b6b;
    border-bottom: 2px solid #e8e8e8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.col-nombre-m {
    width: 22%;
    min-width: 140px;
}
.col-nombre-f {
    width: 22%;
    min-width: 140px;
}
.col-nivel {
    width: 14%;
    min-width: 90px;
}
.col-personas {
    width: 10%;
    min-width: 70px;
}
.col-estado {
    width: 12%;
    min-width: 80px;
}
.col-acciones {
    width: 16%;
    min-width: 110px;
}

.table-modern tbody td {
    padding: 0.7rem 0.8rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table-modern tbody td .cargo-nombre {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.table-modern tbody tr:hover {
    background: #faf8f8;
}

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

.badge-nivel {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-nacional {
    background: #e3f2fd;
    color: #0d47a1;
}

.badge-regional {
    background: #f3e5f5;
    color: #6a1b9a;
}

.badge-institucional {
    background: #e8f5e9;
    color: #1b5e20;
}

.badge-personas {
    display: inline-block;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    min-width: 28px;
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

.cargo-nombre {
    font-weight: 600;
    color: #1a1a1a;
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

.acciones-group {
    display: flex;
    gap: 0.3rem;
    flex-wrap: wrap;
}

.btn-accion {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    flex-shrink: 0;
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

.table-modern-footer {
    padding: 0.8rem 1.25rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    font-size: 0.85rem;
    color: #6b6b6b;
    display: none;
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

@media (max-width: 992px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        min-width: auto;
        max-width: none;
    }

    .btn-filter-apply,
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
        min-width: 650px;
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
        min-width: 580px;
        font-size: 0.7rem;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.4rem 0.4rem;
    }

    .col-nombre-m {
        min-width: 100px;
    }
    .col-nombre-f {
        min-width: 100px;
    }
    .col-nivel {
        min-width: 70px;
    }
    .col-personas {
        min-width: 55px;
    }
    .col-estado {
        min-width: 60px;
    }
    .col-acciones {
        min-width: 90px;
    }

    .btn-accion {
        width: 24px;
        height: 24px;
        font-size: 0.55rem;
        border-radius: 6px;
    }

    .badge-nivel {
        font-size: 0.6rem;
        padding: 0.15rem 0.5rem;
    }
}
</style>

<script>
// ============================================================
// DATOS
// ============================================================

const nivelesCargo = <?= json_encode($niveles_cargo) ?>;
const cargosData = <?= json_encode($cargos) ?>;
const personasAsociadas = <?= json_encode($personas_asociadas) ?>;

// ============================================================
// BÚSQUEDA Y FILTROS EN TIEMPO REAL
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarCargo');
    const filtroNivel = document.getElementById('filtroNivel');
    const filtroEstado = document.getElementById('filtroEstado');
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
    
    if (filtroNivel) {
        filtroNivel.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
    
    if (filtroEstado) {
        filtroEstado.addEventListener('change', function() {
            formFiltros.submit();
        });
    }
});

// ============================================================
// ELIMINAR CARGO
// ============================================================

function eliminarCargo(id) {
    const cargo = cargosData.find(c => c.id === id);
    if (!cargo) {
        mostrarMensaje('No se encontró el cargo', 'error');
        return;
    }
    
    const personas = personasAsociadas[id] || [];
    const totalPersonas = personas.length;
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = 'modalEliminar';
    
    let contenidoBody = '';
    if (totalPersonas > 0) {
        contenidoBody = `
            <p style="color:#c62828;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> 
                Este cargo tiene <strong>${totalPersonas} persona(s)</strong> asociada(s).
            </p>
            <p>Para poder eliminar este cargo, primero debe eliminar o reasignar todas las personas asociadas.</p>
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Cargo</span>
                    <span style="color:#1a1a1a;">${cargo.nombre_m} / ${cargo.nombre_f}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Personas asociadas</span>
                    <span style="color:#c62828;font-weight:600;">${totalPersonas}</span>
                </div>
            </div>
        `;
    } else {
        contenidoBody = `
            <p><strong>¡Advertencia!</strong> Esta acción eliminará el cargo del sistema. Esta operación <strong>no se puede deshacer</strong>.</p>
            
            <div style="background:#faf8f8;padding:1rem;border-radius:10px;border:1px solid #f0ecec;margin:0.75rem 0;">
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Cargo</span>
                    <span style="color:#1a1a1a;">${cargo.nombre_m} / ${cargo.nombre_f}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;border-bottom:1px solid #f0ecec;">
                    <span style="font-weight:600;color:#666;width:120px;">Nivel</span>
                    <span style="color:#1a1a1a;">${nivelesCargo[cargo.id_nivel] || 'Sin nivel'}</span>
                </div>
                <div style="display:flex;padding:0.3rem 0;">
                    <span style="font-weight:600;color:#666;width:120px;">Estado</span>
                    <span style="color:#1a1a1a;">${cargo.activo ? 'Activo' : 'Inactivo'}</span>
                </div>
            </div>
            
            <p style="color:#c62828;font-weight:600;margin-top:0.75rem;">
                <i class="fas fa-exclamation-circle"></i> 
                Se perderá toda la información asociada a este cargo.
            </p>
        `;
    }
    
    modal.innerHTML = `
        <div class="modal-card modal-card-cargo">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle" style="color:${totalPersonas > 0 ? '#e65100' : '#dc3545'};"></i>
                <h3>${totalPersonas > 0 ? 'No se puede eliminar' : '¿Eliminar cargo?'}</h3>
                <button onclick="cerrarModalEliminar()" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#999;margin-left:auto;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                ${contenidoBody}
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" onclick="cerrarModalEliminar()">${totalPersonas > 0 ? 'Entendido' : 'Cancelar'}</button>
                ${totalPersonas > 0 ? `
                    <button class="btn-modal-primary" style="background:#e65100;cursor:not-allowed;opacity:0.6;" disabled>
                        <i class="fas fa-lock"></i> No se puede eliminar
                    </button>
                ` : `
                    <button class="btn-modal-primary" style="background:#dc3545;" onclick="confirmarEliminar(${id})">
                        <i class="fas fa-trash-alt"></i> Eliminar permanentemente
                    </button>
                `}
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';
}

function cerrarModalEliminar() {
    const modal = document.getElementById('modalEliminar');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function confirmarEliminar(id) {
    window.location.href = `cargos.php?accion=eliminar&id=${id}`;
}

// ============================================================
// MENSAJES
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
// EXPORTAR CSV
// ============================================================

function descargarCSV() {
    const filas = document.querySelectorAll('#tbodyCargos tr');
    if (filas.length === 0 || (filas.length === 1 && filas[0].classList.contains('empty-row'))) {
        mostrarMensaje('No hay datos para exportar', 'error');
        return;
    }
    
    let csv = 'Nombre (Masculino),Nombre (Femenino),Nivel,Personas,Estado\n';
    
    filas.forEach(fila => {
        if (fila.classList.contains('empty-row')) return;
        
        const celdas = fila.querySelectorAll('td');
        if (celdas.length < 6) return;
        
        const nombreM = celdas[0].textContent.trim();
        const nombreF = celdas[1].textContent.trim();
        const nivel = celdas[2].textContent.trim();
        const personas = celdas[3].textContent.trim();
        const estado = celdas[4].textContent.trim();
        
        csv += `"${nombreM}","${nombreF}","${nivel}","${personas}","${estado}"\n`;
    });
    
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `cargos_${new Date().toISOString().slice(0,10)}.csv`;
    link.click();
    
    mostrarMensaje('CSV exportado exitosamente', 'success');
}
</script>

<?php include 'template/footer.php'; ?>