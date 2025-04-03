<?php
require_once 'conex_consulta.php';

class Asignacion_ruta {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar(); // Conectar a la base de datos
    }

    // Método para obtener las asignaciones de rutas
    public function obtenerAsignacionesActivas($fechaInicio, $fechaFin) {
        // Llamar al procedimiento almacenado con parámetros de fecha
        $query = "CALL reporte_asignaciones_rutas(?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $fechaInicio, $fechaFin); // Asignar los parámetros de fecha
        $stmt->execute();
        $resultado = $stmt->get_result(); // Obtener los resultados
        return $resultado->fetch_all(MYSQLI_ASSOC); // Retornar los resultados como un array asociativo
    }
}
?>
