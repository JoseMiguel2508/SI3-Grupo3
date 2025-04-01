<?php
require_once '../CONTROLADOR/AlertaControlador.php';

$controlador = new AlertaControlador();
$alertas = $controlador->listarAlertas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Alertas de Mantenimiento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-4">
        <h2 class="text-center">📢 Alertas del Sistema</h2>

        <?php if (!empty($alertas)): ?>
            <div class="alert alert-danger text-center">
                <h4>⚠ Alertas de Mantenimiento</h4>
                <ul class="mb-0">
                    <?php foreach ($alertas as $alerta): ?>
                        <li>
                            <?= htmlspecialchars($alerta['descripcion']) ?>  
                            (Severidad: <strong><?= ucfirst(htmlspecialchars($alerta['severidad'])) ?></strong>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="alert alert-success text-center">
                ✅ No hay alertas activas en este momento.
            </div>
        <?php endif; ?>

        <!-- Depuración en consola del navegador -->
        <script>
            console.log("Alertas obtenidas:", <?= json_encode($alertas) ?>);
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
