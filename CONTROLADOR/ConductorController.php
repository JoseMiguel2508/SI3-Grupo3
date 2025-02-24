<?php
session_start(); // Iniciar la sesión
require_once '../MODELO/Conductor.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre_completo']);
    $numeroLicencia = trim($_POST['numero_licencia']);
    $tipoLicencia = trim($_POST['tipo_licencia']);
    $fechaVencimiento = $_POST['fecha_vencimiento_licencia'];
    $telefono = trim($_POST['telefono']);
    $estado = $_POST['estado'];

    $conductor = new Conductor();
    
    if ($conductor->registrarConductor($nombre, $numeroLicencia, $tipoLicencia, $fechaVencimiento, $telefono, $estado)) {
        header("Location: ../VISTA/control_conductor.php?mensaje=registrado");
    } else {
        header("Location: ../VISTA/registro_conductor.php?error=fallo");
    }
    
}
?>
