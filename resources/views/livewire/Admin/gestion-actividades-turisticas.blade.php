<div class="p-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Actividades Turísticas</h2>
            <p class="text-slate-500 mt-1 text-sm">Gestiona la oferta de aventura y experiencias turísticas</p>
        </div>

        <button wire:click="abrirModal"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 font-semibold">
            <span class="text-lg">➕</span> Agregar Actividad
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="mb-6 p-4 bg-green-800 text-white rounded-2xl shadow-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($actividades as $actividad)
            <div class="group relative bg-white border border-emerald-100 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">

                <div class="relative h-52 overflow-hidden bg-slate-100">
                    @if ($actividad->publicacion->imagenes->first())
                        <img src="{{ asset('storage/' . $actividad->publicacion->imagenes->first()->imagen) }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:opacity-0">
                    @else
                        <div class="w-full h-full bg-emerald-5 flex items-center justify-center text-emerald-600/40 font-medium">
                            🖼 Sin imagen configurada
                        </div>
                    @endif

                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500">
                        <div x-data="{ index: 0 }" class="relative w-full h-full">
                            @foreach ($actividad->publicacion->imagenes->take(5) as $i => $img)
                                <img x-show="index === {{ $i }}" src="{{ asset('storage/' . $img->imagen) }}" class="absolute w-full h-full object-cover transition duration-300">
                            @endforeach

                            <button @click="index = (index === 0) ? {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }} : index - 1" class="absolute left-2 top-1/2 -translate-y-1/2 bg-slate-900/60 backdrop-blur-sm text-white w-7 h-7 flex items-center justify-center rounded-full hover:bg-slate-900 transition">‹</button>
                            <button @click="index = (index === {{ $actividad->publicacion->imagenes->take(5)->count() - 1 }}) ? 0 : index + 1" class="absolute right-2 top-1/2 -translate-y-1/2 bg-slate-900/60 backdrop-blur-sm text-white w-7 h-7 flex items-center justify-center rounded-full hover:bg-slate-900 transition">›</button>
                        </div>
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 group-hover:text-emerald-700 transition tracking-tight line-clamp-1">
                            {{ $actividad->publicacion->nombre }}
                        </h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2 leading-relaxed">
                            {{ $actividad->publicacion->descripcion }}
                        </p>

                        <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-sm text-slate-600">
                            <p class="flex items-center gap-2">
                                <span>⏱️</span> <strong class="text-slate-700">Duración:</strong>
                                <span class="bg-slate-50 border border-slate-200/60 px-2 py-0.5 rounded-lg text-xs font-medium">{{ $actividad->duracion_estimada }}</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span>🏔️</span> <strong class="text-slate-700">Dificultad:</strong>
                                <span class="px-2 py-0.5 rounded-lg text-xs font-bold tracking-wide uppercase bg-emerald-5 text-emerald-700 border border-emerald-200/60">{{ $actividad->dificultad }}</span>
                            </p>
                        </div>
                    </div>

                    @if($actividad->publicacion->imagenes->count() > 0)
                        <div class="flex flex-wrap gap-2 mt-4 pt-3 border-t border-slate-100">
                            @foreach ($actividad->publicacion->imagenes as $img)
                                <div class="relative group/thumb">
                                    <img src="{{ asset('storage/' . $img->imagen) }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 shadow-sm">
                                    <button wire:click="eliminarImagen({{ $img->id }})" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] opacity-0 group-hover/thumb:opacity-100 transition-all duration-200">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="p-3 grid grid-cols-3 gap-2 bg-emerald-50/40 border-t border-emerald-100/60">
                    
                    <button type="button"
                        x-on:click="$flux.modal('detalle-actividad-{{ $actividad->publicacion_id }}').show()"
                        title="Ver detalles"
                        class="bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 py-2.5 rounded-xl transition flex items-center justify-center text-lg shadow-sm">
                        👁
                    </button>

                    <button wire:click="editar({{ $actividad->publicacion_id }})"
                        class="bg-white hover:bg-slate-50 text-amber-600 border border-amber-200/70 py-2.5 rounded-xl transition font-semibold text-sm flex items-center justify-center gap-1 shadow-sm">
                        ✏️
                    </button>

                    <button wire:click="eliminarActividad({{ $actividad->publicacion_id }})"
                        onclick="return confirm('¿Estás segura de eliminar esta actividad?')"
                        class="bg-red-55 hover:bg-red-100 text-red-600 border border-red-200/60 py-2.5 rounded-xl transition font-semibold text-sm flex items-center justify-center gap-1">
                        🗑️
                    </button>
                </div>
            </div>

            <flux:modal name="detalle-actividad-{{ $actividad->publicacion_id }}" class="md:w-2/4">
                <div class="p-6 bg-white rounded-3xl text-slate-800">
                    <h2 class="text-2xl font-bold mb-2 text-slate-800 tracking-tight">{{ $actividad->publicacion->nombre }}</h2>
                    <div class="flex gap-4 my-3 text-xs">
                        <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md">⏱️ {{ $actividad->duracion_estimada }}</span>
                        <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-md font-bold">🏔️ {{ $actividad->dificultad }}</span>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">{{ $actividad->publicacion->descripcion }}</p>
                    
                    @if($actividad->recomendaciones)
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-sm mb-4">
                            <strong class="text-slate-800 block mb-1">🎒 Recomendaciones:</strong>
                            <p class="text-slate-600">{{ $actividad->recomendaciones }}</p>
                        </div>
                    @endif
                </div>
            </flux:modal>
        @endforeach

    </div>

    @if ($mostrarModal)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white text-slate-800 rounded-3xl p-6 sm:p-8 w-full max-w-2xl shadow-2xl border border-slate-100 overflow-y-auto max-h-[90vh] animate-in fade-in zoom-in-95 duration-200">
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
                            <input type="text" wire:model="duracion_estimada" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800">
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
                        <textarea wire:model="recomendaciones" rows="3" class="w-full p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-800"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Imágenes</label>
                        <input type="file" wire:model.live="imagenes" multiple class="w-full p-2.5 border border-slate-200 rounded-xl bg-slate-50 text-sm text-slate-600">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <button wire:click="cerrarModal" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm">Cancelar</button>
                    <button wire:click="guardar" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm">Guardar Actividad</button>
                </div>
            </div>
        </div>
    @endif

</div>
