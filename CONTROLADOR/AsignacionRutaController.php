<?php

require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos
require_once __DIR__ . '/../MODELO/Asignacion_ruta.php';

class AsignacionRutaControlador
{
    // Método para obtener las asignaciones activas, ahora usa el modelo
   
    // Obtener lista de rutas
    public function obtenerRutas()
    {
        $conn = Conexion::conectar();
        $sql = "CALL ObtenerRutas()";
        return $conn->query($sql);
    }

    // Obtener lista de vehículos disponibles (sin conductor asignado)
    public function obtenerVehiculosDisponibles()
    {
        $conn = Conexion::conectar();
        $sql = "CALL ObtenerVehiculosSinRuta()";
        return $conn->query($sql);
    }

    // Asignar un vehículo a un conductor
    public function asignarRuta($id_Ruta, $idasignacionVehiculo, $fechaInicio, $fechaFin, $estado, $idVehiculo)
    {
        $conn = Conexion::conectar();
        // Insertar la asignación en la base de datos
        $sql = "CALL InsertarAsignacionRuta(?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $id_Ruta, $idasignacionVehiculo, $fechaInicio, $fechaFin, $estado);

        if ($stmt->execute()) {
            $stmt->close();
            if ($estado == "en_proceso") {
                // Actualizar el estado del vehículo a "en_proceso"
                $sql = "CALL InsertarUbicacionVehiculo(?, -17.789283, -63.161669, 1)";
                $stmtAct = $conn->prepare($sql);
                $stmtAct->bind_param("i", $idVehiculo);
                if ($stmtAct->execute()) {
                    $stmtAct->close();
                    return true; // Retorna éxito
                } else {
                    return true; // Retorna éxito
                }
            } else {
                return true; // Retorna éxito
            }

        } else {
            return false; // Retorna error
        }
    }

    public function obtenerAsignacionesActivas()
    {
        $conn = Conexion::conectar();
        $sql = "CALL ObtenerAsignacionesRutas()";

        $resultado = $conn->query($sql);

        // Verificar si hay resultados y convertir a un array
        return ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function generarReporteAsignaciones($fechaInicio, $fechaFin)
{
    // Establecer la conexión con la base de datos
    $conn = Conexion::conectar();
    
    // Llamamos al procedimiento almacenado para obtener las asignaciones de rutas en el rango de fechas
    $sql = "CALL reporte_asignaciones_rutas(?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $fechaInicio, $fechaFin); // Enlazamos las fechas a los parámetros
    $stmt->execute();
    
    // Obtener el resultado de la ejecución del procedimiento almacenado
    $resultado = $stmt->get_result();
    
    // Verificar si hay resultados y devolverlos como un array asociativo
    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_all(MYSQLI_ASSOC);
    } else {
        return []; // Si no hay resultados, devolvemos un array vacío
    }
}

    public function obtenerAsignVehiculoActivas()
    {
        $conn = Conexion::conectar();
        $sql = "CALL ListaVehiculoRuta()";

        $resultado = $conn->query($sql);

        // Verificar si hay resultados y convertir a un array
        return ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function cambiarEstado($idVehiculo, $idAsignacion)
    {
        $conn = Conexion::conectar();
    
        // Llamar al procedimiento para insertar la ubicación del vehículo
        $sql = "CALL InsertarUbicacionVehiculo(?, -17.789283, -63.161669, 1)";
        $stmtUbi = $conn->prepare($sql);
        $stmtUbi->bind_param("i", $idVehiculo);
    
        if ($stmtUbi->execute()) {
            $stmtUbi->close();
    
            // Actualizar la asignación como "en_proceso"
            $sql = "UPDATE asignaciones_rutas 
                    SET estado = 'en_proceso'
                    WHERE id_asignacion = ?";
        
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idAsignacion);
    
            if ($stmt->execute()) {
                $stmt->close();
    
                // Obtener los detalles de la asignación para insertar en la tabla 'viajes'
                $sql = "SELECT hora_inicio, hora_fin, id_asignacion
                        FROM asignaciones_rutas 
                        WHERE id_asignacion = ?";
            
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $idAsignacion);
                $stmt->execute();
                $result = $stmt->get_result();
                $asignacion = $result->fetch_assoc();
                
                if ($asignacion) {
                    // Datos para insertar en la tabla viajes
                    $horaInicio = $asignacion['hora_inicio'];
                    $horaFin = $asignacion['hora_fin'] ?? 'Pendiente';  // Si hora_fin es NULL, asignar "Pendiente"

                    $kilometrajeInicio = 0;  // Asegúrate de obtener el valor correcto del kilometraje
                    $combustibleInicio = 0;  // Asegúrate de obtener el valor correcto del combustible
        
                    // Insertar el registro en la tabla viajes
                    $sqlViaje = "INSERT INTO viajes (id_asignacion, fecha_inicio, fecha_fin, kilometraje_inicio, combustible_inicio, estado)
                                 VALUES (?, ?, ?, ?, ?, 'en_proceso')";
        
                    $stmtViaje = $conn->prepare($sqlViaje);
                    $stmtViaje->bind_param("issdd", $idAsignacion, $horaInicio, $horaFin, $kilometrajeInicio, $combustibleInicio);
                    $stmtViaje->execute();
                    $stmtViaje->close();
                }
    
                return true; // Retorna éxito
            } else {
                $stmt->close();
                return false; // Retorna error
            }
        } else {
            $stmtUbi->close();
            return false; // Retorna error
        }
    }

    public function eliminarRuta($id_asignacion)
    {
        $conn = Conexion::conectar();
        $sql = "CALL EliminarAsignacionRuta(?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_asignacion);
    
        return $stmt->execute();
    }
    public function cambiaracancelado($id_asignacion)
    {
        $conn = Conexion::conectar();
    
        // Actualizar la asignación como "cancelado"
        $sql = "UPDATE asignaciones_rutas 
                SET estado = 'cancelado'
                WHERE id_asignacion = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_asignacion);
    
        // Ejecutar la consulta y retornar el resultado
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Indica que la asignación fue cancelada con éxito
        } else {
            $stmt->close();
            return false; // Indica que hubo un error al cancelar la asignación
        }
    }
    
    public function cambiarUbicacion($idUbicacion, $latitud, $longitud)
    {
        $conn = Conexion::conectar();
        // Actualizar la asignación como "cancelado" y colocar la fecha de fin
        $sql = "UPDATE asignaciones_rutas 
        SET estado = 'en_proceso'
        WHERE id_asignacion = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUbicacion,$latitud, $longitud);
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Retorna éxito
        } else {
            $stmt->close();
            return false; // Retorna error
        }
    }
    public function obtenerReporteAsignacionesRutas($fechaInicio, $fechaFin)
    {
        // Establecer la conexión con la base de datos
        $conn = Conexion::conectar();
    
        // Llamamos al procedimiento almacenado para obtener las asignaciones de rutas en el rango de fechas
        $sql = "CALL reporte_asignaciones_rutas(?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $fechaInicio, $fechaFin); // Enlazamos las fechas a los parámetros
        $stmt->execute();
    
        // Obtener el resultado de la ejecución del procedimiento almacenado
        $resultado = $stmt->get_result();
    
        // Verificar si hay resultados y devolverlos como un array asociativo
        return ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }
    
}

?>
