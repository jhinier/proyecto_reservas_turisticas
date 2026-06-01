<div class="bg-white dark:bg-zinc-900 p-2 md:p-3 rounded-[2.5rem] shadow-sm border border-gray-200 dark:border-zinc-800 mb-10 w-full max-w-4xl mx-auto transition-all hover:shadow-md">
    <div class="flex flex-col md:flex-row items-center md:divide-x divide-gray-200 dark:divide-zinc-800">
        
        <div class="flex-1 w-full px-4 py-2">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1 ml-1">Fecha de inicio</label>
            <input type="date" wire:model.blur="fecha" min="{{ $this->getFechaMinima() }}" 
                   class="w-full bg-transparent border-none p-0 text-sm font-black text-[#06281E] dark:text-white focus:ring-0 cursor-pointer dark:[color-scheme:dark] outline-none">
            @error('fecha') <span class="text-red-500 dark:text-red-400 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>

        @if($this->requiereFechaFin())
        <div class="flex-1 w-full px-4 py-2">
            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1 ml-1">Fecha de fin</label>
            <input type="date" wire:model.blur="fechaFin" min="{{ $fecha ?: $this->getFechaMinima() }}" 
                   class="w-full bg-transparent border-none p-0 text-sm font-black text-[#06281E] dark:text-white focus:ring-0 cursor-pointer dark:[color-scheme:dark] outline-none">
            @error('fechaFin') <span class="text-red-500 dark:text-red-400 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
        </div>
        @endif

        <div class="w-full md:w-auto p-2">
            <button wire:click="buscar" wire:loading.attr="disabled" 
                    class="w-full md:w-auto px-8 py-3 bg-[#00A344] hover:bg-green-700 dark:bg-[#00D65B] dark:hover:bg-[#00c052] text-white dark:text-[#06281E] font-black rounded-full text-sm transition-colors flex items-center justify-center gap-2 outline-none">
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