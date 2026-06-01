@props(['carrito', 'totalCarrito', 'personasBusqueda' => 1, 'categoriaFiltro' => '', 'metaAlcanzada' => false])

@php
    $catLower = strtolower($categoriaFiltro);
    $esHospedajeOGuianza = str_contains($catLower, 'hospedaje') || str_contains($catLower, 'guianza');
    $puedeContinuar = $metaAlcanzada || !$esHospedajeOGuianza;
@endphp

@if(!empty($carrito))
<div class="fixed bottom-0 left-0 right-0 z-50 transition-transform duration-300" x-data="{ mostrarLista: true }" @servicio-agregado.window="mostrarLista = true">
    <div class="max-w-6xl mx-auto md:px-4">
        <div class="bg-white shadow-[0_-10px_30px_rgba(0,0,0,0.1)] border-t md:border-x md:border-t border-gray-300 w-full flex flex-col rounded-t-3xl overflow-hidden">
            
            <button x-on:click="mostrarLista = !mostrarLista" class="w-full flex items-center justify-center gap-2 py-3 text-gray-500 hover:text-[#06281E] transition-colors text-xs font-black uppercase tracking-widest bg-gray-50 border-b border-gray-200 outline-none">
                <span x-text="mostrarLista ? 'Ocultar reserva' : 'Ver reserva'"></span>
                <svg class="w-4 h-4 transition-transform duration-300" x-bind:class="mostrarLista ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="mostrarLista" x-collapse class="max-h-[40vh] overflow-y-auto px-4 md:px-8 bg-white custom-scrollbar">
                <div class="flex flex-col py-2 space-y-3 mt-2">
                    @foreach($carrito as $index => $item)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 gap-4" wire:key="cart-item-{{ $index }}">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <button wire:click="$dispatch('quitar-del-carrito', { index: {{ $index }} })" class="text-gray-400 hover:text-red-500 transition-colors bg-gray-50 hover:bg-red-50 w-7 h-7 flex items-center justify-center rounded-full shrink-0 border border-gray-200 outline-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                <div class="bg-gray-100 text-[#06281E] px-2.5 py-1 rounded-md border border-gray-200 flex items-center gap-1.5 shrink-0">
                                    <span class="font-black text-[11px]">{{ $item['cantidad'] ?? 1 }}</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <h4 class="font-black text-sm text-[#06281E] truncate">{{ $item['nombre'] }}</h4>
                                    <p class="text-[10px] text-gray-500 font-bold truncate mt-0.5">
                                        @if(str_contains(strtolower($item['categoria']), 'hospedaje'))
                                            {{ $item['cantidad'] }} hab. &times; {{ $item['numero_personas'] ?? 1 }} pers.
                                        @elseif(str_contains(strtolower($item['categoria']), 'guianza'))
                                            {{ $item['cantidad'] }} guía(s)
                                        @else
                                            {{ $item['cantidad'] }} unidad(es)
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0 font-black text-[#00D65B] text-lg text-right">
                                ${{ number_format($item['subtotal'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 px-6 md:px-8 py-5 bg-white border-t border-gray-200">
                <div class="flex flex-col min-w-0">
                    <span class="text-3xl font-black text-[#06281E] leading-none">${{ number_format($totalCarrito, 2) }}</span>
                    <span class="text-gray-400 text-[10px] font-black uppercase tracking-widest mt-1">Total a pagar</span>
                </div>
                
                <div class="shrink-0">
                    <button wire:click="irAlCheckout" 
                            @disabled(!$puedeContinuar)
                            class="px-8 py-3.5 rounded-full uppercase text-xs tracking-widest font-black transition-all flex items-center gap-2 border-2 border-black outline-none {{ $puedeContinuar ? 'bg-[#00D65B] text-black shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)]' : 'bg-gray-200 text-gray-400 cursor-not-allowed border-gray-300' }}">
                        Reservar
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endif