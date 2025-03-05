<?php

require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos

class AsignacionRutaControlador
{
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


        // Actualizar la asignación como "cancelado" y colocar la fecha de fin
        $sql = "CALL InsertarUbicacionVehiculo(?, -17.789283, -63.161669, 1)";

        $stmtUbi = $conn->prepare($sql);
        $stmtUbi->bind_param("i", $idVehiculo);

        if ($stmtUbi->execute()) {
            $stmtUbi->close();
            // Actualizar la asignación como "cancelado" y colocar la fecha de fin
            $sql = "UPDATE asignaciones_rutas 
            SET estado = 'en_proceso'
            WHERE id_asignacion = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $idAsignacion);
            if ($stmt->execute()) {
                $stmt->close();
                //$conn->close();
                return true; // Retorna éxito
            } else {
                $stmt->close();
                //$conn->close();
                return false; // Retorna error
            }


        } else {
            $stmtUbi->close();
            //$conn->close();
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
}
?>