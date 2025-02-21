<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Asignación</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a CSS personalizado -->
    <link rel="stylesheet" href="../CONTROLADOR/css/nueva_asignacion.css">
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="form-container w-100">
            <h2 class="text-center">Nueva Asignación</h2>
            <form action="guardar_asignacion.php" method="POST" class="form-asignacion">
                <div class="form-group">
                    <label for="vehiculo" class="form-label">Vehículo</label>
                    <select class="form-select form-select-sm" id="vehiculo" name="vehiculo" required>
                        <option value="">Seleccione un vehículo</option>
                        <option value="Ford Ranger">Ford Ranger</option>
                        <option value="Chevrolet Tahoe">Chevrolet Tahoe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="conductor" class="form-label">Conductor</label>
                    <select class="form-select form-select-sm" id="conductor" name="conductor" required>
                        <option value="">Seleccione un conductor</option>
                        <option value="Juan Pérez">Juan Pérez</option>
                        <option value="María López">María López</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_asignacion" class="form-label">Fecha de Asignación</label>
                    <input type="date" class="form-control form-control-sm" id="fecha_asignacion" name="fecha_asignacion" required>
                </div>
                <div class="form-group">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input type="date" class="form-control form-control-sm" id="fecha_fin" name="fecha_fin" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-sm">Guardar Asignación</button>
                <div class="text-center mt-2">
                    <a href="asignacion.php" class="btn btn-secondary btn-sm">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
