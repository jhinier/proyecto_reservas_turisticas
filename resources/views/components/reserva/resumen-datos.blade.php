@props(['datosTurista', 'carrito', 'totalCarrito'])

<div class="bg-white p-6 md:p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#CFE2CF]/50 max-w-4xl mx-auto">
    
    {{-- Encabezado --}}
    <div class="flex items-center gap-4 mb-8">
        <span class="bg-[#F2F7F2] p-3 rounded-2xl shadow-sm border border-[#CFE2CF]/50">
            <svg class="size-6 text-[#32744C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </span>
        <h2 class="text-2xl font-black text-[#4C4F26] uppercase tracking-tighter">Resumen de Datos</h2>
    </div>

    <div class="space-y-6">
        
        {{-- Tarjeta de Información del Turista --}}
        <div class="bg-[#F9FBF9] rounded-3xl p-6 md:p-8 border border-[#CFE2CF]/60 shadow-inner">
            <h3 class="text-xs font-black text-[#8DBEA2] uppercase tracking-widest mb-5">Información del Turista</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                <div>
                    <p class="text-[10px] text-[#8DBEA2] uppercase font-bold tracking-wider">Identificación</p>
                    <p class="text-sm md:text-base font-black text-[#4C4F26] mt-0.5">{{ $datosTurista['identificacion'] ?? '' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-[#8DBEA2] uppercase font-bold tracking-wider">Nombres Completos</p>
                    <p class="text-sm md:text-base font-black text-[#4C4F26] mt-0.5">{{ $datosTurista['nombres'] ?? '' }} {{ $datosTurista['apellidos'] ?? '' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-[#8DBEA2] uppercase font-bold tracking-wider">Correo Electrónico</p>
                    <p class="text-sm md:text-base font-black text-[#4C4F26] mt-0.5 truncate">{{ $datosTurista['correo'] ?? '' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-[#8DBEA2] uppercase font-bold tracking-wider">Teléfono y Edad</p>
                    <p class="text-sm md:text-base font-black text-[#4C4F26] mt-0.5">{{ $datosTurista['telefono'] ?? 'No especificado' }} / <span class="text-[#32744C]">{{ $datosTurista['edad'] ?? '' }} años</span></p>
                </div>
            </div>
        </div>

        {{-- Tarjeta de Detalles de Servicios (Tabla Responsive) --}}
        <div class="bg-[#F9FBF9] rounded-3xl p-6 md:p-8 border border-[#CFE2CF]/60 shadow-inner">
            <h3 class="text-xs font-black text-[#8DBEA2] uppercase tracking-widest mb-5">Detalle de los Servicios</h3>
            
            <div class="overflow-x-auto [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-thumb]:bg-[#CFE2CF] [&::-webkit-scrollbar-thumb]:rounded-full">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="border-b border-[#CFE2CF]/80 text-[10px] uppercase tracking-widest text-[#8DBEA2]">
                            <th class="pb-4 font-black w-1/3">Servicio</th>
                            <th class="pb-4 font-black">Fecha / Hora</th>
                            <th class="pb-4 font-black text-center">Desglose de Cantidad</th>
                            <th class="pb-4 font-black text-right">P. Unitario</th>
                            <th class="pb-4 font-black text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($carrito as $item)
                        @php
                            $fi = $item['fecha_inicio'] ?? $item['fecha'] ?? now();
                            $ff = $item['fecha_fin'] ?? $fi;
                            $dias = max(1, \Carbon\Carbon::parse($fi)->diffInDays(\Carbon\Carbon::parse($ff)) + 1);
                            
                            $nombreCat = strtolower($item['categoria_nombre'] ?? '');
                            $esHospedaje = str_contains($nombreCat, 'hospedaje');
                            $esGuianza = str_contains($nombreCat, 'guianza');
                            $esPaquete = str_contains($nombreCat, 'paquete');
                            
                            $aplicaDias = $dias > 1 && !$esPaquete && !str_contains($nombreCat, 'aliment');
                        @endphp
                        <tr class="border-b border-[#CFE2CF]/40 last:border-0 hover:bg-white transition-colors">
                            <td class="py-4 pr-4">
                                <span class="font-black text-[#4C4F26] block leading-tight">{{ $item['nombre'] }}</span>
                                <span class="text-[9px] font-bold text-[#8DBEA2] uppercase mt-1 inline-block bg-[#E8EFE8] px-2 py-0.5 rounded-md">{{ $item['categoria_nombre'] }}</span>
                            </td>
                            <td class="py-4 text-[#8DBEA2] text-xs font-bold leading-relaxed">
                                <span class="text-[#4C4F26]">Ini:</span> {{ $item['fecha'] ?? 'Sin fecha' }}
                                @if(isset($item['fecha_fin']) && $item['fecha_fin'] !== $item['fecha'])
                                    <br><span class="text-[#4C4F26]">Fin:</span> {{ $item['fecha_fin'] }}
                                @endif
                                @if(isset($item['hora']) && $item['hora'] !== '') 
                                    <br><span class="inline-block mt-1 text-[#4C4F26] bg-white border border-[#CFE2CF] px-2 py-0.5 rounded shadow-sm text-[10px]">Hora: {{ \Carbon\Carbon::parse($item['hora'])->format('H:i') }}</span> 
                                @endif
                            </td>
                            <td class="py-4 text-center text-[11px] font-black text-[#8DBEA2] whitespace-nowrap">
                                @if($esHospedaje)
                                    <span class="text-[#4C4F26]">{{ $item['cantidad'] }}</span> Hab. &times; <span class="text-[#4C4F26]">{{ $item['numero_personas'] }}</span> Pers. 
                                    @if($aplicaDias) &times; <span class="text-[#32744C]">{{ $dias }} Días</span> @endif
                                @elseif($esGuianza)
                                    <span class="text-[#4C4F26]">{{ $item['cantidad'] }}</span> Guías
                                    @if($aplicaDias) &times; <span class="text-[#32744C]">{{ $dias }} Días</span> @endif
                                @elseif($esPaquete)
                                    <span class="text-[#4C4F26]">{{ $item['cantidad'] }}</span> Paquetes
                                @else
                                    <span class="text-[#4C4F26]">{{ $item['cantidad'] }}</span> Unidades
                                    @if($aplicaDias) &times; <span class="text-[#32744C]">{{ $dias }} Días</span> @endif
                                @endif
                            </td>
                            <td class="py-4 text-right font-black text-[#4C4F26]">
                                ${{ number_format($item['precio'], 2) }}
                            </td>
                            <td class="py-4 text-right font-black text-[#32744C] text-lg">
                                ${{ number_format($item['subtotal'], 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="pt-8 text-right font-black text-[#8DBEA2] uppercase text-[10px] tracking-widest pr-6">Total a pagar:</td>
                            <td class="pt-8 text-right font-black text-3xl md:text-4xl text-[#32744C] leading-none">${{ number_format($totalCarrito, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        {{-- Botones de Acción inferior --}}
        <div class="flex gap-4 pt-4">
            <button wire:click="$set('paso', 2)" class="px-8 py-3.5 rounded-full border-2 border-[#CFE2CF] text-[#8DBEA2] font-black text-[10px] md:text-xs uppercase hover:bg-[#F2F7F2] hover:text-[#32744C] hover:border-[#8DBEA2] transition-colors tracking-widest flex items-center gap-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Modificar Datos
            </button>
        </div>
    </div>
</div>