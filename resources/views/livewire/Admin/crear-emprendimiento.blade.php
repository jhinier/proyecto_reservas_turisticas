<div class="w-full px-4 pt-2 pb-8" wire:key="main-wizard-container">
    {{-- MENSAJE DE ÉXITO (Añadido) --}}
    @if (session('status'))
        <div class="mb-6 relative w-full overflow-hidden rounded-radius border border-green-500 bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark shadow-sm" role="alert">
            <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                <div class="bg-green-500/15 text-green-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex w-full flex-col items-center justify-between gap-2 ml-2 sm:flex-row">
                    <div>
                        <h3 class="text-sm font-semibold text-success">Acción Completada</h3>
                        <p class="text-xs font-medium sm:text-sm">{{ session('status') }}</p>
                    </div>
                    <a href="{{ route('admin.emprendimientos.gestion') }}" wire:navigate class="whitespace-nowrap ml-auto text-sm font-medium text-success hover:opacity-75 transition">
                        Ver Lista
                    </a>
                </div>
            </div>
        </div>
    @endif

    <h1 class="mb-6 text-2xl font-bold text-zinc-900 dark:text-white">Nuevo Emprendimiento</h1>
<div class="w-full px-4 pt-2 pb-8">
    <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="flex flex-col lg:flex-row">
            
            <div class="w-full border-b border-zinc-100 bg-zinc-50/50 p-6 lg:w-80 lg:border-b-0 lg:border-r lg:p-10 dark:bg-zinc-800/20 dark:border-zinc-800">
                <nav>
                    <ol class="flex flex-row justify-around gap-2 lg:flex-col lg:gap-14" aria-label="registration progress">
                        @foreach(['Emprendedor' => 'DATOS PERSONALES', 'Negocio' => 'INFORMACIÓN GENERAL', 'Finalizar' => 'CONFIRMAR'] as $label => $sub)
                            @php $i = $loop->iteration; @endphp
                            <li class="flex flex-col items-center gap-2 lg:flex-row lg:gap-4" wire:key="step-indicator-{{ $i }}">
                                <div class="relative">
                                    @if($i > 1) <div class="absolute bottom-9 left-3.5 hidden h-12 w-0.5 lg:block {{ $step >= $i ? 'bg-primary' : 'bg-outline' }}"></div> @endif
                                    
                                    <span class="flex size-7 shrink-0 items-center justify-center rounded-full border {{ $step > $i ? 'bg-primary text-white border-primary' : ($step == $i ? 'bg-primary text-white border-primary outline outline-2 outline-offset-2 outline-primary' : 'bg-surface-alt border-outline text-zinc-400') }}">
                                        @if($step > $i) <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else {{ $i }} @endif
                                    </span>
                                </div>
                                <div class="text-center lg:text-left">
                                    <span class="block text-[9px] font-bold uppercase lg:text-sm {{ $step >= $i ? 'text-primary' : 'text-zinc-400' }}">{{ $label }}</span>
                                    <span class="hidden text-[10px] text-zinc-500 lg:block">{{ $sub }}</span>
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
                            <h3 class="text-xl font-bold">Datos Personales</h3>
                            <x-formulario-usuario prefix="datosUsuario." />
                        </div>
                    @endif

                    @if ($step === 2)
                        <div class="space-y-8">
                            <h3 class="text-xl font-bold">Perfil del Emprendimiento</h3>
                            
                            {{-- Nombre del Emprendimiento --}}
                            @php $hasErrorNombre = $errors->has('nombre_emprendimiento'); $isSuccessNombre = filled($nombre_emprendimiento) && !$hasErrorNombre; @endphp
                            <div class="flex w-full flex-col gap-1 text-on-surface">
                                <label class="flex w-fit items-center gap-1 pl-0.5 text-sm font-medium {{ $hasErrorNombre ? 'text-danger' : ($isSuccessNombre ? 'text-success' : 'text-zinc-700') }}">
                                    @if($hasErrorNombre) <svg class="size-4" viewBox="0 0 16 16" fill="currentColor"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
                                    @elseif($isSuccessNombre) <svg class="size-4" viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg> @endif
                                    Nombre del Emprendimiento
                                </label>
                                <input wire:model.blur="nombre_emprendimiento" type="text" class="w-full rounded-radius border {{ $hasErrorNombre ? 'border-danger' : ($isSuccessNombre ? 'border-success' : 'border-outline') }} bg-surface-alt px-3 py-2 text-sm focus:outline-none dark:bg-zinc-900" placeholder="Ej: Hostelería la Candelaria" />
                                @error('nombre_emprendimiento') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- Descripción Detallada --}}
                            @php $hasErrorDesc = $errors->has('descripcion'); $isSuccessDesc = filled($descripcion) && !$hasErrorDesc; @endphp
                            <div class="flex w-full flex-col gap-1 text-on-surface">
                                <label class="flex w-fit items-center gap-1 pl-0.5 text-sm font-medium {{ $hasErrorDesc ? 'text-danger' : ($isSuccessDesc ? 'text-success' : 'text-zinc-700') }}">
                                    @if($hasErrorDesc) <svg class="size-4" viewBox="0 0 16 16" fill="currentColor"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
                                    @elseif($isSuccessDesc) <svg class="size-4" viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg> @endif
                                    Descripción Detallada
                                </label>
                                <textarea wire:model.blur="descripcion" rows="5" class="w-full rounded-radius border {{ $hasErrorDesc ? 'border-danger' : ($isSuccessDesc ? 'border-success' : 'border-outline') }} bg-surface-alt px-3 py-2 text-sm focus:outline-none dark:bg-zinc-900" placeholder="Describe tu negocio..."></textarea>
                                @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    @if ($step === 3)
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold">Resumen Final</h3>
                            
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <article class="flex flex-col rounded-radius border border-outline bg-surface-alt p-6 dark:bg-surface-dark-alt">
                                    <small class="mb-4 font-bold uppercase tracking-widest text-zinc-400 text-[11px]">Datos del Establecimiento</small>
                                    <h3 class="text-2xl font-bold text-on-surface-strong mb-4 break-words">{{ $nombre_emprendimiento }}</h3>
                                    <p class="text-sm text-zinc-500">Estado: <span class="text-success font-bold">Activo</span></p>
                                </article>

                                <article class="flex flex-col rounded-radius border border-outline bg-surface-alt p-6 dark:bg-surface-dark-alt">
                                    <small class="mb-4 font-bold uppercase tracking-widest text-zinc-400 text-[11px]">Responsable del emprendimiento</small>
                                    <h3 class="text-xl font-bold text-on-surface-strong mb-2">{{ $datosUsuario->nombre }} {{ $datosUsuario->apellidos }}</h3>
                                    <div class="space-y-1 text-sm text-zinc-600 dark:text-zinc-400">
                                        <p>CI: {{ $datosUsuario->cedula }}</p>
                                        <p>Edad: <span class="font-bold text-on-surface">{{ $datosUsuario->edad }} años</span></p>
                                        <p>Telf: {{ $datosUsuario->telefono }}</p>
                                        <p class="break-all font-medium text-primary">{{ $datosUsuario->email }}</p>
                                    </div>
                                </article>

                                <article class="md:col-span-2 flex flex-col rounded-radius border border-outline bg-surface-alt p-6 dark:bg-surface-dark-alt">
                                    <small class="mb-4 font-bold uppercase tracking-widest text-zinc-400 text-[11px]">Descripción General</small>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed italic">{{ $descripcion }}</p>
                                </article>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-zinc-100 pt-8 dark:border-zinc-800" wire:key="nav-buttons">
                    <a href="{{ route('admin.emprendimientos.gestion') }}" wire:navigate
                        class="w-full sm:w-auto text-center bg-transparent rounded-radius border border-danger px-6 py-2.5 text-sm font-medium tracking-wide text-danger transition hover:bg-danger/5">
                        Cancelar Registro
                    </a>

                    <div class="flex flex-col gap-3 sm:flex-row w-full sm:w-auto">
                        @if ($step > 1)
                            <button type="button" wire:click="atras"
                                class="w-full sm:w-auto bg-transparent rounded-radius border border-outline px-6 py-2.5 text-sm font-medium tracking-wide text-zinc-500 transition hover:opacity-75">
                                Atrás
                            </button>
                        @endif
                        
                        @if ($step < 3)
                            <button type="button" wire:click="siguiente"
                                class="w-full sm:w-auto rounded-radius bg-surface-dark border border-surface-dark px-10 py-2.5 text-sm font-medium tracking-wide text-white transition hover:opacity-90">
                                Continuar
                            </button>
                        @else
                            <button type="button" wire:click="guardar"
                                class="w-full sm:w-auto rounded-radius bg-success border border-success px-10 py-2.5 text-sm font-medium tracking-wide text-white transition shadow-lg shadow-success/20">
                                Guardar Registro
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>