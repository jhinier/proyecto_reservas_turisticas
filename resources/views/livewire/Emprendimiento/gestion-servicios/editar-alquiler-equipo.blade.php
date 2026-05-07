<div x-data="{ show: @entangle('abierto') }" x-show="show" class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    <div @click.outside="show = false" class="bg-white dark:bg-gray-900 w-full max-w-3xl rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-200 dark:border-gray-800">
        
        <div class="p-4 border-b dark:border-gray-800 flex justify-between items-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-md">
            <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">Editar alquiler de equipo</h3>
            <button @click="show = false" type="button" class="text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 p-1 rounded-lg">
                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 md:p-8">
            <form wire:submit.prevent="actualizar" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-form id="nombre" label="Nombre del equipo" model="nombre" />
                    <x-input-form id="precio" label="Precio de alquiler ($)" model="precio" type="number" step="0.01" />
                    <x-input-form id="stock" label="Stock por Día (Unidades disponibles)" model="stock" type="number" />
                </div>

                <x-textarea-form id="descripcion" label="Estado y detalles del equipo" model="descripcion" rows="4" />

                <div class="flex justify-end pt-6 border-t dark:border-gray-800 gap-3">
                    <button @click="show = false" type="button" class="rounded-xl bg-gray-100 px-6 py-2.5 text-sm font-medium text-gray-700">
                        Cancelar
                    </button>
                    <button type="submit" class="rounded-xl bg-sky-600 px-8 py-2.5 text-sm font-bold text-white hover:bg-sky-700 transition shadow-lg shadow-sky-200">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>