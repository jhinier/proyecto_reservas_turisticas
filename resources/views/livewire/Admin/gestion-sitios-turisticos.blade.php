<div class="p-6">

    <!-- TÍTULO + BOTÓN -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-300">Sitios Turísticos</h2>

        <button wire:click="abrirModal"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Agregar Sitio
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
    
        @foreach ($sitios as $sitio)
            <div class="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
    
                <!-- IMAGEN / CARRUSEL -->
                <div class="relative h-52 overflow-hidden">
    
                    <!-- IMAGEN PRINCIPAL -->
                    @if ($sitio->publicacion->imagenes->first())
                        <img src="{{ asset('storage/' . $sitio->publicacion->imagenes->first()->imagen) }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:opacity-0">
                    @endif
    
                    <!-- CARRUSEL -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500">
    
                        <div x-data="{ index: 0 }" class="relative w-full h-full">
    
                            @foreach ($sitio->publicacion->imagenes->take(5) as $i => $img)
                                <img x-show="index === {{ $i }}"
                                    src="{{ asset('storage/' . $img->imagen) }}"
                                    class="absolute w-full h-full object-cover transition">
                            @endforeach
    
                            <!-- BOTÓN IZQUIERDA -->
                            <button 
                                @click="index = (index === 0) ? {{ $sitio->publicacion->imagenes->take(5)->count() - 1 }} : index - 1"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 text-white px-2 py-1 rounded-full hover:bg-black/70">
                                ‹
                            </button>
    
                            <!-- BOTÓN DERECHA -->
                            <button 
                                @click="index = (index === {{ $sitio->publicacion->imagenes->take(5)->count() - 1 }}) ? 0 : index + 1"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 text-white px-2 py-1 rounded-full hover:bg-black/70">
                                ›
                            </button>
    
                        </div>
                    </div>
                </div>
    
                <!-- CONTENIDO -->
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition">
                        {{ $sitio->publicacion->nombre }}
                    </h3>

                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">
                        {{ $sitio->publicacion->descripcion }}
                    </p>

                    <div class="flex justify-end gap-2 mt-4">

                        <!-- EDITAR -->
                        <button
                            type="button"
                            wire:click="editar({{ $sitio->publicacion_id }})"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm shadow">
                            ✏️ Editar
                        </button>
                    
                        <!-- ELIMINAR -->
                        <button
                            type="button"
                            wire:click="eliminarSitio({{ $sitio->publicacion_id }})"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm shadow">
                            🗑️ Eliminar
                        </button>
                    
                    </div>
                </div>
    
            </div>
        @endforeach
    
    </div>


    <!-- MODAL -->
    @if ($mostrarModal)
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">

        <div class="bg-white dark:bg-zinc-800 text-gray-800 dark:text-white rounded-2xl p-8 w-full max-w-lg shadow-2xl border border-gray-200 dark:border-zinc-700">

            <!-- TÍTULO -->
            <h2 class="text-2xl font-bold mb-6 text-center">
               🌄 Registrar Sitio Turístico
            </h2>

            <!-- NOMBRE -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Nombre del lugar
                </label>
                <input type="text" wire:model="nombre"
                    placeholder="Ej: Volcán El Altar"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                    bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>

            <!-- DESCRIPCIÓN -->
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">
                    Descripción
                </label>
                <textarea wire:model="descripcion"
                    placeholder="Describe el atractivo turístico, actividades, clima, etc..."
                    rows="3"
                    class="w-full p-3 rounded-lg border border-gray-300 dark:border-zinc-600 
                    bg-gray-50 dark:bg-zinc-700 focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>
            </div>

            <div class="flex gap-2 mt-4">

            </div>

            <!-- IMÁGENES -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Imágenes del sitio
                </label>

                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-2">
                        Imágenes del sitio
                    </label>

                    <input 
                        type="file" 
                        wire:model.live="imagenes"
                        multiple
                        class="w-full p-2 border rounded-lg bg-white text-black"
                    >

                    @error('imagenes.*')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- BOTONES -->
            <div class="flex justify-end gap-3">
                <button wire:click="cerrarModal"
                    class="px-4 py-2 rounded-lg bg-gray-400 hover:bg-gray-500 text-white transition">
                    Cancelar
                </button>

                <button wire:click="guardar"
                    class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition">
                    {{ $modoEdicion ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>

        </div>

    </div>
    @endif

</div>