<?php

require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos

class ViajeController {
    
    public function obtenerHistorialViajes() {
        $conn = Conexion::conectar();
        
        // Consultar la información de los viajes, incluyendo el nombre de la ruta y el nombre del conductor
        $sql = "SELECT v.id_viaje, r.nombre AS nombre_ruta, v.fecha_inicio, v.fecha_fin, c.nombre_completo AS nombre_completo
                FROM viajes v
                LEFT JOIN asignaciones_rutas a ON v.id_asignacion = a.id_asignacion
                LEFT JOIN rutas r ON a.id_ruta = r.id_ruta
                LEFT JOIN asignaciones_vehiculos av ON a.id_asignacion_vehiculo = av.id_asignacion
                LEFT JOIN conductores c ON av.id_conductor = c.id_conductor
                ORDER BY v.fecha_inicio DESC";
        
        $result = $conn->query($sql);
        $viajes = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $viajes[] = $row;
            }
        }
        
        $conn->close();
        
        return $viajes;
    }
}

?>
