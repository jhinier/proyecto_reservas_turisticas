<div class="min-h-screen bg-white dark:bg-zinc-950" wire:key="reserva-root-container">
    <div class="max-w-5xl mx-auto p-4 md:p-8">
        
        <x-reserva.pasos-horizontal :paso="$paso" />

        <div class="w-full space-y-6">
            
            @if($paso === 1)
                <x-reserva.filtro-servicios :categorias="$this->categorias" :filtroCategoria="$filtroCategoria" />
                
                @if($filtroCategoria)
                    <livewire:emprendimiento.reserva.formulario-reserva 
                        :nombreCategoria="$nombreCategoriaFiltro" 
                        wire:key="buscador-{{ $filtroCategoria }}" />
                    
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
                
                <div class="flex justify-center md:justify-end mt-8">
                    <button wire:click="finalizarAgendamiento" wire:loading.attr="disabled" 
                            class="px-10 py-4 bg-[#00A344] hover:bg-green-700 dark:bg-[#00D65B] dark:hover:bg-[#00c052] text-white dark:text-[#06281E] font-black rounded-full transition-all shadow-xl shadow-[#00A344]/20 dark:shadow-[#00D65B]/20 uppercase text-xs tracking-widest flex items-center gap-2 outline-none">
                        <span wire:loading.remove wire:target="finalizarAgendamiento">Confirmar y Terminar</span>
                        <span wire:loading wire:target="finalizarAgendamiento" class="flex justify-center items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Procesando...
                        </span>
                    </button>
                </div>
            @endif
        </div>
        
        {{-- ESPACIADOR FANTASMA --}}
        @if($paso !== 3)
            <div class="h-72 md:h-96 w-full pointer-events-none opacity-0"></div>
        @else
            <div class="h-10 w-full pointer-events-none opacity-0"></div>
        @endif
        
    </div>

    {{-- El carrito inferior (Limpio de variables que bloqueaban el botón) --}}
    @if($paso !== 3)
        <x-reserva.carrito-lateral 
            :carrito="$carrito" 
            :paso="$paso" 
            :totalCarrito="$this->totalCarrito" />
    @endif
</div>