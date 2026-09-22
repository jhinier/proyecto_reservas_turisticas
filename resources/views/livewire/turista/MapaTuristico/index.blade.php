<div>

    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        #map{
            height:700px;
            border-radius:20px;
            box-shadow:0 10px 25px rgba(0,0,0,.15);
        }
    </style>

    <div class="mx-auto max-w-7xl p-6">

        <!-- TÍTULO -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-emerald-700">
                🗺️ Mapa Turístico de La Candelaria
            </h1>

            <p class="text-gray-500 mt-2">
                Explora los atractivos turísticos de manera interactiva.
            </p>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <!-- MAPA -->
            <div class="col-span-8">

                <div id="map"></div>

            </div>

            <!-- PANEL DERECHO -->
            <div class="col-span-4">

                <div id="panelLugar"
                     class="bg-white rounded-2xl shadow-lg h-[700px] p-6 overflow-y-auto">

                    <div class="flex flex-col items-center justify-center h-full text-center">

                        <div class="text-6xl mb-4">
                            🗺️
                        </div>

                        <h2 class="text-2xl font-bold text-gray-700">
                            Explora el mapa
                        </h2>

                        <p class="text-gray-500 mt-4">

                            Haz clic sobre cualquier marcador para visualizar toda la información del atractivo turístico.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>

        document.addEventListener("DOMContentLoaded", iniciarMapa);

        function iniciarMapa(){

            if(window.mapaTuristico){
                return;
            }

            const mapa = L.map('map').setView([-1.651618,-78.4410895],13);

            window.mapaTuristico = mapa;

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    attribution:'© OpenStreetMap'
                }
            ).addTo(mapa);

            // =======================
            // CAPAS DEL MAPA
            // =======================

            // 🗺️ Carto Voyager (Principal)
            const carto = L.tileLayer(
                'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',
                {
                    attribution: '&copy; OpenStreetMap &copy; CARTO'
                }
            );

            // 🛰️ Satélite Esri
            const satelite = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                {
                    attribution: 'Tiles © Esri'
                }
            );

            // ⛰️ Topográfico
            const topografico = L.tileLayer(
                'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
                {
                    attribution: '© OpenTopoMap'
                }
            );

            // Cargar el mapa principal
            carto.addTo(mapa);

            // =======================
            // CONTROL DE CAPAS
            // =======================

            const mapasBase = {

                "🗺️ Carto Voyager": carto,

                "🛰️ Satélite": satelite,

                "⛰️ Topográfico": topografico

            };

            L.control.layers(mapasBase).addTo(mapa);

            // --------- GeoJSON ---------

            fetch('/geojson/la-candelaria.geojson')
            .then(res=>res.json())
            .then(data=>{

                const limite=L.geoJSON(data,{

                    style:{
                        color:'#16a34a',
                        weight:3,
                        fillColor:'#22c55e',
                        fillOpacity:0.15
                    }

                }).addTo(mapa);

                mapa.fitBounds(limite.getBounds());

            });


            // -------- Lugares ---------

        const lugares = @json($lugares);

        lugares.forEach(function(lugar){

            const marcador = L.marker([
                lugar.lat,
                lugar.lng
            ]).addTo(mapa);

            marcador.on("click", function(){

                mostrarLugar(lugar);

            });

        });

        } // ← AQUÍ TERMINA iniciarMapa()


        function mostrarLugar(lugar){

            document.getElementById("panelLugar").innerHTML = `

                <img src="${lugar.imagenes[0]}"
                     class="w-full h-60 object-cover rounded-xl shadow">

                <h2 class="text-3xl font-bold mt-5 text-emerald-700">
                    ${lugar.nombre}
                </h2>

                <div class="mt-3">
                    <span class="bg-emerald-600 text-white px-3 py-1 rounded-full">
                        ${lugar.categoria}
                    </span>
                </div>

                <p class="mt-5 text-gray-700">
                    ${lugar.descripcion}
                </p>

                <hr class="my-5">

                <div class="space-y-2">

                    <div>🕒 <strong>Horario:</strong> ${lugar.horario}</div>

                    <div>⏳ <strong>Tiempo:</strong> ${lugar.tiempo}</div>

                    <div>🥾 <strong>Dificultad:</strong> ${lugar.dificultad}</div>

                    <div>⭐ <strong>Calificación:</strong> ${lugar.rating}</div>

                </div>

                <a
                    href="https://www.google.com/maps?q=${lugar.lat},${lugar.lng}"
                    target="_blank"
                    class="block mt-6 bg-emerald-600 text-white text-center py-3 rounded-xl">

                    📍 Cómo llegar

                </a>

            `;

        }

    </script>

</div>