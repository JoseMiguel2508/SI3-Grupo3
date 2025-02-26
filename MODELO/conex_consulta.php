<?php
class Conexion {
    public static function conectar() {
        $servidor = "localhost";
        $usuario = "root";  
        $password = "";  
        $baseDatos = "control_flotas";

        $conexion = new mysqli($servidor, $usuario, $password, $baseDatos);

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        return $conexion;
    }
}
?>
