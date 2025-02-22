<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Conductor</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../CONTROLADOR/css/form_style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="panel border bg-white p-3">
            <div class="panel-heading">
                <h3 class="pt-2 font-weight-bold">Nuevo Conductor</h3>
            </div>
            <div class="panel-body">
                <form action="guardar_conductor.php" method="POST" class="registration-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-id-card p-2"></span>
                                <input type="text" class="form-control" name="numero_licencia" placeholder="Número de Licencia" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-car p-2"></span>
                                <input type="text" class="form-control" name="tipo_licencia" placeholder="Tipo de Licencia" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-calendar-alt p-2"></span>
                                <input type="date" class="form-control" name="fecha_vencimiento_licencia" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-phone p-2"></span>
                                <input type="text" class="form-control" name="telefono" placeholder="Teléfono" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-user p-2"></span>
                                <select class="form-control" name="usuario" required>
                                    <option value="">Seleccione un Usuario</option>
                                    <option value="usuario1">Usuario 1</option>
                                    <option value="usuario2">Usuario 2</option>
                                    <option value="usuario3">Usuario 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-toggle-on p-2"></span>
                                <select class="form-control" name="estado" required>
                                    <option value="disponible">Disponible</option>
                                    <option value="en_ruta">En Ruta</option>
                                    <option value="fuera_servicio">Fuera de Servicio</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Guardar Conductor</button>
                    <div class="text-center mt-2">
                        <a href="conductores.php" class="btn btn-secondary btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
