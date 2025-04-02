<?php
// Incluir el controlador que maneja los viajes
require_once '../CONTROLADOR/ViajeController.php';

// Instanciar el controlador
$viajeController = new ViajeController();

// Obtener los viajes
$historialViajes = $viajeController->obtenerHistorialViajes();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Historial de Viajes</title>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Historial de Viajes</h2>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Viaje</th>
                        <th>Asignación</th>
                        <th>Conductor</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>

                    </tr>
                </thead>
                <tbody>
                <tbody>
    <?php if (!empty($historialViajes)): ?>
        <?php foreach ($historialViajes as $viaje): ?>
            <tr>
                <td><?= htmlspecialchars($viaje['id_viaje'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($viaje['nombre_ruta'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($viaje['nombre_completo'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($viaje['fecha_inicio'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php 
                        // Verificar si 'fecha_fin' existe en el array y tiene un valor
                        echo isset($viaje['fecha_fin']) && !empty($viaje['fecha_fin']) 
                            ? htmlspecialchars($viaje['fecha_fin'], ENT_QUOTES, 'UTF-8') 
                            : 'Pendiente'; // Valor predeterminado si no existe
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center text-danger fw-bold">No hay viajes registrados</td>
        </tr>
    <?php endif; ?>
</tbody>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Incluir Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
