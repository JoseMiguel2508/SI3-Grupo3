<?php
// filepath: c:\xampp\htdocs\SI3-Grupo3\VISTA\editar_vehiculo.php

require_once '../MODELO/conex_consulta.php'; // Conexión a la base de datos

// Verificar si se ha pasado el ID del vehículo
if (isset($_GET['id'])) {
    $id_vehiculo = $_GET['id'];

    // Obtener la conexión
    $con = Conexion::conectar();

    // Obtener los datos del vehículo
    $sql = "SELECT id_vehiculo, numero_placa, marca, modelo, anio, capacidad, estado FROM vehiculos WHERE id_vehiculo = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_vehiculo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $vehiculo = $resultado->fetch_assoc();
    } else {
        die('Vehículo no encontrado');
    }

    // Cerrar la conexión
    $stmt->close();
    $con->close();
} else {
    die('ID de vehículo no especificado');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="panel border bg-white p-3">
            <div class="panel-heading">
                <h3 class="pt-2 font-weight-bold">Editar Vehículo</h3>
            </div>
            <div class="panel-body">
                <form action="../CONTROLADOR/VehiculoController.php" method="post" class="registration-form">
                    <input type="hidden" name="accion" value="editar">
                    <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero_placa">Número de Placa:</label>
                                <input type="text" class="form-control" id="numero_placa" name="numero_placa" value="<?php echo $vehiculo['numero_placa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="modelo">Modelo:</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $vehiculo['modelo']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="capacidad">Capacidad:</label>
                                <input type="text" class="form-control" id="capacidad" name="capacidad" value="<?php echo $vehiculo['capacidad']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marca">Marca:</label>
                                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $vehiculo['marca']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="anio">Año:</label>
                                <input type="number" class="form-control" id="anio" name="anio" value="<?php echo $vehiculo['anio']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="activo" <?php if ($vehiculo['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                                    <option value="mantenimiento" <?php if ($vehiculo['estado'] == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
                                    <option value="inactivo" <?php if ($vehiculo['estado'] == 'inactivo') echo 'selected'; ?>>Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Actualizar Vehículo</button>
                    <div class="text-center mt-2">
                        <a href="main_vehiculo.php" class="btn btn-secondary btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>