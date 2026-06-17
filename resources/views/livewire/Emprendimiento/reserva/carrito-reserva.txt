@props(['carrito', 'paso', 'totalCarrito'])

@if(!empty($carrito))
<div class="fixed bottom-0 left-0 right-0 z-50 lg:pl-72 transition-transform duration-300" x-data="{ mostrarLista: true }" @servicio-agregado.window="mostrarLista = true">
    
    <div class="bg-white dark:bg-zinc-900 shadow-[0_-15px_40px_rgba(0,0,0,0.1)] dark:shadow-[0_-15px_40px_rgba(0,0,0,0.5)] border-t border-gray-200 dark:border-zinc-800 w-full flex flex-col pointer-events-auto rounded-t-3xl md:rounded-none transition-colors">

        @if(!empty($carrito))
            <button x-on:click="mostrarLista = !mostrarLista" 
                    class="w-full flex items-center justify-center gap-2 py-3 text-gray-500 dark:text-gray-400 hover:text-[#00A344] dark:hover:text-[#00D65B] transition-colors text-[10px] md:text-xs font-black uppercase tracking-widest bg-white dark:bg-zinc-900 rounded-t-3xl md:rounded-none border-b border-gray-200 dark:border-zinc-800 outline-none">
                <span x-text="mostrarLista ? 'Ocultar' : 'Mostrar'"></span>
                <svg class="size-4 transition-transform duration-300" x-bind:class="mostrarLista ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        @endif

        <div x-show="mostrarLista" x-collapse x-transition.opacity.duration.300ms class="max-h-[45vh] overflow-y-auto px-3 md:px-8 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] bg-gray-50/30 dark:bg-zinc-900/50">
            @if(empty($carrito))
                <div class="py-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-black uppercase tracking-widest">Tu bolsa está vacía</p>
                </div>
            @else
                <div class="flex flex-col py-2">
                    @foreach($carrito as $index => $item)
                        @php
                            $fi = $item['fecha_inicio'] ?? $item['fecha'] ?? now();
                            $ff = $item['fecha_fin'] ?? $fi;
                            $dias = max(1, \Carbon\Carbon::parse($fi)->diffInDays(\Carbon\Carbon::parse($ff)) + 1);
                            $nombreCat = strtolower($item['categoria_nombre'] ?? '');
                            $aplicaDias = $dias > 1 && !str_contains($nombreCat, 'paquete') && !str_contains($nombreCat, 'aliment');
                            
                            $esHospedaje = str_contains($nombreCat, 'hospedaje');
                            $esGuianza = str_contains($nombreCat, 'guianza');
                            $esPaquete = str_contains($nombreCat, 'paquete');
                            $esAlquiler = str_contains($nombreCat, 'alquiler');
                        @endphp

                        <div class="flex items-center justify-between py-3 md:py-3.5 border-b border-gray-200 dark:border-zinc-800 gap-2 md:gap-4 w-full group" wire:key="cart-item-{{ $index }}">
                            
                            <div class="flex items-center gap-2 md:gap-3 min-w-0 flex-1">
                                
                                @if($paso === 1)
                                    <button wire:click="$dispatch('quitar-del-carrito', { index: {{ $index }} })" class="text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 transition-colors bg-white dark:bg-zinc-900 hover:bg-red-50 dark:hover:bg-red-900/20 size-6 md:size-7 flex items-center justify-center rounded-full shrink-0 border border-gray-200 dark:border-zinc-700 hover:border-red-200 dark:hover:border-red-800 outline-none">
                                        <svg class="size-3 md:size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                @endif

                                <div class="bg-green-50 dark:bg-green-900/30 text-[#00A344] dark:text-[#00D65B] px-2 py-1 md:px-2.5 rounded-md border border-[#00A344]/30 dark:border-[#00D65B]/30 flex items-center gap-1 md:gap-1.5 shrink-0">
                                    @if($esHospedaje)
                                        <svg class="size-3 md:size-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <span class="font-black text-[10px] md:text-[11px]">{{ $item['numero_personas'] ?? 1 }}</span>
                                    @elseif($esGuianza)
                                        <svg class="size-3 md:size-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        <span class="font-black text-[10px] md:text-[11px]">{{ $item['cantidad'] ?? 1 }}</span>
                                    @else
                                        <span class="font-black text-[10px] md:text-[11px]">{{ $item['cantidad'] ?? 1 }}u.</span>
                                    @endif
                                </div>

                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-baseline gap-1.5 md:gap-2">
                                        <h4 class="font-black text-[10px] md:text-sm text-[#06281E] dark:text-white truncate">
                                            {{ $item['nombre'] }}
                                        </h4>
                                        <span class="text-gray-500 dark:text-gray-400 text-[8px] md:text-[9px] font-bold shrink-0 hidden sm:inline">| {{ strtolower($item['categoria_nombre'] ?? $item['categoria']) }}</span>
                                    </div>
                                    
                                    <p class="text-[8px] md:text-[10px] text-gray-500 dark:text-gray-400 font-bold truncate mt-0.5">
                                        @if($esHospedaje)
                                            {{ $item['cantidad'] }} hab. &times; {{ $item['numero_personas'] ?? 1 }} pers. @if($aplicaDias) &times; {{ $dias }} días @endif
                                        @elseif($esGuianza)
                                            {{ $item['cantidad'] }} guía(s) @if($aplicaDias) &times; {{ $dias }} días @endif
                                        @elseif($esPaquete)
                                            {{ $item['cantidad'] }} paquete(s)
                                        @elseif($esAlquiler)
                                            {{ $item['cantidad'] }} unidad(es) @if($aplicaDias) &times; {{ $dias }} días @endif
                                        @else
                                            {{ $item['cantidad'] }} unidad(es)
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="shrink-0 font-black text-[#00A344] dark:text-[#00D65B] text-sm md:text-lg text-right pl-1 md:pl-2">
                                ${{ number_format($item['subtotal'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between gap-3 md:gap-4 px-4 md:px-8 py-4 bg-white dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 relative z-10 transition-colors">
            
            <div class="flex flex-col min-w-0">
                <span class="text-2xl md:text-4xl font-black text-[#00A344] dark:text-[#00D65B] leading-none truncate">${{ number_format($totalCarrito, 2) }}</span>
                <span class="text-gray-500 dark:text-gray-400 text-[8px] md:text-[10px] font-black uppercase tracking-widest mt-1 truncate">Impuestos incluidos</span>
            </div>
            
            <div class="shrink-0">
                @if($paso === 1 && !empty($carrito))
                    <button wire:click="$set('paso', 2)" 
                            class="px-5 md:px-8 py-2.5 md:py-3.5 rounded-xl uppercase text-[10px] md:text-xs tracking-widest whitespace-nowrap font-black transition-all outline-none bg-[#00A344] hover:bg-green-700 dark:bg-[#00D65B] dark:hover:bg-[#00c052] text-white dark:text-[#06281E] shadow-md shadow-[#00A344]/20 dark:shadow-[#00D65B]/20">
                        Reservar
                    </button>
                @endif

                @if($paso === 3 && !empty($carrito))
                    <button wire:click="finalizarAgendamiento" wire:loading.attr="disabled" class="px-5 md:px-8 py-2.5 md:py-3.5 bg-[#00A344] hover:bg-green-700 dark:bg-[#00D65B] dark:hover:bg-[#00c052] text-white dark:text-[#06281E] font-black rounded-xl transition-all shadow-md shadow-[#00A344]/20 dark:shadow-[#00D65B]/20 uppercase text-[10px] md:text-xs tracking-widest whitespace-nowrap flex items-center gap-2 outline-none">
                        <span wire:loading.remove wire:target="finalizarAgendamiento">Confirmar</span>
                        <span wire:loading wire:target="finalizarAgendamiento" class="flex justify-center items-center gap-1.5 md:gap-2">
                            <svg class="animate-spin size-3.5 md:size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                @endif
            </div>
        </div>
        
    </div>
</div>
@endif