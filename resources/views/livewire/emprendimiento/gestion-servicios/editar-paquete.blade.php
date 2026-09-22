<div x-data="{ show: @entangle('abierto') }" x-show="show" 
     class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    
    <div class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
        
        {{-- Header --}}
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md z-20">
            <div>
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Editar Paquete Turístico</h3>
                <p class="text-xs text-gray-500 mt-1">Refina el itinerario y los detalles de tu paquete.</p>
            </div>
            
            <button @click="show = false" type="button" class="p-1.5 hover:bg-gray-100 rounded-lg dark:hover:bg-gray-800 transition-colors text-gray-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Cuerpo del Formulario --}}
        <div class="p-6 md:p-8 flex-1">
            <form wire:submit.prevent="actualizar" class="space-y-6">
                
                <section>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div wire:key="p-nombre"><x-input-form id="nombre" label="Nombre del Paquete" model="nombre" /></div>
                        <div wire:key="p-precio"><x-input-form id="precio" label="Precio por Persona" model="precio" type="number" step="0.01" simbolo="$" /></div>
                        <div wire:key="p-stock"><x-input-form id="stock" label="Stock por Día (Cupos disponibles)" model="stock" type="number" /></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        <div wire:key="p-dias"><x-input-form id="duracion_dias" label="Días de duración" model="duracion_dias" type="number" /></div>
                        <div wire:key="p-salida"><x-input-form id="lugar_salida" label="Punto de Encuentro" model="lugar_salida" /></div>
                        <div wire:key="p-hora"><x-input-form id="hora_salida" label="Hora de Inicio" model="hora_salida" type="time" /></div>
                    </div>
                    
                    <div wire:key="p-desc" class="mt-6">
                        <x-textarea-form id="descripcion" label="Resumen General" model="descripcion" rows="3" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div wire:key="p-itinerario">
                            <x-textarea-form id="lugares_actividades" label="Itinerario Detallado" model="lugares_actividades" rows="4" />
                        </div>
                        <div wire:key="p-incluye">
                            <x-textarea-form id="servicios_incluidos" label="¿Qué incluye?" model="servicios_incluidos" rows="4" />
                        </div>
                    </div>

                    <div wire:key="p-recom" class="mt-6">
                        <x-textarea-form id="recomendaciones" label="Recomendaciones para el turista" model="recomendaciones" rows="3" />
                    </div>

                    {{-- Campo de archivo PDF --}}
                    <div wire:key="p-pdf" class="mt-6 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Itinerario PDF (Opcional)</label>
                        <input type="file" wire:model="nuevo_documento" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                        
                        @if($documento)
                            <div class="mt-2 flex items-center gap-2 text-xs text-emerald-600">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Ya tienes un archivo cargado. Sube uno nuevo solo si quieres reemplazarlo.</span>
                            </div>
                        @endif
                        @error('nuevo_documento') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </section>
                
                {{-- Footer: Acciones --}}
                <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-800 gap-3">
                    <button @click="show = false" type="button" class="rounded-xl bg-gray-100 px-6 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300">
                        Cancelar
                    </button>

                    <button type="submit" 
                            wire:loading.attr="disabled" 
                            wire:target="actualizar" 
                            class="inline-flex items-center gap-2 rounded-xl bg-sky-600 px-8 py-2.5 text-sm font-bold text-white transition hover:bg-sky-700 disabled:opacity-50 shadow-lg shadow-sky-200">
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
