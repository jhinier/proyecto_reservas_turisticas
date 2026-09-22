<div class="p-6">
    @if (session()->has('mensaje'))
        <div class="mb-4 p-4 bg-green-800 text-white rounded-2xl shadow-lg text-sm font-medium">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Festividades</h1>
            <p class="text-slate-500 mt-1 text-sm">Gestiona eventos turísticos y su cronograma multimedia</p>
        </div>

        <button x-on:click="$flux.modal('modal-festividad').show(); $wire.set('modoEditar', false); $wire.call('limpiarCampos');"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2 font-semibold text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva Festividad
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($festividades as $festividad)
            @php $imagenPortada = $festividad->publicacion->imagenes->first(); @endphp

            <div class="relative bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                
                <div>
                    <div class="relative">
                        @if($imagenPortada)
                            <img src="{{ asset('storage/' . $imagenPortada->imagen) }}" class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 bg-slate-50 flex items-center justify-center text-slate-400 font-medium text-xs">
                                🖼 Sin imágenes en galería
                            </div>
                        @endif

                        <!--
                        <div class="absolute top-2.5 right-2.5 bg-slate-900/80 backdrop-blur-md px-2.5 py-0.5 rounded-full text-[11px] text-white font-medium tracking-wide">
                            {{ \Carbon\Carbon::parse($festividad->fecha_inicio)->format('d M') }} - {{ \Carbon\Carbon::parse($festividad->fecha_fin)->format('d M') }}
                        </div>
                        -->
                        @php
                            $hoy = \Carbon\Carbon::now();
                            $inicio = \Carbon\Carbon::parse($festividad->fecha_inicio);
                            $fin = \Carbon\Carbon::parse($festividad->fecha_fin);

                            $bloqueado = $hoy->lt($inicio) || $hoy->gt($fin);
                        @endphp

                        <div class="absolute top-2.5 right-2.5 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-[11px] text-white font-medium tracking-wide">

                            <div>
                                <span class="text-slate-300">Inicio:</span>
                                {{ $inicio->format('d M') }}
                            </div>

                            <div>
                                <span class="text-slate-300">Fin:</span>
                                {{ $fin->format('d M') }}
                            </div>

                            @if($hoy->lt($inicio))
                                <div class="mt-1 text-yellow-300 font-semibold">
                                    🔒 Próximamente
                                </div>
                            @elseif($hoy->gt($fin))
                                <div class="mt-1 text-red-300 font-semibold">
                                    🔒 Finalizado
                                </div>
                            @else
                                <div class="mt-1 text-green-300 font-semibold">
                                    ✅ Disponible
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-4">
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight line-clamp-1">
                            {{ $festividad->publicacion->nombre }}
                        </h2>
                        <p class="text-slate-500 text-xs mt-1.5 line-clamp-2 leading-relaxed">
                            {{ $festividad->publicacion->descripcion }}
                        </p>
                        
                        <div class="mt-3 flex items-center justify-between text-[11px] font-semibold text-emerald-700 bg-emerald-50/60 px-2.5 py-1.5 rounded-lg border border-emerald-100/40">
                            <span class="flex items-center gap-1">📅 {{ $festividad->actividades->count() }} actividades</span>
                            <span>📸 {{ $festividad->publicacion->imagenes->count() }} fotos</span>
                        </div>
                    </div>
                </div>

                <div class="px-4 pb-4 pt-1 flex items-center justify-between gap-1.5 border-t border-slate-50 bg-slate-50/50">
                    
                    <button wire:click="abrirGaleria({{ $festividad->publicacion_id }})" 
                            title="Gestionar Galería"
                            class="flex-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/50 py-1.5 rounded-lg text-xs font-bold flex items-center justify-center gap-1 transition">
                        📸 <span class="hidden sm:inline">Galería</span>
                    </button>

                    <div class="flex items-center gap-1">
                        <button x-on:click="$flux.modal('detalle-{{ $festividad->publicacion_id }}').show()" 
                                title="Ver detalles" 
                                class="bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 p-1.5 rounded-lg transition shadow-sm flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>

                        <button wire:click="cargarFestividad({{ $festividad->publicacion_id }})" 
                                x-on:click="$flux.modal('modal-festividad').show()" 
                                title="Editar festividad" 
                                class="bg-white hover:bg-amber-50 text-amber-600 border border-amber-200 p-1.5 rounded-lg transition shadow-sm flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>

                        <button wire:click="seleccionarFestividad({{ $festividad->publicacion_id }})" 
                                x-on:click="$flux.modal('modal-actividad').show()" 
                                title="Agregar Actividad" 
                                class="bg-emerald-600 hover:bg-emerald-700 text-white p-1.5 rounded-lg transition shadow-sm flex items-center justify-center font-bold text-xs px-2">
                            + Act
                        </button>

                        <button wire:click="eliminar({{ $festividad->publicacion_id }})" 
                                wire:confirm="¿Eliminar festividad?" 
                                title="Eliminar" 
                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/50 p-1.5 rounded-lg transition flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>

                </div>
            </div>

            <flux:modal name="detalle-{{ $festividad->publicacion_id }}" class="md:w-2/4">
                <div class="p-6 bg-white rounded-3xl text-slate-800">
                    <h2 class="text-2xl font-bold mb-2 text-emerald-800">{{ $festividad->publicacion->nombre }}</h2>
                    <p class="text-xs text-slate-400 mb-4">Fechas: {{ $festividad->fecha_inicio }} al {{ $festividad->fecha_fin }}</p>
                    <h3 class="font-bold text-slate-700 mb-1 text-sm">Descripción:</h3>
                    <p class="text-slate-600 text-xs mb-6 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed">{{ $festividad->publicacion->descripcion }}</p>

                    <h3 class="font-bold text-slate-700 mb-3 text-sm">Cronograma de Actividades ({{ $festividad->actividades->count() }})</h3>
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        @forelse($festividad->actividades as $actividad)
                            <div class="p-3 bg-emerald-50/50 rounded-2xl border border-emerald-100/50 flex gap-3">
                                @if($actividad->imagen)
                                    <img src="{{ asset('storage/' . $actividad->imagen) }}" class="w-14 h-14 object-cover rounded-xl">
                                @endif
                                <div>
                                    <h4 class="font-semibold text-slate-800 text-xs">{{ $actividad->nombre }}</h4>
                                    <p class="text-[11px] text-emerald-700 font-medium mt-0.5">📍 {{ $actividad->lugar }} | 🕒 {{ $actividad->fecha }} ({{ $actividad->hora }})</p>
                                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $actividad->descripcion }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">No hay actividades registradas aún.</p>
                        @endforelse
                    </div>
                </div>
            </flux:modal>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-100 p-12 text-center">
                <div class="text-5xl mb-3">🎉</div>
                <h2 class="text-xl font-bold text-slate-800 mb-1">No hay festividades registradas</h2>
            </div>
        @endforelse
    </div>

    <flux:modal name="modal-festividad" class="md:w-2/4">
        <div class="p-6 bg-white rounded-3xl text-slate-800">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">{{ $modoEditar ? 'Editar Festividad' : 'Nueva Festividad' }}</h2>
            <form wire:submit.prevent="guardarFestividad" class="space-y-4">
                <input type="text" wire:model="nombre" placeholder="Nombre de la festividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm">
                <textarea wire:model="descripcion" placeholder="Descripción" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-24 text-sm"></textarea>
                <!--
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <input type="date" wire:model="fecha_inicio" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                    <input type="date" wire:model="fecha_fin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                </div>
                -->
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
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-2xl font-bold transition shadow-lg text-sm">
                    {{ $modoEditar ? 'Actualizar Festividad' : 'Guardar Festividad' }}
                </button>
            </form>
        </div>
    </flux:modal>

    <flux:modal name="modal-actividad" class="md:w-2/4">
        <div class="p-6 bg-white rounded-3xl text-slate-800">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">Nueva Actividad</h2>
            <form wire:submit.prevent="guardarActividad" class="space-y-4 text-sm">
                <input type="text" wire:model="actividad_nombre" placeholder="Nombre de la actividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" wire:model="fecha" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                    <input type="time" wire:model="hora" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                </div>
                <input type="text" wire:model="lugar" placeholder="Lugar" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                <textarea wire:model="descripcion_actividad" placeholder="Descripción de la actividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 h-20"></textarea>
                <input type="file" wire:model="imagen_actividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-2xl font-bold transition shadow-lg">Guardar Actividad</button>
            </form>
        </div>
    </flux:modal>

    <div x-data="{ show: @entangle('abierto') }" x-show="show" 
         class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/70 backdrop-blur-sm" style="display: none;">
        
        <div @click.outside="show = false" class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
            
            <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur z-20">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Gestor de Galería</h3>
                    <p class="text-xs text-emerald-600 font-bold mt-0.5">Festividad activa: {{ $festividadSeleccionada?->publicacion?->nombre }}</p>
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
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Fotografías en la Nube</h4>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @if($festividadSeleccionada && $festividadSeleccionada->publicacion)
                            @foreach($festividadSeleccionada->publicacion->imagenes as $imagen)
                                <div wire:key="img-cloud-{{ $imagen->id }}" class="group relative aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <img src="{{ asset('storage/' . $imagen->imagen) }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <button wire:click="eliminarImagen({{ $imagen->id }})" wire:confirm="¿Deseas eliminar permanentemente esta foto del servidor?" class="bg-red-500 text-white p-2 rounded-xl hover:bg-red-600 transition shadow-lg transform hover:scale-105">
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
                        <button wire:click="subirFotos" 
                                wire:loading.attr="disabled" 
                                @disabled(empty($nuevasImagenes))
                                class="w-full bg-[#1a4031] text-white py-3 rounded-2xl text-sm font-bold shadow-md hover:bg-[#132f24] transition disabled:opacity-40 disabled:cursor-not-allowed flex justify-center items-center gap-2">
                            <span wire:loading.remove wire:target="subirFotos">
                                {{ empty($nuevasImagenes) ? 'Selecciona fotos para guardar' : 'Sincronizar y Guardar en la Nube' }}
                            </span>
                            <span wire:loading wire:target="subirFotos">Guardando fotos...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" wire:click="$dispatch('abrirCalendario')" class="fixed bottom-8 right-8 z-40 bg-emerald-700 hover:bg-emerald-800 text-white shadow-2xl rounded-full px-6 py-3.5 font-bold text-base transition duration-300 hover:scale-105 flex items-center gap-2">
        📅 Calendario
    </button>

   @livewire('admin.festividades.calendario-festividades')
</div>