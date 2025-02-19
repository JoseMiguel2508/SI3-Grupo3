<html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CONTROLADOR/css/controlflot.css">
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Control de Flotas Trans Aerosur</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-status activo p-3">
                    <h5>🚚 ABC-123 <span class="badge bg-success">Activo</span></h5>
                    <p>Lat: 40.7128, Lng: -74.0060</p>
                    <div class="progress">
                        <div class="progress-bar" style="width: 75%;"></div>
                    </div>
                    <p>Último mantenimiento: 14/2/2024</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-status mantenimiento p-3">
                    <h5>⛔ XYZ-789 <span class="badge bg-warning">En Mantenimiento</span></h5>
                    <p>Lat: 34.0522, Lng: -118.2437</p>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: 45%;"></div>
                    </div>
                    <p>Último mantenimiento: 29/2/2024</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-status inactivo p-3">
                    <h5>🚌 DEF-456 <span class="badge bg-danger">Inactivo</span></h5>
                    <p>Lat: 41.8781, Lng: -87.6298</p>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: 90%;"></div>
                    </div>
                    <p>Último mantenimiento: 19/1/2024</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>