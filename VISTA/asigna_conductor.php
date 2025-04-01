<?php
require_once '../CONTROLADOR/AsignacionControlador.php';

// Instanciar el controlador
$asignacionControlador = new AsignacionControlador();

// Obtener el término de búsqueda
$terminoBusqueda = isset($_POST['buscar']) ? $_POST['buscar'] : '';

// Obtener las asignaciones activas, filtradas si hay un término de búsqueda
$asignaciones = $asignacionControlador->obtenerAsignacionesActivas($terminoBusqueda);
$asignaciones = $asignacionControlador->buscarAsignaciones($terminoBusqueda);

// Verificar si se solicitó dar de baja
if (isset($_GET['dar_baja_id'])) {
    $idAsignacion = $_GET['dar_baja_id'];
    $resultado = $asignacionControlador->darDeBajaAsignacion($idAsignacion);
    if ($resultado) {
        // Redirigir para evitar el resubmit de formulario y actualizar la lista
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista de Asignaciones</title>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Lista de Asignaciones de Vehículos</h2>

        <!-- Formulario de búsqueda -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar conductor" value="<?php echo htmlspecialchars($terminoBusqueda); ?>">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Botones de acción -->
        <div class="text-end mb-3">
            <a href="nueva_asig_conductor.php" class="btn btn-danger">Nueva Asignación</a>
            <a href="reporte_asignacion_vehiculo.php" class="btn btn-info">Ver Reportes</a> <!-- Botón de reportes -->
        </div>
        

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Conductor</th>
                        <th>Vehículo</th>
                        <th>Placa</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($asignaciones)) {
                        foreach ($asignaciones as $asignacion) { ?>
                            <tr <?= $asignacion["estado"] === "dada de baja" ? 'class="table-danger"' : '' ?>>
                                <td><?= $asignacion["id_asignacion"] ?></td>
                                <td><?= $asignacion["nombre_completo"] ?></td>
                                <td><?= $asignacion["modelo"] ?></td>
                                <td><?= $asignacion["numero_placa"] ?></td>
                                <td><?= $asignacion["fecha_inicio"] ?></td>
                                <td>
                                    <?php 
                                    // Si tiene fecha de fin, mostrarla; si no, indicar "En curso"
                                    echo $asignacion["fecha_fin"] ? $asignacion["fecha_fin"] : "En curso"; 
                                    ?>
                                </td>
                                <td><?= ucfirst($asignacion["estado"]) ?></td>
                                <td>
                                    <?php if ($asignacion["estado"] !== "dada de baja") { ?>
                                        <a href="?dar_baja_id=<?= $asignacion["id_asignacion"] ?>" class="btn btn-danger btn-sm">Dar de baja</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay asignaciones activas</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
