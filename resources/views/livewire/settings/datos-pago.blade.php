<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">Datos de pago</flux:heading>

    <x-settings.layout
        heading="Datos de pago"
        subheading="Administra las cuentas bancarias donde se reciben los pagos"
    >
        @if (session()->has('datos_pago_success'))
            <div class="my-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-200">
                {{ session('datos_pago_success') }}
            </div>
        @endif

        <form wire:submit="guardar" class="my-6 w-full space-y-8">
            <section class="space-y-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Cuentas bancarias</h3>

                    <button
                        type="button"
                        wire:click="agregarCuentaBancaria"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 transition-colors hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 sm:w-auto dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-300 dark:hover:bg-emerald-400/20"
                    >
                        <flux:icon.plus class="size-4" />
                        Agregar cuenta
                    </button>
                </div>

                <div class="space-y-4">
                    @forelse ($cuentasBancarias as $index => $cuenta)
                        <div
                            class="grid gap-3 rounded-lg border border-zinc-200 p-4 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_2.5rem] sm:items-end dark:border-white/10"
                            wire:key="cuenta-bancaria-{{ $cuenta['id'] }}"
                        >
                            <flux:input
                                wire:model.blur="cuentasBancarias.{{ $index }}.nombre_banco"
                                :label="'Banco '.($index + 1)"
                                type="text"
                                maxlength="120"
                                autocomplete="organization"
                            />

                            <flux:input
                                wire:model.blur="cuentasBancarias.{{ $index }}.numero_cuenta"
                                label="Numero de cuenta"
                                type="text"
                                maxlength="60"
                            />

                            <flux:input
                                wire:model.blur="cuentasBancarias.{{ $index }}.titular"
                                label="Titular"
                                type="text"
                                maxlength="150"
                                autocomplete="name"
                            />

                            <button
                                type="button"
                                wire:click="eliminarCuentaBancaria('{{ $cuenta['id'] }}')"
                                class="inline-flex size-10 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 transition-colors hover:border-red-600 hover:bg-red-600 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500 sm:justify-self-end dark:border-red-500/30 dark:bg-zinc-800 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white"
                                title="Eliminar cuenta bancaria"
                                aria-label="Eliminar cuenta bancaria {{ $index + 1 }}"
                            >
                                <flux:icon.trash class="size-4" />
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">No hay cuentas bancarias registradas.</p>
                    @endforelse
                </div>
            </section>

            <div class="flex flex-col items-stretch gap-3 border-t border-zinc-200 pt-6 sm:flex-row sm:items-center dark:border-white/10">
                <flux:button
                    variant="primary"
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="guardar"
                    class="w-full bg-[#00D65B] text-[#06281E] transition-colors hover:bg-[#00c052] sm:w-auto"
                >
                    <span wire:loading.remove wire:target="guardar">Guardar cambios</span>
                    <span wire:loading wire:target="guardar">Guardando...</span>
                </flux:button>

                <span class="text-sm text-zinc-500 dark:text-zinc-400" wire:loading wire:target="guardar">
                    Actualizando pagina...
                </span>
            </div>
        </form>
    </x-settings.layout>
</section>
