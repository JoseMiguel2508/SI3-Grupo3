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
                <h3 class="pt-2 font-weight-bold">Registrar Nuevo Vehículo</h3>
            </div>
            <div class="panel-body">
                <form action="../CONTROLADOR/VehiculoController.php" method="post" class="registration-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero_placa">Número de Placa:</label>
                                <input type="text" class="form-control" id="numero_placa" name="numero_placa" placeholder="Número de Placa" required>
                            </div>
                            <div class="form-group">
                                <label for="modelo">Modelo:</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo" required>
                            </div>
                            <div class="form-group">
                                <label for="capacidad">Capacidad:</label>
                                <input type="text" class="form-control" id="capacidad" name="capacidad" placeholder="Capacidad">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marca">Marca:</label>
                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Marca" required>
                            </div>
                            <div class="form-group">
                                <label for="anio">Año:</label>
                                <input type="number" class="form-control" id="anio" name="anio" placeholder="Año" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="activo">Activo</option>
                                    <option value="mantenimiento">Mantenimiento</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger btn-block mt-3">Registrar Vehículo</button>
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