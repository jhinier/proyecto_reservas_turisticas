<div class="p-6">

    <!-- TÍTULO -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-300">
            Actividades Turísticas
        </h2>

        <button wire:click="abrirModal"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Agregar Actividad
        </button>
    </div>

    <!-- MENSAJE -->
    @if (session()->has('mensaje'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($actividades as $actividad)

            <div class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">

                <!-- IMAGEN -->
                <div class="relative h-52 overflow-hidden">

                    @if ($actividad->publicacion->imagenes->first())
                        <img src="{{ asset('storage/' . $actividad->publicacion->imagenes->first()->imagen) }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:opacity-0">
                    @endif

                    <!-- CARRUSEL -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500">

                        <div x-data="{ index: 0 }" class="relative w-full h-full">

                            @foreach ($actividad->publicacion->imagenes->take(5) as $i => $img)

                                <img x-show="index === {{ $i }}"
                                    src="{{ asset('storage/' . $img->imagen) }}"
                                    class="absolute w-full h-full object-cover transition">

                            @endforeach

                            <button
                                @click="index = (index === 0) ? {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }} : index - 1"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 text-white px-2 py-1 rounded-full">
                                ‹
                            </button>

                            <button
                                @click="index = (index === {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }}) ? 0 : index + 1"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 text-white px-2 py-1 rounded-full">
                                ›
                            </button>

                        </div>
                    </div>
                </div>

                <!-- CONTENIDO -->
                <div class="p-4">

                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">
                        {{ $actividad->publicacion->nombre }}
                    </h3>

                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                        {{ $actividad->publicacion->descripcion }}
                    </p>

                    <div class="mt-4 space-y-2 text-sm text-gray-700">

                        <p>
                            ⏱️ <strong>Duración:</strong>
                            {{ $actividad->duracion_estimada }}
                        </p>

                        <p>
                            🏔️ <strong>Dificultad:</strong>
                            {{ $actividad->dificultad }}
                        </p>

                        <p class="line-clamp-2">
                            🎒 <strong>Recomendaciones:</strong>
                            {{ $actividad->recomendaciones }}
                        </p>

                    </div>

                    <!-- IMÁGENES -->
                    <div class="flex flex-wrap gap-2 mt-4">

                        @foreach ($actividad->publicacion->imagenes as $img)

                            <div class="relative">

                                <img src="{{ asset('storage/' . $img->imagen) }}"
                                    class="w-16 h-16 rounded-lg object-cover border">

                                <button
                                    wire:click="eliminarImagen({{ $img->id }})"
                                    class="absolute -top-2 -right-2 bg-red-600 text-white w-5 h-5 rounded-full text-xs">
                                    ✕
                                </button>

                            </div>

                        @endforeach

                    </div>

                    <!-- BOTONES -->
                    <div class="flex justify-end gap-2 mt-4">

                        <!-- BOTÓN EDITAR -->
                        <button
                            wire:click="editar({{ $actividad->publicacion_id }})"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                            Editar
                        </button>

                        <!-- BOTÓN ELIMINAR -->
                        <button
                            wire:click="eliminarActividad({{ $actividad->publicacion_id }})"
                            onclick="return confirm('¿Estás segura de eliminar esta actividad?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                            Eliminar
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    <!-- MODAL -->
@if ($mostrarModal)

<div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white dark:bg-zinc-800 text-gray-800 dark:text-white rounded-2xl p-8 w-full max-w-2xl shadow-2xl border border-gray-200 dark:border-zinc-700 overflow-y-auto max-h-[90vh]">

        <!-- TÍTULO -->
        <h2 class="text-2xl font-bold mb-6 text-center">
            {{ $modoEdicion ? '✏️ Editar Actividad Turística' : '🌄 Registrar Actividad Turística' }}
        </h2>

        <!-- NOMBRE -->
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Nombre de la actividad
            </label>

            <input type="text"
                wire:model="nombre"
                placeholder="Ej: Caminata al Chimborazo"
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition">

            @error('nombre')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Descripción
            </label>

            <textarea
                wire:model="descripcion"
                rows="3"
                placeholder="Describe la actividad turística..."
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>

            @error('descripcion')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- DURACIÓN -->
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Duración estimada
            </label>

            <input type="text"
                wire:model="duracion_estimada"
                placeholder="Ej: 3 horas"
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition">

            @error('duracion_estimada')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- DIFICULTAD -->
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Dificultad
            </label>

            <select wire:model="dificultad"
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition">

                <option value="">Seleccione una opción</option>
                <option value="Fácil">Fácil</option>
                <option value="Media">Media</option>
                <option value="Difícil">Difícil</option>

            </select>

            @error('dificultad')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- RECOMENDACIONES -->
        <div class="mb-5">
            <label class="block text-sm font-semibold mb-1">
                Recomendaciones
            </label>

            <textarea
                wire:model="recomendaciones"
                rows="3"
                placeholder="Ej: Llevar ropa abrigada, agua y protector solar..."
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>

            @error('recomendaciones')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- IMÁGENES -->
        <div class="mb-5">

            <label class="block text-sm font-semibold mb-2">
                Imágenes de la actividad
            </label>

            <input
                type="file"
                wire:model.live="imagenes"
                multiple
                class="w-full p-2 border rounded-lg bg-white text-black">

            @error('imagenes.*')
                <span class="text-red-500 text-sm">
                    {{ $message }}
                </span>
            @enderror

        </div>

        <!-- BOTONES -->
        <div class="flex justify-end gap-3">

            <button
                wire:click="cerrarModal"
                class="px-4 py-2 rounded-lg bg-gray-400 hover:bg-gray-500 text-white transition">
                Cancelar
            </button>

            <button
                wire:click="guardar"
                class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition">

                {{ $modoEdicion ? 'Actualizar' : 'Guardar' }}

            </button>

        </div>

    </div>

</div>

@endif

</div>
