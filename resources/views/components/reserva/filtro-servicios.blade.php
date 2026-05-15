@props(['categorias', 'filtroCategoria'])

@php
    // Busca la categoría de paquetes dentro de las activas
    $categoriaPaquetes = $categorias->first(function($cat) {
        return \Illuminate\Support\Str::contains(\Illuminate\Support\Str::slug($cat->nombre, ' '), 'paquete');
    });
@endphp

<div class="space-y-1">
    <div class="h-px bg-gray-300 w-full"></div>

    <div class="flex flex-col md:flex-row justify-center items-center gap-6 py-1">
        <div wire:ignore x-data="{
            options: @js($categorias->filter(fn($c) => \Illuminate\Support\Str::slug($c->nombre, ' ') !== 'paquetes turisticos')->map(fn($c) => ['value' => $c->id, 'label' => $c->nombre])->values()),
            isOpen: false,
            selectedOption: null,
            setSelectedOption(option) {
                this.selectedOption = option;
                this.isOpen = false;
                $wire.seleccionarCategoria(option.value);
            }
        }" class="w-full max-w-xs">
            <div class="relative">
                <button type="button" class="inline-flex w-full items-center justify-between gap-2 border-2 border-gray-300 bg-white px-5 py-2.5 text-sm font-black text-gray-800 transition hover:border-[#1a4031] rounded-2xl" x-on:click="isOpen = ! isOpen">
                    <span x-text="selectedOption ? selectedOption.label : 'VER CATEGORIAS'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-400"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                </button>
                <ul x-cloak x-show="isOpen" x-on:click.outside="isOpen = false" class="absolute z-50 left-0 top-12 flex max-h-44 w-full flex-col overflow-y-auto border-2 border-gray-100 bg-white shadow-2xl rounded-2xl py-2">
                    <template x-for="item in options" :key="item.value">
                        <li class="inline-flex justify-between items-center px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-50 cursor-pointer uppercase" x-on:click="setSelectedOption(item)">
                            <span x-bind:class="selectedOption && selectedOption.value == item.value ? 'text-[#1a4031] font-black' : ''" x-text="item.label"></span>
                            <svg x-show="selectedOption && selectedOption.value == item.value" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="4" class="size-4 text-[#1a4031]"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
        
        @if($categoriaPaquetes)
            <span class="text-gray-300 font-black text-xs hidden md:block">|</span>
            <button type="button" wire:click="seleccionarCategoria('{{ $categoriaPaquetes->id }}')" class="w-full md:w-auto inline-flex justify-center items-center gap-3 rounded-2xl bg-[#1a4031] border-2 border-[#1a4031] px-8 py-2.5 text-xs font-black tracking-widest text-white transition hover:bg-[#122d22] uppercase">
                <svg class="size-5 fill-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.378 1.602a.75.75 0 00-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03zM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 00.372-.648V7.93zM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 00.372.648l8.628 5.033z"/></svg>
                Paquetes Turisticos
            </button>
        @endif
    </div>

    <div class="h-px bg-gray-300 w-full"></div>

</div>