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

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach ($sitios as $sitio)
            @php $imagenPortada = $sitio->publicacion->imagenes->first(); @endphp

            <div class="group relative bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                
                <div>
                    <div class="relative h-44 overflow-hidden bg-slate-100">
                        @if ($imagenPortada)
                            <img src="{{ asset('storage/' . $imagenPortada->imagen) }}"
                                 class="w-full h-full object-cover transition duration-500 group-hover:opacity-0">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 font-medium text-xs">
                                🖼️ Sin imagen configurada
                            </div>
                        @endif

                        @if($sitio->publicacion->imagenes->count() > 0)
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500">
                                <div x-data="{ index: 0 }" class="relative w-full h-full">
                                    @foreach ($sitio->publicacion->imagenes->take(5) as $i => $img)
                                        <img x-show="index === {{ $i }}"
                                             src="{{ asset('storage/' . $img->imagen) }}"
                                             class="absolute w-full h-full object-cover transition duration-300">
                                    @endforeach

                                    <button @click.prevent="index = (index === 0) ? {{ $sitio->publicacion->imagenes->take(5)->count() - 1 }} : index - 1"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-slate-900/60 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs z-20">
                                        ‹
                                    </button>

                                    <button @click.prevent="index = (index === {{ $sitio->publicacion->imagenes->take(5)->count() - 1 }}) ? 0 : index + 1"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-slate-900/60 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs z-20">
                                        ›
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight line-clamp-1">
                            {{ $sitio->publicacion->nombre }}
                        </h3>
                        <p class="text-slate-500 text-xs mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $sitio->publicacion->descripcion }}
                        </p>
                    </div>
                </div>

                <div class="px-4 pb-4 pt-1 flex items-center justify-between gap-1.5 border-t border-slate-50 bg-slate-50/50">
                    
                    <button wire:click="abrirGaleria({{ $sitio->publicacion_id }})" 
                            title="Gestionar Fotos"
                            class="flex-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/50 py-1.5 rounded-lg text-xs font-bold flex items-center justify-center gap-1 transition">
                        📸 <span class="hidden sm:inline">Galería ({{ $sitio->publicacion->imagenes->count() }})</span>
                    </button>

                    <div class="flex items-center gap-1">
                        <button x-on:click="$flux.modal('detalle-sitio-{{ $sitio->publicacion_id }}').show()"
                                title="Ver detalles" 
                                class="bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 p-1.5 rounded-lg transition shadow-sm flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>

                        <button wire:click="editar({{ $sitio->publicacion_id }})"
                                title="Editar sitio" 
                                class="bg-white hover:bg-amber-50 text-amber-600 border border-amber-200 p-1.5 rounded-lg transition shadow-sm flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>

                        <button wire:click="eliminarSitio({{ $sitio->publicacion_id }})" 
                                wire:confirm="¿Seguro que deseas eliminar este sitio turístico?"
                                title="Eliminar sitio" 
                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/50 p-1.5 rounded-lg transition flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>

                </div>
            </div>

            <flux:modal name="detalle-sitio-{{ $sitio->publicacion_id }}" class="md:w-2/4">
                <div class="p-6 bg-white rounded-3xl text-slate-800">
                    <h2 class="text-2xl font-bold mb-2 tracking-tight text-emerald-800">
                        {{ $sitio->publicacion->nombre }}
                    </h2>
                    <h3 class="font-bold text-slate-700 mb-1 text-sm">Descripción:</h3>
                    <p class="text-slate-600 text-xs mb-6 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed">
                        {{ $sitio->publicacion->descripcion }}
                    </p>

                    <h3 class="font-bold text-slate-700 mb-3 text-sm">Galería de Imágenes</h3>
                    <div class="grid grid-cols-3 gap-2 mt-4 max-h-60 overflow-y-auto">
                        @forelse($sitio->publicacion->imagenes as $img)
                            <img src="{{ asset('storage/' . $img->imagen) }}"
                                 class="w-full h-24 object-cover rounded-xl border border-slate-100">
                        @empty
                            <p class="text-xs text-slate-400 col-span-3 italic">Este sitio no cuenta con fotos en su galería.</p>
                        @endforelse
                    </div>
                </div>
            </flux:modal>
        @endforeach
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