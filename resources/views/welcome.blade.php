@extends('layouts.turista')

@section('content')
<!-- HERO PRINCIPAL -->
<section class="relative w-full h-screen overflow-hidden">
    
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
    <div class="relative z-20 flex h-full">

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
        <div class="flex items-center px-10 lg:px-24 w-full">
            <div class="max-w-3xl mt-24">
                 
                <!-- MINI TEXTO -->
                <p class="uppercase tracking-[0.5em] text-[#7ed957] text-sm mb-5">
                    Turismo • Naturaleza • Cultura
                </p>

                <!-- TITULO -->
                <h1 class="text-white text-6xl md:text-8xl font-black uppercase leading-none drop-shadow-2xl">
                    Explora <br>
                    La Candelaria
                </h1>

                <!-- DESCRIPCION -->
                <p class="mt-8 text-lg md:text-xl text-gray-200 leading-relaxed max-w-2xl">
                    Descubre destinos únicos, reserva experiencias inolvidables
                    y vive la magia turística de La Candelaria desde un solo lugar.
                </p>

                <!-- BOTONES -->
                <div class="flex flex-wrap gap-5 mt-10">
                    <a href="{{ route('turista.servicios.index') }}"
                    class="px-8 py-4 bg-[#0b8a0f] hover:bg-[#276a25] text-white rounded-full text-sm uppercase tracking-[0.3em] transition duration-300 shadow-2xl">
                        Explorar
                    </a>
                    <a href="{{ route('turista.servicios.index') }}"
                    class="px-8 py-4 border border-white/40 hover:bg-white hover:text-black text-white rounded-full text-sm uppercase tracking-[0.3em] transition duration-300 backdrop-blur-md">
                        Reservar Ahora
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SOCIAL BAR -->
    <div class="absolute bottom-0 right-0 z-30">
        <div class="flex items-center gap-8 bg-black/50 backdrop-blur-md px-10 py-5 border-t border-l border-white/10 rounded-tl-3xl">
            <span class="text-white/60 uppercase tracking-[0.3em] text-xs">
                Síguenos
            </span>
            <a href="https://www.facebook.com/parroquia.lacandelaria.5" class="text-white hover:text-[#7ed957] transition text-lg">
                Facebook
            </a>
            <a href="" class="text-white hover:text-[#7ed957] transition text-lg">
                Instagram
            </a>
            <a href="https://www.tiktok.com/@gadlacandelaria" class="text-white hover:text-[#7ed957] transition text-lg">
                TikTok
            </a>
        </div>
    </div>

</section>
@endsection