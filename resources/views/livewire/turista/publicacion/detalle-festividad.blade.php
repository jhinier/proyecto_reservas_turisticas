@extends('layouts.turista')

@section('content')

<section class="bg-gray-100 min-h-screen pb-20">

    {{-- HERO --}}
    <div class="relative h-[500px]">

        @if($festividad->publicacion->imagenes->count())

            <img
                src="{{ asset('storage/'.$festividad->publicacion->imagenes->first()->imagen) }}"
                class="w-full h-full object-cover">

        @endif

        <div class="absolute inset-0 bg-black/50"></div>

        <div
            class="absolute bottom-16 left-1/2 -translate-x-1/2 text-center text-white">

            <h1 class="text-5xl font-black">

                {{ $festividad->publicacion->nombre }}

            </h1>

            <div class="mt-5 flex justify-center gap-4 flex-wrap">

                <span
                    class="bg-white/20 backdrop-blur px-5 py-2 rounded-full">

                    📅 Inicio:
                    {{ \Carbon\Carbon::parse($festividad->fecha_inicio)->format('d/m/Y') }}

                </span>

                <span
                    class="bg-white/20 backdrop-blur px-5 py-2 rounded-full">

                    🏁 Fin:
                    {{ \Carbon\Carbon::parse($festividad->fecha_fin)->format('d/m/Y') }}

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

                {!! nl2br(e($festividad->publicacion->descripcion)) !!}

            </div>

        </div>

        {{-- ACTIVIDADES --}}
        <div class="bg-white rounded-3xl shadow-xl p-10 mt-10">

            <h2 class="text-3xl font-bold mb-8">

                Actividades Programadas

            </h2>

            <div class="space-y-6">

                @forelse($festividad->actividades as $actividad)

                    <div
                        class="border border-gray-200 rounded-2xl p-6">

                        <h3
                            class="font-bold text-xl text-slate-800">

                            {{ $actividad->nombre }}

                        </h3>

                        <div
                            class="mt-4 space-y-2 text-gray-600">

                            <p>
                                📍 {{ $actividad->lugar }}
                            </p>

                            <p>
                                📅 {{ $actividad->fecha }}
                            </p>

                            <p>
                                🕒 {{ $actividad->hora }}
                            </p>

                        </div>

                    </div>

                @empty

                    <p class="text-gray-500 italic">

                        No existen actividades registradas.

                    </p>

                @endforelse

            </div>

        </div>

        {{-- GALERÍA --}}
        @if($festividad->publicacion->imagenes->count())

        <div
            class="bg-white rounded-3xl shadow-xl p-10 mt-10">

            <h2 class="text-3xl font-bold mb-8">

                Galería

            </h2>

            <div class="grid md:grid-cols-3 gap-6">

                @foreach($festividad->publicacion->imagenes as $imagen)

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