<?php
require_once '../MODELO/AsignacionModelo.php';
require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos

class AsignacionControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new AsignacionModelo();
    }

    // Obtener asignaciones activas
    public function obtenerAsignacionesActivas() {
        return $this->modelo->obtenerAsignacionesActivas();
    }

    // Obtener lista de conductores disponibles (sin vehículo asignado)
    public function obtenerConductoresDisponibles() {
        $conn = Conexion::conectar();
        $sql = "SELECT id_conductor, nombre_completo 
                FROM conductores 
                WHERE estado = 'disponible' 
                AND id_conductor NOT IN (SELECT id_conductor FROM asignaciones_vehiculos WHERE estado = 'activo')";
        return $conn->query($sql);
    }

    // Obtener lista de vehículos disponibles (sin conductor asignado)
    public function obtenerVehiculosDisponibles() {
        $conn = Conexion::conectar();
        $sql = "SELECT id_vehiculo, marca, modelo, numero_placa 
                FROM vehiculos 
                WHERE estado = 'activo' 
                AND id_vehiculo NOT IN (SELECT id_vehiculo FROM asignaciones_vehiculos WHERE estado = 'activo')";
        return $conn->query($sql);
    }

    // Asignar un vehículo a un conductor
    public function asignarVehiculo($idConductor, $idVehiculo, $fechaInicio) {
        $conn = Conexion::conectar();
        $fechaInicio = date("Y-m-d H:i:s", strtotime($fechaInicio)); // Formateamos la fecha correctamente

        // Insertar la asignación en la base de datos
        $sql = "INSERT INTO asignaciones_vehiculos (id_conductor, id_vehiculo, fecha_inicio, estado) 
                VALUES (?, ?, ?, 'activo')";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $idConductor, $idVehiculo, $fechaInicio);

        if ($stmt->execute()) {
            return true; // Retorna éxito
        } else {
            return false; // Retorna error
        }

        $stmt->close();
    }
}
?>
