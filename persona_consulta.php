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
// OBTENER ID DE LA PERSONA
// ============================================================

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// ============================================================
// DATOS SIMULADOS DE LAS PERSONAS (mismos que en personas.php)
// ============================================================

$zonas_regionales = [
    1 => 'Noroeste',
    2 => 'Norte',
    3 => 'Centro',
    4 => 'Centro Occidente',
    5 => 'Centro Sur',
    6 => 'Sur',
    7 => 'Ciudad de México'
];

$tipos_institucion = [
    1 => 'Universidad',
    2 => 'Facultad',
    3 => 'Campus'
];

$niveles_cargo = [
    1 => 'Nacional',
    2 => 'Regional',
    3 => 'Institucional'
];

$tipos_directorio = [
    1 => 'Consejo Nacional Directivo',
    2 => 'Consejos Regionales',
    3 => 'Coordinaciones Nacionales',
    4 => 'Instituciones'
];

// Datos de todas las personas (mismos que en personas.php)
$personas_data = [
    [
        'id' => 1,
        'num_afiliacion' => '9801001',
        'nombre' => 'María',
        'apellido_paterno' => 'González',
        'apellido_materno' => 'Pérez',
        'genero' => 'F',
        'id_zona' => 7,
        'institucion' => 'UNAM - Facultad de Contaduría',
        'tipo_institucion' => 2,
        'nivel_academico' => 'Maestría (Mtra.)',
        'telefonos' => [
            ['lada' => '55', 'numero' => '1234 5678', 'extension' => '123', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'maria.gonzalez@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '55', 'numero' => '9876 5432', 'visible' => true]
        ],
        'cargos' => [
            [
                'nivel' => 1,
                'nivel_nombre' => 'Nacional',
                'nombre' => 'Presidenta',
                'zona' => null,
                'coordinacion' => null,
                'fecha_inicio' => '01/01/2024',
                'fecha_fin' => null,
                'directorios' => ['Consejo Nacional Directivo', 'Coordinaciones Nacionales']
            ]
        ]
    ],
    [
        'id' => 2,
        'num_afiliacion' => '9801002',
        'nombre' => 'Juan',
        'apellido_paterno' => 'Martínez',
        'apellido_materno' => 'López',
        'genero' => 'M',
        'id_zona' => 7,
        'institucion' => 'IPN - ESCOM',
        'tipo_institucion' => 2,
        'nivel_academico' => 'Doctorado (Dr.)',
        'telefonos' => [
            ['lada' => '55', 'numero' => '9876 5432', 'extension' => '', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'juan.martinez@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '55', 'numero' => '9876 5432', 'visible' => false]
        ],
        'cargos' => [
            [
                'nivel' => 1,
                'nivel_nombre' => 'Nacional',
                'nombre' => 'Coordinador Nacional',
                'zona' => null,
                'coordinacion' => null,
                'fecha_inicio' => '15/03/2024',
                'fecha_fin' => null,
                'directorios' => ['Consejo Nacional Directivo']
            ]
        ]
    ],
    [
        'id' => 3,
        'num_afiliacion' => '9801003',
        'nombre' => 'Ana',
        'apellido_paterno' => 'Sánchez',
        'apellido_materno' => 'Ramírez',
        'genero' => 'F',
        'id_zona' => 3,
        'institucion' => 'UAQ - Querétaro',
        'tipo_institucion' => 1,
        'nivel_academico' => 'Licenciatura (Lic.)',
        'telefonos' => [
            ['lada' => '44', 'numero' => '1234 5678', 'extension' => '', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'ana.sanchez@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '44', 'numero' => '9876 5432', 'visible' => false]
        ],
        'cargos' => [
            [
                'nivel' => 1,
                'nivel_nombre' => 'Nacional',
                'nombre' => 'Secretaria General',
                'zona' => null,
                'coordinacion' => null,
                'fecha_inicio' => '01/06/2024',
                'fecha_fin' => null,
                'directorios' => ['Consejos Regionales', 'Coordinaciones Nacionales']
            ],
            [
                'nivel' => 2,
                'nivel_nombre' => 'Regional',
                'nombre' => 'Coordinadora Regional',
                'zona' => 'Centro',
                'coordinacion' => 'Academia ANFECA',
                'fecha_inicio' => '01/01/2023',
                'fecha_fin' => '31/12/2023',
                'directorios' => ['Consejos Regionales']
            ]
        ]
    ],
    [
        'id' => 4,
        'num_afiliacion' => '9801004',
        'nombre' => 'Carlos',
        'apellido_paterno' => 'Hernández',
        'apellido_materno' => 'Díaz',
        'genero' => 'M',
        'id_zona' => 4,
        'institucion' => 'UDG - Guadalajara',
        'tipo_institucion' => 1,
        'nivel_academico' => 'Maestría (Mtro.)',
        'telefonos' => [
            ['lada' => '33', 'numero' => '1234 5678', 'extension' => '', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'carlos.hernandez@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '33', 'numero' => '9876 5432', 'visible' => true]
        ],
        'cargos' => [
            [
                'nivel' => 2,
                'nivel_nombre' => 'Regional',
                'nombre' => 'Director Regional',
                'zona' => 'Centro Occidente',
                'coordinacion' => null,
                'fecha_inicio' => '01/02/2024',
                'fecha_fin' => null,
                'directorios' => ['Consejos Regionales']
            ]
        ]
    ],
    [
        'id' => 5,
        'num_afiliacion' => '9801005',
        'nombre' => 'Laura',
        'apellido_paterno' => 'Torres',
        'apellido_materno' => 'Vega',
        'genero' => 'F',
        'id_zona' => 1,
        'institucion' => 'UABC - Mexicali',
        'tipo_institucion' => 2,
        'nivel_academico' => 'Licenciatura (Lic.)',
        'telefonos' => [
            ['lada' => '66', 'numero' => '1234 5678', 'extension' => '', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'laura.torres@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '66', 'numero' => '9876 5432', 'visible' => false]
        ],
        'cargos' => [
            [
                'nivel' => 2,
                'nivel_nombre' => 'Regional',
                'nombre' => 'Coordinadora Regional',
                'zona' => 'Noroeste',
                'coordinacion' => 'Certificación Académica',
                'fecha_inicio' => '01/07/2024',
                'fecha_fin' => null,
                'directorios' => ['Coordinaciones Nacionales']
            ]
        ]
    ],
    [
        'id' => 6,
        'num_afiliacion' => '9801006',
        'nombre' => 'Roberto',
        'apellido_paterno' => 'Mendoza',
        'apellido_materno' => 'Cruz',
        'genero' => 'M',
        'id_zona' => 2,
        'institucion' => 'UANL - San Nicolás',
        'tipo_institucion' => 1,
        'nivel_academico' => 'Maestría (Mtro.)',
        'telefonos' => [
            ['lada' => '81', 'numero' => '1234 5678', 'extension' => '', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'roberto.mendoza@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '81', 'numero' => '9876 5432', 'visible' => false]
        ],
        'cargos' => [
            [
                'nivel' => 2,
                'nivel_nombre' => 'Regional',
                'nombre' => 'Secretario Regional',
                'zona' => 'Norte',
                'coordinacion' => null,
                'fecha_inicio' => '01/01/2023',
                'fecha_fin' => '01/01/2024',
                'directorios' => ['Instituciones']
            ]
        ]
    ],
    [
        'id' => 7,
        'num_afiliacion' => '9801007',
        'nombre' => 'Patricia',
        'apellido_paterno' => 'Flores',
        'apellido_materno' => 'Reyes',
        'genero' => 'F',
        'id_zona' => 5,
        'institucion' => 'UAEH - Pachuca',
        'tipo_institucion' => 2,
        'nivel_academico' => 'Doctorado (Dra.)',
        'telefonos' => [
            ['lada' => '77', 'numero' => '1234 5678', 'extension' => '', 'visible' => true]
        ],
        'correos' => [
            ['valor' => 'patricia.flores@example.com', 'visible' => true]
        ],
        'celulares' => [
            ['lada' => '77', 'numero' => '9876 5432', 'visible' => true]
        ],
        'cargos' => [
            [
                'nivel' => 2,
                'nivel_nombre' => 'Regional',
                'nombre' => 'Coordinadora Regional',
                'zona' => 'Centro Sur',
                'coordinacion' => 'Investigación',
                'fecha_inicio' => '01/04/2024',
                'fecha_fin' => null,
                'directorios' => ['Coordinaciones Nacionales', 'Instituciones']
            ]
        ]
    ]
];

// Buscar la persona por ID
$persona = null;
foreach ($personas_data as $p) {
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

// Determinar estado basado en cargos
$tiene_cargo_activo = false;
foreach ($persona['cargos'] as $cargo) {
    if ($cargo['fecha_fin'] === null) {
        $tiene_cargo_activo = true;
        break;
    }
}
$persona['activo'] = $tiene_cargo_activo;

// Agregar zona_nombre
$persona['zona_nombre'] = $zonas_regionales[$persona['id_zona']] ?? 'Sin zona';

// Agregar tipo_institucion_nombre
$persona['tipo_institucion_nombre'] = $tipos_institucion[$persona['tipo_institucion']] ?? 'No especificado';

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
                        <?php 
                        $iniciales = substr($persona['nombre'], 0, 1) . substr($persona['apellido_paterno'], 0, 1);
                        ?>
                        <span><?= $iniciales ?></span>
                    </div>
                    <div class="profile-info">
                        <h2><?= htmlspecialchars($persona['nombre'] . ' ' . $persona['apellido_paterno'] . ' ' . $persona['apellido_materno']) ?></h2>
                        <div class="profile-meta">
                            <span class="profile-afiliacion">
                                <span class="afiliacion-label">Núm. Afiliación:</span>
                                <span class="afiliacion-value"><?= htmlspecialchars($persona['num_afiliacion']) ?></span>
                            </span>
                            <span class="profile-status <?= $persona['activo'] ? 'status-active' : 'status-inactive' ?>">
                                <span class="status-dot"></span> <?= $persona['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                            <span class="profile-gender">
                                <?= $persona['genero'] == 'F' ? 'Femenino' : 'Masculino' ?>
                            </span>
                        </div>
                        <div class="profile-details">
                            <span><?= htmlspecialchars($persona['nivel_academico']) ?></span>
                        </div>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="profile-item">
                        <span class="profile-label">Institución</span>
                        <span class="profile-value"><?= htmlspecialchars($persona['institucion']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Tipo de Institución</span>
                        <span class="profile-value"><?= htmlspecialchars($persona['tipo_institucion_nombre']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Zona Regional</span>
                        <span class="profile-value">
                            <span class="badge-zona"><?= htmlspecialchars($persona['zona_nombre']) ?></span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contactos -->
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Contactos</h3>
                </div>
                <div class="detail-card-body">
                    <?php if (!empty($persona['telefonos']) || !empty($persona['correos']) || !empty($persona['celulares'])): ?>
                        <div class="contactos-grid-detail">
                            <?php if (!empty($persona['telefonos'])): ?>
                                <div class="contactos-grupo-detail">
                                    <h4>Teléfonos</h4>
                                    <?php foreach ($persona['telefonos'] as $telefono): ?>
                                        <div class="contacto-detail">
                                            <span>
                                                <?= htmlspecialchars($telefono['lada']) ?> 
                                                <?= htmlspecialchars($telefono['numero']) ?>
                                                <?php if (!empty($telefono['extension'])): ?>
                                                    Ext. <?= htmlspecialchars($telefono['extension']) ?>
                                                <?php endif; ?>
                                            </span>
                                            <?php if ($telefono['visible']): ?>
                                                <span class="badge-visible">Visible</span>
                                            <?php else: ?>
                                                <span class="badge-hidden">Oculto</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($persona['correos'])): ?>
                                <div class="contactos-grupo-detail">
                                    <h4>Correos Electrónicos</h4>
                                    <?php foreach ($persona['correos'] as $correo): ?>
                                        <div class="contacto-detail">
                                            <span><?= htmlspecialchars($correo['valor']) ?></span>
                                            <?php if ($correo['visible']): ?>
                                                <span class="badge-visible">Visible</span>
                                            <?php else: ?>
                                                <span class="badge-hidden">Oculto</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($persona['celulares'])): ?>
                                <div class="contactos-grupo-detail">
                                    <h4>Celulares</h4>
                                    <?php foreach ($persona['celulares'] as $celular): ?>
                                        <div class="contacto-detail">
                                            <span>
                                                <?= htmlspecialchars($celular['lada']) ?> 
                                                <?= htmlspecialchars($celular['numero']) ?>
                                            </span>
                                            <?php if ($celular['visible']): ?>
                                                <span class="badge-visible">Visible</span>
                                            <?php else: ?>
                                                <span class="badge-hidden">Oculto</span>
                                            <?php endif; ?>
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

            <!-- Cargos -->
            <div class="detail-card">
                <div class="detail-card-header">
                    <h3>Cargos y Designaciones</h3>
                </div>
                <div class="detail-card-body">
                    <?php if (!empty($persona['cargos'])): ?>
                        <div class="cargos-grid-detail">
                            <?php foreach ($persona['cargos'] as $cargo): 
                                $es_activo = $cargo['fecha_fin'] === null;
                            ?>
                                <div class="cargo-detail-card <?= $es_activo ? 'cargo-activo' : 'cargo-inactivo' ?>">
                                    <div class="cargo-detail-header">
                                        <span class="cargo-detail-nivel"><?= htmlspecialchars($cargo['nivel_nombre']) ?></span>
                                        <span class="cargo-detail-nombre"><?= htmlspecialchars($cargo['nombre']) ?></span>
                                        <?php if ($es_activo): ?>
                                            <span class="cargo-status-activo">Activo</span>
                                        <?php else: ?>
                                            <span class="cargo-status-inactivo">Finalizado</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cargo-detail-body">
                                        <div class="cargo-detail-fechas">
                                            <span><strong>Inicio:</strong> <?= $cargo['fecha_inicio'] ?></span>
                                            <span><strong>Fin:</strong> <?= $cargo['fecha_fin'] ?? 'Actual' ?></span>
                                        </div>
                                        <?php if ($cargo['zona']): ?>
                                            <div class="cargo-detail-extra">
                                                <span><strong>Zona:</strong> <?= htmlspecialchars($cargo['zona']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($cargo['coordinacion']): ?>
                                            <div class="cargo-detail-extra">
                                                <span><strong>Coordinación:</strong> <?= htmlspecialchars($cargo['coordinacion']) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="cargo-detail-directorios">
                                            <strong>Directorios:</strong>
                                            <div class="directorios-tags">
                                                <?php foreach ($cargo['directorios'] as $directorio): ?>
                                                    <span class="tag-directorio"><?= htmlspecialchars($directorio) ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
    gap: 0.75rem;
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

.profile-gender {
    font-size: 0.8rem;
    color: #666;
}

.profile-details {
    font-size: 0.85rem;
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

/* Cargos Grid */
.cargos-grid-detail {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1rem;
}

.cargo-detail-card {
    background: #faf8f8;
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid #f0ecec;
    transition: all 0.2s ease;
}

.cargo-detail-card:hover {
    border-color: #d4c5c4;
}

.cargo-detail-card.cargo-activo {
    border-left: 4px solid #2e7d32;
}

.cargo-detail-card.cargo-inactivo {
    border-left: 4px solid #c62828;
}

.cargo-detail-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    flex-wrap: wrap;
}

.cargo-detail-nivel {
    font-size: 0.6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #8B0000;
    background: #f5edec;
    padding: 0.2rem 0.6rem;
    border-radius: 4px;
}

.cargo-detail-nombre {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.cargo-status-activo {
    font-size: 0.6rem;
    font-weight: 700;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
    background: #e8f5e9;
    color: #2e7d32;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.cargo-status-inactivo {
    font-size: 0.6rem;
    font-weight: 700;
    padding: 0.15rem 0.6rem;
    border-radius: 20px;
    background: #fce4ec;
    color: #c62828;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.cargo-detail-body {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.cargo-detail-fechas {
    display: flex;
    gap: 1.5rem;
    font-size: 0.85rem;
    color: #666;
}

.cargo-detail-fechas strong {
    color: #4a4a4a;
}

.cargo-detail-extra {
    font-size: 0.85rem;
    color: #666;
}

.cargo-detail-extra strong {
    color: #4a4a4a;
}

.cargo-detail-directorios {
    margin-top: 0.3rem;
    font-size: 0.85rem;
}

.cargo-detail-directorios strong {
    color: #4a4a4a;
}

.directorios-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.3rem;
    margin-top: 0.3rem;
}

.tag-directorio {
    display: inline-block;
    padding: 0.15rem 0.6rem;
    background: white;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    font-size: 0.7rem;
    color: #666;
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

    .profile-details {
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

    .cargos-grid-detail {
        grid-template-columns: 1fr;
    }

    .cargo-detail-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .detail-card {
        padding: 1.25rem;
    }
}
</style>

<?php include 'template/footer.php'; ?>