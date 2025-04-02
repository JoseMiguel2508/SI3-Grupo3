<?php
require_once '../MODELO/conex_consulta.php'; // Para la conexión a la base de datos
require_once '../MODELO/Alerta.php';  // Incluir la clase Alerta
class AlertaControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new Alerta();
    }

    // Listar alertas activas
    public function listarAlertas() {
        $alertaModelo = new Alerta();
    
    // Obtener solo alertas activas
    return $alertaModelo->obtenerAlertasActivas();
    }

    // Registrar una nueva alerta manualmente
    public function registrarAlerta($id_vehiculo, $tipo_alerta, $descripcion, $severidad) {
        return $this->modelo->insertarAlerta($id_vehiculo, $tipo_alerta, $descripcion, $severidad);
    }

    // Marcar una alerta como reconocida
    public function reconocerAlerta($id_alerta) {
        return $this->modelo->reconocerAlerta($id_alerta);
    }

    // Marcar una alerta como resuelta
    public function resolverAlerta($id_alerta, $resuelto_por) {
        return $this->modelo->resolverAlerta($id_alerta, $resuelto_por);
    }

    // Ejecutar verificación de mantenimientos vencidos
    public function verificarAlertasMantenimiento() {
        $this->modelo->verificarMantenimientosVencidos();
    }
    
}

// Ejecutar la verificación de alertas de mantenimiento cada vez que se carga este archivo
$controlador = new AlertaControlador();
$controlador->verificarAlertasMantenimiento();
