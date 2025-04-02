<?php
require_once '../CONTROLADOR/AsignacionRutaController.php';

// Instanciar el controlador
$asignacionRuta = new AsignacionRutaControlador();

$listaAsignaciones = $asignacionRuta->obtenerAsignacionesActivas();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_asignacion"])) {
    $id_asignacion = intval($_POST["id_asignacion"]);

    $resultado = $asignacionRuta->eliminarRuta($id_asignacion);

    header('Content-Type: application/json');
    echo json_encode(["success" => $resultado]);
    exit;
}

// Verificar si se solicitó dar de baja
if (isset($_GET['dar_baja_id']) && isset($_GET['id_vehiculo'])) {
    $idAsignacion = $_GET['dar_baja_id'];
    $idVehiculo = $_GET['id_vehiculo'];

    $result = $asignacionRuta->cambiarEstado($idVehiculo, $idAsignacion);
    
    if ($result) {
        // Redirigir para evitar el resubmit del formulario
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
    <link rel="stylesheet" href="../CONTROLADOR/css/asigna_ruta.css">
    <title>Lista de Asignaciones</title>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Lista de Asignaciones de Rutas</h2>

        <!-- Botones de acción -->
        <div class="text-end mb-3">
            <a href="nueva_asig_ruta.php" class="btn btn-danger">Nueva Asignación</a>
            <a href="reporte_asignaciones_rutas.php" class="btn btn-info">Ver Reportes</a> <!-- Botón de reportes -->
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ruta</th>
                        <th>Conductor</th>
                        <th>Vehículo</th>
                        <th>Placa</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Estado</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listaAsignaciones)): ?>
                        <?php $contador = 1; // Inicializar contador ?>
                        <?php foreach ($listaAsignaciones as $asignacion): ?>
                            <tr>
                                <td><?= $contador++ ?></td> <!-- Mostrar y aumentar el contador -->
                                <td><?= htmlspecialchars($asignacion["nombre_ruta"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($asignacion["nombre_completo"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($asignacion["modelo"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($asignacion["numero_placa"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($asignacion["hora_inicio"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($asignacion["hora_fin"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php if ($asignacion["estado"] !== "dada de baja") { ?>
                                        <a href="?dar_baja_id=<?= $asignacion["id_asignacion"] ?>&id_vehiculo=<?= $asignacion["id_vehiculo"] ?>"
                                            class="btn btn-danger btn-sm"><?= htmlspecialchars($asignacion["estado"], ENT_QUOTES, 'UTF-8') ?></a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button class="button" onclick="eliminarRuta(<?= (int) $asignacion['id_asignacion'] ?>)">
                                        <span class="button-content">Desestimar</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-danger fw-bold">No hay asignaciones activas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
    <script>
        function eliminarRuta(id_asignacion) {
            if (!confirm("¿Seguro que deseas eliminar esta asignación?")) return;

            fetch("asigna_ruta.php", { // Asegurar que se llame al archivo correcto
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id_asignacion=" + encodeURIComponent(id_asignacion)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Asignación eliminada correctamente.");
                        location.reload();
                    } else {
                        alert("Error al eliminar la asignación.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }

    </script>

    <!-- Incluir Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>