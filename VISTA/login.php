<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CONTROLADOR/css/login.css">
    <title>Iniciar sesión</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
        <?php 
            include("../MODELO/conex_consulta.php"); // Se usa la nueva conexión

            if(isset($_POST['submit'])){
                $conexion = Conexion::conectar(); // Llamamos a la nueva clase

                $usuario = $conexion->real_escape_string($_POST['usuario']);
                $contra = $conexion->real_escape_string($_POST['contra']);

                // Llamada al procedimiento almacenado
                $query = "CALL ValidarUsuario('$usuario', '$contra')";
                $result = $conexion->query($query);
                
                if(!$result) {
                    die("Error en la consulta: " . $conexion->error);
                }
                $row = $result->fetch_assoc();
                if ($row) { // Verifica si se encontró un usuario
                    header("Location: navbar.php"); // Redirigir si es correcto
                    exit();
                } else {
                    echo "<div class='message'>
                            <p>Usuario o Contraseña Incorrectos</p>
                          </div> <br>";
                    echo "<a href='login.php'><button class='btn'>Volver</button></a>";
                }
            } else {
        ?>

            <header>Iniciar Sesión</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="contra">Contraseña</label>
                    <input type="password" name="contra" id="contra" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Iniciar sesión">
                </div>
                <div class="links">
                    No tienes cuenta? <a href="registrar.php">Regístrate</a>
                </div>
            </form>

        <?php } ?>
        </div>
    </div>
</body>

</html>
