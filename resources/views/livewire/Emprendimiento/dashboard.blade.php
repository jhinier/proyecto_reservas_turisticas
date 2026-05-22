<div class="min-h-screen bg-[#FAF9F5] relative pb-24 text-[#2C3D30] font-sans antialiased" wire:key="dashboard-root">
    
    <div class="bg-white border-b border-[#C2D5C0]/40 px-8 py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="text-xs font-bold text-[#6B806D] uppercase tracking-widest flex items-center gap-2">
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
                <span class="text-[#C2D5C0]">&bull;</span>
                <span class="text-[#254A0C] font-black">Panel operativo</span>
            </div>
            <h1 class="text-3xl font-semibold text-[#2C3D30] tracking-tight mt-1">Resumen de actividad</h1>
            <p class="text-sm text-[#6B806D] mt-2 flex flex-wrap items-center gap-x-4 gap-y-1">
                <span>Bienvenido, <span class="text-[#2C3D30] font-bold">{{ Auth::user()->name }}</span></span>
                <span class="text-[#C2D5C0] hidden sm:inline">|</span>
                <span class="flex items-center gap-1.5 bg-[#F4F6F0] px-2.5 py-0.5 rounded-full text-xs text-[#254A0C] font-semibold">
                    <span class="size-1.5 rounded-full bg-[#254A0C] animate-pulse"></span>
                    {{ count($this->agendaHoy) }} servicios para hoy
                </span>
            </p>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
            <div class="flex items-center bg-[#F4F6F0] p-1 rounded-xl border border-[#C2D5C0]/40 w-full md:w-auto">
                <span class="text-xs text-[#6B806D] font-bold px-3 hidden lg:inline">Periodo:</span>
                <select wire:model.live="periodoFiltro" class="bg-white border border-[#C2D5C0]/50 rounded-lg py-1.5 px-4 text-xs font-bold text-[#2C3D30] shadow-sm focus:ring-2 focus:ring-[#254A0C] focus:border-[#254A0C] cursor-pointer outline-none transition-all w-full md:w-auto">
                    <option value="hoy">Hoy</option>
                    <option value="esta_semana">Esta semana</option>
                    <option value="este_mes">Este mes</option>
                </select>
            </div>
        </div>
    </div>

    <div class="p-8 max-w-7xl mx-auto space-y-8 relative">
        
        <div wire:loading.flex wire:target="periodoFiltro" class="absolute inset-0 bg-[#FAF9F5]/70 z-30 items-center justify-center backdrop-blur-xs transition-all">
            <div class="animate-spin size-7 border-3 border-[#C2D5C0] border-t-[#254A0C] rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="bg-[#254A0C] rounded-2xl p-6 border border-[#254A0C] shadow-xs flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-[#A3A53F] uppercase tracking-wider">Confirmadas</p>
                        <h3 class="text-3xl font-semibold text-white tracking-tight mt-1">{{ $this->metricas['confirmadas'] ?? 0 }}</h3>
                    </div>
                    <div class="size-9 rounded-xl bg-white/20 text-white flex items-center justify-center shadow-xs">
                        <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-2 text-[11px] text-[#A3A53F]">
                    <span class="text-[#254A0C] font-bold bg-white px-1.5 py-0.5 rounded">Listas</span>
                    <span class="text-white/80">Operación agendada</span>
                </div>
            </div>

            <div class="bg-[#567119] rounded-2xl p-6 border border-[#567119] shadow-xs flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-[#FAF9F5]/70 uppercase tracking-wider">Pendientes</p>
                        <h3 class="text-3xl font-semibold text-white tracking-tight mt-1">{{ $this->metricas['pendientes'] ?? 0 }}</h3>
                    </div>
                    <div class="size-9 rounded-xl bg-white/20 text-white flex items-center justify-center shadow-xs">
                        <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-2 text-[11px] text-[#FAF9F5]/80">
                    <span class="text-[#567119] font-bold bg-white px-1.5 py-0.5 rounded">Espera</span>
                    <span class="text-white/80">Por confirmar cupos</span>
                </div>
            </div>

            <div class="bg-[#CCC13A] rounded-2xl p-6 border border-[#CCC13A] shadow-xs flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-[#3E3407] uppercase tracking-wider">Reagendadas</p>
                        <h3 class="text-3xl font-semibold text-[#3E3407] tracking-tight mt-1">{{ $this->metricas['reagendadas'] ?? 0 }}</h3>
                    </div>
                    <div class="size-9 rounded-xl bg-[#3E3407]/10 text-[#3E3407] flex items-center justify-center shadow-xs">
                        <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-[#3E3407]/10 flex items-center gap-2 text-[11px] text-[#3E3407]">
                    <span class="text-white font-bold bg-[#3E3407] px-1.5 py-0.5 rounded">Cambios</span>
                    <span>Modificaciones de fecha</span>
                </div>
            </div>

            <div class="bg-[#3E3407] rounded-2xl p-6 border border-[#3E3407] shadow-xs flex flex-col justify-between group transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-[#CCC13A] uppercase tracking-wider">Canceladas</p>
                        <h3 class="text-3xl font-semibold text-white tracking-tight mt-1">{{ $this->metricas['canceladas'] ?? 0 }}</h3>
                    </div>
                    <div class="size-9 rounded-xl bg-white/20 text-white flex items-center justify-center shadow-xs">
                        <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-2 text-[11px] text-[#CCC13A]">
                    <span class="text-[#3E3407] font-bold bg-white px-1.5 py-0.5 rounded">Anuladas</span>
                    <span class="text-white/80">Servicios descartados</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white rounded-2xl border border-[#254A0C] shadow-xs overflow-hidden">
                    <div class="bg-[#254A0C]/20 border-b border-[#254A0C]/30 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-2 rounded-lg border border-[#C2D5C0]/40 text-[#254A0C] shadow-xs">
                                <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-[#2C3D30] tracking-tight">Agenda del día</h2>
                                <p class="text-xs text-[#6B806D] font-medium">Servicios programados ordenados cronológicamente</p>
                            </div>
                        </div>
                        
                        <button type="button" wire:click="$dispatch('abrirCalendario')" class="text-xs font-bold bg-white border border-[#C2D5C0] hover:border-[#254A0C] text-[#2C3D30] hover:text-[#254A0C] px-4 py-2 rounded-xl transition-all shadow-xs shrink-0 self-start sm:self-auto">
                            Ver calendario analítico
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-[#2C3D30]">
                            <thead class="bg-[#FAF9F5] border-b border-[#C2D5C0]/30 text-[10px] uppercase tracking-wider text-[#6B806D] font-bold">
                                <tr>
                                    <th class="px-6 py-3.5 font-bold">Servicio contratado</th>
                                    <th class="px-6 py-3.5 font-bold">Cliente / Turista</th>
                                    <th class="px-6 py-3.5 font-bold text-center">Hora de arribo</th>
                                    <th class="px-6 py-3.5 font-bold text-right">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#C2D5C0]/20 font-medium">
                                @forelse($this->agendaHoy as $detalle)
                                    <tr class="hover:bg-[#E5ECD7]/30 transition-colors group" wire:key="agenda-item-{{ $detalle->id }}">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-[#2C3D30] text-sm group-hover:text-[#254A0C] transition-colors">{{ $detalle->servicio->nombre ?? 'Servicio no definido' }}</div>
                                            <div class="text-[10px] text-[#6B806D] font-semibold tracking-wider uppercase mt-0.5 bg-[#F4F6F0] w-fit px-1.5 py-0.2 rounded">{{ $detalle->servicio->tipoServicio->nombre ?? 'General' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="size-8 rounded-full bg-[#E5ECD7] border border-[#C2D5C0]/40 text-[#254A0C] flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                                                    {{ substr($detalle->reserva->turista->name ?? 'T', 0, 1) }}
                                                </div>
                                                <span class="text-[#2C3D30] text-sm font-semibold truncate max-w-[150px] sm:max-w-[200px]">
                                                    {{ trim(($detalle->reserva->turista->name ?? '') . ' ' . ($detalle->reserva->turista->apellidos ?? '')) ?: 'Sin identificar' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-mono text-xs font-bold text-[#2C3D30] bg-[#F4F6F0] px-2 py-1 rounded border border-[#C2D5C0]/30">
                                                {{ $detalle->hora_llegada ? \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') : '--:--' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @php
                                                $statusColor = match($detalle->reserva->estado ?? '') {
                                                    'Confirmada' => 'text-green-700 bg-green-50 border-green-100',
                                                    'Pendiente' => 'text-amber-700 bg-amber-50 border-amber-100',
                                                    'Cancelada' => 'text-rose-700 bg-rose-50 border-rose-100',
                                                    default => 'text-[#2C3D30] bg-[#F4F6F0] border-[#C2D5C0]/40'
                                                };
                                            @endphp
                                            <span class="text-[10px] px-2.5 py-0.5 rounded-md font-bold uppercase tracking-wider border {{ $statusColor }}">
                                                {{ $detalle->reserva->estado ?? 'Indefinido' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center text-[#6B806D] text-sm">
                                            <div class="max-w-xs mx-auto space-y-2">
                                                <p class="font-bold text-[#2C3D30]">Sin registros pendientes</p>
                                                <p class="text-xs">No se registran reservas operativas para el intervalo seleccionado.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xs border border-[#254A0C] overflow-hidden">
                    <div class="bg-[#254A0C]/20 border-b border-[#254A0C]/30 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-2 rounded-lg border border-[#C2D5C0]/40 text-[#254A0C] shadow-xs">
                                <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v16.5M21 19.5H3.75M6.75 12l3-3m0 0l3 3m-3-3v8m4.5-3l3 3m0 0l3-3m-3 3V11"/></svg>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-[#2C3D30] tracking-tight">Curva de rendimiento</h2>
                                <p class="text-xs text-[#6B806D] font-medium">Análisis predictivo y volumen histórico de operaciones</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 h-64 relative w-full flex items-end">
                        <svg viewBox="0 0 400 120" class="w-full h-full text-[#F4F6F0]" preserveAspectRatio="none">
                            <path d="M0 110 L 50 70 L 100 85 L 150 45 L 200 65 L 250 25 L 300 45 L 350 15 L 400 35 L 400 120 L 0 120 Z" fill="currentColor"></path>
                            <path d="M0 110 L 50 70 L 100 85 L 150 45 L 200 65 L 250 25 L 300 45 L 350 15 L 400 35" fill="none" stroke="#254A0C" stroke-width="2" stroke-linecap="round"></path>
                            <circle cx="50" cy="70" r="3.5" fill="white" stroke="#254A0C" stroke-width="2.5"></circle>
                            <circle cx="150" cy="45" r="3.5" fill="white" stroke="#254A0C" stroke-width="2.5"></circle>
                            <circle cx="250" cy="25" r="3.5" fill="white" stroke="#254A0C" stroke-width="2.5"></circle>
                            <circle cx="350" cy="15" r="3.5" fill="white" stroke="#254A0C" stroke-width="2.5"></circle>
                        </svg>
                        <div class="absolute top-6 right-6 bg-white border border-[#C2D5C0]/60 p-4 rounded-xl shadow-xs text-center backdrop-blur-md">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-[#6B806D]">Flujo operativo total</div>
                            <div class="text-xl font-semibold text-[#2C3D30] mt-0.5">{{ ($this->metricas['confirmadas'] ?? 0) + ($this->metricas['completadas'] ?? 0) }} rsv.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-[#2C3D30] rounded-2xl shadow-sm text-white p-6 relative overflow-hidden flex flex-col justify-center h-32 border border-[#2C3D30]">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <div class="text-4xl font-semibold tracking-tight text-[#FAF9F5]">{{ $this->metricas['completadas'] ?? 0 }}</div>
                            <div class="text-xs font-bold uppercase tracking-wider text-[#C2D5C0] mt-1">Servicios completados con éxito</div>
                        </div>
                        <div class="size-10 rounded-xl bg-white/10 flex items-center justify-center text-[#FAF9F5]">
                            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xs border border-[#254A0C] overflow-hidden">
                    <div class="bg-[#254A0C]/20 border-b border-[#254A0C]/30 px-5 py-4 flex items-center gap-3">
                        <div class="bg-white p-2 rounded-lg border border-[#C2D5C0]/40 text-[#254A0C] shadow-xs">
                            <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2-2.25V6zM13.5 15.75a2.25 2.25 0 012-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                        </div>
                        <h2 class="text-base font-semibold text-[#2C3D30] tracking-tight">Densidad por línea</h2>
                    </div>
                    
                    <div class="p-5 space-y-4 max-h-[400px] overflow-y-auto scrollbar-none">
                        @forelse($this->categorias as $categoria)
                            @php
                                $maxServicios = 20; 
                                $porcentaje = min(100, (($categoria->servicios_count ?? 0) / $maxServicios) * 100);
                            @endphp
                            <div class="space-y-1.5 group" wire:key="cat-widget-{{ $categoria->id }}">
                                <div class="flex justify-between items-center text-xs font-semibold">
                                    <span class="text-[#2C3D30] group-hover:text-[#254A0C] transition-colors font-bold">{{ $categoria->nombre ?? 'Línea de servicio' }}</span>
                                    <span class="text-[#6B806D] font-mono text-[11px] bg-[#FAF9F5] px-1.5 py-0.2 rounded border border-[#C2D5C0]/20">{{ $categoria->servicios_count ?? 0 }} activos</span>
                                </div>
                                <div class="w-full h-1.5 bg-[#F4F6F0] rounded-full overflow-hidden border border-[#C2D5C0]/10">
                                    <div class="h-full bg-[#254A0C] rounded-full transition-all duration-500" data-width="{{ $porcentaje }}"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-[#6B806D] font-bold text-center py-6">No se registran líneas activas.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xs border border-[#C2D5C0] p-5 flex items-start gap-4">
                    <div class="bg-[#F4F6F0] p-2.5 rounded-xl text-[#D2A432] shrink-0 border border-[#C2D5C0]/40">
                        <svg class="size-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M12 2a10 10 0 110 20 10 10 0 010-20zm0 5v6"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase text-[#2C3D30] tracking-wider">Recomendación operativa</h4>
                        <p class="text-xs text-[#6B806D] font-medium mt-1.5 leading-relaxed">
                            Controla de forma continua los servicios con estatus <span class="text-[#D2A432] font-bold">reagendados</span> para asegurar una correcta asignación de guías locales.
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