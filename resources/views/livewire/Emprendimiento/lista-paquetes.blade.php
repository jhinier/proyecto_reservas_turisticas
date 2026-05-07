<div class="space-y-6">
    
    {{-- Encabezado y Botón Nuevo --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
            Mis {{ $nombreCategoria }}
        </h3>
        
        <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" wire:navigate 
           class="inline-flex items-center gap-2 rounded-lg bg-[#1a4031] px-4 py-2 text-sm font-medium text-white hover:bg-[#132f24] transition shadow-sm">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
            Nuevo Paquete
        </a>
    </div>

    {{-- Estado Vacío --}}
    @if($paquetes->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center flex flex-col items-center justify-center">
            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-full mb-4">
                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white">No hay paquetes turísticos</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-sm">Comienza a diseñar tu primer paquete para tus visitantes.</p>
        </div>

    @else
        <div class="flex flex-col gap-5">
            @foreach($paquetes as $paquete)
                <div class="group flex flex-col sm:flex-row bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    
                    {{-- 1. Zona de Imagen (Izquierda) --}}
                    <div class="relative w-full sm:w-72 h-56 sm:h-auto bg-gray-100 dark:bg-gray-900 shrink-0 overflow-hidden">
                        @if($paquete->imagenes && $paquete->imagenes->count() > 0)
                            <img src="{{ Storage::url($paquete->imagenes->first()->imagen) }}" 
                                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105" 
                                 alt="{{ $paquete->nombre }}">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50 dark:bg-gray-800/50">
                                <svg class="size-10 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        {{-- Badge Precio --}}
                        <div class="absolute top-3 left-3 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm px-3 py-1 rounded-lg text-sm font-extrabold text-[#1a4031] dark:text-green-400 shadow-sm">
                            ${{ number_format($paquete->precio, 2) }}
                        </div>
                    </div>

                    {{-- 2. Cuerpo de Contenido (Derecha) --}}
                    <div class="p-6 flex-1 flex flex-col">
                        
                        {{-- Título y Duración --}}
                        <div class="mb-5">
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white line-clamp-1">
                                {{ $paquete->nombre }}
                            </h4>
                            
                            <div class="flex items-center gap-1.5 mt-1.5 text-sm font-medium text-emerald-600 dark:text-emerald-400">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>
                                    {{ $paquete->detallePaqueteTuristico?->duracion_dias ?? 0 }} Días 
                                </span>
                            </div>
                        </div>

                        {{-- Grilla de Datos Técnicos (Enmarcada) --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 mb-5 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 shadow-inner">
                            
                            <div class="flex flex-col gap-1">
                                <span class="flex items-center gap-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Cupos Tot.
                                </span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $paquete->stock ?? '0' }}</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <span class="flex items-center gap-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Salida
                                </span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ $paquete->detallePaqueteTuristico?->hora_salida ? \Carbon\Carbon::parse($paquete->detallePaqueteTuristico->hora_salida)->format('H:i') : '--:--' }}
                                </span>
                            </div>

                            <div class="flex flex-col gap-1 md:col-span-1 col-span-2 border-l border-gray-200 dark:border-gray-700 pl-4">
                                <span class="flex items-center gap-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Punto Encuentro
                                </span>
                                <span class="text-sm font-semibold text-gray-800 dark:text-gray-200 line-clamp-1" title="{{ $paquete->detallePaqueteTuristico?->lugar_salida }}">
                                    {{ $paquete->detallePaqueteTuristico?->lugar_salida ?? 'Por definir' }}
                                </span>
                            </div>

                        </div>

                        {{-- Descripción / Itinerario --}}
                        <div class="mb-4">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">Itinerario / Detalles:</span>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                {{ $paquete->descripcion }}
                            </p>
                        </div>

                        {{-- Servicios Incluidos --}}
                        <div class="p-3 bg-sky-50/50 dark:bg-sky-900/20 border-l-4 border-sky-400 dark:border-sky-500 rounded-r-lg mb-4">
                            <span class="text-[10px] font-bold text-sky-800 dark:text-sky-300 uppercase tracking-widest block mb-1">
                                Servicios Incluidos
                            </span>
                            <p class="text-sm text-sky-900/80 dark:text-sky-100/70 italic line-clamp-2">
                                "{{ $paquete->detallePaqueteTuristico?->servicios_incluidos ?? 'Sin información detallada.' }}"
                            </p>
                        </div>

                        {{-- Acciones Finales (Botones Mejorados) --}}
                        <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100 dark:border-gray-700">
                            
                            {{-- Botón Galería --}}
                            <button @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })" 
                                    class="group flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-900/30 dark:hover:text-indigo-400 rounded-lg transition text-xs font-bold shadow-sm">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Galería
                            </button>

                            <div class="flex gap-2">
                                {{-- Botón EDITAR --}}
                                <button wire:click="editarServicio({{ $paquete->id }})" 
                                        type="button"
                                        class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-600 hover:bg-sky-100 dark:bg-sky-900/30 dark:text-sky-400 dark:hover:bg-sky-800/40 text-sm font-bold px-4 py-2 rounded-lg transition shadow-sm border border-sky-100 dark:border-sky-800/50">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </button>
                                
                                {{-- Botón BORRAR --}}
                                <button @click="$dispatch('abrir-modal-eliminar', { id: {{ $paquete->id }}, action: 'eliminarPaquete' })" 
                                        type="button"
                                        class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/40 text-sm font-bold px-4 py-2 rounded-lg transition shadow-sm border border-red-100 dark:border-red-800/50">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Borrar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        @if($paquetes->hasPages())
            <div class="mt-8">
                {{ $paquetes->links() }}
            </div>
        @endif

        {{-- EL MODAL AHORA ESTÁ FUERA DE TODO Y SIEMPRE SE CARGA --}}
        @livewire('emprendimiento.gestion-servicios.editar-paquete')
    @endif
</div>