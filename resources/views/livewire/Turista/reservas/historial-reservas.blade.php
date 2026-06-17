<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen relative font-sans">
    {{-- El inject debe ir ESTRICTAMENTE dentro del div principal en Livewire 3 --}}
    @inject('reservaService', 'App\Services\ReservaService')
    
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mis reservas</h1>
            <p class="text-sm text-gray-500 mt-1">Historial de tus solicitudes y servicios contratados.</p>
        </div>
        
        {{-- Selector personalizado técnico --}}
        <div class="w-full sm:w-auto flex flex-col gap-1">
            <label for="filtroEstado" class="w-fit pl-0.5 text-xs font-medium text-gray-500">Filtrar estado</label>
            <div class="relative">
                <select id="filtroEstado" wire:model.live="filtroEstado" class="w-full sm:w-56 appearance-none rounded-lg border border-gray-300 bg-white px-4 py-2 pr-10 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-not-allowed disabled:opacity-75 shadow-sm text-gray-900 font-medium cursor-pointer">
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

    {{-- TABLA DE RESERVAS ESTILO TÉCNICO --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-[#464646] font-bold text-xs  tracking-widest border-b border-gray-200">
                    <tr>
                        <th class="p-4 pl-6">Establecimiento</th>
                        <th class="p-4">Fecha solicitud</th>
                        <th class="p-4">Última modificación</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4 text-right">Total</th>
                        <th class="p-4 pr-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reservas as $reserva)
                        @php
                            $emprendimiento = $reserva->detalles->first()?->servicio?->categoriaPivot?->emprendimiento;
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 pl-6 font-bold text-gray-900">
                                {{ $emprendimiento->nombre ?? 'Local no registrado' }}
                            </td>
                            <td class="p-4 text-gray-500">{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-4 text-gray-500">{{ $reserva->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="p-4">
                                @if($reserva->estado === 'Pendiente')
                                    <span class="px-2.5 py-1 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-700 text-[11px] font-bold uppercase tracking-wider">Pendiente</span>
                                @elseif(in_array($reserva->estado, ['Confirmada', 'Completada']))
                                    <span class="px-2.5 py-1 rounded-md bg-green-50 border border-green-200 text-green-700 text-[11px] font-bold uppercase tracking-wider">{{ $reserva->estado }}</span>
                                @elseif(in_array($reserva->estado, ['Cancelada', 'Rechazada']))
                                    <span class="px-2.5 py-1 rounded-md bg-red-50 border border-red-200 text-red-700 text-[11px] font-bold uppercase tracking-wider">{{ $reserva->estado }}</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md bg-gray-50 border border-gray-200 text-gray-700 text-[11px] font-bold uppercase tracking-wider">{{ $reserva->estado }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-right font-bold text-gray-900">${{ number_format($reserva->precio_total, 2) }}</td>
                            <td class="p-4 pr-6">
                                <div class="flex items-center justify-center">
                                    <button type="button" wire:click="verDetalles({{ $reserva->id }})" class="text-xs font-bold text-[#00A344] bg-white border border-[#00A344] hover:bg-green-50 px-4 py-2 rounded-lg transition-colors outline-none shadow-sm flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#00A344]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detalles
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-500 font-medium text-sm">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012-2v2M7 7h10"></path></svg>
                                    No tienes reservas registradas con ese estado.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reservas->hasPages())
            <div class="p-4 border-t border-gray-200 bg-white">
                {{ $reservas->links('components.paginacion-turismo') }}
            </div>
        @endif
    </div>

    {{-- MODAL DE DETALLES --}}
    @if($mostrarModal && $reservaSeleccionada)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity backdrop-blur-sm" aria-hidden="true" wire:click="cerrarModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-gray-200">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-8 sm:pb-6">
                    <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="text-xl font-bold text-[#00A344] tracking-tight" id="modal-title">
                                    Detalles de la reserva 
                                </h3>
                                
                                @if($reservaSeleccionada->estado === 'Pendiente')
                                    <span class="px-2.5 py-1 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-700 text-[10px] font-bold uppercase tracking-wider">Pendiente</span>
                                @elseif(in_array($reservaSeleccionada->estado, ['Confirmada', 'Completada']))
                                    <span class="px-2.5 py-1 rounded-md bg-green-50 border border-green-200 text-green-700 text-[10px] font-bold uppercase tracking-wider">{{ $reservaSeleccionada->estado }}</span>
                                @elseif(in_array($reservaSeleccionada->estado, ['Cancelada', 'Rechazada']))
                                    <span class="px-2.5 py-1 rounded-md bg-red-50 border border-red-200 text-red-700 text-[10px] font-bold uppercase tracking-wider">{{ $reservaSeleccionada->estado }}</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md bg-gray-50 border border-gray-200 text-gray-700 text-[10px] font-bold uppercase tracking-wider">{{ $reservaSeleccionada->estado }}</span>
                                @endif
                            </div>
                            @php
                                $emprendimientoModal = $reservaSeleccionada->detalles->first()?->servicio?->categoriaPivot?->emprendimiento;
                            @endphp
                            <p class="text-sm text-gray-500 mt-2">Establecimiento: <span class="font-semibold text-gray-900">{{ $emprendimientoModal->nombre ?? 'Local no registrado' }}</span></p>
                        </div>
                        <button wire:click="cerrarModal" class="text-gray-400 hover:text-[#00A344] transition-colors outline-none bg-gray-50 hover:bg-green-50 p-1.5 rounded-full">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="space-y-3 max-h-[50vh] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($reservaSeleccionada->detalles as $detalle)
                            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                                <h4 class="font-bold text-gray-900 text-sm mb-3">{{ $detalle->servicio->nombre ?? 'Servicio eliminado' }}</h4>
                                <div class="grid grid-cols-2 gap-4 text-xs text-gray-600">
                                    <div>
                                        <span class="font-medium text-[10px] text-[#00A344] uppercase tracking-widest block mb-1">Fechas</span> 
                                        <span class="font-semibold text-gray-800">
                                            {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }} {{ $detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio ? ' al ' . \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') : '' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-[10px] text-[#00A344] uppercase tracking-widest block mb-1">Cantidad</span> 
                                        <span class="font-semibold text-gray-800">{{ $detalle->cantidad }}</span>
                                    </div>
                                    @if($detalle->hora_llegada)
                                        <div>
                                            <span class="font-medium text-[10px] text-[#00A344] uppercase tracking-widest block mb-1">Hora</span> 
                                            <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') }}</span>
                                        </div>
                                    @endif
                                    <div class="text-right col-span-2 sm:col-span-1 sm:col-start-2">
                                        <span class="font-medium text-[10px] text-[#00A344] uppercase tracking-widest block mb-1">Total Parcial</span> 
                                        <span class="font-bold text-gray-900 text-sm">${{ number_format($detalle->subtotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- MOTIVO DE CANCELACIÓN (Si aplica) --}}
                    @if(in_array($reservaSeleccionada->estado, ['Cancelada', 'Rechazada']) && !empty($reservaSeleccionada->motivo_cancelacion))
                        <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100">
                            <span class="block text-[10px] font-bold text-red-800 uppercase tracking-widest mb-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Motivo de cancelación
                            </span>
                            <p class="text-sm text-red-900 font-medium">{{ $reservaSeleccionada->motivo_cancelacion }}</p>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-between items-end bg-gray-50 p-5 rounded-xl border border-gray-200">
                        <span class="text-xs font-bold text-[#00A344] uppercase tracking-widest">Total de la reserva</span>
                        <span class="text-3xl font-bold text-gray-900 tracking-tight">${{ number_format($reservaSeleccionada->precio_total, 2) }}</span>
                    </div>

                    @if($reservaService->esCancelablePorTurista($reservaSeleccionada))
                        <div class="mt-6 border-t border-gray-100 pt-6">
                            @if(!$intentoCancelar)
                                <button type="button" wire:click="intentarCancelar" class="w-full sm:w-auto px-6 py-2.5 rounded-lg border border-red-200 bg-white text-red-600 font-bold text-sm hover:bg-red-50 transition-colors outline-none shadow-sm">
                                    Cancelar Reserva
                                </button>
                            @else
                                <div class="bg-red-50 p-5 rounded-xl border border-red-100 shadow-sm">
                                    <label class="block text-[10px] font-bold text-red-800 uppercase tracking-widest mb-2">Por favor indica el motivo de cancelación</label>
                                    
                                    <x-textarea-form label="Motivo de la cancelación" id="motivoCancelacion" wire:model="motivoCancelacion" placeholder="Ej: Hubo un cambio en mis planes de viaje..." rows="3" class="bg-white border-red-200 focus:border-red-500 focus:ring-red-500 rounded-lg text-sm text-gray-900" />
                                    
                                    @error('motivoCancelacion') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                                    
                                    <div class="flex gap-3 mt-4 justify-end">
                                        <button type="button" wire:click="$set('intentoCancelar', false)" class="px-5 py-2 rounded-lg border border-[#00A344] bg-white text-[#00A344] font-bold text-xs hover:bg-green-50 transition-colors outline-none shadow-sm">
                                            Atrás
                                        </button>
                                        <button type="button" wire:click="confirmarCancelacion" class="px-5 py-2 rounded-lg bg-red-600 text-white font-bold text-xs hover:bg-red-700 transition shadow-sm outline-none">
                                            Confirmar Cancelación
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        @if(!in_array($reservaSeleccionada->estado, ['Completada', 'Cancelada', 'Rechazada']))
                            <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200 text-center">
                                <span class="text-xs font-semibold text-gray-500">
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

    {{-- SISTEMA DE NOTIFICACIONES FLOTANTES --}}
    <div x-data="{
            notifications: [],
            displayDuration: 8000,
            addNotification({ variant = 'info', title = null, message = null}) {
                const id = Date.now()
                const notification = { id, variant, title, message }
                if (this.notifications.length >= 20) {
                    this.notifications.splice(0, this.notifications.length - 19)
                }
                this.notifications.push(notification)
            },
            removeNotification(id) {
                setTimeout(() => {
                    this.notifications = this.notifications.filter((notification) => notification.id !== id)
                }, 400);
            },
        }" 
        x-on:notificar.window="
            let n = $event.detail[0] || $event.detail;
            addNotification({
                variant: n.tipo === 'error' ? 'danger' : (n.tipo === 'warning' ? 'warning' : (n.tipo === 'info' ? 'info' : 'success')),
                title: n.tipo === 'error' ? 'Error' : (n.tipo === 'warning' ? 'Atención' : 'Notificación'),
                message: n.mensaje
            });
        "
        class="group pointer-events-none fixed inset-x-4 top-4 z-[300] flex max-w-full flex-col gap-2 md:bottom-auto md:left-[unset] md:right-4 md:top-4 md:max-w-sm">
        
        <template x-for="(notification, index) in notifications" x-bind:key="notification.id">
            <div>
                <template x-if="notification.variant !== 'auth'">
                    <div x-data="{ isVisible: false, timeout: null }" x-cloak x-show="isVisible" class="pointer-events-auto relative rounded-xl border bg-white shadow-lg" :class="{'border-red-400': notification.variant === 'danger', 'border-[#00D65B]': notification.variant === 'success', 'border-yellow-400': notification.variant === 'warning', 'border-blue-400': notification.variant === 'info'}" role="alert" x-on:pause-auto-dismiss.window="clearTimeout(timeout)" x-on:resume-auto-dismiss.window=" timeout = setTimeout(() => {(isVisible = false), removeNotification(notification.id) }, displayDuration)" x-init="$nextTick(() => { isVisible = true }), (timeout = setTimeout(() => { isVisible = false, removeNotification(notification.id)}, displayDuration))" x-transition:enter="transition duration-300 ease-out" x-transition:enter-end="translate-y-0 opacity-100" x-transition:enter-start="-translate-y-4 opacity-0" x-transition:leave="transition duration-200 ease-in" x-transition:leave-end="translate-x-8 opacity-0" x-transition:leave-start="translate-x-0 opacity-100">
                        <div class="flex w-full items-center gap-2.5 rounded-xl p-3 transition-all duration-300" :class="{'bg-red-50/50': notification.variant === 'danger', 'bg-green-50/50': notification.variant === 'success', 'bg-yellow-50/50': notification.variant === 'warning', 'bg-blue-50/50': notification.variant === 'info'}">
                            <div class="rounded-full p-1" :class="{'bg-red-100 text-red-600': notification.variant === 'danger', 'bg-green-100 text-[#00A344]': notification.variant === 'success', 'bg-yellow-100 text-yellow-600': notification.variant === 'warning', 'bg-blue-100 text-blue-600': notification.variant === 'info'}">
                                <template x-if="notification.variant === 'success'">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                                </template>
                                <template x-if="notification.variant === 'danger' || notification.variant === 'warning'">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                                </template>
                                <template x-if="notification.variant === 'info'">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" /></svg>
                                </template>
                            </div>
                            <div class="flex flex-col w-full">
                                <h3 class="text-[11px] font-bold text-gray-800 uppercase tracking-wide" x-text="notification.title"></h3>
                                <p class="text-xs text-gray-600 mt-0.5" x-text="notification.message"></p>
                            </div>
                            <button type="button" class="ml-auto text-gray-400 hover:text-gray-600" aria-label="dismiss" x-on:click="(isVisible = false), setTimeout(() => { removeNotification(notification.id) }, 400)">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>

    {{-- LÓGICA PARA DISPARAR MENSAJES GUARDADOS EN SESIÓN (Ej: Cuando viene del Checkout) --}}
    @if(session()->has('mensaje_exito'))
        <div x-data x-init="
            $nextTick(() => {
                $dispatch('notificar', { tipo: 'success', mensaje: '{{ session('mensaje_exito') }}' });
            });
        "></div>
    @endif
    
    @if(session()->has('error'))
        <div x-data x-init="
            $nextTick(() => {
                $dispatch('notificar', { tipo: 'error', mensaje: '{{ session('error') }}' });
            });
        "></div>
    @endif

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    </style>
</div>