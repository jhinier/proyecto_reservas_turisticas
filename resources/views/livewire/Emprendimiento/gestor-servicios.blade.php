<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-6">
    
    <x-alert-success />

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200 pb-4 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Servicios</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Administra tus habitaciones, platos, tours o paquetes.</p>
        </div>
        
        <a href="{{ route('emprendimiento.servicios.seleccion') }}" wire:navigate class="inline-flex items-center gap-2 rounded-radius bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>
            Configurar Categorías
        </a>
    </div>

    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex gap-6 overflow-x-auto" aria-label="Tabs">
            @foreach($categoriasActivas as $categoria)
                <button wire:click="seleccionarPestana({{ $categoria['pivot_id'] }}, '{{ $categoria['nombre'] }}')"
                        class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors duration-200 {{ $pestanaActivaId === $categoria['pivot_id'] ? 'border-[#1a4031] text-[#1a4031] dark:border-success dark:text-success' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                    {{ $categoria['nombre'] }}
                </button>
            @endforeach
        </nav>
    </div>

    <div class="relative min-h-[300px]">
        
        <div wire:loading wire:target="seleccionarPestana" class="absolute inset-0 z-10 flex items-center justify-center bg-white/70 dark:bg-gray-900/70">
            <svg class="h-8 w-8 animate-spin text-[#1a4031]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </div>

        <div wire:loading.remove wire:target="seleccionarPestana" class="pt-4 flex flex-col gap-4">
            
            <div class="flex justify-end">
                @if($this->esHospedaje())
                    <a href="{{ route('emprendimiento.hospedaje.crear', ['pivotId' => $pestanaActivaId]) }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-[#1a4031] px-4 py-2 text-sm font-medium text-white transition hover:opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                        Nuevo: {{ $nombrePestanaActiva }}
                    </a>
                @else
                    <button wire:click="toggleFormulario" class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition hover:opacity-90 {{ $mostrandoFormulario ? 'bg-gray-500' : 'bg-[#1a4031]' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            @if($mostrandoFormulario) <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                            @else <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /> @endif
                        </svg>
                        {{ $mostrandoFormulario ? 'Cancelar' : 'Nuevo: ' . $nombrePestanaActiva }}
                    </button>
                @endif
            </div>

            @if($mostrandoFormulario)
                <div class="mb-4 animate-fade-in">
                    <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">El formulario para {{ $nombrePestanaActiva }} se habilitará pronto.</p>
                    </div>
                </div>
            @else
                <div class="animate-fade-in">
                    @if($servicios->isEmpty())
                        <x-mensaje-sin-registros :nombrePestana="$nombrePestanaActiva" />
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($servicios as $servicio)
                                <x-servicio-card :servicio="$servicio" />
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>