<?php
session_start(); ?>


<!DOCTYPE html>
<html lang="en">

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
            include("../MODELO/conex_consulta.php");
            if (isset($_POST['submit'])) {
                $usuario = mysqli_real_escape_string($con, $_POST['usuario']);
                $contra = mysqli_real_escape_string($con, $_POST['contra']);

                $result = mysqli_query($con, "CALL obtener_usuario('$usuario', '$contra')") or die("Ocurrio un error");
                $row = mysqli_fetch_assoc($result);

                if (is_array($row) && !empty($row)) {//obtener la informacion del inicio de sesion
                    header("Location: navbar.php");

                } else {
                    echo "<div class='message'>
                            <p>Usuario o Contraseña Incorrectos</p>
                        </div> <br>";
                    echo "<a href='login.php'><button class='btn'>Volver</button>";

                }
            } else {


                ?>

                <header>Registrarse</header>
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
                        <input type="submit" class="btn" name="submit" value="Iniciar sesión" required>
                    </div>
                    <div class="links">
                        No tienes cuenta? <a href="registrar.php">Registrate</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>