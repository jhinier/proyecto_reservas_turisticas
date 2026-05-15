<div class="max-w-5xl mx-auto p-4 md:p-6 relative">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Nueva Alimentación</h1>
            <p class="text-sm text-gray-500 mt-1">Registra un plato, bebida o menú en tu catálogo.</p>
        </div>
        <a href="{{ route('emprendimiento.servicios.index', ['tab' => $pivotId]) }}" class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-black border border-black px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 dark:bg-white dark:border-white dark:text-black">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-current" fill="currentColor">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H21a.75.75 0 010 1.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>
            Volver al Gestor
        </a>
    </div>

    <div class="p-8 bg-surface rounded-xl border border-gray-200 shadow-sm dark:bg-surface-dark dark:border-gray-700">
        <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark mb-6 border-b border-gray-200 dark:border-gray-700 pb-3">Detalles del Plato</h3>
        
        <form wire:submit.prevent="guardar" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-input-form id="nombre" label="Nombre del Plato/Menú" model="nombre" placeholder="Ej. Desayuno Continental" />
                
                {{-- CAMBIO REALIZADO AQUÍ: De Input a Select --}}
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

                <x-input-form id="lugar_alimentacion" label="Lugar donde se sirve" model="lugar_alimentacion" placeholder="Ej. Restaurante Principal" />
                <x-input-form id="precio" label="Precio ($)" model="precio" type="number" step="0.01" placeholder="0.00" simbolo="$" />
            </div>

            <x-textarea-form id="descripcion" label="Descripción e Ingredientes" model="descripcion" rows="3" placeholder="Incluye jugo, huevos, pan..." />
            
            <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-700 mt-4">
                <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 whitespace-nowrap rounded-radius bg-success border border-success px-6 py-2.5 text-sm font-medium tracking-wide text-on-success transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:border-success dark:text-on-success dark:focus-visible:outline-success">
                    <span wire:loading.remove wire:target="guardar">Guardar Alimentación</span>
                    <span wire:loading wire:target="guardar">Guardando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
