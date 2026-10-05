<div x-data="{ show: @entangle('abierto') }"
     x-show="show"
     x-on:keydown.escape.window="if (show) $wire.cerrar()"
     @click.self="$wire.cerrar()"
     class="fixed inset-0 z-[80] flex items-center justify-center bg-gray-950/65 p-3 backdrop-blur-sm sm:p-6"
     role="dialog"
     aria-modal="true"
     aria-labelledby="detalle-servicio-titulo"
     style="display: none;">
    @if($servicio)
        @php
            $tipoId = $servicio->tipo_real_id;
            $tipoNombre = $servicio->categoriaPivot?->tipoServicio?->nombre ?? 'Servicio';
            $detallePaquete = $servicio->detallePaqueteTuristico;
        @endphp

        <div @click.stop
             class="flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-white/10 dark:bg-zinc-900">
            <header class="z-10 flex shrink-0 items-start justify-between gap-4 border-b border-gray-200 bg-white px-5 py-4 dark:border-white/10 dark:bg-zinc-900 sm:px-6">
                <div class="min-w-0">
                    <span class="inline-flex rounded-md bg-[#e4eccf] px-2.5 py-1 text-[10px] font-bold uppercase text-[#31552b]">
                        {{ $tipoNombre }}
                    </span>
                    <h2 id="detalle-servicio-titulo" class="mt-2 break-words text-xl font-bold text-[#06281E] dark:text-white sm:text-2xl">
                        {{ $servicio->nombre }}
                    </h2>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Información completa del servicio</p>
                </div>

                <button type="button"
                        wire:click="cerrar"
                        title="Cerrar detalle"
                        aria-label="Cerrar detalle"
                        class="inline-flex size-9 shrink-0 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:hover:bg-white/10 dark:hover:text-white">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </header>

            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5 sm:px-6 sm:py-6">
                @switch($tipoId)
                    @case(\App\Models\Servicio::TIPO_HOSPEDAJE)
                        <section>
                            <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">Detalles de la Habitación</h3>
                            <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                <x-detalle-servicio-campo etiqueta="Nombre de la Habitación" :valor="$servicio->nombre" />
                                <x-detalle-servicio-campo etiqueta="Capacidad (Personas)" :valor="$servicio->detalleHospedaje?->capacidad" />
                                <x-detalle-servicio-campo etiqueta="Precio por Noche ($)" :valor="'$' . number_format((float) $servicio->precio, 2)" />
                                <x-detalle-servicio-campo etiqueta="Stock por Día (Habitaciones disponibles)" :valor="$servicio->stock" />
                                <x-detalle-servicio-campo etiqueta="Descripción de la habitación" :valor="$servicio->descripcion" amplio />
                            </dl>
                        </section>
                        @break

                    @case(\App\Models\Servicio::TIPO_ALIMENTACION)
                        <section>
                            <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">Detalles del Plato</h3>
                            <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                <x-detalle-servicio-campo etiqueta="Nombre del Plato/Menú" :valor="$servicio->nombre" />
                                <x-detalle-servicio-campo etiqueta="Tipo de Alimentación" :valor="$servicio->detalleAlimentacion?->tipo_alimentacion" />
                                <x-detalle-servicio-campo etiqueta="Lugar donde se sirve" :valor="$servicio->detalleAlimentacion?->lugar_alimentacion" />
                                <x-detalle-servicio-campo etiqueta="Precio ($)" :valor="'$' . number_format((float) $servicio->precio, 2)" />
                                <x-detalle-servicio-campo etiqueta="Descripción e Ingredientes" :valor="$servicio->descripcion" amplio />
                            </dl>
                        </section>
                        @break

                    @case(\App\Models\Servicio::TIPO_GUIANZA)
                        <section>
                            <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">Detalles del Servicio de Guía</h3>
                            <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                <x-detalle-servicio-campo etiqueta="Máximo de Personas (por Guía)" :valor="$servicio->detalleGuianza?->numero_max_persona" />
                                <x-detalle-servicio-campo etiqueta="Precio ($)" :valor="'$' . number_format((float) $servicio->precio, 2)" />
                                <x-detalle-servicio-campo etiqueta="Guías disponibles por día" :valor="$servicio->stock" />
                                <x-detalle-servicio-campo etiqueta="Lugares y rutas que puede guiar" :valor="$servicio->descripcion" amplio />
                            </dl>
                        </section>
                        @break

                    @case(\App\Models\Servicio::TIPO_ALQUILER)
                        <section>
                            <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">Detalles del Equipo</h3>
                            <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                <x-detalle-servicio-campo etiqueta="Nombre del Equipo" :valor="$servicio->nombre" />
                                <x-detalle-servicio-campo etiqueta="Precio por Unidad ($)" :valor="'$' . number_format((float) $servicio->precio, 2)" />
                                <x-detalle-servicio-campo etiqueta="Stock por Día (Cantidad disponible)" :valor="$servicio->stock" />
                                <x-detalle-servicio-campo etiqueta="Descripción y Condiciones" :valor="$servicio->descripcion" amplio />
                            </dl>
                        </section>
                        @break

                    @case(\App\Models\Servicio::TIPO_PAQUETE)
                        <div class="space-y-7">
                            <section>
                                <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">1. Información de venta</h3>
                                <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                    <x-detalle-servicio-campo etiqueta="Nombre del paquete" :valor="$servicio->nombre" />
                                    <x-detalle-servicio-campo etiqueta="Precio por persona" :valor="'$' . number_format((float) $servicio->precio, 2)" />
                                    <x-detalle-servicio-campo etiqueta="Stock por día (Cupos disponibles)" :valor="$servicio->stock" />
                                </dl>
                            </section>

                            <section>
                                <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">2. Duración y salida</h3>
                                <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                    <x-detalle-servicio-campo etiqueta="Días de duración" :valor="$detallePaquete?->duracion_dias" />
                                    <x-detalle-servicio-campo etiqueta="Punto de encuentro" :valor="$detallePaquete?->lugar_salida" />
                                    <x-detalle-servicio-campo etiqueta="Hora de inicio" :valor="$detallePaquete?->hora_salida ? \Carbon\Carbon::parse($detallePaquete->hora_salida)->format('H:i') : null" />
                                </dl>
                            </section>

                            <section>
                                <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">3. Experiencia e itinerario</h3>
                                <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                    <x-detalle-servicio-campo etiqueta="Resumen general" :valor="$servicio->descripcion" amplio />
                                    <x-detalle-servicio-campo etiqueta="Itinerario detallado" :valor="$detallePaquete?->lugares_actividades" />
                                    <x-detalle-servicio-campo etiqueta="¿Qué incluye?" :valor="$detallePaquete?->servicios_incluidos" />
                                    <x-detalle-servicio-campo etiqueta="Recomendaciones para el turista" :valor="$detallePaquete?->recomendaciones" amplio />
                                </dl>
                            </section>

                            <section>
                                <h3 class="mb-3 text-sm font-bold text-[#06281E] dark:text-white">4. Documentación adicional</h3>
                                <div class="border-b border-gray-100 pb-3 dark:border-white/10">
                                    <p class="text-[11px] font-semibold uppercase text-gray-500 dark:text-gray-400">Itinerario PDF (Opcional)</p>
                                    @if(filled($detallePaquete?->documento))
                                        <a href="{{ Storage::url($detallePaquete->documento) }}"
                                           target="_blank"
                                           rel="noopener"
                                           class="mt-2 inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-[#31552b] transition hover:bg-[#e4eccf] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#31552b] dark:border-white/15 dark:bg-zinc-800 dark:text-green-300 dark:hover:bg-white/10">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                                            </svg>
                                            Ver itinerario PDF
                                        </a>
                                    @else
                                        <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">No registrado</p>
                                    @endif
                                </div>

                                @if(filled($detallePaquete?->mensaje_pago))
                                    <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                        <x-detalle-servicio-campo etiqueta="Mensaje para el pago" :valor="$detallePaquete->mensaje_pago" amplio />
                                    </dl>
                                @endif
                            </section>
                        </div>
                        @break

                    @default
                        <section>
                            <h3 class="mb-2 text-sm font-bold text-[#06281E] dark:text-white">Información del servicio</h3>
                            <dl class="grid grid-cols-1 gap-x-8 sm:grid-cols-2">
                                <x-detalle-servicio-campo etiqueta="Nombre" :valor="$servicio->nombre" />
                                <x-detalle-servicio-campo etiqueta="Precio ($)" :valor="'$' . number_format((float) $servicio->precio, 2)" />
                                <x-detalle-servicio-campo etiqueta="Stock" :valor="$servicio->stock" />
                                <x-detalle-servicio-campo etiqueta="Descripción" :valor="$servicio->descripcion" amplio />
                            </dl>
                        </section>
                @endswitch

                @if($servicio->permite_galeria)
                    <section class="mt-7 border-t border-gray-200 pt-7 dark:border-white/10">
                        <div class="mb-3 flex items-center justify-between gap-3">
                            <h3 class="text-sm font-bold text-[#06281E] dark:text-white">Imágenes del servicio</h3>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                {{ $servicio->imagenes->count() }} de 5
                            </span>
                        </div>

                        @if($servicio->imagenes->isNotEmpty())
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                                @foreach($servicio->imagenes as $imagen)
                                    <a href="{{ Storage::url($imagen->imagen) }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="group relative aspect-[4/3] overflow-hidden rounded-lg border border-gray-200 bg-gray-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-white/10 dark:bg-zinc-800"
                                       title="Abrir imagen completa">
                                        <img src="{{ Storage::url($imagen->imagen) }}"
                                             alt="Imagen de {{ $servicio->nombre }}"
                                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                             loading="lazy">
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="flex min-h-28 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 text-center text-sm text-gray-500 dark:border-white/15 dark:bg-white/5 dark:text-gray-400">
                                Este servicio todavía no tiene imágenes registradas.
                            </div>
                        @endif
                    </section>
                @endif
            </div>

            <footer class="flex shrink-0 justify-end border-t border-gray-200 bg-gray-50 px-5 py-3 dark:border-white/10 dark:bg-zinc-800/60 sm:px-6">
                <button type="button"
                        wire:click="cerrar"
                        class="rounded-xl bg-[#06281E] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0b3a2c] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:bg-[#00D65B] dark:text-[#06281E] dark:hover:bg-[#22e675]">
                    Cerrar
                </button>
            </footer>
        </div>
    @endif
</div>
