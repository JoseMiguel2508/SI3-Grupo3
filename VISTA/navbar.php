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
    <title>Navbar Mejorado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CONTROLADOR/css/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="#">
                <img src="../MODELO/assets/img/logo_3.PNG" alt="Logo" width="80" height="54" class="d-inline-block align-text-top">
                TRANS UPDS
            </a>
        </div>
    </nav>
<!-- Sección de Alertas -->
<div class="container mt-3">
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

        <?php endif; ?>
    </div>

    <!-- Sección de Navegación -->
    <div class="d-flex flex-column vh-100 align-items-center">
        <div class="radio-inputs mb-3">
            <label class="radio">
                <input checked name="radio" type="radio" onclick="mostrarContenido('control.php')"/>
                <span class="name">Control Ruta</span>
            </label>
            <label class="radio">
                <input name="radio" type="radio" onclick="mostrarContenido('asigna_ruta.php')"/>
                <span class="name">Asignacion Ruta</span>
            </label>
            <label class="radio">
                <input name="radio" type="radio" onclick="mostrarContenido('main_vehiculo.php')"/>
                <span class="name">Control Flota</span>
            </label>
            <label class="radio">
                <input name="radio" type="radio" onclick="mostrarContenido('control_conductor.php')"/>
                <span class="name">Control Conductor</span>
            </label>
            <label class="radio">
                <input name="radio" type="radio" onclick="mostrarContenido('asigna_conductor.php')"/>
                <span class="name">Asignacion Conductor</span>
            </label>
            <label class="radio">
                <input name="radio" type="radio" onclick="mostrarContenido('lista_mantenimiento.php')"/>
                <span class="name">Mantenimientos</span>
            </label>
        </div>

        <div id="contenido" class="text-center border p-3" style="width: 100%; max-width: 100%;">
            <iframe id="contenido-frame" src="cards.html" style="width: 100%; height: 500px; border: none;"></iframe>
        </div>
    </div>

    <script>
        function mostrarContenido(opcion) {
            document.getElementById("contenido-frame").src = opcion;
        }

        window.onload = function () {
            mostrarContenido("control.php");
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
