<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Lista de Mantenimientos</h2>

        <div class="text-end mb-3">
            <a href="../VISTA/mantenimientos.php" class="btn btn-danger">Nuevo Mantenimiento</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Mantenimiento</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo de conexión
                    include '../MODELO/conex_consulta.php';

                    // Crear instancia de MantenimientoModelo
                    require_once '../MODELO/MantenimientoModelo.php';
                    $modelo = new MantenimientoModelo();
                    $mantenimientos = $modelo->obtenerMantenimientos();

                    // Verificar si se ha enviado el formulario
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_mantenimiento'])) {
                        $id_mantenimiento = $_POST['id_mantenimiento'];

                        // Llamar al método para actualizar el estado del mantenimiento a "completado"
                        $modelo->actualizarEstadoMantenimiento($id_mantenimiento);
                    }

                    if ($mantenimientos->num_rows > 0) {
                        // Mostrar los datos en la tabla
                        while($row = $mantenimientos->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id_mantenimiento"] . "</td>";
                            echo "<td>" . $row["marca"] . "</td>";
                            echo "<td>" . $row["modelo"] . "</td>";
                            echo "<td>" . $row["descripcion"] . "</td>";
                            echo "<td>" . $row["estado"] . "</td>";
                            echo "<td>";
                            // Si el estado no es completado, mostrar el botón para actualizar
                            if ($row['estado'] !== 'completado') {
                                echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='id_mantenimiento' value='" . $row["id_mantenimiento"] . "'>";
                                echo "<button type='submit' class='btn btn-success'>Marcar como Completado</button>";
                                echo "</form>";
                            } else {
                                echo "<button class='btn btn-secondary' disabled>Completado</button>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No hay mantenimientos registrados</td></tr>";
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
