<!-- <?php
session_start();
?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CONTROLADOR/css/login.css">
    <title>Registrar</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include("../MODELO/conex_consulta.php");
            if (isset($_POST['submit'])) {
                $nombre_usuario = $_POST['usuario'];
                $contrasena = $_POST['contra'];
                $nombre_completo = $_POST['nombre'];
                $correo = $_POST['email'];

                //verificar que el usuario y email sea unico no este registrado
            
                $verify_user = mysqli_query($con, "SELECT nombre_usuario FROM usuarios WHERE nombre_usuario = '$nombre_usuario'");

                if (mysqli_num_rows($verify_user) != 0) {
                    echo "<div class='message'>
                                <p>Este usuario ya fue registrado, por favor ingrese otro!</p>
                            </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Volver</button>";//volver
                } else {
                    $verify_email = mysqli_query($con, "SELECT correo FROM usuarios WHERE correo = '$correo'");

                    if (mysqli_num_rows($verify_email) != 0) {
                        echo "<div class='message'>
                                    <p>Este correo ya fue registrado, por favor ingrese otro!</p>
                                </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Volver</button>";//volver
                    } else {
                        mysqli_query($con, "CALL  insertar_usuario('$nombre_usuario', '$contrasena', '$nombre_completo', '$correo')") or die("Ocurrio un error");
                        echo "<div class='message'>

                                    <p>Registro Exitoso!</p>
                                </div> <br>";
                        echo "<a href='login.php'><button class='btn'>Iniciar</button>";

                    }
                }
            } else {
                ?>
                <header>Registrarse</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="usuario">Nombre Usuario</label>
                        <input type="text" name="usuario" id="usuario" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="contra">Contraseña</label>
                        <input type="contra" name="contra" id="contra" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" name="nombre" id="nombre" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>


                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Registrar" required>
                    </div>
                    <div class="links">
                        Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>