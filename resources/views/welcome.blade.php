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

        <!-- TEXO PRINCIPAL -->
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
                    <a href="{{ route('turista.mapa') }}"
                       class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-[#0b8a0f] hover:bg-[#276a25] text-white rounded-full text-[11px] sm:text-sm uppercase tracking-[0.2em] sm:tracking-[0.3em] transition duration-300 shadow-2xl w-full sm:w-auto">
                        🗺️ Explorar Mapa
                    </a>
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
                <a href="https://www.facebook.com/parroquia.lacandelaria.5" class="text-white hover:text-[#7ed957] transition text-sm sm:text-lg">
                    Facebook
                </a>
                <a href="" class="text-white hover:text-[#7ed957] transition text-sm sm:text-lg">
                    Instagram
                </a>
                <a href="https://www.tiktok.com/@gadlacandelaria" class="text-white hover:text-[#7ed957] transition text-sm sm:text-lg">
                    TikTok
                </a>
            </div>
        </div>
    </div>

</section>
@endsection