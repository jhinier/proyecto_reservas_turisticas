<div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6 relative text-[#06281E] dark:text-gray-200">
    
    {{-- CABECERA PRINCIPAL --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 dark:border-white/10 pb-6">
        <div>
            <h1 class="text-3xl font-black text-[#06281E] dark:text-white tracking-tight flex items-center gap-3">
                <svg class="size-8 text-[#00A344] dark:text-[#00D65B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Gestión de reservas
                <div class="hidden md:flex items-center gap-1.5 px-2 py-1 rounded-full bg-[#00A344]/10 border border-[#00A344]/20 text-[9px] text-[#00A344] dark:text-[#00D65B] uppercase tracking-widest font-black ml-1" title="Sincronización automática activada">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00A344] dark:bg-[#00D65B] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#00A344] dark:bg-[#00D65B]"></span>
                    </span>
                    En vivo
                </div>
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
    <div wire:poll.10s class="relative overflow-hidden w-full overflow-x-auto rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-sm transition-all duration-300">
        <div wire:loading.flex wire:target="filtroCategoria, filtroEstado, buscarCedula" class="absolute inset-0 bg-white/60 dark:bg-zinc-900/80 backdrop-blur-sm z-10 flex items-center justify-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#00A344]"></div>
        </div>
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
            <tbody wire:loading.class="opacity-40" class="divide-y divide-gray-100 dark:divide-zinc-800 relative transition-opacity duration-300">
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

    {{-- LLAMADA AL MODAL EXTRAÍDO --}}
    @include('livewire.emprendimiento.reserva.modal-detalle-reserva')
    
    <button wire:click="$dispatch('abrirCalendario')" 
            class="fixed bottom-8 right-8 z-40 bg-[#00D65B] text-[#06281E] shadow-xl hover:bg-[#00c052] hover:scale-105 dark:bg-[#00D65B] dark:text-[#06281E] transition-all duration-300 rounded-full p-4 flex items-center justify-center group outline-none">
        <svg class="size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4M4 11h16M11 15h2m-1-1v2" /></svg>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-500 font-bold pl-0 group-hover:pl-3 text-xs uppercase tracking-widest">Ver calendario</span>
    </button>

    @livewire('emprendimiento.reserva.calendario-lateral')
</div>