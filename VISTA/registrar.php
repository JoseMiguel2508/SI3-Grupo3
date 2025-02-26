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
            <header>Registrarse</header>
            <form action="../CONTROLADOR/UsuarioController.php" method="post">
                <div class="field input">
                    <label for="usuario">Nombre Usuario</label>
                    <input type="text" name="usuario" id="usuario" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="contra">Contraseña</label>
                    <input type="password" name="contra" id="contra" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" name="nombre" id="nombre" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Registrar">
                </div>
                <div class="links">
                    Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>