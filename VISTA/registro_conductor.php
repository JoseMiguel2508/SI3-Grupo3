<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Conductor</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/form-elements.css">
    <link rel="stylesheet" href="../CONTROLADOR/css/nueva_asig_conductor.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
        <div class="panel border bg-white p-3">
            <div class="panel-heading">
                <h3 class="pt-2 font-weight-bold">Nuevo Conductor</h3>
            </div>

            <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'registrado'): ?>
                <div class="alert alert-success text-center">¡Conductor registrado correctamente!</div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] == 'fallo'): ?>
                <div class="alert alert-danger text-center">Error al registrar el conductor. Intente de nuevo.</div>
            <?php endif; ?>

            <div class="panel-body">
                <form action="../CONTROLADOR/ConductorController.php" method="POST" id="registroForm" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-id-card p-2"></span>
                                <input type="text" class="form-control" name="nombre_completo" placeholder="Nombre Completo" pattern="[A-Za-z\s]+" title="Solo letras y espacios permitidos" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-id-card p-2"></span>
                                <input type="text" class="form-control" name="numero_licencia" placeholder="Número de Licencia" pattern="[A-Za-z0-9]+" title="Solo letras y números permitidos" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-car p-2"></span>
                                <input type="text" class="form-control" name="tipo_licencia" placeholder="Tipo de Licencia" pattern="[A-Za-z\s]+" title="Solo letras y espacios permitidos" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-calendar-alt p-2"></span>
                                <input type="date" class="form-control" name="fecha_vencimiento_licencia" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-field">
                                <span class="fas fa-phone p-2"></span>
                                <input type="text" class="form-control" name="telefono" placeholder="Teléfono" pattern="[0-9]+" title="Solo números permitidos" required>
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

                    <!-- Campo para subir foto con vista previa -->
                    <div class="form-group">
                        <label for="foto"><strong>Foto del Conductor</strong></label>
                        <input type="file" class="form-control-file" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-2 text-center">
                            <img id="preview" src="../assets/default-user.png" alt="Vista previa" class="img-thumbnail" style="max-width: 150px; display: none;">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-sm mt-3 px-3">Guardar</button>
                    </div>
                    <div class="text-center mt-2">
                        <a href="control_conductor.php" class="btn btn-secondary btn-sm">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = "block";
            }
            if(event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</body>
</html>
