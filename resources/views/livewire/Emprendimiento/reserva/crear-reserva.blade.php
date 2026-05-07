<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" wire:key="reserva-root-container">
    <div class="max-w-7xl mx-auto p-4 md:p-6">
        
        <x-reserva.pasos-horizontal :paso="$paso" />

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            <div class="w-full lg:w-2/3 xl:w-3/4 space-y-4">
                
                @if($paso === 1)
                    <x-reserva.filtro-servicios :categorias="$this->categorias" :filtroCategoria="$filtroCategoria" />
                @endif

                @if($paso === 2)
                    <livewire:emprendimiento.reserva.datos-turista wire:key="paso-datos-turista" />
                @endif

                @if($paso === 3)
                    <x-reserva.resumen-datos :datosTurista="$datosTurista" :carrito="$carrito" :totalCarrito="$this->totalCarrito" />
                @endif
            </div>

            <x-reserva.carrito-lateral :carrito="$carrito" :paso="$paso" :totalCarrito="$this->totalCarrito" />
        </div>
    </div>
</div>