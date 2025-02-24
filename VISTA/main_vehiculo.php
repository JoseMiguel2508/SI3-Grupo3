<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Lista de Vehículos</h2>

        <div class="text-end mb-3">
            <a href="../VISTA/crear_vehiculo.php" class="btn btn-primary btn-asignacion">Nuevo registro</a>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo de conexión
                    include '../MODELO/conex_consulta.php';

                    // Obtener la conexión
                    $con = Conexion::conectar();

                    // Obtener los datos de la tabla vehiculos
                    $sql = "SELECT id_vehiculo, numero_placa, marca, modelo, anio, capacidad, estado FROM vehiculos";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        // Mostrar los datos en la tabla
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id_vehiculo"] . "</td>";
                            echo "<td>" . $row["numero_placa"] . "</td>";
                            echo "<td>" . $row["marca"] . "</td>";
                            echo "<td>" . $row["modelo"] . "</td>";
                            echo "<td>" . $row["anio"] . "</td>";
                            echo "<td>" . $row["capacidad"] . "</td>";
                            echo "<td>" . $row["estado"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No hay vehículos registrados</td></tr>";
                    }

                    // Cerrar la conexión
                    $con->close();
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