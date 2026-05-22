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
        <div class="w-full md:w-80 bg-[#3B4D36] text-[#F1EAD7] flex flex-col flex-none md:h-full shadow-lg z-20">
            <div class="p-4 md:p-6 flex justify-between items-center border-b border-[#8DBEA2]/20 shrink-0">
                <button @click="$wire.cerrar()" class="bg-white/10 p-2 rounded-xl hover:bg-[#C6A24D] hover:text-[#3B4D36] transition">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <h2 class="text-xl font-black text-[#C6A24D]">Agenda</h2>
            </div>

            {{-- Ocultamos el calendario mensual en móviles (hidden md:block) --}}
            <div class="hidden md:block p-6 flex-1 overflow-y-auto space-y-8 custom-scrollbar">
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

        {{-- CONTENIDO DERECHO (min-h-0 arregla el corte visual) --}}
        <div class="flex-1 flex flex-col min-h-0 bg-white relative">
            <div wire:loading.flex wire:target="mesAnterior, mesSiguiente, seleccionarDia, semanaAnterior, semanaSiguiente, irAHoy" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-30 items-center justify-center">
                <div class="animate-spin size-8 border-4 border-[#C6A24D] border-t-[#3B4D36] rounded-full"></div>
            </div>

            {{-- Cabecera --}}
            <div class="p-4 md:p-6 border-b border-[#CFE2CF] flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white z-20 shrink-0 shadow-sm">
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-[#3B4D36] flex items-center gap-2">
                        @if(isset($this->diasMostrar) && count($this->diasMostrar) > 0)
                            {{ $this->diasMostrar[0]->translatedFormat('d M') }} 
                            <svg class="size-5 text-[#C6A24D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            {{ $this->diasMostrar[6]->translatedFormat('d M, Y') }}
                        @endif
                    </h2>
                    <p class="text-xs font-bold text-[#7C8D54] uppercase tracking-wider mt-1">Control de ocupación</p>
                </div>
                
                <div class="flex items-center gap-2 bg-[#F1EAD7]/30 border border-[#CFE2CF]/50 rounded-xl p-1 shrink-0 w-max">
                    <button wire:click="semanaAnterior" class="p-2 hover:bg-white rounded-lg text-[#32744C] transition shadow-sm border border-transparent hover:border-[#CFE2CF]">
                        <svg class="size-4 md:size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    
                    @php
                        $estamosEnSemanaActual = false;
                        if(isset($this->diasMostrar)) {
                            foreach($this->diasMostrar as $diaVerificar) {
                                if($diaVerificar->isToday()) {
                                    $estamosEnSemanaActual = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    <button wire:click="irAHoy" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-black text-[#3B4D36] hover:text-[#C6A24D] uppercase tracking-wide transition">
                        @if(!$estamosEnSemanaActual)
                            <span class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
                        {{ $estamosEnSemanaActual ? 'Hoy' : 'Volver' }}
                    </button>

                    <button wire:click="semanaSiguiente" class="p-2 hover:bg-white rounded-lg text-[#32744C] transition shadow-sm border border-transparent hover:border-[#CFE2CF]">
                        <svg class="size-4 md:size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>

            {{-- VISTA MÓVIL: Timeline Vertical --}}
            <div class="block lg:hidden flex-1 overflow-y-auto px-4 py-6 bg-white relative">
                @if(isset($this->diasMostrar))
                    @foreach($this->diasMostrar as $dia)
                        @php 
                            $esHoy = $dia->isToday();
                            $fechaStr = $dia->format('Y-m-d');
                            $serviciosDelDia = $this->agendaPorDia[$fechaStr] ?? [];
                        @endphp
                        
                        <div class="mb-8">
                            <div class="mb-4 flex items-baseline gap-2 border-b border-gray-100 pb-2 sticky top-0 bg-white/95 backdrop-blur z-10">
                                <h3 class="text-lg font-black text-[#3B4D36]">{{ $dia->format('d M') }}</h3>
                                <span class="text-sm font-bold text-gray-400 capitalize">{{ $dia->translatedFormat('l') }}</span>
                                @if($esHoy) <span class="text-[10px] uppercase bg-[#C6A24D]/10 px-2 py-0.5 rounded text-[#C6A24D] font-black tracking-widest ml-auto border border-[#C6A24D]/20">Hoy</span> @endif
                            </div>

                            <div class="space-y-3">
                                @forelse($serviciosDelDia as $item)
                                    @php
                                        $tipo = \Illuminate\Support\Str::slug($item->servicio->tipoServicio->nombre ?? '');
                                        
                                        $estilo = match(true) {
                                            str_contains($tipo, 'hospedaj') || str_contains($tipo, 'alojamient') => 'border-l-[6px] border-l-[#8DBEA2] border-y border-r border-gray-100',
                                            str_contains($tipo, 'guianz') || str_contains($tipo, 'tour') => 'border-l-[6px] border-l-[#C6A24D] border-y border-r border-gray-100',
                                            str_contains($tipo, 'aliment') || str_contains($tipo, 'restauran') => 'border-l-[6px] border-l-[#855A37] border-y border-r border-gray-100',
                                            default => 'border-l-[6px] border-l-[#32744C] border-y border-r border-gray-100',
                                        };

                                        $hora = $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--';
                                    @endphp

                                    <div class="flex gap-3 items-center">
                                        <div class="w-12 shrink-0 text-right">
                                            <p class="text-[11px] font-black text-[#3B4D36] opacity-80">{{ $hora }}</p>
                                        </div>
                                        
                                        <div class="flex-1 p-3 rounded-xl bg-gray-50 shadow-sm flex justify-between items-center hover:scale-[1.02] transition {{ $estilo }}">
                                            <div>
                                                <h4 class="text-sm font-bold text-[#3B4D36] mb-0.5">{{ $item->servicio->nombre }}</h4>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-[9px] text-[#7C8D54] uppercase tracking-wider font-bold">{{ $item->servicio->tipoServicio->nombre }}</p>
                                                    <span class="text-[9px] bg-black/5 px-1.5 py-0.5 rounded font-black text-[#3B4D36]">x{{ $item->cantidad }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs font-bold text-gray-300 pl-16 pt-2 italic">Sin agendamientos</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- VISTA DESKTOP: Grid Corporativo --}}
            <div class="hidden lg:flex flex-col flex-1 overflow-hidden bg-white">
                <div class="grid grid-cols-7 border-b border-[#CFE2CF] shrink-0 bg-white shadow-sm z-10">
                    @if(isset($this->diasMostrar))
                        @foreach($this->diasMostrar as $dia)
                            @php $esHoy = $dia->isToday(); @endphp
                            <div class="text-center py-3 border-r border-[#CFE2CF]/50 last:border-r-0 relative {{ $esHoy ? 'bg-[#F1EAD7]/30' : '' }}">
                                @if($esHoy)
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-[#C6A24D]"></div>
                                @endif
                                <span class="block text-[10px] font-bold uppercase tracking-widest {{ $esHoy ? 'text-[#C6A24D]' : 'text-[#7C8D54]' }}">
                                    {{ $esHoy ? 'Hoy' : $dia->translatedFormat('l') }}
                                </span>
                                <span class="text-xl md:text-2xl font-black {{ $esHoy ? 'text-[#32744C]' : 'text-[#3B4D36]' }}">
                                    {{ $dia->format('d') }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>

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
                                                str_contains($tipo, 'hospedaj') || str_contains($tipo, 'alojamient') => ['bg' => 'bg-[#8DBEA2]/40', 'border' => 'border-l-[12px] border-l-[#8DBEA2] border-y border-r border-[#8DBEA2]/50', 'text' => 'text-[#3B4D36]'],
                                                str_contains($tipo, 'guianz') || str_contains($tipo, 'tour') => ['bg' => 'bg-[#C6A24D]/30', 'border' => 'border-l-[12px] border-l-[#C6A24D] border-y border-r border-[#C6A24D]/50', 'text' => 'text-[#855A37]'],
                                                str_contains($tipo, 'aliment') || str_contains($tipo, 'restauran') => ['bg' => 'bg-[#855A37]/20', 'border' => 'border-l-[12px] border-l-[#855A37] border-y border-r border-[#855A37]/40', 'text' => 'text-[#855A37]'],
                                                default => ['bg' => 'bg-[#32744C]/20', 'border' => 'border-l-[12px] border-l-[#32744C] border-y border-r border-[#32744C]/40', 'text' => 'text-[#32744C]'],
                                            };

                                            $hora = $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--';
                                        @endphp

                                        <div class="p-2 rounded-lg shadow-sm transition flex flex-col gap-1 hover:shadow-md cursor-pointer {{ $estilo['bg'] }} {{ $estilo['border'] }}">
                                            <div class="flex items-center justify-between mb-0.5 {{ $estilo['text'] }}">
                                                <div class="flex items-center gap-1">
                                                    <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    <span class="text-[10px] font-black">{{ $hora }}</span>
                                                </div>
                                                <span class="text-[8px] font-black opacity-60">#{{ $item->reserva->id }}</span>
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