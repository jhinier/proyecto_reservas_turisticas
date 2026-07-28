@if($mostrarModal && $reservaSeleccionada)
    @php
        $primerDetalle = $reservaSeleccionada->detalles->sortBy('fecha_inicio')->first();
        $yaPasoFecha = false;
        
        if ($primerDetalle) {
            $fechaString = \Carbon\Carbon::parse($primerDetalle->fecha_inicio)->format('Y-m-d');
            $horaString = $primerDetalle->hora_llegada ? \Carbon\Carbon::parse($primerDetalle->hora_llegada)->format('H:i:s') : '00:00:00';
            $fechaHoraInicio = \Carbon\Carbon::parse($fechaString . ' ' . $horaString);
            $yaPasoFecha = now()->greaterThanOrEqualTo($fechaHoraInicio);
        }
    @endphp

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 backdrop-blur-sm p-4 font-sans">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl flex flex-col max-h-[95vh] overflow-hidden border-2 border-[#00A344]">
            
            {{-- Cabecera --}}
            <div class="relative p-6 md:px-8 md:py-6 border-b border-gray-300 flex justify-between items-start bg-white">
                <div>
                    <h2 class="text-[22px] font-black text-gray-900 tracking-tight">
                        {{ $modoReagendar ? 'Modificar fechas de servicio' : 'Resumen de la reserva' }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Revisa los detalles antes de confirmar.</p>
                </div>
                
                <div class="flex items-center gap-6 pr-8">
                    <div class="text-right">
                        <p class="text-xs text-gray-500 mb-0.5">Estado</p>
                        @php
                            $colorEstado = match($reservaSeleccionada->estado) {
                                'Confirmada' => 'text-green-700 bg-green-100',
                                'Completada' => 'text-blue-700 bg-blue-100',
                                'Pago en revisión' => 'text-indigo-700 bg-indigo-100',
                                'Reagendada' => 'text-amber-700 bg-amber-100',
                                'Pendiente'  => 'text-orange-700 bg-orange-100',
                                'Cancelada', 'Rechazada' => 'text-red-700 bg-red-100',
                                default => 'text-gray-700 bg-gray-100'
                            };
                        @endphp
                        <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider {{ $colorEstado }}">
                            {{ $reservaSeleccionada->estado }}
                        </span>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-xs text-gray-500 mb-0.5">Fecha de emisión</p>
                        <p class="text-sm font-bold text-gray-900">{{ $reservaSeleccionada->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <button wire:click="cerrarModal" class="absolute top-6 right-6 text-gray-400 hover:text-gray-900 transition outline-none">
                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="p-6 md:p-8 space-y-8 overflow-y-auto flex-1 bg-white">
                
                @error('error_general')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <p class="text-sm text-red-700 font-bold">{{ $message }}</p>
                        </div>
                    </div>
                @enderror

                {{-- Datos del cliente --}}
                <div>
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Datos del cliente</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-[13px] text-gray-500 mb-1">Nombre completo</p>
                            <p class="text-[15px] font-bold text-gray-900 leading-tight">{{ $reservaSeleccionada->turista->name }} {{ $reservaSeleccionada->turista->apellidos }}</p>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 mb-1">Identificación</p>
                            <p class="text-[15px] font-bold text-gray-900 leading-tight">{{ $reservaSeleccionada->turista->cedula }}</p>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 mb-1">Correo electrónico</p>
                            <p class="text-[15px] font-bold text-gray-900 leading-tight break-all">{{ $reservaSeleccionada->turista->email }}</p>
                        </div>
                        <div>
                            <p class="text-[13px] text-gray-500 mb-1">Teléfono</p>
                            <p class="text-[15px] font-bold text-gray-900 leading-tight">{{ $reservaSeleccionada->turista->telefono ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-300">

                {{-- Detalle de los servicios --}}
                <div>
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Detalle de los servicios</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="border-b border-gray-300 text-gray-500">
                                    <th class="pb-3 font-normal min-w-[220px]">Descripción</th>
                                    <th class="pb-3 font-normal text-center">Precio unitario</th>
                                    <th class="pb-3 font-normal text-center">Detalles</th>
                                    <th class="pb-3 font-normal text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                @foreach($reservaSeleccionada->detalles as $item)
                                    @php
                                        $nombreCat = strtolower($item->servicio?->tipoServicio?->nombre ?? '');
                                        $esHospedaje = str_contains($nombreCat, 'hospedaje') || str_contains($nombreCat, 'habitaci');
                                        
                                        $dias = 1;
                                        if ($item->fecha_inicio && $item->fecha_fin) {
                                            $dias = \Carbon\Carbon::parse($item->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($item->fecha_fin)) + 1;
                                        }

                                        $precioUnitario = $item->precio_unitario ?? $item->servicio?->precio ?? ($item->subtotal / max(1, $item->cantidad));
                                    @endphp
                                    <tr>
                                        <td class="py-5 align-top">
                                            <p class="font-bold text-gray-900 text-[15px]">{{ $item->servicio?->nombre ?? 'Servicio no disponible' }}</p>
                                            
                                            @if(!$modoReagendar)
                                                <p class="text-[13px] text-gray-500 mt-1">
                                                    {{ $item->fecha_inicio->format('d/m/Y') }} - {{ $item->fecha_fin->format('d/m/Y') }}
                                                    @if($item->hora_llegada) | {{ \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') }} @endif
                                                </p>
                                            @else
                                                <div class="mt-3 grid grid-cols-2 gap-3 bg-gray-50 p-3 rounded-lg border border-gray-300">
                                                    <div>
                                                        <span class="text-[11px] font-bold text-gray-500 uppercase block mb-1">Inicia</span>
                                                        <input type="date" wire:model.defer="nuevasFechas.{{ $item->id }}.inicio"
                                                               @if(str_contains(strtolower($item->servicio?->tipoServicio?->nombre ?? ''), 'paquete'))
                                                                   min="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}"
                                                                   oninput="const fecha = new Date(this.value); if (fecha.getDay() === 0 || fecha.getDay() === 1) { this.value=''; }"
                                                               @endif
                                                               class="w-full rounded border-gray-300 bg-white text-xs py-1.5 font-bold text-gray-900 focus:ring-1 focus:ring-gray-900 outline-none">
                                                        @error('nuevasFechas.'.$item->id.'.inicio') <span class="text-red-500 text-[10px] leading-tight block mt-1 font-bold">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div>
                                                        <span class="text-[11px] font-bold text-gray-500 uppercase block mb-1">Termina</span>
                                                        <input type="date" wire:model.defer="nuevasFechas.{{ $item->id }}.fin"
                                                               @if(str_contains(strtolower($item->servicio?->tipoServicio?->nombre ?? ''), 'paquete'))
                                                                   min="{{ \Carbon\Carbon::now()->addDays(3)->format('Y-m-d') }}"
                                                                   oninput="const fecha = new Date(this.value); if (fecha.getDay() === 0 || fecha.getDay() === 1) { this.value=''; }"
                                                               @endif
                                                               class="w-full rounded border-gray-300 bg-white text-xs py-1.5 font-bold text-gray-900 focus:ring-1 focus:ring-gray-900 outline-none">
                                                        @error('nuevasFechas.'.$item->id.'.fin') <span class="text-red-500 text-[10px] leading-tight block mt-1 font-bold">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-span-2">
                                                        <span class="text-[11px] font-bold text-gray-500 uppercase block mb-1">Hora de llegada</span>
                                                        <input type="time" wire:model.defer="nuevasFechas.{{ $item->id }}.hora_llegada" class="w-full rounded border-gray-300 bg-white text-xs py-1.5 font-bold text-gray-900 focus:ring-1 focus:ring-gray-900 outline-none">
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-5 align-top text-center font-bold text-gray-900 text-[15px]">
                                            ${{ number_format($precioUnitario, 2) }}
                                        </td>
                                        <td class="py-5 align-top text-center text-gray-600 text-[13px] space-y-1">
                                            @if(str_contains($nombreCat, 'hospedaje') || str_contains($nombreCat, 'habitaci'))
                                                <p>Habitaciones: {{ $item->cantidad }}</p>
                                            @elseif(str_contains($nombreCat, 'paquete'))
                                                <p>Paquetes: {{ $item->cantidad }}</p>
                                            @elseif(str_contains($nombreCat, 'guianza') || str_contains($nombreCat, 'guía'))
                                                <p>Guías: {{ $item->cantidad }}</p>
                                            @elseif(str_contains($nombreCat, 'alquiler') || str_contains($nombreCat, 'equipo'))
                                                <p>Equipos: {{ $item->cantidad }}</p>
                                            @elseif(str_contains($nombreCat, 'aliment'))
                                                <p>Platos: {{ $item->cantidad }}</p>
                                            @else
                                                <p>Cant: {{ $item->cantidad }}</p>
                                            @endif
                                            
                                            @if($esHospedaje)
                                                @php $huespedes = $item->numero_personas ?? $item->numero_huespedes ?? $item->huespedes ?? $item->cantidad_personas ?? null; @endphp
                                                @if($huespedes !== null)
                                                    <p>Huéspedes: {{ $huespedes }}</p>
                                                @endif
                                            @endif

                                            @if($dias > 0)
                                                <p>Días: {{ $dias }}</p>
                                            @endif
                                        </td>
                                        <td class="py-5 align-top text-right font-black text-gray-900 text-[16px]">
                                            ${{ number_format($item->subtotal, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($reservaSeleccionada->estado === 'Cancelada' && !empty($reservaSeleccionada->motivo_cancelacion))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h5 class="text-xs font-bold text-red-600 mb-1">Motivo de la cancelación</h5>
                        <p class="text-[13px] text-red-800">{{ $reservaSeleccionada->motivo_cancelacion }}</p>
                    </div>
                @endif

                <div class="flex justify-end pt-4">
                    <div class="flex items-center gap-6">
                        <span class="text-sm font-bold text-gray-500">Total pagado</span>
                        <span class="text-2xl font-black text-gray-900">${{ number_format($reservaSeleccionada->precio_total, 2) }}</span>
                    </div>
                </div>

                {{-- Zona de revisión de comprobante --}}
                @if($reservaSeleccionada->estado === 'Pago en revisión' && !empty($reservaSeleccionada->comprobante_pago))
                    <div class="mt-6 p-5 bg-blue-50 rounded-xl border border-blue-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="text-[11px] font-bold text-blue-800 uppercase tracking-widest mb-1">Comprobante de pago</h4>
                            <p class="text-xs text-blue-600">El turista reportó el pago para esta reserva.</p>
                        </div>
                        
                        <a href="{{ asset('storage/' . $reservaSeleccionada->comprobante_pago) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-700 border border-blue-300 font-bold text-xs rounded-lg hover:bg-blue-100 transition shadow-sm outline-none whitespace-nowrap">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Abrir comprobante
                        </a>
                    </div>

                    @php
                        $horasEnRevision = \Carbon\Carbon::parse($reservaSeleccionada->fecha_subida_comprobante)->diffInHours(now());
                    @endphp
                    
                    @if($horasEnRevision >= 11)
                        <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-xs font-bold rounded">
                            Llevas {{ $horasEnRevision }} horas sin revisar este pago. Si llegas a las 12 horas, el sistema lo aprobará automáticamente.
                        </div>
                    @endif
                @elseif(in_array($reservaSeleccionada->estado, ['Completada']) && !empty($reservaSeleccionada->comprobante_pago))
                    <div class="mt-4 text-right">
                         <a href="{{ asset('storage/' . $reservaSeleccionada->comprobante_pago) }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">Abrir comprobante de pago guardado</a>
                    </div>
                @endif

                @if($intentoCancelar)
                    <div class="bg-gray-50 border border-gray-300 rounded-xl p-6 mt-4">
                        <label class="block text-sm font-bold text-gray-900 mb-1">Mensaje de cancelación</label>
                        
                        <textarea wire:model.defer="motivoCancelacion" rows="3" class="w-full rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-900 focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none p-3" placeholder="Ej: No disponemos de capacidad para esas fechas..."></textarea>
                        @error('motivoCancelacion') <span class="text-red-500 text-xs mt-2 block font-bold">{{ $message }}</span> @enderror
                        
                        <div class="mt-4 flex justify-end gap-3">
                            <button wire:click="$set('intentoCancelar', false)" class="px-5 py-2 text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg transition-colors outline-none">Regresar</button>
                            <button wire:click="confirmarCancelacion" class="px-5 py-2 text-sm font-bold text-white bg-red-400 hover:bg-red-500 rounded-lg shadow-sm transition-colors outline-none">Confirmar cancelación</button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Controles inferiores --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-300 flex justify-end">
                <div class="flex flex-wrap gap-3">
                    @if($modoReagendar)
                        <button wire:click="$set('modoReagendar', false)" class="px-5 py-2 text-xs font-bold text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 rounded-lg transition-colors outline-none">Descartar cambios</button>
                        <button wire:click="guardarReagendamiento" class="px-5 py-2 text-xs font-bold text-white bg-[#0acd5b] hover:bg-[#00A344] rounded-lg shadow-sm transition-colors flex items-center gap-2 outline-none">
                            <svg wire:loading.remove wire:target="guardarReagendamiento" class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <svg wire:loading wire:target="guardarReagendamiento" class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Guardar y notificar
                        </button>
                    @elseif(!$intentoCancelar)
                        <button wire:click="cerrarModal" class="px-5 py-2 text-xs font-bold text-gray-700 bg-gray-100 border border-gray-300 hover:bg-gray-200 rounded-lg transition-colors outline-none">Cerrar</button>

                        @if(in_array($reservaSeleccionada->estado, ['Pendiente', 'Reagendada']))
                            <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Confirmada')" class="px-5 py-2 text-xs font-bold text-white bg-[#0acd5b] hover:bg-[#00A344] rounded-lg shadow-sm transition-colors outline-none">Confirmar reserva</button>
                        @endif
                        
                        @if(!in_array($reservaSeleccionada->estado, ['Cancelada', 'Rechazada']) && !$yaPasoFecha)
                            <button wire:click="activarModoReagendar" class="px-5 py-2 text-xs font-bold text-gray-900 bg-amber-300 hover:bg-amber-400 rounded-lg shadow-sm transition-colors outline-none">Reagendar</button>
                            <button wire:click="intentarCancelar" class="px-5 py-2 text-xs font-bold text-white bg-red-400 hover:bg-red-500 rounded-lg shadow-sm transition-colors outline-none">Cancelar</button>
                        @endif

                        @if($reservaSeleccionada->estado === 'Confirmada' || $reservaSeleccionada->estado === 'Pago en revisión')
                            <button wire:click="actualizarEstado({{ $reservaSeleccionada->id }}, 'Completada')" class="px-5 py-2 text-xs font-bold text-white bg-blue-500 hover:bg-blue-600 rounded-lg shadow-sm transition-colors outline-none">Marcar completada</button>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
@endif