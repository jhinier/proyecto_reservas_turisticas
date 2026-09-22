<div relative>
    <div x-data="{ show: false, type: 'success', title: '', message: '' }"
         @notify.window="
            type = $event.detail.type;
            title = $event.detail.title;
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 4000);
         "
         class="fixed top-4 right-4 z-[100] w-full max-w-sm space-y-2"
         x-show="show"
         x-transition.opacity.duration.300ms
         style="display: none;">

        <div x-show="type === 'success'" class="relative w-full overflow-hidden rounded-sm border border-green-500 bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark shadow-lg" role="alert">
            <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                <div class="bg-green-500/15 text-green-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-success" x-text="title"></h3>
                    <p class="text-xs font-medium sm:text-sm" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-auto" aria-label="dismiss alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="type === 'danger'" class="relative w-full overflow-hidden rounded-sm border border-red-500 bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark shadow-lg" role="alert">
            <div class="flex w-full items-center gap-2 bg-danger/10 p-4">
                <div class="bg-red-500/15 text-red-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-danger" x-text="title"></h3>
                    <p class="text-xs font-medium sm:text-sm" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-auto" aria-label="dismiss alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="type === 'info'" class="relative w-full overflow-hidden rounded-sm border border-sky-500 bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark shadow-lg" role="alert">
            <div class="flex w-full items-center gap-2 bg-info/10 p-4">
                <div class="bg-sky-500/15 text-sky-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-info" x-text="title"></h3>
                    <p class="text-xs font-medium sm:text-sm" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div x-show="type === 'warning'" class="relative w-full overflow-hidden rounded-sm border border-amber-500 bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark shadow-lg" role="alert">
            <div class="flex w-full items-center gap-2 bg-warning/10 p-4">
                <div class="bg-amber-500/15 text-amber-500 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-warning" x-text="title"></h3>
                    <p class="text-xs font-medium sm:text-sm" x-text="message"></p>
                </div>
                <button @click="show = false" class="ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Emprendimientos</h1>
        <a href="{{ route('admin.emprendimientos.crear') }}" wire:navigate class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-success border border-success dark:border-success px-4 py-2 text-sm font-medium tracking-wide text-on-success transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:text-on-success dark:focus-visible:outline-success">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-on-success dark:fill-on-success" fill="currentColor">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
            </svg>
            Crear Emprendimiento
        </a>
    </div>

    {{-- Filtros --}}
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        {{-- Buscador por nombre o cédula --}}
        <div class="w-full sm:w-[65%]">
            <label class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">Buscar</label>
            <input type="text" wire:model.live="busqueda" placeholder="Buscar por nombre o cédula..." 
                class="w-full rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm text-on-surface focus:outline-none focus:border-primary dark:border-zinc-700 dark:bg-zinc-800/50 dark:text-white dark:focus:border-blue-500 transition-colors" />
        </div>

        {{-- Filtro por tipo de servicio --}}
        <div class="w-full sm:w-[35%]">
            <label for="filtro-tipo" class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">Tipo de servicio</label>
            <select id="filtro-tipo" wire:model.live="filtroTipoServicio" 
                class="w-full rounded-radius border border-outline bg-surface-alt px-4 py-2 text-sm text-on-surface focus:outline-none focus:border-primary dark:border-zinc-700 dark:bg-zinc-800/50 dark:text-white dark:focus:border-blue-500 transition-colors">
                <option value="">Todos los servicios</option>
                @foreach($tiposServicio as $id => $nombre)
                    <option value="{{ $nombre }}">{{ $nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="w-full overflow-hidden overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700 bg-surface dark:bg-surface-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead class="border-b border-neutral-200 bg-surface-alt dark:border-neutral-700 dark:bg-surface-dark-alt">
                <tr>
                    <th scope="col" class="p-4 font-medium">Emprendimiento</th>
                    <th scope="col" class="p-4 font-medium">Responsable</th>
                    <th scope="col" class="p-4 font-medium">Cédula</th>
                    <th scope="col" class="p-4 font-medium">Teléfono</th>
                    <th scope="col" class="p-4 font-medium">Estado</th>
                    <th scope="col" class="p-4 font-medium text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse ($emprendimientos as $emprendimiento)
                    <tr class="hover:bg-surface-alt/50 dark:hover:bg-surface-dark-alt/50 transition-colors">
                        <td class="p-4"><span class="font-medium text-on-surface dark:text-on-surface-dark">{{ $emprendimiento->nombre }}</span></td>
                        <td class="p-4">
                            <div class="flex flex-col">
                                <span class="text-sm text-on-surface dark:text-on-surface-dark">{{ $emprendimiento->user->name }} {{ $emprendimiento->user->apellidos }}</span>
                                <span class="text-xs text-neutral-500">{{ $emprendimiento->user->email }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-400">{{ $emprendimiento->user->cedula }}</td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-400">{{ $emprendimiento->user->telefono }}</td>
                        <td class="p-4">
                            @if($emprendimiento->estado)
                                <span class="inline-flex items-center rounded-full bg-success/10 px-2 py-1 text-xs font-medium text-success">Activo</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-danger/10 px-2 py-1 text-xs font-medium text-danger">Inactivo</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-3">
                                <button wire:click="verDetalle({{ $emprendimiento->id }})" 
                                        x-on:click="$flux.modal('modal-ver-empresa').show()"
                                        class="text-neutral-500 hover:text-neutral-800 dark:hover:text-white transition-colors" title="Ver detalles">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </button>
                                <button wire:click="editar({{ $emprendimiento->id }})" x-on:click="$flux.modal('modal-emprendimiento').show()" class="text-primary hover:text-primary-dark transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                </button>
                                <button wire:click="eliminar({{ $emprendimiento->id }})" wire:confirm="¿Estás seguro?" class="text-danger hover:text-danger-dark transition-colors" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-neutral-500 dark:text-neutral-400">Aún no hay emprendimientos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <nav aria-label="pagination" class="mt-4 w-full flex justify-center">
        <ul class="flex shrink-0 items-center gap-2 text-sm font-medium">
            <li>
                <a href="#" class="flex items-center rounded-radius p-1 text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark" aria-label="previous page">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6"><path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" /></svg> Anterior
                </a>
            </li>
            <li><a href="#" class="flex size-6 items-center justify-center rounded-radius bg-primary p-1 font-bold text-on-primary dark:bg-primary-dark dark:text-on-primary-dark" aria-current="page">1</a></li>
            <li>
                <a href="#" class="flex items-center rounded-radius p-1 text-on-surface hover:text-primary dark:text-on-surface-dark dark:hover:text-primary-dark" aria-label="next page">
                    Siguiente <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
                </a>
            </li>
        </ul>
    </nav>
    
    <flux:modal name="modal-ver-empresa" class="w-[92%] mx-auto md:max-w-4xl relative rounded-2xl !p-0">
        <div wire:loading wire:target="verDetalle" class="absolute inset-0 z-50 flex items-center justify-center bg-white/70 dark:bg-zinc-900/70 rounded-2xl min-h-[400px]">
            <div class="flex flex-col items-center justify-center translate-y-[-20px]">
                <flux:icon.loading class="size-12 text-primary" />
            </div>
        </div>

        <div class="flex flex-col max-h-[85vh]">
            @if($empresaDetalle)
                <div class="p-6 shrink-0 border-b border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-t-2xl">
                    <flux:heading size="lg">Detalles del Emprendimiento</flux:heading>
                    <flux:subheading>Información completa del registro #{{ $empresaDetalle->id }}</flux:subheading>
                </div>
                <div class="p-6 flex-1 overflow-y-auto bg-neutral-50 dark:bg-zinc-950/30">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-sm">
                            <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Datos del Establecimiento</h3>
                            @if($empresaDetalle->imagen)
                                <img src="{{ asset('storage/' . $empresaDetalle->imagen) }}" alt="{{ $empresaDetalle->nombre }}" class="mb-4 h-40 w-full rounded-lg border border-neutral-200 object-cover dark:border-neutral-700">
                            @else
                                <div class="mb-4 flex h-32 w-full items-center justify-center rounded-lg border border-dashed border-neutral-300 bg-neutral-50 text-sm text-neutral-500 dark:border-neutral-700 dark:bg-zinc-800/50 dark:text-neutral-400">
                                    Sin imagen registrada
                                </div>
                            @endif
                            <p class="font-semibold text-lg text-on-surface dark:text-on-surface-dark">{{ $empresaDetalle->nombre }}</p>
                            <div class="mt-2">
                                <span class="text-xs text-neutral-500">Estado:</span>
                                @if($empresaDetalle->estado)
                                    <span class="text-success font-medium text-sm ml-1">Activo</span>
                                @else
                                    <span class="text-danger font-medium text-sm ml-1">Inactivo</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-sm">
                            <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Responsable Legal</h3>
                            <p class="font-semibold text-on-surface dark:text-on-surface-dark">{{ $empresaDetalle->user->name }} {{ $empresaDetalle->user->apellidos }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">CI: {{ $empresaDetalle->user->cedula }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">Telf: {{ $empresaDetalle->user->telefono }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 break-all">{{ $empresaDetalle->user->email }}</p>
                        </div>
                    <div class="col-span-1 md:col-span-2 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-sm">
                            <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Descripción General</h3>
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed">{{ $empresaDetalle->descripcion }}</p>
                        </div>
                        @if($empresaDetalle->enlaces)
                            <div class="col-span-1 md:col-span-2 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-sm">
                                <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Enlaces del Emprendimiento</h3>
                                <div class="flex flex-col gap-2">
                                    @foreach($empresaDetalle->enlaces as $link)
                                        <a href="{{ $link }}" target="_blank" class="text-sm text-primary dark:text-blue-400 hover:underline truncate flex items-center gap-2">
                                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                            {{ $link }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-6 shrink-0 border-t border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-b-2xl flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <flux:modal.close><flux:button variant="ghost" class="w-full sm:w-auto">Cerrar</flux:button></flux:modal.close>
                </div>
            @endif
        </div>
    </flux:modal>

    <flux:modal name="modal-emprendimiento" class="w-[92%] mx-auto md:max-w-4xl relative rounded-2xl !p-0">
        <div wire:loading wire:target="editar" class="absolute inset-0 z-50 flex items-center justify-center bg-white/70 dark:bg-zinc-900/70 rounded-2xl min-h-[400px]">
            <div class="flex flex-col items-center justify-center translate-y-[-20px]">
                <flux:icon.loading class="size-12 text-primary" />
            </div>
        </div>

        <form wire:submit="actualizar" enctype="multipart/form-data" class="flex flex-col max-h-[85vh]">
            <div class="p-6 shrink-0 border-b border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-t-2xl">
                <flux:heading size="lg">Editar Información General</flux:heading>
                <flux:subheading>Modifica los datos del emprendimiento y responsable.</flux:subheading>
            </div>
            <div class="p-6 flex-1 overflow-y-auto bg-neutral-50 dark:bg-zinc-950/30">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <flux:heading level="3" size="sm" class="text-blue-600 uppercase tracking-wider">Empresa</flux:heading>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Logo o Imagen Principal</label>
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start">
                                <div class="h-28 w-full overflow-hidden rounded-lg border border-neutral-200 bg-neutral-100 sm:w-40 dark:border-neutral-700 dark:bg-zinc-800">
                                    @if($imagen)
                                        <img src="{{ $imagen->temporaryUrl() }}" class="h-full w-full object-cover" alt="Vista previa de la nueva imagen">
                                    @elseif($imagenActual)
                                        <img src="{{ asset('storage/' . $imagenActual) }}" class="h-full w-full object-cover" alt="Imagen actual del emprendimiento">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center px-3 text-center text-xs text-neutral-500 dark:text-neutral-400">
                                            Sin imagen registrada
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" wire:model="imagen" accept="image/*" class="w-full rounded-radius border border-outline bg-surface-alt px-3 py-2 text-sm text-zinc-600 file:mr-4 file:rounded-full file:border-0 file:bg-primary/10 file:px-4 file:py-1 file:text-sm file:font-semibold file:text-primary hover:file:bg-primary/20 focus:outline-none dark:border-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300 dark:file:bg-blue-900/30 dark:file:text-blue-400" />
                                    <div wire:loading wire:target="imagen" class="mt-2 text-sm text-primary dark:text-blue-400">Cargando imagen...</div>
                                    @error('imagen') <small class="mt-1 block text-danger dark:text-red-400">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                        <flux:input wire:model="nombre" label="Nombre Comercial" />
                        <flux:select wire:model="estado" label="Estado">
                            <option value="1">🟢 Activo</option>
                            <option value="0">🔴 Inactivo</option>
                        </flux:select>
                        <flux:textarea wire:model="descripcion" label="Descripción" rows="4" />
                    </div>
                    <div class="space-y-4">
                        <flux:heading level="3" size="sm" class="text-blue-600 uppercase tracking-wider">Responsable Legal</flux:heading>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <flux:input wire:model="user_name" label="Nombres" />
                            <flux:input wire:model="user_apellidos" label="Apellidos" />
                        </div>
                        <flux:input wire:model="user_cedula" label="Cédula" /> 
                        <flux:input wire:model="user_email" label="Correo Electrónico" />
                        <flux:input wire:model="user_telefono" label="Teléfono / WhatsApp" />
                    </div>
                </div>

                {{-- Enlaces del Emprendimiento (Edición) --}}
                <div class="mt-6 border-t border-neutral-200 pt-6 dark:border-neutral-700">
                    <div class="flex w-full flex-col gap-1 text-on-surface dark:text-zinc-200">
                        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm font-bold text-zinc-800 dark:text-zinc-300">
                            Enlaces del Emprendimiento (URLs)
                        </label>
                        <p class="text-[10px] text-zinc-500 mb-2 dark:text-zinc-400">Añade los links de redes sociales o sitio web.</p>
                        
                        <div class="space-y-3">
                            @foreach($enlaces as $index => $enlace)
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 relative">
                                        <input type="url" wire:model.blur="enlaces.{{ $index }}" placeholder="https://ejemplo.com" class="w-full rounded-radius border {{ $errors->has('enlaces.'.$index) ? 'border-danger dark:border-red-500' : 'border-outline dark:border-zinc-700' }} bg-surface-alt px-3 py-2 text-sm focus:outline-none focus:border-primary dark:bg-zinc-800/50 dark:text-white transition-colors" />
                                    </div>
                                    <button type="button" wire:click="eliminarEnlace({{ $index }})" class="p-2 text-danger hover:bg-danger/10 rounded-lg transition-colors outline-none shrink-0 dark:text-red-400 dark:hover:bg-red-500/20" title="Eliminar enlace">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                                @error('enlaces.'.$index) <small class="text-danger dark:text-red-400 block mt-1">{{ $message }}</small> @enderror
                            @endforeach
                        </div>

                        <button type="button" wire:click="agregarEnlace" class="mt-4 w-fit flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-primary bg-primary/10 hover:bg-primary/20 rounded-lg transition-colors dark:text-blue-400 dark:bg-blue-500/10 dark:hover:bg-blue-500/20 outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Agregar otro enlace
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6 shrink-0 border-t border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-b-2xl flex flex-col-reverse sm:flex-row gap-3">
                <flux:spacer class="hidden sm:block" />
                <flux:button variant="ghost" class="w-full sm:w-auto" x-on:click="$flux.modal('modal-emprendimiento').close()">Cancelar</flux:button>
                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">Guardar Cambios</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
