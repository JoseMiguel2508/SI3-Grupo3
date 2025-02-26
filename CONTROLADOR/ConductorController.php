<?php
session_start();
require_once '../MODELO/Conductor.php';
require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre_completo']);
    $numeroLicencia = trim($_POST['numero_licencia']);
    $tipoLicencia = trim($_POST['tipo_licencia']);
    $fechaVencimiento = $_POST['fecha_vencimiento_licencia'];
    $telefono = trim($_POST['telefono']);
    $estado = $_POST['estado'];

    $foto = NULL;

    // Verificar si se subió un archivo
    if (!empty($_FILES['foto']['name'])) {
        $directorioDestino = "../uploads/";
        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        $nombreArchivo = time() . "_" . basename($_FILES["foto"]["name"]);
        $rutaCompleta = $directorioDestino . $nombreArchivo;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaCompleta)) {
            $foto = $nombreArchivo;
        }
    }

    // Llamar al procedimiento almacenado
    $conn = Conexion::conectar(); // Establecer la conexión a la base de datos

    $sql = "CALL registrar_conductor(?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado, $foto);
        
        // Ejecutar el procedimiento almacenado
        if ($stmt->execute()) {
            header("Location: ../VISTA/control_conductor.php?mensaje=registrado");
        } else {
            header("Location: ../VISTA/registro_conductor.php?error=fallo");
        }

        $stmt->close();
    } else {
        header("Location: ../VISTA/registro_conductor.php?error=fallo");
    }
}
?>
