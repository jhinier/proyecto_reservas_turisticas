```blade
@extends('layouts.turista')

@section('content')
@if (isset($status))
    <div class="fixed left-1/2 top-6 z-50 w-[calc(100%-2rem)] max-w-xl -translate-x-1/2 rounded-lg bg-green-600 px-6 py-4 text-center text-white shadow-2xl">
        {{ $status }}
    </div>
@endif

<!-- HERO PRINCIPAL -->
<section class="relative w-full min-h-screen overflow-hidden">
    
    <!-- IMAGEN FONDO -->
    <div class="absolute inset-0">
        <img 
            src="{{ asset('img/fondo4.png') }}"
            class="w-full h-full object-cover"
            alt="Explora Candelaria"
        >

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-black/20"></div>
    </div>

    <!-- CONTENIDO -->
    <div class="relative z-20 flex min-h-screen">

        <!-- SIDEBAR -->
        <div class="hidden lg:flex w-28 bg-black/40 backdrop-blur-md flex-col items-center justify-between py-10 border-r border-white/10">

            <!-- LOGO -->
            <div class="flex flex-col items-center"></div>

            <!-- TEXTO -->
            <div class="rotate-[-90deg] whitespace-nowrap text-white/50 tracking-[0.4em] text-xs uppercase">
                Descubre · Reserva · Vive experiencias
            </div>

            <!-- BOTON -->
            <button class="w-14 h-14 rounded-full bg-[#0b8a0f] hover:bg-[#276a25] transition flex items-center justify-center text-white text-2xl shadow-2xl">
                ↓
            </button>

        </div>

        <!-- TEXTO PRINCIPAL -->
        <div class="flex items-center w-full px-4 sm:px-6 md:px-10 lg:px-24 py-24 sm:py-28 lg:py-0">

            <div class="max-w-3xl mt-12 sm:mt-16 lg:mt-24">
                 
                <!-- MINI TEXTO -->
                <p class="uppercase tracking-[0.2em] sm:tracking-[0.5em] text-[#7ed957] text-[10px] sm:text-sm mb-4 sm:mb-5">
                    Turismo • Naturaleza • Cultura
                </p>

                <!-- TITULO -->
                <h1 class="text-white text-4xl sm:text-5xl md:text-6xl lg:text-8xl font-black uppercase leading-[0.95] drop-shadow-2xl">
                    Explora <br>
                    La Candelaria
                </h1>

                <!-- DESCRIPCION -->
                <p class="mt-5 sm:mt-8 text-base sm:text-lg md:text-xl text-gray-200 leading-relaxed max-w-xl lg:max-w-2xl">
                    Descubre destinos únicos, reserva experiencias inolvidables
                    y vive la magia turística de La Candelaria desde un solo lugar.
                </p>

                <!-- BOTONES -->
                <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row sm:flex-wrap gap-4 sm:gap-5">

                    <!-- BOTÓN EXPLORAR MAPA -->
                    <a
                        href="{{ route('turista.mapa') }}"
                        class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-[#0b8a0f] hover:bg-[#276a25] text-white rounded-full text-[11px] sm:text-sm uppercase tracking-[0.2em] sm:tracking-[0.3em] transition duration-300 shadow-2xl w-full sm:w-auto"
                    >
                        🗺️ Explorar Mapa
                    </a>


                    <!-- BOTÓN HORARIOS DE BUSES -->
                    <button
                        type="button"
                        onclick="abrirModalBuses()"
                        class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white/15 hover:bg-white/25 backdrop-blur-md border border-white/30 text-white rounded-full text-[11px] sm:text-sm uppercase tracking-[0.2em] sm:tracking-[0.3em] transition duration-300 shadow-2xl w-full sm:w-auto"
                    >
                        🚌 Horarios buses
                    </button>

                </div>

            </div>

        </div>
    </div>

    <!-- SOCIAL BAR -->
    <div class="absolute bottom-0 left-0 right-0 z-30 sm:left-auto sm:right-0">

        <div class="flex w-full flex-col items-center justify-center gap-3 bg-black/50 backdrop-blur-md border-t border-white/10 px-4 py-4 sm:w-auto sm:flex-row sm:justify-end sm:gap-8 sm:rounded-tl-3xl sm:border-l sm:border-t sm:px-10 sm:py-5">

            <span class="text-white/60 uppercase tracking-[0.2em] sm:tracking-[0.3em] text-[10px] sm:text-xs">
                Síguenos
            </span>

            <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-8">

                <a
                    href="https://www.facebook.com/parroquia.lacandelaria.5"
                    class="text-white hover:text-[#7ed957] transition text-sm sm:text-lg"
                >
                    Facebook
                </a>

                <a
                    href=""
                    class="text-white hover:text-[#7ed957] transition text-sm sm:text-lg"
                >
                    Instagram
                </a>

                <a
                    href="https://www.tiktok.com/@gadlacandelaria"
                    class="text-white hover:text-[#7ed957] transition text-sm sm:text-lg"
                >
                    TikTok
                </a>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     MODAL HORARIOS DE BUSES
========================================================= --}}

<div
    id="modalBuses"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 px-4 backdrop-blur-sm"
    onclick="cerrarModalBuses(event)"
>

    <div
        class="relative w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl"
        onclick="event.stopPropagation()"
    >

        {{-- ENCABEZADO --}}
        <div class="bg-[#0b8a0f] px-6 py-5 sm:px-8">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <h2 class="text-xl sm:text-2xl font-bold text-white">
                        🚌 Horarios de buses
                    </h2>

                    <p class="mt-1 text-sm text-white/80">
                        Transporte entre Riobamba y La Candelaria
                    </p>

                </div>

                <button
                    type="button"
                    onclick="cerrarModalBuses()"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white/15 text-xl text-white transition hover:bg-white/25"
                    aria-label="Cerrar"
                >
                    ✕
                </button>

            </div>

        </div>


        {{-- CONTENIDO --}}
        <div class="max-h-[70vh] overflow-y-auto p-5 sm:p-8">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- RIOBAMBA → CANDELARIA --}}
                <div class="overflow-hidden rounded-2xl border border-emerald-100 bg-emerald-50">

                    <div class="bg-emerald-100 px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
                                🚌
                            </div>

                            <div>

                                <h3 class="font-bold text-emerald-800">
                                    Riobamba → La Candelaria
                                </h3>

                                <p class="text-xs text-emerald-600">
                                    Horarios de salida
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="space-y-2 p-4">

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-emerald-700">
                                06:30
                            </span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-emerald-700">
                                10:30
                            </span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-emerald-700">
                                12:30
                            </span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-emerald-700">
                                15:30
                            </span>
                        </div>

                    </div>

                </div>


                {{-- CANDELARIA → RIOBAMBA --}}
                <div class="overflow-hidden rounded-2xl border border-green-100 bg-green-50">

                    <div class="bg-green-100 px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
                                🚌
                            </div>

                            <div>

                                <h3 class="font-bold text-green-800">
                                    La Candelaria → Riobamba
                                </h3>

                                <p class="text-xs text-green-600">
                                    Horarios de regreso
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="space-y-2 p-4">

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-green-700">
                                06:30
                            </span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-green-700">
                                08:30
                            </span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-green-700">
                                14:30
                            </span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm">
                            <span class="text-sm text-gray-600">
                                Salida
                            </span>
                            <span class="font-bold text-green-700">
                                17:00
                            </span>
                        </div>

                    </div>

                </div>

            </div>


            {{-- NOTA --}}
            <div class="mt-5 rounded-2xl bg-gray-50 px-5 py-4 text-center">

                <p class="text-xs leading-relaxed text-gray-500">
                    🕐 Horarios informativos de transporte entre
                    Riobamba y La Candelaria.
                </p>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT MODAL
========================================================= --}}

<script>

    function abrirModalBuses() {

        const modal =
            document.getElementById('modalBuses');

        modal.classList.remove('hidden');

        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

    }


    function cerrarModalBuses(event) {

        if (
            event &&
            event.target !== event.currentTarget
        ) {
            return;
        }

        const modal =
            document.getElementById('modalBuses');

        modal.classList.add('hidden');

        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'Escape') {

                cerrarModalBuses();

            }

        }
    );

</script>

@endsection
