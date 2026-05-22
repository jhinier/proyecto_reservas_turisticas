<div class="w-full bg-white text-[#4C4F26] rounded-[2rem] p-6 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#CFE2CF]">

    {{-- Encabezado --}}
    <div class="flex items-center gap-3 mb-2 border-b border-[#CFE2CF]/60 pb-6">
        <svg class="size-6 text-[#32744C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h3 class="text-xl font-black tracking-wide">Detalle de la Reserva</h3>
    </div>

    {{-- Lista de ítems (Formato Lista/Recibo Horizontal) --}}
    <div class="flex flex-col">
        @forelse($items as $index => $item)
            @php
                $cat = strtolower($item['categoria_nombre'] ?? $item['categoria'] ?? '');
                $esHosp = str_contains($cat, 'hospedaje');
                $esGuia = str_contains($cat, 'guianza');
                $esPaq  = str_contains($cat, 'paquete');
                $esAlq  = str_contains($cat, 'alquiler');
            @endphp

            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-5 border-b border-[#CFE2CF]/50 gap-4 relative group hover:bg-[#F9FBF9] transition-colors -mx-4 px-4 rounded-xl">

                {{-- Izquierda: Info del Servicio --}}
                <div class="flex items-start gap-3 md:gap-4">
                    
                    {{-- Badge estilo referencia (Personas / Cantidad) --}}
                    <div class="bg-[#CFE2CF]/40 text-[#4C4F26] px-2.5 py-1.5 rounded-lg flex items-center gap-1.5 shrink-0 mt-0.5">
                        @if($esHosp || $esGuia)
                            <svg class="size-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span class="font-black text-xs">{{ $item['numero_personas'] ?? 1 }}</span>
                        @else
                            <svg class="size-3.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span class="font-black text-xs">{{ $item['cantidad'] ?? 1 }}</span>
                        @endif
                    </div>

                    {{-- Textos (Nombre | Categoría) --}}
                    <div>
                        <div class="flex flex-wrap items-baseline gap-x-2">
                            <h4 class="font-black text-[15px] md:text-base text-[#4C4F26] leading-tight">
                                {{ $item['nombre'] }}
                            </h4>
                            <span class="text-[#8DBEA2] text-xs font-bold">| {{ $item['categoria'] }}</span>
                        </div>

                        {{-- Fechas y Horas (Sutiles debajo del nombre) --}}
                        <div class="mt-1.5 text-[11px] text-[#8DBEA2] font-bold flex flex-wrap gap-x-4 gap-y-1">
                            <span class="flex items-center gap-1">
                                <span class="opacity-70">📅</span> 
                                {{ \Carbon\Carbon::parse($item['fecha_inicio'])->format('d M, Y') }}
                                @if(isset($item['fecha_fin']) && $item['fecha_fin'] !== $item['fecha_inicio'])
                                    → {{ \Carbon\Carbon::parse($item['fecha_fin'])->format('d M, Y') }}
                                @endif
                            </span>
                            @if(!empty($item['hora']))
                                <span class="flex items-center gap-1">
                                    <span class="opacity-70">🕐</span> {{ \Carbon\Carbon::parse($item['hora'])->format('H:i') }}
                                </span>
                            @endif
                            @if($esHosp)
                                <span class="flex items-center gap-1">
                                    <span class="opacity-70">🛏</span> {{ $item['cantidad'] }} hab.
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Derecha: Precio y Eliminar --}}
                <div class="flex items-center justify-between sm:justify-end gap-6 sm:w-auto w-full mt-2 sm:mt-0 pl-14 sm:pl-0">
                    <span class="font-black text-[#32744C] text-lg md:text-xl">
                        ${{ number_format($item['subtotal'], 2) }}
                    </span>
                    
                    <button wire:click="eliminar({{ $index }})"
                            class="text-[#8DBEA2] hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50 bg-white sm:bg-transparent shadow-sm sm:shadow-none border border-[#CFE2CF] sm:border-transparent"
                            title="Quitar servicio">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        @empty
            <div class="text-center py-16 w-full">
                <svg class="size-14 mx-auto mb-4 text-[#CFE2CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p class="text-sm font-black text-[#8DBEA2] uppercase tracking-widest">Lista Vacía</p>
                <p class="text-xs mt-1 text-[#8DBEA2] font-bold">Aún no has agregado ningún servicio a tu reserva.</p>
            </div>
        @endforelse
    </div>

    {{-- Bloque de Totales Inferior (Exactamente como tu captura) --}}
    @if(count($items) > 0)
        <div class="mt-10 pt-2 flex flex-col sm:flex-row sm:items-end justify-between gap-6 border-t-0">
            
            {{-- Textos de Total e Impuestos a la izquierda --}}
            <div class="flex flex-col text-left">
                <span class="block text-4xl font-black text-[#32744C] leading-none mb-1">
                    ${{ number_format(collect($items)->sum('subtotal'), 2) }}
                </span>
                <span class="block text-[11px] font-black text-[#8DBEA2] uppercase tracking-widest">
                    Impuestos incluidos
                </span>
            </div>

            {{-- Botón a la derecha --}}
            @if($pasoActual === 1)
                <button wire:click="$dispatch('cambiar-paso', { nuevoPaso: 2 })"
                        class="w-full sm:w-auto bg-[#32744C] hover:bg-[#4C4F26] text-white px-10 py-4 rounded-xl font-black uppercase text-xs tracking-widest shadow-md transition-colors text-center">
                    Continuar
                </button>
            @elseif($pasoActual === 2)
                <div class="text-center p-3 rounded-xl bg-[#F9FBF9] border border-[#CFE2CF] text-xs font-bold text-[#8DBEA2] w-full sm:w-auto">
                    Complete los datos del cliente para finalizar.
                </div>
            @endif
        </div>
    @endif
</div>