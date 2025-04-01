<?php
require_once __DIR__ . '/../CONTROLADOR/AsignacionRutaController.php'; 
$controlador = new AsignacionRutaControlador();
$fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-01'); // Inicio del mes actual
$fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d'); // Fecha actual

$reporte = $controlador->obtenerAsignacionesActivas($fechaInicio, $fechaFin);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporte de Asignación de Rutas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center">📋 Reporte de Asignación de Rutas</h2>

    <!-- Filtros de Fecha -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
            <input type="date" class="form-control" name="fecha_inicio" value="<?= $fechaInicio ?>" required>
        </div>
        <div class="col-md-4">
            <label for="fecha_fin" class="form-label">Fecha Fin:</label>
            <input type="date" class="form-control" name="fecha_fin" value="<?= $fechaFin ?>" required>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
        </div>
    </form>

    <!-- Tabla de Reporte -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Ruta</th>
                <th>Vehículo</th>
                <th>Conductor</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reporte)): ?>
                <?php foreach ($reporte as $index => $fila): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($fila['rutas']) ?></td>
                        <td><?= htmlspecialchars($fila['vehiculos']) ?></td>
                        <td><?= htmlspecialchars($fila['conductores']) ?></td>
                        <td><?= htmlspecialchars($fila['hora_inicio']) ?></td>
                        <td><?= htmlspecialchars($fila['hora_fin']) ?></td>
                        <td>
                            <span class="badge bg-<?= $fila['estado'] == 'activo' ? 'success' : ($fila['estado'] == 'completado' ? 'primary' : 'danger') ?>">
                                <?= htmlspecialchars($fila['estado']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No hay registros en el rango seleccionado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Botones de Exportación -->
    <div class="mt-3">
        <a href="exportar_pdf.php?fecha_inicio=<?= $fechaInicio ?>&fecha_fin=<?= $fechaFin ?>" class="btn btn-danger">📄 Exportar PDF</a>
        <a href="exportar_excel.php?fecha_inicio=<?= $fechaInicio ?>&fecha_fin=<?= $fechaFin ?>" class="btn btn-success">📊 Exportar Excel</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
