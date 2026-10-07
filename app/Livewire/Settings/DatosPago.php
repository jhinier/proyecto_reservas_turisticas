<?php

namespace App\Livewire\Settings;

use App\Livewire\Settings\Concerns\UsesSettingsLayout;
use App\Models\CuentaBancaria;
use App\Models\Emprendimiento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Datos de pago')]
class DatosPago extends Component
{
    use UsesSettingsLayout;

    /** @var array<int, array{id: string, cuenta_id: int|null, nombre_banco: string, numero_cuenta: string, titular: string}> */
    public array $cuentasBancarias = [];

    public function mount(): void
    {
        $this->cargarCuentasBancarias($this->emprendimientoActual());
    }

    public function render()
    {
        return view('livewire.settings.datos-pago')
            ->layout($this->settingsLayout());
    }

    public function agregarCuentaBancaria(): void
    {
        $this->cuentasBancarias[] = $this->nuevaCuentaBancaria();
        $this->resetValidation('cuentasBancarias');
    }

    public function eliminarCuentaBancaria(string $id): void
    {
        $existeEnFormulario = collect($this->cuentasBancarias)
            ->contains(fn (array $cuenta) => ($cuenta['id'] ?? null) === $id);

        if (! $existeEnFormulario) {
            return;
        }

        $this->cuentasBancarias = collect($this->cuentasBancarias)
            ->reject(fn (array $cuenta) => ($cuenta['id'] ?? null) === $id)
            ->values()
            ->all();

        $this->resetValidation('cuentasBancarias');
    }

    public function guardar()
    {
        $emprendimiento = $this->emprendimientoActual();

        foreach ($this->cuentasBancarias as $index => $cuenta) {
            $this->cuentasBancarias[$index]['nombre_banco'] = trim((string) ($cuenta['nombre_banco'] ?? ''));
            $this->cuentasBancarias[$index]['numero_cuenta'] = trim((string) ($cuenta['numero_cuenta'] ?? ''));
            $this->cuentasBancarias[$index]['titular'] = trim((string) ($cuenta['titular'] ?? ''));
        }

        $validated = $this->validate([
            'cuentasBancarias' => ['array'],
            'cuentasBancarias.*.id' => ['required', 'uuid'],
            'cuentasBancarias.*.cuenta_id' => ['nullable', 'integer'],
            'cuentasBancarias.*.nombre_banco' => ['nullable', 'string', 'max:120'],
            'cuentasBancarias.*.numero_cuenta' => ['nullable', 'string', 'max:60'],
            'cuentasBancarias.*.titular' => ['nullable', 'string', 'max:150'],
        ], [
            'cuentasBancarias.*.nombre_banco.max' => 'El nombre del banco no puede superar los 120 caracteres.',
            'cuentasBancarias.*.numero_cuenta.max' => 'La cuenta no puede superar los 60 caracteres.',
            'cuentasBancarias.*.titular.max' => 'El titular no puede superar los 150 caracteres.',
        ]);

        $cuentasBancarias = $this->cuentasBancariasValidadas($validated['cuentasBancarias'] ?? []);

        $this->guardarCuentasBancarias($emprendimiento, $cuentasBancarias);
        session()->flash('datos_pago_success', 'Datos bancarios guardados exitosamente.');

        return $this->redirectRoute('emprendimiento-payment.edit', navigate: false);
    }

    private function emprendimientoActual(): Emprendimiento
    {
        $user = Auth::user();

        abort_unless($user instanceof User && $user->hasRole('emprendimiento'), 403);

        return $user->emprendimiento()->firstOrFail();
    }

    private function cargarCuentasBancarias(Emprendimiento $emprendimiento): void
    {
        $this->cuentasBancarias = $emprendimiento->cuentasBancarias()
            ->orderBy('id')
            ->get()
            ->map(fn (CuentaBancaria $cuenta) => $this->nuevaCuentaBancaria($cuenta))
            ->values()
            ->all();

        if ($this->cuentasBancarias === []) {
            $this->cuentasBancarias[] = $this->nuevaCuentaBancaria();
        }
    }

    /**
     * @param  array<int, array{id?: string, cuenta_id?: int|null, nombre_banco?: string, numero_cuenta?: string, titular?: string}>  $cuentas
     * @return array<int, array{cuenta_id: int|null, nombre_banco: string, numero_cuenta: string, titular: string}>
     */
    private function cuentasBancariasValidadas(array $cuentas): array
    {
        $normalizadas = [];
        $mensajes = [];
        $idsFormulario = [];

        foreach ($cuentas as $index => $cuenta) {
            $nombreBanco = trim((string) ($cuenta['nombre_banco'] ?? ''));
            $numeroCuenta = trim((string) ($cuenta['numero_cuenta'] ?? ''));
            $titular = trim((string) ($cuenta['titular'] ?? ''));

            if ($nombreBanco === '' && $numeroCuenta === '' && $titular === '') {
                continue;
            }

            if ($nombreBanco === '') {
                $mensajes["cuentasBancarias.$index.nombre_banco"] = 'El banco es obligatorio.';
            }

            if ($numeroCuenta === '') {
                $mensajes["cuentasBancarias.$index.numero_cuenta"] = 'La cuenta es obligatoria.';
            }

            if ($titular === '') {
                $mensajes["cuentasBancarias.$index.titular"] = 'El titular es obligatorio.';
            }

            $cuentaId = $cuenta['cuenta_id'] ?? null;
            $cuentaId = $cuentaId ? (int) $cuentaId : null;

            if ($cuentaId && in_array($cuentaId, $idsFormulario, true)) {
                $mensajes["cuentasBancarias.$index.numero_cuenta"] = 'Esta cuenta esta duplicada en el formulario.';
            }

            if ($cuentaId) {
                $idsFormulario[] = $cuentaId;
            }

            $normalizadas[] = [
                'cuenta_id' => $cuentaId,
                'nombre_banco' => $nombreBanco,
                'numero_cuenta' => $numeroCuenta,
                'titular' => $titular,
            ];
        }

        if ($mensajes !== []) {
            throw ValidationException::withMessages($mensajes);
        }

        return $normalizadas;
    }

    /**
     * @param  array<int, array{cuenta_id: int|null, nombre_banco: string, numero_cuenta: string, titular: string}>  $cuentas
     */
    private function guardarCuentasBancarias(Emprendimiento $emprendimiento, array $cuentas): void
    {
        $idsActivos = [];

        foreach ($cuentas as $index => $cuenta) {
            $cuentaBancaria = $cuenta['cuenta_id']
                ? $emprendimiento->cuentasBancarias()->whereKey($cuenta['cuenta_id'])->first()
                : new CuentaBancaria;

            if (! $cuentaBancaria) {
                throw ValidationException::withMessages([
                    "cuentasBancarias.$index.numero_cuenta" => 'La cuenta bancaria seleccionada no es valida.',
                ]);
            }

            $cuentaBancaria->fill([
                'nombre_banco' => $cuenta['nombre_banco'],
                'numero_cuenta' => $cuenta['numero_cuenta'],
                'titular' => $cuenta['titular'],
            ]);

            if (! $cuentaBancaria->exists) {
                $cuentaBancaria->emprendimiento()->associate($emprendimiento);
            }

            $cuentaBancaria->save();
            $idsActivos[] = $cuentaBancaria->id;
        }

        if ($idsActivos === []) {
            $emprendimiento->cuentasBancarias()->delete();

            return;
        }

        $emprendimiento->cuentasBancarias()
            ->whereNotIn('id', $idsActivos)
            ->delete();
    }

    /** @return array{id: string, cuenta_id: int|null, nombre_banco: string, numero_cuenta: string, titular: string} */
    private function nuevaCuentaBancaria(?CuentaBancaria $cuenta = null): array
    {
        return [
            'id' => (string) Str::uuid(),
            'cuenta_id' => $cuenta?->id,
            'nombre_banco' => $cuenta?->nombre_banco ?? '',
            'numero_cuenta' => $cuenta?->numero_cuenta ?? '',
            'titular' => $cuenta?->titular ?? '',
        ];
    }
}
