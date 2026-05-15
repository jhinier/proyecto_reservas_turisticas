<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" wire:key="reserva-root-container">
    <div class="max-w-7xl mx-auto p-4 md:p-6">
        
        <x-reserva.pasos-horizontal :paso="$paso" />

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            {{-- Si estamos en el paso 3, ocupa el 100% del ancho --}}
            <div class="w-full {{ $paso === 3 ? '' : 'lg:w-2/3 xl:w-3/4' }} space-y-4">
                
                @if($paso === 1)
                    <x-reserva.filtro-servicios :categorias="$this->categorias" :filtroCategoria="$filtroCategoria" />
                    
                    @if($filtroCategoria)
                        
                        {{-- Buscador Global --}}
                        <livewire:emprendimiento.reserva.formulario-reserva 
                            :nombreCategoria="$nombreCategoriaFiltro" 
                            wire:key="buscador-{{ $filtroCategoria }}" />
                        
                        {{-- Lista de Resultados --}}
                        <livewire:emprendimiento.reserva.lista-servicios-reservas 
                            :filtroCategoria="$filtroCategoria" 
                            :nombreCategoria="$nombreCategoriaFiltro"
                            :busquedaActiva="$busquedaActiva"
                            :metaAlcanzada="$metaAlcanzada"
                            :fechaBusqueda="$fechaBusqueda"
                            :fechaFinBusqueda="$fechaFinBusqueda"
                            :personasBusqueda="$personasBusqueda"
                            :carrito="$carrito"
                            wire:key="lista-{{ $filtroCategoria }}" />
                            
                    @endif
                @endif

                @if($paso === 2)
                    <livewire:emprendimiento.reserva.datos-turista wire:key="paso-datos-turista" />
                @endif

                @if($paso === 3)
                    <x-reserva.resumen-datos :datosTurista="$datosTurista" :carrito="$carrito" :totalCarrito="$this->totalCarrito" />
                    
                    {{-- Botón final movido debajo de la tabla --}}
                    <div class="flex justify-end mt-6">
                        <button wire:click="finalizarAgendamiento" wire:loading.attr="disabled" class="px-8 py-4 bg-[#1a4031] hover:bg-green-950 text-white font-black rounded-2xl transition-all shadow-lg uppercase text-xs tracking-widest flex items-center gap-2">
                            <span wire:loading.remove wire:target="finalizarAgendamiento">Confirmar y Terminar</span>
                            <span wire:loading wire:target="finalizarAgendamiento" class="flex justify-center items-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Procesando...
                            </span>
                        </button>
                    </div>
                @endif
            </div>

            {{-- El carrito lateral solo se renderiza si NO estamos en el paso 3 --}}
            @if($paso !== 3)
                <x-reserva.carrito-lateral 
                    :carrito="$carrito" 
                    :paso="$paso" 
                    :totalCarrito="$this->totalCarrito" 
                    :personasBusqueda="$personasBusqueda"
                    :categoriaFiltro="$nombreCategoriaFiltro" />
            @endif
        </div>
    </div>
</div>