<?php
require_once 'conex_consulta.php'; // Conexión a la base de datos

class Vehiculo {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    // Método para registrar un nuevo vehículo
    public function registrarVehiculo($numero_placa, $marca, $modelo, $anio, $capacidad, $estado) {
        $sql = "CALL RegistrarVehiculo(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Error en la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("ssssss", $numero_placa, $marca, $modelo, $anio, $capacidad, $estado);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "Error en el registro: " . $stmt->error;
        } else {
            return "Registro exitoso";
        }
    }

    // Método para editar un vehículo existente
    public function editarVehiculo($id_vehiculo, $numero_placa, $marca, $modelo, $anio, $capacidad, $estado) {
        $sql = "CALL EditarVehiculo(?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Error en la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("isssids", $id_vehiculo, $numero_placa, $marca, $modelo, $anio, $capacidad, $estado);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return "Error en la actualización: " . $stmt->error;
        } else {
            return "Actualización exitosa";
        }
    }

    // Método para listar todos los vehículos
    public function listarVehiculos() {
        $sql = "CALL ListarVehiculos()";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die('Error en la consulta: ' . $this->conn->error);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado === false) {
            die('Error en la ejecución de la consulta: ' . $this->conn->error);
        }

        return $resultado;
    }
}
?>