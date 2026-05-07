<div x-data="{ show: @entangle('abierto') }" x-show="show" class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    <div @click.outside="show = false" class="bg-white dark:bg-gray-900 w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
        
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md z-20">
            <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">Editar Alimentación</h3>
            <button @click="show = false" type="button" class="text-gray-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 md:p-8 flex-1">
            <form wire:submit.prevent="actualizar" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-form id="nombre" label="Nombre del Plato" model="nombre" />
                    <x-input-form id="tipo_alimentacion" label="Tipo de Alimentaci\u00f3n" model="tipo_alimentacion" placeholder="Desayuno, Almuerzo, Cena..." />
                    <x-input-form id="precio" label="Precio ($)" model="precio" type="number" step="0.01" />
                    <x-input-form id="lugar_alimentacion" label="Lugar donde se sirve" model="lugar_alimentacion" />
                </div>
                
                <x-textarea-form id="descripcion" label="Ingredientes / Descripci\u00f3n" model="descripcion" rows="4" />

                <div class="flex justify-end pt-6 border-t border-gray-100 gap-3">
                    <button @click="show = false" type="button" class="rounded-xl bg-gray-100 px-6 py-2.5">Cancelar</button>
                    <button type="submit" class="rounded-xl bg-sky-600 px-8 py-2.5 text-white font-bold">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>