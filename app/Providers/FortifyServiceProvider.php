<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse; // Agrega esta línea

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();

        // NIVEL 1: Bloqueo en la puerta (Login)
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            // 1. Verificamos credenciales básicas
            if ($user && Hash::check($request->password, $user->password)) {
                
                // 2. Validación de Roles: El usuario DEBE tener al menos un rol asignado
                if ($user->roles()->count() === 0) {
                    throw ValidationException::withMessages([
                        Fortify::username() => 'Tu cuenta no tiene un rol asignado para acceder al sistema.',
                    ]);
                }
                
                // 3. Validación de Arquitectura: Si es emprendedor, su negocio DEBE estar activo
                if ($this->loginEsParaReserva($request) && !$user->hasRole('turista')) {
                    $request->session()->forget(['url.intended', 'reserva_login_pendiente']);

                    throw ValidationException::withMessages([
                        Fortify::username() => 'Solo los usuarios con rol turista pueden realizar reservas.',
                    ]);
                }

                if ($user->hasRole('emprendimiento')) {
                    if (!$user->emprendimiento || !$user->emprendimiento->estado) {
                        throw ValidationException::withMessages([
                            'email' => 'Tu emprendimiento se encuentra inactivo. Contacta soporte.',
                        ]);
                    }
                }

                return $user;
            }

            return null;
        });

        // Redirección dinámica según el rol del usuario
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    /** @var User $user */
                    $user = Auth::user();

                    if ($user->hasAnyRole(['admin', 'superAdministrador', 'administrador_gad'])) {
                        return redirect()->intended(route('admin.dashboard'));
                    } elseif ($user->hasRole('emprendimiento')) {
                        return redirect()->intended(route('emprendimiento.panel'));
                    }

                    // Redirección por defecto para el turista
                    if ($this->loginTuristaDebeVolverAReserva($request)) {
                        $request->session()->forget(['url.intended', 'reserva_login_pendiente']);

                        return redirect()->route('turista.reservas.checkout');
                    }

                    return redirect()->intended(route('home'));
                }

                private function loginTuristaDebeVolverAReserva($request): bool
                {
                    $intendedUrl = (string) $request->session()->get('url.intended', '');
                    $intendedPath = (string) parse_url($intendedUrl, PHP_URL_PATH);

                    return $request->boolean('reserva')
                        || $request->session()->has('reserva_login_pendiente')
                        || Str::contains($intendedPath, [
                            '/checkout',
                            '/reserva',
                            '/reservas',
                            '/reservar',
                        ]);
                }
            };
        });
    }

    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('livewire.auth.login'));
        Fortify::verifyEmailView(fn () => view('livewire.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('livewire.auth.confirm-password'));
        Fortify::registerView(fn () => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn () => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('livewire.auth.forgot-password'));
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }

    private function loginEsParaReserva(Request $request): bool
    {
        $intendedUrl = (string) $request->session()->get('url.intended', '');
        $intendedPath = (string) parse_url($intendedUrl, PHP_URL_PATH);

        if (Str::startsWith($intendedPath, ['/admin', '/emprendimiento'])) {
            return false;
        }

        return $request->boolean('reserva')
            || $request->boolean('solo_turista')
            || $request->session()->has('reserva_login_pendiente')
            || Str::contains($intendedPath, [
                '/checkout',
                '/reserva',
                '/reservas',
                '/reservar',
            ]);
    }
}
