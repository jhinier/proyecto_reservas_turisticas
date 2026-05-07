<div x-data="{ show: @entangle('abierto') }" x-show="show" 
     class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    
    {{-- Contenedor del Modal --}}
    <div @click.outside="show = false" class="bg-white dark:bg-gray-900 w-full max-w-3xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
        
        {{-- Header Compacto del Modal --}}
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md z-20">
            <div>
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Editar Hospedaje</h3>
                <p class="text-xs text-gray-500 mt-1">Refina la información de tu habitación.</p>
            </div>
            
            {{-- Botón X para cerrar --}}
            <button @click="show = false" type="button" class="p-1.5 hover:bg-gray-100 rounded-lg dark:hover:bg-gray-800 transition-colors text-gray-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Cuerpo del Formulario --}}
        <div class="p-6 md:p-8 flex-1">
            <form wire:submit.prevent="actualizar" class="space-y-6">
                
                <section>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div wire:key="f-nombre"><x-input-form id="nombre" label="Nombre de la Habitación" model="nombre" /></div>
                        <div wire:key="f-capacidad"><x-input-form id="capacidad" label="Capacidad (Personas)" model="capacidad" type="number" /></div>
                        <div wire:key="f-precio"><x-input-form id="precio" label="Precio por Noche ($)" model="precio" type="number" step="0.01" simbolo="$" /></div>
                        <div wire:key="f-stock"><x-input-form id="stock" label="Stock por Día (Disponibles)" model="stock" type="number" /></div>
                    </div>
                    
                    <div wire:key="f-desc" class="mt-6">
                        <x-textarea-form id="descripcion" label="Descripción detallada" model="descripcion" rows="4" />
                    </div>
                </section>
                
                {{-- Footer: Acciones --}}
                <div wire:key="edit-actions" class="flex justify-end pt-6 mt-2 border-t border-gray-100 dark:border-gray-800 gap-3">
                    
                    {{-- Botón Cancelar --}}
                    <button @click="show = false" type="button" class="rounded-xl bg-gray-100 px-6 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancelar
                    </button>

                    {{-- Botón Guardar --}}
                    <button type="submit" 
                            wire:loading.attr="disabled" 
                            wire:target="actualizar" 
                            class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-8 py-2.5 text-sm font-bold text-white transition hover:bg-sky-700 disabled:opacity-50 shadow-lg shadow-sky-200 dark:shadow-none">
                        <span wire:loading.remove wire:target="actualizar">Confirmar Cambios</span>
                        <span wire:loading wire:target="actualizar">Guardando...</span>
                        
                        <svg wire:loading wire:target="actualizar" class="size-5 animate-spin fill-white" viewBox="0 0 24 24">
                            <path opacity="0.25" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" />
                            <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>