@props(['prefix' => ''])

<div class="grid grid-cols-1 gap-6 md:grid-cols-2" wire:key="form-usuario-container">
    
    {{-- Lógica para determinar estados de Error o Éxito --}}
    @php
        $getFieldInfo = function($field) use ($prefix, $errors) {
            $name = $prefix . $field;
            $hasError = $errors->has($name);
            $isSuccess = filled(data_get($this, $name)) && !$hasError;
            return [
                'name' => $name,
                'hasError' => $hasError,
                'isSuccess' => $isSuccess,
                'statusClass' => $hasError ? 'border-danger' : ($isSuccess ? 'border-success' : 'border-outline'),
                'labelClass' => $hasError ? 'text-danger' : ($isSuccess ? 'text-success' : 'text-on-surface')
            ];
        };
    @endphp

    {{-- 1. NOMBRES --}}
    @php $nombre = $getFieldInfo('nombre'); @endphp
    <div class="flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $nombre['labelClass'] }}">
            @if($nombre['hasError'])
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif($nombre['isSuccess'])
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Nombres
        </label>
        <input wire:model="{{ $nombre['name'] }}" type="text" autofocus autocomplete="off" placeholder="Ej: Juan Antonio"
            class="w-full rounded-radius border {{ $nombre['statusClass'] }} bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:bg-surface-dark-alt/50" />
        @error($nombre['name']) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 2. APELLIDOS --}}
    @php $apellidos = $getFieldInfo('apellidos'); @endphp
    <div class="flex w-full flex-col gap-1 text-on-surface">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $apellidos['labelClass'] }}">
            @if($apellidos['hasError']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif($apellidos['isSuccess']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Apellidos
        </label>
        <input wire:model="{{ $apellidos['name'] }}" type="text" autocomplete="off" placeholder="Ej: Pérez Zambrano"
            class="w-full rounded-radius border {{ $apellidos['statusClass'] }} bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary" />
        @error($apellidos['name']) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 3. CÉDULA --}}
    @php $cedula = $getFieldInfo('cedula'); @endphp
    <div class="flex w-full flex-col gap-1">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $cedula['labelClass'] }}">
            @if($cedula['hasError']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif($cedula['isSuccess']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Cédula
        </label>
        <input wire:model="{{ $cedula['name'] }}" type="text" maxlength="10" inputmode="numeric" autocomplete="off" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="060xxxxxxx"
            class="w-full rounded-radius border {{ $cedula['statusClass'] }} bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary" />
        @error($cedula['name']) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 4. EDAD --}}
    @php $edad = $getFieldInfo('edad'); @endphp
    <div class="flex w-full flex-col gap-1">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $edad['labelClass'] }}">
            @if($edad['hasError']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif($edad['isSuccess']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Edad
        </label>
        <input wire:model="{{ $edad['name'] }}" type="number" min="18" max="99" autocomplete="off" placeholder="Ej: 25"
            class="w-full rounded-radius border {{ $edad['statusClass'] }} bg-surface-alt px-2 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary" />
        @error($edad['name']) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 5. TELÉFONO --}}
    @php $telefono = $getFieldInfo('telefono'); @endphp
    <div class="flex flex-col gap-1">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $telefono['labelClass'] }}">
            @if($telefono['hasError']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif($telefono['isSuccess']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Teléfono
        </label>
        <div x-data="{
                allOptions: [
                    { label: 'Ecuador', value: 'Ecuador', iso: 'ec', phoneCode: '+593' },
                    { label: 'Argentina', value: 'Argentina', iso: 'ar', phoneCode: '+54' },
                    { label: 'Colombia', value: 'Colombia', iso: 'co', phoneCode: '+57' },
                    { label: 'Peru', value: 'Peru', iso: 'pe', phoneCode: '+51' },
                    { label: 'United States', value: 'United States', iso: 'us', phoneCode: '+1' }
                ],
                options: [],
                isOpen: false,
                selectedOption: null,
                init() { this.options = this.allOptions; this.setSelectedOption(this.allOptions[0]) },
                setSelectedOption(option) { this.selectedOption = option; this.isOpen = false; },
                getFilteredOptions(query) { this.options = this.allOptions.filter(o => o.label.toLowerCase().includes(query.toLowerCase()) || o.phoneCode.includes(query)) }
            }" class="relative flex w-full">
            
            <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center gap-2 rounded-l-radius border {{ $telefono['statusClass'] }} border-r-0 bg-surface-alt px-3 text-sm">
                <img class="h-3 w-5" :src="'https://flagcdn.com/' + selectedOption?.iso + '.svg'" />
                <span x-text="selectedOption?.phoneCode" class="text-xs font-bold"></span>
            </button>

            <input wire:model="{{ $telefono['name'] }}" type="tel" maxlength="10"autocomplete="off" placeholder="0999999999"
                class="w-full rounded-r-radius border {{ $telefono['statusClass'] }} bg-surface-alt px-2.5 py-2 text-sm focus:outline-hidden" />
        </div>
        @error($telefono['name']) <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 6. CORREO --}}
    @php $email = $getFieldInfo('email'); @endphp
    <div class="flex flex-col gap-1">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $email['labelClass'] }}">
            @if($email['hasError']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
            @elseif($email['isSuccess']) <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
            @endif
            Correo electrónico
        </label>
        <input wire:model="{{ $email['name'] }}" type="email" autocomplete="off" placeholder="usuario@ejemplo.com"
            class="w-full rounded-radius border {{ $email['statusClass'] }} bg-surface-alt px-2 py-2 text-sm" />
        @error($email['name']) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 7. CONTRASEÑA --}}
    @php $pass = $getFieldInfo('password'); @endphp
    <div class="flex flex-col gap-1" x-data="{ showPassword: false }">
        <label class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $pass['labelClass'] }}">Contraseña</label>
        <div class="relative">
            <input :type="showPassword ? 'text' : 'password'" wire:model="{{ $pass['name'] }}" autocomplete="off" placeholder="Mínimo 8 caracteres"
                class="w-full rounded-radius border {{ $pass['statusClass'] }} bg-surface-alt px-2 py-2 text-sm" />
            <button type="button" @click="showPassword = !showPassword" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-zinc-400">
                <svg x-show="!showPassword" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                <svg x-show="showPassword" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
            </button>
        </div>
    </div>

    {{-- 8. CONFIRMAR CONTRASEÑA --}}
    <div class="flex flex-col gap-1" x-data="{ showConfirm: false }">
        <label class="pl-0.5 text-sm">Confirmar Contraseña</label>
        <div class="relative">
            <input :type="showConfirm ? 'text' : 'password'" wire:model="{{ $prefix }}password_confirmation" autocomplete="off" placeholder="Repite la contraseña"
                class="w-full rounded-radius border border-outline bg-surface-alt px-2 py-2 text-sm focus:outline-none" />
            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-zinc-400">
                <svg x-show="!showConfirm" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /></svg>
                <svg x-show="showConfirm" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12" /></svg>
            </button>
        </div>
    </div>

    {{-- MENSAJE DE ERROR PARA CONTRASEÑA (Solo asoma cuando está mal) --}}
    <div class="md:col-span-2">
        @if($errors->has($prefix . 'password'))
            <div class="relative w-full overflow-hidden rounded-radius border border-danger bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark" role="alert">
                <div class="flex w-full items-center gap-2 bg-danger/10 p-4">
                    <div class="bg-danger/15 text-danger rounded-full p-1" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-danger">La contraseña no es segura</h3>
                        <p class="text-xs font-medium sm:text-sm">La contraseña ingresada no cumple con los requisitos mínimos. Asegúrate de que:</p>
                        <ul class="mt-2 list-inside list-disc pl-2 text-xs font-medium text-danger sm:text-sm">
                            <li>Tenga <strong>mínimo 8</strong> caracteres</li>
                            <li>Incluya <strong>mayúsculas y minúsculas</strong></li>
                            <li>Contenga <strong>al menos un número y un símbolo</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>