<?php
// Incluir el archivo de conexión
include '../MODELO/conex_consulta.php';

// Obtener la conexión
$con = Conexion::conectar();

// Datos del nuevo usuario
$usuario = $_POST['usuario'];
$contra = $_POST['contra'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];

// Validación de usuario existente
$sql_usuario = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
$verify_usuario = $con->prepare($sql_usuario);
$verify_usuario->bind_param("s", $usuario);
$verify_usuario->execute();
$result_usuario = $verify_usuario->get_result();

if ($result_usuario->num_rows > 0) {
    $mensaje = "El usuario ya está registrado.";
    $tipo_mensaje = "danger";
} else {
    // Validación de email existente
    $sql_email = "SELECT * FROM usuarios WHERE correo = ?";
    $verify_email = $con->prepare($sql_email);
    $verify_email->bind_param("s", $email);
    $verify_email->execute();
    $result_email = $verify_email->get_result();

    if ($result_email->num_rows > 0) {
        $mensaje = "El correo electrónico ya está registrado.";
        $tipo_mensaje = "danger";
    } else {
        // Insertar nuevo usuario
        $sql_insert = "CALL InsertarUsuario(?, ?, ?, ?)";
        $stmt = $con->prepare($sql_insert);
        $stmt->bind_param("ssss", $usuario, $contra, $nombre, $email);

        if ($stmt->execute()) {
            $mensaje = "Nuevo usuario registrado exitosamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error en el registro: " . $stmt->error;
            $tipo_mensaje = "danger";
        }
        $stmt->close();
    }
    $verify_email->close();
}

// Cerrar conexiones
$verify_usuario->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="col-md-6">
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show shadow-lg p-4 rounded text-center" role="alert">
                <h4 class="alert-heading"><?php echo ($tipo_mensaje === "success") ? "¡Éxito!" : "¡Error!"; ?></h4>
                <p><?php echo $mensaje; ?></p>
                <hr>
                <p class="mb-0">Serás redirigido en unos segundos...</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php 
    if ($tipo_mensaje === "danger") {
        echo "<script>
            setTimeout(function () {
                window.location.href = '../VISTA/registrar.php';
            }, 3500);
        </script>";
    } else {
        echo "<script>
            setTimeout(function () {
                window.location.href = '../VISTA/login.php';
            }, 3000);
        </script>";
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>



</html>