<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight sm:text-3xl">
                Actividades Turísticas
            </h2>

            <p class="text-slate-500 mt-1 text-sm">
                Gestiona la oferta de aventura, deportes y experiencias
            </p>
        </div>

        <button
            wire:click="abrirModal"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-3 rounded-2xl shadow-md transition-all duration-300 flex w-full items-center justify-center gap-2 font-semibold sm:w-auto"
        >
            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2.5"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Agregar Actividad
        </button>
    </div>


    @if (session()->has('mensaje'))
        <div class="mb-6 p-4 bg-emerald-800 text-white rounded-2xl shadow-lg">
            {{ session('mensaje') }}
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- TABLA DE ACTIVIDADES TURÍSTICAS --}}
    {{-- ========================================================= --}}

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- Encabezado de tabla --}}
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/70">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-sm font-bold text-slate-800">
                        Actividades registradas
                    </h2>

                    <p class="text-xs text-slate-500 mt-0.5">
                        Listado de actividades, deportes y experiencias turísticas
                    </p>
                </div>

                <div class="bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1.5 rounded-xl text-xs font-bold">

                    {{ $actividades->count() }}

                    {{ $actividades->count() == 1 ? 'actividad' : 'actividades' }}

                </div>

            </div>

        </div>


        {{-- Contenedor responsive --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1000px] text-left">

                {{-- CABECERA --}}
                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Actividad
                        </th>

                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Descripción
                        </th>

                        <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Duración
                        </th>

                        <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Dificultad
                        </th>

                        <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            Acciones
                        </th>

                    </tr>

                </thead>


                {{-- CUERPO --}}
                <tbody class="divide-y divide-slate-100">

                    @forelse ($actividades as $actividad)

                        @php
                            $imagenPortada = $actividad->publicacion->imagenes->first();
                        @endphp


                        <tr class="hover:bg-slate-50/80 transition duration-200">

                            {{-- ACTIVIDAD --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    {{-- Miniatura --}}
                                    <div class="w-14 h-14 rounded-xl overflow-hidden
                                                bg-slate-100 border border-slate-200
                                                flex-shrink-0">

                                        @if ($imagenPortada)

                                            <img
                                                src="{{ asset('storage/' . $imagenPortada->imagen) }}"
                                                alt="{{ $actividad->publicacion->nombre }}"
                                                class="w-full h-full object-cover"
                                            >

                                        @else

                                            <div class="w-full h-full flex items-center justify-center text-emerald-500/50">

                                                <svg
                                                    class="w-6 h-6"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    />
                                                </svg>

                                            </div>

                                        @endif

                                    </div>


                                    {{-- Nombre --}}
                                    <div class="min-w-0">

                                        <p class="text-sm font-bold text-slate-800 truncate max-w-[220px]">
                                            {{ $actividad->publicacion->nombre }}
                                        </p>

                                        <p class="text-[11px] text-slate-400 mt-1">
                                            ID #{{ $actividad->publicacion_id }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- DESCRIPCIÓN --}}
                            <td class="px-6 py-4">

                                <p class="text-xs text-slate-500 leading-relaxed max-w-[320px] line-clamp-2">
                                    {{ $actividad->publicacion->descripcion ?: 'Sin descripción registrada' }}
                                </p>

                            </td>


                            {{-- DURACIÓN --}}
                            <td class="px-6 py-4 text-center">

                                <span
                                    class="inline-flex items-center gap-1.5
                                           px-3 py-1.5 rounded-lg
                                           bg-slate-100
                                           border border-slate-200
                                           text-xs font-semibold text-slate-700"
                                >

                                    <svg
                                        class="w-3.5 h-3.5 text-slate-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>

                                    {{ $actividad->duracion_estimada }}

                                </span>

                            </td>


                            {{-- DIFICULTAD --}}
                            <td class="px-6 py-4 text-center">

                                @php
                                    $claseDificultad = match($actividad->dificultad) {
                                        'Fácil' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Media' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Difícil' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                    };
                                @endphp

                                <span
                                    class="inline-flex items-center px-3 py-1.5
                                           rounded-lg border text-xs font-bold
                                           {{ $claseDificultad }}"
                                >
                                    {{ $actividad->dificultad ?: 'No definida' }}
                                </span>

                            </td>


                            {{-- ACCIONES --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- VER DETALLES --}}
                                    <button
                                        type="button"
                                        x-on:click="$flux.modal('detalle-actividad-{{ $actividad->publicacion_id }}').show()"
                                        title="Ver detalles"
                                        class="w-9 h-9 inline-flex items-center justify-center
                                               bg-white hover:bg-slate-100
                                               text-slate-600
                                               border border-slate-200
                                               rounded-lg
                                               transition duration-200
                                               shadow-sm"
                                    >

                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />
                                        </svg>

                                    </button>


                                    {{-- EDITAR --}}
                                    <button
                                        type="button"
                                        wire:click="editar({{ $actividad->publicacion_id }})"
                                        title="Editar Actividad"
                                        class="w-9 h-9 inline-flex items-center justify-center
                                               bg-white hover:bg-amber-50
                                               text-amber-600
                                               border border-amber-200
                                               rounded-lg
                                               transition duration-200
                                               shadow-sm"
                                    >

                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15H9v-3l9.5-9.5z"
                                            />
                                        </svg>

                                    </button>


                                    {{-- ELIMINAR --}}
                                    <button
                                        type="button"
                                        wire:click="eliminarActividad({{ $actividad->publicacion_id }})"
                                        wire:confirm="¿Estás segura de eliminar esta actividad por completo?"
                                        title="Eliminar"
                                        class="w-9 h-9 inline-flex items-center justify-center
                                               bg-red-50 hover:bg-red-100
                                               text-red-600
                                               border border-red-200
                                               rounded-lg
                                               transition duration-200"
                                    >

                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 01-1 1v3M4 7h16"
                                            />
                                        </svg>

                                    </button>

                                </div>

                            </td>

                        </tr>


                        {{-- ================================================= --}}
                        {{-- MODAL DE DETALLES --}}
                        {{-- AQUÍ ESTÁ LA CORRECCIÓN DE LAS IMÁGENES --}}
                        {{-- ================================================= --}}

                        <flux:modal
                            name="detalle-actividad-{{ $actividad->publicacion_id }}"
                            class="w-[94vw] md:max-w-4xl"
                        >

                            <div class="p-4 sm:p-6 text-slate-800">

                                {{-- ENCABEZADO --}}
                                <div class="flex items-start gap-3 mb-6">

                                    <div class="w-11 h-11 rounded-xl bg-emerald-100
                                                flex items-center justify-center">

                                        <svg
                                            class="w-6 h-6 text-emerald-700"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <h2 class="text-xl font-bold text-slate-800 sm:text-2xl">
                                            {{ $actividad->publicacion->nombre }}
                                        </h2>

                                        <p class="text-xs text-slate-500 mt-1">
                                            Información de la actividad turística
                                        </p>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- GALERÍA DE IMÁGENES --}}
                                {{-- ================================================= --}}

                                <div class="mb-6">

                                    <div class="flex flex-col gap-3 mb-3 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <h3 class="text-sm font-bold text-slate-800">
                                                Imágenes de la actividad
                                            </h3>

                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Fotografías registradas para esta actividad
                                            </p>
                                        </div>


                                        <span
                                            class="px-3 py-1.5 rounded-full
                                                   bg-emerald-50
                                                   border border-emerald-100
                                                   text-emerald-700
                                                   text-xs font-bold"
                                        >
                                            {{ $actividad->publicacion->imagenes->count() }}
                                            {{ $actividad->publicacion->imagenes->count() == 1 ? 'imagen' : 'imágenes' }}
                                        </span>

                                    </div>


                                    @if ($actividad->publicacion->imagenes->count() > 0)

                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">

                                            @foreach ($actividad->publicacion->imagenes as $imagen)

                                                <div
                                                    class="group relative aspect-[4/3]
                                                           overflow-hidden rounded-xl
                                                           bg-slate-100
                                                           border border-slate-200
                                                           shadow-sm"
                                                >

                                                    <img
                                                        src="{{ asset('storage/' . $imagen->imagen) }}"
                                                        alt="Imagen de {{ $actividad->publicacion->nombre }}"
                                                        class="w-full h-full object-cover
                                                               transition duration-300
                                                               group-hover:scale-105"
                                                    >

                                                </div>

                                            @endforeach

                                        </div>

                                    @else

                                        {{-- SIN IMÁGENES --}}
                                        <div
                                            class="rounded-xl border border-dashed
                                                   border-slate-300 bg-slate-50
                                                   p-8 text-center"
                                        >

                                            <svg
                                                class="w-10 h-10 mx-auto mb-3 text-slate-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>

                                            <p class="text-sm font-semibold text-slate-600">
                                                No hay imágenes registradas
                                            </p>

                                        </div>

                                    @endif

                                </div>


                                {{-- ================================================= --}}
                                {{-- DESCRIPCIÓN --}}
                                {{-- ================================================= --}}

                                <div class="mb-4">

                                    <h3 class="text-sm font-bold text-slate-800 mb-2">
                                        Descripción
                                    </h3>

                                    <div
                                        class="bg-slate-50 p-4 rounded-xl
                                               border border-slate-100"
                                    >

                                        <p class="text-slate-600 text-sm leading-relaxed">
                                            {{ $actividad->publicacion->descripcion ?: 'Sin descripción registrada.' }}
                                        </p>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- INFORMACIÓN --}}
                                {{-- ================================================= --}}

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                                    {{-- DURACIÓN --}}
                                    <div
                                        class="bg-slate-50 p-4 rounded-xl
                                               border border-slate-100"
                                    >

                                        <p class="text-[11px] uppercase tracking-wider
                                                  font-bold text-slate-400 mb-1">
                                            Duración estimada
                                        </p>

                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $actividad->duracion_estimada ?: 'No especificada' }}
                                        </p>

                                    </div>


                                    {{-- DIFICULTAD --}}
                                    <div
                                        class="bg-slate-50 p-4 rounded-xl
                                               border border-slate-100"
                                    >

                                        <p class="text-[11px] uppercase tracking-wider
                                                  font-bold text-slate-400 mb-1">
                                            Dificultad
                                        </p>

                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $actividad->dificultad ?: 'No definida' }}
                                        </p>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- RECOMENDACIONES --}}
                                {{-- ================================================= --}}

                                <div>

                                    <h3 class="text-sm font-bold text-slate-800 mb-2">
                                        Recomendaciones
                                    </h3>

                                    <div
                                        class="bg-slate-50 p-4 rounded-xl
                                               border border-slate-100"
                                    >

                                        <p class="text-sm text-slate-600 leading-relaxed">
                                            {{ $actividad->recomendaciones ?: 'Sin recomendaciones registradas.' }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </flux:modal>


                    @empty

                        {{-- SIN REGISTROS --}}
                        <tr>

                            <td colspan="5" class="px-6 py-14 text-center">

                                <div class="flex flex-col items-center justify-center">

                                    <div
                                        class="w-14 h-14 rounded-2xl bg-slate-100
                                               flex items-center justify-center mb-3"
                                    >

                                        <svg
                                            class="w-7 h-7 text-slate-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 001.73 3z"
                                            />
                                        </svg>

                                    </div>

                                    <p class="text-sm font-semibold text-slate-600">
                                        No hay actividades turísticas registradas
                                    </p>

                                    <p class="text-xs text-slate-400 mt-1">
                                        Utiliza el botón "Agregar Actividad" para registrar una.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MODAL AGREGAR / EDITAR --}}
    {{-- ========================================================= --}}

    @if ($mostrarModal)

        <div
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm
                   flex items-center justify-center z-50 p-4"
        >

            <div
                class="bg-white text-slate-800 rounded-3xl p-4 sm:p-8
                       w-full max-w-2xl shadow-2xl border border-slate-100
                       overflow-y-auto max-h-[90vh]"
            >

                <h2 class="text-xl font-bold mb-6 text-slate-800 tracking-tight sm:text-2xl">

                    {{ $modoEdicion
                        ? '📝 Editar Actividad Turística'
                        : '🌄 Registrar Actividad Turística'
                    }}

                </h2>


                <div class="space-y-4">

                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Nombre de la actividad
                        </label>

                        <input
                            type="text"
                            wire:model="nombre"
                            class="w-full p-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-slate-800"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Descripción
                        </label>

                        <textarea
                            wire:model="descripcion"
                            rows="3"
                            class="w-full p-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-slate-800"
                        ></textarea>

                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-1">
                                Duración estimada
                            </label>

                            <input
                                type="text"
                                wire:model="duracion_estimada"
                                class="w-full p-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-slate-800"
                                placeholder="Ej: 2 horas"
                            >

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-1">
                                Dificultad
                            </label>

                            <select
                                wire:model="dificultad"
                                class="w-full p-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-slate-800"
                            >

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="Fácil">
                                    Fácil
                                </option>

                                <option value="Media">
                                    Media
                                </option>

                                <option value="Difícil">
                                    Difícil
                                </option>

                            </select>

                        </div>

                    </div>


                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Recomendaciones
                        </label>

                        <textarea
                            wire:model="recomendaciones"
                            rows="2"
                            class="w-full p-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-slate-800"
                        ></textarea>

                    </div>


                    @if($modoEdicion && count($imagenesGuardadas) > 0)

                        <div
                            class="p-4 bg-slate-50 border border-slate-200/60
                                   rounded-2xl"
                        >

                            <label
                                class="block text-xs font-bold text-slate-700
                                       uppercase tracking-wider mb-2"
                            >
                                Imágenes en el servidor
                                (Presiona la X para borrarlas)
                            </label>

                            <div class="flex flex-wrap gap-2">

                                @foreach ($imagenesGuardadas as $img)

                                    <div class="relative group/thumb">

                                        <img
                                            src="{{ asset('storage/' . $img->imagen) }}"
                                            class="w-16 h-16 rounded-xl object-cover
                                                   border border-slate-200 shadow-sm
                                                   transition group-hover/thumb:brightness-75"
                                        >

                                        <button
                                            type="button"
                                            wire:click="eliminarImagen({{ $img->id }})"
                                            class="absolute -top-1.5 -right-1.5
                                                   bg-red-500 hover:bg-red-600
                                                   text-white w-5 h-5 rounded-full
                                                   flex items-center justify-center
                                                   text-[10px] font-bold shadow-md
                                                   transition"
                                        >
                                            ✕
                                        </button>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @endif


                    <div>

                        <label class="block text-sm font-semibold text-slate-700 mb-1">

                            {{ $modoEdicion
                                ? 'Añadir más imágenes a la galería'
                                : 'Subir Imágenes iniciales'
                            }}

                        </label>

                        <input
                            type="file"
                            wire:model.live="imagenes"
                            multiple
                            class="w-full p-2.5 border border-slate-200
                                   rounded-xl bg-slate-50 text-sm text-slate-600"
                        >

                        <div
                            wire:loading
                            wire:target="imagenes"
                            class="text-xs text-emerald-700 mt-1"
                        >
                            Cargando archivos multimedia...
                        </div>

                    </div>

                </div>


                <div
                    class="flex flex-col-reverse gap-3 mt-6 pt-4 sm:flex-row sm:justify-end
                           border-t border-slate-100"
                >

                    <button
                        type="button"
                        wire:click="cerrarModal"
                        class="px-5 py-2.5 rounded-xl bg-slate-100
                               hover:bg-slate-200 text-slate-600 text-sm"
                    >
                        Cancelar
                    </button>


                    <button
                        type="button"
                        wire:click="guardar"
                        class="px-6 py-2.5 rounded-xl bg-emerald-700
                               hover:bg-emerald-800 text-white font-semibold text-sm"
                    >

                        {{ $modoEdicion
                            ? 'Actualizar Cambios'
                            : 'Guardar Actividad'
                        }}

                    </button>

                </div>

            </div>

        </div>

    @endif

</div>
