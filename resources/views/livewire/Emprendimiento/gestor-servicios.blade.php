<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-6">
    
    @if(session()->has('success'))
        <div x-data="{ open: true }" 
             x-init="setTimeout(() => open = false, 4000)" 
             x-show="open" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-[-1rem] sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
             x-transition:leave-end="opacity-0 translate-y-[-1rem] sm:translate-y-0 sm:translate-x-4"
             class="fixed top-6 right-6 z-[100] w-full max-w-sm overflow-hidden rounded-radius border border-green-500 bg-surface text-on-surface shadow-2xl dark:bg-surface-dark dark:text-on-surface-dark" 
             role="alert">
            <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                <div class="bg-green-500/15 text-green-500 rounded-full p-1 shadow-sm" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-bold text-success">¡Acción Exitosa!</h3>
                    <p class="text-xs font-medium sm:text-sm mt-0.5">{{ session('success') }}</p>
                </div>
                <button @click="open = false" type="button" class="ml-auto hover:opacity-75 transition bg-transparent p-1 rounded-full hover:bg-success/20" aria-label="dismiss alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0 text-success">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200 pb-4 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Gestión de Servicios
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Administra tus habitaciones, platos, tours o paquetes.
            </p>
        </div>
        
        <a href="{{ route('emprendimiento.servicios.seleccion') }}" 
           wire:navigate 
           class="inline-flex items-center gap-2 rounded-radius bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                <path fill-rule="evenodd" d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
            Configurar Categorías
        </a>
    </div>

    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex gap-6 overflow-x-auto" aria-label="Tabs">
            @foreach($categoriasActivas as $categoria)
                <button 
                    wire:click="seleccionarPestana({{ $categoria['pivot_id'] }}, '{{ $categoria['nombre'] }}')"
                    class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200
                    {{ $pestanaActivaId === $categoria['pivot_id'] 
                        ? 'border-[#1a4031] text-[#1a4031] dark:border-success dark:text-success' 
                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}"
                >
                    {{ $categoria['nombre'] }}
                </button>
            @endforeach
        </nav>
    </div>

    <div class="relative min-h-[300px]">
        
        <div wire:loading wire:target="seleccionarPestana" class="absolute inset-0 z-10 flex items-center justify-center bg-white/70 dark:bg-gray-900/70">
            <svg class="h-8 w-8 animate-spin text-[#1a4031]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <div wire:loading.remove wire:target="seleccionarPestana" class="pt-4 flex flex-col gap-4">
            
            <div class="flex justify-end">
                
                @if($nombrePestanaActiva === 'Hospedaje')
                    <a href="{{ route('emprendimiento.hospedaje.crear', ['pivotId' => $pestanaActivaId]) }}" 
                       wire:navigate 
                       class="inline-flex items-center gap-2 rounded-lg bg-[#1a4031] px-4 py-2 text-sm font-medium text-white transition hover:opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        Nuevo: {{ $nombrePestanaActiva }}
                    </a>
                @else
                    <button wire:click="toggleFormulario" 
                        class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition hover:opacity-90 {{ $mostrandoFormulario ? 'bg-gray-500' : 'bg-[#1a4031]' }}">
                        
                        @if($mostrandoFormulario)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            </svg>
                            Cancelar
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Nuevo: {{ $nombrePestanaActiva }}
                        @endif
                    </button>
                @endif
            </div>

            @if($mostrandoFormulario)
                
                <div class="mb-4 animate-fade-in">
                    @if($nombrePestanaActiva === 'Hospedaje')
                        <livewire:emprendimiento.gestion-servicios.crear-hospedaje :pivotId="$pestanaActivaId" />
                    @else
                        <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center bg-gray-50">
                            <p class="text-sm text-gray-500 italic">El formulario para {{ $nombrePestanaActiva }} se habilitará pronto.</p>
                        </div>
                    @endif
                </div>

            @else
                
                <div class="animate-fade-in">
                    @if($servicios->isEmpty())
                        <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 p-12 text-center dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mb-4 size-12 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">No hay registros</h3>
                            <p class="mt-1 text-sm text-gray-500">Aún no has agregado ningún ítem en la categoría de {{ $nombrePestanaActiva }}.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($servicios as $servicio)
                                <div class="group relative rounded-xl border border-gray-200 bg-white p-4 transition-all hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex flex-col gap-1">
                                        <h4 class="font-bold text-gray-900 dark:text-white">{{ $servicio->nombre }}</h4>
                                        <p class="text-xs text-gray-500 line-clamp-2 mb-2">{{ $servicio->descripcion }}</p>
                                        <div class="flex items-center justify-between border-t border-gray-100 pt-2 dark:border-gray-700">
                                            <span class="text-sm font-bold text-[#1a4031] dark:text-success">
                                                ${{ number_format($servicio->precio, 2) }}
                                            </span>
                                            <span class="text-[10px] uppercase font-semibold text-gray-400">
                                                Stock: {{ $servicio->stock }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>