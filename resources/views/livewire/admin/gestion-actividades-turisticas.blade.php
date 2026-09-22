<div class="p-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Actividades Turísticas</h2>
            <p class="text-slate-500 mt-1 text-sm">Gestiona la oferta de aventura, deportes y experiencias</p>
        </div>

        <button wire:click="abrirModal"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-3 rounded-2xl shadow-md transition-all duration-300 flex items-center justify-center gap-2 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg> 
            Agregar Actividad
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="mb-6 p-4 bg-emerald-800 text-white rounded-2xl shadow-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($actividades as $actividad)
            <div class="group relative bg-white border border-emerald-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">

                <div class="relative h-52 overflow-hidden bg-slate-100">
                    @if ($actividad->publicacion->imagenes->first())
                        <img src="{{ asset('storage/' . $actividad->publicacion->imagenes->first()->imagen) }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:opacity-0">
                    @else
                        <div class="w-full h-full bg-emerald-5/40 flex items-center justify-center text-emerald-600/40 font-medium">
                            🖼 Sin imagen configurada
                        </div>
                    @endif

                    @if($actividad->publicacion->imagenes->count() > 0)
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500">
                            <div x-data="{ index: 0 }" class="relative w-full h-full">
                                @foreach ($actividad->publicacion->imagenes->take(5) as $i => $img)
                                    <img x-show="index === {{ $i }}" src="{{ asset('storage/' . $img->imagen) }}" class="absolute w-full h-full object-cover">
                                @endforeach
                                @if($actividad->publicacion->imagenes->count() > 1)
                                    <button @click.prevent="index = (index === 0) ? {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }} : index - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-slate-900/60 text-white w-7 h-7 flex items-center justify-center rounded-full">‹</button>
                                    <button @click.prevent="index = (index === {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }}) ? 0 : index + 1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-slate-900/60 text-white w-7 h-7 flex items-center justify-center rounded-full">›</button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 line-clamp-1">
                            {{ $actividad->publicacion->nombre }}
                        </h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2 leading-relaxed">
                            {{ $actividad->publicacion->descripcion }}
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                            <p>⏱️ <strong>Duración:</strong> {{ $actividad->duracion_estimada }}</p>
                            <p>🏔️ <strong>Dificultad:</strong> <span class="font-bold text-emerald-700">{{ $actividad->dificultad }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="p-3 grid grid-cols-3 gap-2 bg-slate-50 border-t border-slate-100">
                    
                    <button type="button"
                        x-on:click="$flux.modal('detalle-actividad-{{ $actividad->publicacion_id }}').show()"
                        title="Ver detalles"
                        class="bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 py-2.5 rounded-xl transition flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>

                    <button type="button"
                        wire:click="editar({{ $actividad->publicacion_id }})"
                        title="Editar Actividad"
                        class="bg-white hover:bg-amber-50 text-amber-600 border border-amber-200 py-2.5 rounded-xl transition flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>

                    <button type="button"
                        wire:click="eliminarActividad({{ $actividad->publicacion_id }})"
                        wire:confirm="¿Estás segura de eliminar esta actividad por completo?"
                        title="Eliminar"
                        class="bg-white hover:bg-red-50 text-red-600 border border-red-200 py-2.5 rounded-xl transition flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>

            <flux:modal name="detalle-actividad-{{ $actividad->publicacion_id }}" class="md:w-2/4">
                <div class="p-4 text-slate-800">
                    <h2 class="text-2xl font-bold mb-2">{{ $actividad->publicacion->nombre }}</h2>
                    <p class="text-slate-600 text-sm mb-4 leading-relaxed">{{ $actividad->publicacion->descripcion }}</p>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm space-y-2">
                        <p><strong>🎒 Recomendaciones de viaje:</strong> {{ $actividad->recomendaciones }}</p>
                    </div>
                </div>
            </flux:modal>
        @endforeach

    </div>

    @if ($mostrarModal)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white text-slate-800 rounded-3xl p-6 sm:p-8 w-full max-w-2xl shadow-2xl border border-slate-100 overflow-y-auto max-h-[90vh]">
                <h2 class="text-2xl font-bold mb-6 text-slate-800 tracking-tight">
                    {{ $modoEdicion ? '📝 Editar Actividad Turística' : '🌄 Registrar Actividad Turística' }}
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre de la actividad</label>
                        <input type="text" wire:model="nombre" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Descripción</label>
                        <textarea wire:model="descripcion" rows="3" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800"></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Duración estimada</label>
                            <input type="text" wire:model="duracion_estimada" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800" placeholder="Ej: 2 horas">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Dificultad</label>
                            <select wire:model="dificultad" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800">
                                <option value="">Seleccione</option>
                                <option value="Fácil">Fácil</option>
                                <option value="Media">Media</option>
                                <option value="Difícil">Difícil</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Recomendaciones</label>
                        <textarea wire:model="recomendaciones" rows="2" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800"></textarea>
                    </div>

                    @if($modoEdicion && count($imagenesGuardadas) > 0)
                        <div class="p-4 bg-slate-50 border border-slate-200/60 rounded-2xl">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Imágenes en el servidor (Presiona la X para borrarlas)</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($imagenesGuardadas as $img)
                                    <div class="relative group/thumb">
                                        <img src="{{ asset('storage/' . $img->imagen) }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shadow-sm transition group-hover/thumb:brightness-75">
                                        <button type="button" 
                                            wire:click="eliminarImagen({{ $img->id }})" 
                                            class="absolute -top-1.5 -right-1.5 bg-red-500 hover:bg-red-600 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shadow-md transition">
                                            ✕
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            {{ $modoEdicion ? 'Añadir más imágenes a la galería' : 'Subir Imágenes iniciales' }}
                        </label>
                        <input type="file" wire:model.live="imagenes" multiple class="w-full p-2.5 border border-slate-200 rounded-xl bg-slate-50 text-sm text-slate-600">
                        <div wire:loading wire:target="imagenes" class="text-xs text-emerald-700 mt-1">Cargando archivos multimedia...</div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <button type="button" wire:click="cerrarModal" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm">Cancelar</button>
                    <button type="button" wire:click="guardar" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm">
                        {{ $modoEdicion ? 'Actualizar Cambios' : 'Guardar Actividad' }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
