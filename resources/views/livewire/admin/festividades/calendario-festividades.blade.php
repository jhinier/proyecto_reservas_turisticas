<div>
    {{-- Fondo oscuro del Modal --}}
    <div x-show="$wire.abierto" 
         x-transition.opacity.duration.300ms
         @click="$wire.cerrar()"
         class="fixed inset-0 bg-[#3B4D36]/70 backdrop-blur-sm z-[60]"
         style="display: none;">
    </div>

    {{-- Contenedor del Modal --}}
    <div x-show="$wire.abierto"
         x-transition:enter="transition transform duration-300 ease-out"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform duration-200 ease-in"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed right-0 top-0 h-full w-full sm:w-[450px] md:w-[90vw] lg:w-[85vw] bg-white shadow-2xl z-[70] flex flex-col md:flex-row overflow-hidden border-l-4 border-[#C6A24D]"
         style="display: none;">
        
        {{-- SIDEBAR IZQUIERDO --}}
        <div class="w-full md:w-80 bg-[#3B4D36] text-[#F1EAD7] flex flex-col h-full shrink-0 shadow-lg z-20">

            <div class="p-6 flex justify-between items-center border-b border-[#8DBEA2]/20">
                <button @click="$wire.cerrar()" class="bg-white/10 p-2 rounded-xl hover:bg-[#C6A24D] hover:text-[#3B4D36] transition">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <h2 class="text-xl font-black text-[#C6A24D]">
                    Orden del día
                </h2>
            </div>

            <div class="p-6 flex-1 overflow-y-auto space-y-8">

                {{-- MINI CALENDARIO --}}
                <div class="bg-[#F1EAD7]/10 p-5 rounded-3xl border border-[#8DBEA2]/20">

                    <div class="flex justify-between items-center mb-5">
                        <span class="font-black text-[#F1EAD7] text-sm capitalize">
                            {{ $this->datosCalendario()['nombreMes'] }}
                        </span>

                        <div class="flex gap-1">
                            <button wire:click="mesAnterior" class="p-1 rounded-md text-[#8DBEA2] hover:text-[#C6A24D] transition">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button wire:click="mesSiguiente" class="p-1 rounded-md text-[#8DBEA2] hover:text-[#C6A24D] transition">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- DÍAS --}}
                    <div class="grid grid-cols-7 gap-1 text-center text-[9px] font-black text-[#8DBEA2] uppercase mb-2">
                        <span>Lu</span>
                        <span>Ma</span>
                        <span>Mi</span>
                        <span>Ju</span>
                        <span>Vi</span>
                        <span>Sa</span>
                        <span>Do</span>
                    </div>

                    {{-- NÚMEROS --}}
                    <div class="grid grid-cols-7 gap-1">

                        @for($i = 1; $i < $this->datosCalendario()['primerDiaSemana']; $i++)
                            <div></div>
                        @endfor

                        @for($dia = 1; $dia <= $this->datosCalendario()['diasEnMes']; $dia++)
                            @php
                                $fechaStr = \Carbon\Carbon::create($this->anioActual, $this->mesActual, $dia)->format('Y-m-d');

                                $esSeleccionado = $fechaStr === $this->diaSeleccionado;

                                $tieneActividades = isset($this->agendaPorDia()[$fechaStr]) 
                                    && count($this->agendaPorDia()[$fechaStr]) > 0;
                            @endphp

                            <button wire:click="seleccionarDia({{ $dia }})"
                                    class="relative aspect-square flex items-center justify-center text-xs font-bold transition rounded-lg
                                    {{ $esSeleccionado 
                                        ? 'bg-[#C6A24D] text-[#3B4D36] shadow-md z-10' 
                                        : 'text-[#F1EAD7] hover:bg-[#8DBEA2]/30' }}">

                                {{ $dia }}

                                @if($tieneActividades)
                                    <span class="absolute bottom-1 size-1.5 rounded-full bg-[#52B788]"></span>
                                @endif
                            </button>
                        @endfor

                    </div>
                </div>

                {{-- LEYENDA --}}
                <div class="space-y-3">
                    <h3 class="text-[10px] font-black text-[#8DBEA2] uppercase tracking-widest mb-4">
                        Leyenda
                    </h3>

                    <div class="flex items-center gap-3 bg-[#F1EAD7]/5 p-3 rounded-xl border border-[#F1EAD7]/10">
                        <div class="size-4 rounded-full bg-[#52B788]"></div>
                        <span class="text-xs font-bold">
                            Actividades de la Parroquia
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL DERECHO --}}
        <div class="flex-1 flex flex-col h-full bg-white relative">

            {{-- LOADING --}}
            <div wire:loading.flex 
                 wire:target="mesAnterior, mesSiguiente, seleccionarDia, irAHoy"
                 class="absolute inset-0 bg-white/60 backdrop-blur-sm z-30 items-center justify-center">

                <div class="animate-spin size-8 border-4 border-[#C6A24D] border-t-[#3B4D36] rounded-full"></div>
            </div>

            {{-- HEADER --}}
            <div class="p-4 md:p-6 border-b border-[#CFE2CF] flex justify-between items-center bg-white z-20 shrink-0">

                <div>
                    <h2 class="text-xl md:text-2xl font-black text-[#3B4D36]">
                        Agenda de Festividades
                    </h2>

                    <p class="text-xs font-bold text-[#7C8D54] uppercase tracking-wider mt-1">
                        Visualización por día seleccionado
                    </p>
                </div>

                <div class="flex items-center gap-2 bg-[#F1EAD7]/30 border border-[#CFE2CF]/50 rounded-xl p-1">
                    <button wire:click="irAHoy"
                            class="px-3 py-1.5 text-xs font-black text-[#3B4D36] hover:text-[#C6A24D] uppercase tracking-wide transition">
                        Hoy
                    </button>
                </div>
            </div>

            {{-- CONTENIDO --}}
            <div class="flex-1 overflow-y-auto p-6 bg-[#F8F9FA]">

                <div class="border-b border-gray-200 pb-3 mb-6">
                    <h2 class="text-lg font-bold text-[#3B4D36]">
                        Actividades del
                        <span class="text-[#C6A24D] font-black">
                            {{ \Carbon\Carbon::parse($diaSeleccionado)->translatedFormat('d \d\e F, Y') }}
                        </span>
                    </h2>
                </div>

                <div class="space-y-4">

                    @forelse($this->agendaPorDia()[$diaSeleccionado] ?? [] as $actividad)

                        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition space-y-4">

                            {{-- FESTIVIDAD --}}
                            <div class="border-b border-dashed border-[#CFE2CF] pb-3">

                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#7C8D54] block mb-2">
                                    Festividad
                                </span>

                                <h3 class="text-lg font-black text-[#32744C] leading-tight">
                                    {{ $actividad->publicacion->nombre ?? 'Festividad sin nombre' }}
                                </h3>

                            </div>

                            {{-- ACTIVIDAD --}}
                            <div>

                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#7C8D54] block mb-2">
                                    Actividad
                                </span>

                                <h4 class="text-base font-extrabold text-[#3B4D36]">
                                    {{ $actividad->nombre }}
                                </h4>

                            </div>

                            {{-- DATOS --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                                {{-- HORA --}}
                                <div class="bg-[#32744C]/5 border border-[#32744C]/10 rounded-xl p-3">
                                    <span class="text-[10px] uppercase font-black tracking-widest text-[#7C8D54] block mb-1">
                                        Hora
                                    </span>

                                    <p class="text-sm font-bold text-[#32744C]">
                                        🕒 {{ \Carbon\Carbon::parse($actividad->hora)->format('g:i A') }}
                                    </p>
                                </div>

                                {{-- LUGAR --}}
                                <div class="bg-[#C6A24D]/5 border border-[#C6A24D]/10 rounded-xl p-3">
                                    <span class="text-[10px] uppercase font-black tracking-widest text-[#7C8D54] block mb-1">
                                        Lugar
                                    </span>

                                    <p class="text-sm font-bold text-[#855A37]">
                                        📍 {{ $actividad->lugar ?: 'No especificado' }}
                                    </p>
                                </div>

                            </div>

                            {{-- DESCRIPCIÓN --}}
                            @if($actividad->descripcion)
                                <div class="bg-[#F8F9FA] border border-gray-100 rounded-2xl p-4">

                                    <span class="text-[10px] uppercase font-black tracking-widest text-[#7C8D54] block mb-2">
                                        Descripción
                                    </span>

                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        {{ $actividad->descripcion }}
                                    </p>

                                </div>
                            @endif

                        </div>

                    @empty

                        <div class="py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300 flex flex-col items-center justify-center">

                            <span class="text-4xl mb-3">🎉</span>

                            <h4 class="text-sm font-bold text-gray-400">
                                No hay actividades para este día
                            </h4>

                        </div>

                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>