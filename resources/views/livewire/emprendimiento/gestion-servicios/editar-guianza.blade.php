<div x-data="{ show: @entangle('abierto') }" x-show="show" class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    <div class="bg-white dark:bg-gray-900 w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md z-20">
            <div>
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Editar Guianza</h3>
                <p class="text-xs text-gray-500 mt-1">Ajusta los detalles de tu servicio de guía.</p>
            </div>
            <button @click="show = false" type="button" class="p-1.5 hover:bg-gray-100 rounded-lg dark:hover:bg-gray-800 transition-colors text-gray-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 md:p-8 flex-1">
            <form wire:submit.prevent="actualizar" class="space-y-6">
                <section>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div wire:key="g-capacidad"><x-input-form id="numero_max_persona" label="Máximo de Personas (por Guía)" model="numero_max_persona" type="number" /></div>
                        <div wire:key="g-precio"><x-input-form id="precio" label="Precio ($)" model="precio" type="number" step="0.01" simbolo="$" /></div>
                        <div wire:key="g-stock"><x-input-form id="stock" label="Guías disponibles por día" model="stock" type="number" /></div>
                    </div>
                    <div wire:key="g-desc" class="mt-6">
                        <x-textarea-form id="descripcion" label="Lugares y rutas que puede guiar" model="descripcion" rows="4" />
                    </div>
                </section>
                <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-800 gap-3">
                    <button @click="show = false" type="button" class="rounded-xl bg-gray-100 px-6 py-2.5 text-sm font-medium">Cancelar</button>
                    <button type="submit" class="rounded-xl bg-sky-600 px-8 py-2.5 text-sm font-bold text-white shadow-lg shadow-sky-200">Confirmar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
