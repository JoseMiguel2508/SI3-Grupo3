<?php
// filepath: /C:/xampp/htdocs/SI3-Grupo3/CONTROLADOR/vehiculos.php

// Incluir el archivo del modelo Vehiculo
require_once '../MODELO/Vehiculo.php';

// Crear una instancia del modelo Vehiculo
$vehiculo = new Vehiculo();

// Verificar si 'accion' está definido en $_POST
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'crear':
            // Datos del nuevo vehículo
            $numero_placa = $_POST['numero_placa'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $anio = $_POST['anio'];
            $capacidad = $_POST['capacidad'];
            $estado = $_POST['estado'];

            // Registrar el nuevo vehículo utilizando el modelo
            $resultado = $vehiculo->registrarVehiculo($numero_placa, $marca, $modelo, $anio, $capacidad, $estado);

            if ($resultado === "Registro exitoso") {
                $mensaje = "Nuevo vehículo registrado exitosamente";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error: " . $resultado;
                $tipo_mensaje = "danger";
            }
            break;

        case 'editar':
            // Datos del vehículo a editar
            $id_vehiculo = $_POST['id_vehiculo'];
            $numero_placa = $_POST['numero_placa'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $anio = $_POST['anio'];
            $capacidad = $_POST['capacidad'];
            $estado = $_POST['estado'];

            // Editar el vehículo utilizando el modelo
            $resultado = $vehiculo->editarVehiculo($id_vehiculo, $numero_placa, $marca, $modelo, $anio, $capacidad, $estado);

            if ($resultado === "Actualización exitosa") {
                $mensaje = "Vehículo actualizado exitosamente";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error: " . $resultado;
                $tipo_mensaje = "danger";
            }
            break;

        case 'listar':
            // Listar todos los vehículos utilizando el modelo
            $resultado = $vehiculo->listarVehiculos();

            if ($resultado) {
                $vehiculos = $resultado->fetch_all(MYSQLI_ASSOC);
                // Aquí podrías procesar los datos para mostrarlos en una vista
            } else {
                $mensaje = "Error al listar los vehículos";
                $tipo_mensaje = "danger";
            }
            break;

        default:
            $mensaje = "Acción no válida";
            $tipo_mensaje = "danger";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vehículos</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($mensaje)): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
    </div>
    <script>
        // Redirigir después de 3 segundos si no es la acción de listar
        <?php if (isset($accion) && $accion !== 'listar'): ?>
        setTimeout(function() {
            window.location.href = "../VISTA/main_vehiculo.php";
        }, 2000);
        <?php endif; ?>
    </script>
    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>