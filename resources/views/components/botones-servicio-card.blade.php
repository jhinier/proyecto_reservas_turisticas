@props(['servicio'])

<div class="flex items-center gap-2 shrink-0">
    
    {{-- Galería --}}
    @if($servicio->permite_galeria)
        <button 
            @click="$dispatch('abrir-gestor-galeria', { servicioId: @js($servicio->id) })"
            title="Ver Galería"
            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-gray-300 text-gray-700 hover:-translate-y-0.5 hover:shadow-md hover:bg-[#06281E] hover:border-[#06281E] hover:text-white dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-white dark:hover:text-[#06281E] transition-all duration-300 outline-none cursor-pointer">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:inline">Galería</span>
        </button>
    @endif

    {{-- Editar --}}
    <button 
        wire:click="editarServicio({{ $servicio->id }})"
        title="Editar Servicio"
        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#00D65B]/10 border border-[#00D65B]/30 text-[#00A344] hover:-translate-y-0.5 hover:shadow-md hover:bg-[#00D65B] hover:border-[#00D65B] hover:text-[#06281E] dark:bg-[#00D65B]/10 dark:border-[#00D65B]/20 dark:text-[#00D65B] dark:hover:bg-[#00D65B] dark:hover:text-[#06281E] transition-all duration-300 outline-none cursor-pointer">
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:inline">Editar</span>
    </button>

    {{-- Eliminar --}}
    <button 
        @click="$dispatch('abrir-modal-eliminar', { id: @js($servicio->id), action: 'eliminarServicio' })"
        title="Borrar Servicio"
        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 border border-red-200 text-red-600 hover:-translate-y-0.5 hover:shadow-md hover:bg-red-600 hover:border-red-600 hover:text-white dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white transition-all duration-300 outline-none cursor-pointer">
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        <span class="text-[10px] font-bold uppercase tracking-widest hidden sm:inline">Borrar</span>
    </button>

</div>