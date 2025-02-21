<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Asignaciones</title>

    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Enlace a CSS personalizado -->
    <link rel="stylesheet" href="../CONTROLADOR/css/asignacion.css">
</head>
<body>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Asignaciones</h2>
        
        <div class="text-end mb-3">
        <a href="../VISTA/nueva_asignacion.php" class="btn btn-primary btn-asignacion">Nueva Asignación</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehículo</th>
                        <th>Conductor</th>
                        <th>Fecha Asignación</th>
                        <th>Fecha Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ford Ranger</td>
                        <td>Juan Pérez</td>
                        <td>2024-02-15</td>
                        <td>2024-03-15</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Chevrolet Tahoe</td>
                        <td>María López</td>
                        <td>2024-01-10</td>
                        <td>2024-02-10</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
