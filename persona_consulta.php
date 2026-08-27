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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Datos simulados de la persona
$persona = [
    'id' => $id,
    'nombre' => 'María',
    'apellido_paterno' => 'González',
    'apellido_materno' => 'Pérez',
    'genero' => 'F',
    'institucion' => 'UNAM - Facultad de Contaduría',
    'nivel_academico' => 'Maestría',
    'activo' => true,
    'contactos' => [
        ['tipo' => 'Correo', 'valor' => 'maria.gonzalez@example.com', 'principal' => true],
        ['tipo' => 'Celular', 'valor' => '55 1234 5678', 'principal' => false]
    ],
    'cargos' => [
        ['cargo' => 'Presidenta', 'nivel' => 'Nacional', 'inicio' => '2024-01-01', 'fin' => null],
        ['cargo' => 'Coordinadora Regional', 'nivel' => 'Regional', 'inicio' => '2023-06-01', 'fin' => '2023-12-31']
    ]
];

$nombre_completo = $persona['nombre'] . ' ' . $persona['apellido_paterno'];
if (!empty($persona['apellido_materno'])) {
    $nombre_completo .= ' ' . $persona['apellido_materno'];
}

include 'template/header.php';
include 'template/menu.php';
?>

<main class="main-content">
    <div class="dashboard-container">
        
        <div class="module-header">
            <h1><i class="fas fa-user-circle"></i> Consultar Persona</h1>
            <div class="module-actions">
                <a href="persona_edicion.php?id=<?= $id ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="personas.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Información general -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar-circle mb-3">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                        <h4 class="mb-1"><?= htmlspecialchars($nombre_completo) ?></h4>
                        <p class="text-muted small">ID: #<?= str_pad($persona['id'], 6, '0', STR_PAD_LEFT) ?></p>
                        
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <span class="badge <?= $persona['activo'] ? 'badge-success' : 'badge-danger' ?>">
                                <?= $persona['activo'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                            <span class="badge badge-info">
                                <?= $persona['genero'] == 'F' ? 'Femenino' : 'Masculino' ?>
                            </span>
                        </div>

                        <hr>

                        <div class="text-start">
                            <p><strong><i class="fas fa-university"></i> Institución:</strong><br>
                            <?= htmlspecialchars($persona['institucion']) ?></p>
                            
                            <p><strong><i class="fas fa-graduation-cap"></i> Nivel Académico:</strong><br>
                            <?= htmlspecialchars($persona['nivel_academico']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contactos y cargos -->
            <div class="col-md-8">
                <!-- Contactos -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-address-card"></i> Contactos</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($persona['contactos']) > 0): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($persona['contactos'] as $contacto): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= htmlspecialchars($contacto['tipo']) ?>:</strong>
                                            <?= htmlspecialchars($contacto['valor']) ?>
                                            <?php if ($contacto['principal']): ?>
                                                <span class="badge badge-primary ms-2">Principal</span>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay contactos registrados</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Cargos / Designaciones -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-briefcase"></i> Cargos y Designaciones</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($persona['cargos']) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Cargo</th>
                                            <th>Nivel</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($persona['cargos'] as $cargo): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($cargo['cargo']) ?></td>
                                                <td><?= htmlspecialchars($cargo['nivel']) ?></td>
                                                <td><?= date('d/m/Y', strtotime($cargo['inicio'])) ?></td>
                                                <td><?= $cargo['fin'] ? date('d/m/Y', strtotime($cargo['fin'])) : 'Actual' ?></td>
                                                <td>
                                                    <?php if (!$cargo['fin']): ?>
                                                        <span class="badge badge-success">Activo</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Finalizado</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay cargos asignados</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<style>
.avatar-circle {
    width: 100px;
    height: 100px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.list-group-item {
    border-left: none;
    border-right: none;
    padding: 0.75rem 0;
}

.list-group-item:first-child {
    border-top: none;
}
</style>

<?php include 'template/footer.php'; ?>