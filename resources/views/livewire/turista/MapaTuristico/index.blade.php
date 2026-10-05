<div
    wire:ignore
    id="contenedorMapaTuristico"
>

    {{-- =========================================================
         LEAFLET CSS
    ========================================================== --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >


    <style>

        /* =====================================================
           CONTENEDOR GENERAL
        ====================================================== */

        #mapaTuristicoWrapper {
            position: relative;
        }

<<<<<<< HEAD:resources/views/livewire/Turista/MapaTuristico/index.blade.php

        /* =====================================================
           MAPA
        ====================================================== */

        #map {

            height: 700px;

            width: 100%;

            border-radius: 22px;

            overflow: hidden;

            border: 1px solid #e5e7eb;

            box-shadow:
                0 12px 35px rgba(0, 0, 0, 0.14);

            background: #e5e7eb;

        }


        /* =====================================================
           MARCADORES
        ====================================================== */

        .marker-turistico {

            width: 46px;

            height: 46px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: white;

            border: 3px solid #16a34a;

            font-size: 23px;

            box-shadow:
                0 5px 14px rgba(0, 0, 0, .32);

            transition:
                transform .2s ease,
                box-shadow .2s ease;

        }


        .marker-turistico:hover {

            transform:
                scale(1.18)
                translateY(-3px);

            box-shadow:
                0 8px 20px rgba(0, 0, 0, .38);

        }
        /* =====================================================
           NOMBRE DE LOS LUGARES EN EL MAPA
        ====================================================== */

            .nombre-lugar-mapa {
                background: white !important;
                border: none !important;
                border-radius: 8px !important;
                padding: 5px 9px !important;
                color: #166534 !important;
                font-size: 12px !important;
                font-weight: 700 !important;
                box-shadow: 0 3px 10px rgba(0, 0, 0, .20) !important;
                white-space: nowrap;
            }

            /* Quitar la flechita predeterminada */
            .nombre-lugar-mapa::before {
                display: none !important;
            }


        /* =====================================================
           BUSCADOR
        ====================================================== */

        .buscador-mapa {

            position: absolute;

            z-index: 1000;

            top: 15px;

            left: 15px;

            width: 300px;

        }


        .buscador-mapa input {

            width: 100%;

            height: 46px;

            padding:
                0 15px 0 43px;

            border:

                1px solid #d1d5db;

            border-radius: 14px;

            background: white;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, .18);

            outline: none;

            font-size: 14px;

        }


        .buscador-mapa input:focus {

            border-color: #16a34a;

            box-shadow:
                0 0 0 3px rgba(34,197,94,.15),
                0 5px 18px rgba(0,0,0,.18);

        }


        .icono-busqueda {

            position: absolute;

            left: 15px;

            top: 12px;

            font-size: 18px;

            pointer-events: none;

        }


        /* =====================================================
           RESULTADOS BUSQUEDA
        ====================================================== */

        #resultadosBusqueda {

            display: none;

            margin-top: 7px;

            background: white;

            border-radius: 14px;

            overflow: hidden;

            box-shadow:
                0 7px 22px rgba(0,0,0,.20);

            max-height: 280px;

            overflow-y: auto;

        }


        .resultado-busqueda {

            padding: 11px 14px;

            cursor: pointer;

            border-bottom:
                1px solid #f3f4f6;

        }


        .resultado-busqueda:hover {

            background: #f0fdf4;

        }


        .resultado-nombre {

            font-weight: 700;

            color: #166534;

        }


        .resultado-categoria {

            font-size: 11px;

            color: #6b7280;

            margin-top: 2px;

        }


        /* =====================================================
           FILTROS
        ====================================================== */

        .filtros-mapa {

            position: absolute;

            z-index: 999;

            left: 15px;

            bottom: 15px;

            display: flex;

            flex-wrap: wrap;

            gap: 7px;

            max-width: calc(100% - 30px);

        }


        .filtro-btn {

            border: none;

            background: white;

            color: #374151;

            padding:
                8px 12px;

            border-radius: 999px;

            font-size: 12px;

            font-weight: 600;

            cursor: pointer;

            box-shadow:
                0 4px 12px rgba(0,0,0,.18);

            transition: .2s;

        }


        .filtro-btn:hover {

            transform:
                translateY(-2px);

        }


        .filtro-btn.activo {

            background: #15803d;

            color: white;

        }


        /* =====================================================
           LEYENDA
        ====================================================== */

        .leyenda-mapa {

            background: white;

            padding: 13px 16px;

            border-radius: 15px;

            box-shadow:
                0 5px 18px rgba(0,0,0,.18);

            font-size: 12px;

            line-height: 1.8;

        }


        .leyenda-titulo {

            color: #166534;

            font-weight: 800;

            margin-bottom: 4px;

        }


        /* =====================================================
           CONTROL CAPAS
        ====================================================== */

        .leaflet-control-layers {

            border: none !important;

            border-radius: 14px !important;

            padding: 7px !important;

            box-shadow:
                0 5px 18px rgba(0,0,0,.18) !important;

        }


        .leaflet-control-layers label {

            padding: 5px;

            font-size: 13px;

        }


        /* =====================================================
           BOTÓN CENTRAR
        ====================================================== */

        .btn-mapa {

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: white;

            border-radius: 12px;

            cursor: pointer;

            box-shadow:
                0 4px 12px rgba(0,0,0,.20);

            font-size: 19px;

            transition: .2s;

        }


        .btn-mapa:hover {

            transform: scale(1.08);

            background: #f0fdf4;

        }


        /* =====================================================
           POPUP
        ====================================================== */

        .popup-turistico {

            width: 235px;

        }


        .popup-turistico img {

            width: 100%;

            height: 125px;

            object-fit: cover;

            border-radius: 11px;

            margin-bottom: 8px;

        }


        .popup-turistico h3 {

            margin: 0;

            font-size: 17px;

            font-weight: 800;

            color: #166534;

        }


        .popup-categoria {

            display: inline-block;

            margin-top: 5px;

            padding:
                3px 9px;

            border-radius: 999px;

            background: #dcfce7;

            color: #166534;

            font-size: 11px;

            font-weight: 700;

        }


        /* =====================================================
           GALERÍA
        ====================================================== */

        .galeria-mapa {

            position: relative;

            height: 250px;

            overflow: hidden;

            border-radius: 16px;

            background: #f0fdf4;

        }


        .galeria-mapa img {

            width: 100%;

            height: 100%;

            object-fit: cover;

        }


        .btn-galeria {

            position: absolute;

            top: 50%;

            transform: translateY(-50%);

            width: 36px;

            height: 36px;

            border: none;

            border-radius: 50%;

            background: rgba(255,255,255,.92);

            box-shadow:
                0 3px 10px rgba(0,0,0,.2);

            cursor: pointer;

            font-size: 17px;

        }


        .btn-galeria:hover {

            background: white;

        }


        .btn-anterior {

            left: 10px;

        }


        .btn-siguiente {

            right: 10px;

        }


        .contador-galeria {

            position: absolute;

            right: 10px;

            bottom: 10px;

            padding:
                4px 9px;

            border-radius: 999px;

            background:
                rgba(0,0,0,.55);

            color: white;

            font-size: 11px;

        }


        /* =====================================================
           ESTRELLAS
        ====================================================== */

        .estrellas {

            color: #f59e0b;

            letter-spacing: 2px;

            font-size: 18px;

        }


        /* =====================================================
           BOTONES PANEL
        ====================================================== */

        .btn-principal {

            display: block;

            width: 100%;

            padding: 12px;

            border-radius: 12px;

            text-align: center;

            font-weight: 700;

            color: white;

            background: #16a34a;

            transition: .2s;

        }


        .btn-principal:hover {

            background: #15803d;

            transform:
                translateY(-1px);

        }


        .btn-secundario {

            display: block;

            width: 100%;

            padding: 12px;

            border-radius: 12px;

            text-align: center;

            font-weight: 700;

            color: #166534;

            background: #dcfce7;

            transition: .2s;

        }


        .btn-secundario:hover {

            background: #bbf7d0;

        }


        /* =====================================================
           PANEL INFORMACIÓN
        ====================================================== */

        .dato-lugar {

            display: flex;

            gap: 12px;

            align-items: flex-start;

        }


        .dato-icono {

            width: 38px;

            height: 38px;

            min-width: 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 11px;

            background: #f0fdf4;

            font-size: 18px;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1024px) {

            .buscador-mapa {

                width: 250px;

            }

        }


        @media (max-width: 640px) {

            #map {

                height: 550px;

                border-radius: 15px;

            }


            .buscador-mapa {

                width: calc(100% - 30px);

            }


            .filtros-mapa {

                bottom: 10px;

            }


            .filtro-btn {

                padding:
                    7px 9px;

            }

        }

=======
        .dark #map {
            box-shadow: 0 18px 45px rgba(0,0,0,.45);
        }

        .dark .leaflet-control-layers,
        .dark .leaflet-popup-content-wrapper,
        .dark .leaflet-popup-tip {
            background: #18181b;
            color: #e5e7eb;
        }
>>>>>>> origin/Rama_jhinier:resources/views/livewire/turista/MapaTuristico/index.blade.php
    </style>


    {{-- =========================================================
         CONTENIDO PRINCIPAL
    ========================================================== --}}

    <div class="mx-auto max-w-7xl p-4 sm:p-6">


        {{-- =====================================================
             CABECERA
        ====================================================== --}}

        <div class="mb-6">
<<<<<<< HEAD:resources/views/livewire/Turista/MapaTuristico/index.blade.php

            <div class="flex items-center gap-3">
=======
            <h1 class="text-3xl font-bold text-emerald-700 dark:text-emerald-300">
                🗺️ Mapa Turístico de La Candelaria
            </h1>

            <p class="text-gray-500 mt-2 dark:text-slate-300">
                Explora los atractivos turísticos de manera interactiva.
            </p>
        </div>
>>>>>>> origin/Rama_jhinier:resources/views/livewire/turista/MapaTuristico/index.blade.php

                <div
                    class="
                        flex
                        h-12
                        w-12
                        items-center
                        justify-center
                        rounded-2xl
                        bg-emerald-100
                        text-2xl
                    "
                >
                    🗺️
                </div>

                <div>

                    <h1
                        class="
                            text-2xl
                            font-bold
                            text-emerald-700
                            sm:text-3xl
                        "
                    >
                        Mapa Turístico de La Candelaria
                    </h1>

                    <p class="mt-1 text-sm text-gray-500 sm:text-base">

                        Explora, descubre y vive los atractivos turísticos
                        de nuestra parroquia.

                    </p>

                </div>

            </div>

        </div>

<<<<<<< HEAD:resources/views/livewire/Turista/MapaTuristico/index.blade.php
=======
                <div id="panelLugar"
                     class="bg-white rounded-2xl shadow-lg h-[700px] p-6 overflow-y-auto dark:border dark:border-white/10 dark:bg-zinc-900">
>>>>>>> origin/Rama_jhinier:resources/views/livewire/turista/MapaTuristico/index.blade.php

        {{-- =====================================================
             MAPA + PANEL
        ====================================================== --}}

        <div class="grid grid-cols-12 gap-6">


            {{-- =================================================
                 MAPA
            ================================================== --}}

            <div
                class="
                    col-span-12
                    lg:col-span-8
                "
            >

                <div
                    id="mapaTuristicoWrapper"
                >


                    {{-- =========================================
                         BUSCADOR
                    ========================================== --}}

                    <div class="buscador-mapa">

                        <span class="icono-busqueda">
                            🔎
                        </span>

                        <input
                            id="buscadorLugar"
                            type="text"
                            placeholder="Buscar atractivo turístico..."
                            autocomplete="off"
                        >

                        <div
                            id="resultadosBusqueda"
                        ></div>

                    </div>


                    {{-- =========================================
                         MAPA
                    ========================================== --}}

                    <div id="map"></div>


                    {{-- =========================================
                         FILTROS
                    ========================================== --}}

                    <div
                        id="filtrosMapa"
                        class="filtros-mapa"
                    >

                        <button
                            class="filtro-btn activo"
                            data-categoria="todos"
                        >
                            🌎 Todos
                        </button>

                        <button
                            class="filtro-btn"
                            data-categoria="naturaleza"
                        >
                            🌿 Naturaleza
                        </button>

                        <button
                            class="filtro-btn"
                            data-categoria="hospedaje"
                        >
                            🏨 Hospedaje
                        </button>

                        <button
                            class="filtro-btn"
                            data-categoria="festividad"
                        >
                            🎉 Festividades
                        </button>

                        <button
                            class="filtro-btn"
                            data-categoria="gastronomia"
                        >
                            🍽️ Gastronomía
                        </button>

                        <button
                            class="filtro-btn"
                            data-categoria="actividad"
                        >
                            🚶 Actividades
                        </button>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 PANEL
            ================================================== --}}

            <div
                class="
                    col-span-12
                    lg:col-span-4
                "
            >

                <div
                    id="panelLugar"
                    class="
                        h-[700px]
                        overflow-y-auto
                        rounded-2xl
                        bg-white
                        p-6
                        shadow-lg
                    "
                >

                    <div
                        class="
                            flex
                            h-full
                            flex-col
                            items-center
                            justify-center
                            text-center
                        "
                    >

                        <div
                            class="
                                mb-5
                                flex
                                h-24
                                w-24
                                items-center
                                justify-center
                                rounded-full
                                bg-emerald-50
                                text-5xl
                            "
                        >
                            🧭
                        </div>

<<<<<<< HEAD:resources/views/livewire/Turista/MapaTuristico/index.blade.php

                        <h2
                            class="
                                text-2xl
                                font-bold
                                text-gray-700
                            "
                        >
                            Explora La Candelaria
                        </h2>

=======
                        <h2 class="text-2xl font-bold text-gray-700 dark:text-white">
                            Explora el mapa
                        </h2>

                        <p class="text-gray-500 mt-4 dark:text-slate-300">

                            Haz clic sobre cualquier marcador para visualizar toda la información del atractivo turístico.
>>>>>>> origin/Rama_jhinier:resources/views/livewire/turista/MapaTuristico/index.blade.php

                        <p
                            class="
                                mt-4
                                max-w-sm
                                text-gray-500
                            "
                        >
                            Selecciona un marcador para descubrir
                            información, fotografías y detalles
                            del atractivo turístico.
                        </p>


                        <div
                            class="
                                mt-6
                                rounded-xl
                                bg-emerald-50
                                px-5
                                py-4
                                text-sm
                                text-emerald-700
                            "
                        >

                            📍 Descubre los lugares turísticos

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         LEAFLET JS
    ========================================================== --}}

    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    ></script>


    <script>

        /* =====================================================
           VARIABLES GLOBALES
        ====================================================== */

        let mapaTuristico = null;

        let lugaresTuristicos = [];

        let marcadoresTuristicos = [];

        let limiteCandelaria = null;

        let boundsCandelaria = null;

        let imagenActual = 0;

        let lugarGaleriaActual = null;


        /* =====================================================
           INICIALIZAR
        ====================================================== */

        function iniciarMapaTuristico() {


            /*
             * Si ya existe el mapa, no lo volvemos a crear.
             */

            if (mapaTuristico) {

                return;

            }


            /* =================================================
               CARGAR LUGARES DESDE LARAVEL
            ================================================== */

            lugaresTuristicos = @json($lugares);


            /* =================================================
               CREAR MAPA
            ================================================== */

            mapaTuristico = L.map(

                'map',

                {

                    zoomControl: false,

                    worldCopyJump: false,

                    minZoom: 11,

                    maxZoom: 18,

                    attributionControl: true

                }

            );


            /* =================================================
               ZOOM
            ================================================== */

            L.control.zoom({

                position: 'topright'

            }).addTo(mapaTuristico);


            /* =================================================
               CAPAS BASE
            ================================================== */

            const cartoVoyager = L.tileLayer(

                'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png',

                {

                    attribution:
                        '&copy; OpenStreetMap &copy; CARTO',

                    maxZoom: 20

                }

            );


            const satelite = L.tileLayer(

                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',

                {

                    attribution:
                        'Tiles &copy; Esri',

                    maxZoom: 19

                }

            );


            const topografico = L.tileLayer(

                'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',

                {

                    attribution:
                        '&copy; OpenTopoMap',

                    maxZoom: 17

                }

            );


            /* =================================================
               VOYAGER POR DEFECTO
            ================================================== */

            cartoVoyager.addTo(
                mapaTuristico
            );


            /* =================================================
               CONTROL DE CAPAS
            ================================================== */

            L.control.layers(

                {

                    "🗺️ Mapa turístico":
                        cartoVoyager,

                    "🛰️ Satélite":
                        satelite,

                    "⛰️ Topográfico":
                        topografico

                },

                null,

                {

                    collapsed: true,

                    position: 'topright'

                }

            ).addTo(mapaTuristico);


            /* =================================================
               GEOJSON
            ================================================== */

            cargarLimiteCandelaria();


            /* =================================================
               CREAR MARCADORES
            ================================================== */

            crearMarcadores();


            /* =================================================
               BUSCADOR
            ================================================== */

            configurarBuscador();


            /* =================================================
               FILTROS
            ================================================== */

            configurarFiltros();

        }


        /* =====================================================
           CARGAR LÍMITE DE LA CANDELARIA
        ====================================================== */

        function cargarLimiteCandelaria() {


            fetch(
                '/geojson/la-candelaria.geojson'
            )

            .then(response => {

                if (!response.ok) {

                    throw new Error(
                        'No se pudo cargar el GeoJSON'
                    );

                }

                return response.json();

            })

            .then(data => {


                /* =============================================
                   CAPA GEOJSON
                ============================================== */

                limiteCandelaria = L.geoJSON(

                    data,

                    {

                        style: {

                            color: '#15803d',

                            weight: 4,

                            opacity: .95,

                            fillColor: '#22c55e',

                            fillOpacity: .10,

                            lineJoin: 'round'

                        },


                        onEachFeature:
                            function(feature, layer) {


                                layer.bindTooltip(

                                    '📍 Parroquia La Candelaria',

                                    {

                                        sticky: true,

                                        direction: 'top'

                                    }

                                );


                                layer.on({

                                    mouseover:
                                        function(e) {

                                            e.target.setStyle({

                                                weight: 5,

                                                color: '#166534',

                                                fillOpacity: .17

                                            });

                                        },


                                    mouseout:
                                        function(e) {

                                            limiteCandelaria
                                                .resetStyle(
                                                    e.target
                                                );

                                        }

                                });

                            }

                    }

                ).addTo(

                    mapaTuristico

                );


                /* =============================================
                   BOUNDS
                ============================================== */

                boundsCandelaria =
                    limiteCandelaria.getBounds();


                mapaTuristico.fitBounds(

                    boundsCandelaria,

                    {

                        padding: [25, 25]

                    }

                );


                /* =============================================
                   RESTRINGIR MAPA
                ============================================== */

                mapaTuristico.setMaxBounds(

                    boundsCandelaria.pad(.12)

                );


                mapaTuristico.options.maxBoundsViscosity =
                    1.0;


                /* =============================================
                   BOTÓN CENTRAR
                ============================================== */

                agregarBotonCentrar();


                /* =============================================
                   LEYENDA
                ============================================== */

                agregarLeyenda();


            })

            .catch(error => {

                console.error(
                    'Error cargando GeoJSON:',
                    error
                );

            });

        }


        /* =====================================================
           CREAR MARCADORES
        ====================================================== */

        function crearMarcadores() {


            lugaresTuristicos.forEach(

                function(lugar, index) {


                    const lat =
                        parseFloat(lugar.lat);

                    const lng =
                        parseFloat(lugar.lng);


                    /*
                     * Validar coordenadas
                     */

                    if (
                        isNaN(lat) ||
                        isNaN(lng)
                    ) {

                        return;

                    }


                    /*
                     * Emoji
                     */

                    const emoji =
                        obtenerEmoji(lugar);


                    /*
                     * Icono
                     */

                    const icono =
                        L.divIcon({

                            className: '',

                            html: `

                                <div
                                    class="marker-turistico"
                                    title="${lugar.nombre}"
                                >
                                    ${emoji}
                                </div>

                            `,

                            iconSize:
                                [46, 46],

                            iconAnchor:
                                [23, 46],

                            popupAnchor:
                                [0, -46]

                        });


                    /*
                     * Marcador
                     */

                    const marcador =
                        L.marker(

                            [lat, lng],

                            {

                                icon:
                                    icono,

                                title:
                                    lugar.nombre

                            }

                        ).addTo(
                            mapaTuristico
                        );


                         /*
                          * Nombre visible permanentemente
                          */

                         marcador.bindTooltip(

                             lugar.nombre,

                             {

                                 permanent: true,

                                 direction: 'top',

                                 offset: [0, -42],

                                 className: 'nombre-lugar-mapa'

                             }

                         );

                    /*
                     * Guardar referencia
                     */

                    marcadoresTuristicos.push({

                        marcador:
                            marcador,

                        lugar:
                            lugar,

                        index:
                            index

                    });


                    /*
                     * Popup
                     */

                    marcador.bindPopup(

                        crearPopup(lugar),

                        {

                            maxWidth:
                                280,

                            className:
                                'popup-lugar'

                        }

                    );


                    /*
                     * Click
                     */

                    marcador.on(

                        'click',

                        function() {

                            mostrarLugar(
                                lugar
                            );

                        }

                    );

                }

            );

        }


        /* =====================================================
           OBTENER EMOJI
        ====================================================== */

        function obtenerEmoji(lugar) {


            const categoria =
                String(
                    lugar.categoria || ''
                ).toLowerCase();


            const icono =
                String(
                    lugar.icono || ''
                ).toLowerCase();


            if (

                icono === 'hotel' ||

                categoria.includes('hospedaje') ||

                categoria.includes('hotel')

            ) {

                return '🏨';

            }


            if (
                categoria.includes('naturaleza')
            ) {

                return '🌿';

            }


            if (
                categoria.includes('festiv')
            ) {

                return '🎉';

            }


            if (
                categoria.includes('gastr')
            ) {

                return '🍽️';

            }


            if (
                categoria.includes('actividad')
            ) {

                return '🚶';

            }


            if (
                categoria.includes('sitio')
            ) {

                return '🏞️';

            }
            if (icono === 'cooperativa') {
               return '🏢';
}              


            return '📍';

        }


        /* =====================================================
           CREAR POPUP
        ====================================================== */

        function crearPopup(lugar) {


            const imagen =

                lugar.imagenes &&
                lugar.imagenes.length

                    ? lugar.imagenes[0]

                    : null;


            return `

                <div
                    class="popup-turistico"
                >

                    ${
                        imagen

                        ? `

                            <img
                                src="${imagen}"
                                alt="${lugar.nombre}"
                            >

                          `

                        : ''
                    }


                    <h3>
                        ${lugar.nombre}
                    </h3>


                    <span
                        class="popup-categoria"
                    >
                        ${
                            lugar.categoria ||
                            'Lugar turístico'
                        }
                    </span>


                    <p
                        style="
                            margin-top:8px;
                            font-size:12px;
                            color:#6b7280;
                        "
                    >
                        Haz clic para ver
                        toda la información.
                    </p>

                </div>

            `;

        }


        /* =====================================================
           BUSCADOR
        ====================================================== */

        function configurarBuscador() {


            const input =
                document.getElementById(
                    'buscadorLugar'
                );


            const resultados =
                document.getElementById(
                    'resultadosBusqueda'
                );


            input.addEventListener(

                'input',

                function() {


                    const texto =
                        this.value
                            .trim()
                            .toLowerCase();


                    resultados.innerHTML = '';


                    if (!texto) {

                        resultados.style.display =
                            'none';

                        return;

                    }


                    const encontrados =
                        lugaresTuristicos.filter(

                            lugar =>

                                String(
                                    lugar.nombre || ''
                                )
                                .toLowerCase()
                                .includes(texto)

                                ||

                                String(
                                    lugar.categoria || ''
                                )
                                .toLowerCase()
                                .includes(texto)

                        );


                    if (!encontrados.length) {

                        resultados.innerHTML = `

                            <div
                                class="
                                    p-4
                                    text-center
                                    text-sm
                                    text-gray-500
                                "
                            >
                                😕 No encontramos
                                ese atractivo.
                            </div>

                        `;

                        resultados.style.display =
                            'block';

                        return;

                    }


                    encontrados.forEach(

                        function(lugar) {


                            const div =
                                document.createElement(
                                    'div'
                                );


                            div.className =
                                'resultado-busqueda';


                            div.innerHTML = `

                                <div
                                    class="resultado-nombre"
                                >
                                    ${obtenerEmoji(lugar)}
                                    ${lugar.nombre}
                                </div>

                                <div
                                    class="resultado-categoria"
                                >
                                    ${
                                        lugar.categoria ||
                                        'Turismo'
                                    }
                                </div>

                            `;


                            div.addEventListener(

                                'click',

                                function() {

                                    seleccionarLugar(
                                        lugar
                                    );

                                    resultados.style.display =
                                        'none';

                                    input.value =
                                        lugar.nombre;

                                }

                            );


                            resultados.appendChild(
                                div
                            );

                        }

                    );


                    resultados.style.display =
                        'block';

                }

            );


            /*
             * Cerrar resultados al hacer
             * clic fuera.
             */

            document.addEventListener(

                'click',

                function(e) {

                    if (
                        !e.target.closest(
                            '.buscador-mapa'
                        )
                    ) {

                        resultados.style.display =
                            'none';

                    }

                }

            );

        }


        /* =====================================================
           SELECCIONAR LUGAR
        ====================================================== */

        function seleccionarLugar(lugar) {


            const encontrado =
                marcadoresTuristicos.find(

                    item =>
                        item.lugar.nombre ===
                        lugar.nombre

                );


            if (!encontrado) {

                return;

            }


            const lat =
                parseFloat(lugar.lat);

            const lng =
                parseFloat(lugar.lng);


            mapaTuristico.flyTo(

                [lat, lng],

                16,

                {

                    duration: 1.2

                }

            );


            setTimeout(

                function() {

                    encontrado.marcador.openPopup();

                },

                900

            );


            mostrarLugar(lugar);

        }


        /* =====================================================
           FILTROS
        ====================================================== */

        function configurarFiltros() {


            document
                .querySelectorAll(
                    '.filtro-btn'
                )
                .forEach(

                    function(boton) {


                        boton.addEventListener(

                            'click',

                            function() {


                                document
                                    .querySelectorAll(
                                        '.filtro-btn'
                                    )
                                    .forEach(

                                        btn =>
                                            btn.classList.remove(
                                                'activo'
                                            )

                                    );


                                this.classList.add(
                                    'activo'
                                );


                                const categoria =
                                    this.dataset.categoria;


                                filtrarMarcadores(
                                    categoria
                                );

                            }

                        );

                    }

                );

        }


        /* =====================================================
           FILTRAR MARCADORES
        ====================================================== */

        function filtrarMarcadores(
            categoria
        ) {


            marcadoresTuristicos.forEach(

                function(item) {


                    const lugar =
                        item.lugar;


                    const categoriaLugar =
                        String(
                            lugar.categoria || ''
                        ).toLowerCase();


                    let mostrar = true;


                    if (
                        categoria !==
                        'todos'
                    ) {

                        switch (
                            categoria
                        ) {

                            case 'naturaleza':

                                mostrar =
                                    categoriaLugar.includes(
                                        'naturaleza'
                                    );

                                break;


                            case 'hospedaje':

                                mostrar =

                                    categoriaLugar.includes(
                                        'hospedaje'
                                    )

                                    ||

                                    categoriaLugar.includes(
                                        'hotel'
                                    )

                                    ||

                                    String(
                                        lugar.icono || ''
                                    ).toLowerCase()
                                    ===
                                    'hotel';

                                break;


                            case 'festividad':

                                mostrar =
                                    categoriaLugar.includes(
                                        'festiv'
                                    );

                                break;


                            case 'gastronomia':

                                mostrar =
                                    categoriaLugar.includes(
                                        'gastr'
                                    );

                                break;


                            case 'actividad':

                                mostrar =
                                    categoriaLugar.includes(
                                        'actividad'
                                    );

                                break;

                        }

                    }


                    if (mostrar) {

                        if (
                            !mapaTuristico.hasLayer(
                                item.marcador
                            )
                        ) {

                            item.marcador.addTo(
                                mapaTuristico
                            );

                        }

                    }

                    else {

                        if (
                            mapaTuristico.hasLayer(
                                item.marcador
                            )
                        ) {

                            mapaTuristico.removeLayer(
                                item.marcador
                            );

                        }

                    }

                }

            );

        }


        /* =====================================================
           BOTÓN CENTRAR
        ====================================================== */

        function agregarBotonCentrar() {


            const CentroControl =
                L.Control.extend({

                    options: {

                        position:
                            'topleft'

                    },


                    onAdd:
                        function() {


                            const container =
                                L.DomUtil.create(
                                    'div',
                                    'leaflet-bar'
                                );


                            const boton =
                                L.DomUtil.create(
                                    'div',
                                    'btn-mapa',
                                    container
                                );


                            boton.innerHTML =
                                '🎯';


                            boton.title =
                                'Centrar en La Candelaria';


                            L.DomEvent
                                .disableClickPropagation(
                                    container
                                );


                            L.DomEvent.on(

                                boton,

                                'click',

                                function() {

                                    if (
                                        boundsCandelaria
                                    ) {

                                        mapaTuristico.fitBounds(

                                            boundsCandelaria,

                                            {

                                                padding:
                                                    [25, 25]

                                            }

                                        );

                                    }

                                }

                            );


                            return container;

                        }

                });


            mapaTuristico.addControl(

                new CentroControl()

            );

        }


        /* =====================================================
           LEYENDA
        ====================================================== */

        function agregarLeyenda() {


            const leyenda =
                L.control({

                    position:
                        'bottomright'

                });


            leyenda.onAdd =
                function() {


                    const div =
                        L.DomUtil.create(
                            'div',
                            'leyenda-mapa'
                        );


                    div.innerHTML = `

                        <div
                            class="leyenda-titulo"
                        >
                            🗺️ Referencias
                        </div>

                        <div>
                            🌿 Naturaleza
                        </div>

                        <div>
                            🏨 Hospedaje
                        </div>

                        <div>
                            🎉 Festividades
                        </div>

                        <div>
                            🍽️ Gastronomía
                        </div>

                        <div>
                            🚶 Actividades
                        </div>

                    `;


                    return div;

                };


            leyenda.addTo(
                mapaTuristico
            );

        }


        /* =====================================================
           MOSTRAR LUGAR
        ====================================================== */

        function mostrarLugar(lugar) {


            const panel =
                document.getElementById(
                    'panelLugar'
                );


            if (!panel) {

                return;

            }


            imagenActual = 0;

            lugarGaleriaActual =
                lugar;


            const imagenes =

                Array.isArray(
                    lugar.imagenes
                )

                ? lugar.imagenes

                : [];


            const imagenPrincipal =
                imagenes.length

                    ? imagenes[0]

                    : null;


            /* =================================================
               ESTRELLAS
            ================================================== */

            const rating =
                parseFloat(
                    lugar.rating
                ) || 0;


            const estrellasLlenas =
                Math.round(
                    rating
                );


            const estrellas =
                '★'.repeat(
                    estrellasLlenas
                )
                +
                '☆'.repeat(
                    5 - estrellasLlenas
                );


            /* =================================================
               GALERÍA
            ================================================== */

            let galeriaHTML = '';


            if (imagenes.length) {

                galeriaHTML = `

                    <div
                        class="galeria-mapa"
                    >

                        <img
                            id="imagenGaleria"
                            src="${imagenes[0]}"
                            alt="${lugar.nombre}"
                        >


                        ${
                            imagenes.length > 1

                            ? `

                                <button
                                    type="button"
                                    class="
                                        btn-galeria
                                        btn-anterior
                                    "
                                    onclick="
                                        cambiarImagen(-1)
                                    "
                                >
                                    ‹
                                </button>


                                <button
                                    type="button"
                                    class="
                                        btn-galeria
                                        btn-siguiente
                                    "
                                    onclick="
                                        cambiarImagen(1)
                                    "
                                >
                                    ›
                                </button>


                                <div
                                    id="contadorGaleria"
                                    class="
                                        contador-galeria
                                    "
                                >
                                    1 /
                                    ${imagenes.length}
                                </div>

                              `

                            : ''
                        }

                    </div>

                `;

            }

            else {

                galeriaHTML = `

                    <div
                        class="
                            flex
                            h-[250px]
                            items-center
                            justify-center
                            rounded-2xl
                            bg-emerald-50
                            text-7xl
                        "
                    >
                        ${obtenerEmoji(lugar)}
                    </div>

                `;

            }


            /* =================================================
               VIDEO
            ================================================== */

            let videoHTML = '';


            if (lugar.video) {

                videoHTML = `

                    <a
                        href="${lugar.video}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="
                            mt-4
                            block
                            rounded-xl
                            bg-red-50
                            px-4
                            py-3
                            text-center
                            font-semibold
                            text-red-600
                            transition
                            hover:bg-red-100
                        "
                    >

                        ▶️ Ver video turístico

                    </a>

                `;

            }


            /* =================================================
               RESERVA
            ================================================== */

            let reservaHTML = '';


            if (
                lugar.reserva_url ||
                lugar.url_reserva
            ) {

                const urlReserva =
                    lugar.reserva_url ||
                    lugar.url_reserva;


                reservaHTML = `

                    <a
                        href="${urlReserva}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-principal"
                    >

                        📅 Reservar

                    </a>

                `;

            }


            /* =================================================
               PANEL
            ================================================== */

            panel.innerHTML = `


                ${galeriaHTML}


                <div class="mt-5">


                    <div
                        class="
                            flex
                            items-start
                            justify-between
                            gap-3
                        "
                    >

                        <div>

                            <h2
                                class="
                                    text-2xl
                                    font-bold
                                    text-emerald-700
                                "
                            >
                                ${lugar.nombre}
                            </h2>


                            <span
                                class="
                                    mt-2
                                    inline-block
                                    rounded-full
                                    bg-emerald-100
                                    px-3
                                    py-1
                                    text-xs
                                    font-bold
                                    text-emerald-700
                                "
                            >

                                ${
                                    lugar.categoria ||
                                    'Turismo'
                                }

                            </span>

                        </div>


                        <div
                            class="
                                text-right
                            "
                        >

                            <div
                                class="estrellas"
                            >
                                ${estrellas}
                            </div>


                            <div
                                class="
                                    text-xs
                                    text-gray-500
                                "
                            >
                                ${rating || 'Sin'}
                                ${
                                    rating
                                        ? '/5'
                                        : ''
                                }
                            </div>

                        </div>

                    </div>


                    <p
                        class="
                            mt-5
                            leading-relaxed
                            text-gray-700
                        "
                    >

                        ${
                            lugar.descripcion ||
                            'No hay descripción disponible.'
                        }

                    </p>


                    <hr
                        class="my-5"
                    >


                    <div
                        class="space-y-4"
                    >


                        <div
                            class="dato-lugar"
                        >

                            <div
                                class="dato-icono"
                            >
                                🕒
                            </div>

                            <div>

                                <div
                                    class="
                                        font-bold
                                        text-gray-700
                                    "
                                >
                                    Horario
                                </div>

                                <div
                                    class="
                                        text-sm
                                        text-gray-500
                                    "
                                >

                                    ${
                                        lugar.horario ||
                                        'No disponible'
                                    }

                                </div>

                            </div>

                        </div>


                        <div
                            class="dato-lugar"
                        >

                            <div
                                class="dato-icono"
                            >
                                ⏳
                            </div>

                            <div>

                                <div
                                    class="
                                        font-bold
                                        text-gray-700
                                    "
                                >
                                    Tiempo estimado
                                </div>

                                <div
                                    class="
                                        text-sm
                                        text-gray-500
                                    "
                                >

                                    ${
                                        lugar.tiempo ||
                                        'No disponible'
                                    }

                                </div>

                            </div>

                        </div>


                        <div
                            class="dato-lugar"
                        >

                            <div
                                class="dato-icono"
                            >
                                🥾
                            </div>

                            <div>

                                <div
                                    class="
                                        font-bold
                                        text-gray-700
                                    "
                                >
                                    Dificultad
                                </div>

                                <div
                                    class="
                                        text-sm
                                        text-gray-500
                                    "
                                >

                                    ${
                                        lugar.dificultad ||
                                        'No especificada'
                                    }

                                </div>

                            </div>

                        </div>


                        <div
                            class="dato-lugar"
                        >

                            <div
                                class="dato-icono"
                            >
                                📍
                            </div>

                            <div>

                                <div
                                    class="
                                        font-bold
                                        text-gray-700
                                    "
                                >
                                    Ubicación
                                </div>

                                <div
                                    class="
                                        text-sm
                                        text-gray-500
                                    "
                                >

                                    La Candelaria

                                </div>

                            </div>

                        </div>


                    </div>


                    ${videoHTML}


                    <div
                        class="
                            mt-6
                            space-y-3
                        "
                    >

                        ${reservaHTML}


                        <a
                            href="
                                https://www.google.com/maps?q=${lugar.lat},${lugar.lng}
                            "
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-secundario"
                        >

                            📍 Cómo llegar

                        </a>

                    </div>


                </div>

            `;

        }


        /* =====================================================
           CAMBIAR IMAGEN
        ====================================================== */

        function cambiarImagen(direccion) {


            if (
                !lugarGaleriaActual ||
                !Array.isArray(
                    lugarGaleriaActual.imagenes
                )
            ) {

                return;

            }


            const imagenes =
                lugarGaleriaActual.imagenes;


            if (!imagenes.length) {

                return;

            }


            imagenActual += direccion;


            if (
                imagenActual < 0
            ) {

                imagenActual =
                    imagenes.length - 1;

            }


            if (
                imagenActual >=
                imagenes.length
            ) {

                imagenActual = 0;

            }


            const imagen =
                document.getElementById(
                    'imagenGaleria'
                );


            const contador =
                document.getElementById(
                    'contadorGaleria'
                );


            if (imagen) {

                imagen.src =
                    imagenes[imagenActual];

            }


            if (contador) {

                contador.innerHTML =

                    `${imagenActual + 1} /
                     ${imagenes.length}`;

            }

        }


        /* =====================================================
           INICIALIZACIÓN
        ====================================================== */

        document.addEventListener(

            'DOMContentLoaded',

            iniciarMapaTuristico

        );


        /*
         * Compatible con Livewire Navigate.
         */

        document.addEventListener(

            'livewire:navigated',

            function() {

                setTimeout(

                    iniciarMapaTuristico,

                    100

                );

            }

        );

    </script>

</div>
