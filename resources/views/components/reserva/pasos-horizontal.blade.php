@props(['paso'])

<header class="mb-12 flex flex-col md:flex-row md:justify-between md:items-start gap-6">
    <div class="flex-1">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-[#032E15] tracking-tight">Crear reserva</h1>
            <p class="text-[#5A735E] mt-2 font-bold">Selecciona los servicios para tu viaje</p>
        </div>

        <nav aria-label="Progreso de reserva" class="max-w-lg">
            <ol class="flex w-full items-center">
                <li class="flex items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 items-center justify-center rounded-full border-2 {{ $paso > 1 ? 'bg-[#508A45] border-[#508A45] text-white' : 'bg-[#508A45] border-[#508A45] text-white outline outline-2 outline-offset-2 outline-[#508A45]' }}">
                            @if($paso > 1) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else <span class="font-bold">1</span> @endif
                        </span>
                        <span class="hidden font-black text-[#508A45] uppercase text-[10px] tracking-widest sm:inline">Servicios</span>
                    </div>
                </li>
                <li class="flex-1 px-4"><div class="h-0.5 w-full {{ $paso >= 2 ? 'bg-[#508A45]' : 'bg-[#E8EFE8]' }}"></div></li>
                <li class="flex items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 {{ $paso == 2 ? 'bg-[#508A45] border-[#508A45] text-white outline outline-2 outline-offset-2 outline-[#508A45]' : ($paso > 2 ? 'bg-[#508A45] border-[#508A45] text-white' : 'bg-white border-[#E8EFE8] text-[#5A735E]') }}">
                            @if($paso > 2) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else <span class="font-bold">2</span> @endif
                        </span>
                        <span class="hidden {{ $paso >= 2 ? 'font-black text-[#508A45]' : 'font-bold text-[#5A735E]' }} uppercase text-[10px] tracking-widest sm:inline">Cliente</span>
                    </div>
                </li>
                <li class="flex-1 px-4"><div class="h-0.5 w-full {{ $paso >= 3 ? 'bg-[#508A45]' : 'bg-[#E8EFE8]' }}"></div></li>
                <li class="flex items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 {{ $paso == 3 ? 'bg-[#508A45] border-[#508A45] text-white outline outline-2 outline-offset-2 outline-[#508A45]' : 'bg-white border-[#E8EFE8] text-[#5A735E]' }} font-bold text-xs">3</span>
                        <span class="hidden {{ $paso == 3 ? 'font-black text-[#508A45]' : 'font-bold text-[#5A735E]' }} uppercase text-[10px] tracking-widest sm:inline">Resumen</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="flex items-center gap-3 shrink-0 pt-2">
        @if($paso > 1)
            <button wire:click="$set('paso', {{ $paso - 1 }})" class="px-6 py-3 bg-white text-[#508A45] font-black rounded-full border border-[#E8EFE8] hover:border-[#508A45] shadow-sm text-[10px] uppercase tracking-widest transition-colors">Atrás</button>
        @endif
        <a href="{{ route('emprendimiento.reservas') }}" wire:navigate class="px-6 py-3 bg-white text-red-500 font-black rounded-full border border-[#E8EFE8] hover:border-red-500 shadow-sm text-[10px] uppercase tracking-widest transition-colors">Cancelar</a>
    </div>
</header>