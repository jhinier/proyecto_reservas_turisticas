<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mapa Turístico</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7f6;
        }

        .header {
            padding: 15px;
            background: #0f766e;
            color: white;
            text-align: center;
            font-size: 20px;
        }

        #map {
            height: calc(100vh - 60px);
            width: 100%;
        }

        .popup-title {
            font-weight: bold;
            font-size: 16px;
        }

        .popup-img {
            width: 100%;
            border-radius: 8px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">
        🗺️ Mapa Turístico Interactivo - La Candelaria
    </div>

    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Crear mapa centrado
        const map = L.map('map').setView([-1.6635, -78.6545], 13);

        // Capa base
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Lugares turísticos
        const lugares = [
            {
                nombre: "Centro Histórico",
                lat: -1.6635,
                lng: -78.6545,
                descripcion: "Zona histórica con arquitectura colonial y cultura viva.",
                img: "https://upload.wikimedia.org/wikipedia/commons/6/6e/Riobamba_centro.jpg"
            },
            {
                nombre: "Museo de la Ciudad",
                lat: -1.6608,
                lng: -78.6510,
                descripcion: "Museo con historia y arte local.",
                img: "https://upload.wikimedia.org/wikipedia/commons/3/3a/Museo_Quito.jpg"
            },
            {
                nombre: "Parque Central",
                lat: -1.6660,
                lng: -78.6560,
                descripcion: "Parque turístico y recreativo.",
                img: "https://upload.wikimedia.org/wikipedia/commons/8/8a/Parque_central.jpg"
            }
        ];

        // Marcadores
        lugares.forEach(lugar => {
            L.marker([lugar.lat, lugar.lng])
                .addTo(map)
                .bindPopup(`
                    <b>${lugar.nombre}</b><br>
                    <p>${lugar.descripcion}</p>
                    <img src="${lugar.img}" style="width:100%; border-radius:8px;">
                `);
        });

        // Ruta
        const ruta = lugares.map(l => [l.lat, l.lng]);

        L.polyline(ruta, {
            color: 'green',
            weight: 4,
            dashArray: '10, 10'
        }).addTo(map);

        // Ajustar zoom automático
        const bounds = L.latLngBounds(ruta);
        map.fitBounds(bounds);

    </script>

</body>
</html>