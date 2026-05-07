@props(['datosTurista', 'carrito', 'totalCarrito'])

<div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
    <div class="flex items-center gap-3 mb-6">
        <span class="bg-[#1a4031]/10 p-2 rounded-xl">
            <svg class="size-6 text-[#1a4031]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </span>
        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Resumen de Datos</h2>
    </div>

    <div class="space-y-6">
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-4">Información del Turista</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Identificación</p>
                    <p class="text-sm font-black text-gray-800">{{ $datosTurista['identificacion'] ?? '' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Nombres Completos</p>
                    <p class="text-sm font-black text-gray-800">{{ $datosTurista['nombres'] ?? '' }} {{ $datosTurista['apellidos'] ?? '' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Correo Electrónico</p>
                    <p class="text-sm font-black text-gray-800 truncate">{{ $datosTurista['correo'] ?? '' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Teléfono y Edad</p>
                    <p class="text-sm font-black text-gray-800">{{ $datosTurista['telefono'] ?? 'No especificado' }} / {{ $datosTurista['edad'] ?? '' }} años</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-4">Detalle de los Servicios</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-[10px] uppercase tracking-widest text-gray-400">
                            <th class="pb-3 font-bold">Servicio</th>
                            <th class="pb-3 font-bold">Fecha / Hora</th>
                            <th class="pb-3 font-bold text-center">Cant.</th>
                            <th class="pb-3 font-bold text-right">P. Unitario</th>
                            <th class="pb-3 font-bold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($carrito as $item)
                        <tr class="border-b border-gray-100 last:border-0">
                            <td class="py-3 font-black text-gray-800">{{ $item['nombre'] }}</td>
                            <td class="py-3 text-gray-600">
                                <span class="font-bold text-gray-800">Ini:</span> {{ $item['fecha'] ?? 'Sin fecha' }}
                                @if(isset($item['fecha_fin']) && $item['fecha_fin'] !== $item['fecha'])
                                    <br><span class="font-bold text-gray-800">Fin:</span> {{ $item['fecha_fin'] }}
                                @endif
                                @if(isset($item['hora']) && $item['hora'] !== '') 
                                    <br><span class="text-xs text-gray-400">Hora: {{ $item['hora'] }}</span> 
                                @endif
                            </td>
                            <td class="py-3 text-center font-bold text-gray-800">{{ $item['cantidad'] }}</td>
                            <td class="py-3 text-right text-gray-600">${{ number_format($item['precio_unitario'] ?? ($item['subtotal'] / $item['cantidad']), 2) }}</td>
                            <td class="py-3 text-right font-black text-[#1a4031]">${{ number_format($item['subtotal'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="text-sm">
                            <td colspan="4" class="pt-4 text-right font-bold text-gray-500 uppercase text-[10px] tracking-widest">Total a pagar:</td>
                            <td class="pt-4 text-right font-black text-xl text-gray-900">${{ number_format($totalCarrito, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="flex gap-4">
            <button wire:click="$set('paso', 2)" class="px-6 py-3 rounded-xl border-2 border-gray-200 text-gray-600 font-black text-xs uppercase hover:bg-gray-50 transition-colors">Modificar Datos</button>
        </div>
    </div>
</div>