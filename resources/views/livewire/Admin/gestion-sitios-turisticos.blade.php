<div class="p-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Sitios Turísticos</h2>
            <p class="text-slate-500 mt-1 text-sm">Gestiona los atractivos turísticos de la región</p>
        </div>

        <button wire:click="abrirModal"
            class="bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-3 rounded-2xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 font-semibold">
            <span class="text-lg">➕</span> Agregar Sitio
        </button>
    </div>

    @if (session()->has('mensaje'))
        <div class="mb-6 p-4 bg-green-800 text-white rounded-2xl shadow-lg">
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- 🔥 GRID CORREGIDO (MENOS ESPACIO + MÁS ORDEN) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

        @foreach ($sitios as $sitio)
            <div class="group relative bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-emerald-950/5 hover:-translate-y-1 hover:z-10 transition-all duration-300 flex flex-col overflow-hidden">

                <!-- IMAGEN -->
                <div class="relative h-52 overflow-hidden bg-slate-100">
                    @if ($sitio->publicacion->imagenes->first())
                        <img src="{{ asset('storage/' . $sitio->publicacion->imagenes->first()->imagen) }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:opacity-0">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-emerald-600/40 font-medium">
                            🖼️ Sin imagen configurada
                        </div>
                    @endif

                    <!-- GALERÍA HOVER -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-500">
                        <div x-data="{ index: 0 }" class="relative w-full h-full">
                            @foreach ($sitio->publicacion->imagenes->take(5) as $i => $img)
                                <img x-show="index === {{ $i }}"
                                    src="{{ asset('storage/' . $img->imagen) }}"
                                    class="absolute w-full h-full object-cover transition duration-300">
                            @endforeach

                            <button @click="index = (index === 0) ? {{ $sitio->publicacion->imagenes->take(5)->count() - 1 }} : index - 1"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-slate-900/60 text-white w-7 h-7 flex items-center justify-center rounded-full">
                                ‹
                            </button>

                            <button @click="index = (index === {{ $sitio->publicacion->imagenes->take(5)->count() - 1 }}) ? 0 : index + 1"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-slate-900/60 text-white w-7 h-7 flex items-center justify-center rounded-full">
                                ›
                            </button>
                        </div>
                    </div>
                </div>

                <!-- CONTENIDO -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 group-hover:text-emerald-700 transition tracking-tight line-clamp-1">
                            {{ $sitio->publicacion->nombre }}
                        </h3>

                        <p class="text-slate-400 text-sm mt-1 line-clamp-2 leading-relaxed">
                            {{ $sitio->publicacion->descripcion }}
                        </p>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="p-3 grid grid-cols-3 gap-2 bg-slate-50/60 border-t border-slate-100/80">

                    <button type="button"
                        x-on:click="$flux.modal('detalle-sitio-{{ $sitio->publicacion_id }}').show()"
                        class="bg-slate-100/80 hover:bg-slate-200 text-slate-700 py-2 rounded-xl flex items-center justify-center gap-1 text-xs font-semibold">
                        👁️ Ver
                    </button>

                    <button type="button" wire:click="editar({{ $sitio->publicacion_id }})"
                        class="bg-amber-50 hover:bg-amber-100 text-amber-700 py-2 rounded-xl flex items-center justify-center gap-1 text-xs font-semibold">
                        ✏️ Editar
                    </button>

                    <button type="button" wire:click="eliminarSitio({{ $sitio->publicacion_id }})"
                        class="bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-xl flex items-center justify-center gap-1 text-xs font-semibold">
                        🗑️ Quitar
                    </button>

                </div>
            </div>

            <!-- MODAL DETALLE -->
            <flux:modal name="detalle-sitio-{{ $sitio->publicacion_id }}" class="md:w-2/4">
                <div class="p-6 bg-white rounded-3xl text-slate-800">
                    <h2 class="text-2xl font-bold mb-4 tracking-tight">
                        {{ $sitio->publicacion->nombre }}
                    </h2>

                    <p class="text-slate-600 text-sm mb-4">
                        {{ $sitio->publicacion->descripcion }}
                    </p>

                    <div class="grid grid-cols-3 gap-2 mt-4">
                        @foreach($sitio->publicacion->imagenes as $img)
                            <img src="{{ asset('storage/' . $img->imagen) }}"
                                class="w-full h-24 object-cover rounded-xl border border-slate-100">
                        @endforeach
                    </div>
                </div>
            </flux:modal>
        @endforeach

    </div>

    <!-- MODAL FORM -->
    @if ($mostrarModal)
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-3xl p-6 sm:p-8 w-full max-w-lg shadow-2xl border border-slate-100">

                <h2 class="text-2xl font-bold mb-6">
                    {{ $modoEdicion ? '📝 Actualizar Sitio Turístico' : '🌄 Registrar Sitio Turístico' }}
                </h2>

                <div class="space-y-4">
                    <input type="text" wire:model="nombre" placeholder="Nombre"
                        class="w-full p-3 rounded-xl border bg-slate-50">

                    <textarea wire:model="descripcion" rows="3"
                        class="w-full p-3 rounded-xl border bg-slate-50"
                        placeholder="Descripción"></textarea>

                    <input type="file" wire:model.live="imagenes" multiple
                        class="w-full p-2 border rounded-xl bg-slate-50">
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="cerrarModal"
                        class="px-5 py-2 rounded-xl bg-slate-100">
                        Cancelar
                    </button>

                    <button wire:click="guardar"
                        class="px-6 py-2 rounded-xl bg-emerald-700 text-white">
                        Guardar
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>