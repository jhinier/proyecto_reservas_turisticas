<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">Configuración del emprendimiento</flux:heading>

    <x-settings.layout
        heading="Datos del emprendimiento"
        subheading="Actualiza la información pública de tu emprendimiento"
    >
        <form wire:submit="guardar" class="my-6 w-full space-y-8">
            <section class="space-y-4">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Imagen del emprendimiento</h3>

                <div class="flex flex-col items-center gap-4 sm:flex-row sm:items-center">
                    <div class="relative flex size-28 shrink-0 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-emerald-50 text-3xl font-bold text-emerald-700 shadow ring-1 ring-zinc-200 dark:border-zinc-900 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-white/10">
                        @if ($imagen)
                            <img src="{{ $imagen->temporaryUrl() }}" alt="Vista previa de {{ $nombre }}" class="h-full w-full object-cover">
                        @elseif ($imagenActual)
                            <img src="{{ Storage::url($imagenActual) }}" alt="Imagen de {{ $nombre }}" class="h-full w-full object-cover">
                        @else
                            <span aria-hidden="true">{{ Str::upper(Str::substr($nombre, 0, 1)) }}</span>
                        @endif

                        <div wire:loading.flex wire:target="imagen" class="absolute inset-0 items-center justify-center bg-white/80 dark:bg-zinc-900/80">
                            <flux:icon.loading class="size-6 text-emerald-600" />
                        </div>
                    </div>

                    <div class="flex min-w-0 flex-col items-center gap-2 sm:items-start">
                        <label class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 transition-colors hover:border-emerald-600 hover:text-emerald-700 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-emerald-600 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:border-emerald-400 dark:hover:text-emerald-300">
                            <input id="imagen-emprendimiento" wire:model="imagen" type="file" accept="image/jpeg,image/png,image/webp" class="sr-only">
                            <flux:icon.camera class="size-4" />
                            Cambiar imagen
                        </label>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">JPG, PNG o WEBP. Máximo 5 MB.</p>
                        @error('imagen')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="space-y-5 border-t border-zinc-200 pt-6 dark:border-white/10">
                <flux:input
                    :value="$nombre"
                    label="Nombre del emprendimiento"
                    type="text"
                    readonly
                />

                <flux:textarea
                    wire:model.blur="descripcion"
                    label="Descripción"
                    rows="5"
                    maxlength="300"
                    required
                />
            </section>

            <section class="space-y-4 border-t border-zinc-200 pt-6 dark:border-white/10">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Redes sociales</h3>

                    <button
                        type="button"
                        wire:click="agregarRedSocial"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 transition-colors hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 sm:w-auto dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:bg-emerald-400/20"
                    >
                        <flux:icon.plus class="size-4" />
                        Agregar red social
                    </button>
                </div>

                @error('redes')
                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                <div class="space-y-3">
                    @foreach ($redes as $index => $red)
                        <div class="grid grid-cols-[minmax(0,1fr)_2.5rem] items-end gap-2" wire:key="red-social-{{ $red['id'] }}">
                            <flux:input
                                wire:model.blur="redes.{{ $index }}.url"
                                :label="'Red social '.($index + 1)"
                                type="url"
                                placeholder="https://www.instagram.com/tu-emprendimiento"
                                inputmode="url"
                                autocomplete="url"
                            />

                            <button
                                type="button"
                                wire:click="eliminarRedSocial('{{ $red['id'] }}')"
                                class="inline-flex size-10 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 transition-colors hover:border-red-600 hover:bg-red-600 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 dark:border-red-500/30 dark:bg-zinc-800 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white"
                                title="Eliminar red social"
                                aria-label="Eliminar red social {{ $index + 1 }}"
                            >
                                <flux:icon.trash class="size-4" />
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="flex flex-col items-stretch gap-3 border-t border-zinc-200 pt-6 sm:flex-row sm:items-center dark:border-white/10">
                <flux:button
                    variant="primary"
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="guardar,imagen"
                    class="w-full bg-[#00D65B] text-[#06281E] transition-colors hover:bg-[#00c052] sm:w-auto"
                >
                    <span wire:loading.remove wire:target="guardar">Guardar cambios</span>
                    <span wire:loading wire:target="guardar">Guardando...</span>
                </flux:button>

                <x-action-message on="emprendimiento-updated">
                    Guardado.
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
