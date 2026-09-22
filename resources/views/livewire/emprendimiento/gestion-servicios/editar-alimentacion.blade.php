<div x-data="{ show: @entangle('abierto') }" x-show="show" class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    <div class="bg-white dark:bg-gray-900 w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
        
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md z-20">
            <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">Editar Alimentación</h3>
            <button @click="show = false" type="button" class="text-gray-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 md:p-8 flex-1">
            <form wire:submit.prevent="actualizar" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-form id="nombre" label="Nombre del Plato/Menú" model="nombre" />

                    <div class="flex flex-col gap-2">
                        <label for="tipo_alimentacion" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Alimentación</label>
                        <select id="tipo_alimentacion" wire:model="tipo_alimentacion" class="w-full bg-gray-50 border-gray-200 rounded-lg p-2.5 text-sm font-medium text-gray-700 focus:ring-black focus:border-black dark:bg-zinc-800 dark:border-gray-700 dark:text-white transition-all">
                            <option value="">-- Seleccione --</option>
                            <option value="Desayuno">Desayuno</option>
                            <option value="Almuerzo">Almuerzo</option>
                            <option value="Cena">Cena</option>
                            <option value="Plato a la Carta">Plato a la Carta</option>
                        </select>
                        @error('tipo_alimentacion') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <x-input-form id="lugar_alimentacion" label="Lugar donde se sirve" model="lugar_alimentacion" />
                    <x-input-form id="precio" label="Precio ($)" model="precio" type="number" step="0.01" simbolo="$" />
                </div>
                
                <x-textarea-form id="descripcion" label="Descripción e Ingredientes" model="descripcion" rows="3" />

                <div class="flex justify-end pt-6 border-t border-gray-100 gap-3">
                    <button @click="show = false" type="button" class="rounded-xl bg-gray-100 px-6 py-2.5">Cancelar</button>
                    <button type="submit" class="rounded-xl bg-sky-600 px-8 py-2.5 text-white font-bold">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
