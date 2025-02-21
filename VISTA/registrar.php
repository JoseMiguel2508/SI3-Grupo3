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
            <!-- <?php 
                include("../MODELO/conexion.php");
                if(isset($_POST['submit'])){
                    $usuario = $_POST['usuario'];
                    $tipo_usuario= 4;
                    $contra = $_POST['contra'];
                    $nombre = $_POST['nombre'];
                    $email = $_POST['email'];
                    $telefono = $_POST['telefono'];

                    //verificar que el email sea unico no este registrado

                    $verify_query = mysqli_query($con,"SELECT usuario FROM usuarios WHERE usuario='$usuario'");

                    if(mysqli_num_rows($verify_query) !=0 ){
                        echo "<div class='message'>
                                <p>Este usuario ya fue registrado, por favor ingrese otro!</p>
                            </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Volver</button>";//volver
                    }
                    else{

                        mysqli_query($con,"INSERT INTO usuarios(usuario,id_tipo_usuario,contraseña_hash,nombre_completo,telefono,mail) VALUES('$usuario','$tipo_usuario','$contra','$nombre','$email','$telefono')") or die("Ocurrio un error");
            
                        echo "<div class='message'>
                                <p>Registro Exitoso!</p>
                            </div> <br>";
                        echo "<a href='login.php'><button class='btn'>Iniciar</button>";
            
                    }
                    }else{
            ?> -->
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

                <div class="field input">
                    <label for="telefono">Telefono Personal</label>
                    <input type="text" name="telefono" id="telefono" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Registrar" required>
                </div>
                <div class="links">
                    Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
                </div>
            </form>
        </div>
        <!-- <?php } ?> -->
    </div>
</body>

</html>