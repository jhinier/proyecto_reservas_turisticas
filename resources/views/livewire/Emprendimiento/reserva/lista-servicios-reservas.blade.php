<div class="space-y-6">
    {{-- Indicador de carga visual --}}
    <div wire:loading.flex wire:target="filtroCategoria, tipoSeleccionado" 
         class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-pulse">
        @for ($i = 0; $i < 2; $i++)
            <div class="h-48 bg-gray-200 rounded-3xl"></div>
        @endfor
    </div>

    {{-- Grid de Resultados --}}
    <div wire:loading.remove wire:target="filtroCategoria, tipoSeleccionado" 
         class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($this->servicios as $servicio)
            <x-reservas-servicios-card 
                wire:key="srv-{{ $servicio->id }}" 
                :servicio="$servicio" 
                onSelect="prepararAgendamiento" 
            />
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
                <span class="text-4xl block mb-4 opacity-40">🔍</span>
                <h3 class="text-gray-900 font-black uppercase text-sm tracking-tighter">Sin resultados</h3>
                <p class="text-gray-500 text-xs mt-1">No se encontraron servicios en esta categoría.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal de Agendamiento --}}
    <livewire:emprendimiento.reserva.formulario-reserva />
</div>