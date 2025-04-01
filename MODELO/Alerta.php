<?php
require_once 'conex_consulta.php';

class Alerta {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    // Obtener todas las alertas activas
    public function obtenerAlertasActivas() {
        try {
            $sql = "SELECT id_alerta, id_vehiculo, tipo_alerta, descripcion, severidad 
                    FROM alertas 
                    WHERE estado = 'activa'";
            $stmt = $this->conn->query($sql);

            if (!$stmt) {
                throw new Exception("Error en la consulta: " . $this->conn->error);
            }

            $alertas = $stmt->fetch_all(MYSQLI_ASSOC);
            return $alertas ?: []; // Si no hay alertas, devuelve un array vacío
        } catch (Exception $e) {
            error_log("Error en obtenerAlertasActivas: " . $e->getMessage());
            return [];
        }
    }

    // Insertar una nueva alerta
    public function insertarAlerta($id_vehiculo, $tipo_alerta, $descripcion, $severidad) {
        try {
            $sql = "INSERT INTO alertas (id_vehiculo, tipo_alerta, descripcion, severidad, estado) 
                    VALUES (?, ?, ?, ?, 'activa')";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }

            $stmt->bind_param("isss", $id_vehiculo, $tipo_alerta, $descripcion, $severidad);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en insertarAlerta: " . $e->getMessage());
            return false;
        }
    }

    // Marcar alerta como reconocida
    public function reconocerAlerta($id_alerta) {
        return $this->actualizarEstadoAlerta($id_alerta, 'reconocida');
    }

    // Marcar alerta como resuelta
    public function resolverAlerta($id_alerta, $resuelto_por) {
        try {
            $sql = "UPDATE alertas 
                    SET estado = 'resuelta', fecha_resolucion = NOW(), resuelto_por = ? 
                    WHERE id_alerta = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }

            $stmt->bind_param("ii", $resuelto_por, $id_alerta);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en resolverAlerta: " . $e->getMessage());
            return false;
        }
    }

    // Función genérica para actualizar el estado de una alerta
    private function actualizarEstadoAlerta($id_alerta, $nuevo_estado) {
        try {
            $sql = "UPDATE alertas SET estado = ? WHERE id_alerta = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $this->conn->error);
            }

            $stmt->bind_param("si", $nuevo_estado, $id_alerta);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en actualizarEstadoAlerta: " . $e->getMessage());
            return false;
        }
    }

    // Verificar vehículos con mantenimiento vencido y generar alertas
    public function verificarMantenimientosVencidos() {
        try {
            $query = "SELECT rm.id_vehiculo, v.marca, v.modelo, rm.fecha_proximo_servicio 
                      FROM registros_mantenimiento rm
                      JOIN vehiculos v ON rm.id_vehiculo = v.id_vehiculo
                      LEFT JOIN alertas a ON rm.id_vehiculo = a.id_vehiculo AND a.tipo_alerta = 'mantenimiento'
                      WHERE rm.fecha_proximo_servicio <= CURDATE() 
                      AND rm.estado != 'completado' 
                      AND a.id_alerta IS NULL"; // Solo si no existe una alerta
    
            $stmt = $this->conn->query($query);

            if (!$stmt) {
                throw new Exception("Error en la consulta de mantenimientos vencidos: " . $this->conn->error);
            }

            while ($fila = $stmt->fetch_assoc()) {
                $this->insertarAlerta(
                    $fila['id_vehiculo'],
                    'mantenimiento',
                    "El vehículo {$fila['marca']} {$fila['modelo']} necesita mantenimiento.",
                    'alta'
                );
            }
        } catch (Exception $e) {
            error_log("Error en verificarMantenimientosVencidos: " . $e->getMessage());
        }
    }
}
?>
