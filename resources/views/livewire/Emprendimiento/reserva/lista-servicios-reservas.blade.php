<div class="space-y-4">

    {{-- Skeleton mientras carga la categoría --}}
    <div wire:loading.flex wire:target="filtroCategoria" class="grid grid-cols-1 md:grid-cols-2 gap-4 animate-pulse">
        @for ($i = 0; $i < 2; $i++)
            <div class="h-48 bg-gray-200 dark:bg-zinc-800 rounded-3xl border border-gray-300 dark:border-zinc-700"></div>
        @endfor
    </div>

    @if($busquedaActiva ?? false)

        @php
            $catLower       = strtolower($nombreCategoria ?? '');
            $esHospedajeV   = str_contains($catLower, 'hospedaje');
            $esGuianzaV     = str_contains($catLower, 'guianza');
            $esPaqueteV     = str_contains($catLower, 'paquete');
            $esAlquilerV    = str_contains($catLower, 'alquiler');
            $esAlimentacionV = str_contains($catLower, 'aliment');
            $tieneMetaV     = $esHospedajeV || $esGuianzaV;
            $mostrarStock   = !$esAlimentacionV;

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
            $metaBloqueada = false;
        @endphp

        <div wire:loading.remove wire:target="filtroCategoria" class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            @forelse($this->servicios as $servicio)

                @php
                    $restantes = max(0, (int)($personasBusqueda ?? 1) - $personasAcomodadas);
                    $sugerido  = min($restantes, $servicio->capacidad_unitaria);
                    $sugerido  = max(1, $sugerido); // Que inicie mínimo en 1 para que no se vea feo el diseño
                @endphp

                <div class="bg-white dark:bg-zinc-900 rounded-3xl p-5 border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md hover:-translate-y-1" wire:key="srv-{{ $servicio->id }}">

                    {{-- Cabecera: nombre + cupos --}}
                    <div>
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <h4 class="font-black text-lg text-[#06281E] dark:text-white leading-tight">
                                {{ $servicio->nombre }}
                            </h4>
                            @if($mostrarStock)
                                <span class="bg-green-50 dark:bg-green-900/30 text-[#00A344] dark:text-[#00D65B] text-[9px] font-black px-2 py-1 rounded-full whitespace-nowrap shrink-0 border border-[#00A344]/30 dark:border-[#00D65B]/30">
                                    {{ $servicio->cupos_libres }} disp.
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-3 leading-relaxed">{{ $servicio->descripcion }}</p>

                        {{-- Info de capacidad --}}
                        @if($servicio->detalleHospedaje)
                            <p class="text-[9px] text-gray-500 dark:text-gray-400 font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Capacidad: {{ $servicio->detalleHospedaje->capacidad }} pers.
                            </p>
                        @elseif($servicio->detalleGuianza)
                            <p class="text-[9px] text-gray-500 dark:text-gray-400 font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Máx: {{ $servicio->detalleGuianza->numero_max_persona }} pers/guía
                            </p>
                        @elseif($servicio->detallePaqueteTuristico)
                            <p class="text-[9px] text-gray-500 dark:text-gray-400 font-black uppercase tracking-widest mb-1.5 flex items-center gap-1">
                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $servicio->detallePaqueteTuristico->duracion_dias ?? '?' }} días
                                @if(!empty($servicio->detallePaqueteTuristico->hora_salida))
                                    <span class="opacity-50">|</span> Salida: {{ \Carbon\Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i') }}
                                @endif
                            </p>
                        @endif

                        {{-- Precio Unitario Base --}}
                        <p class="text-xl font-black text-[#00A344] dark:text-[#00D65B] mt-2">
                            ${{ number_format($servicio->precio, 2) }}
                            <span class="text-[9px] text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider ml-1">
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
                                personas: {{ $servicio->capacidad_unitaria }}, {{-- Lleno por defecto al máximo --}}
                                cantidad: 1,
                                precioUnitario: {{ $servicio->precio }},
                                dias: {{ max(1, \Carbon\Carbon::parse($fechaBusqueda ?: now())->diffInDays(\Carbon\Carbon::parse($fechaFinBusqueda ?: $fechaBusqueda ?: now())) + 1) }},
                                errorHora: false,
                                get total() { 
                                    return this.esGuianza 
                                        ? (this.cantidad * this.precioUnitario * this.dias)
                                        : (this.personas * this.cantidad * this.precioUnitario * this.dias);
                                },
                                validarYAgregar() {
                                    if (!this.$refs.horaInput.value) {
                                        this.errorHora = true;
                                        this.$refs.horaInput.focus();
                                        setTimeout(() => this.errorHora = false, 3000);
                                        return;
                                    }
                                    this.errorHora = false;
                                    $wire.agregarHospedaje({{ $servicio->id }}, this.personas, this.cantidad);
                                }
                            }"
                            class="mt-4 pt-4 border-t border-gray-100 dark:border-zinc-800">

                            <div class="flex flex-col gap-3 mb-4">
                                {{-- Fila 1: Cantidad y Hora --}}
                                <div class="flex gap-3 items-end">
                                    @if($esGuianzaV)
                                        {{-- Selector de cantidad (Solo se muestra para guías) --}}
                                        <div class="w-1/2">
                                            <label class="block text-[9px] font-black text-gray-500 dark:text-gray-400 uppercase mb-1 tracking-widest ml-1">Guías</label>
                                            <input type="number" x-model.number="cantidad" min="1" max="{{ $servicio->cupos_libres }}" class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl p-2 text-xs font-black text-[#06281E] dark:text-white text-center focus:ring-2 focus:ring-[#00A344] dark:focus:ring-[#00D65B] focus:border-transparent outline-none transition-all dark:[color-scheme:dark]">
                                        </div>
                                    @endif

                                    {{-- Hora (Hospedaje: Ancho completo | Guianza: Mitad) --}}
                                    <div class="w-full {{ $esGuianzaV ? 'w-1/2' : '' }}">
                                        <label class="block text-[9px] font-black text-gray-500 dark:text-gray-400 uppercase mb-1 tracking-widest ml-1">Hora</label>
                                        <input type="time" x-ref="horaInput" wire:model.blur="horas.{{ $servicio->id }}" 
                                               class="w-full bg-gray-50 dark:bg-zinc-800 border rounded-xl p-2 text-xs font-black text-[#06281E] dark:text-white outline-none transition-all dark:[color-scheme:dark]"
                                               x-bind:class="errorHora ? 'border-red-500 ring-2 ring-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-zinc-700 focus:ring-2 focus:ring-[#00A344] dark:focus:ring-[#00D65B] focus:border-transparent'">
                                    </div>
                                </div>

                                @if($esHospedajeV)
                                    {{-- Fila 2: Selector de personas (Solo se muestra para hospedaje) --}}
                                    <div class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl p-3">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-[9px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">Huéspedes / Hab.</span>
                                            <div class="text-[10px] font-black text-[#06281E] dark:text-white">
                                                <span x-text="personas"></span> <span class="text-gray-400">/</span> <span x-text="maxPersonas" class="text-gray-400"></span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="button" x-on:click="if(personas > 1) personas--" class="size-7 rounded-full border border-gray-200 dark:border-zinc-600 flex items-center justify-center text-[#00A344] dark:text-[#00D65B] hover:bg-gray-200 dark:hover:bg-zinc-700 transition-colors disabled:opacity-30 disabled:cursor-not-allowed outline-none" x-bind:disabled="personas <= 1">
                                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                            </button>
                                            <div class="flex-1 h-1.5 bg-gray-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-[#00A344] dark:bg-[#00D65B] transition-all duration-300 rounded-full" x-bind:style="'width: ' + ((personas / maxPersonas) * 100) + '%'"></div>
                                            </div>
                                            <button type="button" x-on:click="if(personas < maxPersonas) personas++" class="size-7 rounded-full border border-gray-200 dark:border-zinc-600 flex items-center justify-center text-[#00A344] dark:text-[#00D65B] hover:bg-gray-200 dark:hover:bg-zinc-700 transition-colors disabled:opacity-30 disabled:cursor-not-allowed outline-none" x-bind:disabled="personas >= maxPersonas">
                                                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Total Dinámico Único --}}
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl p-3 mb-4">
                                <p class="font-black text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Total</p>
                                <p class="text-xl font-black text-[#00A344] dark:text-[#00D65B] leading-none">$<span x-text="total.toFixed(2)"></span></p>
                            </div>

                            <button type="button" x-on:click="validarYAgregar()" class="w-full py-3 bg-[#00D65B] hover:bg-[#00c052] text-[#06281E] text-[11px] font-black uppercase tracking-widest rounded-full transition-colors flex justify-center items-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed outline-none" >
                                <span>{{ $esHospedajeV ? 'Añadir habitación' : 'Añadir guianza' }}</span>
                            </button>
                        </div>
                    @else
                        {{-- Controles tradicionales --}}
                        <div x-data="{ 
                                errorHora: false, 
                                validarYAgregar(id) { 
                                    @if(!$esPaqueteV)
                                        if(!this.$refs.horaTrad.value) { 
                                            this.errorHora = true; 
                                            this.$refs.horaTrad.focus();
                                            setTimeout(() => this.errorHora = false, 3000); 
                                            return; 
                                        } 
                                    @endif
                                    $wire.agregarServicio(id); 
                                } 
                            }" 
                            class="mt-4 pt-4 border-t border-gray-100 dark:border-zinc-800 flex flex-col sm:flex-row gap-3 items-end">
                            <div class="w-full sm:w-24">
                                <label class="block text-[9px] font-black text-gray-500 dark:text-gray-400 uppercase mb-1 tracking-widest ml-1">
                                    @if($esAlquilerV) Unidades @elseif($esPaqueteV) Paquetes @else Cant. @endif
                                </label>
                                <input type="number"
                                       wire:model.blur="cantidades.{{ $servicio->id }}"
                                       min="1"
                                       max="{{ $servicio->cupos_libres }}"
                                       @disabled($metaBloqueada)
                                       class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl p-2 text-xs font-black text-[#06281E] dark:text-white text-center focus:ring-2 focus:ring-[#00A344] dark:focus:ring-[#00D65B] focus:border-transparent outline-none transition-all disabled:opacity-50 disabled:cursor-not-allowed dark:[color-scheme:dark]">
                            </div>

                            @if(!$esPaqueteV)
                                <div class="w-full sm:w-28">
                                    <label class="block text-[9px] font-black text-gray-500 dark:text-gray-400 uppercase mb-1 tracking-widest ml-1">Hora</label>
                                    <input type="time" x-ref="horaTrad"
                                           wire:model.blur="horas.{{ $servicio->id }}"
                                           @disabled($metaBloqueada)
                                           class="w-full bg-gray-50 dark:bg-zinc-800 border rounded-xl p-2 text-xs font-black text-[#06281E] dark:text-white outline-none transition-all disabled:opacity-50 disabled:cursor-not-allowed dark:[color-scheme:dark]"
                                           x-bind:class="errorHora ? 'border-red-500 ring-2 ring-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-zinc-700 focus:ring-2 focus:ring-[#00A344] dark:focus:ring-[#00D65B] focus:border-transparent'">
                                </div>
                            @endif

                            <button type="button" x-on:click="validarYAgregar({{ $servicio->id }})"
                                    @disabled($metaBloqueada)
                                    class="w-full sm:w-auto flex-1 px-4 py-2.5 bg-[#00D65B] hover:bg-[#00c052] text-[#06281E] text-[11px] font-black uppercase tracking-widest rounded-full transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed outline-none">
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
                <div class="col-span-full py-16 text-center bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm flex flex-col items-center">
                    <span class="text-4xl block mb-3 opacity-70">🍃</span>
                    <h3 class="text-[#06281E] dark:text-white font-black text-lg mb-1">Sin disponibilidad</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-xs font-bold">No hay servicios con cupos para estas fechas.</p>
                </div>
            @endforelse
        </div>

    @else
        <div class="py-12 text-center bg-gray-50 dark:bg-zinc-900/50 rounded-3xl border-2 border-gray-200 dark:border-zinc-800 border-dashed flex flex-col items-center">
            <svg class="size-8 text-[#00A344] dark:text-[#00D65B] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <p class="text-[#06281E] dark:text-white font-bold text-xs">
                Utiliza el buscador superior para encontrar disponibilidad.
            </p>
        </div>
    @endif

</div>