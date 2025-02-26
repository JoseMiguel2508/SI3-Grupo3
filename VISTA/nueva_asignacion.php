<?php
require_once '../CONTROLADOR/AsignacionControlador.php';

$controlador = new AsignacionControlador();

// Obtener los conductores y vehículos disponibles
$resultConductores = $controlador->obtenerConductoresDisponibles();
$resultVehiculos = $controlador->obtenerVehiculosDisponibles();

// Si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_conductor = $_POST["id_conductor"];
    $id_vehiculo = $_POST["id_vehiculo"];
    $fecha_inicio = $_POST["fecha_inicio"];

    // Intentar asignar el vehículo
    $asignacionExitosa = $controlador->asignarVehiculo($id_conductor, $id_vehiculo, $fecha_inicio);

    if ($asignacionExitosa) {
        echo "<script>alert('Vehículo asignado correctamente.'); window.location.href='asignacion.php';</script>";
    } else {
        echo "<script>alert('Error al asignar el vehículo.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de Vehículos</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../CONTROLADOR/css/form_style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="panel border bg-white p-3">
            <div class="panel-heading">
                <h3 class="pt-2 font-weight-bold">Asignar Vehículo a Conductor</h3>
            </div>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'asignado'): ?>
                <div class="alert alert-success text-center">¡Vehículo asignado correctamente!</div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] == 'fallo'): ?>
                <div class="alert alert-danger text-center">Error al asignar el vehículo. Intente de nuevo.</div>
            <?php endif; ?>

            <div class="panel-body">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-user p-2"></span>
                                <select id="id_conductor" name="id_conductor" class="form-control" required>
                                    <option value="">Seleccione un conductor</option>
                                    <?php while ($row = $resultConductores->fetch_assoc()) { ?>
                                        <option value="<?= $row['id_conductor'] ?>"><?= $row['nombre_completo'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-car p-2"></span>
                                <select id="id_vehiculo" name="id_vehiculo" class="form-control" required>
                                    <option value="">Seleccione un vehículo</option>
                                    <?php while ($row = $resultVehiculos->fetch_assoc()) { ?>
                                        <option value="<?= $row['id_vehiculo'] ?>">
                                            <?= $row['marca'] ?> <?= $row['modelo'] ?> - <?= $row['numero_placa'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-field">
                            <span class="fas fa-calendar-alt p-2"></span>
                            <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-sm mt-3 px-3">Asignar Vehículo</button>
                    </div>
                    <div class="text-center mt-2">
                        <a href="asignacion.php" class="btn btn-secondary btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
