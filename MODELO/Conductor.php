<?php
require_once 'conex_consulta.php'; //conexión a la base de datos

class Conductor {
    private $conn; //almacena la conexión a la base de datos

    public function __construct() {
        $this->conn = Conexion::conectar(); //Una instancia de la clase
    }

    //Registrar un conductor en la base de datos
    public function registrarConductor($nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado) {
        // Sentencia SQL para insertar un nuevo conductor en la tabla 'conductores'
        $sql = "INSERT INTO conductores (nombre_completo, numero_licencia, tipo_licencia, fecha_vencimiento_licencia, telefono, estado)
                VALUES (?, ?, ?, ?, ?, ?)";

        // Prepara la sentencia SQL
        $stmt = $this->conn->prepare($sql);
        // Asigna los valores a los parámetros de la sentencia SQL
        $stmt->bind_param("ssssss", $nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado);

        // Ejecuta la sentencia SQL y retorna el resultado
        return $stmt->execute();
    }
}
?>
