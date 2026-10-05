<div class="min-w-0 space-y-6">
    
    {{-- Selector de vista y botón Nuevo --}}
    <div class="flex flex-col gap-3 pb-4 pt-2 sm:flex-row sm:items-center sm:justify-end">
        <x-selector-vista-servicios :vista="$vista" />

        <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" 
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#00D65B] px-6 py-2.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#06281E] hover:bg-[#00c052] transition-colors shadow-sm outline-none shrink-0 w-full sm:w-auto">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
            Nuevo: {{ $nombreCategoria }}
        </a>
    </div>

    {{-- Servicios --}}
    @if($servicios->isEmpty())
        <x-mensaje-sin-registros :nombrePestana="$nombreCategoria" />
    @else
        @if($vista === 'lista')
            <div class="w-full max-w-full overflow-x-auto rounded-lg border border-outline bg-white shadow-sm dark:border-white/10 dark:bg-zinc-900">
                <table class="w-full min-w-[920px] text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead class="border-b border-outline bg-surface-alt text-xs font-semibold uppercase text-on-surface-strong dark:border-white/10 dark:bg-zinc-800 dark:text-white">
                        <tr>
                            <th scope="col" class="p-4">Servicio</th>
                            <th scope="col" class="p-4">Descripción</th>
                            <th scope="col" class="p-4">Precio</th>
                            <th scope="col" class="p-4">Imágenes</th>
                            <th scope="col" class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-white/10">
                        @foreach($servicios as $servicio)
                            @php($presentador = $servicio->presenter())
                            <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-zinc-900 dark:hover:bg-white/5" wire:key="servicio-lista-{{ $servicio->id }}">
                                <td class="p-4 align-middle">
                                    <div class="flex min-w-[220px] items-center gap-3">
                                        <div class="flex size-12 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-white/10 dark:bg-zinc-800">
                                            @if($presentador->imagenUrl())
                                                <img src="{{ $presentador->imagenUrl() }}" alt="{{ $servicio->nombre }}" class="h-full w-full object-cover">
                                            @else
                                                <x-icon-servicio-card :tipo="$presentador->tipoId()" class="size-6 text-[#00A344] dark:text-[#00D65B]" />
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-[#06281E] dark:text-white">{{ $servicio->nombre }}</p>
                                            <p class="mt-0.5 text-[11px] text-gray-500 dark:text-gray-400">{{ $nombreCategoria }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="max-w-[360px] p-4 align-middle">
                                    <p class="line-clamp-2 whitespace-normal text-xs leading-relaxed text-gray-600 dark:text-gray-300" title="{{ $servicio->descripcion }}">
                                        {{ $servicio->descripcion ?? 'Sin descripción detallada.' }}
                                    </p>
                                </td>
                                <td class="whitespace-nowrap p-4 align-middle font-bold text-[#00A344] dark:text-[#00D65B]">
                                    {{ $presentador->precio() }}
                                </td>
                                <td class="whitespace-nowrap p-4 align-middle">
                                    @if($servicio->permite_galeria)
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200" title="{{ $servicio->imagenes->count() }} imágenes registradas">
                                            <svg class="size-4 text-[#00A344] dark:text-[#00D65B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $servicio->imagenes->count() }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500">Sin galería</span>
                                    @endif
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                @click="$dispatch('abrir-detalle-servicio', { servicioId: {{ $servicio->id }} })"
                                                title="Ver detalle"
                                                aria-label="Ver detalle de {{ $servicio->nombre }}"
                                                class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-gray-300 bg-white text-[#31552b] transition-all hover:-translate-y-0.5 hover:border-[#06281E] hover:bg-[#06281E] hover:text-white hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-zinc-600 dark:bg-zinc-800 dark:text-green-300 dark:hover:bg-white dark:hover:text-[#06281E]">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <x-botones-servicio-card :servicio="$servicio" :solo-iconos="true" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($servicios as $servicio)
                    <x-servicio-card
                    :servicio="$servicio"
                    wire:key="servicio-{{ $servicio->id }}" />
                @endforeach
            </div>
        @endif

        <div class="mt-8">
            {{ $servicios->links() }}
        </div>
    @endif

    {{-- ======================================================== --}}
    {{-- ZONA DE MODALES (INVISIBLES HASTA QUE SE ACTIVAN)        --}}
    {{-- ======================================================== --}}

    {{-- 1. Modal de Edición de Hospedaje --}}
    @livewire('emprendimiento.gestion-servicios.editar-hospedaje')
    @livewire('emprendimiento.gestion-servicios.editar-alimentacion')
    @livewire('emprendimiento.gestion-servicios.editar-guianza')
    @livewire('emprendimiento.gestion-servicios.editar-alquiler-equipo')

    {{-- 2. Modal de Confirmación de Eliminación --}}
    <div x-data="{ open: false, itemId: null, actionName: 'eliminarServicio' }"
         @abrir-modal-eliminar.window="open = true; itemId = $event.detail.id; actionName = $event.detail.action ?? 'eliminarServicio'"
         x-show="open"
         x-transition.opacity
         class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
         style="display: none;">
         
        <div @click.outside="open = false" 
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="w-full max-w-md rounded-3xl bg-white p-6 md:p-8 shadow-2xl dark:bg-zinc-900 border border-gray-100 dark:border-white/10">
            
            <div class="flex items-center gap-4 mb-6">
                <div class="bg-red-50 text-red-600 p-3.5 rounded-2xl dark:bg-red-500/10 dark:text-red-400 shrink-0 border border-red-100 dark:border-red-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-[#06281E] dark:text-white uppercase tracking-wide">Confirmar Borrado</h3>
                </div>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-8 font-medium leading-relaxed">
                ¿Estás seguro de que deseas eliminar este registro? Esta acción es definitiva y no se podrá deshacer.
            </p>
            
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-5 border-t border-gray-100 dark:border-white/5">
                <button @click="open = false" 
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-700 rounded-full text-[11px] font-bold uppercase tracking-widest transition-all outline-none">
                    Cancelar
                </button>
                
                {{-- Ejecuta la acción en Livewire y cierra el modal --}}
                <button @click="$wire[actionName](itemId); open = false" 
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-red-50 border border-red-100 text-red-600 hover:bg-red-600 hover:text-white hover:border-red-600 dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white rounded-full text-[11px] font-bold uppercase tracking-widest transition-all shadow-sm outline-none">
                    Sí, Eliminar
                </button>
            </div>
        </div>
    </div>

</div>
