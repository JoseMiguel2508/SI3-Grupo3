<?php
require_once '../CONTROLADOR/MantenimientoControlador.php';

$controlador = new MantenimientoControlador();
$vehiculos = $controlador->obtenerVehiculos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Mantenimiento</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="panel border bg-white p-4 rounded shadow" style="max-width: 600px; width: 100%;">
            <h4 class="text-center font-weight-bold mb-3">Registrar Mantenimiento</h4>

            <form method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Vehículo</label>
                        <select id="vehiculo" name="id_vehiculo" class="form-control">
                    <option value="">Selecciona un vehículo</option>
                    <?php
                    // Verificar si hay vehículos
                    if ($vehiculos->num_rows > 0) {
                        while ($row = $vehiculos->fetch_assoc()) {
                            echo "<option value='" . $row["id_vehiculo"] . "'>" . $row["marca"] . " " . $row["modelo"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay vehículos con mantenimiento completado</option>";
                    }
                    ?>
                </select>

                    </div>
                    <div class="form-group col-md-6">
                        <label>Tipo</label>
                        <select name="tipo_mantenimiento" class="form-control" required>
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Costo</label>
                        <input type="number" name="costo" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Estado</label>
                        <select name="estado" class="form-control">
                            <option value="programado">Programado</option>
                            <option value="en_proceso">En Proceso</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nota</label>
                    <textarea name="notas" class="form-control" rows="2" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Fecha Servicio</label>
                        <input type="date" id="fecha_servicio" name="fecha_servicio" class="form-control" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Próximo Servicio</label>
                        <input type="date" id="fecha_proximo_servicio" name="fecha_proximo_servicio" class="form-control" readonly>
                    </div>
                </div>

                <input type="hidden" name="creado_por" value="1"> 

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm px-4">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script>
        document.getElementById("fecha_servicio").addEventListener("change", function() {
            let fechaServicio = new Date(this.value);
            if (!isNaN(fechaServicio.getTime())) {
                fechaServicio.setMonth(fechaServicio.getMonth() + 3); // Agrega 3 meses
                let fechaProxima = fechaServicio.toISOString().split("T")[0]; // Formato YYYY-MM-DD
                document.getElementById("fecha_proximo_servicio").value = fechaProxima;
            }
        });
    </script>
</body>
</html>
