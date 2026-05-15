<div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-200 mb-6 w-full">
    <div class="flex flex-col md:flex-row gap-4 items-end">
        
        <div class="flex-1 w-full">
            <label class="block text-[10px] font-black text-[#1a4031] uppercase tracking-widest mb-2 ml-1">Fecha de inicio</label>
            {{-- Llamamos a la función PHP para obtener la fecha mínima dinámica --}}
            <input type="date" wire:model.blur="fecha" min="{{ $this->getFechaMinima() }}" 
                   class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl p-3 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031]">
            @error('fecha') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        @if($this->requiereFechaFin())
        <div class="flex-1 w-full">
            <label class="block text-[10px] font-black text-[#1a4031] uppercase tracking-widest mb-2 ml-1">Fecha de fin</label>
            {{-- Aquí el mínimo es la fecha de inicio seleccionada, o si no hay, la fecha mínima dinámica --}}
            <input type="date" wire:model.blur="fechaFin" min="{{ $fecha ?: $this->getFechaMinima() }}" 
                   class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl p-3 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031]">
            @error('fechaFin') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>
        @endif

        @if($this->requierePersonas())
        <div class="w-full md:w-32">
            <label class="block text-[10px] font-black text-[#1a4031] uppercase tracking-widest mb-2 ml-1">Personas</label>
            <input type="number" wire:model.blur="personas" min="1" 
                   class="w-full bg-gray-50 border-2 border-gray-200 rounded-xl p-3 text-sm font-bold text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031] text-center">
            @error('personas') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>
        @endif

        <div class="w-full md:w-auto">
            <button wire:click="buscar" wire:loading.attr="disabled" 
                    class="w-full md:w-auto px-8 py-3 bg-[#1a4031] hover:bg-green-950 text-white font-black rounded-xl text-sm transition-colors flex items-center justify-center gap-2 shadow-lg shadow-green-900/20">
                <span wire:loading.remove wire:target="buscar">Buscar</span>
                <span wire:loading wire:target="buscar" class="flex gap-2 items-center">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Buscando
                </span>
            </button>
        </div>

    </div>
</div>