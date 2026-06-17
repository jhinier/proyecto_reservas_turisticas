<div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
#map{
    height:700px;
    border-radius:15px;
    z-index:1;
}
.modal-bg{
    position:fixed;
    top:0;left:0;right:0;bottom:0;
    background:rgba(0,0,0,.5);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
}
.modal{
    background:white;
    padding:20px;
    border-radius:10px;
    width:350px;
}
</style>

<div class="bg-emerald-700 text-white p-4 rounded-lg mb-4">
    <h2 class="text-xl font-bold">🗺️ Mapa Turístico Interactivo</h2>
</div>

<div id="map"></div>

<!-- MODAL FORM -->
<div class="modal-bg" id="modalForm">
    <div class="modal">
        <h3 class="font-bold mb-2">Nuevo punto turístico</h3>

        <input id="nombre" placeholder="Nombre" class="border p-2 w-full mb-2">
        <textarea id="descripcion" placeholder="Descripción" class="border p-2 w-full mb-2"></textarea>
        <input id="tipo" placeholder="Tipo" class="border p-2 w-full mb-2">
        <input id="imagen" placeholder="URL imagen" class="border p-2 w-full mb-2">

        <button onclick="guardarPunto()" class="bg-green-600 text-white px-3 py-2 w-full">
            Guardar
        </button>

        <button onclick="cerrarModal()" class="bg-gray-400 text-white px-3 py-2 w-full mt-2">
            Cancelar
        </button>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>

<script>
let map;
let lugares = @json($lugares);
let latTemp = null;
let lngTemp = null;

document.addEventListener('DOMContentLoaded', iniciarMapa);

function iniciarMapa(){

    map = L.map('map').setView([-1.651618, -78.4410895], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution:'&copy; OpenStreetMap'
    }).addTo(map);

    let grupo = L.layerGroup().addTo(map);
    let capaLimite = null;

    fetch('/geojson/la-candelaria.geojson')
    .then(r => r.json())
    .then(data => {

        capaLimite = L.geoJSON(data,{
            style:{color:'#15803d',weight:3,fillOpacity:0.1}
        }).addTo(map);

        map.fitBounds(capaLimite.getBounds());
    });

    function render(){
        grupo.clearLayers();

        lugares.forEach(lugar=>{
            L.marker([lugar.lat,lugar.lng])
            .addTo(grupo)
            .bindPopup(`
                <b>${lugar.nombre}</b><br>
                ${lugar.descripcion}
            `);
        });
    }

    render();

    // CLICK EN MAPA
    map.on('click', function(e){

        latTemp = e.latlng.lat;
        lngTemp = e.latlng.lng;

        document.getElementById('modalForm').style.display = 'flex';
    });

    window.cerrarModal = function(){
        document.getElementById('modalForm').style.display = 'none';
    }

    window.guardarPunto = function(){

        $wire.guardarLugar({
            nombre: document.getElementById('nombre').value,
            descripcion: document.getElementById('descripcion').value,
            tipo: document.getElementById('tipo').value,
            imagen: document.getElementById('imagen').value,
            lat: latTemp,
            lng: lngTemp
        });

        cerrarModal();
    }

    Livewire.on('recargarMapa', (event)=>{
        lugares = event.lugares;
        render();
    });
}
</script>
</div>