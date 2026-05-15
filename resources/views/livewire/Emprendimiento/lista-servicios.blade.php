<div class="space-y-6">
    {{-- Botón Nuevo dinámico --}}
    <div class="flex justify-end pt-4">
        <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" 
           class="inline-flex items-center gap-2 rounded-lg bg-[#1a4031] px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
            Nuevo: {{ $nombreCategoria }}
        </a>
    </div>

    {{-- Rejilla de Cards --}}
    @if($servicios->isEmpty())
        <x-mensaje-sin-registros :nombrePestana="$nombreCategoria" />
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($servicios as $servicio)
                <x-servicio-card 
                :servicio="$servicio" 
                wire:key="servicio-{{ $servicio->id }}" />
            @endforeach
        </div>
        <div class="mt-4">
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
         class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm"
         style="display: none;">
         
        <div @click.outside="open = false" 
             class="w-full max-w-md rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-red-100 text-red-600 p-3 rounded-full dark:bg-red-500/20 dark:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Confirmar Eliminación</h3>
            </div>
            
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                ¿Estás seguro de que deseas eliminar este registro? Esta acción no se podrá deshacer.
            </p>
            
            <div class="flex justify-end gap-3">
                <button @click="open = false" 
                        class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Cancelar
                </button>
                
                {{-- Ejecuta la acción en Livewire y cierra el modal --}}
                <button @click="$wire[actionName](itemId); open = false" 
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                    Sí, Eliminar
                </button>
            </div>
        </div>
    </div>

</div>