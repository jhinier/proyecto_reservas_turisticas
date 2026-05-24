<?php

namespace App\Livewire\Settings;

use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Password settings')]
class Password extends Component
{
    use PasswordValidationRules;

    public function render()
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        $layout = $user?->hasRole('emprendimiento') ? 'layouts.app.sidebar_emprendimiento' : 'layouts.app';

        /** @var \Illuminate\View\View $view */
        $view = view('livewire.settings.password');
        $view->layout($layout);

        return $view;
    }

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $user?->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}
