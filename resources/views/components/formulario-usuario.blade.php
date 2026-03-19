@props(['prefix' => ''])

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    {{-- 1. NOMBRES --}}
    <div class="flex flex-col gap-1">
        <label class="flex items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has($prefix.'nombre') ? 'text-danger' : (filled(data_get($this, $prefix.'nombre')) ? 'text-success' : 'text-zinc-700') }}">
            @if($errors->has($prefix.'nombre'))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif(filled(data_get($this, $prefix.'nombre')))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Nombres
        </label>
        <input type="text" wire:model.blur="{{ $prefix }}nombre" placeholder="Ej: Juan Antonio"
            class="w-full rounded-lg border {{ $errors->has($prefix.'nombre') ? 'border-danger' : (filled(data_get($this, $prefix.'nombre')) ? 'border-success' : 'border-zinc-300') }} bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:bg-zinc-900 dark:text-white" />
        @error($prefix.'nombre') <small class="text-danger font-medium">{{ $message }}</small> @enderror
    </div>

    {{-- 2. APELLIDOS --}}
    <div class="flex flex-col gap-1">
        <label class="flex items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has($prefix.'apellidos') ? 'text-danger' : (filled(data_get($this, $prefix.'apellidos')) ? 'text-success' : 'text-zinc-700') }}">
            @if($errors->has($prefix.'apellidos'))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif(filled(data_get($this, $prefix.'apellidos')))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Apellidos
        </label>
        <input type="text" wire:model.blur="{{ $prefix }}apellidos" placeholder="Ej: Pérez Zambrano"
            class="w-full rounded-lg border {{ $errors->has($prefix.'apellidos') ? 'border-danger' : (filled(data_get($this, $prefix.'apellidos')) ? 'border-success' : 'border-zinc-300') }} bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:bg-zinc-900 dark:text-white" />
        @error($prefix.'apellidos') <small class="text-danger font-medium">{{ $message }}</small> @enderror
    </div>

    {{-- 3. CÉDULA --}}
    <div class="flex flex-col gap-1">
        <label class="flex items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has($prefix.'cedula') ? 'text-danger' : (filled(data_get($this, $prefix.'cedula')) ? 'text-success' : 'text-zinc-700') }}">
            @if($errors->has($prefix.'cedula'))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif(filled(data_get($this, $prefix.'cedula')))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Cédula
        </label>
        <input type="text" wire:model.blur="{{ $prefix }}cedula" placeholder="Ej: 060xxxxxxx" maxlength="10" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
            class="w-full rounded-lg border {{ $errors->has($prefix.'cedula') ? 'border-danger' : (filled(data_get($this, $prefix.'cedula')) ? 'border-success' : 'border-zinc-300') }} bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:bg-zinc-900 dark:text-white" />
        @error($prefix.'cedula') <small class="text-danger font-medium">{{ $message }}</small> @enderror
    </div>

    {{-- 4. TELÉFONO (AL LADO DE CÉDULA) --}}
    <div class="flex flex-col gap-1">
        <label class="flex items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has($prefix.'telefono') ? 'text-danger' : (filled(data_get($this, $prefix.'telefono')) ? 'text-success' : 'text-zinc-700') }}">
            @if($errors->has($prefix.'telefono'))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif(filled(data_get($this, $prefix.'telefono')))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Teléfono
        </label>
        <div class="relative flex w-full items-stretch rounded-lg border {{ $errors->has($prefix.'telefono') ? 'border-danger' : (filled(data_get($this, $prefix.'telefono')) ? 'border-success' : 'border-zinc-300') }} bg-white shadow-sm dark:bg-zinc-900 focus-within:ring-2 focus-within:ring-zinc-900/5 transition-all">
            <div class="flex items-center gap-2 border-r border-zinc-200 bg-zinc-50/50 px-3 rounded-l-lg dark:border-zinc-700 dark:bg-zinc-800/50">
                <img class="h-3 w-5" src="https://flagcdn.com/ec.svg" alt="EC" />
                <span class="text-sm font-medium text-zinc-500">+593</span>
            </div>
            <input type="tel" wire:model.blur="{{ $prefix }}telefono" placeholder="Ej: 0999999999" maxlength="10" inputmode="numeric" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                class="w-full border-none bg-transparent px-3 py-2 text-sm focus:ring-0 dark:text-white" />
        </div>
        @error($prefix.'telefono') <small class="text-danger font-medium">{{ $message }}</small> @enderror
    </div>

    {{-- 5. CORREO (ANCHO COMPLETO) --}}
    <div class="flex flex-col gap-1 md:col-span-2">
        <label class="flex items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has($prefix.'email') ? 'text-danger' : (filled(data_get($this, $prefix.'email')) ? 'text-success' : 'text-zinc-700') }}">
            @if($errors->has($prefix.'email'))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif(filled(data_get($this, $prefix.'email')))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Correo electrónico
        </label>
        <input type="email" wire:model.blur="{{ $prefix }}email" placeholder="usuario@ejemplo.com"
            class="w-full rounded-lg border {{ $errors->has($prefix.'email') ? 'border-danger' : (filled(data_get($this, $prefix.'email')) ? 'border-success' : 'border-zinc-300') }} bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:bg-zinc-900 dark:text-white" />
        @error($prefix.'email') <small class="text-danger font-medium">{{ $message }}</small> @enderror
    </div>

    {{-- 6. CONTRASEÑA --}}
    <div class="flex flex-col gap-1">
        <label class="flex items-center gap-1 pl-0.5 text-sm font-medium {{ $errors->has($prefix.'password') ? 'text-danger' : (filled(data_get($this, $prefix.'password')) ? 'text-success' : 'text-zinc-700') }}">
            @if($errors->has($prefix.'password'))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif(filled(data_get($this, $prefix.'password')))
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Contraseña
        </label>
        <input type="password" wire:model.blur="{{ $prefix }}password" placeholder="Mínimo 8 caracteres"
            class="w-full rounded-lg border {{ $errors->has($prefix.'password') ? 'border-danger' : (filled(data_get($this, $prefix.'password')) ? 'border-success' : 'border-zinc-300') }} bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:bg-zinc-900 dark:text-white" />
        @error($prefix.'password') <small class="text-danger font-medium">{{ $message }}</small> @enderror
    </div>

    {{-- 7. CONFIRMAR --}}
    <div class="flex flex-col gap-1">
        <label class="pl-0.5 text-sm font-medium text-zinc-700">Confirmar Contraseña</label>
        <input type="password" wire:model.blur="{{ $prefix }}password_confirmation" placeholder="Repite tu contraseña"
            class="w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/5 dark:bg-zinc-900 dark:text-white" />
    </div>
</div>