<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Configuración de autenticación de dos factores') }}</flux:heading>

    <x-settings.layout
        :heading="__('Autenticación de dos factores')"
        :subheading="__('Administra la configuración de autenticación de dos factores')"
    >
        <div class="flex flex-col w-full mx-auto space-y-6 text-sm" wire:cloak>
            @if ($twoFactorEnabled)
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <flux:badge color="green">{{ __('Activado') }}</flux:badge>
                    </div>

                    <flux:text>
                        {{ __('Con la autenticación de dos factores activada, se te pedirá un PIN seguro y aleatorio durante el inicio de sesión, que puedes obtener desde la aplicación compatible con TOTP en tu teléfono.') }}
                    </flux:text>

                    <livewire:settings.two-factor.recovery-codes :$requiresConfirmation/>

                    <form method="POST" action="{{ route('two-factor.disable') }}" class="flex justify-start">
                        @csrf
                        @method('DELETE')

                        <flux:button
                            type="submit"
                            variant="danger"
                            icon="shield-exclamation"
                            icon:variant="outline"
                        >
                            {{ __('Desactivar 2FA') }}
                        </flux:button>
                    </form>
                </div>
            @else
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <flux:badge color="red">{{ __('Desactivado') }}</flux:badge>
                    </div>

                    <flux:text variant="subtle">
                        {{ __('Cuando habilites la autenticación de dos factores, se te pedirá un PIN seguro durante el inicio de sesión. Este PIN puede obtenerse desde una aplicación compatible con TOTP en tu teléfono.') }}
                    </flux:text>

                    <flux:text variant="subtle">
                        {{ __('Si no tienes una app autenticadora, instala Google Authenticator, Microsoft Authenticator o Authy antes de activar esta opción.') }}
                    </flux:text>

                    <flux:button
                        variant="primary"
                        icon="shield-check"
                        icon:variant="outline"
                        wire:click="enable"
                    >
                        {{ __('Activar 2FA') }}
                    </flux:button>
                </div>
            @endif
        </div>
    </x-settings.layout>

    <flux:modal
        name="two-factor-setup-modal"
        class="max-w-md md:min-w-md"
        @close="closeModal"
        wire:model="showModal"
    >
        <div class="space-y-6">
            <div class="flex flex-col items-center space-y-4">
                <div class="p-0.5 w-auto rounded-full border border-stone-100 dark:border-stone-600 bg-white dark:bg-stone-800 shadow-sm">
                    <div class="p-2.5 rounded-full border border-stone-200 dark:border-stone-600 overflow-hidden bg-stone-100 dark:bg-stone-200 relative">
                        <div class="flex items-stretch absolute inset-0 w-full h-full divide-x [&>div]:flex-1 divide-stone-200 dark:divide-stone-300 justify-around opacity-50">
                            @for ($i = 1; $i <= 5; $i++)
                                <div></div>
                            @endfor
                        </div>

                        <div class="flex flex-col items-stretch absolute w-full h-full divide-y [&>div]:flex-1 inset-0 divide-stone-200 dark:divide-stone-300 justify-around opacity-50">
                            @for ($i = 1; $i <= 5; $i++)
                                <div></div>
                            @endfor
                        </div>

                        <flux:icon.qr-code class="relative z-20 dark:text-accent-foreground"/>
                    </div>
                </div>

                <div class="space-y-2 text-center">
                    <flux:heading size="lg">{{ $this->modalConfig['title'] }}</flux:heading>
                    <flux:text>{{ $this->modalConfig['description'] }}</flux:text>
                </div>
            </div>

            @if ($showVerificationStep)
                <div class="space-y-6">
                    <div class="flex flex-col items-center space-y-3 justify-center">
                        <flux:otp
                            name="code"
                            wire:model="code"
                            length="6"
                            label="Código OTP"
                            label:sr-only
                            class="mx-auto"
                        />

                        @error('code')
                            <flux:text color="red">
                                {{ $message }}
                            </flux:text>
                        @enderror

                    </div>

                    <div class="flex items-center space-x-3">
                        <flux:button
                            variant="outline"
                            class="flex-1"
                            wire:click="resetVerification"
                        >
                            {{ __('Atrás') }}
                        </flux:button>

                        <flux:button
                            variant="primary"
                            class="flex-1"
                            wire:click="confirmTwoFactor"
                            x-bind:disabled="$wire.code.length < 6"
                        >
                            {{ __('Confirmar') }}
                        </flux:button>
                    </div>
                </div>
            @else
                @error('setupData')
                    <flux:callout variant="danger" icon="x-circle" heading="{{ $message }}"/>
                @enderror

                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800 dark:border-emerald-400/20 dark:bg-emerald-400/10 dark:text-emerald-200">
                    {{ __('Necesitas una app autenticadora en tu celular. Si ya la tienes, escanea el QR. Si no puedes escanearlo, copia la clave de abajo en la app.') }}
                </div>

                <div class="space-y-3 rounded-lg border border-stone-200 p-3 dark:border-stone-700">
                    <div class="space-y-1 text-center">
                        <p class="text-sm font-semibold text-stone-800 dark:text-stone-100">
                            {{ __('¿No tienes la app?') }}
                        </p>
                        <p class="text-xs text-stone-500 dark:text-stone-400">
                            {{ __('Elige tu celular para abrir la tienda de descarga.') }}
                        </p>
                    </div>

                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($this->authenticatorDownloadLinks as $app)
                            <a
                                href="{{ $app['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-lg border border-stone-200 px-3 py-2 text-sm font-semibold text-stone-700 transition hover:bg-stone-50 dark:border-stone-700 dark:text-stone-200 dark:hover:bg-white/10"
                                aria-label="Descargar Google Authenticator para {{ $app['label'] }}"
                            >
                                Descargar para {{ $app['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="relative w-64 overflow-hidden border rounded-lg border-stone-200 dark:border-stone-700 aspect-square">
                        @empty($qrCodeSvg)
                            <div class="absolute inset-0 flex items-center justify-center bg-white dark:bg-stone-700 animate-pulse">
                                <flux:icon.loading/>
                            </div>
                        @else
                        <div class="flex items-center justify-center h-full p-4 bg-white">
                            <div class="bg-white p-3 rounded">
                                    {!! $qrCodeSvg !!}
                                </div>
                            </div>
                        @endempty
                    </div>
                </div>

                <div>
                    <flux:button
                        :disabled="$errors->has('setupData')"
                        variant="primary"
                        class="w-full"
                        wire:click="showVerificationIfNecessary"
                    >
                        {{ $requiresConfirmation ? __('Ya escaneé el QR') : $this->modalConfig['buttonText'] }}
                    </flux:button>
                </div>

                <div class="space-y-4">
                    <div class="relative flex items-center justify-center w-full">
                        <div class="absolute inset-0 w-full h-px top-1/2 bg-stone-200 dark:bg-stone-600"></div>
                        <span class="relative px-2 text-sm bg-white dark:bg-stone-800 text-stone-600 dark:text-stone-400">
                            {{ __('o, copia esta clave en tu app') }}
                        </span>
                    </div>

                    <div
                        class="flex items-center space-x-2"
                        x-data="{
                            copied: false,
                            setupKey: @js($manualSetupKey),
                            async copy() {
                                try {
                                    await navigator.clipboard.writeText(this.setupKey);
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 1500);
                                } catch (e) {
                                    console.warn('Could not copy to clipboard');
                                }
                            }
                        }"
                    >
                        <div class="flex items-stretch w-full border rounded-xl dark:border-stone-700">
                            @empty($manualSetupKey)
                                <div class="flex items-center justify-center w-full p-3 bg-stone-100 dark:bg-stone-700">
                                    <flux:icon.loading variant="mini"/>
                                </div>
                            @else
                                <input
                                    type="text"
                                    readonly
                                    value="{{ $manualSetupKey }}"
                                    class="w-full p-3 font-mono text-sm tracking-wider bg-transparent outline-none text-stone-900 dark:text-stone-100"
                                />

                                <button
                                    type="button"
                                    @click="copy()"
                                    class="px-3 transition-colors border-l cursor-pointer border-stone-200 dark:border-stone-600"
                                >
                                    <flux:icon.document-duplicate x-show="!copied" variant="outline"></flux:icon>
                                    <flux:icon.check
                                        x-show="copied"
                                        variant="solid"
                                        class="text-green-500"
                                    ></flux:icon>
                                </button>
                            @endempty
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>
</section>
