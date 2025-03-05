<?php
require_once '../MODELO/MantenimientoModelo.php';

class MantenimientoControlador {
    private $modelo;

    public function __construct() {
        $this->modelo = new MantenimientoModelo();
    }

    public function obtenerMantenimientos() {
        return $this->modelo->obtenerMantenimientos();
    }

    public function obtenerVehiculos() {
        return $this->modelo->obtenerVehiculos();
    }
    public function registrarMantenimiento($data) {
        // Aquí se asume que el modelo ya tiene la lógica para insertar el mantenimiento.
        $exito = $this->modelo->registrarMantenimiento(
            $data['id_vehiculo'],
            $data['tipo_mantenimiento'],
            $data['descripcion'],
            $data['costo'],
            $data['fecha_servicio'],
            $data['fecha_proximo_servicio'],
            $data['estado'],
            $data['creado_por']

        );
        
        if ($exito) {
            $mensaje = "Mantenimiento registrado correctamente.";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Error al registrar mantenimiento.";
            $tipo_mensaje = "danger";
        }

        // HTML del mensaje de éxito o error
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registro de Mantenimiento</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
            <script src='https://code.jquery.com/jquery-3.5.1.min.js'></script>
        </head>
        <body>
            <div class='container mt-5'>
                <div class='alert alert-$tipo_mensaje alert-dismissible fade show' role='alert'>
                    $mensaje
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            </div>
            <script>
                // Redirigir después de 3 segundos
                setTimeout(function() {
                    window.location.href = '../VISTA/lista_mantenimiento.php'; // Redirigir a la página de mantenimientos
                }, 3000);
            </script>
            <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js'></script>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
        </body>
        </html>
        ";
    }
}

$controlador = new MantenimientoControlador();
$notas = new MantenimientoControlador();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Registrar el mantenimiento y obtener el mensaje de éxito o error
    $controlador->registrarMantenimiento($_POST);

}
?>
