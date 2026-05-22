<div class="space-y-4">

    {{-- Skeleton mientras carga la categoría --}}
    <div wire:loading.flex wire:target="filtroCategoria" class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-pulse">
        @for ($i = 0; $i < 2; $i++)
            <div class="h-48 bg-[#C2D5C0]/30 rounded-3xl border border-[#C2D5C0]/50"></div>
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
            <div class="flex items-center gap-3 bg-[#C2D5C0]/30 border border-[#508A45] rounded-2xl px-4 py-3 shadow-sm">
                <svg class="size-5 text-[#508A45] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs font-bold text-[#2C3D30]">
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

                <div class="bg-white rounded-3xl p-5 border border-[#C2D5C0] shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md hover:-translate-y-1 {{ $metaBloqueada ? 'opacity-50 pointer-events-none' : '' }}"
                     wire:key="srv-{{ $servicio->id }}">

                    {{-- Cabecera: nombre + cupos --}}
                    <div>
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h4 class="font-black text-lg text-[#2C3D30] leading-tight">
                                {{ $servicio->nombre }}
                            </h4>
                            <span class="bg-[#C2D5C0]/40 text-[#508A45] text-[9px] font-black px-2 py-1 rounded-full whitespace-nowrap shrink-0 border border-[#508A45]/30">
                                {{ $servicio->cupos_libres }} disp.
                            </span>
                        </div>

                        <p class="text-xs text-[#6B806D] line-clamp-2 mb-3 leading-relaxed">{{ $servicio->descripcion }}</p>

                        {{-- Info de capacidad --}}
                        @if($servicio->detalleHospedaje)
                            <p class="text-[9px] text-[#6B806D] font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Capacidad: {{ $servicio->detalleHospedaje->capacidad }} pers.
                            </p>
                        @elseif($servicio->detalleGuianza)
                            <p class="text-[9px] text-[#6B806D] font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Máx: {{ $servicio->detalleGuianza->numero_max_persona }} pers/guía
                            </p>
                        @elseif($servicio->detallePaqueteTuristico)
                            <p class="text-[9px] text-[#6B806D] font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $servicio->detallePaqueteTuristico->duracion_dias ?? '?' }} días
                                @if(!empty($servicio->detallePaqueteTuristico->hora_salida))
                                    <span class="opacity-50">|</span> Salida: {{ \Carbon\Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i') }}
                                @endif
                            </p>
                        @endif

                        {{-- Precio Unitario Base --}}
                        <p class="text-xl font-black text-[#508A45] mt-2">
                            ${{ number_format($servicio->precio, 2) }}
                            <span class="text-[9px] text-[#6B806D] font-bold uppercase tracking-wider ml-1">
                                @if($esHospedajeV)
                                    / persona
                                @elseif($esGuianzaV)
                                    / guía
                                @else
                                    / unidad
                                @endif
                            </span>
                        </p>
                    </div>

                    {{-- Sistema de controles condicional --}}
                    @if($esHospedajeV || $esGuianzaV)
                        {{-- Interfaz interactiva para hospedaje/guianza (LOGICA INTACTA) --}}
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
                            class="mt-4 pt-4 border-t border-[#C2D5C0]/50">

                            <div class="flex flex-col gap-3 mb-4">
                                {{-- Fila 1: Cantidad y Hora --}}
                                <div class="flex gap-3 items-end">
                                    @if($esGuianzaV)
                                        {{-- Selector de cantidad (Solo se muestra para guías) --}}
                                        <div class="w-1/2">
                                            <label class="block text-[9px] font-black text-[#6B806D] uppercase mb-1 tracking-widest ml-1">Guías</label>
                                            <input type="number" x-model.number="cantidad" min="1" max="{{ $servicio->cupos_libres }}" class="w-full bg-[#F1F5E6] border border-[#C2D5C0] rounded-xl p-2 text-xs font-black text-[#2C3D30] text-center focus:ring-2 focus:ring-[#508A45] focus:border-[#508A45] outline-none transition-all">
                                        </div>
                                    @endif

                                    {{-- Hora (Hospedaje: Ancho completo | Guianza: Mitad) --}}
                                    <div class="w-full {{ $esGuianzaV ? 'w-1/2' : '' }}">
                                        <label class="block text-[9px] font-black text-[#6B806D] uppercase mb-1 tracking-widest ml-1">Hora</label>
                                        <input type="time" wire:model.blur="horas.{{ $servicio->id }}" class="w-full bg-[#F1F5E6] border border-[#C2D5C0] rounded-xl p-2 text-xs font-black text-[#2C3D30] focus:ring-2 focus:ring-[#508A45] focus:border-[#508A45] outline-none transition-all">
                                    </div>
                                </div>

                                @if($esHospedajeV)
                                    {{-- Fila 2: Selector de personas (Solo se muestra para hospedaje) --}}
                                    <div class="w-full bg-[#F1F5E6] border border-[#C2D5C0] rounded-xl p-3">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-[9px] font-black text-[#6B806D] uppercase tracking-widest">Pers. / Hab.</span>
                                            <div class="text-[10px] font-black text-[#2C3D30]">
                                                <span x-text="personas"></span> <span class="text-[#6B806D]">/</span> <span x-text="maxPersonas" class="text-[#6B806D]"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" x-on:click="if(personas > 1) personas--" class="size-7 rounded-full border border-[#C2D5C0] flex items-center justify-center text-[#508A45] hover:bg-[#C2D5C0]/50 transition-colors disabled:opacity-30 disabled:cursor-not-allowed" x-bind:disabled="personas <= 1">
                                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                            </button>
                                            <div class="flex-1 h-1.5 bg-[#C2D5C0]/50 rounded-full overflow-hidden">
                                                <div class="h-full bg-[#508A45] transition-all duration-300 rounded-full" x-bind:style="'width: ' + ((personas / maxPersonas) * 100) + '%'"></div>
                                            </div>
                                            <button type="button" x-on:click="if(personas < maxPersonas) personas++" class="size-7 rounded-full border border-[#C2D5C0] flex items-center justify-center text-[#508A45] hover:bg-[#C2D5C0]/50 transition-colors disabled:opacity-30 disabled:cursor-not-allowed" x-bind:disabled="personas >= maxPersonas">
                                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Total Dinámico Único --}}
                            <div class="flex justify-between items-center bg-[#F1F5E6] border border-[#C2D5C0] rounded-xl p-3 mb-4">
                                <p class="font-black text-[#6B806D] text-xs uppercase tracking-wider">Total</p>
                                <p class="text-xl font-black text-[#508A45] leading-none">$<span x-text="total.toFixed(2)"></span></p>
                            </div>

                            <button type="button" x-on:click="$wire.agregarHospedaje({{ $servicio->id }}, personas, cantidad)" class="w-full py-3 bg-[#508A45] hover:bg-[#3E6B35] text-white text-[11px] font-black uppercase tracking-widest rounded-full transition-colors flex justify-center items-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" @disabled($metaBloqueada)>
                                <span>{{ $esHospedajeV ? 'Añadir habitación' : 'Añadir guianza' }}</span>
                            </button>
                        </div>
                    @else
                        {{-- Controles tradicionales --}}
                        <div class="mt-4 pt-4 border-t border-[#C2D5C0]/50 flex flex-col sm:flex-row gap-3 items-end">
                            <div class="w-full sm:w-24">
                                <label class="block text-[9px] font-black text-[#6B806D] uppercase mb-1 tracking-widest ml-1">
                                    @if($esAlquilerV) Unidades @elseif($esPaqueteV) Paquetes @else Cant. @endif
                                </label>
                                <input type="number"
                                       wire:model.blur="cantidades.{{ $servicio->id }}"
                                       min="1"
                                       max="{{ $servicio->cupos_libres }}"
                                       @disabled($metaBloqueada)
                                       class="w-full bg-[#F1F5E6] border border-[#C2D5C0] rounded-xl p-2 text-xs font-black text-[#2C3D30] text-center focus:ring-2 focus:ring-[#508A45] focus:border-[#508A45] outline-none transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            </div>

                            @if(!$esPaqueteV)
                                <div class="w-full sm:w-28">
                                    <label class="block text-[9px] font-black text-[#6B806D] uppercase mb-1 tracking-widest ml-1">Hora</label>
                                    <input type="time"
                                           wire:model.blur="horas.{{ $servicio->id }}"
                                           @disabled($metaBloqueada)
                                           class="w-full bg-[#F1F5E6] border border-[#C2D5C0] rounded-xl p-2 text-xs font-black text-[#2C3D30] focus:ring-2 focus:ring-[#508A45] focus:border-[#508A45] outline-none transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                </div>
                            @endif

                            <button wire:click="agregarServicio({{ $servicio->id }})"
                                    @disabled($metaBloqueada)
                                    class="w-full sm:w-auto flex-1 px-4 py-2.5 bg-[#508A45] hover:bg-[#3E6B35] text-white text-[11px] font-black uppercase tracking-widest rounded-full transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
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
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-[#C2D5C0] shadow-sm flex flex-col items-center">
                    <span class="text-4xl block mb-3 opacity-70">🍃</span>
                    <h3 class="text-[#2C3D30] font-black text-lg mb-1">Sin disponibilidad</h3>
                    <p class="text-[#6B806D] text-xs font-bold">No hay servicios con cupos para estas fechas.</p>
                </div>
            @endforelse
        </div>

    @else
        <div class="py-12 text-center bg-[#C2D5C0]/20 rounded-3xl border-2 border-[#C2D5C0] border-dashed flex flex-col items-center">
            <svg class="size-8 text-[#508A45] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <p class="text-[#2C3D30] font-bold text-xs">
                Utiliza el buscador superior para encontrar disponibilidad.
            </p>
        </div>
    @endif

</div>