@extends('layouts.turista')

@section('content')

<section class="bg-gray-100 min-h-screen pb-20">

    {{-- HERO --}}
    <div class="relative h-[500px]">

        @if($actividad->publicacion->imagenes->count())

            <img
                src="{{ asset('storage/'.$actividad->publicacion->imagenes->first()->imagen) }}"
                class="w-full h-full object-cover">

        @endif

        <div class="absolute inset-0 bg-black/50"></div>

        <div
            class="absolute bottom-16 left-1/2 -translate-x-1/2 text-center text-white">

            <h1 class="text-5xl font-black">

                {{ $actividad->publicacion->nombre }}

            </h1>

            <div class="mt-5 flex justify-center gap-4">

                <span
                    class="bg-white/20 backdrop-blur px-5 py-2 rounded-full">

                    {{ $actividad->dificultad }}

                </span>

                <span
                    class="bg-white/20 backdrop-blur px-5 py-2 rounded-full">

                    ⏱ {{ $actividad->duracion_estimada }}

                </span>

            </div>

        </div>

    </div>

    <div class="max-w-6xl mx-auto px-6 mt-16">

        {{-- DESCRIPCIÓN --}}
        <div class="bg-white rounded-3xl shadow-xl p-10">

            <h2 class="text-3xl font-bold mb-8">

                Descripción

            </h2>

            <div class="text-gray-600 text-lg leading-9 text-justify">

                {!! nl2br(e($actividad->publicacion->descripcion)) !!}

            </div>

        </div>

        {{-- RECOMENDACIONES --}}
        @if($actividad->recomendaciones)

        <div class="bg-white rounded-3xl shadow-xl p-10 mt-10">

            <h2 class="text-3xl font-bold mb-8">

                Recomendaciones

            </h2>

            <div class="text-gray-600 text-lg leading-9">

                {{ $actividad->recomendaciones }}

            </div>

        </div>

        @endif

        {{-- GALERÍA --}}
        @if($actividad->publicacion->imagenes->count())

        <div class="bg-white rounded-3xl shadow-xl p-10 mt-10">

            <h2 class="text-3xl font-bold mb-8">

                Galería

            </h2>

            <div class="grid md:grid-cols-3 gap-6">

                @foreach($actividad->publicacion->imagenes as $imagen)

                    <img
                        src="{{ asset('storage/'.$imagen->imagen) }}"
                        class="
                        h-64
                        w-full
                        object-cover
                        rounded-2xl
                        shadow-lg
                        hover:scale-105
                        transition duration-500">

                @endforeach

            </div>

        </div>

        @endif

        {{-- VOLVER --}}
        <div class="mt-12 text-center">

            <a
                href="{{ url()->previous() }}"
                class="
                inline-block
                bg-emerald-600
                text-white
                px-10
                py-4
                rounded-2xl
                font-bold
                shadow-lg
                hover:bg-emerald-700
                hover:scale-105
                transition">

                ← Volver

            </a>

        </div>

    </div>

</section>

@endsection