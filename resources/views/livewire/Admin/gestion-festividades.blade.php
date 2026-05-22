<div class="p-6">
    @if (session()->has('mensaje'))
        <div class="mb-4 p-4 bg-green-800 text-white rounded-2xl shadow-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Festividades</h1>
            <p class="text-slate-500 mt-1 text-sm">Gestiona eventos turísticos y sus actividades</p>
        </div>

        <button x-on:click="$flux.modal('modal-festividad').show()"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2 font-semibold">
            <span class="text-lg">➕</span> Nueva Festividad
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse($festividades as $festividad)
            @php $imagen = $festividad->publicacion->imagenes->first(); @endphp

                <div class="relative bg-white border border-emerald-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col">

                    <div class="relative">
                        @if($imagen)
                            <img src="{{ asset('storage/' . $imagen->imagen) }}"
                                 class="w-full h-52 object-cover">
                        @else
                            <div class="w-full h-52 bg-emerald-50 flex items-center justify-center text-emerald-600/40 font-medium">
                                🖼 Sin imagen configurada
                            </div>
                        @endif

                        <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-md px-3 py-1 rounded-full text-xs text-white font-medium">
                            {{ \Carbon\Carbon::parse($festividad->fecha_inicio)->format('d M') }}
                            -
                            {{ \Carbon\Carbon::parse($festividad->fecha_fin)->format('d M') }}
                        </div>
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 tracking-tight line-clamp-1">
                                {{ $festividad->publicacion->nombre }}
                            </h2>

                            <p class="text-slate-500 text-sm mt-2 line-clamp-2 leading-relaxed">
                                {{ $festividad->publicacion->descripcion }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100 text-xs">
                            <span class="text-emerald-600 font-semibold flex items-center gap-1.5">
                                📅 {{ $festividad->actividades->count() }} actividades
                            </span>

                            <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full border border-emerald-200/60 font-bold tracking-wide text-[10px] uppercase">
                                Activo
                            </span>
                        </div>
                    </div>

                    <div class="p-3 grid grid-cols-3 gap-2 bg-emerald-50/40 border-t border-emerald-100/60">

                        <button x-on:click="$flux.modal('detalle-{{ $festividad->publicacion_id }}').show()"
                            title="Ver detalles"
                            class="bg-white hover:bg-slate-50 text-slate-600 border border-slate-200 py-2.5 rounded-xl transition flex items-center justify-center text-lg shadow-sm">
                            👁
                        </button>

                        <button wire:click="seleccionarFestividad({{ $festividad->publicacion_id }})"
                            x-on:click="$flux.modal('modal-actividad').show()"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-xl transition font-semibold text-sm flex items-center justify-center gap-1 shadow-sm shadow-emerald-600/10">
                            <span>+</span> Actividad
                        </button>

                        <button wire:click="eliminar({{ $festividad->publicacion_id }})"
                            wire:confirm="¿Eliminar festividad?"
                            class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/60 py-2.5 rounded-xl transition font-medium text-sm flex items-center justify-center gap-1">
                            🗑 Eliminar
                        </button>

                    </div>
                </div>

            @empty
            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
                <div class="text-6xl mb-4">🎉</div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">No hay festividades</h2>
                <p class="text-slate-500">Agrega tu primera festividad turística</p>
            </div>
        @endforelse
    </div>

    <flux:modal name="modal-festividad" class="md:w-2/4">
        <div class="p-6 bg-white rounded-3xl text-slate-800">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">Nueva Festividad</h2>
            <form wire:submit.prevent="guardarFestividad" class="space-y-4">
                <input type="text" wire:model="nombre" placeholder="Nombre de la festividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                <textarea wire:model="descripcion" placeholder="Descripción" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 h-24"></textarea>
                
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" wire:model="fecha_inicio" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                    <input type="date" wire:model="fecha_fin" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                </div>

                <input type="file" wire:model="imagenes" multiple class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                <div wire:loading wire:target="imagenes" class="text-sm text-amber-600 font-medium">Cargando imágenes...</div>

                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white py-3 rounded-2xl font-bold transition shadow-lg">
                    Guardar Festividad
                </button>
            </form>
        </div>
    </flux:modal>

    <flux:modal name="modal-actividad" class="md:w-2/4">
        <div class="p-6 bg-white rounded-3xl text-slate-800">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">Nueva Actividad</h2>
            <form wire:submit.prevent="guardarActividad" class="space-y-4">
                <input type="text" wire:model="actividad_nombre" placeholder="Nombre de la actividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" wire:model="fecha" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                    <input type="time" wire:model="hora" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                </div>

                <input type="text" wire:model="lugar" placeholder="Lugar" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">
                <textarea wire:model="descripcion_actividad" placeholder="Descripción de la actividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800 h-20"></textarea>
                <input type="file" wire:model="imagen_actividad" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3 text-slate-800">

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-2xl font-bold transition shadow-lg">
                    Guardar Actividad
                </button>
            </form>
        </div>
    </flux:modal>

    <button type="button" 
            wire:click="$dispatch('abrirCalendario')"
            class="fixed bottom-8 right-8 z-40 bg-emerald-700 hover:bg-emerald-800 text-white shadow-2xl rounded-full px-6 py-3.5 font-bold text-base transition-all duration-300 hover:scale-105 flex items-center gap-2">
        📅 Calendario
    </button>

   @livewire('admin.festividades.calendario-festividades')
</div>