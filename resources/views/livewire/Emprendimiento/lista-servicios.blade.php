<div class="space-y-6">
    
    {{-- Botón Nuevo dinámico --}}
    <div class="flex justify-end pt-2 pb-4">
        <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" 
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#00D65B] px-6 py-2.5 text-[10px] sm:text-xs font-bold uppercase tracking-widest text-[#06281E] hover:bg-[#00c052] transition-colors shadow-sm outline-none shrink-0 w-full sm:w-auto">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
            Nuevo: {{ $nombreCategoria }}
        </a>
    </div>

    {{-- Rejilla de Cards --}}
    @if($servicios->isEmpty())
        <x-mensaje-sin-registros :nombrePestana="$nombreCategoria" />
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($servicios as $servicio)
                <x-servicio-card 
                :servicio="$servicio" 
                wire:key="servicio-{{ $servicio->id }}" />
            @endforeach
        </div>
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