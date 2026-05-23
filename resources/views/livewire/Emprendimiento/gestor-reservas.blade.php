<div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6 relative text-[#2C3D30] dark:text-[#F3F5F3]">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-[#C2D5C0] dark:border-[#2A332A] pb-6">
        <div>
            <h1 class="text-3xl font-black text-[#2C3D30] dark:text-white tracking-tight flex items-center gap-3">
                <svg class="size-8 text-[#508A45] dark:text-[#11991F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Gestión de reservas
            </h1>
            <p class="text-xs text-[#6B806D] dark:text-[#8C9E8C] mt-1.5 uppercase tracking-widest font-black">Administra las solicitudes de tus clientes</p>
        </div>
        <a href="{{ route('emprendimiento.reservas.crear') }}" wire:navigate class="w-full md:w-auto flex items-center justify-center gap-2 bg-[#508A45] hover:bg-[#3E6B35] dark:bg-[#11991F] dark:hover:bg-[#0E7A18] text-white px-6 py-3.5 rounded-full text-sm font-black transition-all shadow-md shadow-[#508A45]/20 dark:shadow-none">
            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Agendar nueva reserva
        </a>
    </div>

    {{-- Grid de filtros --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white dark:bg-[#161A16] p-6 rounded-lg shadow-sm border border-[#C2D5C0] dark:border-[#2A332A]">
        <div class="relative flex w-full flex-col gap-1.5">
            <label class="w-fit pl-1 text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase tracking-wider">Buscar cédula</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-[#6B806D] dark:text-[#8C9E8C]"> 
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input wire:model.live.debounce.1000ms="buscarCedula" type="search" class="w-full rounded-full border border-[#C2D5C0] dark:border-[#354235] bg-[#F1F5E6] dark:bg-[#202520] py-2.5 pl-10 pr-4 text-sm font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-[#508A45] dark:focus:ring-[#11991F] focus:border-[#508A45] dark:focus:border-[#11991F] outline-none transition-all" placeholder="Ej: 060..."/>
            </div>
        </div>

        <div class="relative flex w-full flex-col gap-1.5">
            <label class="w-fit pl-1 text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase tracking-wider">Categoría</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-1/2 size-4 -translate-y-1/2 text-[#6B806D] dark:text-[#8C9E8C]">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <select wire:model.live="filtroCategoria" class="w-full appearance-none rounded-full border border-[#C2D5C0] dark:border-[#354235] bg-[#F1F5E6] dark:bg-[#202520] px-4 py-2.5 text-sm font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-[#508A45] dark:focus:ring-[#11991F] focus:border-[#508A45] dark:focus:border-[#11991F] outline-none transition-all">
                    <option value="">Todas las categorías</option>
                    @foreach($this->categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="relative flex w-full flex-col gap-1.5">
            <label class="w-fit pl-1 text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase tracking-wider">Estado</label>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-4 top-1/2 size-4 -translate-y-1/2 text-[#6B806D] dark:text-[#8C9E8C]">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
                <select wire:model.live="filtroEstado" class="w-full appearance-none rounded-full border border-[#C2D5C0] dark:border-[#354235] bg-[#F1F5E6] dark:bg-[#202520] px-4 py-2.5 text-sm font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-[#508A45] dark:focus:ring-[#11991F] focus:border-[#508A45] dark:focus:border-[#11991F] outline-none transition-all">
                    <option value="">Todos los estados</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Completada">Completada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-hidden w-full overflow-x-auto rounded-lg border border-[#C2D5C0] dark:border-[#2A332A] bg-white dark:bg-[#161A16] shadow-sm">
        <table class="w-full text-left text-sm text-[#2C3D30] dark:text-[#F3F5F3]">
            <thead class="border-b border-[#C2D5C0] dark:border-[#2A332A] bg-[#F1F5E6] dark:bg-[#101310] text-[10px] text-[#6B806D] dark:text-[#8C9E8C] uppercase font-black tracking-wider">
                <tr>
                    <th scope="col" class="p-4.5">Turista</th>
                    <th scope="col" class="p-4.5">Nº Reserva</th>
                    <th scope="col" class="p-4.5">Creación</th>
                    <th scope="col" class="p-4.5">Última modif.</th>
                    <th scope="col" class="p-4.5">Reservado por</th>
                    <th scope="col" class="p-4.5">Estado</th>
                    <th scope="col" class="p-4.5 text-right">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#C2D5C0]/40 dark:divide-[#2A332A] relative">
                <div wire:loading.flex wire:target="filtroCategoria, filtroEstado, buscarCedula" class="absolute inset-0 bg-white/60 dark:bg-[#161A16]/80 backdrop-blur-sm z-10 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#508A45] dark:border-[#11991F]"></div>
                </div>

                @forelse($this->reservas as $reserva)
                    <tr wire:key="reserva-item-{{ $reserva->id }}" class="hover:bg-[#F1F5E6]/30 dark:hover:bg-[#202520] transition-colors">
                        <td class="p-4.5">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-[#C2D5C0]/40 dark:bg-[#202520] text-[#508A45] dark:text-[#11991F] flex items-center justify-center font-black text-lg shrink-0 border dark:border-[#354235]">
                                    {{ substr($reserva->turista?->name ?? '?', 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#2C3D30] dark:text-[#F3F5F3] text-sm">
                                        {{ $reserva->turista?->name ?? 'Usuario' }} {{ $reserva->turista?->apellidos ?? 'eliminado' }}
                                    </span>
                                    <span class="text-xs text-[#6B806D] dark:text-[#8C9E8C] font-medium">CI: {{ $reserva->turista?->cedula ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4.5 font-black text-[#2C3D30] dark:text-[#F3F5F3] text-base">
                            {{ $reserva->id }}
                        </td>
                        <td class="p-4.5 font-bold text-[#6B806D] dark:text-[#8C9E8C]">
                            {{ $reserva->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4.5 font-bold text-[#6B806D] dark:text-[#8C9E8C] text-xs">
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
                                    'Confirmada' => 'text-green-700 bg-green-50 border-green-200 dark:bg-green-900/30 dark:text-[#11991F] dark:border-green-800',
                                    'Completada' => 'text-blue-700 bg-blue-50 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                                    'Reagendada' => 'text-yellow-700 bg-yellow-50 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800',
                                    'Pendiente'  => 'text-orange-700 bg-orange-50 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:border-orange-800',
                                    'Cancelada', 'Rechazada' => 'text-red-700 bg-red-50 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
                                    default => 'text-[#2C3D30] bg-[#F1F5E6] border-[#C2D5C0] dark:bg-[#202520] dark:text-[#A5B8A5] dark:border-[#354235]'
                                };
                            @endphp
                            <span class="inline-flex rounded-full border px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $color }}">
                                {{ $reserva->estado }}
                            </span>
                        </td>
                        <td class="p-4.5 text-right">
                            <button wire:click="verDetalles({{ $reserva->id }})" class="inline-flex items-center gap-1.5 rounded-full bg-white dark:bg-[#161A16] px-4 py-2 text-xs font-black text-[#508A45] dark:text-[#11991F] border border-[#C2D5C0] dark:border-[#354235] hover:bg-[#508A45] dark:hover:bg-[#11991F] hover:text-white dark:hover:text-white hover:border-[#508A45] dark:hover:border-[#11991F] transition-all shadow-sm">
                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Ver detalle
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-[#6B806D] dark:text-[#8C9E8C]">
                            <svg class="size-12 mx-auto text-[#C2D5C0] dark:text-[#354235] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
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
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#2C3D30]/60 dark:bg-[#0A0C0A]/90 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-[#161A16] rounded-[2rem] shadow-2xl w-full max-w-4xl overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[90vh] border border-[#C2D5C0] dark:border-[#2A332A]">
                
                <div class="flex justify-between items-center p-6 border-b border-[#C2D5C0]/40 dark:border-[#2A332A] bg-[#508A45] dark:bg-[#11991F] text-white">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-xl hidden sm:block">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="text-xl font-black tracking-tight truncate">
                            {{ $modoReagendar ? 'Modificar fechas' : 'Detalle de reserva' }} #{{ $reservaSeleccionada->id }}
                        </h3>
                    </div>
                    <button wire:click="cerrarModal" class="text-white/80 hover:text-white transition bg-black/10 p-2 rounded-full shrink-0"><svg class="size-5 sm:size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>

                <div class="p-6 space-y-6 overflow-y-auto flex-1 bg-[#F1F5E6]/30 dark:bg-[#101310]">
                    
                    @error('error_general')
                        <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-r-2xl shadow-sm mb-4">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <p class="text-sm text-red-700 dark:text-red-400 font-bold">{{ $message }}</p>
                            </div>
                        </div>
                    @enderror

                    <div class="bg-white dark:bg-[#161A16] border border-[#C2D5C0] dark:border-[#2A332A] rounded-3xl p-5 shadow-sm">
                        <h4 class="text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase tracking-widest mb-4 flex items-center gap-2"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> Información del turista</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-[#2C3D30] dark:text-[#F3F5F3]">
                            <div><span class="text-[10px] text-[#6B806D] dark:text-[#8C9E8C] uppercase block font-bold">Nombre</span> <strong class="text-sm truncate block font-black">{{ $reservaSeleccionada->turista->name }} {{ $reservaSeleccionada->turista->apellidos }}</strong></div>
                            <div><span class="text-[10px] text-[#6B806D] dark:text-[#8C9E8C] uppercase block font-bold">Cédula</span> <strong class="text-sm font-black">{{ $reservaSeleccionada->turista->cedula }}</strong></div>
                            <div><span class="text-[10px] text-[#6B806D] dark:text-[#8C9E8C] uppercase block font-bold">Correo</span> <strong class="text-sm break-all font-black">{{ $reservaSeleccionada->turista->email }}</strong></div>
                            <div><span class="text-[10px] text-[#6B806D] dark:text-[#8C9E8C] uppercase block font-bold">Teléfono</span> <strong class="text-sm font-black">{{ $reservaSeleccionada->turista->telefono ?? 'N/A' }}</strong></div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#161A16] border border-[#C2D5C0] dark:border-[#2A332A] rounded-3xl shadow-sm overflow-hidden">
                        <div class="p-4 border-b border-[#C2D5C0]/40 dark:border-[#2A332A] bg-[#F1F5E6] dark:bg-[#101310]">
                            <h4 class="text-[10px] font-black text-[#2C3D30] dark:text-[#A5B8A5] uppercase tracking-widest flex items-center gap-2"><svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg> Servicios contratados</h4>
                        </div>
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-sm text-left min-w-[500px]">
                                <thead class="bg-white dark:bg-[#161A16] text-[9px] uppercase font-black text-[#6B806D] dark:text-[#8C9E8C] border-b border-[#C2D5C0]/30 dark:border-[#2A332A] tracking-wider">
                                    <tr>
                                        <th class="px-5 py-4">Servicio</th>
                                        <th class="px-5 py-4 text-center">Programación</th>
                                        <th class="px-5 py-4 text-center">Cant.</th>
                                        <th class="px-5 py-4 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#C2D5C0]/30 dark:divide-[#2A332A] bg-white dark:bg-[#161A16]">
                                    @foreach($reservaSeleccionada->detalles as $item)
                                        <tr>
                                            <td class="px-5 py-4">
                                                <strong class="block text-[#2C3D30] dark:text-[#F3F5F3] text-base font-black">{{ $item->servicio->nombre }}</strong>
                                                <span class="text-[9px] text-[#6B806D] dark:text-[#8C9E8C] uppercase font-black tracking-wider">{{ $item->servicio->tipoServicio->nombre ?? '' }}</span>
                                            </td>
                                            <td class="px-5 py-4">
                                                @if($modoReagendar)
                                                    <div class="flex flex-col gap-2 bg-[#F1F5E6] dark:bg-[#101310] p-3 rounded-2xl border border-[#C2D5C0] dark:border-[#2A332A] min-w-[200px]">
                                                        <div class="flex gap-2">
                                                            <div class="w-1/2">
                                                                <span class="text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase block mb-1">Inicia</span>
                                                                <input type="date" wire:model.defer="nuevasFechas.{{ $item->id }}.inicio" class="w-full rounded-xl border-[#C2D5C0] dark:border-[#354235] bg-white dark:bg-[#202520] text-xs py-1.5 font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-[#508A45] dark:focus:ring-[#11991F] outline-none">
                                                                @error('nuevasFechas.'.$item->id.'.inicio') <span class="text-red-500 text-[10px] leading-tight block mt-1 font-bold">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="w-1/2">
                                                                <span class="text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase block mb-1">Termina</span>
                                                                <input type="date" wire:model.defer="nuevasFechas.{{ $item->id }}.fin" class="w-full rounded-xl border-[#C2D5C0] dark:border-[#354235] bg-white dark:bg-[#202520] text-xs py-1.5 font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-[#508A45] dark:focus:ring-[#11991F] outline-none">
                                                                @error('nuevasFechas.'.$item->id.'.fin') <span class="text-red-500 text-[10px] leading-tight block mt-1 font-bold">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span class="text-[10px] font-black text-[#6B806D] dark:text-[#8C9E8C] uppercase block mb-1">Hora de llegada</span>
                                                            <input type="time" wire:model.defer="nuevasFechas.{{ $item->id }}.hora_llegada" class="w-full rounded-xl border-[#C2D5C0] dark:border-[#354235] bg-white dark:bg-[#202520] text-xs py-1.5 font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-[#508A45] dark:focus:ring-[#11991F] outline-none">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center flex flex-col items-center">
                                                        <span class="block font-bold text-[#2C3D30] dark:text-[#F3F5F3] whitespace-nowrap text-xs">{{ $item->fecha_inicio->format('d/m/Y') }} @if($item->fecha_fin && $item->fecha_inicio != $item->fecha_fin) al {{ $item->fecha_fin->format('d/m/Y') }} @endif</span>
                                                        @if($item->hora_llegada)
                                                            <span class="inline-block mt-1.5 px-2.5 py-0.5 bg-[#F1F5E6] dark:bg-[#202520] text-[#508A45] dark:text-[#11991F] rounded-full text-[10px] font-black border border-[#C2D5C0]/40 dark:border-[#354235]">Llegada: {{ \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') }}</span>
                                                        @else
                                                            <span class="inline-block mt-1.5 px-2.5 py-0.5 bg-gray-50 dark:bg-[#202520] text-[#6B806D]/60 dark:text-[#8C9E8C] rounded-full text-[9px] font-black border border-gray-100 dark:border-[#354235]">Hora no registrada</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-5 py-4 text-center font-black text-[#2C3D30] dark:text-[#F3F5F3]">{{ $item->cantidad }}</td>
                                            <td class="px-5 py-4 text-right font-black text-[#2C3D30] dark:text-[#F3F5F3] text-base">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-[#F1F5E6]/40 dark:bg-[#101310] border-t border-[#C2D5C0]/60 dark:border-[#2A332A]">
                                    <tr>
                                        <td colspan="3" class="px-5 py-4 text-right font-black uppercase text-[10px] text-[#6B806D] dark:text-[#8C9E8C] tracking-wider">Total pagado:</td>
                                        <td class="px-5 py-4 text-right font-black text-[#508A45] dark:text-[#11991F] text-2xl">${{ number_format($reservaSeleccionada->precio_total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if($intentoCancelar)
                        <div class="bg-white dark:bg-[#161A16] border border-red-200 dark:border-red-900/50 rounded-3xl p-5 shadow-sm animate-in slide-in-from-top-4 duration-300">
                            <label class="block text-sm font-black text-red-600 dark:text-red-400 mb-1.5">Mensaje obligatorio de cancelación</label>
                            <p class="text-xs text-[#6B806D] dark:text-[#8C9E8C] mb-3 font-medium">Este mensaje se enviará por correo electrónico al turista para explicar el motivo.</p>
                            <textarea wire:model.defer="motivoCancelacion" rows="3" class="w-full rounded-2xl border-[#C2D5C0] dark:border-[#2A332A] bg-white dark:bg-[#101310] text-sm font-bold text-[#2C3D30] dark:text-[#F3F5F3] focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none p-3" placeholder="Ej: No disponemos de habitaciones para esas fechas..."></textarea>
                            @error('motivoCancelacion') <span class="text-red-500 dark:text-red-400 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
                            
                            <div class="mt-4 flex flex-col sm:flex-row gap-3 sm:justify-end">
                                <button wire:click="$set('intentoCancelar', false)" class="w-full sm:w-auto px-5 py-2.5 text-xs font-black text-[#6B806D] dark:text-[#8C9E8C] hover:text-[#2C3D30] dark:hover:text-white transition-colors border border-[#C2D5C0] dark:border-[#354235] rounded-full bg-white dark:bg-[#202520]">Regresar</button>
                                <button wire:click="confirmarCancelacion" class="w-full sm:w-auto px-6 py-2.5 bg-red-600 text-white hover:bg-red-700 text-xs font-black rounded-full shadow-md transition-all">Confirmar cancelación definitiva</button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="p-6 bg-white dark:bg-[#161A16] border-t border-[#C2D5C0]/30 dark:border-[#2A332A] flex flex-col sm:flex-row flex-wrap gap-4 items-center justify-between">
                    <div class="w-full sm:w-auto text-center sm:text-left mb-2 sm:mb-0">
                        <span class="text-[10px] text-[#6B806D] dark:text-[#8C9E8C] font-black uppercase tracking-wider block mb-1">Estado de la reserva</span>
                        <span class="text-sm font-black uppercase text-[#508A45] dark:text-[#11991F] tracking-wide">{{ $reservaSeleccionada->estado }}</span>
                    </div>
                    
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                        @if($modoReagendar)
                            <button wire:click="$set('modoReagendar', false)" class="w-full sm:w-auto px-5 py-2.5 text-xs font-black text-[#6B806D] dark:text-[#A5B8A5] hover:bg-gray-100 dark:hover:bg-[#202520] rounded-full transition-all border border-[#C2D5C0] dark:border-[#354235]">Descartar cambios</button>
                            <button wire:click="guardarReagendamiento" class="w-full sm:w-auto px-6 py-2.5 bg-[#508A45] text-white hover:bg-[#3E6B35] dark:bg-[#11991F] dark:hover:bg-[#0E7A18] text-xs font-black rounded-full shadow-md transition-all flex justify-center items-center gap-2">
                                <svg wire:loading.remove wire:target="guardarReagendamiento" class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                                <svg wire:loading wire:target="guardarReagendamiento" class="animate-spin size-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Guardar y notificar
                            </button>
                        @elseif(!$intentoCancelar)
                            <button wire:click="cerrarModal" class="w-full sm:w-auto px-5 py-2.5 text-xs font-black text-[#6B806D] dark:text-[#A5B8A5] hover:bg-[#F1F5E6] dark:hover:bg-[#202520] rounded-full transition-all border border-[#C2D5C0] dark:border-[#354235] bg-white dark:bg-[#161A16]">Cerrar</button>

                            @if(in_array($reservaSeleccionada->estado, ['Pendiente', 'Reagendada']))
                                <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Confirmada')" class="w-full sm:w-auto px-5 py-2.5 bg-[#508A45] text-white hover:bg-[#3E6B35] dark:bg-[#11991F] dark:hover:bg-[#0E7A18] text-xs font-black rounded-full shadow-md transition-all">Confirmar reserva</button>
                            @endif
                            
                            @if(in_array($reservaSeleccionada->estado, ['Confirmada', 'Reagendada', 'Pendiente']))
                                <button wire:click="intentarCancelar" class="w-full sm:w-auto px-5 py-2.5 bg-white dark:bg-[#161A16] border-2 border-red-100 dark:border-red-900/50 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 text-xs font-black rounded-full transition-all">Cancelar reserva</button>
                                <button wire:click="activarModoReagendar" class="w-full sm:w-auto px-5 py-2.5 bg-white dark:bg-[#161A16] border-2 border-yellow-100 dark:border-yellow-900/50 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 text-xs font-black rounded-full transition-all">Reagendar fechas</button>
                            @endif

                            @if($reservaSeleccionada->estado === 'Confirmada')
                                <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Completada')" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white hover:bg-blue-700 text-xs font-black rounded-full shadow-md transition-all">Marcar completada</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <button wire:click="$dispatch('abrirCalendario')" 
            class="fixed bottom-8 right-8 z-40 bg-[#508A45] text-white shadow-xl hover:bg-[#3E6B35] hover:scale-105 dark:bg-[#11991F] dark:hover:bg-[#0E7A18] dark:border-[#11991F] transition-all duration-300 rounded-full p-4 flex items-center justify-center group border border-[#508A45]">
        <svg class="size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4M4 11h16M11 15h2m-1-1v2" /></svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 font-black pl-0 group-hover:pl-3 text-xs uppercase tracking-widest">Ver calendario</span>
    </button>

    @livewire('emprendimiento.reserva.calendario-lateral')
</div>