<?php
require_once 'conex_consulta.php'; // Conexión a la base de datos

class Conductor {
    private $conn;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }


    // Método para buscar conductores de manera flexible
    public function buscarConductores($terminoBusqueda) {
        $sql = "SELECT nombre_completo, numero_licencia, tipo_licencia, estado, foto FROM conductores
                WHERE nombre_completo LIKE ? OR 
                      numero_licencia LIKE ? OR 
                      tipo_licencia LIKE ? OR 
                      estado LIKE ?";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            // Si hay un error en la preparación de la consulta
            die('Error en la consulta: ' . $this->conn->error);
        }

        $termino = '%' . $terminoBusqueda . '%';
        $stmt->bind_param("ssss", $termino, $termino, $termino, $termino);

        $stmt->execute();
        
        // Verificar si la consulta ejecutada devuelve resultados
        $resultado = $stmt->get_result();
        
        if ($resultado === false) {
            // Si no se obtienen resultados
            die('Error en la ejecución de la consulta: ' . $this->conn->error);
        }

        return $resultado; // Retorna los resultados de la búsqueda
    }
}
?>
