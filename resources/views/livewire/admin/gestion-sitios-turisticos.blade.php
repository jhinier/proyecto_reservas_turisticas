 <div class="p-6">
    @if (session()->has('mensaje'))
        <div class="mb-4 p-4 bg-green-800 text-white rounded-2xl shadow-lg text-sm font-medium">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Sitios Turísticos</h1>
            <p class="text-slate-500 mt-1 text-sm">Gestiona los atractivos turísticos de la región</p>
        </div>

        <button wire:click="abrirModal"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 font-semibold text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Agregar Sitio
        </button>
    </div>

    {{-- TABLA DE SITIOS TURÍSTICOS --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    
            {{-- Encabezado de tabla --}}
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/70">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800">
                            Sitios registrados
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Listado de atractivos turísticos registrados en el sistema
                        </p>
                    </div>
    
                    <div class="bg-emerald-50 text-emerald-700 border border-emerald-100
                                px-3 py-1.5 rounded-xl text-xs font-bold">
                        {{ $sitios->count() }}
                        {{ $sitios->count() == 1 ? 'sitio' : 'sitios' }}
                    </div>
                </div>
            </div>
    
            {{-- Contenedor responsive --}}
            <div class="overflow-x-auto">
    
                <table class="w-full min-w-[900px] text-left">
    
                    {{-- CABECERA --}}
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
    
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Sitio turístico
                            </th>
    
                            <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Descripción
                            </th>
    
                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Imágenes
                            </th>
    
                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Galería
                            </th>
    
                            <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                Acciones
                            </th>
    
                        </tr>
                    </thead>
    
                    {{-- CUERPO --}}
                    <tbody class="divide-y divide-slate-100">
    
                        @forelse ($sitios as $sitio)
    
                            @php
                                $imagenPortada = $sitio->publicacion->imagenes->first();
                            @endphp
    
                            <tr class="hover:bg-slate-50/80 transition duration-200">
    
                                {{-- SITIO --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
    
                                        {{-- Miniatura --}}
                                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100
                                                    border border-slate-200 flex-shrink-0">
    
                                            @if ($imagenPortada)
    
                                                <img
                                                    src="{{ asset('storage/' . $imagenPortada->imagen) }}"
                                                    alt="{{ $sitio->publicacion->nombre }}"
                                                    class="w-full h-full object-cover"
                                                >
    
                                            @else
    
                                                <div class="w-full h-full flex items-center justify-center
                                                            text-slate-400">
    
                                                    <svg class="w-6 h-6"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         viewBox="0 0 24 24">
    
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
                                                {{ $sitio->publicacion->nombre }}
                                            </p>
    
                                            <p class="text-[11px] text-slate-400 mt-1">
                                                ID #{{ $sitio->publicacion_id }}
                                            </p>
    
                                        </div>
    
                                    </div>
                                </td>
    
    
                                {{-- DESCRIPCIÓN --}}
                                <td class="px-6 py-4">
    
                                    <p class="text-xs text-slate-500 leading-relaxed max-w-[320px] line-clamp-2">
                                        {{ $sitio->publicacion->descripcion ?: 'Sin descripción registrada' }}
                                    </p>
    
                                </td>
    
    
                                {{-- IMÁGENES --}}
                                <td class="px-6 py-4 text-center">
    
                                    <span class="inline-flex items-center justify-center
                                                 min-w-[34px] h-8 px-2 rounded-lg
                                                 bg-slate-100 text-slate-700
                                                 border border-slate-200
                                                 text-xs font-bold">
    
                                        {{ $sitio->publicacion->imagenes->count() }}
    
                                    </span>
    
                                </td>
    
    
                                {{-- GALERÍA --}}
                                <td class="px-6 py-4 text-center">
    
                                    <button
                                        wire:click="abrirGaleria({{ $sitio->publicacion_id }})"
                                        title="Gestionar Fotos"
                                        class="inline-flex items-center gap-1.5
                                               bg-emerald-50 hover:bg-emerald-100
                                               text-emerald-800
                                               border border-emerald-200
                                               px-3 py-2 rounded-lg
                                               text-xs font-bold
                                               transition duration-200
                                               hover:shadow-sm">
    
                                        <svg class="w-4 h-4"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
    
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"
                                            />
    
                                            <circle
                                                cx="8.5"
                                                cy="8.5"
                                                r="1.5"
                                                stroke-width="1.5"
                                            />
    
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M4 16l4-4 3 3 2-2 7 6"
                                            />
    
                                        </svg>
    
                                        Gestionar
    
                                    </button>
    
                                </td>
    
    
                                {{-- ACCIONES --}}
                                <td class="px-6 py-4">
    
                                    <div class="flex items-center justify-center gap-2">
    
                                        {{-- VER DETALLES --}}
                                        <button
                                            x-on:click="$flux.modal('detalle-sitio-{{ $sitio->publicacion_id }}').show()"
                                            title="Ver detalles"
                                            class="w-9 h-9 inline-flex items-center justify-center
                                                   bg-white hover:bg-slate-100
                                                   text-slate-600
                                                   border border-slate-200
                                                   rounded-lg
                                                   transition duration-200
                                                   shadow-sm">
    
                                            <svg class="w-4 h-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
    
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
                                            wire:click="editar({{ $sitio->publicacion_id }})"
                                            title="Editar sitio"
                                            class="w-9 h-9 inline-flex items-center justify-center
                                                   bg-white hover:bg-amber-50
                                                   text-amber-600
                                                   border border-amber-200
                                                   rounded-lg
                                                   transition duration-200
                                                   shadow-sm">
    
                                            <svg class="w-4 h-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
    
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
                                            wire:click="eliminarSitio({{ $sitio->publicacion_id }})"
                                            wire:confirm="¿Seguro que deseas eliminar este sitio turístico?"
                                            title="Eliminar sitio"
                                            class="w-9 h-9 inline-flex items-center justify-center
                                                   bg-red-50 hover:bg-red-100
                                                   text-red-600
                                                   border border-red-200
                                                   rounded-lg
                                                   transition duration-200">
    
                                            <svg class="w-4 h-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
    
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
                                                    d="M10 11v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
    
                                            </svg>
    
                                        </button>
    
                                    </div>
    
                                </td>
    
                            </tr>
    
                            {{-- MODAL DE DETALLES --}}
                            <flux:modal
                                name="detalle-sitio-{{ $sitio->publicacion_id }}"
                                class="md:w-2/4"
                            >
    
                                <div class="p-6 bg-white rounded-3xl text-slate-800">
    
                                    <h2 class="text-2xl font-bold mb-2 tracking-tight text-emerald-800">
                                        {{ $sitio->publicacion->nombre }}
                                    </h2>
    
                                    <h3 class="font-bold text-slate-700 mb-1 text-sm">
                                        Descripción:
                                    </h3>
    
                                    <p class="text-slate-600 text-xs mb-6 bg-slate-50 p-3 rounded-xl
                                              border border-slate-100 leading-relaxed">
                                        {{ $sitio->publicacion->descripcion }}
                                    </p>
    
                                    <h3 class="font-bold text-slate-700 mb-3 text-sm">
                                        Galería de Imágenes
                                    </h3>
    
                                    <div class="grid grid-cols-3 gap-2 mt-4 max-h-60 overflow-y-auto">
    
                                        @forelse($sitio->publicacion->imagenes as $img)
    
                                            <img
                                                src="{{ asset('storage/' . $img->imagen) }}"
                                                class="w-full h-24 object-cover rounded-xl border border-slate-100"
                                            >
    
                                        @empty
    
                                            <p class="text-xs text-slate-400 col-span-3 italic">
                                                Este sitio no cuenta con fotos en su galería.
                                            </p>
    
                                        @endforelse
    
                                    </div>
    
                                </div>
    
                            </flux:modal>
    
                        @empty
    
                            {{-- SIN REGISTROS --}}
                            <tr>
    
                                <td colspan="5" class="px-6 py-14 text-center">
    
                                    <div class="flex flex-col items-center justify-center">
    
                                        <div class="w-14 h-14 rounded-2xl bg-slate-100
                                                    flex items-center justify-center mb-3">
    
                                            <svg class="w-7 h-7 text-slate-400"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">
    
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M19 11H5m14 0l-4-4m4 4l-4 4"
                                                />
    
                                            </svg>
    
                                        </div>
    
                                        <p class="text-sm font-semibold text-slate-600">
                                            No hay sitios turísticos registrados
                                        </p>
    
                                        <p class="text-xs text-slate-400 mt-1">
                                            Utiliza el botón "Agregar Sitio" para registrar uno.
                                        </p>
    
                                    </div>
    
                                </td>
    
                            </tr>
    
                        @endforelse
    
                    </tbody>
    
                </table>
    
            </div>
    
        </div>
    

    @if ($mostrarModal)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-lg shadow-2xl border border-slate-100">
                <h2 class="text-2xl font-bold mb-6 text-slate-800">
                    {{ $modoEdicion ? '📝 Actualizar Sitio Turístico' : '🌄 Registrar Sitio Turístico' }}
                </h2>

                <div class="space-y-4">
                    <input type="text" wire:model="nombre" placeholder="Nombre del sitio"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">

                    <textarea wire:model="descripcion" rows="3"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-24 text-sm"
                        placeholder="Descripción corta del atractivo..."></textarea>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="cerrarModal" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-semibold transition hover:bg-slate-200">
                        Cancelar
                    </button>
                    <button wire:click="guardar" class="px-6 py-2.5 rounded-xl bg-emerald-700 text-white text-sm font-bold shadow-md transition hover:bg-emerald-800">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div x-data="{ show: @entangle('abierto') }" x-show="show" 
         class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm" style="display: none;">
        
        <div @click.outside="show = false" class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
            
            <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur z-20">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Gestor de Galería Fotográfica</h3>
                    <p class="text-xs text-emerald-600 font-bold mt-0.5">Sitio seleccionado: {{ $sitioSeleccionado?->publicacion?->nombre }}</p>
                </div>
                <button @click="show = false" class="p-2 hover:bg-gray-100 rounded-xl dark:hover:bg-gray-800 transition text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <div class="p-6 flex-1">
                @if (session()->has('mensaje_galeria'))
                    <div class="mb-4 p-3.5 bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm">
                        {{ session('mensaje_galeria') }}
                    </div>
                @endif

                <div class="mb-8">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Imágenes en el Servidor</h4>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @if($sitioSeleccionado && $sitioSeleccionado->publicacion)
                            @foreach($sitioSeleccionado->publicacion->imagenes as $imagen)
                                <div wire:key="img-cloud-{{ $imagen->id }}" class="group relative aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <img src="{{ asset('storage/' . $imagen->imagen) }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <button wire:click="eliminarImagen({{ $imagen->id }})" wire:confirm="¿Deseas remover permanentemente esta imagen?" class="bg-red-500 text-white p-2 rounded-xl hover:bg-red-600 transition shadow-lg transform hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                        id="upload-galeria-sitios" 
                        label="Subir Nuevas Fotos al Atractivo" 
                        model="nuevasImagenes" 
                        :imagesArray="$nuevasImagenes" 
                        deleteMethod="removerTemporal"
                        helpText="Formatos admitidos: PNG, JPG o WEBP (Máx. 5MB)"
                    />

                    @error('nuevasImagenes.*') 
                        <div class="mt-2 text-xs text-red-600 font-bold bg-red-50 p-2 rounded-lg border border-red-100">
                            ⚠️ {{ $message }}
                        </div>
                    @enderror

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                        <button wire:click="subirFotos" 
                                wire:loading.attr="disabled" 
                                @disabled(empty($nuevasImagenes))
                                class="w-full bg-[#1a4031] text-white py-3 rounded-2xl text-sm font-bold shadow-md hover:bg-[#132f24] transition disabled:opacity-40 disabled:cursor-not-allowed flex justify-center items-center gap-2">
                            <span wire:loading.remove wire:target="subirFotos">
                                {{ empty($nuevasImagenes) ? 'Adjunta fotos para subir' : 'Guardar y Sincronizar Galería' }}
                            </span>
                            <span wire:loading wire:target="subirFotos">Sincronizando archivos...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>