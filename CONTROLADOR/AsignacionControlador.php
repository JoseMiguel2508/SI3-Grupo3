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
    public function obtenerReporteAsignacionVehiculo($fechaInicio, $fechaFin) {
        return $this->modelo->reporteAsignacionVehiculo($fechaInicio, $fechaFin);
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
        // Modificación aquí: excluimos vehículos ya asignados a un conductor
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
            // Mensaje de éxito
            $mensaje = "Vehículo asignado correctamente al conductor.";
            $tipo_mensaje = "success";
        } else {
            // Mensaje de error
            $mensaje = "Error al asignar el vehículo al conductor.";
            $tipo_mensaje = "danger";
        }

        $stmt->close();
        $conn->close();

        // Mostrar el mensaje en la misma vista
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registro de Conductor</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        </head>
        <body>
            <div class="container mt-5">
                <div class="alert alert-' . $tipo_mensaje . ' alert-dismissible fade show" role="alert">
                    ' . $mensaje . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = "../VISTA/asigna_conductor.php";
                }, 3000);
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        ';

        exit;
    }

    public function buscarAsignaciones($terminoBusqueda) {
        $conn = Conexion::conectar();
        $sql = "SELECT 
                   a.id_asignacion, 
                   c.nombre_completo, 
                   v.modelo, 
                   v.numero_placa, 
                   a.fecha_inicio, 
                   a.fecha_fin, 
                   a.estado
               FROM asignaciones_vehiculos a
               INNER JOIN conductores c ON a.id_conductor = c.id_conductor
               INNER JOIN vehiculos v ON a.id_vehiculo = v.id_vehiculo
               WHERE a.id_asignacion LIKE ? OR
                     c.nombre_completo LIKE ? OR
                     v.modelo LIKE ? OR
                     v.numero_placa LIKE ? OR
                     a.estado LIKE ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error en la consulta: ' . $conn->error);
        }
    
        // Definir el término de búsqueda
        $termino = '%' . $terminoBusqueda . '%';
    
        // Asociar los parámetros
        $stmt->bind_param("sssss", $termino, $termino, $termino, $termino, $termino);
    
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }
    public function darDeBajaAsignacion($idAsignacion) {
        $conn = Conexion::conectar();
    
        // Establecer la zona horaria de Bolivia
        date_default_timezone_set('America/La_Paz');  // Zona horaria de Bolivia
    
        $fechaFin = date("Y-m-d H:i:s");  // Fecha y hora actual
    
        // Actualizar la asignación como "cancelado" y colocar la fecha de fin
        $sql = "UPDATE asignaciones_vehiculos 
                SET estado = 'cancelado', fecha_fin = ? 
                WHERE id_asignacion = ?";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $fechaFin, $idAsignacion);
    
        if ($stmt->execute()) {
            // Liberar el conductor y vehículo (volver a estado 'disponible' y 'activo')
            $sqlLiberarConductor = "UPDATE conductores 
                                    SET estado = 'disponible' 
                                    WHERE id_conductor = (SELECT id_conductor FROM asignaciones_vehiculos WHERE id_asignacion = ?)";
            $sqlLiberarVehiculo = "UPDATE vehiculos 
                                   SET estado = 'activo' 
                                   WHERE id_vehiculo = (SELECT id_vehiculo FROM asignaciones_vehiculos WHERE id_asignacion = ?)";
    
            $stmtLiberarConductor = $conn->prepare($sqlLiberarConductor);
            $stmtLiberarVehiculo = $conn->prepare($sqlLiberarVehiculo);
            
            // Vincular parámetros
            $stmtLiberarConductor->bind_param("i", $idAsignacion);
            $stmtLiberarVehiculo->bind_param("i", $idAsignacion);
    
            // Ejecutar actualizaciones
            $stmtLiberarConductor->execute();
            $stmtLiberarVehiculo->execute();
    
            // Retornar éxito
            return true;
        } else {
            return false;
        }

        // Cerrar las declaraciones y la conexión
        $stmt->close();
        $stmtLiberarConductor->close();
        $stmtLiberarVehiculo->close();
        $conn->close();
    }
    
    

}
?>
