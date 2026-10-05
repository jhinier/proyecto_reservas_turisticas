<div class="p-6">

    @if (session()->has('mensaje'))
        <div class="mb-4 p-4 bg-green-800 text-white rounded-2xl shadow-lg text-sm font-medium">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                Festividades
            </h1>

            <p class="text-slate-500 mt-1 text-sm">
                Gestiona eventos turísticos y su cronograma multimedia
            </p>
        </div>

        <button
            x-on:click="$flux.modal('modal-festividad').show(); $wire.set('modoEditar', false); $wire.call('limpiarCampos');"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2 font-semibold text-sm"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Nueva Festividad

        </button>

    </div>

    {{-- FILTRO DE ESTADOS --}}
    <div class="mb-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h3 class="text-sm font-bold text-slate-700">
                Estado de las festividades
            </h3>

            <p class="text-xs text-slate-400 mt-0.5">
                Filtra los eventos según su fecha
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            {{-- TODOS --}}
            <button
                wire:click="$set('filtroEstado', 'todos')"
                class="px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200
                {{ $filtroEstado === 'todos'
                    ? 'bg-slate-800 text-white border-slate-800 shadow-sm'
                    : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}"
            >
                Todos
            </button>

            {{-- PRÓXIMAMENTE --}}
            <button
                wire:click="$set('filtroEstado', 'proximamente')"
                class="px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200
                {{ $filtroEstado === 'proximamente'
                    ? 'bg-yellow-500 text-white border-yellow-500 shadow-sm'
                    : 'bg-white text-yellow-700 border-yellow-200 hover:bg-yellow-50' }}"
            >
                🟡 Próximamente
            </button>

            {{-- EN CURSO --}}
            <button
                wire:click="$set('filtroEstado', 'encurso')"
                class="px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200
                {{ $filtroEstado === 'encurso'
                    ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm'
                    : 'bg-white text-emerald-700 border-emerald-200 hover:bg-emerald-50' }}"
            >
                🟢 En curso
            </button>

            {{-- FINALIZADO --}}
            <button
                wire:click="$set('filtroEstado', 'finalizado')"
                class="px-4 py-2 rounded-xl text-xs font-bold border transition-all duration-200
                {{ $filtroEstado === 'finalizado'
                    ? 'bg-red-600 text-white border-red-600 shadow-sm'
                    : 'bg-white text-red-700 border-red-200 hover:bg-red-50' }}"
            >
                🔴 Finalizado
            </button>

        </div>

    </div>

    {{-- ============================================================
    TABLA DE FESTIVIDADES
    SOLO CAMBIO VISUAL: CARDS → TABLA
    ============================================================ --}}

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        {{-- CABECERA DE LA TABLA --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-slate-50 border-b border-slate-200">

                    <tr>

                        <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Festividad
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                            Fechas
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">
                            Actividades
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">
                            Fotografías
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">
                            Estado
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($festividades as $festividad)

                        @php

                            $hoy = \Carbon\Carbon::now();

                            $inicio = \Carbon\Carbon::parse(
                                $festividad->fecha_inicio
                            );

                            $fin = \Carbon\Carbon::parse(
                                $festividad->fecha_fin
                            );

                        @endphp


                        <tr class="hover:bg-slate-50/80 transition duration-200">

                            {{-- ====================================================
                                FESTIVIDAD
                            ===================================================== --}}

                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    {{-- MINIATURA --}}

                                    @php
                                        $imagenPortada =
                                            $festividad->publicacion->imagenes->first();
                                    @endphp

                                    @if($imagenPortada)

                                        <img
                                            src="{{ asset('storage/' . $imagenPortada->imagen) }}"
                                            class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm shrink-0"
                                        >

                                    @else

                                        <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 shrink-0">
                                            📷
                                        </div>

                                    @endif


                                    <div class="min-w-0">

                                        <p class="font-bold text-slate-800 truncate max-w-[220px]">

                                            {{ $festividad->publicacion->nombre }}

                                        </p>

                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1 max-w-[250px]">

                                            {{ $festividad->publicacion->descripcion }}

                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- ====================================================
                                FECHAS
                            ===================================================== --}}

                            <td class="px-5 py-4 whitespace-nowrap">

                                <div class="text-xs">

                                    <div class="flex items-center gap-1.5 text-slate-700">

                                        <span>📅</span>

                                        <span class="font-semibold">

                                            {{ $inicio->format('d/m/Y') }}

                                        </span>

                                    </div>


                                    <div class="text-slate-400 text-center my-0.5">

                                        ↓

                                    </div>


                                    <div class="flex items-center gap-1.5 text-slate-700">

                                        <span>📅</span>

                                        <span class="font-semibold">

                                            {{ $fin->format('d/m/Y') }}

                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- ====================================================
                                ACTIVIDADES
                            ===================================================== --}}

                            <td class="px-5 py-4 text-center">

                                <span class="inline-flex items-center justify-center min-w-[38px] px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100 font-bold text-xs">

                                    {{ $festividad->actividades->count() }}

                                </span>

                            </td>


                            {{-- ====================================================
                                FOTOGRAFÍAS
                            ===================================================== --}}

                            <td class="px-5 py-4 text-center">

                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-50 text-slate-600 border border-slate-200 font-semibold text-xs">

                                    📸

                                    {{ $festividad->publicacion->imagenes->count() }}

                                </span>

                            </td>


                            {{-- ====================================================
                                ESTADO
                            ===================================================== --}}

                            <td class="px-5 py-4 text-center">

                                @if($hoy->lt($inicio))

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 text-[11px] font-bold whitespace-nowrap">

                                        🔒 Próximamente

                                    </span>

                                @elseif($hoy->gt($fin))

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-red-700 border border-red-200 text-[11px] font-bold whitespace-nowrap">

                                        🔒 Finalizado

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold whitespace-nowrap">

                                        ✅ Disponible

                                    </span>

                                @endif

                            </td>


                            {{-- ====================================================
                                ACCIONES
                                IMPORTANTE:
                                SE CONSERVAN LOS wire:click ORIGINALES
                            ===================================================== --}}

                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-1.5">


                                    {{-- GALERÍA --}}

                                    <button
                                        wire:click="abrirGaleria({{ $festividad->publicacion_id }})"
                                        title="Gestionar Galería"
                                        class="w-9 h-9 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-lg flex items-center justify-center transition"
                                    >

                                        📸

                                    </button>


                                    {{-- VER DETALLES --}}
                                    <button
                                        type="button"
                                        x-on:click="$wire.verDetalles({{ $festividad->publicacion_id }}).then(() => {
                                            $flux.modal('modal-detalles-festividad').show();
                                        })"
                                        title="Ver detalles"
                                        class="w-9 h-9 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 rounded-lg flex items-center justify-center transition shadow-sm"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                            />
                                    
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            />
                                        </svg>
                                    </button>
                          
                                    
                                    {{-- EDITAR --}}

                                    <button
                                        wire:click="cargarFestividad({{ $festividad->publicacion_id }})"
                                        x-on:click="$flux.modal('modal-festividad').show()"
                                        title="Editar festividad"
                                        class="w-9 h-9 bg-white hover:bg-amber-50 text-amber-600 border border-amber-200 rounded-lg flex items-center justify-center transition shadow-sm"
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
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16.5 3.5a2.121 2.121 0 013 3L11 15l-4 1 1-4 9.5-8.5z"
                                            />

                                        </svg>

                                    </button>


                                    {{-- AGREGAR ACTIVIDAD --}}

                                    <button
                                        wire:click="seleccionarFestividad({{ $festividad->publicacion_id }})"
                                        x-on:click="$flux.modal('modal-actividad').show()"
                                        title="Agregar Actividad"
                                        class="h-9 px-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition shadow-sm flex items-center justify-center font-bold text-xs"
                                    >

                                        + Act

                                    </button>


                                    {{-- ELIMINAR --}}

                                    <button
                                        wire:click="eliminar({{ $festividad->publicacion_id }})"
                                        wire:confirm="¿Eliminar festividad?"
                                        title="Eliminar"
                                        class="w-9 h-9 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg flex items-center justify-center transition"
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
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 01-1 1v3M4 7h16"
                                            />

                                        </svg>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-14 text-center"
                            >

                                <div class="text-5xl mb-3">
                                    🎉
                                </div>

                                <h2 class="text-xl font-bold text-slate-800 mb-1">

                                    No hay festividades registradas

                                </h2>

                                <p class="text-sm text-slate-500">

                                    Crea una nueva festividad para comenzar.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- ============================================================
        MODAL NUEVA / EDITAR FESTIVIDAD
    ============================================================ --}}

    <flux:modal
        name="modal-festividad"
        class="md:w-2/4"
    >

        <div class="p-6 bg-white rounded-3xl text-slate-800">

            <h2 class="text-2xl font-bold mb-6 text-slate-800">

                {{ $modoEditar ? 'Editar Festividad' : 'Nueva Festividad' }}

            </h2>


            <form
                wire:submit.prevent="guardarFestividad"
                class="space-y-4"
            >

                <input
                    type="text"
                    wire:model="nombre"
                    placeholder="Nombre de la festividad"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm"
                >


                <textarea
                    wire:model="descripcion"
                    placeholder="Descripción"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-24 text-sm"
                ></textarea>


                <div class="grid grid-cols-2 gap-4 text-sm">

                    {{-- FECHA INICIO --}}

                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Fecha Inicio
                        </label>

                        <input
                            type="date"
                            wire:model.live="fecha_inicio"
                            min="{{ now()->format('Y-m-d') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >

                    </div>


                    {{-- FECHA FIN --}}

                    <div>

                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Fecha Fin
                        </label>

                        <input
                            type="date"
                            wire:model="fecha_fin"
                            min="{{ $fecha_inicio ? \Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d') : now()->format('Y-m-d') }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-2xl font-bold transition shadow-lg text-sm"
                >

                    {{ $modoEditar ? 'Actualizar Festividad' : 'Guardar Festividad' }}

                </button>

            </form>

        </div>

    </flux:modal>


    {{-- ============================================================
        MODAL NUEVA ACTIVIDAD
    ============================================================ --}}

    <flux:modal
        name="modal-actividad"
        class="md:w-2/4"
    >

        <div class="p-6 bg-white rounded-3xl text-slate-800">

            <h2 class="text-2xl font-bold mb-6 text-slate-800">
                Nueva Actividad
            </h2>


            <form
                wire:submit.prevent="guardarActividad"
                class="space-y-4 text-sm"
            >

                <input
                    type="text"
                    wire:model="actividad_nombre"
                    placeholder="Nombre de la actividad"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800"
                >


                <div class="grid grid-cols-2 gap-4">

                    <input
                        type="date"
                        wire:model="fecha"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800"
                    >

                    <input
                        type="time"
                        wire:model="hora"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800"
                    >

                </div>


                <input
                    type="text"
                    wire:model="lugar"
                    placeholder="Lugar"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800"
                >


                <textarea
                    wire:model="descripcion_actividad"
                    placeholder="Descripción de la actividad"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 h-20"
                ></textarea>


                <input
                    type="file"
                    wire:model="imagen_actividad"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800"
                >


                <button
                    type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-2xl font-bold transition shadow-lg"
                >
                    Guardar Actividad
                </button>

            </form>

        </div>

    </flux:modal>


    {{-- ============================================================
        GESTOR DE GALERÍA
    ============================================================ --}}

    <div
        x-data="{ show: @entangle('abierto') }"
        x-show="show"
        class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm"
        style="display: none;"
    >

        <div
            @click.outside="show = false"
            class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col"
        >

            <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur z-20">

                <div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Gestor de Galería
                    </h3>

                    <p class="text-xs text-emerald-600 font-bold mt-0.5">

                        Festividad activa:
                        {{ $festividadSeleccionada?->publicacion?->nombre }}

                    </p>

                </div>


                <button
                    @click="show = false"
                    class="p-2 hover:bg-gray-100 rounded-xl dark:hover:bg-gray-800 transition text-gray-500"
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
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>

                </button>

            </div>


            <div class="p-6 flex-1">

                @if (session()->has('mensaje_galeria'))

                    <div class="mb-4 p-3.5 bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm">

                        {{ session('mensaje_galeria') }}

                    </div>

                @endif


                <div class="mb-8">

                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">
                        Fotografías en la Nube
                    </h4>


                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">

                        @if($festividadSeleccionada && $festividadSeleccionada->publicacion)

                            @foreach($festividadSeleccionada->publicacion->imagenes as $imagen)

                                <div
                                    wire:key="img-cloud-{{ $imagen->id }}"
                                    class="group relative aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 dark:border-gray-700 shadow-sm"
                                >

                                    <img
                                        src="{{ asset('storage/' . $imagen->imagen) }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-110"
                                    >


                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">

                                        <button
                                            wire:click="eliminarImagen({{ $imagen->id }})"
                                            wire:confirm="¿Deseas eliminar permanentemente esta foto del servidor?"
                                            class="bg-red-500 text-white p-2 rounded-xl hover:bg-red-600 transition shadow-lg transform hover:scale-105"
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
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 01-1 1h-4a1 1 0 01-1 1v3M4 7h16"
                                                />

                                            </svg>

                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        @endif

                    </div>

                </div>


                <hr class="border-gray-100 dark:border-gray-800 mb-6">


                <div class="w-full">

                    <x-image-upload
                        id="upload-galeria"
                        label="Añadir Nuevas Fotografías"
                        model="nuevasImagenes"
                        :imagesArray="$nuevasImagenes"
                        deleteMethod="removerTemporal"
                        helpText="PNG, JPG o WEBP (Máx. 5MB por foto)"
                    />


                    @error('nuevasImagenes.*')

                        <div class="mt-2 text-xs text-red-600 font-bold bg-red-50 p-2 rounded-lg border border-red-100">

                            ⚠️ {{ $message }}

                        </div>

                    @enderror


                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">

                        <button
                            wire:click="subirFotos"
                            wire:loading.attr="disabled"
                            @disabled(empty($nuevasImagenes))
                            class="w-full bg-[#1a4031] text-white py-3 rounded-2xl text-sm font-bold shadow-md hover:bg-[#132f24] transition disabled:opacity-40 disabled:cursor-not-allowed flex justify-center items-center gap-2"
                        >

                            <span
                                wire:loading.remove
                                wire:target="subirFotos"
                            >

                                {{ empty($nuevasImagenes)
                                    ? 'Selecciona fotos para guardar'
                                    : 'Sincronizar y Guardar en la Nube'
                                }}

                            </span>


                            <span
                                wire:loading
                                wire:target="subirFotos"
                            >
                                Guardando fotos...
                            </span>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
        CALENDARIO
    ============================================================ --}}

    <button
        type="button"
        wire:click="$dispatch('abrirCalendario')"
        class="fixed bottom-8 right-8 z-40 bg-emerald-700 hover:bg-emerald-800 text-white shadow-2xl rounded-full px-6 py-3.5 font-bold text-base transition duration-300 hover:scale-105 flex items-center gap-2"
    >

        📅 Calendario

    </button>

    {{-- ============================================================
    MODAL DETALLES DE FESTIVIDAD
    ============================================================ --}}
    
    <flux:modal
        name="modal-detalles-festividad"
        class="md:w-3/5"
    >
    
        @if($festividadDetalle)
    
            <div class="bg-white rounded-3xl overflow-hidden">
    
               {{-- CABECERA --}}
                <div class="relative bg-white px-6 py-7 border-b border-slate-200">
                
                    {{-- Línea decorativa superior --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-700 via-emerald-500 to-lime-400"></div>
                
                    <div class="pr-8">
                
                        {{-- ETIQUETA --}}
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                                     bg-emerald-50 border border-emerald-200
                                     text-emerald-700 text-[11px] font-bold uppercase tracking-wider mb-3">
                
                            <svg
                                class="w-3.5 h-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                
                            Detalles de festividad
                
                        </span>
                
                
                        {{-- TÍTULO --}}
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                
                            {{ $festividadDetalle->publicacion->nombre }}
                
                        </h2>
                
                
                        {{-- SUBTÍTULO --}}
                        <p class="text-slate-500 text-sm mt-1">
                
                            Información completa del evento
                
                        </p>
                
                    </div>
                
                </div>
    
    
                {{-- CONTENIDO --}}
                <div class="p-6 space-y-6">
    
                    {{-- DESCRIPCIÓN --}}
                    <div>
    
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                            Descripción
                        </h3>
    
                        <p class="text-sm text-slate-600 leading-relaxed">
                            {{ $festividadDetalle->publicacion->descripcion ?: 'Sin descripción registrada.' }}
                        </p>
    
                    </div>
    
    
                    {{-- FECHAS --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
    
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                Fecha de inicio
                            </p>
    
                            <p class="text-lg font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($festividadDetalle->fecha_inicio)->format('d/m/Y') }}
                            </p>
    
                        </div>
    
    
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
    
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1">
                                Fecha de finalización
                            </p>
    
                            <p class="text-lg font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($festividadDetalle->fecha_fin)->format('d/m/Y') }}
                            </p>
    
                        </div>
    
                    </div>
    
    
                    {{-- ACTIVIDADES --}}
                    <div>
    
                        <div class="flex items-center justify-between mb-3">
    
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Actividades
                            </h3>
    
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold">
                                {{ $festividadDetalle->actividades->count() }}
                            </span>
    
                        </div>
    
    
                        @if($festividadDetalle->actividades->count())
    
                            <div class="space-y-2">
    
                                @foreach($festividadDetalle->actividades as $actividad)
    
                                    <div class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
    
                                        <div class="w-9 h-9 shrink-0 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                            📅
                                        </div>
    
                                        <div class="min-w-0">
    
                                            <p class="text-sm font-bold text-slate-800">
                                                {{ $actividad->nombre }}
                                            </p>
    
                                            @if($actividad->fecha)
                                                <p class="text-xs text-slate-500 mt-0.5">
                                                    {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
    
                                                    @if($actividad->hora)
                                                        · {{ $actividad->hora }}
                                                    @endif
                                                </p>
                                            @endif
    
                                            @if($actividad->lugar)
                                                <p class="text-xs text-emerald-700 mt-1 font-medium">
                                                    📍 {{ $actividad->lugar }}
                                                </p>
                                            @endif
    
                                        </div>
    
                                    </div>
    
                                @endforeach
    
                            </div>
    
                        @else
    
                            <div class="p-5 bg-slate-50 border border-dashed border-slate-300 rounded-2xl text-center">
    
                                <p class="text-sm text-slate-500">
                                    No hay actividades registradas.
                                </p>
    
                            </div>
    
                        @endif
    
                    </div>
    
    
                    {{-- FOTOGRAFÍAS --}}
                    <div>
    
                        <div class="flex items-center justify-between mb-3">
    
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Fotografías
                            </h3>
    
                            <span class="text-xs font-bold text-slate-500">
                                {{ $festividadDetalle->publicacion->imagenes->count() }}
                            </span>
    
                        </div>
    
    
                        @if($festividadDetalle->publicacion->imagenes->count())
    
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
    
                                @foreach($festividadDetalle->publicacion->imagenes as $imagen)
    
                                    <div class="aspect-square rounded-xl overflow-hidden border border-slate-200 bg-slate-100">
    
                                        <img
                                            src="{{ asset('storage/' . $imagen->imagen) }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300"
                                        >
    
                                    </div>
    
                                @endforeach
    
                            </div>
    
                        @else
    
                            <div class="p-5 bg-slate-50 border border-dashed border-slate-300 rounded-2xl text-center">
    
                                <p class="text-sm text-slate-500">
                                    No hay fotografías registradas.
                                </p>
    
                            </div>
    
                        @endif
    
                    </div>
    
    
                    {{-- CERRAR --}}
                    <div class="pt-2">
    
                        <button
                            type="button"
                            x-on:click="$flux.modal('modal-detalles-festividad').close()"
                            class="w-full bg-slate-800 hover:bg-slate-900 text-white py-3 rounded-2xl font-bold text-sm transition"
                        >
                            Cerrar
                        </button>
    
                    </div>
    
                </div>
    
            </div>
    
        @endif
    
    </flux:modal>


    @livewire('admin.festividades.calendario-festividades')

</div>