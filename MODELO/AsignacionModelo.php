<?php
require_once 'conex_consulta.php';

class AsignacionModelo {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    // Obtener asignaciones activas
    public function obtenerAsignacionesActivas() {
        $sql = "SELECT a.id_asignacion, v.modelo, v.numero_placa, c.nombre_completo, 
                       a.fecha_inicio, a.fecha_fin, a.estado
                FROM asignaciones_vehiculos a
                INNER JOIN vehiculos v ON a.id_vehiculo = v.id_vehiculo
                INNER JOIN conductores c ON a.id_conductor = c.id_conductor
                WHERE a.estado = 'activo'";

        $resultado = $this->conn->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }


}
?>
