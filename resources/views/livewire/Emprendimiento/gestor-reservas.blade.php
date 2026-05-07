<div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6 relative">
    
    {{-- Encabezado y Filtros --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                <svg class="size-8 text-[#1a4031] dark:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Gestión de Reservas
            </h1>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-wider font-semibold">Administra las solicitudes de tus clientes</p>
        </div>

        <div class="w-full md:w-auto flex flex-col md:flex-row items-center gap-3">
            <div class="flex items-center gap-2 w-full md:w-auto">
                <label for="filtroEstado" class="text-sm font-bold text-gray-700 dark:text-gray-300 hidden md:block">Filtrar:</label>
                <select wire:model.live="filtroEstado" id="filtroEstado" class="w-full md:w-48 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-[#1a4031] focus:border-[#1a4031] block p-2.5 shadow-sm transition">
                    <option value="">Todas las reservas</option>
                    <option value="Pendiente">🟡 Pendientes</option>
                    <option value="Confirmada">🟢 Confirmadas</option>
                    <option value="Cancelada">🔴 Canceladas / Rechazadas</option>
                </select>
            </div>

            <a href="{{ route('emprendimiento.reservas.crear') }}" wire:navigate class="w-full md:w-auto flex items-center justify-center gap-2 bg-[#1a4031] hover:bg-[#132f24] text-white px-4 py-2.5 rounded-xl text-sm font-bold transition shadow-md">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                Agendar Reserva
            </a>
        </div>
    </div>

    {{-- Lista de Reservas --}}
    <div wire:loading.remove wire:target="filtroEstado" class="flex flex-col gap-5">
        @if($this->reservas->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-10 border-2 border-dashed border-gray-200 dark:border-gray-700 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 dark:bg-gray-900 mb-4">
                    <svg class="size-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 dark:text-white mb-1">No hay reservas</h3>
                <p class="text-sm text-gray-500">No se encontraron registros que coincidan con tu búsqueda.</p>
            </div>
        @else
            @foreach($this->reservas as $reserva)
                <div wire:key="reserva-{{ $reserva->id }}" class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-0 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col md:flex-row">
                    
                    <div class="w-full md:w-2 h-2 md:h-auto shrink-0 
                        @if($reserva->estado === 'Pendiente') bg-yellow-400 
                        @elseif($reserva->estado === 'Confirmada') bg-green-500 
                        @else bg-red-500 @endif">
                    </div>

                    <div class="p-5 md:p-6 flex-1 flex flex-col md:flex-row gap-6 justify-between items-start md:items-center">
                        <div class="w-full md:w-auto flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg border 
                                    @if($reserva->estado === 'Pendiente') bg-yellow-50 text-yellow-700 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800/50
                                    @elseif($reserva->estado === 'Confirmada') bg-green-50 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800/50
                                    @else bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800/50 @endif">
                                    {{ $reserva->estado }}
                                </span>
                                <span class="text-xs font-bold text-gray-400">Creada: {{ $reserva->created_at->format('d/m/Y') }}</span>
                            </div>
                            
                            <h3 class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="size-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                {{ $reserva->turista->name ?? 'Turista Anónimo' }}
                            </h3>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium flex items-center gap-2">
                                <svg class="size-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                <span>{{ $reserva->detalles->first()->servicio->nombre ?? 'Sin servicios' }}</span>
                                @if($reserva->detalles->count() > 1)
                                    <span class="text-blue-600 dark:text-blue-400 font-bold">(+{{ $reserva->detalles->count() - 1 }} adicionales)</span>
                                @endif
                            </p>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full md:w-auto bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Primera Fecha:</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $reserva->detalles->first()?->fecha_inicio->format('d/m/Y') ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Servicios:</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $reserva->detalles->count() }} ítem(s)
                                </span>
                            </div>
                            <div class="flex flex-col md:col-span-1 col-span-2 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-700 pt-2 md:pt-0 md:pl-4">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total:</span>
                                <span class="text-lg font-black text-[#1a4031] dark:text-green-400">
                                    ${{ number_format($reserva->precio_total, 2) }}
                                </span>
                            </div>
                        </div>

                        <div class="w-full md:w-auto shrink-0 flex items-center justify-center">
                            <button wire:click="verDetalles({{ $reserva->id }})" class="w-full md:w-auto px-4 py-2.5 bg-white dark:bg-gray-800 border-2 border-[#1a4031] text-[#1a4031] dark:border-green-500 dark:text-green-500 hover:bg-[#1a4031] hover:text-white dark:hover:bg-green-500 dark:hover:text-gray-900 rounded-xl text-sm font-bold transition">
                                Ver Detalles & Acciones
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
            
            {{-- Controles de Paginación de Laravel/Livewire --}}
            <div class="mt-6">
                {{ $this->reservas->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL DE DETALLES --}}
    @if($mostrarModal && $reservaSeleccionada)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-3xl overflow-hidden animate-in fade-in zoom-in duration-200">
                
                <div class="flex justify-between items-center p-6 border-b border-gray-100 dark:border-zinc-800">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Reserva #{{ str_pad($reservaSeleccionada->id, 5, '0', STR_PAD_LEFT) }}</h3>
                    <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-600 transition"><svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                </div>

                <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto">
                    {{-- Datos del Turista --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 dark:bg-zinc-800 p-4 rounded-xl">
                        <div><span class="text-xs text-gray-500 uppercase block">Turista</span> <strong>{{ $reservaSeleccionada->turista->name }}</strong></div>
                        <div><span class="text-xs text-gray-500 uppercase block">Cédula</span> <strong>{{ $reservaSeleccionada->turista->cedula ?? 'N/A' }}</strong></div>
                    </div>

                    {{-- DESGLOSE DE SERVICIOS (Carrito) --}}
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-3 tracking-widest">Servicios Contratados</h4>
                        <div class="border rounded-xl overflow-hidden dark:border-zinc-700">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-zinc-400 text-[10px] uppercase font-black">
                                    <tr>
                                        <th class="px-4 py-3">Servicio</th>
                                        <th class="px-4 py-3 text-center">Fecha</th>
                                        <th class="px-4 py-3 text-center">Cant/Pax</th>
                                        <th class="px-4 py-3 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y dark:divide-zinc-700">
                                    @foreach($reservaSeleccionada->detalles as $item)
                                        <tr class="dark:text-zinc-300">
                                            <td class="px-4 py-3 font-bold">{{ $item->servicio->nombre }}</td>
                                            <td class="px-4 py-3 text-center">{{ $item->fecha_inicio->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 text-center">{{ $item->cantidad }}</td>
                                            <td class="px-4 py-3 text-right font-black">${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-zinc-800/50">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-right font-bold uppercase text-xs">Total General:</td>
                                        <td class="px-4 py-3 text-right font-black text-[#1a4031] dark:text-green-500 text-lg">${{ number_format($reservaSeleccionada->precio_total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Gestión de Motivo (Si es cancelación) --}}
                    @if(in_array($reservaSeleccionada->estado, ['Pendiente', 'Confirmada']))
                        <div class="mt-4">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Motivo para Rechazo o Cancelación</label>
                            <textarea wire:model="motivoCancelacion" rows="2" class="w-full rounded-xl border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 text-sm focus:ring-red-500 focus:border-red-500" placeholder="Ej: No hay disponibilidad de fecha..."></textarea>
                        </div>
                    @endif
                </div>

                <div class="p-6 bg-gray-50 dark:bg-zinc-800 border-t border-gray-200 dark:border-zinc-700 flex flex-wrap gap-3 justify-end">
                    <button wire:click="cerrarModal" class="px-4 py-2 text-sm font-bold text-gray-600 rounded-xl transition">Cerrar</button>
                    @if($reservaSeleccionada->estado === 'Pendiente')
                        <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Rechazada')" class="px-4 py-2 bg-red-100 text-red-700 text-sm font-bold rounded-xl">Rechazar</button>
                        <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Confirmada')" class="px-6 py-2 bg-[#1a4031] text-white text-sm font-bold rounded-xl shadow-lg">Confirmar Reserva</button>
                    @elseif($reservaSeleccionada->estado === 'Confirmada')
                        <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Cancelada')" wire:confirm="¿Seguro que deseas cancelar esta reserva?" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-xl">Cancelar Reserva</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>