<div class="space-y-6">
    
    {{-- Encabezado y Botón Nuevo --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h3 class="text-xl font-gray text-[#06281E] dark:text-white tracking-wide">
            Mis {{ $nombreCategoria }}
        </h3>
        
        <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" wire:navigate 
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#00D65B] px-6 py-2.5 text-[10px] sm:text-xs font-bold  tracking-widest text-[#06281E] hover:bg-[#00c052] transition-colors shadow-sm outline-none shrink-0 w-full sm:w-auto">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
            Nuevo Paquete
        </a>
    </div>

    {{-- Estado Vacío --}}
    @if($paquetes->isEmpty())
        <div class="bg-gray-50/50 dark:bg-zinc-900 rounded-3xl shadow-sm border border-gray-200 dark:border-white/10 p-12 text-center flex flex-col items-center justify-center min-h-[300px]">
            <div class="bg-white dark:bg-zinc-800 p-4 rounded-full mb-4 shadow-sm border border-gray-100 dark:border-white/5">
                <svg class="h-10 w-10 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-base font-black text-[#06281E] dark:text-white uppercase tracking-wide">No hay paquetes turísticos</h3>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 font-medium max-w-sm">Comienza a diseñar tu primer paquete para tus visitantes.</p>
        </div>

    @else
        <div class="flex flex-col gap-5">
            @foreach($paquetes as $paquete)
                {{-- TARJETA COMPACTA Y PROFESIONAL --}}
                <div class="group flex flex-col md:flex-row bg-white dark:bg-zinc-900 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-white/10 overflow-hidden transition-all duration-300" wire:key="paquete-{{ $paquete->id }}">
                    
                    {{-- 1. Zona de Imagen (Izquierda - Ancho reducido para no ser tan alta) --}}
                    <div class="relative w-full md:w-[260px] lg:w-[300px] h-48 md:h-auto bg-gray-100 dark:bg-zinc-800 shrink-0 overflow-hidden cursor-pointer" @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })">
                        @if($paquete->imagenes && $paquete->imagenes->count() > 0)
                            <img src="{{ Storage::url($paquete->imagenes->first()->imagen) }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                 alt="{{ $paquete->nombre }}">
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-zinc-800/50 transition-colors group-hover:bg-gray-100 dark:group-hover:bg-zinc-800">
                                <svg class="size-10 mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">Sin foto</span>
                            </div>
                        @endif

                        {{-- Badge Precio flotante --}}
                        <div class="absolute top-3 left-3 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md px-2.5 py-1 rounded-lg text-xs font-black text-[#06281E] dark:text-[#00D65B] shadow-sm">
                            ${{ number_format($paquete->precio, 2) }}
                        </div>
                    </div>

                    {{-- 2. Cuerpo de Contenido (Derecha - Padding reducido) --}}
                    <div class="p-5 md:p-6 flex-1 flex flex-col justify-between">
                        
                        <div>
                            {{-- Etiqueta Superior --}}
                            <div class="mb-2">
                                <span class="inline-block border border-[#06281E] dark:border-[#00D65B] text-[#06281E] dark:text-[#00D65B] px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest rounded-sm">
                                    Paquete • {{ $paquete->detallePaqueteTuristico?->duracion_dias ?? 0 }} Días
                                </span>
                            </div>

                            {{-- Título --}}
                            <h4 class="text-xl md:text-2xl font-bold text-[#06281E] dark:text-white leading-tight mb-2">
                                {{ $paquete->nombre }}
                            </h4>

                            {{-- Metadata Limpia --}}
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs text-gray-600 dark:text-gray-400 font-medium mb-4">
                                <div class="flex items-center gap-1.5">
                                    <svg class="size-3.5 text-[#00A344]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="truncate max-w-[180px]" title="{{ $paquete->detallePaqueteTuristico?->lugar_salida }}">Punto: {{ $paquete->detallePaqueteTuristico?->lugar_salida ?? 'Por definir' }}</span>
                                </div>
                                <span class="text-gray-300 dark:text-gray-600">&bull;</span>
                                <div class="flex items-center gap-1.5">
                                    <svg class="size-3.5 text-[#00A344]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>Salida: {{ $paquete->detallePaqueteTuristico?->hora_salida ? \Carbon\Carbon::parse($paquete->detallePaqueteTuristico->hora_salida)->format('H:i') : '--:--' }}</span>
                                </div>
                                <span class="text-gray-300 dark:text-gray-600">&bull;</span>
                                <div class="flex items-center gap-1.5">
                                    <svg class="size-3.5 text-[#00A344]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    <span>Cupos: {{ $paquete->stock ?? '0' }}</span>
                                </div>
                            </div>

                            {{-- Textos Descriptivos --}}
                            <div class="space-y-3">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-900 dark:text-gray-300 uppercase tracking-widest">Itinerario / Detalles</span>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5 line-clamp-2 leading-relaxed">
                                        {{ $paquete->descripcion }}
                                    </p>
                                </div>
                                
                                <div>
                                    <span class="text-[10px] font-bold text-[#00A344] uppercase tracking-widest">Incluye</span>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5 line-clamp-1 italic">
                                        "{{ $paquete->detallePaqueteTuristico?->servicios_incluidos ?? 'Sin información detallada.' }}"
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Botones Profesionales --}}
                        <div class="mt-5 flex flex-wrap items-center justify-end gap-2.5 pt-4 border-t border-gray-100 dark:border-white/5">
                            
                            {{-- Botón Galería --}}
                            <button @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })" 
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-gray-300 text-gray-700 hover:-translate-y-0.5 hover:shadow-md hover:bg-[#06281E] hover:border-[#06281E] hover:text-white dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-white dark:hover:text-[#06281E] transition-all duration-300 outline-none cursor-pointer">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:inline">Galería</span>
                            </button>

                            {{-- Botón Editar --}}
                            <button wire:click="editarServicio({{ $paquete->id }})" 
                                    type="button"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#00D65B]/10 border border-[#00D65B]/30 text-[#00A344] hover:-translate-y-0.5 hover:shadow-md hover:bg-[#00D65B] hover:border-[#00D65B] hover:text-[#06281E] dark:bg-[#00D65B]/10 dark:border-[#00D65B]/20 dark:text-[#00D65B] dark:hover:bg-[#00D65B] dark:hover:text-[#06281E] transition-all duration-300 outline-none cursor-pointer">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:inline">Editar</span>
                            </button>
                            
                            {{-- Botón Borrar --}}
                            <button @click="$dispatch('abrir-modal-eliminar', { id: {{ $paquete->id }}, action: 'eliminarPaquete' })" 
                                    type="button"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 border border-red-200 text-red-600 hover:-translate-y-0.5 hover:shadow-md hover:bg-red-600 hover:border-red-600 hover:text-white dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white transition-all duration-300 outline-none cursor-pointer">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:inline">Borrar</span>
                            </button>
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