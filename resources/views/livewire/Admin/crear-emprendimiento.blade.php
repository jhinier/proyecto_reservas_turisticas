<div class="w-full px-4 pt-2 pb-8" wire:key="main-wizard-container">
    @if (session('status'))
        <div class="mb-6 relative w-full overflow-hidden rounded-radius border border-green-500 bg-surface text-on-surface dark:bg-zinc-900 dark:text-zinc-100 shadow-sm" role="alert">
            <div class="flex w-full items-center gap-2 bg-success/10 p-4 dark:bg-green-900/20">
                <div class="bg-green-500/15 text-green-500 rounded-full p-1 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex w-full flex-col items-center justify-between gap-2 ml-2 sm:flex-row">
                    <div>
                        <h3 class="text-sm font-semibold text-success dark:text-green-400">Acción Completada</h3>
                        <p class="text-xs font-medium sm:text-sm">{{ session('status') }}</p>
                    </div>
                    <a href="{{ route('admin.emprendimientos.gestion') }}" wire:navigate class="whitespace-nowrap ml-auto text-sm font-medium text-success dark:text-green-400 hover:opacity-75 transition">
                        Ver Lista
                    </a>
                </div>
            </div>
        </div>
    @endif

    <h1 class="mb-6 text-2xl font-bold text-zinc-900 dark:text-white">Nuevo Emprendimiento</h1>

    <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-[#18181B]">
        <div class="flex flex-col lg:flex-row">
            
            <div class="w-full border-b border-zinc-100 bg-zinc-50/50 p-6 lg:w-80 lg:border-b-0 lg:border-r lg:p-10 dark:bg-zinc-900/50 dark:border-zinc-800">
                <nav>
                    <ol class="flex flex-row justify-around gap-2 lg:flex-col lg:gap-14" aria-label="registration progress">
                        @foreach(['Emprendedor' => 'DATOS PERSONALES', 'Negocio' => 'INFORMACIÓN GENERAL', 'Finalizar' => 'CONFIRMAR'] as $label => $sub)
                            @php $i = $loop->iteration; @endphp
                            <li class="flex flex-col items-center gap-2 lg:flex-row lg:gap-4" wire:key="step-indicator-{{ $i }}">
                                <div class="relative">
                                    @if($i > 1) <div class="absolute bottom-9 left-3.5 hidden h-12 w-0.5 lg:block {{ $step >= $i ? 'bg-primary dark:bg-blue-600' : 'bg-zinc-200 dark:bg-zinc-700' }}"></div> @endif
                                    
                                    <span class="flex size-7 shrink-0 items-center justify-center rounded-full border {{ $step > $i ? 'bg-primary text-white border-primary dark:bg-blue-600 dark:border-blue-600' : ($step == $i ? 'bg-primary text-white border-primary outline outline-2 outline-offset-2 outline-primary dark:bg-blue-600 dark:border-blue-600 dark:outline-blue-600' : 'bg-zinc-100 border-zinc-200 text-zinc-400 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-500') }}">
                                        @if($step > $i) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else {{ $i }} @endif
                                    </span>
                                </div>
                                <div class="text-center lg:text-left">
                                    <span class="block text-[9px] font-bold uppercase lg:text-sm {{ $step >= $i ? 'text-primary dark:text-blue-500' : 'text-zinc-400 dark:text-zinc-500' }}">{{ $label }}</span>
                                    <span class="hidden text-[10px] text-zinc-500 lg:block dark:text-zinc-400">{{ $sub }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>

            <div class="flex-1 p-6 lg:p-12">
                <div class="min-h-[420px]" wire:key="step-content-{{ $step }}">
                    
                    @if ($step === 1)
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold dark:text-white">Datos Personales</h3>
                            <x-formulario-usuario prefix="datosUsuario." />
                        </div>
                    @endif

                    @if ($step === 2)
                        <div class="space-y-8">
                            <h3 class="text-xl font-bold dark:text-white">Perfil del Emprendimiento</h3>
                            
                            {{-- Input Componentizado --}}
                            <x-input-form 
                                id="nombre_emprendimiento" 
                                label="Nombre del Emprendimiento" 
                                model="nombre_emprendimiento" 
                                placeholder="Ej: Hostelería la Candelaria" 
                            />

                            {{-- Textarea Descripción --}}
                            <div class="flex w-full flex-col gap-1 text-on-surface dark:text-zinc-200">
                                <label class="flex w-fit items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has('descripcion') ? 'text-danger dark:text-red-400' : 'text-zinc-700 dark:text-zinc-300' }}">
                                    Descripción Detallada
                                </label>
                                <textarea wire:model.blur="descripcion" rows="4" class="w-full rounded-radius border {{ $errors->has('descripcion') ? 'border-danger dark:border-red-500' : 'border-outline dark:border-zinc-700' }} bg-surface-alt px-3 py-2 text-sm focus:outline-none focus:border-primary dark:bg-zinc-800/50 dark:text-white dark:focus:border-blue-500 transition-colors" placeholder="Describe tu negocio..."></textarea>
                                @error('descripcion') <small class="text-danger dark:text-red-400">{{ $message }}</small> @enderror
                            </div>

                            {{-- Subida de Imagen --}}
                            <div class="flex w-full flex-col gap-1 text-on-surface dark:text-zinc-200">
                                <label class="flex w-fit items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has('imagen') ? 'text-danger dark:text-red-400' : 'text-zinc-700 dark:text-zinc-300' }}">
                                    Logo o Imagen Principal
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="relative w-full max-w-sm">
                                        <input type="file" wire:model="imagen" accept="image/*" class="w-full rounded-radius border {{ $errors->has('imagen') ? 'border-danger dark:border-red-500' : 'border-outline dark:border-zinc-700' }} bg-surface-alt px-3 py-2 text-sm text-zinc-600 file:mr-4 file:rounded-full file:border-0 file:bg-primary/10 file:px-4 file:py-1 file:text-sm file:font-semibold file:text-primary hover:file:bg-primary/20 focus:outline-none dark:bg-zinc-800/50 dark:text-zinc-300 dark:file:bg-blue-900/30 dark:file:text-blue-400" />
                                        <div wire:loading wire:target="imagen" class="absolute right-3 top-2.5 text-sm text-primary dark:text-blue-400">Cargando...</div>
                                    </div>
                                    @if ($imagen)
                                        <div class="size-16 shrink-0 rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 shadow-sm">
                                            <img src="{{ $imagen->temporaryUrl() }}" class="size-full object-cover">
                                        </div>
                                    @endif
                                </div>
                                @error('imagen') <small class="text-danger dark:text-red-400">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    @if ($step === 3)
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold dark:text-white">Resumen Final</h3>
                            
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <article class="flex flex-col rounded-radius border border-outline bg-surface-alt p-6 dark:bg-zinc-800/50 dark:border-zinc-700">
                                    <small class="mb-4 font-bold uppercase tracking-widest text-zinc-400 text-[11px] dark:text-zinc-500">Datos del Establecimiento</small>
                                    
                                    @if($imagen)
                                        <img src="{{ $imagen->temporaryUrl() }}" class="w-full h-32 object-cover rounded-xl mb-4 border border-zinc-200 dark:border-zinc-700">
                                    @endif

                                    <h3 class="text-2xl font-bold text-on-surface-strong mb-4 break-words dark:text-white">{{ $nombre_emprendimiento }}</h3>
                                    <p class="mb-4 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                        {{ filled($descripcion) ? $descripcion : 'Sin descripción registrada.' }}
                                    </p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Estado: <span class="text-success dark:text-green-400 font-bold">Activo</span></p>
                                </article>

                                <article class="flex flex-col rounded-radius border border-outline bg-surface-alt p-6 dark:bg-zinc-800/50 dark:border-zinc-700">
                                    <small class="mb-4 font-bold uppercase tracking-widest text-zinc-400 text-[11px] dark:text-zinc-500">Responsable</small>
                                    <h3 class="text-xl font-bold text-on-surface-strong mb-2 dark:text-white">{{ $datosUsuario->nombre }} {{ $datosUsuario->apellidos }}</h3>
                                    <div class="space-y-1 text-sm text-zinc-600 dark:text-zinc-400">
                                        <p>CI: {{ $datosUsuario->cedula }}</p>
                                        <p>Telf: {{ $datosUsuario->telefono }}</p>
                                        <p class="break-all font-medium text-primary dark:text-blue-400">{{ $datosUsuario->email }}</p>
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-zinc-100 pt-8 dark:border-zinc-800" wire:key="nav-buttons">
                    <a href="{{ route('admin.emprendimientos.gestion') }}" wire:navigate
                        class="w-full sm:w-auto text-center bg-transparent rounded-radius border border-danger px-6 py-2.5 text-sm font-medium tracking-wide text-danger transition hover:bg-danger/5 dark:border-red-500 dark:text-red-500 dark:hover:bg-red-500/10">
                        Cancelar Registro
                    </a>

                    <div class="flex flex-col gap-3 sm:flex-row w-full sm:w-auto">
                        @if ($step > 1)
                            <button type="button" wire:click="atras"
                                class="w-full sm:w-auto bg-transparent rounded-radius border border-outline px-6 py-2.5 text-sm font-medium tracking-wide text-zinc-500 transition hover:opacity-75 dark:border-zinc-700 dark:text-zinc-400 dark:hover:text-white">
                                Atrás
                            </button>
                        @endif
                        
                        @if ($step < 3)
                            <button type="button" wire:click="siguiente"
                                class="w-full sm:w-auto rounded-radius bg-surface-dark border border-surface-dark px-10 py-2.5 text-sm font-medium tracking-wide text-white transition hover:opacity-90 dark:bg-blue-600 dark:border-blue-600">
                                Continuar
                            </button>
                        @else
                            <button type="button" wire:click="guardar" wire:loading.attr="disabled"
                                class="w-full sm:w-auto rounded-radius bg-success border border-success px-10 py-2.5 text-sm font-medium tracking-wide text-white transition shadow-lg shadow-success/20 dark:bg-green-600 dark:border-green-600 dark:shadow-none flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="guardar">Guardar Registro</span>
                                <span wire:loading wire:target="guardar">Procesando...</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
