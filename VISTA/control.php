<?php
require_once '../CONTROLADOR/AsignacionRutaController.php';

// Instanciar el controlador
$asignacionRuta = new AsignacionRutaControlador();

$listaAsignaciones = $asignacionRuta->obtenerAsignVehiculoActivas();
?>

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
            height: 500px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Monitor de Flotas en Ruta</h2>

        <div class="row">
            <?php if (!empty($listaAsignaciones)): ?>
                <?php foreach ($listaAsignaciones as $asignacion): ?>
                    <div class="col-md-4">
                        <div class="card card-status activo p-3">
                            <h5>🚚 <?= htmlspecialchars($asignacion["numero_placa"], ENT_QUOTES, 'UTF-8') ?> <span
                                    class="badge bg-success">En Ruta</span></h5>
                            <p><strong>🛣 Ruta:</strong>
                                <?= htmlspecialchars($asignacion["nombre_ruta"], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>👨‍✈ Conductor:</strong>
                                <?= htmlspecialchars($asignacion["nombre_completo"], ENT_QUOTES, 'UTF-8') ?></p>
                            <p><strong>🚗 Modelo del Vehículo:</strong>
                                <?= htmlspecialchars($asignacion["modelo"], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" style="width: 60%;"></div>
                            </div>
                            <p>Último mantenimiento: <?= htmlspecialchars($asignacion["hora_inicio"], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <button class="btn btn-danger ver-mapa" data-bs-toggle="modal" data-bs-target="#mapModal"
                                data-end="<?= htmlspecialchars($asignacion["latitud_fin"], ENT_QUOTES, 'UTF-8') ?>,<?= htmlspecialchars($asignacion["longitud_fin"], ENT_QUOTES, 'UTF-8') ?>">
                                Ver en Mapa
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-danger fw-bold">No hay asignaciones activas</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para mostrar el mapa -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Mapa de la Ruta de Viaje </h5>
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
        document.addEventListener("DOMContentLoaded", function () {
            var modal = document.getElementById("mapModal");
            var map, vehicleMarker;

            modal.addEventListener("shown.bs.modal", function (event) {
                var button = event.relatedTarget;
                var end = button.getAttribute("data-end").split(",");

                var startLatLng = L.latLng(-17.789283449574143, -63.16166950140825); // Punto de partida
                var endLatLng = L.latLng(parseFloat(end[0]), parseFloat(end[1]));   // Destino
                var vehicleLatLng = L.latLng(-17.790500, -63.160000);  // Posición inicial del vehículo

                // Elimina el contenido del mapa anterior si existe
                var mapContainer = document.getElementById("map");
                mapContainer.innerHTML = "";

                // Inicializar el mapa
                map = L.map(mapContainer).setView(startLatLng, 10);

                // Agregar capa base
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Agregar marcadores
                L.marker(startLatLng).addTo(map).bindPopup("Punto de Partida").openPopup();
                L.marker(endLatLng).addTo(map).bindPopup("Punto de Llegada").openPopup();

                // 🔴 Agregar el marcador del vehículo
                vehicleMarker = L.marker(vehicleLatLng, {
                    icon: L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/1483/1483336.png', // Ícono de camión
                        iconSize: [32, 32],
                        iconAnchor: [16, 16]
                    })
                }).addTo(map).bindPopup("Vehículo en movimiento");

                // 🛣 Dibujar la ruta
                var routingControl = L.Routing.control({
                    waypoints: [startLatLng, endLatLng],
                    createMarker: function (i, waypoint, n) {
                        return L.marker(waypoint.latLng, {
                            title: i === 0 ? "Salida" : "Llegada"
                        });
                    },
                    lineOptions: {
                        styles: [{ color: '#007bff', weight: 5 }]
                    },
                    routeWhileDragging: false,
                    addWaypoints: false,
                    draggableWaypoints: false,
                    show: false
                }).addTo(map);

                // 📍 Simular el movimiento del vehículo cada 3 segundos
                var progress = 0;
                var interval = setInterval(function () {
                    if (progress >= 1) {
                        clearInterval(interval);
                        return;
                    }

                    var newLat = startLatLng.lat + (endLatLng.lat - startLatLng.lat) * progress;
                    var newLng = startLatLng.lng + (endLatLng.lng - startLatLng.lng) * progress;

                    vehicleMarker.setLatLng([newLat, newLng]);
                    progress += 0.1;  // Incremento de la posición del vehículo
                }, 3000);

                // Ajustar vista del mapa
                setTimeout(function () {
                    map.invalidateSize();
                    map.fitBounds(L.latLngBounds([startLatLng, endLatLng]));
                }, 200);
            });

            // Eliminar el mapa al cerrar el modal
            modal.addEventListener("hidden.bs.modal", function () {
                if (map) {
                    map.remove();
                }
            });
        });

    </script>
</body>

</html>