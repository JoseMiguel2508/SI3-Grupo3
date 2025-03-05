<?php
session_start();
require_once '../MODELO/Conductor.php';

// Conectar a la base de datos
$conn = Conexion::conectar();

// Verificar si se ha enviado un término de búsqueda
$terminoBusqueda = isset($_POST['buscar']) ? $_POST['buscar'] : '';

// Crear instancia de Conductor
$conductor = new Conductor();

// Llamar al método de búsqueda de conductores
$resultado = $conductor->buscarConductores($terminoBusqueda);

// Verificar si la consulta devolvió resultados
if ($resultado === false) {
    echo "Error en la consulta";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor de Flotas en Rutas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css/control.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Monitor de Conductores</h2>
        <div class="text-end mb-3">
            <a href="../VISTA/registro_conductor.php" class="btn btn-danger">Nuevo Conductor</a>
        </div>

        <!-- Formulario de búsqueda -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar conductor" value="<?php echo htmlspecialchars($terminoBusqueda); ?>">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php
            // Verificar si hay resultados antes de procesarlos
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    // Obtener el ID del conductor
                    $idConductor = $fila['id_conductor'];

                    // Mostrar cada conductor con enlace al formulario de actualización
                    echo '<div class="col-md-4">
                            <a href="actualizar_conductor.php?id_conductor=' . $idConductor . '" class="text-decoration-none">
                                <div class="card p-3 mb-3">
                                    <div class="text-center">
                                        <img src="' . (empty($fila['foto']) ? "../assets/img/default-driver.png" : "../MODELO/assets/conductores/" .htmlspecialchars($fila['foto'])) . '" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;" alt="Foto del conductor">
                                    </div>
                                    <h5 class="text-center">
                                        🚚 ' . htmlspecialchars($fila['nombre_completo']) . '
                                        <span class="badge bg-' . ($fila['estado'] == 'disponible' ? 'success' : 'warning') . '">
                                            ' . htmlspecialchars($fila['estado']) . '
                                        </span>
                                    </h5>
                                    <p><strong>N° Licencia:</strong> ' . htmlspecialchars($fila['numero_licencia']) . '</p>
                                    <p><strong>Tipo de Licencia:</strong> ' . htmlspecialchars($fila['tipo_licencia']) . '</p>
                                </div>
                            </a>
                        </div>';
                }
            } else {
                echo "<p>No se encontraron conductores.</p>";
            }
            
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
