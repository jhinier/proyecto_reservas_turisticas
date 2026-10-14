{{-- Vista que muestra paquetes turisticos en tarjetas o tabla con acciones de detalle, editar y eliminar. --}}
<div class="min-w-0 space-y-6">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 lg:flex-row lg:items-center">
        <h3 class="text-xl font-gray text-[#06281E] dark:text-white tracking-wide">
            Mis {{ $nombreCategoria }}
        </h3>

        <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
            <x-selector-vista-servicios :vista="$vista" />

            <a href="{{ route($rutaCrear, ['pivotId' => $pivotId]) }}" wire:navigate
               class="inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-[#00D65B] px-6 py-2.5 text-[10px] font-bold tracking-widest text-[#06281E] shadow-sm outline-none transition-colors hover:bg-[#00c052] sm:w-auto sm:text-xs">
                <svg class="size-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                Nuevo Paquete
            </a>
        </div>
    </div>

    @if($paquetes->isEmpty())
        <div class="flex min-h-[300px] flex-col items-center justify-center rounded-3xl border border-gray-200 bg-gray-50/50 p-12 text-center shadow-sm dark:border-white/10 dark:bg-zinc-900">
            <div class="mb-4 rounded-full border border-gray-100 bg-white p-4 shadow-sm dark:border-white/5 dark:bg-zinc-800">
                <svg class="h-10 w-10 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-base font-black uppercase tracking-wide text-[#06281E] dark:text-white">No hay paquetes turisticos</h3>
            <p class="mt-2 max-w-sm text-sm font-medium text-gray-500 dark:text-gray-400">Comienza a disenar tu primer paquete para tus visitantes.</p>
        </div>
    @else
        @if($vista === 'lista')
            <div class="w-full max-w-full overflow-x-auto rounded-lg border border-outline bg-white shadow-sm dark:border-white/10 dark:bg-zinc-900">
                <table class="w-full min-w-[1120px] text-left text-sm text-on-surface dark:text-on-surface-dark">
                    <thead class="border-b border-outline bg-surface-alt text-xs font-semibold uppercase text-on-surface-strong dark:border-white/10 dark:bg-zinc-800 dark:text-white">
                        <tr>
                            <th scope="col" class="p-4">Paquete</th>
                            <th scope="col" class="p-4">Detalles</th>
                            <th scope="col" class="p-4">Salida</th>
                            <th scope="col" class="p-4">Imagenes</th>
                            <th scope="col" class="p-4">Precio</th>
                            <th scope="col" class="p-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-white/10">
                        @foreach($paquetes as $paquete)
                            @php($detalle = $paquete->detallePaqueteTuristico)
                            <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-zinc-900 dark:hover:bg-white/5" wire:key="paquete-lista-{{ $paquete->id }}">
                                <td class="p-4 align-middle">
                                    <div class="flex min-w-[230px] items-center gap-3">
                                        <button type="button"
                                                @click="$dispatch('abrir-gestor-galeria', { servicioId: {{ $paquete->id }} })"
                                                class="flex size-12 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-white/10 dark:bg-zinc-800"
                                                title="Abrir galeria"
                                                aria-label="Abrir galeria de {{ $paquete->nombre }}">
                                            @if($paquete->imagenes && $paquete->imagenes->isNotEmpty())
                                                <img src="{{ Storage::url($paquete->imagenes->first()->imagen) }}" alt="" class="h-full w-full object-cover">
                                            @else
                                                <svg class="size-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </button>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-[#06281E] dark:text-white">{{ $paquete->nombre }}</p>
                                            <span class="mt-1 inline-flex rounded-md border border-[#06281E]/20 px-2 py-0.5 text-[10px] font-semibold uppercase text-[#06281E] dark:border-[#00D65B]/30 dark:text-[#00D65B]">
                                                {{ $detalle?->duracion_dias ?? 0 }} dia{{ ($detalle?->duracion_dias ?? 0) === 1 ? '' : 's' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="max-w-[340px] p-4 align-middle">
                                    <p class="line-clamp-2 whitespace-normal text-xs leading-relaxed text-gray-600 dark:text-gray-300" title="{{ $paquete->descripcion }}">
                                        {{ $paquete->descripcion ?? 'Sin descripcion detallada.' }}
                                    </p>
                                    <p class="mt-1.5 line-clamp-1 whitespace-normal text-[11px] italic text-[#007f36] dark:text-green-300" title="{{ $detalle?->servicios_incluidos }}">
                                        Incluye: {{ $detalle?->servicios_incluidos ?? 'Sin informacion detallada.' }}
                                    </p>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="min-w-[170px] space-y-1 text-xs text-gray-600 dark:text-gray-300">
                                        <p class="font-medium text-gray-800 dark:text-gray-100">{{ $detalle?->lugar_salida ?? 'Por definir' }}</p>
                                        <p>{{ $detalle?->hora_salida ? \Carbon\Carbon::parse($detalle->hora_salida)->format('H:i') : '--:--' }}</p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap p-4 align-middle">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200" title="{{ $paquete->imagenes->count() }} imagenes registradas">
                                        <svg class="size-4 text-[#00A344] dark:text-[#00D65B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $paquete->imagenes->count() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap p-4 align-middle font-bold text-[#00A344] dark:text-[#00D65B]">
                                    ${{ number_format($paquete->precio, 2) }}
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex min-w-[184px] items-center justify-end gap-2">
                                        <button type="button"
                                                @click="$dispatch('abrir-detalle-servicio', { servicioId: {{ $paquete->id }} })"
                                                title="Ver detalle"
                                                aria-label="Ver detalle de {{ $paquete->nombre }}"
                                                class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg border border-gray-300 bg-white text-[#31552b] transition-colors hover:border-[#06281E] hover:bg-[#06281E] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-zinc-600 dark:bg-zinc-800 dark:text-green-300 dark:hover:bg-white dark:hover:text-[#06281E]">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <x-botones-servicio-card :servicio="$paquete" :solo-iconos="true" delete-action="eliminarPaquete" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($paquetes as $paquete)
                    <x-servicio-card
                        :servicio="$paquete"
                        delete-action="eliminarPaquete"
                        wire:key="paquete-{{ $paquete->id }}" />
                @endforeach
            </div>
        @endif

        @if($paquetes->hasPages())
            <div class="mt-8">
                {{ $paquetes->links() }}
            </div>
        @endif

        @livewire('emprendimiento.gestion-servicios.editar-paquete')
    @endif
</div>
