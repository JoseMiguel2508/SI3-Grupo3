<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css">
    <!-- Incluir Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Lista de Vehículos</h2>

        <div class="text-end mb-3">
            <a href="../VISTA/crear_vehiculo.php" class="btn btn-danger btn-asignacion">Nuevo registro</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo del controlador
                    require_once '../CONTROLADOR/VehiculoController.php';

                    // Establecer la acción a listar
                    $_POST['accion'] = 'listar';

                    // Llamar al controlador para listar los vehículos
                    ob_start();
                    include '../CONTROLADOR/VehiculoController.php';
                    ob_end_clean();

                    if (isset($vehiculos) && count($vehiculos) > 0) {
                        // Mostrar los datos en la tabla
                        foreach ($vehiculos as $row) {
                            echo "<tr>";
                            echo "<td>" . $row["id_vehiculo"] . "</td>";
                            echo "<td>" . $row["numero_placa"] . "</td>";
                            echo "<td>" . $row["marca"] . "</td>";
                            echo "<td>" . $row["modelo"] . "</td>";
                            echo "<td>" . $row["anio"] . "</td>";
                            echo "<td>" . $row["capacidad"] . "</td>";
                            echo "<td>" . $row["estado"] . "</td>";
                            echo "<td><a href='../VISTA/editar_vehiculo.php?id=" . $row["id_vehiculo"] . "' class='btn btn-warning btn-sm'><i class='bi bi-pencil-square'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No hay vehículos registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>