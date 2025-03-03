<?php

require_once '../CONTROLADOR/AsignacionRutaController.php';

$control = new AsignacionRutaControlador();

// Obtener los conductores y vehículos disponibles
$resultVehiculos = $control->obtenerVehiculosDisponibles();
$resultRuta = $control->obtenerRutas();


// Si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_ruta = $_POST["id_ruta"];
    $id_asignacion = $_POST["id_asignacion"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];
    $estado = $_POST["estado"];

    // Intentar asignar ruta
    $asignacionExitosa = $control->asignarRuta($id_ruta, $id_asignacion, $fecha_inicio, $fecha_fin, $estado);

    if ($asignacionExitosa) {
        echo "<script>alert('Ruta asignada correctamente.'); window.location.href='asigna_ruta.php';</script>";
    } else {
        echo "<script>alert('Error al asignar la Ruta.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de Ruta</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css/nueva_asig_conductor.css">
</head>

<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="panel border bg-white p-3">
            <div class="panel-heading">
                <h3 class="pt-2 font-weight-bold">Asignar de Ruta</h3>
            </div>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'asignado'): ?>
                <div class="alert alert-success text-center">¡Ruta asignada correctamente!</div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] == 'fallo'): ?>
                <div class="alert alert-danger text-center">Error al Asignar ruta. Intente de nuevo.</div>
            <?php endif; ?>

            <div class="panel-body">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fa fa-map-pin p-2"></span>
                                <select id="id_ruta" name="id_ruta" class="form-control" required>
                                    <option value="">Seleccione un Departamento</option>
                                    <?php while ($row = $resultRuta->fetch_assoc()) { ?>
                                        <option value="<?= $row['id_ruta'] ?>"><?= $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-car p-2"></span>
                                <select id="id_asignacion" name="id_asignacion" class="form-control" required>
                                    <option value="">Seleccione un vehículo</option>
                                    <?php while ($row = $resultVehiculos->fetch_assoc()) { ?>
                                        <option value="<?= $row['id_vehiculo'] ?>">
                                            <?= $row['marca'] ?> - <?= $row['numero_placa'] ?> -
                                            <?= $row['nombre_conductor'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-row text-center">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-calendar-alt p-2"></span>
                                <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" class="form-control"
                                    required>
                            </div>
                            <label for="fecha_inicio" class="w-100">Fecha de Inicio</label>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-calendar-alt p-2"></span>
                                <input type="datetime-local" id="fecha_fin" name="fecha_fin" class="form-control"
                                    required>
                            </div>
                            <label for="fecha_fin" class="w-100">Fecha de Fin</label>
                        </div>
                    </div>

                    <div class="input-field">
                        <span class="fa fa-paper-plane p-2"></span>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="">Seleccione un Estado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>


                    <div class="text-center">
                        <button type="submit" class="btn btn-danger btn-sm mt-3 px-3">Asignar Ruta</button>
                    </div>
                    <div class="text-center mt-2">
                        <a href="asigna_ruta.php" class="btn btn-secondary btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        // Obtener la fecha y hora actuales
        const today = new Date();
        // Formatear la fecha y hora en el formato adecuado para el campo datetime-local
        const year = today.getFullYear();
        const month = ("0" + (today.getMonth() + 1)).slice(-2); // Meses en formato 2 dígitos
        const day = ("0" + today.getDate()).slice(-2); // Día en formato 2 dígitos
        const hours = ("0" + today.getHours()).slice(-2); // Hora en formato 2 dígitos
        const minutes = ("0" + today.getMinutes()).slice(-2); // Minutos en formato 2 dígitos
        // Crear el formato datetime-local: yyyy-mm-ddThh:mm
        const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        // Establecer el valor del input datetime-local
        document.getElementById("fecha_inicio").value = currentDateTime;

    </script>
</body>

</html>