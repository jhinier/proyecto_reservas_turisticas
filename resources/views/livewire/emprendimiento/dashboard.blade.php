<div class="min-h-screen relative pb-24 text-[#06281E] dark:text-gray-200 font-sans antialiased" wire:key="dashboard-root">
    
    @php
        $textoPeriodo = match($periodoFiltro) {
            'esta_semana' => 'esta semana',
            'este_mes' => 'este mes',
            default => 'hoy'
        };
        $totalMetricas = array_sum($this->metricas);
    @endphp

    {{-- Cabecera --}}
    <div class="bg-white dark:bg-zinc-900/95 dark:backdrop-blur-md border-b border-gray-200 dark:border-white/10 px-8 py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 transition-colors">
        <div>
            <div class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest flex items-center gap-2">
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
                <span class="text-gray-300 dark:text-gray-600">&bull;</span>
                <span class="text-[#00A344] dark:text-[#77f062] font-black">Panel operativo</span>
            </div>
            <h1 class="text-2xl font-black text-[#06281E] dark:text-white uppercase tracking-wide mt-1">Resumen de actividad</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex flex-wrap items-center gap-x-4 gap-y-2 font-medium">
                <span>Bienvenido, <span class="text-[#06281E] dark:text-white font-bold">{{ Auth::user()->name }}</span> <span class="text-gray-400 font-normal mx-1">de</span> <span class="text-[#00A344] font-bold">{{ Auth::user()->emprendimiento->nombre ?? 'Tu Emprendimiento' }}</span></span>
                <span class="text-gray-300 dark:text-gray-600 hidden sm:inline">|</span>
                <span class="flex items-center gap-1.5 bg-gray-100 dark:bg-zinc-800 px-3 py-1 rounded-full text-[10px] text-[#00A344] dark:text-[#7ed957] font-bold uppercase tracking-widest border border-gray-200 dark:border-white/5">
                    <span class="size-2 rounded-full bg-[#00D65B] dark:bg-[#7ed957] animate-pulse"></span>
                    {{ $totalMetricas }} reservas registradas {{ $textoPeriodo }}
                </span>
            </p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
            <div class="flex items-center bg-gray-50 dark:bg-zinc-800/50 p-1 rounded-xl border border-gray-200 dark:border-white/10 w-full md:w-auto transition-colors">
                <span class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest font-bold px-3 hidden lg:inline">Periodo:</span>
                <select wire:model.live="periodoFiltro" class="bg-white dark:bg-zinc-800 border border-gray-200 dark:border-white/10 rounded-lg py-1.5 px-4 text-xs font-bold text-[#06281E] dark:text-white shadow-sm focus:ring-2 focus:ring-[#00A344] dark:focus:ring-[#07b25f] focus:border-[#00A344] dark:focus:border-[#07b25f] cursor-pointer outline-none transition-all w-full md:w-auto">
                    <option value="hoy">Hoy</option>
                    <option value="esta_semana">Esta semana</option>
                    <option value="este_mes">Este mes</option>
                </select>
            </div>
        </div>
    </div>

    <div class="p-8 max-w-7xl mx-auto space-y-8 relative">
        
        {{-- Cargando --}}
        <div wire:loading.flex wire:target="periodoFiltro" class="absolute inset-0 bg-white/70 dark:bg-zinc-900/70 z-30 items-center justify-center backdrop-blur-xs transition-all rounded-3xl">
            <div class="animate-spin size-7 border-3 border-gray-300 dark:border-gray-600 border-t-[#00A344] dark:border-t-[#07b25f] rounded-full"></div>
        </div>

        {{-- Tarjetas superiores con colores --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-green-50/40 dark:bg-green-900/10 rounded-3xl p-6 border border-green-200 dark:border-green-500/20 shadow-sm flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-green-600 dark:text-green-500 uppercase tracking-widest">Confirmadas</p>
                        <h3 class="text-3xl font-black text-green-900 dark:text-white mt-1">{{ $this->metricas['confirmadas'] ?? 0 }}</h3>
                    </div>
                    <div class="size-10 rounded-2xl bg-white dark:bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center shadow-sm border border-green-100 dark:border-green-500/20">
                        <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-green-100 dark:border-green-800/30 flex items-center gap-2 text-[10px] text-green-700 dark:text-green-400 font-bold uppercase tracking-wider">
                    <span class="text-white bg-green-500 px-2 py-0.5 rounded shadow-sm">Listas</span>
                    <span>Operación agendada</span>
                </div>
            </div>

            <div class="bg-yellow-50/50 dark:bg-yellow-900/10 rounded-3xl p-6 border border-yellow-200 dark:border-yellow-500/20 shadow-sm flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-yellow-600 dark:text-yellow-500 uppercase tracking-widest">Pendientes</p>
                        <h3 class="text-3xl font-black text-yellow-900 dark:text-white mt-1">{{ $this->metricas['pendientes'] ?? 0 }}</h3>
                    </div>
                    <div class="size-10 rounded-2xl bg-white dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-500 flex items-center justify-center shadow-sm border border-yellow-100 dark:border-yellow-500/20">
                        <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-yellow-100 dark:border-yellow-800/30 flex items-center gap-2 text-[10px] text-yellow-700 dark:text-yellow-400 font-bold uppercase tracking-wider">
                    <span class="text-white bg-yellow-500 px-2 py-0.5 rounded shadow-sm">Espera</span>
                    <span>Por confirmar</span>
                </div>
            </div>

            <div class="bg-red-50/50 dark:bg-red-900/10 rounded-3xl p-6 border border-red-200 dark:border-red-500/20 shadow-sm flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-red-600 dark:text-red-500 uppercase tracking-widest">Canceladas</p>
                        <h3 class="text-3xl font-black text-red-900 dark:text-white mt-1">{{ $this->metricas['canceladas'] ?? 0 }}</h3>
                    </div>
                    <div class="size-10 rounded-2xl bg-white dark:bg-red-500/10 text-red-600 dark:text-red-500 flex items-center justify-center shadow-sm border border-red-100 dark:border-red-500/20">
                        <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-red-100 dark:border-red-800/30 flex items-center gap-2 text-[10px] text-red-700 dark:text-red-400 font-bold uppercase tracking-wider">
                    <span class="text-white bg-red-500 px-2 py-0.5 rounded shadow-sm">Anuladas</span>
                    <span>Descartadas</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Agenda del día (Tabla) --}}
                <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-white/10 shadow-sm overflow-hidden transition-colors">
                    <div class="border-b border-gray-100 dark:border-white/5 px-6 py-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-50 dark:bg-zinc-800 p-2.5 rounded-xl border border-gray-200 dark:border-white/10 text-[#00A344] dark:text-[#7ed957] shadow-sm">
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-black text-[#06281E] dark:text-white uppercase tracking-wide">Agenda del día</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Servicios programados ordenados cronológicamente</p>
                            </div>
                        </div>
                        
                        <button type="button" wire:click="$dispatch('abrirCalendario')" class="bg-[#00D65B] hover:bg-[#00A344] text-[#06281E] dark:text-zinc-900 font-black px-6 py-2.5 rounded-full text-[10px] sm:text-xs uppercase tracking-widest shadow-sm transition-colors outline-none shrink-0 self-start sm:self-auto">
                            Ver calendario
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-[#06281E] dark:text-gray-200">
                            <thead class="bg-gray-50 dark:bg-zinc-900/50 border-b border-gray-200 dark:border-white/5 text-[10px] uppercase tracking-widest text-gray-400 dark:text-gray-500 font-bold">
                                <tr>
                                    <th class="p-5">Servicio contratado</th>
                                    <th class="p-5">Cliente / Turista</th>
                                    <th class="p-5 text-center">Arribo</th>
                                    <th class="p-5 text-right">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                                @forelse($this->agendaHoy as $detalle)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group" wire:key="agenda-item-{{ $detalle->id }}">
                                        <td class="p-5">
                                            <div class="font-bold text-[#00A344] dark:text-[#7ed957] text-sm group-hover:text-[#06281E] dark:group-hover:text-white transition-colors">{{ $detalle->servicio->nombre ?? 'Servicio no definido' }}</div>
                                            <div class="text-[10px] text-gray-500 dark:text-gray-400 font-black tracking-widest uppercase mt-1 bg-gray-100 dark:bg-zinc-800 w-fit px-2 py-0.5 rounded shadow-sm">{{ $detalle->servicio->tipoServicio->nombre ?? 'General' }}</div>
                                        </td>
                                        <td class="p-5">
                                            <div class="flex items-center gap-3">
                                                <div class="size-9 rounded-full bg-gray-100 dark:bg-zinc-800 border border-gray-200 dark:border-white/10 text-[#00A344] dark:text-[#7ed957] flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                                    {{ substr($detalle->reserva->turista->name ?? 'T', 0, 1) }}
                                                </div>
                                                <span class="text-[#06281E] dark:text-gray-200 text-sm font-bold truncate max-w-[150px] sm:max-w-[200px]">
                                                    {{ trim(($detalle->reserva->turista->name ?? '') . ' ' . ($detalle->reserva->turista->apellidos ?? '')) ?: 'Sin identificar' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="p-5 text-center">
                                            <span class="font-mono text-xs font-black text-[#06281E] dark:text-gray-200 bg-gray-100 dark:bg-zinc-800 px-2.5 py-1 rounded shadow-sm border border-gray-200 dark:border-white/5">
                                                {{ $detalle->hora_llegada ? \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') : '--:--' }}
                                            </span>
                                        </td>
                                        <td class="p-5 text-right">
                                            @php
                                                $statusColor = match($detalle->reserva->estado ?? '') {
                                                    'Confirmada' => 'text-green-800 bg-green-100 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20',
                                                    'Pendiente' => 'text-yellow-800 bg-yellow-100 dark:bg-yellow-500/10 dark:text-yellow-400 dark:border-yellow-500/20',
                                                    'Cancelada' => 'text-red-800 bg-red-100 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20',
                                                    default => 'text-gray-800 bg-gray-100 dark:bg-zinc-800 dark:text-gray-300 dark:border-white/10'
                                                };
                                            @endphp
                                            <span class="text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-wider shadow-sm {{ $statusColor }}">
                                                {{ $detalle->reserva->estado ?? 'Indefinido' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-10 text-center text-gray-400 dark:text-gray-500 text-sm font-bold">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-12 h-12 mb-3 text-gray-200 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                No tienes reservas operativas agendadas para la vista de hoy.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Curva de rendimiento y top servicio --}}
                <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden transition-colors">
                    <div class="border-b border-gray-100 dark:border-white/5 px-6 py-5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-50 dark:bg-zinc-800 p-2.5 rounded-xl border border-gray-200 dark:border-white/10 text-[#00A344] dark:text-[#7ed957] shadow-sm">
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v16.5M21 19.5H3.75M6.75 12l3-3m0 0l3 3m-3-3v8m4.5-3l3 3m0 0l3-3m-3 3V11"/></svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-black text-[#06281E] dark:text-white uppercase tracking-wide">Rendimiento y Ventas</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Volumen del periodo y servicio estrella</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 h-64 relative w-full flex items-end">
                        <svg viewBox="0 0 400 120" class="w-full h-full text-gray-50 dark:text-zinc-800" preserveAspectRatio="none">
                            <path d="M0 110 L 50 70 L 100 85 L 150 45 L 200 65 L 250 25 L 300 45 L 350 15 L 400 35 L 400 120 L 0 120 Z" fill="currentColor"></path>
                            <path d="M0 110 L 50 70 L 100 85 L 150 45 L 200 65 L 250 25 L 300 45 L 350 15 L 400 35" fill="none" class="stroke-[#00A344] dark:stroke-[#07b25f]" stroke-width="2.5" stroke-linecap="round"></path>
                            <circle cx="50" cy="70" r="3.5" class="fill-white dark:fill-zinc-900 stroke-[#00A344] dark:stroke-[#07b25f]" stroke-width="2.5"></circle>
                            <circle cx="150" cy="45" r="3.5" class="fill-white dark:fill-zinc-900 stroke-[#00A344] dark:stroke-[#07b25f]" stroke-width="2.5"></circle>
                            <circle cx="250" cy="25" r="3.5" class="fill-white dark:fill-zinc-900 stroke-[#00A344] dark:stroke-[#07b25f]" stroke-width="2.5"></circle>
                            <circle cx="350" cy="15" r="3.5" class="fill-white dark:fill-zinc-900 stroke-[#00A344] dark:stroke-[#07b25f]" stroke-width="2.5"></circle>
                        </svg>
                        
                        {{-- Recuadros del gráfico (Top Servicio) --}}
                        <div class="absolute top-6 right-6 flex flex-col gap-3">
                            <div class="bg-white dark:bg-zinc-800 border border-gray-100 dark:border-white/10 p-3 rounded-2xl shadow-sm text-right">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Total en el periodo</div>
                                <div class="text-xl font-black text-[#06281E] dark:text-white mt-1">{{ array_sum($this->metricas) }} rsv.</div>
                            </div>
                            
                            @if($this->servicioTop)
                            <div class="bg-[#06281E] dark:bg-zinc-800 border border-[#06281E] dark:border-white/10 p-4 rounded-2xl shadow-md text-right max-w-[220px]">
                                <div class="text-[10px] font-bold uppercase tracking-widest text-[#00D65B] flex items-center justify-end gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    Servicio Top
                                </div>
                                <div class="text-sm font-bold text-white mt-1.5 truncate" title="{{ $this->servicioTop->servicio->nombre }}">{{ $this->servicioTop->servicio->nombre }}</div>
                                <div class="text-[10px] text-gray-300 mt-1 uppercase">{{ $this->servicioTop->total_ventas }} ventas gestionadas</div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                {{-- Big card completadas --}}
                <div class="bg-[#06281E] dark:bg-[#163016] rounded-3xl shadow-sm text-white p-6 relative overflow-hidden flex flex-col justify-center h-32 border border-[#06281E] dark:border-white/10 transition-colors">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <div class="text-5xl font-black tracking-tight text-[#00D65B] dark:text-[#77f062]">{{ $this->metricas['completadas'] ?? 0 }}</div>
                            <div class="text-[10px] font-bold uppercase tracking-widest text-gray-300 dark:text-[#7ed957] mt-1">Servicios completados</div>
                        </div>
                        <div class="size-12 rounded-2xl bg-white/10 dark:bg-[#07b25f]/20 flex items-center justify-center text-[#00D65B]">
                            <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Catálogo de servicios --}}
                <div class="bg-white dark:bg-zinc-900 rounded-3xl shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden transition-colors">
                    <div class="border-b border-gray-100 dark:border-white/5 px-6 py-5 flex flex-col gap-1">
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-50 dark:bg-zinc-800 p-2.5 rounded-xl border border-gray-200 dark:border-white/10 text-[#00A344] dark:text-[#7ed957] shadow-sm">
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2-2.25V6zM13.5 15.75a2.25 2.25 0 012-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                            </div>
                            <h2 class="text-lg font-black text-[#06281E] dark:text-white uppercase tracking-wide">Catálogo de Servicios</h2>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium ml-12">Total de servicios activos publicados por categoría</p>
                    </div>
                    
                    <div class="p-6 space-y-5 max-h-[400px] overflow-y-auto scrollbar-none">
                        @forelse($this->categorias as $categoria)
                            @php
                                $maxServicios = 20; 
                                $porcentaje = min(100, (($categoria->servicios_count ?? 0) / $maxServicios) * 100);
                            @endphp
                            <div class="space-y-2 group" wire:key="cat-widget-{{ $categoria->id }}">
                                <div class="flex justify-between items-center text-xs font-bold">
                                    <span class="text-[#06281E] dark:text-gray-200 group-hover:text-[#00A344] transition-colors uppercase tracking-wide">{{ $categoria->nombre ?? 'Línea de servicio' }}</span>
                                    <span class="text-gray-500 dark:text-gray-400 font-mono text-[10px] bg-gray-50 dark:bg-zinc-800 px-2 py-0.5 rounded shadow-sm border border-gray-200 dark:border-white/5">{{ $categoria->servicios_count ?? 0 }} act.</span>
                                </div>
                                <div class="w-full h-2 bg-gray-100 dark:bg-zinc-800 rounded-full overflow-hidden border border-gray-200/50 dark:border-white/5">
                                    <div class="h-full bg-[#00D65B] dark:bg-[#07b25f] rounded-full transition-all duration-500" data-width="{{ $porcentaje }}"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold text-center py-6">No se registran líneas</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recomendación --}}
                <div class="bg-yellow-50 dark:bg-zinc-900 rounded-3xl shadow-sm border border-yellow-200 dark:border-white/10 p-6 flex items-start gap-4 transition-colors">
                    <div class="bg-white dark:bg-zinc-800 p-3 rounded-2xl text-yellow-500 shrink-0 shadow-sm border border-yellow-100 dark:border-white/10">
                        <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M12 2a10 10 0 110 20 10 10 0 010-20zm0 5v6"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black uppercase text-yellow-800 dark:text-yellow-400 tracking-widest">Aviso operativo</h4>
                        <p class="text-xs text-yellow-700 dark:text-gray-400 font-bold mt-2 leading-relaxed">
                            Controla los servicios <span class="text-yellow-800 dark:text-yellow-300 font-black">reagendados</span> para asegurar una correcta asignación.
                        </p>
                    </div>
                </div>

            </div>
        </div>
        
        <livewire:emprendimiento.reserva.calendario-lateral />
        
        <script>
            (function(){
                document.querySelectorAll('[data-width]').forEach(function(el){
                    var v = el.getAttribute('data-width');
                    if (v !== null) {
                        el.style.width = v + '%';
                    }
                });
            })();
        </script>
        
    </div>
</div>