@props(['paso'])

<header class="mb-10 flex flex-col md:flex-row md:justify-between md:items-start gap-6">
    <div class="flex-1">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter">Crear Reserva</h1>
            <p class="text-gray-600 mt-2 font-medium">Siga los pasos para agendar servicios turisticos</p>
        </div>

        <nav aria-label="reserva progress" class="max-w-lg">
            <ol class="flex w-full items-center">
                <li class="flex items-center text-sm" @if($paso == 1) aria-current="step" @endif>
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 items-center justify-center rounded-full border-2 {{ $paso > 1 ? 'bg-[#1a4031] border-[#1a4031] text-white' : 'bg-[#1a4031] border-[#1a4031] text-white outline outline-2 outline-offset-2 outline-[#1a4031]' }}">
                            @if($paso > 1)
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            @else
                                <span class="font-bold">1</span>
                            @endif
                        </span>
                        <span class="hidden font-black text-[#1a4031] uppercase text-[10px] tracking-widest sm:inline">Servicios</span>
                    </div>
                </li>
                <li class="flex-1 px-4"><div class="h-0.5 w-full {{ $paso >= 2 ? 'bg-[#1a4031]' : 'bg-gray-300' }}"></div></li>
                <li class="flex items-center text-sm" @if($paso == 2) aria-current="step" @endif>
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 {{ $paso == 2 ? 'bg-[#1a4031] border-[#1a4031] text-white outline outline-2 outline-offset-2 outline-[#1a4031]' : ($paso > 2 ? 'bg-[#1a4031] border-[#1a4031] text-white' : 'bg-white border-gray-300 text-gray-500') }}">
                            @if($paso > 2)
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            @else
                                <span class="font-bold">2</span>
                            @endif
                        </span>
                        <span class="hidden {{ $paso >= 2 ? 'font-black text-[#1a4031]' : 'font-bold text-gray-400' }} uppercase text-[10px] tracking-widest sm:inline">Cliente</span>
                    </div>
                </li>
                <li class="flex-1 px-4"><div class="h-0.5 w-full {{ $paso >= 3 ? 'bg-[#1a4031]' : 'bg-gray-300' }}"></div></li>
                <li class="flex items-center text-sm" @if($paso == 3) aria-current="step" @endif>
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 {{ $paso == 3 ? 'bg-[#1a4031] border-[#1a4031] text-white outline outline-2 outline-offset-2 outline-[#1a4031]' : 'bg-white border-gray-300 text-gray-500' }} font-bold text-xs">3</span>
                        <span class="hidden {{ $paso == 3 ? 'font-black text-[#1a4031]' : 'font-bold text-gray-400' }} uppercase text-[10px] tracking-widest sm:inline">Resumen</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Botones de acción en la parte superior derecha --}}
    <div class="flex items-center gap-3 shrink-0 pt-2">
        @if($paso > 1)
            <button wire:click="$set('paso', {{ $paso - 1 }})" class="px-6 py-3 bg-white hover:bg-gray-100 text-gray-800 font-black rounded-xl border border-gray-200 shadow-sm text-[10px] uppercase tracking-widest transition-colors">
                Atrás
            </button>
        @endif
        
        <a href="{{ route('emprendimiento.reservas') }}" wire:navigate class="px-6 py-3 bg-white hover:bg-red-50 text-red-500 font-black rounded-xl border border-gray-200 shadow-sm text-[10px] uppercase tracking-widest transition-colors flex items-center justify-center">
            Cancelar
        </a>
    </div>
</header>