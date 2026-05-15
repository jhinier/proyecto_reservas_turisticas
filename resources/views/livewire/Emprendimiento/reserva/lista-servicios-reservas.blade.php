<div class="space-y-4">

    {{-- Skeleton mientras carga la categoría --}}
    <div wire:loading.flex wire:target="filtroCategoria" class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-pulse">
        @for ($i = 0; $i < 2; $i++)
            <div class="h-48 bg-gray-200 rounded-3xl"></div>
        @endfor
    </div>

    @if($busquedaActiva ?? false)

        @php
            $catLower       = strtolower($nombreCategoria ?? '');
            $esHospedajeV   = str_contains($catLower, 'hospedaje');
            $esGuianzaV     = str_contains($catLower, 'guianza');
            $esPaqueteV     = str_contains($catLower, 'paquete');
            $esAlquilerV    = str_contains($catLower, 'alquiler');
            $tieneMetaV     = $esHospedajeV || $esGuianzaV;

            // Recalculamos personas separando por categoría para evitar bloqueos cruzados
            $personasAcomodadas = 0;
            if ($tieneMetaV && !empty($carrito)) {
                foreach ($carrito as $item) {
                    $itemCat = strtolower($item['categoria_nombre'] ?? '');
                    if ($esHospedajeV && str_contains($itemCat, 'hospedaje')) {
                        $personasAcomodadas += (int) ($item['capacidad_aportada'] ?? 0);
                    } elseif ($esGuianzaV && str_contains($itemCat, 'guianza')) {
                        $personasAcomodadas += (int) ($item['capacidad_aportada'] ?? 0);
                    }
                }
            }
            $metaBloqueada = $tieneMetaV && ($personasAcomodadas >= (int) ($personasBusqueda ?? 1));
        @endphp

        {{-- Banner informativo si se bloquean las tarjetas --}}
        @if($metaBloqueada)
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-2xl px-5 py-3">
                <svg class="size-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-bold text-green-800">
                    ¡Capacidad cubierta para tu grupo! Elimina un servicio del resumen si deseas cambiar la selección.
                </p>
            </div>
        @endif

        <div wire:loading.remove wire:target="filtroCategoria" class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            @forelse($this->servicios as $servicio)

                @php
                    $restantes = max(0, (int)($personasBusqueda ?? 1) - $personasAcomodadas);
                    $sugerido  = min($restantes, $servicio->capacidad_unitaria);
                    $sugerido  = max(1, $sugerido); // Que inicie mínimo en 1 para que no se vea feo el diseño
                @endphp

                <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-sm flex flex-col justify-between transition duration-300 {{ $metaBloqueada ? 'opacity-50 pointer-events-none' : '' }}"
                     wire:key="srv-{{ $servicio->id }}">

                    {{-- Cabecera: nombre + cupos --}}
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-black text-lg text-gray-900 leading-tight">
                                {{ $servicio->nombre }}
                            </h4>
                            <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-1 rounded-md whitespace-nowrap">
                                {{ $servicio->cupos_libres }} disponibles
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $servicio->descripcion }}</p>

                        {{-- Info de capacidad --}}
                        @if($servicio->detalleHospedaje)
                            <p class="text-[10px] text-indigo-500 font-semibold mb-2">
                                🛏 Capacidad por habitación: {{ $servicio->detalleHospedaje->capacidad }} personas
                            </p>
                        @elseif($servicio->detalleGuianza)
                            <p class="text-[10px] text-indigo-500 font-semibold mb-2">
                                🧭 Máx. personas por guía: {{ $servicio->detalleGuianza->numero_max_persona }}
                            </p>
                        @elseif($servicio->detallePaqueteTuristico)
                            <p class="text-[10px] text-indigo-500 font-semibold mb-2">
                                📦 Duración: {{ $servicio->detallePaqueteTuristico->duracion_dias ?? '?' }} días
                                @if(!empty($servicio->detallePaqueteTuristico->hora_salida))
                                    &nbsp;·&nbsp; 🕐 Salida:
                                    {{ \Carbon\Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i') }}
                                @endif
                            </p>
                        @endif

                        {{-- Precio Unitario Base --}}
                        <p class="text-xl font-black text-[#1a4031]">
                            ${{ number_format($servicio->precio, 2) }}
                            <span class="text-[10px] text-gray-400 font-normal">
                                @if($esHospedajeV)
                                    / por persona
                                @elseif($esGuianzaV)
                                    / por guía
                                @else
                                    / unidad
                                @endif
                            </span>
                        </p>
                    </div>

                    {{-- Sistema de controles condicional --}}
                    @if($esHospedajeV || $esGuianzaV)
                        {{-- Interfaz interactiva para hospedaje/guianza --}}
                        <div x-data="{
                                esGuianza: {{ $esGuianzaV ? 'true' : 'false' }},
                                maxPersonas: {{ $servicio->capacidad_unitaria }},
                                personas: {{ $sugerido }},
                                cantidad: 1,
                                precioUnitario: {{ $servicio->precio }},
                                dias: {{ max(1, \Carbon\Carbon::parse($fechaBusqueda ?: now())->diffInDays(\Carbon\Carbon::parse($fechaFinBusqueda ?: $fechaBusqueda ?: now())) + 1) }},
                                get total() { 
                                    return this.esGuianza 
                                        ? (this.cantidad * this.precioUnitario * this.dias)
                                        : (this.personas * this.cantidad * this.precioUnitario * this.dias);
                                }
                            }"
                            class="mt-4 pt-4 border-t border-gray-100">

                            <div class="flex flex-col gap-4 mb-4">
                                {{-- Fila 1: Cantidad y Hora --}}
                                <div class="flex gap-3 items-end">
                                    @if($esGuianzaV)
                                        {{-- Selector de cantidad (Solo se muestra para guías) --}}
                                        <div class="w-1/2">
                                            <label class="block text-[10px] font-black text-gray-500 uppercase mb-1">Guías</label>
                                            <input type="number" x-model.number="cantidad" min="1" max="{{ $servicio->cupos_libres }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2 text-sm text-center focus:ring-1 focus:ring-[#1a4031]">
                                        </div>
                                    @endif

                                    {{-- Hora (Hospedaje: Ancho completo | Guianza: Mitad) --}}
                                    <div class="w-full {{ $esGuianzaV ? 'w-1/2' : '' }}">
                                        <label class="block text-[10px] font-black text-gray-500 uppercase mb-1">Hora</label>
                                        <input type="time" wire:model.blur="horas.{{ $servicio->id }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2 text-sm focus:ring-1 focus:ring-[#1a4031]">
                                    </div>
                                </div>

                                @if($esHospedajeV)
                                    {{-- Fila 2: Selector de personas (Solo se muestra para hospedaje) --}}
                                    <div class="w-full">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Pers. / Hab.</span>
                                            <div class="text-[10px] font-black text-gray-900">
                                                <span x-text="personas"></span> / <span x-text="maxPersonas" class="text-gray-400"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" x-on:click="if(personas > 1) personas--" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors" x-bind:disabled="personas <= 1">
                                                <svg class="size-3 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                            </button>
                                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-[#1a4031] transition-all duration-300" x-bind:style="'width: ' + ((personas / maxPersonas) * 100) + '%'"></div>
                                            </div>
                                            <button type="button" x-on:click="if(personas < maxPersonas) personas++" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors" x-bind:disabled="personas >= maxPersonas">
                                                <svg class="size-3 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Total Dinámico Único --}}
                            <div class="flex justify-between items-center bg-[#faf9f4] border border-[#f0eee4] rounded-xl p-4 mb-4">
                                <p class="font-black text-gray-900 text-sm">Total a pagar</p>
                                <p class="text-xl font-black text-[#1a4031]">$<span x-text="total.toFixed(2)"></span></p>
                            </div>

                            <button type="button" x-on:click="$wire.agregarHospedaje({{ $servicio->id }}, personas, cantidad)" class="w-full py-3 bg-[#1a4031] hover:bg-green-900 text-white text-sm font-bold rounded-xl transition flex justify-center items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" @disabled($metaBloqueada)>
                                <span>{{ $esHospedajeV ? 'Añadir habitación' : 'Añadir guianza' }}</span>
                            </button>
                        </div>
                    @else
                        {{-- Controles tradicionales --}}
                        <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col sm:flex-row gap-3 items-end">
                            <div class="w-full sm:w-24">
                                <label class="block text-[10px] font-black text-gray-500 uppercase mb-1">
                                    @if($esAlquilerV) Unidades @elseif($esPaqueteV) Paquetes @else Cant. @endif
                                </label>
                                <input type="number"
                                       wire:model.blur="cantidades.{{ $servicio->id }}"
                                       min="1"
                                       max="{{ $servicio->cupos_libres }}"
                                       @disabled($metaBloqueada)
                                       class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2 text-sm text-center focus:ring-1 focus:ring-[#1a4031] disabled:opacity-50 disabled:cursor-not-allowed">
                            </div>

                            @if(!$esPaqueteV)
                                <div class="w-full sm:w-32">
                                    <label class="block text-[10px] font-black text-gray-500 uppercase mb-1">Hora</label>
                                    <input type="time"
                                           wire:model.blur="horas.{{ $servicio->id }}"
                                           @disabled($metaBloqueada)
                                           class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2 text-sm focus:ring-1 focus:ring-[#1a4031] disabled:opacity-50 disabled:cursor-not-allowed">
                                </div>
                            @endif

                            <button wire:click="agregarServicio({{ $servicio->id }})"
                                    @disabled($metaBloqueada)
                                    class="w-full sm:w-auto flex-1 px-4 py-2 bg-[#1a4031] hover:bg-green-900 text-white text-sm font-bold rounded-xl transition disabled:opacity-50 disabled:cursor-not-allowed">
                                @if($esPaqueteV)
                                    Reservar paquete
                                @else
                                    Añadir
                                @endif
                            </button>
                        </div>
                    @endif
                </div>

            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-gray-200">
                    <span class="text-3xl block mb-2 opacity-50">📅</span>
                    <h3 class="text-gray-900 font-bold">Sin disponibilidad</h3>
                    <p class="text-gray-500 text-sm mt-1">No hay servicios con cupos para estas fechas.</p>
                </div>
            @endforelse
        </div>

    @else
        <div class="py-12 text-center bg-gray-50 rounded-3xl border border-gray-200 border-dashed">
            <p class="text-gray-500 text-sm">
                Utiliza el buscador superior para encontrar disponibilidad.
            </p>
        </div>
    @endif

</div>