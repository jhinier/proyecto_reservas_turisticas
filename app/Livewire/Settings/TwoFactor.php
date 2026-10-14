<?php

namespace App\Livewire\Settings;

use App\Livewire\Settings\Concerns\UsesSettingsLayout;
use Exception;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;

#[Title('Two-factor authentication')]
class TwoFactor extends Component
{
    use UsesSettingsLayout;

    private const AUTHENTICATOR_ANDROID_URL = 'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2';

    private const AUTHENTICATOR_IPHONE_URL = 'https://apps.apple.com/app/google-authenticator/id388497605';

    public function render()
    {
        return view('livewire.settings.two-factor')->layout($this->settingsLayout());
    }

    #[Locked]
    public bool $twoFactorEnabled;

    #[Locked]
    public bool $requiresConfirmation;

    #[Locked]
    public string $qrCodeSvg = '';

    #[Locked]
    public string $manualSetupKey = '';

    public bool $showModal = false;

    public bool $showVerificationStep = false;

    #[Validate('required|digits:6', onUpdate: false)]
    public string $code = '';

    /**
     * Mount the component.
     */
    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        abort_unless(Features::enabled(Features::twoFactorAuthentication()), Response::HTTP_FORBIDDEN);

        if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
            $disableTwoFactorAuthentication(auth()->user());
        }

        $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
        $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
    }

    /**
     * Enable two-factor authentication for the user.
     */
    public function enable(EnableTwoFactorAuthentication $enableTwoFactorAuthentication): void
    {
        $user = auth()->user();

        $enableTwoFactorAuthentication(
            $user,
            ! is_null($user->two_factor_secret) && is_null($user->two_factor_confirmed_at),
        );

        $user->refresh();

        if (! $this->requiresConfirmation) {
            $this->twoFactorEnabled = $user->hasEnabledTwoFactorAuthentication();
        }

        $this->loadSetupData();

        $this->showModal = true;
    }

    /**
     * Load the two-factor authentication setup data for the user.
     */
    private function loadSetupData(): void
    {
        $user = auth()->user();

        try {
            $this->qrCodeSvg = $user?->twoFactorQrCodeSvg();
            $this->manualSetupKey = Fortify::currentEncrypter()->decrypt($user->two_factor_secret);
        } catch (Exception) {
            $this->addError('setupData', 'Failed to fetch setup data.');

            $this->reset('qrCodeSvg', 'manualSetupKey');
        }
    }

    /**
     * Show the two-factor verification step if necessary.
     */
    public function showVerificationIfNecessary(): void
    {
        if ($this->requiresConfirmation) {
            $this->showVerificationStep = true;

            $this->resetErrorBag();

            return;
        }

        $this->closeModal();
    }

    /**
     * Confirm two-factor authentication for the user.
     */
    public function confirmTwoFactor(ConfirmTwoFactorAuthentication $confirmTwoFactorAuthentication): void
    {
        $this->code = preg_replace('/\D/', '', $this->code);

        $this->validate();

        try {
            $confirmTwoFactorAuthentication(auth()->user(), $this->code);
        } catch (ValidationException) {
            throw ValidationException::withMessages([
                'code' => 'El código no es válido. Elimina cualquier cuenta anterior de Authenticator, escanea este QR de nuevo y verifica que la fecha y hora del celular estén en automático.',
            ]);
        }

        $this->closeModal();

        $this->twoFactorEnabled = true;
    }

    /**
     * Reset two-factor verification state.
     */
    public function resetVerification(): void
    {
        $this->reset('code', 'showVerificationStep');

        $this->resetErrorBag();
    }

    /**
     * Disable two-factor authentication for the user.
     */
    public function disableTwoFactor(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }

    public function getAuthenticatorDownloadLinksProperty(): array
    {
        return [
            [
                'label' => 'Android',
                'url' => self::AUTHENTICATOR_ANDROID_URL,
            ],
            [
                'label' => 'iPhone',
                'url' => self::AUTHENTICATOR_IPHONE_URL,
            ],
        ];
    }

    /**
     * Close the two-factor authentication modal.
     */
    public function closeModal(): void
    {
        $this->reset(
            'code',
            'manualSetupKey',
            'qrCodeSvg',
            'showModal',
            'showVerificationStep',
        );

        $this->resetErrorBag();

        if (! $this->requiresConfirmation) {
            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
        }
    }

    /**
     * Get the current modal configuration state.
     */
    public function getModalConfigProperty(): array
    {
        if ($this->twoFactorEnabled) {
            return [
                'title' => __('Autenticación en dos pasos activada'),
                'description' => __('La autenticación en dos pasos ya está activada para tu cuenta.'),
                'buttonText' => __('Cerrar'),
            ];
        }

        if ($this->showVerificationStep) {
            return [
                'title' => __('Verifica el código'),
                'description' => __('Ingresa el código de 6 dígitos que aparece en tu aplicación de autenticación.'),
                'buttonText' => __('Continuar'),
            ];
        }

        return [
            'title' => __('Activar autenticación en dos pasos'),
            'description' => __('Escanea el QR con tu aplicación de autenticación o copia la clave de configuración manual.'),
            'buttonText' => __('Continuar'),
        ];
    }
}
