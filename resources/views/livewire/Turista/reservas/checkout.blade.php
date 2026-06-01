<div class="w-full pb-12 bg-transparent min-h-screen font-sans">
    <div class="max-w-4xl mx-auto px-4 pt-8 md:pt-12">
        
        {{-- Indicador de pasos (Stepper) restaurado al estilo original --}}
        <div class="flex items-center justify-center mb-10 overflow-x-auto pb-4">
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full bg-[#00A344] text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-black text-[#00A344] uppercase tracking-widest">Servicios</span>
            </div>
            <div class="w-8 sm:w-16 h-[2px] bg-[#00A344] mx-2 sm:mx-4 shrink-0"></div>
            
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full bg-[#00A344] text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-black text-[#00A344] uppercase tracking-widest">Cliente</span>
            </div>
            <div class="w-8 sm:w-16 h-[2px] bg-[#00A344] mx-2 sm:mx-4 shrink-0"></div>
            
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full border-2 border-[#06281E] text-[#06281E] font-black flex items-center justify-center bg-white shadow-sm">
                    3
                </div>
                <span class="text-xs font-black text-[#06281E] uppercase tracking-widest">Resumen</span>
            </div>
        </div>

        {{-- CONTENEDOR PRINCIPAL TIPO FACTURA PROFESIONAL --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- Encabezado de Factura --}}
            <div class="px-6 py-8 md:px-10 md:py-8 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Resumen de la reserva</h1>
                    <p class="text-sm text-gray-500 mt-1">Revisa los detalles antes de confirmar.</p>
                </div>
                <div class="text-left sm:text-right">
                    <p class="text-xs text-gray-500 font-medium">Fecha de emisión</p>
                    <p class="text-sm font-semibold text-gray-900">{{ now()->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- Sección: Facturado a (Datos del Turista) --}}
            <div class="px-6 py-6 md:px-10 md:py-8 border-b border-gray-100 bg-gray-50/30">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Datos del cliente</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <span class="text-xs text-gray-500 font-medium block mb-1">Nombre completo</span>
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }} {{ Auth::user()->apellidos }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 font-medium block mb-1">Identificación</span>
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->cedula }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 font-medium block mb-1">Correo electrónico</span>
                        <p class="text-sm font-semibold text-gray-900 truncate" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 font-medium block mb-1">Teléfono</span>
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->telefono }}</p>
                    </div>
                </div>
            </div>

            {{-- Sección: Líneas de Servicios (Carrito) --}}
            <div class="px-6 py-6 md:px-10 md:py-8">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Detalle de los servicios</h2>
                
                <div class="w-full">
                    @php $totalPagar = 0; @endphp
                    
                    {{-- Cabecera de la tabla (Solo visible en desktop) --}}
                    <div class="hidden md:grid grid-cols-12 gap-4 text-xs font-semibold text-gray-500 border-b border-gray-200 pb-3 mb-2">
                        <div class="col-span-6">Descripción</div>
                        <div class="col-span-2 text-right">Precio unitario</div>
                        <div class="col-span-2 text-right">Detalles</div>
                        <div class="col-span-2 text-right">Subtotal</div>
                    </div>

                    @foreach($carrito as $index => $item)
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
                        
                        {{-- Fila de Item --}}
                        <div class="py-4 border-b border-gray-100 flex flex-col md:grid md:grid-cols-12 gap-4 items-start md:items-center">
                            
                            {{-- Descripción --}}
                            <div class="col-span-6 w-full">
                                <h3 class="font-bold text-gray-900 text-base">{{ $item['nombre'] }}</h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $fInicio->format('d/m/Y') }} 
                                    @if(isset($item['fecha_fin']) && $item['fecha_fin'] != $item['fecha_inicio'])
                                        - {{ $fFin->format('d/m/Y') }}
                                    @endif
                                    @if(isset($item['hora']))
                                        | {{ \Carbon\Carbon::parse($item['hora'])->format('H:i') }}
                                    @endif
                                </p>
                            </div>
                            
                            {{-- Precio Unitario --}}
                            <div class="col-span-2 w-full flex justify-between md:block md:text-right">
                                <span class="md:hidden text-sm text-gray-500">P. Unitario</span>
                                <span class="text-sm font-medium text-gray-900">${{ number_format($precioUnitario, 2) }}</span>
                            </div>

                            {{-- Detalles (Cantidades) --}}
                            <div class="col-span-2 w-full flex justify-between md:block md:text-right text-sm text-gray-700">
                                <span class="md:hidden text-gray-500">Cantidad</span>
                                <div>
                                    <span class="block">Cant: {{ $item['cantidad'] }}</span>
                                    @if($esHospedaje && isset($item['numero_personas']))
                                        <span class="block">Pers: {{ $item['numero_personas'] }}</span>
                                    @endif
                                    @if($dias > 1 && !$esPaquete)
                                        <span class="block">Días: {{ $dias }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Subtotal --}}
                            <div class="col-span-2 w-full flex justify-between md:block md:text-right mt-2 md:mt-0 pt-2 md:pt-0 border-t md:border-t-0 border-gray-100">
                                <span class="md:hidden text-sm font-semibold text-gray-900">Subtotal</span>
                                <span class="font-bold text-gray-900 text-base">${{ number_format($item['subtotal'], 2) }}</span>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Aviso y Total alineados --}}
                <div class="mt-8 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6">
                    
                    {{-- Aviso sutil restaurado al diseño original amarillo --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 flex gap-4 items-start w-full lg:max-w-md">
                        <svg class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs sm:text-sm text-yellow-800 font-bold leading-relaxed">
                            Tu reserva se registrará en estado <strong class="text-yellow-900 uppercase">Pendiente</strong>. 
                            Una vez confirmada por el establecimiento, tendrás un plazo de 24 horas para realizar el pago.
                        </p>
                    </div>

                    {{-- Total final --}}
                    <div class="w-full lg:w-auto text-right border-t lg:border-t-0 border-gray-200 pt-4 lg:pt-0">
                        <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total a pagar</span>
                        <div class="text-4xl font-bold text-gray-900 mt-1">${{ number_format($totalPagar, 2) }}</div>
                    </div>
                </div>

            </div>

            {{-- Botones de Acción (Confirmar pintado de verde vibrante) --}}
            <div class="bg-gray-50/50 border-t border-gray-200 px-6 py-6 md:px-10 md:py-6 flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button wire:click="volver" type="button" class="w-full sm:w-auto px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-100 transition-colors outline-none text-center">
                    Atrás
                </button>
                <button wire:click="confirmar" wire:loading.attr="disabled" class="w-full sm:w-auto px-8 py-2.5 rounded-lg bg-[#00D65B] text-[#06281E] font-bold text-sm hover:bg-[#00c052] transition-colors outline-none flex items-center justify-center gap-2">
                    <span wire:loading.remove>Confirmar reserva</span>
                    <span wire:loading>Procesando...</span>
                    <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>

        </div>
    </div>
</div>