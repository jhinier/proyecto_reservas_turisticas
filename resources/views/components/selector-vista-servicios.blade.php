@props(['vista' => 'lista'])

<div {{ $attributes->class(['inline-flex w-full shrink-0 rounded-xl border border-[#d5dfbc] bg-[#e4eccf] p-0.5 sm:w-[230px]']) }}
     role="group"
     aria-label="Cambiar vista de servicios">
    <button type="button"
            wire:click="$dispatch('cambiar-vista-servicios', { vista: 'tarjetas' })"
            title="Vista de tarjetas"
            aria-label="Mostrar como tarjetas"
            aria-pressed="{{ $vista === 'tarjetas' ? 'true' : 'false' }}"
            class="inline-flex h-9 flex-1 items-center justify-center gap-1.5 rounded-xl border px-3 text-xs font-semibold text-[#31552b] transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#31552b] {{ $vista === 'tarjetas' ? 'border-[#b9c99d] bg-white shadow-sm' : 'border-transparent hover:bg-white/50' }}">
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z" />
        </svg>
        <span>Tarjetas</span>
    </button>

    <button type="button"
            wire:click="$dispatch('cambiar-vista-servicios', { vista: 'lista' })"
            title="Vista de lista"
            aria-label="Mostrar como lista"
            aria-pressed="{{ $vista === 'lista' ? 'true' : 'false' }}"
            class="inline-flex h-9 flex-1 items-center justify-center gap-1.5 rounded-xl border px-3 text-xs font-semibold text-[#31552b] transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#31552b] {{ $vista === 'lista' ? 'border-[#b9c99d] bg-white shadow-sm' : 'border-transparent hover:bg-white/50' }}">
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6h11M9 12h11M9 18h11M4 6h.01M4 12h.01M4 18h.01" />
        </svg>
        <span>Lista</span>
    </button>
</div>
