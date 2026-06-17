@extends('layouts.turista')

@section('content')

<section class="min-h-screen bg-g<section class="min-h-screen bg-gray-100 pb-24 pt-8">

    <div class="max-w-7xl mx-auto px-6 lg:px-10">

        {{-- TITULO --}}
        <div class="mb-16 text-center">

            <p class="uppercase tracking-[0.3em] text-emerald-600 text-sm font-semibold">
                Cultura y Tradición
            </p>

            <h1 class="text-5xl font-black text-slate-800 mt-4">
                Festividades
            </h1>

            <p class="text-slate-500 mt-6 max-w-2xl mx-auto text-lg">
                Descubre eventos, tradiciones y celebraciones culturales
            </p>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($festividades as $festividad)

                <div class="bg-white rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 hover:-translate-y-2 border border-slate-100">

                    {{-- CARRUSEL --}}
                    <div class="relative h-64 overflow-hidden">

                        @if($festividad->publicacion->imagenes->count())

                            <div x-data="{ index: 0 }" class="w-full h-full relative">

                                @foreach($festividad->publicacion->imagenes->take(5) as $i => $img)

                                    <img
                                        x-show="index === {{ $i }}"
                                        x-transition
                                        src="{{ asset('storage/' . $img->imagen) }}"
                                        alt="{{ $festividad->publicacion->nombre }}"
                                        class="absolute inset-0 w-full h-full object-cover transition duration-700">

                                @endforeach

                                {{-- OVERLAY --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

                                {{-- BOTON IZQUIERDO --}}
                                <button
                                    @click="index = (index === 0)
                                        ? {{ $festividad->publicacion->imagenes->take(5)->count() - 1 }}
                                        : index - 1"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-9 h-9 rounded-full backdrop-blur-sm transition z-20">

                                    ‹

                                </button>

                                {{-- BOTON DERECHO --}}
                                <button
                                    @click="index = (index === {{ $festividad->publicacion->imagenes->take(5)->count() - 1 }})
                                        ? 0
                                        : index + 1"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-9 h-9 rounded-full backdrop-blur-sm transition z-20">

                                    ›

                                </button>

                                {{-- INDICADORES --}}
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">

                                    @foreach($festividad->publicacion->imagenes->take(5) as $i => $img)

                                        <div
                                            @click="index = {{ $i }}"
                                            :class="index === {{ $i }}
                                                ? 'bg-white w-6'
                                                : 'bg-white/50 w-2'"
                                            class="h-2 rounded-full transition-all duration-300 cursor-pointer">
                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @else

                            <img
                                src="https://via.placeholder.com/600x400"
                                class="w-full h-full object-cover"
                                alt="Sin imagen">

                        @endif

                    </div>

                    {{-- CONTENIDO --}}
                    <div class="p-8">

                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-4 py-2 rounded-full">
                            Festividad
                        </span>

                        {{-- Nombre --}}
                        <h2 class="text-2xl font-bold text-slate-800 mt-5">
                            {{ $festividad->publicacion->nombre }}
                        </h2>


                        <div class="mt-6 space-y-3">

                            <div class="flex flex-col gap-2 text-sm">

                                <span
                                    class="bg-emerald-50 text-emerald-700 px-4 py-2 rounded-xl font-semibold">

                                    📅 Inicio:
                                    {{ \Carbon\Carbon::parse($festividad->fecha_inicio)->format('d/m/Y') }}

                                </span>

                                <span
                                    class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-semibold">

                                    🏁 Fin:
                                    {{ \Carbon\Carbon::parse($festividad->fecha_fin)->format('d/m/Y') }}

                                </span>

                            </div>

                            <a
                                href="{{ route('turista.festividad.detalle', $festividad->publicacion_id) }}"
                                class="mt-6 inline-flex items-center justify-center w-full
                                       bg-emerald-600 text-white py-3 rounded-2xl font-semibold
                                       shadow-lg
                                       hover:bg-emerald-700
                                       hover:scale-105
                                       hover:shadow-2xl
                                       active:scale-95
                                       transition duration-300">

                                Ver más

                                <svg
                                    class="w-5 h-5 ml-2"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"/>

                                </svg>

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection