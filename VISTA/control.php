<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor de Flotas en Ruta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="../CONTROLADOR/css/control.css">
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Monitor de Flotas en Ruta</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-status activo p-3">
                    <h5>🚚 ABC-123 <span class="badge bg-success">En Ruta</span></h5>
                    <p>Ruta: Santa Cruz de la Sierra → Montero</p>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success" style="width: 60%;"></div>
                    </div>
                    <p>Último mantenimiento: 14/2/2024</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mapModal">Ver en Mapa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar el mapa -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Ruta de Viaje: Santa Cruz → Montero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <script>
        document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {
            var map = L.map('map').setView([-17.7833, -63.1821], 10); // Vista centrada en Santa Cruz, Bolivia

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Coordenadas de Santa Cruz y Montero
            var startPoint = L.latLng(-17.7833, -63.1821); // Santa Cruz de la Sierra
            var endPoint = L.latLng(-17.3412, -63.2500); // Montero

            // Configuración de la ruta con marcadores personalizados
            L.Routing.control({
                waypoints: [startPoint, endPoint],
                createMarker: function (i, waypoint, n) {
                    if (i === 0) {
                        return L.marker(waypoint.latLng, { title: "Salida: Santa Cruz" });
                    } else if (i === n - 1) {
                        return L.marker(waypoint.latLng, { title: "Llegada: Montero" });
                    }
                },
                lineOptions: {
                    styles: [{ color: '#007bff', weight: 5 }]
                },
                routeWhileDragging: false,
                addWaypoints: false,
                draggableWaypoints: false,
                show: false // Oculta las indicaciones de texto
            }).addTo(map);
        });
    </script>
</body>

</html>
