<?php
session_start();
require_once '../MODELO/Conductor.php';
require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idConductor = $_POST['id_conductor']; // Se espera que el ID del conductor venga desde el formulario
    $nombre = trim($_POST['nombre_completo']);
    $numeroLicencia = trim($_POST['numero_licencia']);
    $tipoLicencia = trim($_POST['tipo_licencia']);
    $fechaVencimiento = $_POST['fecha_vencimiento_licencia'];
    $telefono = trim($_POST['telefono']);
    $estado = $_POST['estado'];

    $conn = Conexion::conectar(); // Establecer la conexión a la base de datos

    // Obtener la foto actual si no se sube una nueva
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
        // Si no se subió una nueva foto, obtener la foto existente de la base de datos
        $query = "SELECT foto FROM conductores WHERE id_conductor = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idConductor);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $foto = $fila['foto'] ?? 'default-user.png'; // Mantener la foto anterior o usar una por defecto
        $stmt->close();
    }

    // Llamar al procedimiento almacenado para actualizar
    $sql = "CALL actualizar_conductor(?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isssssss", $idConductor, $nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado, $foto);
        
        // Ejecutar el procedimiento almacenado
        if ($stmt->execute()) {
            header("Location: ../VISTA/control_conductor.php?mensaje=actualizado");
        } else {
            header("Location: ../VISTA/actualizar_conductor.php?error=fallo");
        }

        $stmt->close();
    } else {
        header("Location: ../VISTA/actualizar_conductor.php?error=fallo");
    }

    $conn->close();
}
?>
