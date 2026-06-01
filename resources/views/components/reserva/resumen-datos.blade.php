@props(['datosTurista', 'carrito', 'totalCarrito'])

<div class="bg-white dark:bg-zinc-900 p-6 md:p-12 rounded-3xl shadow-sm border border-gray-200 dark:border-zinc-800 max-w-4xl mx-auto transition-colors">
    
    {{-- Encabezado Factura --}}
    <div class="flex justify-between items-start mb-10 border-b-2 border-black dark:border-white pb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-black dark:text-white uppercase tracking-tighter">Resumen de Reserva</h2>
            <p class="text-[9px] font-bold text-gray-500 mt-2 uppercase tracking-widest">Detalles del servicio</p>
        </div>
        <div class="text-right">
            <p class="text-[9px] font-black text-gray-400 uppercase">Fecha</p>
            <p class="text-sm font-black text-black dark:text-white">{{ date('d/m/Y') }}</p>
        </div>
    </div>

    <div class="space-y-8">
        
        {{-- Datos del Cliente --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 pb-4">
            <div>
                <p class="text-[9px] text-gray-500 uppercase font-black tracking-widest">Identificación</p>
                <p class="text-sm font-black text-black dark:text-white mt-1">{{ $datosTurista['identificacion'] ?? '' }}</p>
            </div>
            <div>
                <p class="text-[9px] text-gray-500 uppercase font-black tracking-widest">Nombres Completos</p>
                <p class="text-sm font-black text-black dark:text-white mt-1">{{ $datosTurista['nombres'] ?? '' }} {{ $datosTurista['apellidos'] ?? '' }}</p>
            </div>
            <div>
                <p class="text-[9px] text-gray-500 uppercase font-black tracking-widest">Correo Electrónico</p>
                <p class="text-sm font-black text-black dark:text-white mt-1">{{ $datosTurista['correo'] ?? '' }}</p>
            </div>
            <div>
                <p class="text-[9px] text-gray-500 uppercase font-black tracking-widest">Teléfono / Edad</p>
                <p class="text-sm font-black text-black dark:text-white mt-1">
                    {{ $datosTurista['telefono'] ?? 'N/A' }} / 
                    <span class="text-[#00A344]">{{ $datosTurista['edad'] ?? '' }} años</span>
                </p>
            </div>
        </div>

        {{-- Tabla de Servicios --}}
        <div class="border border-gray-200 dark:border-zinc-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        {{-- Color de fondo suavizado a un tono charcoal profesional --}}
                        <tr class="bg-[#8fe9aa] text-black text-[10px] uppercase tracking-widest">
                            <th class="py-4 px-4 font-black">Descripción</th>
                            <th class="py-4 px-4 font-black">Fecha / Hora</th>
                            <th class="py-4 px-4 font-black text-center">Desglose</th>
                            <th class="py-4 px-4 font-black text-right">P. Unitario</th>
                            <th class="py-4 px-4 font-black text-right">Importe</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-700 text-sm">
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
                        <tr class="text-black dark:text-gray-200">
                            <td class="py-5 px-4">
                                <span class="font-black block">{{ $item['nombre'] }}</span>
                                <span class="text-[9px] font-black text-gray-500 uppercase">{{ $item['categoria_nombre'] }}</span>
                            </td>
                            <td class="py-5 px-4 text-xs font-bold leading-relaxed">
                                <span class="text-black dark:text-white">Ini:</span> {{ \Carbon\Carbon::parse($fi)->format('Y-m-d') }}<br>
                                <span class="text-black dark:text-white">Fin:</span> {{ \Carbon\Carbon::parse($ff)->format('Y-m-d') }}
                                @if(isset($item['hora']) && $item['hora'] !== '') 
                                    <br><span class="mt-1 inline-block text-[9px] border border-gray-300 dark:border-zinc-700 px-2 py-0.5 rounded">Hora: {{ \Carbon\Carbon::parse($item['hora'])->format('H:i') }}</span> 
                                @endif
                            </td>
                            <td class="py-5 px-4 text-center text-xs font-black">
                                @if($esHospedaje)
                                    {{ $item['cantidad'] }} Hab × {{ $item['numero_personas'] }} Pers. @if($aplicaDias) × {{ $dias }} Días @endif
                                @elseif($esGuianza)
                                    {{ $item['cantidad'] }} Guías @if($aplicaDias) × {{ $dias }} Días @endif
                                @else
                                    {{ $item['cantidad'] }} Unid. @if($aplicaDias) × {{ $dias }} Días @endif
                                @endif
                            </td>
                            <td class="py-5 px-4 text-right font-black">
                                ${{ number_format($item['precio'], 2) }}
                            </td>
                            <td class="py-5 px-4 text-right font-black">
                                ${{ number_format($item['subtotal'], 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100 dark:bg-zinc-800">
                        <tr>
                            <td colspan="4" class="py-5 px-4 text-right font-black uppercase text-[10px] tracking-widest">Total a pagar:</td>
                            <td class="py-5 px-4 text-right font-black text-2xl text-[#00A344]">${{ number_format($totalCarrito, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        {{-- Botones --}}
        <div class="flex gap-4">
            <button wire:click="$set('paso', 2)" class="px-8 py-3 rounded-full border-2 border-black dark:border-white text-black dark:text-white font-black text-[10px] uppercase hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all tracking-widest flex items-center gap-2 outline-none">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Modificar Datos
            </button>
        </div>
    </div>
</div>