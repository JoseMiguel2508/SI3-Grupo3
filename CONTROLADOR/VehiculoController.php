<?php
// filepath: /C:/xampp/htdocs/SI3-Grupo3/CONTROLADOR/vehiculos.php

// Incluir el archivo de conexión
include '../MODELO/conex_consulta.php';

// Obtener la conexión
$con = Conexion::conectar();

// Datos del nuevo vehículo
$numero_placa = $_POST['numero_placa'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio'];
$capacidad = $_POST['capacidad'];
$estado = $_POST['estado'];

// Preparar y ejecutar la consulta
$sql = "INSERT INTO vehiculos (numero_placa, marca, modelo, anio, capacidad, estado)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $con->prepare($sql);
$stmt->bind_param("sssiss", $numero_placa, $marca, $modelo, $anio, $capacidad, $estado);

if ($stmt->execute()) {
    $mensaje = "Nuevo vehículo registrado exitosamente";
    $tipo_mensaje = "success";
} else {
    $mensaje = "Error: " . $sql . "<br>" . $con->error;
    $tipo_mensaje = "danger";
}

// Cerrar la conexión
$stmt->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vehículo</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <script>
        // Redirigir después de 3 segundos
        setTimeout(function() {
            window.location.href = "../VISTA/main_vehiculo.php";
        }, 2500);
    </script>
    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>