@props(['carrito', 'paso', 'totalCarrito'])

<aside class="w-full lg:w-1/3 xl:w-1/4 shrink-0">
    <div class="bg-gray-900 rounded-[2.5rem] p-6 md:p-8 shadow-2xl sticky top-6 text-white border border-white/10 overflow-hidden">
        <div class="flex items-center gap-3 mb-6 md:mb-8 overflow-hidden">
            <span class="bg-green-500/20 p-2 rounded-xl shrink-0">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </span>
            <h3 class="font-black text-lg md:text-xl uppercase tracking-tighter truncate min-w-0">Resumen</h3>
        </div>

        @if(empty($carrito))
            <div class="py-8 md:py-12 text-center flex flex-col items-center">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-white/5 rounded-full flex items-center justify-center mb-4 border border-white/10">
                    <span class="text-2xl md:text-3xl">🛒</span>
                </div>
                <p class="text-gray-400 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em]">Bolsa vacia</p>
            </div>
        @else
            <div class="space-y-4 max-h-[40vh] md:max-h-[45vh] overflow-y-auto mb-8 pr-1 custom-scrollbar">
                @foreach($carrito as $index => $item)
                    <div class="bg-white/5 p-3 md:p-4 rounded-2xl border border-white/5 hover:border-white/20 transition-all relative group" wire:key="cart-item-{{ $index }}">
                        @if($paso === 1)
                            <button wire:click="$dispatch('quitar-del-carrito', { index: {{ $index }} })"
                                class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-all shadow-xl">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        @endif
                        <p class="font-black text-[10px] md:text-[11px] leading-tight mb-2 uppercase text-gray-200 truncate">{{ $item['nombre'] }}</p>
                        <div class="flex justify-between items-center gap-2">
                            <span class="bg-white/10 px-2 py-0.5 rounded text-[8px] md:text-[9px] font-black uppercase shrink-0">{{ $item['cantidad'] }} Un.</span>
                            <span class="text-xs font-black text-green-400 shrink-0">${{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-6 border-t border-white/10 space-y-6">
                <div class="flex justify-between items-end px-1">
                    <div class="flex flex-col">
                        <span class="text-gray-500 text-[8px] md:text-[9px] font-black uppercase tracking-widest mb-1">Total</span>
                        <span class="text-2xl md:text-3xl font-black text-white leading-none">${{ number_format($totalCarrito, 2) }}</span>
                    </div>
                </div>
                
                @if($paso === 1)
                    <button wire:click="$set('paso', 2)" class="w-full py-4 md:py-5 bg-green-500 hover:bg-green-400 text-gray-900 font-black rounded-2xl transition-all shadow-lg uppercase text-[10px] md:text-xs tracking-widest">Siguiente Paso</button>
                @endif

                @if($paso === 3)
                    <button wire:click="finalizarAgendamiento" wire:loading.attr="disabled" class="w-full py-4 md:py-5 bg-green-500 hover:bg-green-400 text-gray-900 font-black rounded-2xl transition-all shadow-lg uppercase text-[10px] md:text-xs tracking-widest">
                        <span wire:loading.remove wire:target="finalizarAgendamiento">Confirmar y Terminar</span>
                        <span wire:loading wire:target="finalizarAgendamiento" class="flex justify-center items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Procesando...
                        </span>
                    </button>
                @endif
            </div>
        @endif
    </div>
</aside>