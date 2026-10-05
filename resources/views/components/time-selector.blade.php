@props(['servicio', 'modelName' => 'hora_llegada', 'label' => 'Hora de Llegada'])

<div class="space-y-2">
    <label class="text-xs font-black text-gray-600 uppercase tracking-widest ml-1 dark:text-slate-300">{{ $label }}</label>
    
    @if($servicio->detallePaqueteTuristico)
        {{-- CASO PAQUETE: Hora Fija --}}
        <div class="bg-amber-50 border-2 border-amber-100 p-4 rounded-2xl flex items-center justify-between dark:border-amber-400/20 dark:bg-amber-400/10">
            <div class="flex items-center gap-2 text-xs font-bold text-amber-700 dark:text-amber-200">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Establecida:
            </div>
            <span class="font-black text-amber-900 text-base uppercase dark:text-amber-100">
                {{ $this->obtenerHoraSalida() }}
            </span>
            <input type="hidden" wire:model="{{ $modelName }}">
        </div>
    @elseif($servicio->detalleAlimentacion)
        {{-- CASO ALIMENTACIÓN: Rangos Dinámicos --}}
        @php
            $rangos = $this->obtenerRangosHorario();
        @endphp
        <div class="relative">
            <input type="time" wire:model="{{ $modelName }}" 
                min="{{ $rangos['min'] }}" max="{{ $rangos['max'] }}"
                class="w-full bg-blue-50 border-2 border-blue-100 rounded-2xl p-3 font-bold text-sm focus:ring-blue-500 dark:border-blue-400/20 dark:bg-blue-400/10 dark:text-blue-100">
            <div class="mt-1 flex justify-between px-1">
                <span class="text-[9px] font-black text-blue-600 uppercase dark:text-blue-300">{{ $rangos['label'] }}</span>
                <span class="text-[9px] font-bold text-blue-400 italic dark:text-blue-200">{{ $rangos['min'] }} a {{ $rangos['max'] }}</span>
            </div>
        </div>
    @else
        {{-- OTROS SERVICIOS: Selector Normal --}}
        <input type="time" wire:model="{{ $modelName }}" 
            class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl p-3 font-bold text-sm focus:ring-[#1a4031] focus:border-[#1a4031] dark:border-white/10 dark:bg-zinc-900 dark:text-white">
    @endif
</div>
