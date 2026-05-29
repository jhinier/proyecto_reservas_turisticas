<div class="w-full pb-12 bg-gray-50 min-h-screen">

    {{-- Cabecera con altura flexible para móviles --}}
    <div class="relative w-full min-h-[90svh] md:min-h-[500px] md:h-[60vh] flex flex-col justify-center py-16">
        <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" alt="Fondo" class="absolute inset-0 w-full h-full object-cover z-0">
        <div class="absolute inset-0 bg-black/40 z-10"></div>

        <div class="relative z-20 flex flex-col items-center justify-center px-4 w-full mt-4">
            <a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => $tipoServicioSeleccionado]) }}"
               class="inline-flex items-center gap-2 bg-black/50 hover:bg-black/70 text-white text-sm font-bold py-2 px-6 rounded-full backdrop-blur-sm transition shadow-lg border border-white/20 mb-6">
                ← Volver al buscador
            </a>

            <h1 class="text-4xl md:text-5xl font-black text-white text-center drop-shadow-lg mb-8 uppercase tracking-wide">
                {{ $emprendimiento->nombre }}
            </h1>

            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-4xl border border-gray-300">
                <h2 class="text-[26px] font-bold text-[#06281E] mb-4">Catálogo de {{ $tipoServicio->nombre }} y disponibilidad</h2>

                <form wire:submit.prevent="buscar" class="flex flex-col md:flex-row gap-4 items-center">

                    <div class="flex-1 w-full min-w-0" wire:ignore x-data="{ inicio: 'Seleccionar', fin: 'Seleccionar' }"
                         x-init="
                            let defaultDates = ['{{ $fechaInicio }}'];
                            if ('{{ $this->requiereFechaFin() }}' && '{{ $fechaFin }}') { defaultDates.push('{{ $fechaFin }}'); }
                            flatpickr($refs.dateWrapper, {
                                mode: '{{ $this->requiereFechaFin() ? 'range' : 'single' }}',
                                showMonths: window.innerWidth > 768 ? 2 : 1, locale: 'es', minDate: 'today',
                                defaultDate: defaultDates, dateFormat: 'Y-m-d',
                                onChange: function(selectedDates, dateStr, instance) {
                                    if (selectedDates.length > 0) { inicio = instance.formatDate(selectedDates[0], 'd M Y'); @this.set('fechaInicio', instance.formatDate(selectedDates[0], 'Y-m-d')); }
                                    if (selectedDates.length === 2) { fin = instance.formatDate(selectedDates[1], 'd M Y'); @this.set('fechaFin', instance.formatDate(selectedDates[1], 'Y-m-d')); } else { fin = 'Seleccionar'; }
                                },
                                onReady: function(selectedDates, dateStr, instance) {
                                    if (selectedDates.length > 0) { inicio = instance.formatDate(selectedDates[0], 'd M Y'); }
                                    if (selectedDates.length === 2) { fin = instance.formatDate(selectedDates[1], 'd M Y'); }
                                }
                            });
                         ">
                        <div x-ref="dateWrapper" class="flex flex-col sm:flex-row gap-4 cursor-pointer w-full">
                            <div class="flex-1 border border-gray-400 rounded-full px-5 py-2.5 flex items-center gap-3 hover:bg-gray-50 transition bg-white overflow-hidden">
                                <svg class="w-5 h-5 text-gray-800 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase">{{ $this->esHospedaje() ? 'Check-in' : 'Fecha inicio' }}</span>
                                    <span class="text-sm font-bold text-gray-900 truncate" x-text="inicio"></span>
                                </div>
                            </div>
                            @if($this->requiereFechaFin())
                            <div class="flex-1 border border-gray-400 rounded-full px-5 py-2.5 flex items-center gap-3 hover:bg-gray-50 transition bg-white overflow-hidden">
                                <svg class="w-5 h-5 text-gray-800 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase">{{ $this->esHospedaje() ? 'Check-out' : 'Fecha fin' }}</span>
                                    <span class="text-sm font-bold text-gray-900 truncate" x-text="fin"></span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($this->esHospedaje() || $this->esGuianza())
                    <div x-data="{ open: false, huespedes: @entangle('huespedesGlobales') }"
                         class="relative w-full md:w-auto border border-gray-400 rounded-full bg-white hover:bg-gray-50 transition">
                        <div @click="open = !open" class="w-full h-full px-5 py-2.5 flex items-center gap-3 cursor-pointer select-none">
                            <svg class="w-5 h-5 text-gray-800 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <div class="flex flex-col items-start text-left">
                                <span class="text-[11px] font-bold text-gray-500 uppercase">Personas totales</span>
                                <span class="text-sm font-bold text-gray-900 whitespace-nowrap" x-text="huespedes + (huespedes == 1 ? ' persona' : ' personas')"></span>
                            </div>
                        </div>
                        <div x-show="open" @click.away="open = false" @click.stop style="display:none"
                             class="absolute top-full right-0 mt-3 w-[calc(100vw-2rem)] sm:w-72 max-w-sm bg-white rounded-2xl shadow-2xl border border-gray-200 p-5 z-50">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 text-sm">Número de personas</span>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click.stop="if(huespedes > 1) huespedes--;"
                                            class="w-9 h-9 rounded-full bg-[#9CA3AF] flex items-center justify-center text-white hover:bg-gray-500 transition-colors outline-none shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <span class="w-10 text-center font-bold text-gray-900 text-lg" x-text="huespedes"></span>
                                    <button type="button" @click.stop="huespedes++;"
                                            class="w-9 h-9 rounded-full bg-[#06281E] flex items-center justify-center text-white hover:bg-black transition-colors shadow-sm outline-none shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($this->requiereHora())
                    <div class="w-full md:w-auto border border-gray-400 rounded-full px-5 py-2.5 flex items-center gap-3 bg-white hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 text-gray-800 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="flex flex-col w-full text-left min-w-0">
                            <span class="text-[11px] font-bold text-gray-500 uppercase">Llegada</span>
                            <input type="time" wire:model.blur="horaLlegada" class="w-full border-0 p-0 text-sm font-bold text-gray-900 focus:ring-0 bg-transparent h-5">
                        </div>
                    </div>
                    @endif

                    <button type="submit" class="w-full md:w-auto bg-[#00D65B] text-black font-black uppercase tracking-wider py-4 px-8 rounded-full border border-black hover:bg-green-500 transition-colors outline-none shrink-0">
                        Buscar
                    </button>
                </form>

                <div class="mt-2 flex gap-4">
                    @error('fechaInicio') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    @error('horaLlegada') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-12 relative z-10">
        @if($busquedaRealizada)
            
            @php
                $esMetaControlada = $this->esHospedaje() || $this->esGuianza();
                $metaBloqueada = $esMetaControlada && $metaAlcanzada;
            @endphp

            <div class="mb-6">
                <p class="text-gray-600 text-lg font-medium">Explora las opciones disponibles y ajusta las cantidades para armar tu reserva perfecta.</p>
            </div>

            @if($metaBloqueada)
                <div class="flex items-center gap-3 bg-[#00D65B]/10 border border-[#00D65B] rounded-2xl px-4 py-3 shadow-sm mb-6">
                    <svg class="w-5 h-5 text-[#06281E] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs font-bold text-[#06281E]">
                        ¡Capacidad cubierta para tu grupo! Elimina un servicio de tu reserva si deseas cambiar la selección, o aumenta el número de personas arriba y presiona Buscar.
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($servicios as $servicio)

                    <div x-data="{
                            modalOpen: false,
                            activeSlide: 0,
                            imagenes: [
                                @foreach($servicio->imagenes as $img)'{{ asset('storage/' . $img->imagen) }}',@endforeach
                            ]
                         }"
                         class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full overflow-hidden {{ $metaBloqueada ? 'opacity-50 pointer-events-none' : '' }}"
                         wire:key="servicio-{{ $servicio->id }}">

                        <div class="w-full h-56 relative bg-gray-100 shrink-0 group">
                            @if($servicio->imagenes->isNotEmpty())
                                <img src="{{ asset('storage/' . $servicio->imagenes->first()->imagen) }}"
                                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                     alt="{{ $servicio->nombre }}">
                                @if(!$this->esGuianza())
                                <button type="button" @click="modalOpen = true" class="absolute top-3 right-3 bg-white text-[#06281E] text-[10px] font-black uppercase px-3 py-1.5 rounded-full shadow-md hover:bg-gray-50 transition flex items-center gap-1.5 z-20 outline-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Ver
                                </button>
                                @endif
                            @else
                                @if($this->esGuianza())
                                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-[#00D65B] to-[#06281E] text-white">
                                        <svg class="w-16 h-16 mb-2 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="font-black tracking-widest text-sm uppercase drop-shadow-md">Servicio de Guianza</span>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-bold bg-gray-200">Sin foto</div>
                                @endif
                            @endif
                            <div class="absolute bottom-3 left-3 bg-[#00D65B] text-black text-[10px] font-black uppercase px-3 py-1 rounded shadow-sm z-20 tracking-wider">
                                {{ $tipoServicio->nombre }}
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-[22px] font-black text-[#06281E] leading-tight mb-1">{{ $servicio->nombre }}</h3>
                            
                            @if($servicio->detallePaqueteTuristico)
                                <p class="text-sm text-gray-500 mb-4">{{ $servicio->detallePaqueteTuristico->duracion_dias }} días</p>
                            @elseif($servicio->detalleHospedaje)
                                <p class="text-sm text-gray-500 mb-4">Capacidad máxima: {{ $servicio->detalleHospedaje->capacidad }} pers. / hab.</p>
                            @elseif($servicio->detalleGuianza)
                                <p class="text-sm text-gray-500 mb-4">Máx: {{ $servicio->detalleGuianza->numero_max_persona }} personas por guía</p>
                            @else
                                <p class="text-sm text-gray-500 mb-4 line-clamp-1">{{ $servicio->descripcion }}</p>
                            @endif

                            @if(!str_contains(strtolower($tipoServicio->nombre), 'aliment'))
                                <div class="bg-gray-50 rounded-xl p-3.5 flex items-center gap-2 mb-6 border border-gray-100">
                                    <span class="text-base drop-shadow-sm">🎒</span>
                                    <span class="text-sm font-black text-[#00A344]">
                                        @if($this->esAlquiler()) Equipos disponibles: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @elseif($this->esPaquete()) Paquetes disponibles: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @elseif($this->esHospedaje()) Habitaciones disponibles: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @elseif($this->esGuianza()) Guías disponibles: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @else Disponibilidad: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @endif
                                    </span>
                                </div>
                            @endif

                            <div class="mt-auto space-y-5">
                                @if(!$this->esHospedaje())
                                <div class="flex items-center justify-between">
                                    <span class="font-black text-[#06281E] text-[13px] uppercase tracking-widest">Cantidad</span>
                                    <div class="flex items-center gap-3">
                                        <button type="button"
                                                wire:click.stop="disminuirCantidad({{ $servicio->id }})"
                                                class="w-8 h-8 rounded-full bg-[#9CA3AF] text-white flex items-center justify-center hover:bg-gray-500 transition-colors outline-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="w-6 text-center font-bold text-gray-900 text-lg">{{ $cantidadesTarjetas[$servicio->id] ?? 1 }}</span>
                                        <button type="button"
                                                wire:click.stop="aumentarCantidad({{ $servicio->id }})"
                                                class="w-8 h-8 rounded-full bg-[#06281E] text-white flex items-center justify-center hover:bg-black transition-colors outline-none shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                @endif

                                @if($this->esHospedaje())
                                <div class="flex items-center justify-between">
                                    <span class="font-black text-[#06281E] text-[13px] uppercase tracking-widest">Huéspedes</span>
                                    <div class="flex items-center gap-3">
                                        <button type="button"
                                                wire:click.stop="disminuirPersonas({{ $servicio->id }})"
                                                class="w-8 h-8 rounded-full bg-[#9CA3AF] text-white flex items-center justify-center hover:bg-gray-500 transition-colors outline-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="w-6 text-center font-bold text-gray-900 text-lg">{{ $personasTarjetas[$servicio->id] ?? 1 }}</span>
                                        <button type="button"
                                                wire:click.stop="aumentarPersonas({{ $servicio->id }})"
                                                class="w-8 h-8 rounded-full bg-[#06281E] text-white flex items-center justify-center hover:bg-black transition-colors outline-none shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                @endif

                                <div class="flex flex-col items-start w-full border-t border-gray-100 pt-5 mt-2">
                                    <span class="text-[28px] font-black text-[#06281E] leading-none mb-4">${{ number_format($servicio->precio, 2) }}</span>
                                    <button type="button"
                                            wire:click.stop="agregarAlCarrito({{ $servicio->id }})"
                                            @disabled($metaBloqueada)
                                            class="w-full bg-[#00D65B] text-black text-center font-black uppercase tracking-wider text-sm px-8 py-3.5 rounded-full border border-black hover:bg-green-500 active:scale-95 transition-all outline-none shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                        Agregar
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Modal detalle --}}
                        @if(!$this->esGuianza())
                        <template x-teleport="body">
                            <div x-show="modalOpen" x-cloak
                                 class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 sm:p-6"
                                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div @click.away="modalOpen = false"
                                     class="bg-white rounded-3xl w-full max-w-7xl max-h-[95vh] overflow-hidden flex flex-col lg:flex-row relative shadow-2xl"
                                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                    <button @click="modalOpen = false" class="absolute top-4 right-4 z-50 bg-white/90 hover:bg-white text-black p-2.5 rounded-full backdrop-blur shadow-md transition outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <div class="w-full lg:w-3/5 bg-gray-100 h-80 lg:h-auto relative p-4 lg:p-6 flex items-center justify-center">
                                        <template x-if="imagenes.length > 0">
                                            <div class="w-full h-full relative group/carousel rounded-2xl overflow-hidden border border-gray-200 shadow-sm bg-black">
                                                <img :src="imagenes[activeSlide]" class="w-full h-full object-cover transition-opacity duration-500">
                                                <div x-show="imagenes.length > 1" class="absolute inset-0 flex items-center justify-between px-4 opacity-0 group-hover/carousel:opacity-100 transition-opacity">
                                                    <button @click="activeSlide = activeSlide === 0 ? imagenes.length - 1 : activeSlide - 1" class="bg-white/90 hover:bg-white p-3 rounded-full shadow-lg text-black outline-none">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button @click="activeSlide = activeSlide === imagenes.length - 1 ? 0 : activeSlide + 1" class="bg-white/90 hover:bg-white p-3 rounded-full shadow-lg text-black outline-none">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                </div>
                                                <div x-show="imagenes.length > 1" class="absolute bottom-4 left-0 right-0 flex justify-center gap-2.5">
                                                    <template x-for="(img, index) in imagenes" :key="index">
                                                        <button @click="activeSlide = index" :class="{'bg-white w-6': activeSlide === index, 'bg-white/50 w-2.5': activeSlide !== index}" class="h-2.5 rounded-full transition-all outline-none shadow-sm"></button>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="imagenes.length === 0">
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold border border-gray-200 rounded-2xl">Sin imágenes</div>
                                        </template>
                                    </div>
                                    <div class="w-full lg:w-2/5 p-8 lg:p-10 overflow-y-auto max-h-[95vh] custom-scrollbar bg-white">
                                        <span class="inline-block px-3 py-1 text-xs font-bold uppercase border border-[#00D65B] bg-[#00D65B]/10 rounded text-[#06281E] mb-4 tracking-widest">{{ $tipoServicio->nombre }}</span>
                                        <h2 class="text-4xl font-black text-[#06281E] mb-4 leading-tight">{{ $servicio->nombre }}</h2>
                                        <p class="text-gray-600 leading-relaxed mb-8 text-[16px]">{{ $servicio->descripcion }}</p>
                                        <div class="space-y-6">
                                            @if($servicio->detallePaqueteTuristico)
                                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                                                    <h4 class="font-black text-gray-900 mb-3 flex items-center gap-2 text-lg">✨ Servicios Incluidos</h4>
                                                    <p class="text-[15px] text-gray-600 whitespace-pre-line">{{ $servicio->detallePaqueteTuristico->servicios_incluidos }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                                                    <h4 class="font-black text-gray-900 mb-3 flex items-center gap-2 text-lg">📍 Lugares y Actividades</h4>
                                                    <p class="text-[15px] text-gray-600 whitespace-pre-line">{{ $servicio->detallePaqueteTuristico->lugares_actividades }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                                                    <h4 class="font-black text-gray-900 mb-3 flex items-center gap-2 text-lg">💡 Recomendaciones</h4>
                                                    <p class="text-[15px] text-gray-600 whitespace-pre-line">{{ $servicio->detallePaqueteTuristico->recomendaciones }}</p>
                                                </div>
                                                @if($servicio->detallePaqueteTuristico->documento)
                                                <a href="{{ asset('storage/' . $servicio->detallePaqueteTuristico->documento) }}" target="_blank"
                                                   class="flex items-center justify-center gap-2 w-full py-4 bg-[#06281E] text-white font-bold rounded-2xl hover:bg-black transition outline-none shadow-md">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    Descargar Itinerario (PDF)
                                                </a>
                                                @endif
                                            @endif
                                            @if($servicio->detalleAlimentacion)
                                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                                                    <p class="text-[16px] text-gray-600 mb-2"><strong class="text-gray-900">Tipo:</strong> {{ $servicio->detalleAlimentacion->tipo_alimentacion }}</p>
                                                    <p class="text-[16px] text-gray-600"><strong class="text-gray-900">Lugar:</strong> {{ $servicio->detalleAlimentacion->lugar_alimentacion }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-10 pt-8 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <div class="flex items-end gap-2">
                                                <span class="text-sm font-bold text-gray-500 mb-1.5">Precio:</span>
                                                <span class="text-4xl font-black text-gray-900">${{ number_format($servicio->precio, 2) }}</span>
                                            </div>
                                            <button @click="modalOpen = false" class="w-full sm:w-auto bg-gray-200 text-gray-800 font-bold px-10 py-3.5 rounded-full hover:bg-gray-300 transition outline-none">
                                                Cerrar Detalle
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        @endif

                    </div>
                @empty
                    <div class="col-span-full bg-white p-16 text-center rounded-2xl border border-gray-200 shadow-sm flex flex-col items-center">
                        <span class="text-5xl mb-4">🍃</span>
                        <h3 class="text-xl font-black text-[#06281E] mb-2">No hay disponibilidad</h3>
                        <p class="text-gray-500">Intenta buscando con otras fechas u otra categoría.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    {{-- Espaciador fantasma para que el carrito inferior no tape el contenido --}}
    @if(count($carrito) > 0)
        <div class="h-40 w-full pointer-events-none opacity-0"></div>
    @endif

    {{-- NUEVO CARRITO FLOTANTE INFERIOR CON RESPONSIVE AJUSTADO --}}
    @if(count($carrito) > 0)
        @php
            $puedeContinuar = (!$this->esHospedaje() && !$this->esGuianza()) || $metaAlcanzada;
            $totalReserva = collect($carrito)->sum('subtotal');
        @endphp
        <div class="fixed bottom-0 left-0 right-0 z-50 transition-transform duration-300" x-data="{ mostrarLista: true }" @servicio-agregado.window="mostrarLista = true">
            <div class="max-w-6xl mx-auto md:px-4">
                <div class="bg-white shadow-[0_-10px_30px_rgba(0,0,0,0.1)] border-t md:border-x md:border-t border-gray-300 w-full flex flex-col rounded-t-3xl overflow-hidden">
                    
                    <button x-on:click="mostrarLista = !mostrarLista" class="w-full flex items-center justify-center gap-2 py-3 text-gray-500 hover:text-[#06281E] transition-colors text-xs font-black uppercase tracking-widest bg-gray-50 border-b border-gray-200 outline-none">
                        <span x-text="mostrarLista ? 'Ocultar reserva' : 'Ver reserva'"></span>
                        <svg class="w-4 h-4 transition-transform duration-300" x-bind:class="mostrarLista ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="mostrarLista" x-collapse class="max-h-[40vh] overflow-y-auto px-4 md:px-8 bg-white custom-scrollbar">
                        <div class="flex flex-col py-2 space-y-3 mt-2">
                            @foreach($carrito as $index => $item)
                                @php
                                    $fi = $item['fecha_inicio'] ?? now();
                                    $ff = $item['fecha_fin'] ?? $fi;
                                    $dias = max(1, \Carbon\Carbon::parse($fi)->diffInDays(\Carbon\Carbon::parse($ff)) + 1);
                                    
                                    $nombreCat = strtolower($item['categoria_nombre'] ?? $item['categoria'] ?? '');
                                    $esHosp = str_contains($nombreCat, 'hospedaje');
                                    $esGuia = str_contains($nombreCat, 'guianza');
                                    $esPaq = str_contains($nombreCat, 'paquete');
                                    $esAlq = str_contains($nombreCat, 'alquiler');
                                    
                                    $aplicaDias = $dias > 1 && !$esPaq && !str_contains($nombreCat, 'aliment');
                                @endphp
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 gap-2 md:gap-4" wire:key="cart-item-{{ $index }}">
                                    <div class="flex items-center gap-2 md:gap-3 flex-1 min-w-0">
                                        <button wire:click="quitarDelCarrito({{ $index }})" class="text-gray-400 hover:text-red-500 transition-colors bg-gray-50 hover:bg-red-50 w-6 h-6 md:w-7 md:h-7 flex items-center justify-center rounded-full shrink-0 border border-gray-200 outline-none">
                                            <svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <div class="bg-gray-100 text-[#06281E] px-2 py-1 md:px-2.5 md:py-1 rounded-md border border-gray-200 flex items-center gap-1.5 shrink-0">
                                            <span class="font-black text-[10px] md:text-[11px]">{{ $item['cantidad'] ?? 1 }}</span>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <h4 class="font-black text-xs md:text-sm text-[#06281E] truncate">{{ $item['nombre'] }}</h4>
                                            <p class="text-[9px] md:text-[10px] text-gray-500 font-bold truncate mt-0.5">
                                                @if($esHosp)
                                                    {{ $item['cantidad'] }} hab. &times; {{ $item['numero_personas'] ?? 1 }} pers. @if($aplicaDias) &times; {{ $dias }} días @endif
                                                @elseif($esGuia)
                                                    {{ $item['cantidad'] }} guía(s) @if($aplicaDias) &times; {{ $dias }} días @endif
                                                @elseif($esAlq)
                                                    {{ $item['cantidad'] }} unidad(es) @if($aplicaDias) &times; {{ $dias }} días @endif
                                                @else
                                                    {{ $item['cantidad'] }} unidad(es)
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="shrink-0 font-black text-[#00D65B] text-base md:text-lg text-right pl-2">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4 px-4 py-3 md:px-8 md:py-5 bg-white border-t border-gray-200">
                        <div class="flex flex-col min-w-0">
                            <span class="text-2xl md:text-3xl font-black text-[#06281E] leading-none">${{ number_format($totalReserva, 2) }}</span>
                            <span class="text-gray-400 text-[9px] md:text-[10px] font-black uppercase tracking-widest mt-1">Total a pagar</span>
                        </div>
                        
                        <div class="shrink-0">
                            <button wire:click="irAlCheckout" 
                                    @disabled(!$puedeContinuar)
                                    class="px-6 py-3 md:px-8 md:py-3.5 rounded-full uppercase text-[10px] md:text-xs tracking-widest font-black transition-all flex items-center gap-1.5 md:gap-2 border-2 border-black outline-none {{ $puedeContinuar ? 'bg-[#00D65B] text-black shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] hover:translate-y-[2px] hover:translate-x-[2px] hover:shadow-[1px_1px_0px_0px_rgba(0,0,0,1)]' : 'bg-gray-200 text-gray-400 cursor-not-allowed border-gray-300' }}">
                                Reservar
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endif

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</div>