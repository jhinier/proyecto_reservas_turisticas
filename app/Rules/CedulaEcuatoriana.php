<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CedulaEcuatoriana implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_numeric($value) || strlen($value) !== 10) {
            $fail('La cédula debe tener exactamente 10 números.');
            return;
        }

        $provincia = (int) substr($value, 0, 2);
        if ($provincia < 1 || $provincia > 24) {
            $fail('Los primeros dos dígitos de la provincia son incorrectos.');
            return;
        }

        $tercerDigito = (int) substr($value, 2, 1);
        if ($tercerDigito > 5) {
            $fail('El tercer dígito de la cédula es inválido.');
            return;
        }

        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $valor = (int) substr($value, $i, 1) * $coeficientes[$i];
            $suma += ($valor > 9) ? $valor - 9 : $valor;
        }

        $digitoVerificador = (int) substr($value, 9, 1);
        
        $resultado = (10 - ($suma % 10)) % 10;

        if ($resultado !== $digitoVerificador) {
            $fail('La cédula no valida.');
        }
    }
}