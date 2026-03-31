<div class="w-full px-4 pt-2 pb-8">
    <h1 class="mb-4 text-2xl font-bold text-zinc-900 dark:text-white">Nuevo Emprendimiento_1</h1>

    <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex flex-col lg:flex-row">
            
            <div class="w-full border-b border-zinc-100 bg-zinc-50/50 p-6 lg:w-72 lg:border-b-0 lg:border-r dark:bg-zinc-800/20 dark:border-zinc-800">
                <h2 class="mb-6 text-xl font-bold text-zinc-900 lg:mb-10 dark:text-white">Registro</h2>
                <nav>
                    <ol class="flex flex-row overflow-x-auto gap-8 pb-4 lg:flex-col lg:gap-12 lg:overflow-visible lg:pb-0 scrollbar-hide">
                        <li class="flex shrink-0 items-center gap-3">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 text-xs font-bold transition-all
                                {{ $step >= 1 ? 'border-zinc-900 bg-zinc-900 text-white shadow-md' : 'border-zinc-300 bg-white text-zinc-400' }}">
                                @if($step > 1) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else 1 @endif
                            </span>
                            <div>
                                <p class="text-sm font-bold {{ $step >= 1 ? 'text-zinc-900' : 'text-zinc-400' }}">Emprendedor</p>
                                <p class="text-[10px] text-zinc-500 uppercase tracking-wider">Datos Personales</p>
                            </div>
                        </li>
                        <li class="flex shrink-0 items-center gap-3">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 text-xs font-bold transition-all
                                {{ $step >= 2 ? 'border-zinc-900 bg-zinc-900 text-white shadow-md' : 'border-zinc-300 bg-white text-zinc-400' }}">
                                @if($step > 2) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else 2 @endif
                            </span>
                            <div>
                                <p class="text-sm font-bold {{ $step >= 2 ? 'text-zinc-900' : 'text-zinc-400' }}">Emprendimiento</p>
                                <p class="text-[10px] text-zinc-500 uppercase tracking-wider">Información General</p>
                            </div>
                        </li>
                        <li class="flex shrink-0 items-center gap-3">
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-full border-2 text-xs font-bold transition-all
                                {{ $step == 3 ? 'border-zinc-900 bg-zinc-900 text-white shadow-md' : 'border-zinc-300 bg-white text-zinc-400' }}">
                                3
                            </span>
                            <div>
                                <p class="text-sm font-bold {{ $step == 3 ? 'text-zinc-900' : 'text-zinc-400' }}">Finalizar</p>
                                <p class="text-[10px] text-zinc-500 uppercase tracking-wider">Confirmar</p>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="flex-1 p-6 lg:p-10">
                <div class="min-h-[400px]">
                    @if ($step === 1)
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold">Datos Personales</h3>
                            <x-formulario-usuario prefix="datosUsuario." />
                        </div>
                    @endif

                    @if ($step === 2)
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold">Perfil del Emprendimiento</h3>
                            <flux:input wire:model.blur="nombre_emprendimiento" label="Nombre comercial del emprendimiento" />
                            <flux:textarea wire:model.blur="descripcion" label="Descripción detallada" rows="6" />
                        </div>
                    @endif

                    @if ($step === 3)
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold">Resumen de Datos</h3>
                            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-800 dark:bg-zinc-800/50">
                                <div class="grid grid-cols-1 gap-y-6 md:grid-cols-2">
                                    <div>
                                        <p class="mb-1 text-xs font-bold uppercase text-zinc-500">Representante Legal</p>
                                        <p class="text-sm font-medium">{{ $datosUsuario->nombre }} {{ $datosUsuario->apellidos }}</p>
                                        <p class="text-sm text-zinc-600">CI: {{ $datosUsuario->cedula }}</p>
                                    </div>
                                    <div>
                                        <p class="mb-1 text-xs font-bold uppercase text-zinc-500">Contacto</p>
                                        <p class="text-sm font-medium">{{ $datosUsuario->email }}</p>
                                        <p class="text-sm text-zinc-600">Tel: {{ $datosUsuario->telefono }}</p>
                                    </div>
                                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700 md:col-span-2">
                                        <p class="mb-1 text-xs font-bold uppercase text-zinc-500">Emprendimiento</p>
                                        <p class="text-sm font-medium">{{ $nombre_emprendimiento }}</p>
                                        <p class="mt-1 text-sm text-zinc-600">{{ $descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-10 flex flex-wrap items-center justify-between gap-4 border-t border-zinc-100 pt-6">
                    
                    {{-- Botón Cancelar (Estilo Danger) --}}
                    <a href="{{ route('admin.emprendimientos.gestion') }}" wire:navigate
                        class="whitespace-nowrap rounded-lg bg-danger border border-danger px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75">
                        Cancelar Registro
                    </a>

                    <div class="flex gap-4">
                        {{-- Botón Atrás (Estilo Alternate) --}}
                        @if ($step > 1)
                            <button type="button" wire:click="atras"
                                class="whitespace-nowrap rounded-lg bg-zinc-100 border border-zinc-200 px-4 py-2 text-sm font-medium tracking-wide text-zinc-700 transition hover:bg-zinc-200">
                                Atrás
                            </button>
                        @endif
                        
                        {{-- Botones de Acción (Continuar / Success) --}}
                        @if ($step < 3)
                            <flux:button wire:click="siguiente" variant="primary" color="lime">Continuar</flux:button>
                        @else
                            <button type="button" wire:click="guardar"
                                class="whitespace-nowrap rounded-lg bg-success border border-success px-4 py-2 text-sm font-medium tracking-wide text-white transition hover:opacity-75">
                                Guardar Registro
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>