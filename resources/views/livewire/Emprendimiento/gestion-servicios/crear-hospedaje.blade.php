<div class="max-w-5xl mx-auto p-4 md:p-6 relative">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Nuevo Hospedaje</h1>
            <p class="text-sm text-gray-500 mt-1">Registra una nueva habitación en tu catálogo de servicios.</p>
        </div>

        {{-- Botón Volver configurado con parámetro de pestaña --}}
        <a href="{{ route('emprendimiento.servicios.index', ['tab' => $pivotId]) }}" 
           class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-black border border-black px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 dark:bg-white dark:border-white dark:text-black">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-current" fill="currentColor">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H21a.75.75 0 010 1.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>
            Volver al Gestor
        </a>
    </div>

    <div class="p-8 bg-surface rounded-xl border border-gray-200 shadow-sm dark:bg-surface-dark dark:border-gray-700">
        <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark mb-6 border-b border-gray-200 dark:border-gray-700 pb-3">Detalles de la Habitación</h3>
        
        <form wire:submit.prevent="guardar" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <x-input-form id="nombre" label="Nombre de la Habitación" model="nombre" placeholder="Ej. Suite Matrimonial" />
                
                <x-input-form id="capacidad" label="Capacidad (Personas)" model="capacidad" type="number" placeholder="Ej. 2" />

                <x-input-form id="precio" label="Precio por Noche ($)" model="precio" type="number" step="0.01" placeholder="0.00" simbolo="$" />

                <x-input-form id="stock" label="Stock por Día (Habitaciones disponibles)" model="stock" type="number" placeholder="Ej. 5" />
                
            </div>

            <x-textarea-form 
                id="descripcion" 
                label="Descripción de la habitación" 
                model="descripcion" 
                rows="4" 
                placeholder="Incluye TV, baño privado, agua caliente..." 
            />
            
            <div class="flex justify-end pt-6 border-t border-gray-100 dark:border-gray-700 mt-4">
                <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center gap-2 whitespace-nowrap rounded-radius bg-success border border-success px-6 py-2.5 text-sm font-medium tracking-wide text-on-success transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:border-success dark:text-on-success dark:focus-visible:outline-success">
                    <span wire:loading.remove wire:target="guardar">Guardar Habitación</span>
                    
                    <svg wire:loading wire:target="guardar" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 animate-spin motion-reduce:animate-none fill-on-success dark:fill-on-success" >
                        <path opacity="0.25" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" />
                        <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
                    </svg>
                    <span wire:loading wire:target="guardar">Guardando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
