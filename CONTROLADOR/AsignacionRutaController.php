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
    public function asignarRuta($id_Ruta, $idasignacionVehiculo, $fechaInicio, $fechaFin, $estado)
    {
        $conn = Conexion::conectar();
        $fechaInicio = date("Y-m-d H:i:s", strtotime($fechaInicio)); // Formateamos la fecha correctamente
        $fechaFin = date("Y-m-d H:i:s", strtotime($fechaInicio));

        // Insertar la asignación en la base de datos
        $sql = "CALL InsertarAsignacionRuta(?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $id_Ruta, $idasignacionVehiculo, $fechaInicio, $fechaFin, $estado);

        if ($stmt->execute()) {
            return true; // Retorna éxito
        } else {
            return false; // Retorna error
        }

        $stmt->close();
    }


    public function obtenerAsignacionesActivas()
    {
        $conn = Conexion::conectar();
        $sql = "CALL ObtenerAsignacionesRutas()";
    
        $resultado = $conn->query($sql);
    
        // Verificar si hay resultados y convertir a un array
        return ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function eliminarRuta($id_asignacion)
    {
        $conn = Conexion::conectar();
        $sql = "CALL EliminarAsignacionRuta(?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_asignacion);

        return $stmt->execute();
    }

}
?>