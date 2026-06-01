@props(['paso'])

<header class="mb-12 flex flex-col md:flex-row md:justify-between md:items-start gap-6">
    <div class="flex-1">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-[#06281E] dark:text-white tracking-tight">Crear reserva</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-bold">Selecciona los servicios para tu viaje</p>
        </div>

        <nav aria-label="Progreso de reserva" class="max-w-lg">
            <ol class="flex w-full items-center">
                <li class="flex items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 items-center justify-center rounded-full border-2 {{ $paso > 1 ? 'bg-[#00D65B] border-[#00D65B] text-[#06281E]' : 'bg-[#00D65B] border-[#00D65B] text-[#06281E] outline outline-2 outline-offset-2 outline-[#00D65B]' }}">
                            @if($paso > 1) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else <span class="font-bold">1</span> @endif
                        </span>
                        <span class="hidden font-black text-[#00A344] dark:text-[#00D65B] uppercase text-[10px] tracking-widest sm:inline">Servicios</span>
                    </div>
                </li>
                <li class="flex-1 px-4"><div class="h-0.5 w-full {{ $paso >= 2 ? 'bg-[#00A344] dark:bg-[#00D65B]' : 'bg-gray-200 dark:bg-zinc-700' }}"></div></li>
                <li class="flex items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 {{ $paso == 2 ? 'bg-[#00D65B] border-[#00D65B] text-[#06281E] outline outline-2 outline-offset-2 outline-[#00D65B]' : ($paso > 2 ? 'bg-[#00D65B] border-[#00D65B] text-[#06281E]' : 'bg-white dark:bg-zinc-900 border-gray-200 dark:border-zinc-700 text-gray-500 dark:text-gray-400') }}">
                            @if($paso > 2) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else <span class="font-bold">2</span> @endif
                        </span>
                        <span class="hidden {{ $paso >= 2 ? 'font-black text-[#00A344] dark:text-[#00D65B]' : 'font-bold text-gray-500 dark:text-gray-400' }} uppercase text-[10px] tracking-widest sm:inline">Cliente</span>
                    </div>
                </li>
                <li class="flex-1 px-4"><div class="h-0.5 w-full {{ $paso >= 3 ? 'bg-[#00A344] dark:bg-[#00D65B]' : 'bg-gray-200 dark:bg-zinc-700' }}"></div></li>
                <li class="flex items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 {{ $paso == 3 ? 'bg-[#00D65B] border-[#00D65B] text-[#06281E] outline outline-2 outline-offset-2 outline-[#00D65B]' : 'bg-white dark:bg-zinc-900 border-gray-200 dark:border-zinc-700 text-gray-500 dark:text-gray-400' }} font-bold text-xs">3</span>
                        <span class="hidden {{ $paso == 3 ? 'font-black text-[#00A344] dark:text-[#00D65B]' : 'font-bold text-gray-500 dark:text-gray-400' }} uppercase text-[10px] tracking-widest sm:inline">Resumen</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex items-center gap-3 shrink-0 pt-2">
        @if($paso > 1)
            <button wire:click="$set('paso', {{ $paso - 1 }})" class="px-6 py-3 bg-white dark:bg-zinc-800 text-[#00A344] dark:text-[#00D65B] font-black rounded-full border border-gray-200 dark:border-zinc-700 hover:border-[#00A344] dark:hover:border-[#00D65B] shadow-sm text-[10px] uppercase tracking-widest transition-colors outline-none">Atrás</button>
        @endif
        <a href="{{ route('emprendimiento.reservas') }}" wire:navigate.hover class="px-6 py-3 bg-white dark:bg-zinc-800 text-red-500 dark:text-red-400 font-black rounded-full border border-gray-200 dark:border-zinc-700 hover:border-red-500 dark:hover:border-red-400 shadow-sm text-[10px] uppercase tracking-widest transition-colors outline-none text-center">Cancelar</a>
    </div>
</header>