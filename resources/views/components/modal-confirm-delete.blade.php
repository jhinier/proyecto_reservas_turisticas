<div x-data="{ open: false, itemId: null, actionName: 'eliminar' }"
     @abrir-modal-eliminar.window="open = true; itemId = $event.detail.id; actionName = $event.detail.action ?? 'eliminarServicio'"
     x-show="open"
     x-transition.opacity
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
     style="display: none;">
     
    <div @click.outside="open = false" class="w-full max-w-md rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        
        <div class="flex items-center gap-4 mb-4">
            <div class="bg-red-100 text-red-600 p-3 rounded-full dark:bg-red-500/20 dark:text-red-400 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Confirmar Eliminación</h3>
            </div>
        </div>
        
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">¿Estás seguro de que deseas eliminar este registro? Esta acción no se podrá deshacer.</p>
        
        <div class="flex justify-end gap-3">
            {{-- Botón Cancelar --}}
            <button type="button" @click="open = false"
                    class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 outline-none">
                Cancelar
            </button>

            {{-- Botón Eliminar --}}
            <button type="button" @click="$dispatch(actionName, { id: itemId }); open = false"
                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700 outline-none shadow-sm">
                Sí, Eliminar
            </button>
        </div>
    </div>
</div>