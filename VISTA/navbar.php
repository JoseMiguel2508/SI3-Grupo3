<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Navbar Mejorado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CONTROLADOR/css/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="#">
                <img src="../MODELO/assets/img/logo.PNG" alt="Logo" width="80" height="54"
                    class="d-inline-block align-text-top">
                Trans Aerosur
            </a>
        </div>
    </nav>

    <div class="d-flex flex-column vh-100">
        <div class="btn-group mb-3" role="group" aria-label="Botones de selección">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
            <label class="btn btn-outline-danger" for="btnradio1" onclick="mostrarContenido('control.php')">Control Ruta</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
            <label class="btn btn-outline-danger" for="btnradio2" onclick="mostrarContenido('asignacion.php')">Asignacion</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
            <label class="btn btn-outline-danger" for="btnradio3" onclick="mostrarContenido('controlflota.php')">Control Flota</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
            <label class="btn btn-outline-danger" for="btnradio4" onclick="mostrarContenido('control_conductor.php')">Control Conductor</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
            <label class="btn btn-outline-danger" for="btnradio5" onclick="mostrarContenido('main_vehiculo.php')">Vehiculos</label>
            
            <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
            <label class="btn btn-outline-danger" for="btnradio5" onclick="mostrarContenido('contenido5')">Mantenimiento</label>
        </div>

        <div id="contenido" class="text-center border p-3" style="width: 100%; max-width: 100%;">
            <iframe id="contenido-frame" src="cards.html" style="width: 100%; height: 400px; border: none;"></iframe>
        </div>
    </div>

    <script>
        function mostrarContenido(opcion) {
            let contenidoFrame = document.getElementById("contenido-frame");

            if (opcion === "control.php") {
                contenidoFrame.src = "control.php"; // Cargar cards.html
            } else if (opcion === "asignacion.php") {
                contenidoFrame.src = "asignacion.php"; // Cargar index.html
            } else if (opcion === "controlflota.php") {
                contenidoFrame.src = "controlflota.php"; // Vaciar el iframe si no se quiere mostrar nada
            }else if (opcion === "control_conductor.php") {
                contenidoFrame.src = "control_conductor.php"; // Vaciar el iframe si no se quiere mostrar nada
            }else if (opcion === "main_vehiculo.php") {
                contenidoFrame.src = "main_vehiculo.php"; // Vaciar el iframe si no se quiere mostrar nada
            }
        }

        // Cargar automáticamente "cards.html" al iniciar
        window.onload = function () {
            mostrarContenido("control.php");
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
