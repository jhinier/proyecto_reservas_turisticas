<div x-data="{ seleccionados: @js($seleccionados) }" class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-6">
    <style>
        [data-service-card][data-selected="true"] {
            background-color: #1a4031;
            border-color: #1a4031;
            color: #ffffff;
        }

        [data-service-card][data-selected="false"] {
            background-color: #ffffff;
            border-color: #e5e7eb;
            color: #1f2937;
        }

        [data-service-card][data-selected="false"]:hover {
            border-color: rgb(26 64 49 / 0.5);
        }

        [data-service-check][data-selected="true"] {
            background-color: #facc15;
            border-color: #facc15;
            color: #ffffff;
        }

        [data-service-check][data-selected="false"] {
            background-color: transparent;
            border-color: #d1d5db;
            color: transparent;
        }
    </style>
    
    <div class="flex flex-col gap-1 mb-2">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            ¿Qué tipos de servicio ofreces?
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Selecciona uno o más servicios para configurarlos en tu emprendimiento.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        @foreach($catalogos as $catalogo)
            @php
                // Mapeo de íconos
                $nombreIcono = match($catalogo->nombre) {
                    'Hospedaje' => 'hotel',
                    'Alimentación' => 'soup',
                    'Guianza' => 'footprints',              
                    'Recreación' => 'clapperboard',
                    'Alquiler de Equipos' => 'backpack',
                    'Paquetes Turísticos' => 'tent-tree',
                    default => 'layout-grid'                 
                };

                $estaSeleccionado = in_array($catalogo->id, $seleccionados, true);
            @endphp

            {{-- IMPORTANTE: Se agregó wire:key para evitar parpadeos en el DOM diffing --}}
            <div 
                wire:key="catalogo-{{ $catalogo->id }}"
                @click="if(seleccionados.includes({{ $catalogo->id }})) { seleccionados = seleccionados.filter(i => i !== {{ $catalogo->id }}) } else { seleccionados.push({{ $catalogo->id }}) }"
                class="cursor-pointer transition-all duration-200 ease-in-out transform hover:scale-[1.02]"
            >
                <div 
                    data-service-card
                    data-selected="{{ $estaSeleccionado ? 'true' : 'false' }}"
                    x-bind:data-selected="seleccionados.includes({{ $catalogo->id }}) ? 'true' : 'false'"
                    class="relative flex flex-col items-center justify-center p-6 rounded-xl border-2 shadow-sm h-32 transition-colors duration-200"
                >
                    
                    <div 
                        data-service-check
                        data-selected="{{ $estaSeleccionado ? 'true' : 'false' }}"
                        x-bind:data-selected="seleccionados.includes({{ $catalogo->id }}) ? 'true' : 'false'"
                        class="absolute top-4 right-4 flex items-center justify-center w-6 h-6 rounded-full border-2 transition-colors duration-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    </div>

                    <div class="mb-3">
                        <flux:icon :name="$nombreIcono" class="size-8" />
                    </div>

                    <h3 class="font-bold text-center">
                        {{ $catalogo->nombre }}
                    </h3>
                </div>
            </div>
        @endforeach

    </div>

    @error('seleccionados')
        <div class="mt-2 flex items-center gap-2 text-red-600 dark:text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 shrink-0">
                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
            </svg>
            <span class="text-sm font-medium">{{ $message }}</span>
        </div>
    @enderror

    <div class="mt-6 flex items-center justify-start gap-4">
        
        <a
            href="{{ route('emprendimiento.servicios.index') }}"
            class="inline-flex items-center justify-center rounded-radius border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
        >
            Cancelar
        </a>

        <button 
            @click="$wire.guardarSeleccion(seleccionados)"
            wire:loading.attr="disabled"
            type="button" 
            class="inline-flex items-center gap-2 whitespace-nowrap rounded-radius bg-success border border-success px-4 py-2 text-sm font-medium tracking-wide text-on-success transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:border-success dark:text-on-success dark:focus-visible:outline-success"
        >
            <svg 
                wire:loading
                wire:target="guardarSeleccion"
                aria-hidden="true" 
                xmlns="http://www.w3.org/2000/svg" 
                viewBox="0 0 24 24" 
                class="size-5 animate-spin motion-reduce:animate-none fill-on-success dark:fill-on-success" 
            >
                <path opacity="0.25" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" />
                <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
            </svg>
            
            <span wire:loading.remove wire:target="guardarSeleccion">Guardar </span>
            <span wire:loading wire:target="guardarSeleccion">Guardando...</span>
        </button>

    </div>

</div>
