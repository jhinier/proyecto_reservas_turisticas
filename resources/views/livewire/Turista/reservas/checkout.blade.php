<div class="w-full pb-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 pt-10">
        
        {{-- Indicador de pasos (Stepper) --}}
        <div class="flex items-center justify-center mb-10 overflow-x-auto pb-4">
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full bg-[#00A344] text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-black text-[#00A344] uppercase tracking-widest">Servicios</span>
            </div>
            <div class="w-10 sm:w-16 h-[2px] bg-[#00A344] mx-2 sm:mx-4 shrink-0"></div>
            
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full bg-[#00A344] text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-black text-[#00A344] uppercase tracking-widest">Cliente</span>
            </div>
            <div class="w-10 sm:w-16 h-[2px] bg-[#00A344] mx-2 sm:mx-4 shrink-0"></div>
            
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full border-2 border-[#06281E] text-[#06281E] font-black flex items-center justify-center bg-white shadow-sm">
                    3
                </div>
                <span class="text-xs font-black text-[#06281E] uppercase tracking-widest">Resumen</span>
            </div>
        </div>

        {{-- Contenedor principal --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-200 p-6 sm:p-10">
            <h1 class="text-2xl sm:text-3xl font-black text-[#06281E] mb-8 uppercase tracking-wide">Resumen de tu reserva</h1>

            {{-- Sección de datos del turista --}}
            <div class="mb-10">
                <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Datos del turista</h2>
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest block mb-1">Nombres y Apellidos</span>
                            <p class="text-base font-bold text-gray-900">{{ Auth::user()->name }} {{ Auth::user()->apellidos }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest block mb-1">Identificación</span>
                            <p class="text-base font-bold text-gray-900">{{ Auth::user()->cedula }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest block mb-1">Correo electrónico</span>
                            <p class="text-base font-bold text-gray-900">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest block mb-1">Teléfono</span>
                            <p class="text-base font-bold text-gray-900">{{ Auth::user()->telefono }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección de servicios en el carrito --}}
            <div class="mb-10">
                <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Detalle de los servicios</h2>
                <div class="space-y-4">
                    @php $totalPagar = 0; @endphp
                    @foreach($carrito as $item)
                        @php 
                            $totalPagar += $item['subtotal']; 
                            $fInicio = \Carbon\Carbon::parse($item['fecha_inicio']);
                            $fFin = isset($item['fecha_fin']) ? \Carbon\Carbon::parse($item['fecha_fin']) : $fInicio;
                            $dias = max(1, $fInicio->diffInDays($fFin) + 1);
                            
                            $precioUnitario = $item['precio_unitario'] ?? $item['precio'] ?? ($item['subtotal'] / max(1, $item['cantidad']));
                            $categoria = strtolower($item['categoria'] ?? '');
                            $esHospedaje = str_contains($categoria, 'hospedaje');
                            $esPaquete = str_contains($categoria, 'paquete');
                        @endphp
                        
                        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col sm:flex-row justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-black text-[#06281E] text-base mb-2">{{ $item['nombre'] }}</h3>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <div>
                                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Precio base</span>
                                        <span class="font-bold">${{ number_format($precioUnitario, 2) }}</span>
                                    </div>
                                    
                                    <div>
                                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Cantidad</span>
                                        <span class="font-bold">x{{ $item['cantidad'] }}</span>
                                    </div>

                                    @if($esHospedaje && isset($item['numero_personas']))
                                    <div>
                                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Personas</span>
                                        <span class="font-bold">x{{ $item['numero_personas'] }}</span>
                                    </div>
                                    @endif

                                    @if($dias > 1 && !$esPaquete)
                                    <div>
                                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Días</span>
                                        <span class="font-bold">x{{ $dias }}</span>
                                    </div>
                                    @endif
                                </div>

                                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide mt-3">
                                    <span class="text-[#00A344]">Inicio:</span> {{ $fInicio->format('d/m/Y') }}
                                    @if(isset($item['fecha_fin']) && $item['fecha_fin'] != $item['fecha_inicio'])
                                        <span class="mx-1">|</span> <span class="text-red-500">Fin:</span> {{ $fFin->format('d/m/Y') }}
                                    @endif
                                    @if(isset($item['hora']))
                                        <span class="mx-1">|</span> Hora: {{ \Carbon\Carbon::parse($item['hora'])->format('H:i') }}
                                    @endif
                                </p>
                            </div>
                            
                            <div class="flex flex-col justify-center items-end border-t sm:border-t-0 sm:border-l border-gray-100 pt-4 sm:pt-0 sm:pl-4 mt-2 sm:mt-0">
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Subtotal</span>
                                <div class="font-black text-[#00D65B] text-2xl">
                                    ${{ number_format($item['subtotal'], 2) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total final --}}
            <div class="flex justify-between items-end border-t border-gray-200 pt-6 mb-8">
                <span class="text-gray-500 font-black uppercase tracking-widest text-xs">Total de la reserva</span>
                <span class="text-4xl sm:text-5xl font-black text-[#06281E]">${{ number_format($totalPagar, 2) }}</span>
            </div>

            {{-- Aviso de pago --}}
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 mb-8 flex gap-4 items-start">
                <svg class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-xs sm:text-sm text-yellow-800 font-bold leading-relaxed">
                    Tu reserva se registrará en estado <strong class="text-yellow-900 uppercase">Pendiente</strong>. 
                    Una vez confirmada por el establecimiento, tendrás un plazo de 24 horas para realizar el pago.
                </p>
            </div>

            {{-- Botones de acción --}}
            <div class="flex flex-col-reverse sm:flex-row justify-between gap-4">
                <button wire:click="volver" type="button" class="w-full sm:w-auto px-8 py-4 rounded-xl border-2 border-gray-200 text-gray-600 font-black uppercase text-xs tracking-widest hover:bg-gray-50 hover:border-gray-300 transition outline-none text-center flex items-center justify-center">
                    Atrás
                </button>
                <button wire:click="confirmar" wire:loading.attr="disabled" class="w-full sm:flex-1 bg-[#06281E] text-white py-4 px-6 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-black transition shadow-[3px_3px_0px_0px_rgba(0,0,0,0.2)] active:translate-y-[2px] active:translate-x-[2px] active:shadow-none outline-none flex items-center justify-center gap-2">
                    <span wire:loading.remove>Confirmar y guardar</span>
                    <span wire:loading>Procesando...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

        </div>
    </div>
</div>