@props(['servicio', 'onSelect' => null])

@php
    $tiposConStock = ['Alquiler de Equipos', 'Hospedaje', 'Guianza', 'Paquetes Turísticos'];
    $nombreTipo = $servicio->tipoServicio->nombre ?? '';
    $gestionaStock = in_array($nombreTipo, $tiposConStock);
    $sinStock = $gestionaStock ? $servicio->stock <= 0 : false;
@endphp

<div wire:key="serv-{{ $servicio->id }}" 
     class="group bg-white border border-gray-200 rounded-2xl p-4 shadow-sm flex flex-col h-full relative overflow-hidden {{ $sinStock ? 'opacity-75 bg-gray-50' : 'hover:border-[#1a4031] transition-colors' }}">
    
    <!-- Contenedor izquierdo: Datos del servicio -->
    <div class="w-full flex-1 flex flex-col">
        <div class="mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">{{ $nombreTipo ?: 'Servicio' }}</p>
            <h3 class="text-xl font-black text-gray-900 leading-tight {{ $sinStock ? 'text-gray-500' : 'group-hover:text-[#1a4031]' }}">
                {{ $servicio->nombre }}
            </h3>
        </div>

        @if($servicio->descripcion)
            <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $servicio->descripcion }}</p>
        @endif

        <!-- Detalles -->
        <div class="flex flex-col gap-2 mt-1 mb-4 text-xs font-medium text-gray-600">
            
            @if($servicio->detalleHospedaje)
                <div class="flex items-start gap-2">
                    <span class="text-gray-400 shrink-0 mt-0.5">👤</span> 
                    <span class="break-words">Capacidad: {{ $servicio->detalleHospedaje->capacidad }} pax</span>
                </div>
            @endif

            @if($servicio->detalleGuianza)
                <div class="flex items-start gap-2">
                    <span class="text-gray-400 shrink-0 mt-0.5">👥</span> 
                    <span class="break-words">Grupo máx: {{ $servicio->detalleGuianza->numero_max_persona }} pax</span>
                </div>
            @endif

            @if($servicio->detalleAlimentacion)
                <div class="flex items-start gap-2 w-full">
                    <span class="text-gray-400 shrink-0 mt-0.5">🍽️</span> 
                    <span class="break-words">Menú: {{ ucfirst($servicio->detalleAlimentacion->tipo_alimentacion) }}</span>
                </div>
                <div class="flex items-start gap-2 w-full">
                    <span class="text-gray-400 shrink-0 mt-0.5">📍</span> 
                    <span class="break-words">Lugar: {{ $servicio->detalleAlimentacion->lugar_alimentacion }}</span>
                </div>
            @endif

            @if($servicio->detallePaqueteTuristico)
                <div class="flex items-start gap-2 w-full">
                    <span class="text-gray-400 shrink-0 mt-0.5">⏱️</span> 
                    <span class="break-words">Duración: {{ $servicio->detallePaqueteTuristico->duracion_dias }} días</span>
                </div>
                <div class="flex items-start gap-2 w-full">
                    <span class="text-gray-400 shrink-0 mt-0.5">📍</span> 
                    <span class="break-words">Salida: {{ $servicio->detallePaqueteTuristico->lugar_salida }}</span>
                </div>
                <div class="flex items-start gap-2 w-full">
                    <span class="text-gray-400 shrink-0 mt-0.5">🕒</span> 
                    <span class="break-words">Inicio: {{ \Carbon\Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i') }}</span>
                </div>
                <div class="flex items-start gap-2 w-full">
                    <span class="text-gray-400 shrink-0 mt-0.5">🚌</span> 
                    <span class="break-words">Cupos: {{ $servicio->stock }}</span>
                </div>
            @endif

            @if($sinStock)
                <div class="mt-2">
                    <span class="inline-flex items-center bg-red-50 px-2 py-1 rounded text-red-700 font-bold text-[10px] uppercase">
                        No disponible
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Contenedor inferior: Precio y botón -->
    <div class="w-full flex flex-row items-center justify-between border-t border-gray-100 pt-4 mt-auto">
        
        <div class="text-2xl font-black {{ $sinStock ? 'text-gray-400' : 'text-gray-900' }}">
            ${{ number_format($servicio->precio, 2) }}
        </div>
        
        <button 
            wire:click="$dispatch('prepararAgendamiento', { id: {{ $servicio->id }} })"
            @disabled($sinStock)
            class="px-5 py-2.5 text-white text-sm font-bold rounded-xl transition-colors shrink-0 {{ $sinStock ? 'bg-gray-300 cursor-not-allowed' : 'bg-[#333333] hover:bg-[#1a4031]' }}">
            {{ $sinStock ? 'No disponible' : 'Agendar' }}
        </button>
        
    </div>
</div>
