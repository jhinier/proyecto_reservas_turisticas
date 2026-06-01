@props(['categorias', 'filtroCategoria'])

<div class="space-y-1">
    <div class="h-px bg-gray-200 dark:bg-white/10 w-full"></div>

    <div class="flex flex-col md:flex-row justify-center items-center gap-6 py-2">
        <div wire:ignore x-data="{
            options: @js($categorias->map(fn($c) => ['value' => $c->id, 'label' => $c->nombre])->values()),
            isOpen: false,
            selectedOption: null,
            init() {
                let filtroId = '{{ $filtroCategoria }}';
                if(filtroId) {
                    let preselec = this.options.find(opt => opt.value == filtroId);
                    if(preselec) this.selectedOption = preselec;
                }
            },
            setSelectedOption(option) {
                this.selectedOption = option;
                this.isOpen = false;
                $wire.seleccionarCategoria(option.value);
            }
        }" class="w-full max-w-sm">
            <div class="relative">
                <button type="button" 
                        class="inline-flex w-full items-center justify-between gap-2 border-2 px-5 py-3 text-sm font-black transition rounded-2xl shadow-sm hover:shadow-md outline-none"
                        x-bind:class="isOpen ? 'border-[#00A344] bg-green-50 text-[#00A344] dark:border-[#00D65B] dark:bg-zinc-800 dark:text-[#00D65B]' : 'border-gray-200 bg-white text-[#06281E] dark:border-zinc-700 dark:bg-zinc-900 dark:text-white'"
                        x-on:click="isOpen = ! isOpen">
                    
                    <span x-text="selectedOption ? selectedOption.label : 'SELECCIONA UNA CATEGORÍA'" class="uppercase tracking-wide truncate"></span>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" 
                         class="size-5 transition-transform duration-200 shrink-0"
                         x-bind:class="isOpen ? 'rotate-180 text-[#00A344] dark:text-[#00D65B]' : 'text-gray-400 dark:text-gray-500'">
                         <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>
                
                {{-- Dropdown con scrollbar --}}
                <ul x-cloak x-show="isOpen" 
                    x-on:click.outside="isOpen = false" 
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-50 left-0 top-14 flex max-h-56 w-full flex-col overflow-y-auto border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-xl rounded-2xl py-2 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-zinc-600 scrollbar-track-transparent">
                    
                    <template x-for="item in options" :key="item.value">
                        <li class="inline-flex justify-between items-center px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-zinc-800 cursor-pointer uppercase transition-colors" 
                            x-on:click="setSelectedOption(item)">
                            
                            <span x-bind:class="selectedOption && selectedOption.value == item.value ? 'text-[#00A344] dark:text-[#00D65B] font-black' : ''" x-text="item.label" class="truncate pr-2"></span>
                            
                            <svg x-show="selectedOption && selectedOption.value == item.value" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="4" class="size-4 text-[#00A344] dark:text-[#00D65B] shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>

    <div class="h-px bg-gray-200 dark:bg-white/10 w-full"></div>
</div>