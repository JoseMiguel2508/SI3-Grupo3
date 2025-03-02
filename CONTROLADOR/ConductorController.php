<?php
session_start();
require_once '../MODELO/Conductor.php';
require_once '../MODELO/conex_consulta.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idConductor = isset($_POST['id_conductor']) ? $_POST['id_conductor'] : null;
    $nombre = trim($_POST['nombre_completo']);
    $numeroLicencia = trim($_POST['numero_licencia']);
    $tipoLicencia = trim($_POST['tipo_licencia']);
    $fechaVencimiento = $_POST['fecha_vencimiento_licencia'];
    $telefono = trim($_POST['telefono']);
    $estado = $_POST['estado'];

    $conn = Conexion::conectar();
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Manejo de la foto
    $foto = NULL;
    if (!empty($_FILES['foto']['name'])) {
        $directorioDestino = "../MODELO/assets/conductores/";
        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        $nombreArchivo = time() . "_" . basename($_FILES["foto"]["name"]);
        $rutaCompleta = $directorioDestino . $nombreArchivo;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaCompleta)) {
            $foto = $nombreArchivo;
        }
    } else {
        // Si no se subió una nueva foto, mantener la foto existente
        if ($idConductor) {
            $queryFoto = "SELECT foto FROM conductores WHERE id_conductor = ?";
            $stmtFoto = $conn->prepare($queryFoto);
            $stmtFoto->bind_param("i", $idConductor);
            $stmtFoto->execute();
            $resultadoFoto = $stmtFoto->get_result();
            $filaFoto = $resultadoFoto->fetch_assoc();
            $foto = $filaFoto['foto'] ?? 'default-user.png';
            $stmtFoto->close();
        } else {
            $foto = 'default-user.png';
        }
    }

    if ($idConductor) {
        // **Actualizar Conductor**
        $queryVerificar = "SELECT id_conductor FROM conductores WHERE numero_licencia = ? AND id_conductor != ?";
        $stmtVerificar = $conn->prepare($queryVerificar);
        $stmtVerificar->bind_param("si", $numeroLicencia, $idConductor);
        $stmtVerificar->execute();
        $resultadoVerificar = $stmtVerificar->get_result();

        if ($resultadoVerificar->num_rows > 0) {
            $mensaje = "Error: El número de licencia ya está registrado.";
            $tipo_mensaje = "danger";
        } else {
            $sql = "CALL actualizar_conductor(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssssss", $idConductor, $nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado, $foto);

            if ($stmt->execute()) {
                $mensaje = "Conductor actualizado exitosamente.";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error al actualizar el conductor.";
                $tipo_mensaje = "danger";
            }
            $stmt->close();
        }
        $stmtVerificar->close();
    } else {
        // **Registrar Conductor**
        $queryVerificar = "SELECT id_conductor FROM conductores WHERE numero_licencia = ?";
        $stmtVerificar = $conn->prepare($queryVerificar);
        $stmtVerificar->bind_param("s", $numeroLicencia);
        $stmtVerificar->execute();
        $resultadoVerificar = $stmtVerificar->get_result();

        if ($resultadoVerificar->num_rows > 0) {
            $mensaje = "Error: El número de licencia ya está registrado.";
            $tipo_mensaje = "danger";
        } else {
            $sql = "CALL registrar_conductor(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado, $foto);

            if ($stmt->execute()) {
                $mensaje = "Nuevo conductor registrado exitosamente.";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error al registrar el conductor.";
                $tipo_mensaje = "danger";
            }
            $stmt->close();
        }
        $stmtVerificar->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Conductor</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "../VISTA/control_conductor.php";
        }, 3000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
