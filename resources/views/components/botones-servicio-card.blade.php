@props(['servicio'])

<div class="flex items-center gap-1.5 shrink-0">
    
    {{-- Galería --}}
    @if($servicio->permite_galeria)
        <button 
            @click="$dispatch('abrir-gestor-galeria', { servicioId: @js($servicio->id) })"
            class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-500 hover:bg-gray-100">
            📷
        </button>
    @endif

    {{-- Editar --}}
    <button 
        wire:click="editarServicio({{ $servicio->id }})"
        class="flex h-8 w-8 items-center justify-center rounded-lg border text-gray-500 hover:bg-gray-100">
        ✏️
    </button>

    {{-- Eliminar --}}
    <button 
        @click="$dispatch('abrir-modal-eliminar', { id: @js($servicio->id), action: 'eliminarServicio' })"
        class="flex h-8 w-8 items-center justify-center rounded-lg border text-red-500 hover:bg-red-100">
        🗑️
    </button>

</div>