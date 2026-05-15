<div class="flex flex-col gap-6 p-4 md:p-6">
    {{-- Alertas Globales --}}
    <x-alert-success />
    <x-alert-edit />
    <x-alert-delete />

    {{-- Encabezado Principal --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b pb-4 dark:border-gray-700">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Servicios</h2>
            <p class="text-sm text-gray-500">Administra tus habitaciones, platos, tours o paquetes.</p>
        </div>
        
        {{-- Botón de Configuración --}}
        <a href="{{ route('emprendimiento.servicios.seleccion') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" /></svg>
            Configurar Categorías
        </a>
    </div>

    {{-- Tabs --}}
    <nav class="flex gap-6 overflow-x-auto border-b dark:border-gray-700">
        @foreach($categoriasActivas as $categoria)
            <button wire:click="seleccionarPestana({{ $categoria['pivot_id'] }})"
                    class="py-4 px-1 text-sm font-medium border-b-2 transition {{ $pestanaActivaId === $categoria['pivot_id'] ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                {{ $categoria['nombre'] }}
            </button>
        @endforeach
    </nav>

    {{-- Contenido Dinámico --}}
    <div class="relative min-h-[400px]">
        @if($this->categoriaActiva)
            @if($this->categoriaActiva['nombre'] === 'Paquetes Turísticos')
                <livewire:emprendimiento.lista-paquetes 
                    :pivotId="$this->categoriaActiva['pivot_id']" 
                    :nombreCategoria="$this->categoriaActiva['nombre']"
                    :rutaCrear="$this->categoriaActiva['ruta_crear']"
                    wire:key="paquetes-{{ $this->categoriaActiva['pivot_id'] }}" />
            @else
                <livewire:emprendimiento.lista-servicios 
                    :pivotId="$this->categoriaActiva['pivot_id']"
                    :nombreCategoria="$this->categoriaActiva['nombre']"
                    :rutaCrear="$this->categoriaActiva['ruta_crear']"
                    wire:key="servicios-{{ $this->categoriaActiva['pivot_id'] }}" />
            @endif
        @endif
    </div>

    {{-- Modales e Inyecciones --}}
    <x-modal-confirm-delete />
    <livewire:emprendimiento.gestor-galeria />
</div>