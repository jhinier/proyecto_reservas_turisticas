@extends('layouts.turista')

@section('content')

<section class="min-h-screen bg-g<section class="min-h-screen bg-gray-100 pb-24 pt-8">

    <div class="max-w-7xl mx-auto px-6 lg:px-10">

        {{-- TITULO --}}
        <div class="text-center mb-16">

            <p class="uppercase tracking-[0.3em] text-emerald-600 text-sm font-semibold">
                Aventuras & Experiencias
            </p>

            <h1 class="text-5xl font-black text-gray-900 mt-4">
                Actividades Turísticas
            </h1>

            <p class="text-gray-500 mt-6 max-w-3xl mx-auto text-lg leading-relaxed">
                Vive experiencias inolvidables,
                explora la naturaleza y disfruta de actividades únicas.
            </p>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">

            @forelse ($actividades as $actividad)

                <div class="group bg-white rounded-[2rem] overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 hover:-translate-y-2">

                    {{-- CARRUSEL --}}
                    <div class="relative h-80 overflow-hidden">

                        @if($actividad->publicacion->imagenes->count())

                            <div x-data="{ index: 0 }" class="w-full h-full relative">

                                @foreach($actividad->publicacion->imagenes->take(5) as $i => $img)

                                    <img
                                        x-show="index === {{ $i }}"
                                        x-transition
                                        src="{{ asset('storage/' . $img->imagen) }}"
                                        alt="{{ $actividad->publicacion->nombre }}"
                                        class="absolute inset-0 w-full h-full object-cover transition duration-700">

                                @endforeach

                                {{-- OVERLAY --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                                {{-- BOTON IZQUIERDO --}}
                                <button
                                    @click="index = (index === 0)
                                        ? {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }}
                                        : index - 1"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-9 h-9 rounded-full backdrop-blur-sm transition z-20">

                                    ‹

                                </button>

                                {{-- BOTON DERECHO --}}
                                <button
                                    @click="index = (index === {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }})
                                        ? 0
                                        : index + 1"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white w-9 h-9 rounded-full backdrop-blur-sm transition z-20">

                                    ›

                                </button>

                                {{-- INDICADORES --}}
                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">

                                    @foreach($actividad->publicacion->imagenes->take(5) as $i => $img)

                                        <div
                                            @click="index = {{ $i }}"
                                            :class="index === {{ $i }}
                                                ? 'bg-white w-6'
                                                : 'bg-white/50 w-2'"
                                            class="h-2 rounded-full transition-all duration-300 cursor-pointer">
                                        </div>

                                    @endforeach

                                </div>

                                {{-- BADGE --}}
                                <div class="absolute top-5 left-5 z-20">

                                    <span class="bg-white/20 backdrop-blur-md border border-white/20 text-white text-xs font-bold px-4 py-2 rounded-full">

                                        {{ $actividad->dificultad }}

                                    </span>

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

                        <div class="flex items-center justify-between gap-4">

                            <h2 class="text-2xl font-bold text-gray-900 line-clamp-1">

                                {{ $actividad->publicacion->nombre }}

                            </h2>

                            <span class="text-sm font-semibold text-emerald-700 whitespace-nowrap">

                                ⏱ {{ $actividad->duracion_estimada }}

                            </span>

                        </div>

                        <p class="text-gray-500 leading-relaxed mt-5 line-clamp-3">

                            {{ $actividad->publicacion->descripcion }}

                        </p>

                        {{-- INFO --}}
                        <div class="mt-6 pt-5 border-t border-gray-100">

                            <p class="text-sm text-gray-600 line-clamp-2">

                                🎒
                                <span class="font-semibold">
                                    Recomendaciones:
                                </span>

                                {{ $actividad->recomendaciones }}

                            </p>

                        </div>


                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-20">

                    <h2 class="text-3xl font-bold text-gray-400">

                        No existen actividades registradas.

                    </h2>

                </div>

            @endforelse

        </div>

    </div>

</section>

@endsection