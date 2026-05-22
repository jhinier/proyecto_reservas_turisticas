<div class="bg-white p-2 md:p-3 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#CFE2CF] mb-10 w-full max-w-4xl mx-auto transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
    <div class="flex flex-col md:flex-row items-center md:divide-x divide-[#CFE2CF]">
        
        <div class="flex-1 w-full px-4 py-2">
            <label class="block text-[10px] font-black text-[#8DBEA2] uppercase tracking-widest mb-1 ml-1">Fecha de inicio</label>
            <input type="date" wire:model.blur="fecha" min="{{ $this->getFechaMinima() }}" 
                   class="w-full bg-transparent border-none p-0 text-sm font-black text-[#4C4F26] focus:ring-0 cursor-pointer">
            @error('fecha') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        @if($this->requiereFechaFin())
        <div class="flex-1 w-full px-4 py-2">
            <label class="block text-[10px] font-black text-[#8DBEA2] uppercase tracking-widest mb-1 ml-1">Fecha de fin</label>
            <input type="date" wire:model.blur="fechaFin" min="{{ $fecha ?: $this->getFechaMinima() }}" 
                   class="w-full bg-transparent border-none p-0 text-sm font-black text-[#4C4F26] focus:ring-0 cursor-pointer">
            @error('fechaFin') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>
        @endif

        @if($this->requierePersonas())
        <div class="w-full md:w-32 px-4 py-2">
            <label class="block text-[10px] font-black text-[#8DBEA2] uppercase tracking-widest mb-1 ml-1">Personas</label>
            <input type="number" wire:model.blur="personas" min="1" 
                   class="w-full bg-transparent border-none p-0 text-sm font-black text-[#4C4F26] focus:ring-0 text-center">
            @error('personas') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>
        @endif

        <div class="w-full md:w-auto p-2">
            <button wire:click="buscar" wire:loading.attr="disabled" 
                    class="w-full md:w-auto px-8 py-3 bg-[#508E42] hover:bg-[#32744C] text-white font-black rounded-full text-sm transition-colors flex items-center justify-center gap-2">
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