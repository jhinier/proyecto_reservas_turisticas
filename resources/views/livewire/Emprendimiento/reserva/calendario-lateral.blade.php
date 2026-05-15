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
        
        {{-- SIDEBAR IZQUIERDO (Mini Calendario Mensual y Leyendas) --}}
        <div class="w-full md:w-80 bg-[#3B4D36] text-[#F1EAD7] flex flex-col h-full shrink-0 shadow-lg z-20">
            <div class="p-6 flex justify-between items-center border-b border-[#8DBEA2]/20">
                <button @click="$wire.cerrar()" class="bg-white/10 p-2 rounded-xl hover:bg-[#C6A24D] hover:text-[#3B4D36] transition">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <h2 class="text-xl font-black text-[#C6A24D]">Agenda</h2>
            </div>

            <div class="p-6 flex-1 overflow-y-auto space-y-8">
                <div class="bg-[#F1EAD7]/10 p-5 rounded-3xl border border-[#8DBEA2]/20">
                    <div class="flex justify-between items-center mb-5">
                        <span class="font-black text-[#F1EAD7] text-sm capitalize">{{ $this->datosCalendario['nombreMes'] }}</span>
                        <div class="flex gap-1">
                            <button wire:click="mesAnterior" class="p-1 rounded-md text-[#8DBEA2] hover:text-[#C6A24D] transition"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                            <button wire:click="mesSiguiente" class="p-1 rounded-md text-[#8DBEA2] hover:text-[#C6A24D] transition"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center text-[9px] font-black text-[#8DBEA2] uppercase mb-2">
                        <span>Lu</span><span>Ma</span><span>Mi</span><span>Ju</span><span>Vi</span><span>Sa</span><span>Do</span>
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        @for($i = 1; $i < $this->datosCalendario['primerDiaSemana']; $i++) 
                            <div></div> 
                        @endfor
                        
                        @for($dia = 1; $dia <= $this->datosCalendario['diasEnMes']; $dia++)
                            @php 
                                $fechaStr = \Carbon\Carbon::create($this->anioActual, $this->mesActual, $dia)->format('Y-m-d');
                                $esSeleccionado = $fechaStr === $this->diaSeleccionado;
                            @endphp
                            <button wire:click="seleccionarDia({{ $dia }})" 
                                    class="aspect-square flex items-center justify-center text-xs font-bold transition rounded-lg {{ $esSeleccionado ? 'bg-[#C6A24D] text-[#3B4D36] shadow-md z-10' : 'text-[#F1EAD7] hover:bg-[#8DBEA2]/30' }}">
                                {{ $dia }}
                            </button>
                        @endfor
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-[10px] font-black text-[#8DBEA2] uppercase tracking-widest mb-4">Leyenda de Categorías</h3>
                    <div class="flex items-center gap-3 bg-[#F1EAD7]/5 p-3 rounded-xl border border-[#F1EAD7]/10">
                        <div class="size-4 rounded-full bg-[#8DBEA2]"></div>
                        <span class="text-xs font-bold">Hospedaje</span>
                    </div>
                    <div class="flex items-center gap-3 bg-[#F1EAD7]/5 p-3 rounded-xl border border-[#F1EAD7]/10">
                        <div class="size-4 rounded-full bg-[#C6A24D]"></div>
                        <span class="text-xs font-bold">Guianza / Tours</span>
                    </div>
                    <div class="flex items-center gap-3 bg-[#F1EAD7]/5 p-3 rounded-xl border border-[#F1EAD7]/10">
                        <div class="size-4 rounded-full bg-[#855A37]"></div>
                        <span class="text-xs font-bold">Alimentación</span>
                    </div>
                    <div class="flex items-center gap-3 bg-[#F1EAD7]/5 p-3 rounded-xl border border-[#F1EAD7]/10">
                        <div class="size-4 rounded-full bg-[#32744C]"></div>
                        <span class="text-xs font-bold">Paquetes / Otros</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENIDO DERECHO (Agenda Semanal) --}}
        <div class="flex-1 flex flex-col h-full bg-white relative">
            <div wire:loading.flex wire:target="mesAnterior, mesSiguiente, seleccionarDia, semanaAnterior, semanaSiguiente, irAHoy" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-30 items-center justify-center">
                <div class="animate-spin size-8 border-4 border-[#C6A24D] border-t-[#3B4D36] rounded-full"></div>
            </div>

            {{-- Cabecera del Panel Derecho --}}
            <div class="p-4 md:p-6 border-b border-[#CFE2CF] flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white z-20 shrink-0">
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-[#3B4D36] flex items-center gap-2">
                        @if(isset($this->diasMostrar) && count($this->diasMostrar) > 0)
                            {{ $this->diasMostrar[0]->translatedFormat('d M') }} 
                            <svg class="size-5 text-[#C6A24D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            {{ $this->diasMostrar[6]->translatedFormat('d M, Y') }}
                        @endif
                    </h2>
                    <p class="text-xs font-bold text-[#7C8D54] uppercase tracking-wider mt-1">Control de ocupación semanal</p>
                </div>
                
                <div class="flex items-center gap-2 bg-[#F1EAD7]/30 border border-[#CFE2CF]/50 rounded-xl p-1">
                    <button wire:click="semanaAnterior" class="p-2 hover:bg-white rounded-lg text-[#32744C] transition shadow-sm border border-transparent hover:border-[#CFE2CF]">
                        <svg class="size-4 md:size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button wire:click="irAHoy" class="px-3 py-1.5 text-xs font-black text-[#3B4D36] hover:text-[#C6A24D] uppercase tracking-wide transition">
                        Hoy
                    </button>
                    <button wire:click="semanaSiguiente" class="p-2 hover:bg-white rounded-lg text-[#32744C] transition shadow-sm border border-transparent hover:border-[#CFE2CF]">
                        <svg class="size-4 md:size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- VISTA MÓVIL: Timeline Vertical --}}
            {{-- ========================================== --}}
            <div class="block lg:hidden flex-1 overflow-y-auto px-4 py-6 space-y-8 bg-white relative">
                @if(isset($this->diasMostrar))
                    @foreach($this->diasMostrar as $dia)
                        @php 
                            $esHoy = $dia->isToday();
                            $fechaStr = $dia->format('Y-m-d');
                            $serviciosDelDia = $this->agendaPorDia[$fechaStr] ?? [];
                        @endphp
                        
                        <div class="relative">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex flex-col items-center justify-center w-12 h-12 rounded-2xl {{ $esHoy ? 'bg-[#32744C] text-[#F1EAD7] shadow-md' : 'bg-white text-[#3B4D36] border border-[#CFE2CF]' }}">
                                    <span class="text-[9px] font-black uppercase tracking-widest">{{ $dia->translatedFormat('D') }}</span>
                                    <span class="text-lg font-black leading-none mt-0.5">{{ $dia->format('d') }}</span>
                                </div>
                                <div class="flex-1 border-b-2 {{ $esHoy ? 'border-[#32744C]' : 'border-[#CFE2CF]/50' }} border-dashed mt-2"></div>
                            </div>

                            <div class="pl-[3.5rem] space-y-2">
                                @forelse($serviciosDelDia as $item)
                                    @php
                                        $tipo = \Illuminate\Support\Str::slug($item->servicio->tipoServicio->nombre ?? '');
                                        
                                        $estilo = match(true) {
                                            str_contains($tipo, 'hospedaje') => ['bg' => 'bg-[#8DBEA2]/40', 'border' => 'border-l-[12px] border-l-[#8DBEA2] border-y border-r border-[#8DBEA2]/50', 'text' => 'text-[#3B4D36]'],
                                            str_contains($tipo, 'guianza') || str_contains($tipo, 'tour') => ['bg' => 'bg-[#C6A24D]/30', 'border' => 'border-l-[12px] border-l-[#C6A24D] border-y border-r border-[#C6A24D]/50', 'text' => 'text-[#855A37]'],
                                            str_contains($tipo, 'alimentacion') => ['bg' => 'bg-[#855A37]/20', 'border' => 'border-l-[12px] border-l-[#855A37] border-y border-r border-[#855A37]/40', 'text' => 'text-[#855A37]'],
                                            default => ['bg' => 'bg-[#32744C]/20', 'border' => 'border-l-[12px] border-l-[#32744C] border-y border-r border-[#32744C]/40', 'text' => 'text-[#32744C]'],
                                        };

                                        $hora = $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--';
                                    @endphp

                                    <div class="p-3 rounded-xl shadow-sm hover:shadow-md transition flex flex-col gap-1 {{ $estilo['bg'] }} {{ $estilo['border'] }}">
                                        <div class="flex items-center gap-1.5 mb-1 {{ $estilo['text'] }}">
                                            <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="text-xs font-black">{{ $hora }}</span>
                                        </div>
                                        <p class="text-sm font-extrabold leading-tight text-[#3B4D36]">{{ $item->servicio->nombre }}</p>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 border border-gray-100 border-dashed rounded-xl p-3 flex items-center gap-2">
                                        <div class="size-1.5 rounded-full bg-gray-300"></div>
                                        <p class="text-[11px] font-medium text-gray-400">Sin agendamientos</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- ========================================== --}}
            {{-- VISTA DESKTOP: Grid Corporativo --}}
            {{-- ========================================== --}}
            <div class="hidden lg:flex flex-col flex-1 overflow-hidden bg-white">
                
                {{-- Fila de Cabeceras (Días) --}}
                <div class="grid grid-cols-7 border-b border-[#CFE2CF] shrink-0 bg-white shadow-sm z-10">
                    @if(isset($this->diasMostrar))
                        @foreach($this->diasMostrar as $dia)
                            @php $esHoy = $dia->isToday(); @endphp
                            <div class="text-center py-3 border-r border-[#CFE2CF]/50 last:border-r-0 relative {{ $esHoy ? 'bg-[#F1EAD7]/30' : '' }}">
                                @if($esHoy)
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-[#C6A24D]"></div>
                                @endif
                                <span class="block text-[10px] font-bold uppercase tracking-widest {{ $esHoy ? 'text-[#C6A24D]' : 'text-[#7C8D54]' }}">
                                    {{ $dia->translatedFormat('l') }}
                                </span>
                                <span class="text-xl md:text-2xl font-black {{ $esHoy ? 'text-[#32744C]' : 'text-[#3B4D36]' }}">
                                    {{ $dia->format('d') }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Cuerpo del Calendario --}}
                <div class="flex-1 overflow-y-auto relative bg-white">
                    <div class="absolute inset-0 pointer-events-none" style="background-image: repeating-linear-gradient(transparent, transparent 59px, #CFE2CF 60px); opacity: 0.4;"></div>
                    
                    <div class="grid grid-cols-7 h-full min-h-[600px] divide-x divide-[#CFE2CF]/50 relative z-10">
                        @if(isset($this->diasMostrar))
                            @foreach($this->diasMostrar as $dia)
                                @php 
                                    $fechaStr = $dia->format('Y-m-d');
                                    $serviciosDelDia = $this->agendaPorDia[$fechaStr] ?? [];
                                    $esHoy = $dia->isToday();
                                @endphp
                                
                                <div class="flex flex-col gap-2 p-2 {{ $esHoy ? 'bg-[#F1EAD7]/10' : '' }}">
                                    @foreach($serviciosDelDia as $item)
                                        @php
                                            $tipo = \Illuminate\Support\Str::slug($item->servicio->tipoServicio->nombre ?? '');
                                            
                                            $estilo = match(true) {
                                                str_contains($tipo, 'hospedaje') => ['bg' => 'bg-[#8DBEA2]/40', 'border' => 'border-l-[12px] border-l-[#8DBEA2] border-y border-r border-[#8DBEA2]/50', 'text' => 'text-[#3B4D36]'],
                                                str_contains($tipo, 'guianza') || str_contains($tipo, 'tour') => ['bg' => 'bg-[#C6A24D]/30', 'border' => 'border-l-[12px] border-l-[#C6A24D] border-y border-r border-[#C6A24D]/50', 'text' => 'text-[#855A37]'],
                                                str_contains($tipo, 'alimentacion') => ['bg' => 'bg-[#855A37]/20', 'border' => 'border-l-[12px] border-l-[#855A37] border-y border-r border-[#855A37]/40', 'text' => 'text-[#855A37]'],
                                                default => ['bg' => 'bg-[#32744C]/20', 'border' => 'border-l-[12px] border-l-[#32744C] border-y border-r border-[#32744C]/40', 'text' => 'text-[#32744C]'],
                                            };

                                            $hora = $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--';
                                        @endphp

                                        <div class="p-2 rounded-lg shadow-sm transition flex flex-col gap-1 {{ $estilo['bg'] }} {{ $estilo['border'] }}">
                                            <div class="flex items-center gap-1 mb-0.5 {{ $estilo['text'] }}">
                                                <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span class="text-[10px] font-black">{{ $hora }}</span>
                                            </div>
                                            <p class="text-xs font-bold leading-tight text-[#3B4D36] line-clamp-3">{{ $item->servicio->nombre }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>