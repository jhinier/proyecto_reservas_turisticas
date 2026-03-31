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

    <div class="mb-6">
        <div x-data="{
            options: [ { value: 'Todos', label: 'Todos los servicios' }, { value: 'Hospedaje', label: 'Hospedaje' }, { value: 'Guianza', label: 'Guianza' }, { value: 'Alimentación', label: 'Alimentación' } ],
            isOpen: false, openedWithKeyboard: false, selectedOption: null,
            setSelectedOption(option) { this.selectedOption = option; this.isOpen = false; this.openedWithKeyboard = false; this.$refs.hiddenTextField.value = option.value; },
            highlightFirstMatchingOption(pressedKey) { const option = this.options.find((item) => item.label.toLowerCase().startsWith(pressedKey.toLowerCase())); if (option) { const index = this.options.indexOf(option); const allOptions = document.querySelectorAll('.combobox-option'); if (allOptions[index]) { allOptions[index].focus(); } } }
        }" class="w-full max-w-xs flex flex-col gap-1" x-on:keydown="highlightFirstMatchingOption($event.key)" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false">
            <label for="industry" class="w-fit pl-0.5 text-sm text-on-surface dark:text-on-surface-dark">Tipo de servicio</label>
            <div class="relative">
                <button type="button" role="combobox" class="inline-flex w-full items-center justify-between gap-2 whitespace-nowrap border-outline bg-surface-alt px-4 py-2 text-sm font-medium capitalize tracking-wide text-on-surface transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:text-on-surface-dark dark:focus-visible:outline-primary-dark rounded-radius border" aria-haspopup="listbox" aria-controls="industriesList" x-on:click="isOpen = ! isOpen" x-on:keydown.down.prevent="openedWithKeyboard = true" x-on:keydown.enter.prevent="openedWithKeyboard = true" x-on:keydown.space.prevent="openedWithKeyboard = true" x-bind:aria-label="selectedOption ? selectedOption.value : 'Please Select'" x-bind:aria-expanded="isOpen || openedWithKeyboard">
                    <span class="text-sm font-normal" x-text="selectedOption ? selectedOption.value : 'Seleccionar opción'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                </button>
                <input id="industry" name="industry" type="text" x-ref="hiddenTextField" hidden/>
                <ul x-cloak x-show="isOpen || openedWithKeyboard" id="industriesList" class="absolute z-10 left-0 top-11 flex max-h-44 w-full flex-col overflow-hidden overflow-y-auto border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt rounded-radius border" role="listbox" aria-label="industries list" x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" x-transition x-trap="openedWithKeyboard">
                    <template x-for="(item, index) in options" x-bind:key="item.value"> 
                        <li class="combobox-option inline-flex justify-between gap-6 bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/5 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong" role="option" x-on:click="setSelectedOption(item)" x-on:keydown.enter="setSelectedOption(item)" x-bind:id="'option-' + index" tabindex="0" >
                            <span x-bind:class="selectedOption == item ? 'font-bold' : null" x-text="item.label"></span>
                            <span class="sr-only" x-text="selectedOption == item ? 'selected' : null"></span>
                            <svg x-cloak x-show="selectedOption == item" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" class="size-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        </li>
                    </template>
                </ul>
            </div>
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
                                <button wire:click="verDetalle({{ $emprendimiento->id }})" class="text-neutral-500 hover:text-neutral-800 dark:hover:text-white transition-colors" title="Ver detalles">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </button>
                                <button wire:click="editar({{ $emprendimiento->id }})" x-on:click="$flux.modal('modal-emprendimiento').show()" class="text-primary hover:text-primary-dark transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                </button>
                                <button wire:click="eliminar({{ $emprendimiento->id }})" wire:confirm="¿Estás seguro de que deseas eliminar este emprendimiento?" class="text-danger hover:text-danger-dark transition-colors" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-neutral-500 dark:text-neutral-400">Aún no hay emprendimientos registrados en el sistema.</td></tr>
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
        <div class="flex flex-col max-h-[85vh]">
            @if($empresaDetalle)
                <div class="p-6 shrink-0 border-b border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-t-2xl">
                    <flux:heading size="lg">Detalles del Emprendimiento</flux:heading>
                    <flux:subheading>Información completa del registro #{{ $empresaDetalle->id }}</flux:subheading>
                </div>
                <div class="p-6 flex-1 overflow-y-auto bg-neutral-50 dark:bg-zinc-950/30">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                            <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Datos del Establecimiento</h3>
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
                        <div class="p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                            <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Responsable Legal</h3>
                            <p class="font-semibold text-on-surface dark:text-on-surface-dark">{{ $empresaDetalle->user->name }} {{ $empresaDetalle->user->apellidos }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">CI: {{ $empresaDetalle->user->cedula }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400">Telf: {{ $empresaDetalle->user->telefono }}</p>
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 break-all">{{ $empresaDetalle->user->email }}</p>
                        </div>
                        <div class="col-span-1 md:col-span-2 p-4 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900">
                            <h3 class="text-xs font-bold uppercase text-neutral-500 mb-2">Descripción General</h3>
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed">{{ $empresaDetalle->descripcion }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 shrink-0 border-t border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-b-2xl flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <flux:modal.close><flux:button variant="ghost" class="w-full sm:w-auto">Cerrar</flux:button></flux:modal.close>
                </div>
            @endif
        </div>
    </flux:modal>

    <flux:modal name="modal-emprendimiento" class="w-[92%] mx-auto md:max-w-4xl relative rounded-2xl !p-0">
        <div wire:loading wire:target="editar" class="absolute inset-0 z-50 flex items-center justify-center bg-white/50 dark:bg-zinc-900/50 rounded-2xl">
            <flux:icon.loading class="size-10 text-primary" />
        </div>
        <form wire:submit="actualizar" class="flex flex-col max-h-[85vh]">
            <div class="p-6 shrink-0 border-b border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-t-2xl">
                <flux:heading size="lg">Editar Información General</flux:heading>
                <flux:subheading>Modifica los datos del emprendimiento y responsable.</flux:subheading>
            </div>
            <div class="p-6 flex-1 overflow-y-auto bg-neutral-50 dark:bg-zinc-950/30">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <flux:heading level="3" size="sm" class="text-blue-600 uppercase tracking-wider">Empresa</flux:heading>
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
            </div>
            <div class="p-6 shrink-0 border-t border-neutral-100 dark:border-neutral-800 bg-white dark:bg-zinc-900 rounded-b-2xl flex flex-col-reverse sm:flex-row gap-3">
                <flux:spacer class="hidden sm:block" />
                <flux:button variant="ghost" class="w-full sm:w-auto" x-on:click="$flux.modal('modal-emprendimiento').close()">Cancelar</flux:button>
                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">Guardar Cambios</flux:button>
            </div>
        </form>
    </flux:modal>
</div>