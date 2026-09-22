<div class="p-6">
    <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-3">
        <div>
            <h2 class="text-xl font-black text-gray-900">Reportes</h2>
            <p class="text-[10px] font-medium text-gray-500 mt-0.5">Vista previa y exportación de datos operativos.</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-4">
        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Filtros</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-9 gap-3 items-end">
            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Desde</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <input type="date" wire:model.live="fechaDesde" class="w-full rounded-radius border border-outline bg-surface-alt px-3 py-1.5 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Hasta</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <input type="date" wire:model.live="fechaHasta" class="w-full rounded-radius border border-outline bg-surface-alt px-3 py-1.5 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                </div>
            </div>
            
            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Categoría</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-3 top-1/2 -translate-y-1/2 size-4 text-on-surface/50 dark:text-on-surface-dark/50">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    <select wire:model.live="categoria_id" class="w-full appearance-none rounded-radius border border-outline bg-surface-alt px-3 py-1.5 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Estado</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-3 top-1/2 -translate-y-1/2 size-4 text-on-surface/50 dark:text-on-surface-dark/50">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    <select wire:model.live="estado" class="w-full appearance-none rounded-radius border border-outline bg-surface-alt px-3 py-1.5 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                        <option value="">Todos</option>
                        <option value="Confirmada">Confirmada</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Completada">Completada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Cédula</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-2.5 top-1/2 size-4 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50"> 
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="search" wire:model.live="cedula" class="w-full rounded-radius border border-outline bg-surface-alt py-1.5 pl-8 pr-2 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" placeholder="Ej. 060..."/>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Nombre Servicio</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-2.5 top-1/2 size-4 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50"> 
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="search" wire:model.live="nombreServicio" class="w-full rounded-radius border border-outline bg-surface-alt py-1.5 pl-8 pr-2 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" placeholder="Buscar..."/>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-bold text-gray-600 block mb-1">Mostrar</label>
                <div class="relative flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-3 top-1/2 -translate-y-1/2 size-4 text-on-surface/50 dark:text-on-surface-dark/50">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    <select wire:model.live="tipoReporte" class="w-full appearance-none rounded-radius border border-outline bg-surface-alt px-3 py-1.5 text-xs focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                        <option value="todo">Todo</option>
                        <option value="servicios">Solo Servicios</option>
                        <option value="turistas">Solo Turistas</option>
                        <option value="inventario">Solo Inventario</option>
                    </select>
                </div>
            </div>

            <button wire:click="limpiarFiltros" type="button" class="bg-gray-200 text-black px-4 py-2 rounded-lg font-black text-[10px] uppercase flex items-center justify-center gap-1.5 hover:bg-gray-300 transition-all shadow-md border border-gray-300 h-[38px] active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                Limpiar
            </button>
            <a href="{{ route('reportes.descargar', ['desde' => $fechaDesde, 'hasta' => $fechaHasta, 'categoria' => $categoria_id, 'estado' => $estado, 'cedula' => $cedula, 'tipo_reporte' => $tipoReporte, 'nombre' => $nombreServicio]) }}" 
               target="_blank"
               class="bg-[#00D65B] text-[#06281E] px-4 py-2 rounded-lg font-black text-[10px] uppercase flex items-center justify-center gap-1.5 hover:bg-[#00c052] transition-all shadow-md border border-[#00c052] h-[38px] active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Descargar
            </a>
        </div>
    </div>

    @php
        $agrupadoPorServicio = $servicios->groupBy(function($item) { return $item->servicio->nombre ?? 'Otros'; });
        $nombresServicios = $agrupadoPorServicio->keys()->toArray();
        $cantidadesServicios = [];
        foreach($agrupadoPorServicio as $grupo) {
            $cantidadesServicios[] = $grupo->sum('cantidad');
        }
        $chartKey = uniqid(); 
    @endphp

    <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity duration-200 space-y-4">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <div class="lg:col-span-3 bg-[#E8F2EC] border border-[#8DBEA2]/50 rounded-xl p-4 shadow-sm min-h-[330px] flex flex-col justify-between">
                <div>
                    <div class="bg-[#00A344] text-white text-center py-1.5 rounded font-black tracking-widest uppercase text-[10px] mb-3 shadow-sm">
                        Resumen
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center border-b border-[#8DBEA2]/30 pb-1.5">
                            <span class="text-[10px] font-bold text-[#06281E]/70 uppercase">Total Reservas</span>
                            <span class="text-sm font-black text-[#06281E]">{{ $totales['total'] }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-[#8DBEA2]/30 pb-1.5">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-[#00A344]"></div>
                                <span class="text-[10px] font-bold text-[#06281E]/70 uppercase">Confirmadas</span>
                            </div>
                            <span class="text-sm font-black text-[#06281E]">{{ $totales['confirmadas'] }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-[#8DBEA2]/30 pb-1.5">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                <span class="text-[10px] font-bold text-[#06281E]/70 uppercase">Completadas</span>
                            </div>
                            <span class="text-sm font-black text-[#06281E]">{{ $totales['completadas'] }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-[#8DBEA2]/30 pb-1.5">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                <span class="text-[10px] font-bold text-[#06281E]/70 uppercase">Pendientes</span>
                            </div>
                            <span class="text-sm font-black text-[#06281E]">{{ $totales['pendientes'] }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-[#8DBEA2]/30 pb-1.5">
                            <div class="flex items-center gap-1.5">
                                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                <span class="text-[10px] font-bold text-[#06281E]/70 uppercase">Canceladas</span>
                            </div>
                            <span class="text-sm font-black text-[#06281E]">{{ $totales['canceladas'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-[#8DBEA2]/50">
                    <p class="text-[9px] font-bold text-[#06281E]/70 uppercase tracking-widest text-center">Ingreso Neto</p>
                    <h4 class="text-2xl font-black text-[#00A344] text-center mt-0.5">${{ number_format($totales['recaudado'], 2) }}</h4>
                </div>
            </div>

            <div class="lg:col-span-4 bg-white border border-gray-200 rounded-xl p-4 shadow-sm min-h-[330px] flex flex-col items-center">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center mb-2 w-full">Estado de Reservas</h3>
                @if($totales['total'] > 0)
                    <div class="relative w-[75%] h-[160px] mt-auto mb-auto mx-auto">
                        <canvas id="graficoEstados-{{ $chartKey }}"></canvas>
                    </div>
                @else
                    <div class="flex-grow flex items-center justify-center text-gray-400 text-xs font-medium w-full">No hay datos</div>
                @endif
            </div>

            <div class="lg:col-span-5 bg-white border border-gray-200 rounded-xl p-4 shadow-sm min-h-[330px] flex flex-col items-center">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 w-full text-center">Servicios Solicitados</h3>
                @if($totales['total'] > 0)
                    <div class="relative w-[85%] h-[160px] mt-auto mb-auto mx-auto">
                        <canvas id="graficoServicios-{{ $chartKey }}"></canvas>
                    </div>
                @else
                    <div class="flex-grow flex items-center justify-center text-gray-400 text-xs font-medium w-full">No hay datos en este rango</div>
                @endif
            </div>
        </div>

        <div class="mt-6 space-y-6">
            
            @if($tipoReporte === 'todo' || $tipoReporte === 'servicios')
            <div>
                <h3 class="text-sm font-black uppercase tracking-widest border-b-2 border-black inline-block mb-3 text-[#06281E]">Desglose de Servicios Agendados</h3>
                <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark bg-white shadow-sm">
                    <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                        <thead class="border-b border-[#8DBEA2]/50 bg-[#E8F2EC] text-sm text-[#06281E] font-black uppercase">
                            <tr>
                                <th scope="col" class="p-4 w-12 text-center">N°</th>
                                <th scope="col" class="p-4">C.I. Turista</th>
                                <th scope="col" class="p-4">F. Inicio</th>
                                <th scope="col" class="p-4">F. Fin</th>
                                <th scope="col" class="p-4">Hora</th>
                                <th scope="col" class="p-4">Servicio</th>
                                <th scope="col" class="p-4 text-center">Cant.</th>
                                <th scope="col" class="p-4 text-right">Subtotal</th>
                                <th scope="col" class="p-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @php $sumaListaServicios = 0; @endphp
                            @forelse($servicios as $item)
                                @php $sumaListaServicios += $item->subtotal; @endphp
                                <tr class="even:bg-primary/5 dark:even:bg-primary-dark/10">
                                    <td class="p-4 text-center font-bold">{{ $loop->iteration }}</td>
                                    <td class="p-4 font-mono">{{ $item->reserva->turista->cedula ?? 'N/A' }}</td>
                                    <td class="p-4">{{ \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td class="p-4">{{ $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') : \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td class="p-4">{{ $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--' }}</td>
                                    <td class="p-4">
                                        <strong class="block">{{ $item->servicio->nombre ?? 'N/A' }}</strong>
                                        <span class="text-[10px] text-gray-500">{{ $item->servicio->tipoServicio->nombre ?? '' }}</span>
                                    </td>
                                    <td class="p-4 text-center font-bold">{{ $item->cantidad }}</td>
                                    <td class="p-4 text-right">${{ number_format($item->subtotal, 2) }}</td>
                                    <td class="p-4 font-black">
                                        @php $estadoRsv = $item->reserva->estado ?? ''; @endphp
                                        <span class="text-[10px] uppercase tracking-wider {{ $estadoRsv == 'Confirmada' || $estadoRsv == 'Completada' ? 'text-[#00A344]' : ($estadoRsv == 'Pendiente' ? 'text-amber-500' : 'text-red-500') }}">
                                            {{ $estadoRsv }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="p-4 text-center text-gray-500 text-xs">No hay servicios en este rango.</td></tr>
                            @endforelse
                        </tbody>
                        @if($servicios->isNotEmpty())
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="7" class="p-4 text-right font-black text-gray-700 uppercase tracking-widest text-xs border-t border-gray-200">Total Calculado:</td>
                                <td class="p-4 text-right font-black text-[#00A344] text-sm border-t border-gray-200">${{ number_format($sumaListaServicios, 2) }}</td>
                                <td class="p-4 border-t border-gray-200"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
            @endif

            @if($tipoReporte === 'todo' || $tipoReporte === 'turistas')
            <div>
                <h3 class="text-sm font-black uppercase tracking-widest border-b-2 border-black inline-block mb-3 text-[#06281E]">Listado de Turistas</h3>
                <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark bg-white shadow-sm">
                    <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                        <thead class="border-b border-[#8DBEA2]/50 bg-[#E8F2EC] text-sm text-[#06281E] font-black uppercase">
                            <tr>
                                <th scope="col" class="p-4 w-12 text-center">N°</th>
                                <th scope="col" class="p-4">Turista</th>
                                <th scope="col" class="p-4">Contacto</th>
                                <th scope="col" class="p-4">Servicio Solicitado</th>
                                <th scope="col" class="p-4">Rango de Fechas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse($servicios as $item)
                                @php
                                    $turista = $item->reserva->turista;
                                    $edad = $turista->edad ?? (\Carbon\Carbon::parse($turista->fecha_nacimiento)->age ?? 'N/A');
                                @endphp
                                <tr class="even:bg-primary/5 dark:even:bg-primary-dark/10">
                                    <td class="p-4 text-center font-bold">{{ $loop->iteration }}</td>
                                    <td class="p-4">
                                        <strong class="block">{{ $turista->name ?? 'Usuario' }} {{ $turista->apellidos ?? '' }}</strong>
                                        <span class="text-xs text-gray-500 block mt-1">C.I: {{ $turista->cedula ?? 'N/A' }} | Edad: {{ $edad }}</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="block">{{ $turista->email ?? 'Sin correo' }}</span>
                                        <span class="block text-gray-500 text-xs mt-1">Tel: {{ $turista->telefono ?? 'N/A' }}</span>
                                    </td>
                                    <td class="p-4">
                                        <strong>{{ $item->servicio->nombre ?? 'N/A' }}</strong>
                                    </td>
                                    <td class="p-4">
                                        <span class="block">Del: {{ \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') }}</span>
                                        <span class="block">Al: {{ $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') : \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-4 text-center text-gray-500 text-xs">No hay clientes en este rango.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if($tipoReporte === 'todo' || $tipoReporte === 'inventario')
            <div>
                <h3 class="text-sm font-black uppercase tracking-widest border-b-2 border-black inline-block mb-3 text-[#06281E]">Inventario de Servicios</h3>
                <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark bg-white shadow-sm">
                    <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                        <thead class="border-b border-[#8DBEA2]/50 bg-[#E8F2EC] text-sm text-[#06281E] font-black uppercase">
                            <tr>
                                <th scope="col" class="p-4">Categoría</th>
                                <th scope="col" class="p-4">Servicio Disponible</th>
                                <th scope="col" class="p-4 text-right">Precio Base</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse($serviciosInventario as $categoria => $listaServicios)
                                @foreach($listaServicios as $index => $servicio)
                                <tr class="even:bg-primary/5 dark:even:bg-primary-dark/10">
                                    @if($index === 0)
                                    <td class="p-4 font-black bg-gray-50 uppercase tracking-widest text-xs border-r border-gray-200" rowspan="{{ count($listaServicios) }}">
                                        {{ $categoria }}
                                    </td>
                                    @endif
                                    <td class="p-4">
                                        {{ $servicio->nombre }}
                                    </td>
                                    <td class="p-4 text-right font-bold">
                                        ${{ number_format($servicio->precio, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            @empty
                                <tr><td colspan="3" class="p-4 text-center text-gray-500 text-xs">No hay servicios registrados en el inventario.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div wire:key="charts-{{ $chartKey }}" 
         x-data="{
             initCharts() {
                 let c1 = document.getElementById('graficoEstados-{{ $chartKey }}');
                 if(c1 && @js($totales['total'] > 0)) {
                     new Chart(c1, {
                         type: 'doughnut',
                         data: {
                             labels: ['Confirmadas', 'Completadas', 'Pendientes', 'Canceladas'],
                             datasets: [{
                                 data: [@js($totales['confirmadas']), @js($totales['completadas']), @js($totales['pendientes']), @js($totales['canceladas'])],
                                 backgroundColor: ['#00A344', '#3b82f6', '#f59e0b', '#ef4444'],
                                 borderWidth: 1.5,
                                 borderColor: '#ffffff'
                             }]
                         },
                         options: { responsive: true, maintainAspectRatio: false, cutout: '65%', plugins: { legend: { position: 'right', labels: { boxWidth: 10, font: {size: 10} } } }, layout: { padding: 0 } }
                     });
                 }

                 let c2 = document.getElementById('graficoServicios-{{ $chartKey }}');
                 if(c2 && @js(count($nombresServicios) > 0)) {
                     new Chart(c2, {
                         type: 'bar',
                         data: {
                             labels: @js($nombresServicios),
                             datasets: [{
                                 label: 'Cantidad solicitada',
                                 data: @js($cantidadesServicios),
                                 backgroundColor: '#8DBEA2',
                                 borderRadius: 2,
                                 maxBarThickness: 25
                             }]
                         },
                         options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1, font: {size: 10} } }, x: { grid: {display: false}, ticks: { font: {size: 10} } } }, layout: { padding: 0 } }
                     });
                 }
             }
         }"
         x-init="$nextTick(() => { initCharts(); })">
    </div>
</div>