<div>
    @if($mostrar && $servicio)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

                <div class="bg-white rounded-3xl overflow-hidden shadow-2xl transform transition-all max-w-lg w-full z-50 border border-gray-100 relative">
                    <div class="p-8">
                        <header class="flex justify-between items-start mb-8">
                            <div>
                                <h2 class="text-2xl font-black text-gray-900 uppercase leading-tight tracking-tighter">
                                    {{ $servicio->nombre }}
                                </h2>
                                <p class="text-xs font-bold text-[#1a4031] uppercase tracking-widest mt-1">
                                    {{ $servicio->tipoServicio->nombre }}
                                </p>
                            </div>
                            <button type="button" wire:click="$set('mostrar', false)" class="p-2 bg-gray-50 rounded-full text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </header>

                        <div class="space-y-6"
                             x-data="{ 
                                 fecha: @entangle('fecha'),
                                 fechaFin: @entangle('fechaFin'),
                                 hora: @entangle('hora'),
                                 cantidad: @entangle('cantidad'),
                                 personas: @entangle('numeroPersonasGroup'),
                                 disponibilidad: @entangle('disponibilidad'),
                                 esAlimentacion: {{ str_contains(strtolower($servicio->tipoServicio->nombre ?? ''), 'alimentaci') ? 'true' : 'false' }},
                                 esPaquete: {{ str_contains(strtolower($servicio->tipoServicio->nombre ?? ''), 'paquete') ? 'true' : 'false' }},
                                 requiereFechaFin: {{ $this->requiereFechaFin() ? 'true' : 'false' }},
                                 capacidadUnidad: {{ $servicio->detalleHospedaje->capacidad ?? ($servicio->detalleGuianza->numero_max_persona ?? 0) }},
                                 get capacidadTotal() { return this.cantidad * this.capacidadUnidad },
                                 get noAbastece() { return this.fecha && this.capacidadUnidad > 0 && this.personas > this.capacidadTotal },
                                 get superaStock() { return !this.esAlimentacion && this.disponibilidad !== 999 && this.disponibilidad > 0 && this.cantidad > this.disponibilidad },
                                 get disableButton() { return !this.fecha || (!this.esPaquete && !this.hora) || (this.requiereFechaFin && !this.fechaFin) || (this.disponibilidad <= 0 && this.disponibilidad !== 999) || this.superaStock || this.noAbastece }
                             }">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-xs font-black text-gray-600 uppercase tracking-widest ml-1">
                                        Fecha de inicio
                                    </label>
                                    <input type="date"
                                           wire:model.live="fecha"
                                           min="{{ now()->toDateString() }}"
                                           class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031] focus:bg-white transition-all shadow-sm cursor-pointer">
                                    @error('fecha') <span class="text-red-500 text-[10px] font-bold mt-2 block px-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-2" x-show="requiereFechaFin">
                                    <label class="block text-xs font-black text-gray-600 uppercase tracking-widest ml-1">
                                        Fecha de fin
                                    </label>
                                    <input type="date"
                                           wire:model.live="fechaFin"
                                           :min="fecha || '{{ now()->toDateString() }}'"
                                           class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031] focus:bg-white transition-all shadow-sm cursor-pointer">
                                    @error('fechaFin') <span class="text-red-500 text-[10px] font-bold mt-2 block px-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-2" :class="requiereFechaFin ? 'md:col-span-2' : ''" x-show="!esPaquete">
                                    <label class="block text-xs font-black text-gray-600 uppercase tracking-widest ml-1">
                                        Hora
                                    </label>
                                    <input type="time"
                                           wire:model.live="hora"
                                           class="w-full bg-gray-50 border-2 border-gray-200 rounded-2xl p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031] focus:bg-white transition-all shadow-sm cursor-pointer">
                                    @error('hora') <span class="text-red-500 text-[10px] font-bold mt-2 block px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @if($fecha && $disponibilidad !== 999)
                                <div class="p-5 rounded-2xl transition-all border-2 {{ $disponibilidad > 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                    <div class="flex justify-between items-center" wire:loading.remove wire:target="fecha, fechaFin">
                                        <span class="text-[10px] font-black uppercase {{ $disponibilidad > 0 ? 'text-green-700' : 'text-red-700' }}">
                                            Disponibilidad para la fecha:
                                        </span>
                                        <span class="text-lg font-black {{ $disponibilidad > 0 ? 'text-green-800' : 'text-red-800' }}">
                                            {{ $disponibilidad . ' ' . strtolower($this->unidadMedida) }}
                                        </span>
                                    </div>

                                    <div wire:loading wire:target="fecha, fechaFin" class="flex justify-between items-center w-full animate-pulse">
                                        <div class="h-3 bg-gray-300 rounded w-32"></div>
                                        <div class="h-5 bg-gray-300 rounded w-16"></div>
                                    </div>
                                </div>
                            @endif

                            @if($servicio->detalleHospedaje || $servicio->detalleGuianza)
                                <div class="bg-gray-50 p-4 rounded-2xl border-2 border-gray-200">
                                    <label class="block text-[10px] font-black text-gray-600 uppercase mb-3 ml-1">¿Cuántas personas son en total?</label>
                                    <input type="number" 
                                           x-model.number="personas"
                                           @blur="if (!personas || personas < 1) personas = 1"
                                           min="1"
                                           class="w-full bg-white border-2 border-gray-200 rounded-xl p-3 font-bold text-center text-gray-800 focus:ring-2 focus:ring-[#1a4031] focus:border-[#1a4031]">
                                    @error('numeroPersonasGroup')
                                        <span class="text-red-500 text-[10px] font-bold mt-2 block px-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="space-y-3">
                                
                                {{-- ALERTA DE CUELLO DE BOTELLA: Aparece solo cuando el stock del rango baja respecto al stock total del servicio --}}
                                <div x-show="requiereFechaFin && fecha && fechaFin && disponibilidad > 0 && disponibilidad < {{ $servicio->stock ?? 0 }}" style="display: none;" 
                                     class="p-4 bg-blue-50 border-2 border-blue-200 rounded-2xl transition-all">
                                    <div class="flex items-start gap-3">
                                        <span class="text-xl">ℹ️</span>
                                        <div>
                                            <p class="font-black text-xs uppercase text-blue-900">Disponibilidad limitada</p>
                                            <p class="text-[10px] text-blue-800 mt-1">
                                                Debido a las reservas existentes en los días intermedios de tu estancia, el cupo máximo es de <span class="font-bold" x-text="disponibilidad"></span> {{ strtolower($this->unidadMedida) }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-2xl border-2 transition-colors" :class="(noAbastece || superaStock) ? 'border-yellow-300 bg-yellow-50' : 'border-gray-200 bg-gray-50'">
                                    <label class="block text-[10px] font-black text-gray-600 uppercase mb-3 ml-1 transition-colors" :class="(noAbastece || superaStock) ? 'text-yellow-900' : 'text-gray-600'">{{ $this->unidadMedida }}</label>
                                    
                                    <div class="flex items-center bg-white border-2 rounded-xl overflow-hidden transition-colors border-gray-200">
                                        <button type="button"
                                                @click="cantidad = Math.max(1, cantidad - 1)"
                                                :disabled="!fecha || (disponibilidad <= 0 && disponibilidad !== 999)"
                                                class="size-9 flex items-center justify-center font-bold text-gray-400 hover:text-red-500 hover:bg-red-50 transition disabled:opacity-40">
                                            -
                                        </button>
                                        <input type="number"
                                               x-model.number="cantidad"
                                               @blur="if (!cantidad || cantidad < 1) cantidad = 1; if (!esAlimentacion && disponibilidad !== 999 && cantidad > disponibilidad) cantidad = disponibilidad"
                                               min="1"
                                               :disabled="!fecha || (disponibilidad <= 0 && disponibilidad !== 999)"
                                               class="flex-1 bg-white border-none text-center font-black text-gray-800 focus:ring-0 h-9 disabled:opacity-40">
                                        <button type="button"
                                                @click="cantidad = (esAlimentacion || disponibilidad === 999) ? cantidad + 1 : Math.min(cantidad + 1, disponibilidad)"
                                                :disabled="!fecha || (disponibilidad <= 0 && disponibilidad !== 999)"
                                                class="size-9 flex items-center justify-center font-bold text-gray-400 hover:text-green-600 hover:bg-green-50 transition disabled:opacity-40">
                                            +
                                        </button>
                                    </div>
                                    
                                    @error('cantidad')
                                        <span class="text-red-500 text-[10px] font-bold mt-2 block px-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div x-show="superaStock" style="display: none;" class="flex items-start gap-3 p-4 bg-orange-100 border-2 border-orange-200 rounded-2xl text-orange-900">
                                    <span class="text-xl">⚠️</span>
                                    <div>
                                        <p class="font-black text-xs uppercase">Stock superado</p>
                                        <p class="text-[10px] mt-1">Solo hay <span class="font-bold" x-text="disponibilidad"></span> disponibles para esta fecha. Por favor, reduce la cantidad para continuar.</p>
                                    </div>
                                </div>

                                <div x-show="noAbastece" style="display: none;" class="flex items-start gap-3 p-4 bg-yellow-100 border-2 border-yellow-200 rounded-2xl text-yellow-900">
                                    <span class="text-xl">⚠️</span>
                                    <div>
                                        <p class="font-black text-xs uppercase">Capacidad insuficiente</p>
                                        <p class="text-[10px] mt-1">Has seleccionado contratacion para <span class="font-bold" x-text="capacidadTotal"></span> personas, pero tu grupo es de <span class="font-bold" x-text="personas"></span>. Aumenta la cantidad o elige servicios adicionales.</p>
                                    </div>
                                </div>

                                @error('capacidad')
                                    <div class="p-4 bg-red-100 border-2 border-red-200 rounded-2xl text-red-900 text-xs font-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($servicio->detalleAlimentacion)
                                <div class="bg-blue-50 border-2 border-blue-200 p-3 rounded-xl">
                                    <p class="text-[10px] font-bold text-blue-700 uppercase">Tipo: {{ ucfirst($servicio->detalleAlimentacion->tipo_alimentacion) }}</p>
                                    <p class="text-[10px] text-blue-600 mt-1">Lugar: {{ $servicio->detalleAlimentacion->lugar_alimentacion }}</p>
                                </div>
                            @endif

                            @if($servicio->detalleHospedaje)
                                <div class="bg-purple-50 border-2 border-purple-200 p-3 rounded-xl">
                                    <p class="text-[10px] font-bold text-purple-700 uppercase">Capacidad: {{ $servicio->detalleHospedaje->capacidad }} personas</p>
                                </div>
                            @endif

                            @if($servicio->detalleGuianza)
                                <div class="bg-orange-50 border-2 border-orange-200 p-3 rounded-xl">
                                    <p class="text-[10px] font-bold text-orange-700 uppercase">Max personas: {{ $servicio->detalleGuianza->numero_max_persona }} pax</p>
                                </div>
                            @endif

                            @if($servicio->detallePaqueteTuristico)
                                <div class="bg-amber-50 border-2 border-amber-200 p-3 rounded-xl space-y-1">
                                    <p class="text-[10px] font-bold text-amber-700 uppercase">Paquete Turistico</p>
                                    <p class="text-[10px] text-amber-600">Duracion: {{ $servicio->detallePaqueteTuristico->duracion_dias }} dias</p>
                                    <p class="text-[10px] text-amber-600">Salida preestablecida: {{ \Carbon\Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i') }}</p>
                                    @if($fecha)
                                        <p class="text-[10px] text-amber-800 font-bold mt-2">
                                            Termina el: {{ \Carbon\Carbon::parse($fecha)->addDays(max(0, $servicio->detallePaqueteTuristico->duracion_dias - 1))->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="mt-10">
                            <button
                                type="button"
                                wire:click.prevent="agregarAlResumen"
                                wire:loading.attr="disabled"
                                x-bind:disabled="disableButton"
                                class="w-full py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-sm transition-all shadow-xl border-2 bg-[#1a4031] border-[#1a4031] text-white hover:bg-green-950 shadow-green-900/20 active:scale-95"
                                :class="disableButton ? 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed shadow-none hover:bg-none' : ''">
                                
                                <span wire:loading.remove wire:target="agregarAlResumen">Confirmar y Añadir</span>
                                
                                <span wire:loading wire:target="agregarAlResumen" class="flex items-center justify-center gap-2" style="display: none;">
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Procesando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>