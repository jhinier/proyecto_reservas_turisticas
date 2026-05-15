<div class="sticky top-6 bg-zinc-900 text-white rounded-[2.5rem] p-6 md:p-8 shadow-2xl border border-zinc-800">

    {{-- Encabezado --}}
    <div class="flex items-center gap-3 mb-6 border-b border-white/10 pb-4">
        <svg class="size-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h3 class="text-xl font-black tracking-wide">Resumen</h3>
    </div>

    {{-- Lista de ítems --}}
    <div class="space-y-4 max-h-[45vh] overflow-y-auto pr-2 custom-scrollbar">
        @forelse($items as $index => $item)
            <div class="bg-white/5 hover:bg-white/10 transition rounded-2xl p-4 border border-white/5 relative group">

                {{-- Eliminar --}}
                <button wire:click="eliminar({{ $index }})"
                        class="absolute top-3 right-3 text-white/30 hover:text-red-400 transition"
                        title="Quitar servicio">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Nombre --}}
                <h4 class="font-bold text-sm pr-6 leading-tight">{{ $item['nombre'] }}</h4>

                {{-- Categoría badge --}}
                <span class="inline-block mt-1 text-[9px] font-bold uppercase tracking-widest text-green-400/70">
                    {{ $item['categoria'] }}
                </span>

                {{-- Detalles --}}
                <div class="mt-2 text-[10px] text-gray-400 font-medium space-y-1">

                    {{-- Fechas --}}
                    <p>
                        📅
                        {{ \Carbon\Carbon::parse($item['fecha_inicio'])->format('d/m/Y') }}
                        @if(isset($item['fecha_fin']) && $item['fecha_fin'] !== $item['fecha_inicio'])
                            → {{ \Carbon\Carbon::parse($item['fecha_fin'])->format('d/m/Y') }}
                        @endif
                    </p>

                    {{-- Hora --}}
                    @if(!empty($item['hora']))
                        <p>🕐 {{ $item['hora'] }}</p>
                    @endif

                    {{-- Personas / Cantidad según tipo --}}
                    @php
                        $cat = strtolower($item['categoria_nombre'] ?? $item['categoria'] ?? '');
                        $esHosp = str_contains($cat, 'hospedaje');
                        $esGuia = str_contains($cat, 'guianza');
                        $esPaq  = str_contains($cat, 'paquete');
                        $esAlq  = str_contains($cat, 'alquiler');
                    @endphp

                    @if($esHosp)
                        <p>🛏 {{ $item['cantidad'] }} habitación(es) · 👥 {{ $item['numero_personas'] }} personas</p>
                    @elseif($esGuia)
                        <p>🧭 {{ $item['cantidad'] }} guía(s) · 👥 {{ $item['numero_personas'] }} personas</p>
                    @elseif($esPaq)
                        <p>{{ $item['cantidad'] }} paquete(s)</p>
                    @elseif($esAlq)
                        <p>{{ $item['cantidad'] }} unidad(es)</p>
                    @else
                        <p>🍽 Cantidad: {{ $item['cantidad'] }}</p>
                    @endif
                </div>

                {{-- Precio --}}
                <div class="mt-3 flex justify-end">
                    <span class="font-black text-green-400 text-lg">
                        ${{ number_format($item['subtotal'], 2) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-10 opacity-40">
                <svg class="size-12 mx-auto mb-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <p class="text-xs font-bold uppercase tracking-widest">Carrito Vacío</p>
                <p class="text-[10px] mt-1">Agrega servicios para continuar.</p>
            </div>
        @endforelse
    </div>

    {{-- Totales y acciones --}}
    @if(count($items) > 0)
        <div class="mt-6 pt-6 border-t border-white/10">
            <div class="flex justify-between items-end mb-6">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total:</span>
                <span class="text-3xl font-black text-white">
                    ${{ number_format(collect($items)->sum('subtotal'), 2) }}
                </span>
            </div>

            @if($pasoActual === 1)
                <button wire:click="$dispatch('cambiar-paso', { nuevoPaso: 2 })"
                        class="w-full bg-green-500 hover:bg-green-400 text-black py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5">
                    Continuar al Cliente
                </button>
            @elseif($pasoActual === 2)
                <div class="text-center p-3 rounded-xl bg-white/5 border border-white/10 text-xs text-gray-400">
                    Complete los datos del cliente a la izquierda para finalizar.
                </div>
            @endif
        </div>
    @endif
</div>
