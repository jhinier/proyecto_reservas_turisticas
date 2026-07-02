{{-- Se aplica un margen negativo (-mt-6 md:-mt-8) para anular el padding que pone el layout principal y pegar la imagen al menú --}}
<div class="w-full min-h-screen bg-white -mt-6 md:-mt-8 flex flex-col">

    {{-- Cabecera --}}
    <div class="w-full max-w-screen-2xl mx-auto md:px-16 lg:px-32 xl:px-64">
        <div class="relative w-full min-h-[55svh] md:min-h-[280px] md:h-[32vh] flex flex-col justify-center py-6 md:rounded-b-1xl overflow-hidden">
            
            <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" alt="Fondo" class="absolute inset-0 w-full h-full object-cover z-0">
            <div class="absolute inset-0 bg-black/40 z-10"></div>

            <div class="relative z-20 flex flex-col items-center justify-center px-4 w-full">
                <a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => $tipoServicioSeleccionado]) }}"
                   class="inline-flex items-center gap-2 bg-black/60 hover:bg-black/80 text-white text-xs font-medium py-1.5 px-5 rounded-full backdrop-blur-md transition shadow border border-white/40 mb-5">
                    ← Volver al buscador
                </a>

                <h1 class="text-3xl md:text-5xl font-bold text-white text-center drop-shadow-lg mb-8 tracking-wide">
                    {{ $emprendimiento->nombre }}
                </h1>

                {{-- Buscador semitransparente y textos finos --}}
                 <div class="bg-white/100 backdrop-blur-md rounded-xl shadow-lg p-4 md:p-6 w-full max-w-4xl border border-white/60">
                    

                    <form wire:submit.prevent="buscar" class="flex flex-col md:flex-row gap-3 items-center">

                        <div class="flex-1 w-full min-w-0" wire:ignore x-data="{ inicio: 'Seleccionar', fin: 'Seleccionar' }"
                             x-init="
                                let defaultDates = ['{{ $fechaInicio }}'];
                                if ('{{ $this->requiereFechaFin() }}' && '{{ $fechaFin }}') { defaultDates.push('{{ $fechaFin }}'); }
                                let fp = flatpickr($refs.dateWrapper, {
                                    mode: '{{ $this->requiereFechaFin() ? 'range' : 'single' }}',
                                    showMonths: window.innerWidth > 768 ? 2 : 1, locale: 'es', 
                                    minDate: new Date().fp_incr(2), // AQUI SE BLOQUEAN LOS DOS DIAS
                                    defaultDate: defaultDates, dateFormat: 'Y-m-d',
                                    onChange: function(selectedDates, dateStr, instance) {
                                        if (selectedDates.length > 0) { inicio = instance.formatDate(selectedDates[0], 'd M Y'); @this.set('fechaInicio', instance.formatDate(selectedDates[0], 'Y-m-d')); }
                                        if (selectedDates.length === 2) { fin = instance.formatDate(selectedDates[1], 'd M Y'); @this.set('fechaFin', instance.formatDate(selectedDates[1], 'Y-m-d')); } else { fin = 'Seleccionar'; }
                                        
                                        let modoRango = '{{ $this->requiereFechaFin() }}' === '1';
                                        if ((modoRango && selectedDates.length === 2) || (!modoRango && selectedDates.length === 1)) {
                                            setTimeout(() => {
                                                let inputHora = document.getElementById('horaSeleccion');
                                                if (inputHora) {
                                                    inputHora.focus();
                                                    try { inputHora.showPicker(); } catch(e) {}
                                                }
                                            }, 100);
                                        }
                                    },
                                    onReady: function(selectedDates, dateStr, instance) {
                                        if (selectedDates.length > 0) { inicio = instance.formatDate(selectedDates[0], 'd M Y'); }
                                        if (selectedDates.length === 2) { fin = instance.formatDate(selectedDates[1], 'd M Y'); }
                                    }
                                });
                                @if(!session()->has('mensaje_exito'))
                                    setTimeout(() => { fp.open(); }, 400);
                                @endif
                             ">
                            <div x-ref="dateWrapper" class="flex flex-col sm:flex-row gap-3 cursor-pointer w-full">
                                <div class="flex-1 border border-gray-300 rounded-full px-4 py-1.5 flex items-center gap-2 hover:border-gray-400 transition bg-white/90 overflow-hidden shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-medium text-gray-500 uppercase tracking-widest">{{ $this->esHospedaje() ? 'Fecha Inicio' : 'Fecha inicio' }}</span>
                                        <span class="text-xs font-semibold text-gray-800 truncate" x-text="inicio"></span>
                                    </div>
                                </div>
                                @if($this->requiereFechaFin())
                                <div class="flex-1 border border-gray-300 rounded-full px-4 py-1.5 flex items-center gap-2 hover:border-gray-400 transition bg-white/90 overflow-hidden shadow-sm">
                                    <svg class="w-3.5 h-3.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-[9px] font-medium text-gray-500 uppercase tracking-widest">{{ $this->esHospedaje() ? 'Fecha Fin' : 'Fecha fin' }}</span>
                                        <span class="text-xs font-semibold text-gray-800 truncate" x-text="fin"></span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($this->requiereHora() || str_contains(strtolower($tipoServicio->nombre), 'aliment'))
                        <div class="w-full md:w-auto border border-gray-300 rounded-full px-4 py-1.5 flex items-center gap-2 bg-white/90 hover:border-gray-400 transition shadow-sm">
                            <svg class="w-3.5 h-3.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="flex flex-col w-full text-left min-w-0">
                                <span class="text-[9px] font-medium text-gray-500 uppercase tracking-widest">Llegada</span>
                                <input type="time" id="horaSeleccion" wire:model.blur="horaLlegada" class="w-full border-0 p-0 text-xs font-semibold text-gray-800 focus:ring-0 bg-transparent h-4">
                            </div>
                        </div>
                        @endif

                        <button type="submit" class="w-full md:w-auto bg-[#00D65B] text-[#06281E] font-semibold text-xs uppercase tracking-widest py-2.5 px-6 rounded-full hover:bg-[#00c052] transition-colors outline-none shrink-0 flex items-center justify-center shadow-sm">
                            <span wire:loading.remove wire:target="buscar">Buscar</span>
                            <span wire:loading wire:target="buscar" class="flex items-center gap-1.5">
                                <svg class="animate-spin h-3.5 w-3.5 text-[#06281E]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Buscando
                            </span>
                        </button>
                    </form>

                    <div class="mt-2 flex gap-4">
                        @error('fechaInicio') <span class="text-red-500 text-[10px] font-semibold">{{ $message }}</span> @enderror
                        @error('horaLlegada') <span class="text-red-500 text-[10px] font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

   {{-- Logica de frases --}}
    @php
        $nombreTipoStr = strtolower($tipoServicio->nombre);
        if (str_contains($nombreTipoStr, 'hospedaje')) {
            $fraseTitulo = "Alojamientos recomendados";
            $fraseSub = "Opciones de descanso con buenas valoraciones de los visitantes.";
        } elseif (str_contains($nombreTipoStr, 'paquete')) {
            $fraseTitulo = "Paquetes turísticos";
            $fraseSub = "Recorridos planificados para conocer los atractivos de la zona.";
        } elseif (str_contains($nombreTipoStr, 'aliment')) {
            $fraseTitulo = "Opciones de alimentación";
            $fraseSub = "Restaurantes y locales de comida disponibles para tu visita.";
        } elseif (str_contains($nombreTipoStr, 'guianza')) {
            $fraseTitulo = "Servicios de guianza";
            $fraseSub = "Guías locales para acompañar tus recorridos.";
        } elseif (str_contains($nombreTipoStr, 'alquiler')) {
            $fraseTitulo = "Equipos de alquiler";
            $fraseSub = "Artículos y herramientas disponibles para tus actividades.";
        } else {
            $fraseTitulo = "Opciones disponibles";
            $fraseSub = "Revisa los servicios que puedes reservar en esta categoría.";
        }
    @endphp

    {{-- Contenedor tarjetas alineado al buscador con 3 columnas --}}
    <div class="w-full max-w-4xl mx-auto px-4 mt-12 relative z-10">
        @if($busquedaRealizada)
            
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-1.5">{{ $fraseTitulo }}</h2>
                <p class="text-sm md:text-base text-gray-600 font-normal">{{ $fraseSub }}</p>
                
                {{-- Mensaje exclusivo para hospedaje --}}
                @if($this->esHospedaje())
                <div class="mt-4 bg-blue-50 border border-blue-200 text-blue-800 text-sm px-4 py-3 rounded-xl flex gap-3 items-start shadow-sm">
                    <span class="text-lg">ℹ️</span>
                    <div>
                        <p class="font-bold text-blue-900">Aviso sobre tarifas infantiles</p>
                        <p class="mt-0.5">Los niños mayores de 6 años pagan igual que un adulto. Si son menores de 6 años, no pagan.</p>
                    </div>
                </div>
                @endif
            </div>

            {{-- 1. SKELETON LOADER --}}
            <div wire:loading wire:target="buscar" class="w-full">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @for($i = 0; $i < 3; $i++)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm flex flex-col h-full overflow-hidden animate-pulse min-h-[420px]">
                            <div class="w-full h-48 bg-gray-200 shrink-0"></div>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="h-5 bg-gray-200 rounded-md w-3/4 mb-3"></div>
                                <div class="h-3 bg-gray-200 rounded-md w-1/3 mb-5"></div>
                                <div class="h-10 bg-gray-100 rounded-lg w-full mb-4"></div>
                                <div class="mt-auto space-y-4">
                                    <div class="h-12 bg-gray-100 rounded-lg w-full"></div>
                                    <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-1">
                                        <div class="h-6 bg-gray-200 rounded-md w-1/4"></div>
                                        <div class="h-9 bg-gray-200 rounded-lg w-1/3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- 2. TARJETAS REALES --}}
            <div wire:loading.remove wire:target="buscar" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($servicios as $servicio)
                    <div x-data="{
                            modalOpen: false,
                            activeSlide: 0,
                            imagenes: [
                                @foreach($servicio->imagenes as $img)'{{ asset('storage/' . $img->imagen) }}',@endforeach
                            ]
                         }"
                         class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full overflow-hidden"
                         wire:key="servicio-{{ $servicio->id }}">

                        <div class="w-full h-48 relative bg-gray-100 shrink-0 group cursor-pointer" @click="modalOpen = true">
                            @if($servicio->imagenes->isNotEmpty())
                                <img src="{{ asset('storage/' . $servicio->imagenes->first()->imagen) }}"
                                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                     alt="{{ $servicio->nombre }}">
                                @if(!$this->esGuianza())
                                <button type="button" @click.stop="modalOpen = true" class="absolute top-3 right-3 bg-white/90 text-gray-800 text-[10px] font-bold uppercase px-3 py-1.5 rounded-full shadow-md hover:bg-white transition flex items-center gap-1.5 z-20 outline-none backdrop-blur-sm cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Ver
                                </button>
                                @endif
                            @else
                                @if($this->esGuianza())
                                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-green-500 to-green-700 text-white group-hover:from-green-600 group-hover:to-green-800 transition-colors duration-300">
                                        <svg class="w-10 h-10 mb-1 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="font-medium tracking-wider text-[10px] uppercase opacity-90">Guianza</span>
                                        <button type="button" @click.stop="modalOpen = true" class="absolute top-3 right-3 bg-white/90 text-gray-800 text-[10px] font-bold uppercase px-3 py-1.5 rounded-full shadow-md hover:bg-white transition flex items-center gap-1.5 z-20 outline-none backdrop-blur-sm cursor-pointer opacity-0 group-hover:opacity-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Detalles
                                        </button>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-gray-400 font-medium text-xs bg-gray-200">Sin foto</div>
                                @endif
                            @endif
                            
                            <div class="absolute bottom-2 left-2 bg-white/90 text-gray-800 text-[9px] font-semibold uppercase px-2 py-0.5 rounded shadow-sm z-20 tracking-wide backdrop-blur-sm">
                                {{ $tipoServicio->nombre }}
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="text-base font-bold text-gray-900 leading-tight mb-1 line-clamp-1">{{ $servicio->nombre }}</h3>
                            
                            @if($servicio->detallePaqueteTuristico)
                                <p class="text-xs text-gray-500 mb-2 font-medium">{{ $servicio->detallePaqueteTuristico->duracion_dias }} días</p>
                            @elseif($servicio->detalleHospedaje)
                                <p class="text-xs text-gray-500 mb-2 font-medium">Máx: {{ $servicio->detalleHospedaje->capacidad }} pers. / hab.</p>
                            @elseif($servicio->detalleGuianza)
                                <p class="text-xs text-gray-500 mb-2 font-medium">Máx: {{ $servicio->detalleGuianza->numero_max_persona }} pers. por guía</p>
                            @else
                                <p class="text-xs text-gray-500 mb-2 line-clamp-1 font-medium">{{ $servicio->descripcion }}</p>
                            @endif

                            @if(!str_contains(strtolower($tipoServicio->nombre), 'aliment'))
                                <div class="bg-gray-50 rounded-lg p-2 flex items-center gap-1.5 mb-4 border border-gray-100">
                                    <span class="text-xs">🎒</span>
                                    <span class="text-xs font-semibold text-green-600">
                                        @if($this->esAlquiler()) Equipos disp: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @elseif($this->esPaquete()) Paquetes disp: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @elseif($this->esHospedaje()) Habitaciones disp: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @elseif($this->esGuianza()) Guías disp: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @else Disp: {{ $disponibilidadServicios[$servicio->id] ?? 0 }}
                                        @endif
                                    </span>
                                </div>
                            @endif

                            <div class="mt-auto space-y-4">
                                @if($this->esHospedaje())
                                <div class="flex items-center justify-between bg-green-50 p-2 rounded-lg border border-green-200">
                                    <span class="font-semibold text-green-800 text-[10px] uppercase tracking-wide">Huéspedes</span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" wire:click.stop="disminuirPersonas({{ $servicio->id }})" class="w-6 h-6 rounded-full bg-white border border-green-300 text-green-700 flex items-center justify-center hover:bg-green-100 transition-colors outline-none shadow-sm"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></button>
                                        <span class="w-4 text-center font-bold text-gray-800 text-sm">{{ $personasTarjetas[$servicio->id] ?? 1 }}</span>
                                        <button type="button" wire:click.stop="aumentarPersonas({{ $servicio->id }})" class="w-6 h-6 rounded-full bg-green-600 text-white flex items-center justify-center hover:bg-green-700 transition-colors outline-none shadow-sm"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></button>
                                    </div>
                                </div>
                                @else
                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg border border-gray-200">
                                    <span class="font-semibold text-gray-700 text-[10px] uppercase tracking-wide">
                                        @if($this->esAlquiler()) Cant. Equipos @elseif($this->esPaquete()) Cant. Paquetes @elseif($this->esGuianza()) Cant. Guías @elseif(str_contains(strtolower($tipoServicio->nombre), 'aliment')) Cant. Platos @else Cantidad @endif
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" wire:click.stop="disminuirCantidad({{ $servicio->id }})" class="w-6 h-6 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-300 transition-colors outline-none shadow-sm"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg></button>
                                        <span class="w-4 text-center font-bold text-gray-800 text-sm">{{ $cantidadesTarjetas[$servicio->id] ?? 1 }}</span>
                                        <button type="button" wire:click.stop="aumentarCantidad({{ $servicio->id }})" class="w-6 h-6 rounded-full bg-gray-800 text-white flex items-center justify-center hover:bg-gray-900 transition-colors outline-none shadow-sm"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></button>
                                    </div>
                                </div>
                                @endif

                                <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs text-gray-500 font-medium">desde</span>
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($servicio->precio, 2) }}</span>
                                    </div>
                                    <button type="button" wire:click.stop="agregarAlCarrito({{ $servicio->id }})" wire:loading.attr="disabled" wire:target="agregarAlCarrito({{ $servicio->id }})" class="bg-[#00D65B] text-[#06281E] text-xs font-bold px-4 py-2.5 rounded-lg hover:bg-[#00c052] active:scale-95 transition-all outline-none shadow-sm">
                                        <span wire:loading.remove wire:target="agregarAlCarrito({{ $servicio->id }})">Añadir</span>
                                        <span wire:loading wire:target="agregarAlCarrito({{ $servicio->id }})" class="flex items-center gap-1 justify-center">
                                            <svg class="animate-spin h-3.5 w-3.5 text-[#06281E]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Cargando
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Modal detalle --}}
                        <template x-teleport="body">
                            <div x-show="modalOpen" x-cloak
                                 class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 sm:p-6"
                                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div @click.away="modalOpen = false"
                                     class="bg-white rounded-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden flex flex-col lg:flex-row relative shadow-2xl"
                                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                    <button @click="modalOpen = false" class="absolute top-3 right-3 z-50 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full backdrop-blur shadow-sm transition outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    <div class="w-full lg:w-1/2 bg-gray-100 h-64 lg:h-auto relative p-3 lg:p-4 flex items-center justify-center">
                                        <template x-if="imagenes.length > 0">
                                            <div class="w-full h-full relative group/carousel rounded-xl overflow-hidden shadow-inner bg-black">
                                                <img :src="imagenes[activeSlide]" class="w-full h-full object-cover transition-opacity duration-500">
                                                <div x-show="imagenes.length > 1" class="absolute inset-0 flex items-center justify-between px-3 opacity-0 group-hover/carousel:opacity-100 transition-opacity">
                                                    <button @click="activeSlide = activeSlide === 0 ? imagenes.length - 1 : activeSlide - 1" class="bg-white/80 hover:bg-white p-2 rounded-full shadow-md text-gray-800 outline-none">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <button @click="activeSlide = activeSlide === imagenes.length - 1 ? 0 : activeSlide + 1" class="bg-white/80 hover:bg-white p-2 rounded-full shadow-md text-gray-800 outline-none">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                </div>
                                                <div x-show="imagenes.length > 1" class="absolute bottom-3 left-0 right-0 flex justify-center gap-2">
                                                    <template x-for="(img, index) in imagenes" :key="index">
                                                        <button @click="activeSlide = index" :class="{'bg-white w-5': activeSlide === index, 'bg-white/50 w-2': activeSlide !== index}" class="h-2 rounded-full transition-all outline-none shadow-sm"></button>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="imagenes.length === 0">
                                            @if($this->esGuianza())
                                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-green-500 to-green-700 text-white rounded-xl shadow-inner">
                                                    <svg class="w-16 h-16 mb-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    <span class="font-medium tracking-wider text-sm uppercase opacity-90">Guianza</span>
                                                </div>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400 font-medium text-sm border border-gray-200 rounded-xl">Sin imágenes</div>
                                            @endif
                                        </template>
                                    </div>
                                    <div class="w-full lg:w-1/2 p-6 lg:p-8 overflow-y-auto max-h-[90vh] custom-scrollbar bg-white">
                                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase bg-green-50 text-green-700 rounded mb-3">{{ $tipoServicio->nombre }}</span>
                                        <h2 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">{{ $servicio->nombre }}</h2>
                                        <p class="text-gray-600 leading-relaxed mb-6 text-sm font-medium">{{ $servicio->descripcion }}</p>
                                        <div class="space-y-4">
                                            @if($servicio->detallePaqueteTuristico)
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-1.5 text-sm">✨ Servicios Incluidos</h4>
                                                    <p class="text-xs text-gray-600 whitespace-pre-line">{{ $servicio->detallePaqueteTuristico->servicios_incluidos }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-1.5 text-sm">📍 Lugares y Actividades</h4>
                                                    <p class="text-xs text-gray-600 whitespace-pre-line">{{ $servicio->detallePaqueteTuristico->lugares_actividades }}</p>
                                                </div>
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                    <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-1.5 text-sm">💡 Recomendaciones</h4>
                                                    <p class="text-xs text-gray-600 whitespace-pre-line">{{ $servicio->detallePaqueteTuristico->recomendaciones }}</p>
                                                </div>
                                                @if($servicio->detallePaqueteTuristico->documento)
                                                <a href="{{ asset('storage/' . $servicio->detallePaqueteTuristico->documento) }}" target="_blank"
                                                   class="flex items-center justify-center gap-2 w-full py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-black transition outline-none shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                    Descargar Itinerario (PDF)
                                                </a>
                                                @endif
                                            @endif
                                            @if($servicio->detalleAlimentacion)
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm">
                                                    <p class="text-gray-600 mb-1"><strong class="text-gray-800">Tipo:</strong> {{ $servicio->detalleAlimentacion->tipo_alimentacion }}</p>
                                                    <p class="text-gray-600"><strong class="text-gray-800">Lugar:</strong> {{ $servicio->detalleAlimentacion->lugar_alimentacion }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                                            <div class="flex flex-col">
                                                <span class="text-[11px] font-medium text-gray-400 mb-0.5">Precio base</span>
                                                <span class="text-2xl font-bold text-gray-900">${{ number_format($servicio->precio, 2) }}</span>
                                            </div>
                                            <button @click="modalOpen = false" class="bg-gray-100 text-gray-700 font-semibold text-sm px-6 py-2.5 rounded-lg hover:bg-gray-200 transition outline-none">
                                                Cerrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 text-center rounded-xl border border-gray-200 shadow-sm flex flex-col items-center mt-4">
                        <span class="text-4xl mb-3 text-gray-300">🍃</span>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">No hay disponibilidad</h3>
                        <p class="text-gray-500 text-sm">Intenta buscando con otras fechas u otra categoría.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

    {{-- Espaciador fantasma para que el carrito inferior no tape el contenido --}}
    @if(count($carrito) > 0)
        <div class="h-32 w-full pointer-events-none opacity-0"></div>
    @endif

    {{-- CARRITO FLOTANTE CON MAYOR CONTRASTE --}}
    @if(count($carrito) > 0)
        @php
            $totalReserva = collect($carrito)->sum('subtotal');
        @endphp
        <div class="fixed bottom-0 left-0 right-0 z-50 transition-transform duration-300" x-data="{ mostrarLista: true }" @servicio-agregado.window="mostrarLista = true">
            <div class="max-w-4xl mx-auto md:px-4">
                <div class="bg-white shadow-[0_-15px_40px_rgba(0,0,0,0.25)] border border-gray-400 border-b-0 w-full flex flex-col rounded-t-2xl overflow-hidden">
                    
                    <button x-on:click="mostrarLista = !mostrarLista" class="w-full flex items-center justify-center gap-1.5 py-2.5 text-gray-700 hover:text-black transition-colors text-[10px] font-bold uppercase tracking-wider bg-gray-100 border-b border-gray-300 outline-none">
                        <span x-text="mostrarLista ? 'Ocultar reserva' : 'Ver reserva'"></span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300" x-bind:class="mostrarLista ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="mostrarLista" x-collapse class="max-h-[35vh] overflow-y-auto px-4 md:px-6 bg-white custom-scrollbar">
                        <div class="flex flex-col py-1 space-y-2 mt-1">
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
                                <div class="flex items-center justify-between py-2 border-b border-gray-50 gap-2 md:gap-3" wire:key="cart-item-{{ $index }}">
                                    <div class="flex items-center gap-2 md:gap-3 flex-1 min-w-0">
                                        <button wire:click="quitarDelCarrito({{ $index }})" class="text-gray-400 hover:text-red-500 transition-colors bg-gray-50 hover:bg-red-50 w-5 h-5 md:w-6 md:h-6 flex items-center justify-center rounded-full shrink-0 border border-gray-200 outline-none">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <div class="bg-gray-100 text-gray-700 px-1.5 py-0.5 rounded text-[10px] font-bold border border-gray-200 shrink-0">
                                            {{ $item['cantidad'] ?? 1 }}
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <h4 class="font-semibold text-xs text-gray-800 truncate">{{ $item['nombre'] }}</h4>
                                            <p class="text-[9px] text-gray-500 truncate mt-0.5">
                                                @if($esHosp)
                                                    {{ $item['numero_personas'] ?? 1 }} pers. @if($aplicaDias) &times; {{ $dias }} días @endif
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
                                    <div class="shrink-0 font-bold text-gray-900 text-sm md:text-base text-right pl-2">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 px-4 py-3 md:px-6 md:py-4 bg-gray-50 border-t border-gray-300">
                        <div class="flex flex-col min-w-0">
                            <span class="text-xl md:text-2xl font-bold text-gray-900 leading-none">${{ number_format($totalReserva, 2) }}</span>
                            <span class="text-gray-500 text-[9px] font-bold uppercase tracking-wide mt-1">Total a pagar</span>
                        </div>
                        
                        <div class="shrink-0">
                            @if(Auth::check())
                                <button wire:click="irAlCheckout" 
                                        class="px-5 py-2.5 md:px-6 md:py-2.5 rounded-lg uppercase text-[10px] md:text-xs font-bold transition-all flex items-center gap-1.5 md:gap-2 outline-none bg-[#00D65B] text-[#06281E] hover:bg-[#00c052] shadow-sm">
                                    Reservar
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            @else
                                <button type="button" 
                                        x-data 
                                        @click="$wire.guardarReservaInvitado().then(() => { $dispatch('mostrar-alerta-login') })"
                                        class="px-5 py-2.5 md:px-6 md:py-2.5 rounded-lg uppercase text-[10px] md:text-xs font-bold transition-all flex items-center gap-1.5 md:gap-2 outline-none bg-[#00D65B] text-[#06281E] hover:bg-[#00c052] shadow-sm">
                                    Reservar
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endif

    {{-- SISTEMA DE NOTIFICACIONES FLOTANTES --}}
    <div x-data="{
            notifications: [],
            displayDuration: 8000,
            addNotification({ variant = 'info', title = null, message = null}) {
                const id = Date.now()
                const notification = { id, variant, title, message }
                if (this.notifications.length >= 20) {
                    this.notifications.splice(0, this.notifications.length - 19)
                }
                this.notifications.push(notification)
            },
            removeNotification(id) {
                setTimeout(() => {
                    this.notifications = this.notifications.filter((notification) => notification.id !== id)
                }, 400);
            },
        }" 
        x-on:notificar.window="
            let n = $event.detail[0] || $event.detail;
            addNotification({
                variant: n.tipo === 'error' ? 'danger' : (n.tipo === 'warning' ? 'warning' : (n.tipo === 'info' ? 'info' : 'success')),
                title: n.tipo === 'error' ? 'Error' : (n.tipo === 'warning' ? 'Atención' : 'Notificación'),
                message: n.mensaje
            });
        "
        x-on:mostrar-alerta-login.window="
            addNotification({
                variant: 'auth',
                title: 'Autenticación Requerida',
                message: 'Para hacer una reserva debe iniciar sesión o registrarse.'
            });
        "
        class="group pointer-events-none fixed inset-x-4 bottom-28 z-[300] flex max-w-full flex-col gap-2 md:left-[unset] md:right-6 md:max-w-md">
        
        <template x-for="(notification, index) in notifications" x-bind:key="notification.id">
            <div>
                <template x-if="notification.variant === 'auth'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible" class="pointer-events-auto relative rounded-xl border border-gray-200 bg-white text-gray-800 shadow-xl" role="alert" x-init="$nextTick(() => { isVisible = true })" x-transition:enter="transition duration-300 ease-out" x-transition:enter-end="translate-y-0 opacity-100" x-transition:enter-start="translate-y-8 opacity-0" x-transition:leave="transition duration-200 ease-in" x-transition:leave-end="translate-x-8 opacity-0" x-transition:leave-start="translate-x-0 opacity-100">
                        <div class="flex w-full rounded-xl items-start gap-4 bg-white p-5 transition-all duration-300">
                            <div class="rounded-full bg-yellow-50 p-1.5 text-yellow-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="flex flex-col gap-1 w-full mt-0.5">
                                <h3 class="text-base font-bold text-gray-900" x-text="notification.title"></h3>
                                <p class="text-sm text-gray-500 leading-relaxed font-medium" x-text="notification.message"></p>
                                <div class="flex items-center gap-2 mt-3">
                                    <a href="{{ route('login', ['reserva' => 1]) }}" class="bg-[#00D65B] px-5 py-2 rounded text-xs font-bold uppercase text-[#06281E] hover:bg-[#00c052] transition shadow-sm">Aceptar</a>
                                    <button type="button" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition uppercase tracking-wide px-2" x-on:click="(isVisible = false), setTimeout(() => { removeNotification(notification.id) }, 400)">Cancelar</button>
                                </div>
                            </div>
                            <button type="button" class="ml-auto text-gray-400 hover:text-gray-600 -mt-1 -mr-1" aria-label="dismiss" x-on:click="(isVisible = false), setTimeout(() => { removeNotification(notification.id) }, 400)">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="notification.variant !== 'auth'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible" class="pointer-events-auto relative rounded-xl border bg-white shadow-lg" :class="{'border-red-400': notification.variant === 'danger', 'border-[#00D65B]': notification.variant === 'success', 'border-yellow-400': notification.variant === 'warning', 'border-blue-400': notification.variant === 'info'}" role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)" x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)" x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))" x-transition:enter="transition duration-300 ease-out" x-transition:enter-end="translate-y-0 opacity-100" x-transition:enter-start="translate-y-8 opacity-0" x-transition:leave="transition duration-200 ease-in" x-transition:leave-end="translate-x-8 opacity-0" x-transition:leave-start="translate-x-0 opacity-100">
                        <div class="flex w-full items-center gap-3.5 rounded-xl p-4 transition-all duration-300" :class="{'bg-red-50/50': notification.variant === 'danger', 'bg-green-50/50': notification.variant === 'success', 'bg-yellow-50/50': notification.variant === 'warning', 'bg-blue-50/50': notification.variant === 'info'}">
                            <div class="rounded-full p-1.5" :class="{'bg-red-100 text-red-600': notification.variant === 'danger', 'bg-green-100 text-[#00A344]': notification.variant === 'success', 'bg-yellow-100 text-yellow-600': notification.variant === 'warning', 'bg-blue-100 text-blue-600': notification.variant === 'info'}">
                                <template x-if="notification.variant === 'success'">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                                </template>
                                <template x-if="notification.variant === 'danger' || notification.variant === 'warning'">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                                </template>
                                <template x-if="notification.variant === 'info'">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" /></svg>
                                </template>
                            </div>
                            <div class="flex flex-col w-full">
                                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide" x-text="notification.title"></h3>
                                <p class="text-sm text-gray-600 mt-0.5" x-text="notification.message"></p>
                            </div>
                            <button type="button" class="ml-auto text-gray-400 hover:text-gray-600" aria-label="dismiss" x-on:click="(isVisible = false), setTimeout(() => { removeNotification(notification.id) }, 400)">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    @if(session()->has('mensaje_exito'))
        <div x-data x-init="
            $nextTick(() => {
                $dispatch('notificar', { tipo: 'success', mensaje: '{{ session('mensaje_exito') }}' });
            });
        "></div>
    @endif
    
    @if(session()->has('error'))
        <div x-data x-init="
            $nextTick(() => {
                $dispatch('notificar', { tipo: 'error', mensaje: '{{ session('error') }}' });
            });
        "></div>
    @endif

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; appearance: textfield; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
</div>