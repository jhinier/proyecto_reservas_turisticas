<div class="min-w-0 space-y-6">
    
    {{-- Encabezado y Botón Nuevo --}}
    <div class="mb-6 flex flex-col items-start justify-between gap-4 lg:flex-row lg:items-center">
        <h3 class="text-xl font-gray text-[#06281E] dark:text-white tracking-wide">
            Mis {{ $nombreCategoria }}
        </h3>
        
        <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
            <x-selector-vista-servicios :vista="$vista" />

            <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" wire:navigate
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#00D65B] px-6 py-2.5 text-[10px] sm:text-xs font-bold tracking-widest text-[#06281E] hover:bg-[#00c052] transition-colors shadow-sm outline-none shrink-0 w-full sm:w-auto">
                <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                Nuevo Paquete
            </a>
        </div>
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
        @if($vista === 'lista')
            <div class="w-full max-w-full overflow-x-auto rounded-lg border border-outline bg-white shadow-sm dark:border-white/10 dark:bg-zinc-900">
                <table class="w-full min-w-[1120px] text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead class="border-b border-outline bg-surface-alt text-xs font-semibold uppercase text-on-surface-strong dark:border-white/10 dark:bg-zinc-800 dark:text-white">
                        <tr>
                            <th scope="col" class="p-4">Paquete</th>
                            <th scope="col" class="p-4">Detalles</th>
                            <th scope="col" class="p-4">Salida</th>
                            <th scope="col" class="p-4">Imágenes</th>
                            <th scope="col" class="p-4">Precio</th>
                            <th scope="col" class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-white/10">
                        @foreach($paquetes as $paquete)
                            @php($detalle = $paquete->detallePaqueteTuristico)
                            <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-zinc-900 dark:hover:bg-white/5" wire:key="paquete-lista-{{ $paquete->id }}">
                                <td class="p-4 align-middle">
                                    <div class="flex min-w-[230px] items-center gap-3">
                                        <button type="button"
                                                @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })"
                                                class="flex size-12 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-white/10 dark:bg-zinc-800"
                                                title="Abrir galería"
                                                aria-label="Abrir galería de {{ $paquete->nombre }}">
                                            @if($paquete->imagenes && $paquete->imagenes->isNotEmpty())
                                                <img src="{{ Storage::url($paquete->imagenes->first()->imagen) }}" alt="" class="h-full w-full object-cover">
                                            @else
                                                <svg class="size-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </button>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-[#06281E] dark:text-white">{{ $paquete->nombre }}</p>
                                            <span class="mt-1 inline-flex rounded-md border border-[#06281E]/20 px-2 py-0.5 text-[10px] font-semibold uppercase text-[#06281E] dark:border-[#00D65B]/30 dark:text-[#00D65B]">
                                                {{ $detalle?->duracion_dias ?? 0 }} día{{ ($detalle?->duracion_dias ?? 0) === 1 ? '' : 's' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="max-w-[340px] p-4 align-middle">
                                    <p class="line-clamp-2 whitespace-normal text-xs leading-relaxed text-gray-600 dark:text-gray-300" title="{{ $paquete->descripcion }}">
                                        {{ $paquete->descripcion ?? 'Sin descripción detallada.' }}
                                    </p>
                                    <p class="mt-1.5 line-clamp-1 whitespace-normal text-[11px] italic text-[#007f36] dark:text-green-300" title="{{ $detalle?->servicios_incluidos }}">
                                        Incluye: {{ $detalle?->servicios_incluidos ?? 'Sin información detallada.' }}
                                    </p>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="min-w-[170px] space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $detalle?->lugar_salida ?? 'Por definir' }}</p>
                                        <p>{{ $detalle?->hora_salida ? \Carbon\Carbon::parse($detalle->hora_salida)->format('H:i') : '--:--' }}</p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap p-4 align-middle">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200" title="{{ $paquete->imagenes->count() }} imágenes registradas">
                                        <svg class="size-4 text-[#00A344] dark:text-[#00D65B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $paquete->imagenes->count() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap p-4 align-middle font-bold text-[#00A344] dark:text-[#00D65B]">
                                    ${{ number_format($paquete->precio, 2) }}
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex min-w-[184px] items-center justify-end gap-2">
                                        <button type="button"
                                                @click="$dispatch('abrir-detalle-servicio', { servicioId: {{ $paquete->id }} })"
                                                title="Ver detalle"
                                                aria-label="Ver detalle de {{ $paquete->nombre }}"
                                                class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-gray-300 bg-white text-[#31552b] transition-colors hover:border-[#06281E] hover:bg-[#06281E] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-zinc-600 dark:bg-zinc-800 dark:text-green-300 dark:hover:bg-white dark:hover:text-[#06281E]">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                                @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })"
                                                title="Ver galería"
                                                aria-label="Ver galería"
                                                class="inline-flex size-9 items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-700 transition-colors hover:border-[#06281E] hover:bg-[#06281E] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-zinc-600 dark:bg-zinc-800 dark:text-gray-300 dark:hover:bg-white dark:hover:text-[#06281E]">
                                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </button>
                                        <button type="button"
                                                wire:click="editarServicio({{ $paquete->id }})"
                                                title="Editar paquete"
                                                aria-label="Editar paquete"
                                                class="inline-flex size-9 items-center justify-center rounded-lg border border-[#00D65B]/30 bg-[#00D65B]/10 text-[#00A344] transition-colors hover:bg-[#00D65B] hover:text-[#06281E] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:text-[#00D65B] dark:hover:text-[#06281E]">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                        <button type="button"
                                                @click="$dispatch('abrir-modal-eliminar', { id: {{ $paquete->id }}, action: 'eliminarPaquete' })"
                                                title="Borrar paquete"
                                                aria-label="Borrar paquete"
                                                class="inline-flex size-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition-colors hover:border-red-600 hover:bg-red-600 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
        <div class="mx-auto flex w-full max-w-5xl flex-col gap-4">
            @foreach($paquetes as $paquete)
                {{-- TARJETA COMPACTA Y PROFESIONAL --}}
                <div class="group flex flex-col md:flex-row bg-white dark:bg-zinc-900 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-white/10 overflow-hidden transition-all duration-300" wire:key="paquete-{{ $paquete->id }}">
                    
                    {{-- 1. Zona de Imagen (Izquierda - Ancho reducido para no ser tan alta) --}}
                    <div class="relative h-40 w-full shrink-0 cursor-pointer overflow-hidden bg-gray-100 dark:bg-zinc-800 md:h-auto md:w-[220px] lg:w-[240px]" @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })">
                        @if($paquete->imagenes && $paquete->imagenes->count() > 0)
                            <img src="{{ Storage::url($paquete->imagenes->first()->imagen) }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                 alt="{{ $paquete->nombre }}">
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-zinc-800/50 transition-colors group-hover:bg-gray-100 dark:group-hover:bg-zinc-800">
                                <svg class="mb-1.5 size-8 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest opacity-60">Sin foto</span>
                            </div>
                        @endif

                        {{-- Badge Precio flotante --}}
                        <div class="absolute left-2.5 top-2.5 rounded-md bg-white/95 px-2 py-1 text-[11px] font-black text-[#06281E] shadow-sm backdrop-blur-md dark:bg-zinc-900/95 dark:text-[#00D65B]">
                            ${{ number_format($paquete->precio, 2) }}
                        </div>
                    </div>

                    {{-- 2. Cuerpo de Contenido (Derecha - Padding reducido) --}}
                    <div class="flex flex-1 flex-col justify-between p-4 md:p-5">
                        
                        <div>
                            {{-- Etiqueta Superior --}}
                            <div class="mb-1.5">
                                <span class="inline-block border border-[#06281E] dark:border-[#00D65B] text-[#06281E] dark:text-[#00D65B] px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest rounded-sm">
                                    Paquete • {{ $paquete->detallePaqueteTuristico?->duracion_dias ?? 0 }} Días
                                </span>
                            </div>

                            {{-- Título --}}
                            <h4 class="mb-1.5 text-lg font-bold leading-tight text-[#06281E] dark:text-white md:text-xl">
                                {{ $paquete->nombre }}
                            </h4>

                            {{-- Metadata Limpia --}}
                            <div class="mb-3 flex flex-wrap items-center gap-x-3 gap-y-1.5 text-xs font-medium text-gray-600 dark:text-gray-400">
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
                            <div class="space-y-2">
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
                        <div class="mt-4 flex flex-wrap items-center justify-end gap-2 border-t border-gray-100 pt-3 dark:border-white/5">
                            
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
        @endif

        @if($paquetes->hasPages())
            <div class="mt-8">
                {{ $paquetes->links() }}
            </div>
        @endif

        {{-- EL MODAL AHORA ESTÁ FUERA DE TODO Y SIEMPRE SE CARGA --}}
        @livewire('emprendimiento.gestion-servicios.editar-paquete')
    @endif
</div>
