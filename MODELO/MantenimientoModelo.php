<?php
require_once 'conex_consulta.php';

class MantenimientoModelo {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function obtenerMantenimientos() {
        $sql = "SELECT rm.*, v.marca, v.modelo, u.nombre_usuario AS creado_por_nombre
                FROM registros_mantenimiento rm
                JOIN vehiculos v ON rm.id_vehiculo = v.id_vehiculo
                LEFT JOIN usuarios u ON rm.creado_por = u.id_usuario";
        return $this->conexion->query($sql);
    }

    public function registrarMantenimiento($id_vehiculo, $tipo, $descripcion, $costo, $fecha_servicio, $fecha_proximo, $estado, $creado_por) {
        $sql = "INSERT INTO registros_mantenimiento (id_vehiculo, tipo_mantenimiento, descripcion, costo, fecha_servicio, fecha_proximo_servicio, estado, creado_por) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
    
        // Si notas está vacío, asignamos NULL
        if (empty($notas)) {
            $stmt->bind_param("issdsssi", $id_vehiculo, $tipo, $descripcion, $costo, $fecha_servicio, $fecha_proximo, $estado, $creado_por);
        } else {
            $stmt->bind_param("issdsssi", $id_vehiculo, $tipo, $descripcion, $costo, $fecha_servicio, $fecha_proximo, $estado, $creado_por);
        }
    
        return $stmt->execute();
    }
    
    

    public function obtenerVehiculos() {
        // Combina los vehículos con mantenimiento completado y los vehículos sin mantenimiento
        $query = "SELECT v.id_vehiculo, v.marca, v.modelo
                  FROM vehiculos v
                  LEFT JOIN registros_mantenimiento rm ON v.id_vehiculo = rm.id_vehiculo
                  WHERE rm.estado = 'completado'
                  UNION
                  SELECT v.id_vehiculo, v.marca, v.modelo
                  FROM vehiculos v
                  LEFT JOIN registros_mantenimiento rm ON v.id_vehiculo = rm.id_vehiculo
                  WHERE rm.id_vehiculo IS NULL";
        return $this->conexion->query($query);
    }
    

// Método para actualizar el estado del mantenimiento a "completado"
public function actualizarEstadoMantenimiento($id_mantenimiento) {
    $sql = "UPDATE registros_mantenimiento SET estado = 'completado' WHERE id_mantenimiento = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("i", $id_mantenimiento); // "i" es para integer
    return $stmt->execute();
}
    
public function obtenerVehiculosDisponibles() {
    $sql = "SELECT v.id_vehiculo, v.marca, v.modelo, v.numero_placa
            FROM vehiculos v
            LEFT JOIN registros_mantenimiento rm 
            ON v.id_vehiculo = rm.id_vehiculo 
            AND rm.estado != 'completado'
            WHERE v.estado = 'activo' 
            AND rm.id_vehiculo IS NULL
            OR (rm.estado = 'completado')
            GROUP BY v.id_vehiculo, v.marca, v.modelo, v.numero_placa";

    return $this->conexion->query($sql);
}

public function buscarMantenimientos($terminoBusqueda) {
    $conn = Conexion::conectar();
    $sql = "SELECT 
                m.id_mantenimiento, 
                v.marca, 
                v.modelo, 
                m.descripcion, 
                m.estado
            FROM registros_mantenimiento m
            INNER JOIN vehiculos v ON m.id_vehiculo = v.id_vehiculo
            WHERE v.marca LIKE ? OR v.modelo LIKE ? OR m.descripcion LIKE ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error en la consulta: ' . $conn->error);
    }
    
    $termino = '%' . $terminoBusqueda . '%';
    
    $stmt->bind_param("sss", $termino, $termino, $termino);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}


}
?>
