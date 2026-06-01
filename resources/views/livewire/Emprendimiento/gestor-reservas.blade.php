<div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6 relative text-[#06281E] dark:text-gray-200">
    
    {{-- CABECERA PRINCIPAL --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 dark:border-white/10 pb-6">
        <div>
            <h1 class="text-3xl font-black text-[#06281E] dark:text-white tracking-tight flex items-center gap-3">
                <svg class="size-8 text-[#00A344] dark:text-[#00D65B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Gestión de reservas
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 uppercase tracking-widest font-black">Administra las solicitudes de tus clientes</p>
        </div>
        <a href="{{ route('emprendimiento.reservas.crear') }}" wire:navigate class="w-full md:w-auto flex items-center justify-center gap-2 bg-[#0acd5b] hover:bg-green-700 dark:bg-[#00D65B] dark:hover:bg-[#00c052] text-black dark:text-[#06281E] px-6 py-3.5 rounded-full text-sm font-black transition-all shadow-sm outline-none">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Nueva reserva
        </a>
    </div>

    {{-- FILTROS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-white/10">
        <div class="relative flex w-full flex-col gap-1.5">
            <label class="w-fit pl-1 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider">Buscar cédula</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-gray-400"> 
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.1000ms="buscarCedula" type="search" class="w-full rounded-full border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800/50 py-2.5 pl-10 pr-4 text-sm font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-[#00A344] outline-none transition-all shadow-sm" placeholder="Ej: 060..."/>
            </div>
        </div>

        <div class="relative flex w-full flex-col gap-1.5">
            <label class="w-fit pl-1 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoría</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-1/2 size-4 -translate-y-1/2 text-gray-400">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <select wire:model.live="filtroCategoria" class="w-full appearance-none rounded-full border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800/50 px-4 py-2.5 text-sm font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-[#00A344] outline-none transition-all shadow-sm">
                    <option value="">Todas las categorías</option>
                    @foreach($this->categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="relative flex w-full flex-col gap-1.5">
            <label class="w-fit pl-1 text-[10px] font-black text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-1/2 size-4 -translate-y-1/2 text-gray-400">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <select wire:model.live="filtroEstado" class="w-full appearance-none rounded-full border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800/50 px-4 py-2.5 text-sm font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-[#00A344] outline-none transition-all shadow-sm">
                    <option value="">Todos los estados</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Completada">Completada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
        </div>
    </div>

    {{-- TABLA PRINCIPAL DE RESERVAS --}}
    <div class="overflow-hidden w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-sm">
        <table class="w-full text-left text-sm text-[#06281E] dark:text-white">
            <thead class="border-b border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-800 text-[10px] text-[#000000] dark:text-[#00D65B] uppercase font-black tracking-wider">
                <tr>
                    <th scope="col" class="p-4.5">Turista</th>
                    <th scope="col" class="p-4.5">Categoría(s)</th>
                    <th scope="col" class="p-4.5">Creación</th>
                    <th scope="col" class="p-4.5">Última modif.</th>
                    <th scope="col" class="p-4.5">Reservado por</th>
                    <th scope="col" class="p-4.5">Estado</th>
                    <th scope="col" class="p-4.5 text-right">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-zinc-800 relative">
                <div wire:loading.flex wire:target="filtroCategoria, filtroEstado, buscarCedula" class="absolute inset-0 bg-white/60 dark:bg-zinc-900/80 backdrop-blur-sm z-10 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#00A344]"></div>
                </div>

                @forelse($this->reservas as $reserva)
                    <tr wire:key="reserva-item-{{ $reserva->id }}" class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                        <td class="p-4.5">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-[#00A344]/10 text-[#00A344] dark:text-[#00D65B] flex items-center justify-center font-black text-lg shrink-0 border border-[#00A344]/20">
                                    {{ substr($reserva->turista?->name ?? '?', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#06281E] dark:text-white text-sm">
                                        {{ $reserva->turista?->name ?? 'Usuario' }} {{ $reserva->turista?->apellidos ?? 'eliminado' }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium">CI: {{ $reserva->turista?->cedula ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4.5">
                            @php
                                // Extrae todas las categorías o tipos de servicios únicos de esta reserva específica
                                $categoriasUnicas = $reserva->detalles->map(function($detalle) {
                                    return $detalle->servicio->categoria->nombre ?? $detalle->servicio->tipoServicio->nombre ?? '';
                                })->filter()->unique();
                            @endphp
                            
                            <div class="flex flex-wrap gap-1 max-w-[160px]">
                                @forelse($categoriasUnicas as $catName)
                                    <span class="inline-flex rounded border border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800 px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest text-gray-600 dark:text-gray-400">
                                        {{ $catName }}
                                    </span>
                                @empty
                                    <span class="text-[10px] font-bold text-gray-400">N/A</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="p-4.5 font-bold text-gray-500">
                            {{ $reserva->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4.5 font-bold text-gray-500 text-xs">
                            {{ $reserva->updated_at->diffForHumans() }}
                        </td>
                        <td class="p-4.5">
                            <span class="text-[10px] font-black uppercase tracking-wider {{ $reserva->reservada_por_rol === 'Emprendimiento' ? 'text-indigo-600 dark:text-indigo-400' : 'text-teal-600 dark:text-teal-400' }}">
                                {{ $reserva->reservada_por_rol }}
                            </span>
                        </td>
                        <td class="p-4.5">
                            @php
                                $color = match($reserva->estado) {
                                    'Confirmada' => 'text-green-700 bg-green-50 border-green-200 dark:bg-green-900/30 dark:text-[#00D65B] dark:border-green-800',
                                    'Completada' => 'text-blue-700 bg-blue-50 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                                    'Reagendada' => 'text-yellow-700 bg-yellow-50 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800',
                                    'Pendiente'  => 'text-orange-700 bg-orange-50 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-800',
                                    'Cancelada', 'Rechazada' => 'text-red-700 bg-red-50 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
                                    default => 'text-gray-700 bg-gray-50 border-gray-200 dark:bg-zinc-800 dark:text-gray-400 dark:border-zinc-700'
                                };
                            @endphp
                            <span class="inline-flex rounded-md border px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest {{ $color }}">
                                {{ $reserva->estado }}
                            </span>
                        </td>
                        <td class="p-4.5 text-right">
                            <button wire:click="verDetalles({{ $reserva->id }})" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-[#00D65B]/10 border border-[#00D65B]/30 text-[#00A344] hover:-translate-y-0.5 hover:shadow-md hover:bg-[#00D65B] hover:border-[#00D65B] hover:text-[#06281E] dark:bg-[#00D65B]/10 dark:border-[#00D65B]/20 dark:text-[#00D65B] dark:hover:bg-[#00D65B] dark:hover:text-[#06281E] rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all duration-300 outline-none cursor-pointer">
                                <svg class="size-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Detalle
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-gray-500">
                            <svg class="size-12 mx-auto text-gray-300 dark:text-zinc-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                            <p class="text-sm font-bold">No se encontraron reservas con los filtros seleccionados.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $this->reservas->links('components.paginacion-turismo') }}
    </div>

    @if($mostrarModal && $reservaSeleccionada)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 dark:bg-black/80 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-[#161A16] rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[90vh] border border-gray-200 dark:border-zinc-800">
                
                <div class="flex justify-between items-center p-6 border-b border-gray-100 dark:border-zinc-800 bg-white dark:bg-[#161A16] text-[#06281E] dark:text-white">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-black tracking-tight uppercase text-[#00A344] dark:text-[#00D65B]">
                            {{ $modoReagendar ? 'Modificar fechas' : 'Gestión de Expediente' }}
                        </h3>
                    </div>
                    <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-700 dark:hover:text-white transition p-2 rounded-full shrink-0 outline-none"><svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>

                <div class="p-6 md:p-8 space-y-8 overflow-y-auto flex-1 bg-white dark:bg-[#161A16]">
                    
                    @error('error_general')
                        <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm mb-4">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <p class="text-sm text-red-700 dark:text-red-400 font-bold">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror

                    <div class="flex flex-col md:flex-row gap-6 bg-gray-50 dark:bg-zinc-800/50 p-6 rounded-xl border border-gray-100 dark:border-zinc-700">
                        
                        <div class="flex-1">
                            <h4 class="text-[10px] font-black text-[#00A344] dark:text-[#00D65B] uppercase tracking-widest mb-4 border-b border-[#00A344]/20 pb-1">DATOS DEL CLIENTE</h4>
                            <div class="text-sm text-[#06281E] dark:text-white space-y-3">
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Nombre:</span> 
                                    <span class="font-black">{{ $reservaSeleccionada->turista->name }} {{ $reservaSeleccionada->turista->apellidos }}</span>
                                </div>
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Documento:</span> 
                                    <span class="font-black">{{ $reservaSeleccionada->turista->cedula }}</span>
                                </div>
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Correo:</span> 
                                    <span class="font-black break-all">{{ $reservaSeleccionada->turista->email }}</span>
                                </div>
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Teléfono:</span> 
                                    <span class="font-black">{{ $reservaSeleccionada->turista->telefono ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="hidden md:block w-px bg-gray-200 dark:bg-zinc-700"></div>

                        <div class="flex-1">
                            <h4 class="text-[10px] font-black text-[#00A344] dark:text-[#00D65B] uppercase tracking-widest mb-4 border-b border-[#00A344]/20 pb-1">DETALLES DE RESERVA</h4>
                            <div class="text-sm text-[#06281E] dark:text-white space-y-3">
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Reserva Nº:</span> 
                                    <span class="font-black text-xl leading-none">#{{ str_pad($reservaSeleccionada->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Fecha:</span> 
                                    <span class="font-black">{{ $reservaSeleccionada->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="grid grid-cols-[110px_1fr] gap-2 items-center">
                                    <span class="font-bold text-gray-500 uppercase text-[10px] tracking-wider">Estado:</span> 
                                    <span class="font-black {{ $reservaSeleccionada->estado === 'Cancelada' ? 'text-red-600 dark:text-red-400' : 'text-[#00A344] dark:text-[#00D65B]' }}">{{ $reservaSeleccionada->estado }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="border border-gray-200 dark:border-zinc-800 rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700 text-[10px] uppercase font-black text-gray-500 tracking-widest">
                                    <tr>
                                        <th class="px-6 py-4">Descripción del Servicio</th>
                                        <th class="px-6 py-4 text-center">Programación</th>
                                        <th class="px-6 py-4 text-center">Cant. / Huéspedes</th>
                                        <th class="px-6 py-4 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800 bg-white dark:bg-[#161A16]">
                                    @foreach($reservaSeleccionada->detalles as $item)
                                        <tr>
                                            <td class="px-6 py-5">
                                                <strong class="block text-[#06281E] dark:text-white text-sm font-black">{{ $item->servicio->nombre }}</strong>
                                                <span class="text-[9px] text-gray-400 uppercase font-black tracking-wider mt-1 block">{{ $item->servicio->tipoServicio->nombre ?? '' }}</span>
                                            </td>
                                            <td class="px-6 py-5">
                                                @if($modoReagendar)
                                                    <div class="flex flex-col gap-2 bg-gray-50 dark:bg-zinc-900 p-3 rounded-lg border border-gray-200 dark:border-zinc-700 min-w-[200px]">
                                                        <div class="flex gap-2">
                                                            <div class="w-1/2">
                                                                <span class="text-[10px] font-black text-gray-500 uppercase block mb-1">Inicia</span>
                                                                <input type="date" wire:model.defer="nuevasFechas.{{ $item->id }}.inicio" class="w-full rounded border-gray-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-xs py-1.5 font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-[#00A344] outline-none">
                                                                @error('nuevasFechas.'.$item->id.'.inicio') <span class="text-red-500 text-[10px] leading-tight block mt-1 font-bold">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="w-1/2">
                                                                <span class="text-[10px] font-black text-gray-500 uppercase block mb-1">Termina</span>
                                                                <input type="date" wire:model.defer="nuevasFechas.{{ $item->id }}.fin" class="w-full rounded border-gray-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-xs py-1.5 font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-[#00A344] outline-none">
                                                                @error('nuevasFechas.'.$item->id.'.fin') <span class="text-red-500 text-[10px] leading-tight block mt-1 font-bold">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span class="text-[10px] font-black text-gray-500 uppercase block mb-1">Hora de llegada</span>
                                                            <input type="time" wire:model.defer="nuevasFechas.{{ $item->id }}.hora_llegada" class="w-full rounded border-gray-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-xs py-1.5 font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-[#00A344] outline-none">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center flex flex-col items-center gap-1.5">
                                                        <span class="block font-medium text-[#06281E] dark:text-white whitespace-nowrap text-sm">
                                                            {{ $item->fecha_inicio->format('d/m/Y') }} 
                                                            @if($item->fecha_fin && $item->fecha_inicio != $item->fecha_fin) 
                                                                <span class="text-gray-400 mx-1">al</span> {{ $item->fecha_fin->format('d/m/Y') }} 
                                                            @endif
                                                        </span>
                                                        @if($item->hora_llegada)
                                                            <span class="inline-block px-2.5 py-0.5 bg-[#00A344]/10 text-[#00A344] dark:text-[#00D65B] rounded-md text-[10px] font-black uppercase tracking-widest">Llegada: {{ \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') }}</span>
                                                        @else
                                                            <span class="inline-block px-2.5 py-0.5 bg-gray-100 dark:bg-zinc-800 text-gray-500 rounded-md text-[10px] font-black uppercase tracking-widest">Hora no registrada</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-6 align-top text-center">
                                                <div class="flex flex-col gap-2 items-center">
                                                    <div>
                                                        <span class="font-black text-[#06281E] dark:text-white text-base block">{{ $item->cantidad }}</span>
                                                        <span class="text-[9px] text-gray-500 uppercase font-medium tracking-widest">Cant / Hab.</span>
                                                    </div>
                                                    
                                                    @php $huespedes = $item->numero_personas ?? $item->numero_huespedes ?? $item->huespedes ?? $item->cantidad_personas ?? null; @endphp
                                                    @if($huespedes !== null)
                                                        <div>
                                                            <span class="font-black text-[#00A344] dark:text-[#00D65B] text-base block">{{ $huespedes }}</span>
                                                            <span class="text-[9px] text-[#00A344] dark:text-[#00D65B] uppercase font-bold tracking-widest">Huéspedes</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-6 pl-6 align-top text-right font-black text-[#06281E] dark:text-white text-lg">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($reservaSeleccionada->estado === 'Cancelada' && !empty($reservaSeleccionada->motivo_cancelacion))
                        <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-xl p-5">
                            <h5 class="text-[10px] font-black uppercase tracking-widest text-red-600 dark:text-red-400 mb-1">Motivo de la cancelación</h5>
                            <p class="text-sm text-red-700 dark:text-red-300 font-bold mt-1">{{ $reservaSeleccionada->motivo_cancelacion }}</p>
                        </div>
                    @endif

                    <div class="flex justify-end">
                        <div class="bg-gray-50 dark:bg-zinc-800/80 border border-gray-200 dark:border-zinc-700 rounded-xl py-3 px-6 flex items-center justify-between min-w-[300px]">
                            <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">TOTAL PAGADO</span>
                            <span class="text-2xl font-black text-[#00A344] dark:text-[#00D65B]">${{ number_format($reservaSeleccionada->precio_total, 2) }}</span>
                        </div>
                    </div>

                    @if($intentoCancelar)
                        <div class="bg-gray-50 dark:bg-zinc-800 border border-red-200 dark:border-red-900/50 rounded-xl p-6 shadow-sm mt-4">
                            <label class="block text-sm font-black text-red-600 dark:text-red-400 mb-1.5 uppercase tracking-wider">Mensaje obligatorio de cancelación</label>
                            <p class="text-xs text-gray-500 mb-4 font-medium">Este mensaje se enviará por correo electrónico al turista para explicar el motivo.</p>
                            
                            <textarea wire:model.defer="motivoCancelacion" rows="3" class="w-full rounded-lg border border-gray-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-sm font-bold text-[#06281E] dark:text-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none p-4" placeholder="Ej: No disponemos de habitaciones para esas fechas..."></textarea>
                            @error('motivoCancelacion') <span class="text-red-500 dark:text-red-400 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                            
                            <div class="mt-5 flex flex-col sm:flex-row gap-3 sm:justify-end">
                                <button wire:click="$set('intentoCancelar', false)" class="w-full sm:w-auto px-6 py-2.5 text-xs font-black text-gray-500 hover:text-[#06281E] dark:hover:text-white transition-colors border border-gray-300 dark:border-zinc-600 rounded-lg uppercase tracking-wider outline-none bg-white dark:bg-zinc-800">Regresar</button>
                                <button wire:click="confirmarCancelacion" class="w-full sm:w-auto px-6 py-2.5 bg-red-600 text-white hover:bg-red-700 text-xs font-black rounded-lg shadow-md transition-all uppercase tracking-wider outline-none">Confirmar cancelación</button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-5 bg-gray-50 dark:bg-zinc-900 border-t border-gray-200 dark:border-zinc-800 flex justify-end">
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                        @if($modoReagendar)
                            <button wire:click="$set('modoReagendar', false)" class="w-full sm:w-auto px-6 py-2.5 text-[10px] font-black text-gray-500 hover:bg-gray-200 dark:text-gray-400 dark:hover:bg-zinc-800 border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded uppercase tracking-widest transition-colors outline-none">Descartar cambios</button>
                            <button wire:click="guardarReagendamiento" class="w-full sm:w-auto px-6 py-2.5 bg-[#00A344] text-white hover:bg-green-700 text-[10px] font-black rounded shadow-md transition-all flex justify-center items-center gap-2 uppercase tracking-widest outline-none">
                                <svg wire:loading.remove wire:target="guardarReagendamiento" class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <svg wire:loading wire:target="guardarReagendamiento" class="animate-spin size-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Guardar y notificar
                            </button>
                        @elseif(!$intentoCancelar)
                            <button wire:click="cerrarModal" class="w-full sm:w-auto px-6 py-2.5 text-[10px] font-black text-gray-500 bg-white hover:bg-gray-200 dark:text-gray-300 dark:bg-zinc-800 dark:hover:bg-zinc-700 border border-gray-300 dark:border-zinc-600 rounded uppercase tracking-widest transition-colors outline-none">Cerrar</button>

                            @if(in_array($reservaSeleccionada->estado, ['Pendiente', 'Reagendada']))
                                <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Confirmada')" class="w-full sm:w-auto px-6 py-2.5 bg-[#06281E] text-white hover:bg-[#0a3e2e] dark:bg-[#11991F] dark:hover:bg-[#0E7A18] text-[10px] font-black rounded shadow-md uppercase tracking-widest transition-all outline-none">Confirmar reserva</button>
                            @endif
                            
                            @if(in_array($reservaSeleccionada->estado, ['Confirmada', 'Reagendada', 'Pendiente']))
                                <button wire:click="activarModoReagendar" class="w-full sm:w-auto px-6 py-2.5 text-yellow-600 hover:bg-yellow-50 dark:text-yellow-500 border border-yellow-300 dark:border-yellow-900/50 dark:hover:bg-yellow-900/30 text-[10px] font-black rounded uppercase tracking-widest transition-colors outline-none bg-white dark:bg-zinc-800">Reagendar</button>
                                <button wire:click="intentarCancelar" class="w-full sm:w-auto px-6 py-2.5 text-red-600 hover:bg-red-50 dark:text-red-400 border border-red-300 dark:border-red-900/50 dark:hover:bg-red-900/30 text-[10px] font-black rounded uppercase tracking-widest transition-colors outline-none bg-white dark:bg-zinc-800">Cancelar</button>
                            @endif

                            @if($reservaSeleccionada->estado === 'Confirmada')
                                <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Completada')" class="w-full sm:w-auto px-6 py-2.5 bg-[#508A45] text-white hover:bg-[#3E6B35] dark:bg-[#11991F] dark:hover:bg-[#0E7A18] text-[10px] font-black rounded shadow-md uppercase tracking-widest transition-all outline-none">Marcar completada</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <button wire:click="$dispatch('abrirCalendario')" 
            class="fixed bottom-8 right-8 z-40 bg-[#00D65B] text-[#06281E] shadow-xl hover:bg-[#00c052] hover:scale-105 dark:bg-[#00D65B] dark:text-[#06281E] transition-all duration-300 rounded-full p-4 flex items-center justify-center group outline-none">
        <svg class="size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4M4 11h16M11 15h2m-1-1v2" /></svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 font-bold pl-0 group-hover:pl-3 text-xs uppercase tracking-widest">Ver calendario</span>
    </button>

    @livewire('emprendimiento.reserva.calendario-lateral')
</div>