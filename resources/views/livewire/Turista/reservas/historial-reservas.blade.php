@inject('reservaService', 'App\Services\ReservaService')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">
    
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-black text-[#06281E] uppercase tracking-wide">Mis reservas</h1>
        
        {{-- Selector personalizado corregido visualmente --}}
        <div class="w-full sm:w-auto flex flex-col gap-1">
            <label for="filtroEstado" class="w-fit pl-0.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Filtrar estado</label>
            <div class="relative">
                <select id="filtroEstado" wire:model.live="filtroEstado" class="w-full sm:w-56 appearance-none rounded-xl border border-gray-200 bg-white px-4 py-2 pr-10 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] disabled:cursor-not-allowed disabled:opacity-75 shadow-sm text-gray-800">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmada">Confirmada</option>
                    <option value="Completada">Completada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute pointer-events-none right-3 top-1/2 -translate-y-1/2 size-5 text-gray-500">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 font-bold uppercase text-[10px] tracking-widest border-b border-gray-200">
                    <tr>
                        <th class="p-5">Establecimiento</th>
                        <th class="p-5">Fecha solicitud</th>
                        <th class="p-5">Última modificación</th>
                        <th class="p-5">Estado</th>
                        <th class="p-5 text-right">Total</th>
                        <th class="p-5 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($reservas as $reserva)
                        @php
                            $emprendimiento = $reserva->detalles->first()?->servicio?->categoriaPivot?->emprendimiento;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-5 font-bold text-[#00A344]">
                                {{ $emprendimiento->nombre ?? 'Local no registrado' }}
                            </td>
                            <td class="p-5 text-gray-500">{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-5 text-gray-500">{{ $reserva->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="p-5">
                                @if($reserva->estado === 'Pendiente')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-[10px] font-black uppercase tracking-wider shadow-sm">Pendiente</span>
                                @elseif(in_array($reserva->estado, ['Confirmada', 'Completada']))
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-black uppercase tracking-wider shadow-sm">{{ $reserva->estado }}</span>
                                @elseif(in_array($reserva->estado, ['Cancelada', 'Rechazada']))
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-[10px] font-black uppercase tracking-wider shadow-sm">{{ $reserva->estado }}</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-[10px] font-black uppercase tracking-wider shadow-sm">{{ $reserva->estado }}</span>
                                @endif
                            </td>
                            <td class="p-5 text-right font-black text-[#00D65B] text-base">${{ number_format($reserva->precio_total, 2) }}</td>
                            <td class="p-5">
                                <div class="flex items-center justify-center gap-4">
                                    {{-- El botón Cancelar fue removido de aquí, solo queda Ver detalle --}}
                                    <button type="button" wire:click="verDetalles({{ $reserva->id }})" class="text-[#00A344] hover:text-[#06281E] font-bold text-xs uppercase tracking-widest transition outline-none">
                                        Ver detalle
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-400 font-bold text-sm">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012-2v2M7 7h10"></path></svg>
                                    No tienes reservas registradas con ese estado.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reservas->hasPages())
            <div class="p-5 border-t border-gray-100 bg-white">
                {{ $reservas->links('components.paginacion-turismo') }}
            </div>
        @endif
    </div>

    {{-- MODAL DE DETALLES --}}
    @if($mostrarModal && $reservaSeleccionada)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true" wire:click="cerrarModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-200">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-6">
                    <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="text-xl font-black text-[#06281E] uppercase tracking-wide" id="modal-title">
                                    Detalles de Reserva #{{ $reservaSeleccionada->id }}
                                </h3>
                                {{-- Badge de estado en el modal --}}
                                @if($reservaSeleccionada->estado === 'Pendiente')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-[10px] font-black uppercase tracking-wider shadow-sm">Pendiente</span>
                                @elseif(in_array($reservaSeleccionada->estado, ['Confirmada', 'Completada']))
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-black uppercase tracking-wider shadow-sm">{{ $reservaSeleccionada->estado }}</span>
                                @elseif(in_array($reservaSeleccionada->estado, ['Cancelada', 'Rechazada']))
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-[10px] font-black uppercase tracking-wider shadow-sm">{{ $reservaSeleccionada->estado }}</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-[10px] font-black uppercase tracking-wider shadow-sm">{{ $reservaSeleccionada->estado }}</span>
                                @endif
                            </div>
                            @php
                                $emprendimientoModal = $reservaSeleccionada->detalles->first()?->servicio?->categoriaPivot?->emprendimiento;
                            @endphp
                            <p class="text-sm text-gray-500 mt-2">Establecimiento: <span class="font-bold text-[#00A344]">{{ $emprendimientoModal->nombre ?? 'Local no registrado' }}</span></p>
                        </div>
                        <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-600 outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2">
                        @foreach($reservaSeleccionada->detalles as $detalle)
                            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                <h4 class="font-bold text-gray-900 text-sm mb-3">{{ $detalle->servicio->nombre ?? 'Servicio eliminado' }}</h4>
                                <div class="grid grid-cols-2 gap-4 text-xs text-gray-600">
                                    <div>
                                        <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400 block mb-1">Fechas</span> 
                                        {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }} {{ $detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio ? ' al ' . \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') : '' }}
                                    </div>
                                    <div>
                                        <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400 block mb-1">Cantidad</span> 
                                        {{ $detalle->cantidad }}
                                    </div>
                                    @if($detalle->hora_llegada)
                                        <div>
                                            <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400 block mb-1">Hora</span> 
                                            {{ \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') }}
                                        </div>
                                    @endif
                                    <div class="text-right col-span-2 sm:col-span-1 sm:col-start-2">
                                        <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400 block mb-1">Total Parcial</span> 
                                        <span class="font-black text-[#00D65B] text-sm">${{ number_format($detalle->subtotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-between items-end bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total de la reserva</span>
                        <span class="text-3xl font-black text-[#06281E]">${{ number_format($reservaSeleccionada->precio_total, 2) }}</span>
                    </div>

                    {{-- Flujo de Cancelación con validación de 24h --}}
                    @if($reservaService->esCancelablePorTurista($reservaSeleccionada))
                        <div class="mt-6 border-t border-gray-100 pt-6">
                            @if(!$intentoCancelar)
                                <button type="button" wire:click="intentarCancelar" class="w-full sm:w-auto px-6 py-3 rounded-xl border-2 border-red-100 text-red-600 font-black uppercase text-xs tracking-widest hover:bg-red-50 hover:border-red-200 transition outline-none">
                                    Cancelar Reserva
                                </button>
                            @else
                                <div class="bg-red-50 p-5 rounded-2xl border border-red-100">
                                    <label class="block text-[10px] font-bold text-red-800 uppercase tracking-widest mb-3">Motivo de cancelación</label>
                                    
                                    <x-textarea-form wire:model="motivoCancelacion" placeholder="Ej: Hubo un cambio en mis planes de viaje..." rows="3" />
                                    
                                    @error('motivoCancelacion') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                    
                                    <div class="flex gap-3 mt-4 justify-end">
                                        <button type="button" wire:click="$set('intentoCancelar', false)" class="px-5 py-2 rounded-xl text-gray-600 font-bold text-xs uppercase tracking-widest hover:bg-white transition outline-none">
                                            Atrás
                                        </button>
                                        <button type="button" wire:click="confirmarCancelacion" class="px-5 py-2 rounded-xl bg-red-600 text-white font-black text-xs uppercase tracking-widest hover:bg-red-700 transition shadow-sm outline-none">
                                            Confirmar Cancelación
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        @if(!in_array($reservaSeleccionada->estado, ['Completada', 'Cancelada', 'Rechazada']))
                            <div class="mt-6 p-4 bg-yellow-50 rounded-2xl border border-yellow-100 text-center">
                                <span class="text-xs font-bold text-yellow-700 uppercase tracking-widest">
                                    Faltan menos de 24 horas para el servicio. Ya no es posible cancelar.
                                </span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>