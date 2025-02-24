<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor de Flotas en Ruta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css/control.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Monitor de Conductores</h2>
        <div class="text-end mb-3">
        <a href="../VISTA/registro_conductor.php" class="btn btn-primary btn-asignacion">Nuevo Conductor</a>
        </div>

        <!-- mensaje de Registrado con exito -->
        <div id="messageBox" style="display:none; padding: 10px; background-color: lightgreen; color: black; border: 1px solid green;">
            ¡Registro exitoso!
        </div>
    </div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!--Cargar mensaje -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.search.includes("mensaje=registrado")) {
                document.getElementById("messageBox").style.display = "block";
                setTimeout(function() {
                    document.getElementById("messageBox").style.display = "none";
                }, 3000);
            }
        });
    </script>
</body>

</html>
