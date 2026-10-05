<div>
    {{-- Fondo oscuro del Modal --}}
    <div x-show="$wire.abierto" 
         x-transition.opacity.duration.300ms
         @click="$wire.cerrar()"
         class="fixed inset-0 bg-[#06281E]/70 backdrop-blur-sm z-[60]"
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
         class="fixed right-0 top-0 h-full w-full sm:w-[450px] md:w-[90vw] lg:w-[85vw] bg-white dark:bg-[#050b09] shadow-2xl z-[70] flex flex-col md:flex-row overflow-hidden border-l-4 border-emerald-500"
         style="display: none;">
        
        {{-- SIDEBAR IZQUIERDO --}}
        <div class="w-full md:w-80 bg-[#06281E] dark:bg-[#000604] text-white flex flex-col flex-none md:h-full shadow-lg z-20">
            <div class="p-4 md:p-6 flex justify-between items-center border-b border-white/10 shrink-0">
                <button @click="$wire.cerrar()" class="bg-white/5 p-2 rounded-xl text-slate-400 hover:bg-emerald-500 hover:text-white transition">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <h2 class="text-xl font-black text-emerald-400">Agenda</h2>
            </div>

            {{-- Ocultamos el calendario mensual en móviles (hidden md:block) --}}
            <div class="hidden md:block p-6 flex-1 overflow-y-auto space-y-8 custom-scrollbar">
                <div class="bg-white/5 p-5 rounded-3xl border border-white/10">
                    <div class="flex justify-between items-center mb-5">
                        <span class="font-black text-white text-sm capitalize">{{ $this->datosCalendario['nombreMes'] }}</span>
                        <div class="flex gap-1">
                            <button wire:click="mesAnterior" class="p-1 rounded-md text-slate-400 hover:text-emerald-400 transition"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                            <button wire:click="mesSiguiente" class="p-1 rounded-md text-slate-400 hover:text-emerald-400 transition"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center text-[9px] font-black text-emerald-500 uppercase mb-2">
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
                                    class="aspect-square flex items-center justify-center text-xs font-bold transition rounded-lg {{ $esSeleccionado ? 'bg-emerald-500 text-white shadow-md z-10' : 'text-slate-300 hover:bg-slate-800' }}">
                                {{ $dia }}
                            </button>
                        @endfor
                    </div>
                </div>

                <div class="space-y-3">
                    <h3 class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-4">Leyenda de Categorías</h3>
                    <div class="flex items-center gap-3 bg-white/5 p-3 rounded-xl border border-white/10">
                        <div class="size-4 rounded-full bg-[#8DBEA2]"></div>
                        <span class="text-xs font-bold">Hospedaje</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 p-3 rounded-xl border border-white/10">
                        <div class="size-4 rounded-full bg-[#C6A24D]"></div>
                        <span class="text-xs font-bold">Guianza</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 p-3 rounded-xl border border-white/10">
                        <div class="size-4 rounded-full bg-[#855A37]"></div>
                        <span class="text-xs font-bold">Alimentación</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 p-3 rounded-xl border border-white/10">
                        <div class="size-4 rounded-full bg-[#32744C]"></div>
                        <span class="text-xs font-bold">Paquetes Turísticos</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/5 p-3 rounded-xl border border-white/10">
                        <div class="size-4 rounded-full bg-[#4A90E2]"></div>
                        <span class="text-xs font-bold">Alquiler de Equipos</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENIDO DERECHO --}}
        <div class="flex-1 flex flex-col min-h-0 bg-white dark:bg-[#050b09] relative">
            <div wire:loading.flex wire:target="mesAnterior, mesSiguiente, seleccionarDia, semanaAnterior, semanaSiguiente, irAHoy" class="absolute inset-0 bg-white/60 dark:bg-black/60 backdrop-blur-sm z-30 items-center justify-center">
                <div class="animate-spin size-8 border-4 border-emerald-200 dark:border-emerald-950 border-t-emerald-600 dark:border-t-emerald-400 rounded-full"></div>
            </div>

            {{-- Cabecera --}}
            <div class="p-4 md:p-6 border-b border-slate-200 dark:border-emerald-500/10 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white dark:bg-[#08110e] z-20 shrink-0 shadow-sm dark:shadow-black/30">
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-[#06281E] dark:text-white flex items-center gap-2">
                        @if(isset($this->diasMostrar) && count($this->diasMostrar) > 0)
                            {{ $this->diasMostrar[0]->translatedFormat('d M') }} 
                            <svg class="size-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                            {{ $this->diasMostrar[6]->translatedFormat('d M, Y') }}
                        @endif
                    </h2>
                    <p class="text-xs font-bold text-slate-500 dark:text-emerald-200/60 uppercase tracking-wider mt-1">Control de ocupación</p>
                </div>
                
                <div class="flex items-center gap-2 bg-slate-50 dark:bg-[#0b1713] border border-slate-200 dark:border-emerald-500/10 rounded-xl p-1 shrink-0 w-max">
                    <button wire:click="semanaAnterior" class="p-2 hover:bg-white dark:hover:bg-emerald-500/10 rounded-lg text-slate-600 dark:text-emerald-100/80 transition shadow-sm border border-transparent hover:border-slate-300 dark:hover:border-emerald-400/20">
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
                    <button wire:click="irAHoy" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-black text-[#06281E] dark:text-emerald-50 hover:text-emerald-600 dark:hover:text-emerald-300 uppercase tracking-wide transition">
                        @if(!$estamosEnSemanaActual)
                            <span class="size-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
                        {{ $estamosEnSemanaActual ? 'Hoy' : 'Volver' }}
                    </button>

                    <button wire:click="semanaSiguiente" class="p-2 hover:bg-white dark:hover:bg-emerald-500/10 rounded-lg text-slate-600 dark:text-emerald-100/80 transition shadow-sm border border-transparent hover:border-slate-300 dark:hover:border-emerald-400/20">
                        <svg class="size-4 md:size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>

            {{-- VISTA MÓVIL: Timeline Vertical --}}
            <div class="block lg:hidden flex-1 overflow-y-auto px-4 py-6 bg-white dark:bg-[#050b09] relative">
                @if(isset($this->diasMostrar))
                    @foreach($this->diasMostrar as $dia)
                        @php 
                            $esHoy = $dia->isToday();
                            $fechaStr = $dia->format('Y-m-d');
                            $serviciosDelDia = $this->agendaPorDia[$fechaStr] ?? [];
                        @endphp
                        
                        <div class="mb-8">
                            <div class="mb-4 flex items-baseline gap-2 border-b border-gray-100 dark:border-emerald-500/10 pb-2 sticky top-0 bg-white/95 dark:bg-[#050b09]/95 backdrop-blur z-10">
                                <h3 class="text-lg font-black text-[#06281E] dark:text-white">{{ $dia->format('d M') }}</h3>
                                <span class="text-sm font-bold text-gray-400 dark:text-emerald-100/50 capitalize">{{ $dia->translatedFormat('l') }}</span>
                                @if($esHoy) <span class="text-[10px] uppercase bg-emerald-100 dark:bg-emerald-500/20 px-2 py-0.5 rounded text-emerald-700 dark:text-emerald-300 font-black tracking-widest ml-auto border border-emerald-200 dark:border-emerald-400/20">Hoy</span> @endif
                            </div>

                            <div class="space-y-3">
                                @forelse($serviciosDelDia as $item)
                                    @php
                                        $tipo = \Illuminate\Support\Str::slug($item->servicio->tipoServicio->nombre ?? '');
                                        
                                        $estilo = match(true) {
                                            str_contains($tipo, 'hospedaj') || str_contains($tipo, 'alojamient') => 'border-l-[6px] border-l-[#8DBEA2] border-y border-r border-gray-100 dark:border-y-[#8DBEA2]/20 dark:border-r-[#8DBEA2]/20 bg-gray-50 dark:bg-[#8DBEA2]/10',
                                            str_contains($tipo, 'guianz') || str_contains($tipo, 'tour') => 'border-l-[6px] border-l-[#C6A24D] border-y border-r border-gray-100 dark:border-y-[#C6A24D]/20 dark:border-r-[#C6A24D]/20 bg-gray-50 dark:bg-[#C6A24D]/10',
                                            str_contains($tipo, 'aliment') || str_contains($tipo, 'restauran') => 'border-l-[6px] border-l-[#855A37] border-y border-r border-gray-100 dark:border-y-[#855A37]/20 dark:border-r-[#855A37]/20 bg-gray-50 dark:bg-[#855A37]/10',
                                            str_contains($tipo, 'equipo') || str_contains($tipo, 'alquiler') => 'border-l-[6px] border-l-[#4A90E2] border-y border-r border-gray-100 dark:border-y-[#4A90E2]/20 dark:border-r-[#4A90E2]/20 bg-gray-50 dark:bg-[#4A90E2]/10',
                                            str_contains($tipo, 'paquete') => 'border-l-[6px] border-l-[#32744C] border-y border-r border-gray-100 dark:border-y-[#32744C]/25 dark:border-r-[#32744C]/25 bg-gray-50 dark:bg-[#32744C]/20',
                                            default => 'border-l-[6px] border-l-slate-400 border-y border-r border-gray-100 dark:border-y-white/10 dark:border-r-white/10 bg-gray-50 dark:bg-white/5',
                                        };

                                        $hora = $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--';
                                        
                                        $estadoReserva = $item->reserva->estado ?? 'Pendiente';
                                        $badgeEstado = match($estadoReserva) {
                                            'Confirmada' => '<span class="text-[8px] bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-green-200 dark:border-green-400/20">Conf.</span>',
                                            'Completada' => '<span class="text-[8px] bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-blue-200 dark:border-blue-400/20">Comp.</span>',
                                            'Pago en revisión' => '<span class="text-[8px] bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-indigo-200 dark:border-indigo-400/20">Rev.</span>',
                                            'Reagendada' => '<span class="text-[8px] bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-amber-200 dark:border-amber-400/20">Reag.</span>',
                                            'Cancelada', 'Rechazada' => '<span class="text-[8px] bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-red-200 dark:border-red-400/20">Canc.</span>',
                                            default => '<span class="text-[8px] bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-yellow-200 dark:border-yellow-400/20">Pend.</span>',
                                        };
                                    @endphp

                                    <div class="flex gap-3 items-center">
                                        <div class="w-12 shrink-0 text-right">
                                            <p class="text-[11px] font-black text-[#06281E] dark:text-emerald-100/75 opacity-80">{{ $hora }}</p>
                                        </div>
                                        
                                        <div wire:click="mostrarDetalle({{ $item->reserva->id }})" class="flex-1 p-3 rounded-xl shadow-sm flex flex-col hover:scale-[1.02] transition cursor-pointer {{ $estilo }}">
                                            <div class="flex items-start justify-between mb-0.5">
                                                <h4 class="text-sm font-bold text-[#3B4D36] dark:text-emerald-50 pr-2">{{ $item->servicio->nombre }}</h4>
                                                <div class="shrink-0">{!! $badgeEstado !!}</div>
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <p class="text-[9px] text-slate-500 dark:text-emerald-100/60 uppercase tracking-wider font-bold">{{ $item->servicio->tipoServicio->nombre }}</p>
                                                <span class="text-[9px] bg-black/5 dark:bg-white/10 px-1.5 py-0.5 rounded font-black text-slate-600 dark:text-emerald-100/70">x{{ $item->cantidad }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs font-bold text-gray-300 dark:text-emerald-100/40 pl-16 pt-2 italic">Sin agendamientos</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- VISTA DESKTOP: Grid Corporativo --}}
            <div class="hidden lg:flex flex-col flex-1 overflow-hidden bg-white dark:bg-[#050b09]">
                <div class="grid grid-cols-7 border-b border-slate-200 dark:border-emerald-500/10 shrink-0 bg-white dark:bg-[#08110e] shadow-sm dark:shadow-black/30 z-10">
                    @if(isset($this->diasMostrar))
                        @foreach($this->diasMostrar as $dia)
                            @php $esHoy = $dia->isToday(); @endphp
                            <div class="text-center py-3 border-r border-slate-200/60 dark:border-emerald-500/10 last:border-r-0 relative {{ $esHoy ? 'bg-slate-50 dark:bg-emerald-500/10' : '' }}">
                                @if($esHoy)
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-emerald-500"></div>
                                @endif
                                <span class="block text-[10px] font-bold uppercase tracking-widest {{ $esHoy ? 'text-emerald-600 dark:text-emerald-300' : 'text-slate-500 dark:text-emerald-100/50' }}">
                                    {{ $esHoy ? 'Hoy' : $dia->translatedFormat('l') }}
                                </span>
                                <span class="text-xl md:text-2xl font-black {{ $esHoy ? 'text-emerald-700 dark:text-emerald-300' : 'text-[#06281E] dark:text-white' }}">
                                    {{ $dia->format('d') }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="flex-1 overflow-y-auto relative bg-white dark:bg-[#050b09]">
                    <div class="absolute inset-0 pointer-events-none dark:hidden" style="background-image: repeating-linear-gradient(transparent, transparent 59px, #e2e8f0 60px); opacity: 0.4;"></div>
                    <div class="absolute inset-0 pointer-events-none hidden dark:block" style="background-image: repeating-linear-gradient(transparent, transparent 59px, rgba(16,185,129,0.12) 60px); opacity: 0.8;"></div>
                    
                    <div class="grid grid-cols-7 h-full min-h-[600px] divide-x divide-slate-200/60 dark:divide-emerald-500/10 relative z-10">
                        @if(isset($this->diasMostrar))
                            @foreach($this->diasMostrar as $dia)
                                @php 
                                    $fechaStr = $dia->format('Y-m-d');
                                    $serviciosDelDia = $this->agendaPorDia[$fechaStr] ?? [];
                                    $esHoy = $dia->isToday();
                                @endphp
                                
                                <div class="flex flex-col gap-2 p-2 {{ $esHoy ? 'bg-slate-50/50 dark:bg-emerald-500/5' : '' }}">
                                    @foreach($serviciosDelDia as $item)
                                        @php
                                            $tipo = \Illuminate\Support\Str::slug($item->servicio->tipoServicio->nombre ?? '');
                                            
                                            $estilo = match(true) {
                                                str_contains($tipo, 'hospedaj') || str_contains($tipo, 'alojamient') => ['bg' => 'bg-[#8DBEA2]/40 dark:bg-[#8DBEA2]/10', 'border' => 'border-l-[12px] border-l-[#8DBEA2] border-y border-r border-[#8DBEA2]/50 dark:border-y-[#8DBEA2]/20 dark:border-r-[#8DBEA2]/20', 'text' => 'text-[#3B4D36] dark:text-emerald-50'],
                                                str_contains($tipo, 'guianz') || str_contains($tipo, 'tour') => ['bg' => 'bg-[#C6A24D]/30 dark:bg-[#C6A24D]/10', 'border' => 'border-l-[12px] border-l-[#C6A24D] border-y border-r border-[#C6A24D]/50 dark:border-y-[#C6A24D]/20 dark:border-r-[#C6A24D]/20', 'text' => 'text-[#855A37] dark:text-amber-100'],
                                                str_contains($tipo, 'aliment') || str_contains($tipo, 'restauran') => ['bg' => 'bg-[#855A37]/20 dark:bg-[#855A37]/20', 'border' => 'border-l-[12px] border-l-[#855A37] border-y border-r border-[#855A37]/40 dark:border-y-[#855A37]/25 dark:border-r-[#855A37]/25', 'text' => 'text-[#855A37] dark:text-orange-100'],
                                                str_contains($tipo, 'equipo') || str_contains($tipo, 'alquiler') => ['bg' => 'bg-[#4A90E2]/20 dark:bg-[#4A90E2]/10', 'border' => 'border-l-[12px] border-l-[#4A90E2] border-y border-r border-[#4A90E2]/40 dark:border-y-[#4A90E2]/20 dark:border-r-[#4A90E2]/20', 'text' => 'text-[#2C5282] dark:text-blue-100'],
                                                str_contains($tipo, 'paquete') => ['bg' => 'bg-[#32744C]/20 dark:bg-[#32744C]/20', 'border' => 'border-l-[12px] border-l-[#32744C] border-y border-r border-[#32744C]/40 dark:border-y-[#32744C]/25 dark:border-r-[#32744C]/25', 'text' => 'text-[#32744C] dark:text-green-100'],
                                                default => ['bg' => 'bg-slate-100 dark:bg-white/5', 'border' => 'border-l-[12px] border-l-slate-400 border-y border-r border-slate-200 dark:border-y-white/10 dark:border-r-white/10', 'text' => 'text-slate-700 dark:text-slate-100'],
                                            };

                                            $hora = $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--';
                                            
                                            $estadoReserva = $item->reserva->estado ?? 'Pendiente';
                                            $badgeEstado = match($estadoReserva) {
                                                'Confirmada' => '<span class="text-[8px] bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-green-200 dark:border-green-400/20 shadow-sm">Conf.</span>',
                                                'Completada' => '<span class="text-[8px] bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-blue-200 dark:border-blue-400/20 shadow-sm">Comp.</span>',
                                                'Pago en revisión' => '<span class="text-[8px] bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-indigo-200 dark:border-indigo-400/20 shadow-sm">Rev.</span>',
                                                'Reagendada' => '<span class="text-[8px] bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-amber-200 dark:border-amber-400/20 shadow-sm">Reag.</span>',
                                                'Cancelada', 'Rechazada' => '<span class="text-[8px] bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-red-200 dark:border-red-400/20 shadow-sm">Canc.</span>',
                                                default => '<span class="text-[8px] bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300 px-1.5 py-0.5 rounded font-black tracking-wider uppercase border border-yellow-200 dark:border-yellow-400/20 shadow-sm">Pend.</span>',
                                            };
                                        @endphp

                                        <div wire:click="mostrarDetalle({{ $item->reserva->id }})" class="p-2 rounded-lg shadow-sm transition flex flex-col gap-1 hover:shadow-md cursor-pointer {{ $estilo['bg'] }} {{ $estilo['border'] }}">
                                            <div class="flex items-center justify-between mb-0.5 {{ $estilo['text'] }}">
                                                <div class="flex items-center gap-1">
                                                    <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    <span class="text-[10px] font-black">{{ $hora }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    {!! $badgeEstado !!}
                                                </div>
                                            </div>
                                            <p class="text-xs font-bold leading-tight {{ $estilo['text'] }} line-clamp-3">{{ $item->servicio->nombre }}</p>
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
