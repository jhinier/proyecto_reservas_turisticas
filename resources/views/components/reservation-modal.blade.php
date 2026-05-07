@props(['mostrar' => false, 'servicio' => null, 'fecha' => '', 'cantidad' => 1, 'onClose' => null, 'onConfirm' => null])

@if($mostrar && $servicio)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100">
            
            {{-- Header Modal --}}
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-black text-gray-900 uppercase text-lg tracking-tighter">Configurar Agendamiento</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase">Venta Directa de Empresa</p>
                </div>
                <button {{ $attributes->merge(['wire:click' => $onClose ?? 'cerrarModal']) }} 
                    class="p-2 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-full transition">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-8 space-y-6">
                {{-- Resumen Servicio --}}
                <div class="flex items-center gap-4 bg-zinc-900 p-4 rounded-2xl text-white">
                    <div class="flex-1">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Servicio Seleccionado:</span>
                        <p class="font-black uppercase text-sm leading-tight">{{ $servicio->nombre }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-gray-500 uppercase block tracking-widest">P. Unitario</span>
                        <p class="text-xl font-black text-green-400">${{ number_format($servicio->precio, 2) }}</p>
                    </div>
                </div>

                {{-- Inputs de Reserva (Fecha y Cantidad) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-600 uppercase tracking-widest ml-1">Fecha de Ejecución</label>
                        <input type="date" wire:model="fecha" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-3 font-bold text-sm focus:ring-[#1a4031] focus:border-[#1a4031]">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black text-gray-600 uppercase tracking-widest ml-1">Cantidad / Personas</label>
                        <div class="flex items-center bg-gray-50 border-2 border-gray-100 rounded-2xl p-1">
                            <button type="button" @click="$wire.cantidad > 1 ? $wire.cantidad-- : null" class="size-10 flex items-center justify-center font-bold text-gray-400 hover:text-red-500">-</button>
                            <input type="number" wire:model.live="cantidad" min="1" class="flex-1 bg-transparent border-none text-center font-black text-gray-900 focus:ring-0">
                            <button type="button" @click="$wire.cantidad++" class="size-10 flex items-center justify-center font-bold text-gray-400 hover:text-green-600">+</button>
                        </div>
                    </div>
                </div>

                {{-- Selector de Hora de Llegada --}}
                <x-time-selector :servicio="$servicio" />

                {{-- Footer Modal con Subtotal --}}
                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Subtotal calculado</span>
                        <span class="text-3xl font-black text-gray-900">${{ number_format($servicio->precio * $cantidad, 2) }}</span>
                    </div>
                    <button {{ $attributes->merge(['wire:click' => $onConfirm ?? 'confirmarAgregar']) }} 
                        class="bg-[#1a4031] hover:bg-black text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-xl shadow-green-900/20 active:scale-95">
                        Añadir al Carrito
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
