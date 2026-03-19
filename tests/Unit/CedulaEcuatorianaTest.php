<?php
uses(Tests\TestCase::class);

use App\Rules\CedulaEcuatoriana;
use Illuminate\Support\Facades\Validator;

test('acepta una cédula ecuatoriana real', function () {
    $validador = Validator::make(
        ['cedula' => '0603061235'], // Cédula de Chimborazo matemáticamente válida
        ['cedula' => [new CedulaEcuatoriana()]]
    );

    expect($validador->passes())->toBeTrue();
});

test('rechaza una cédula que tiene letras', function () {
    $validador = Validator::make(
        ['cedula' => '060306123A'],
        ['cedula' => [new CedulaEcuatoriana()]]
    );

    expect($validador->fails())->toBeTrue();
});

test('rechaza una cédula con menos de 10 números', function () {
    $validador = Validator::make(
        ['cedula' => '060306123'],
        ['cedula' => [new CedulaEcuatoriana()]]
    );

    expect($validador->fails())->toBeTrue();
});

test('rechaza una provincia que no existe', function () {
    $validador = Validator::make(
        ['cedula' => '3003061235'], // La provincia 30 no existe en Ecuador
        ['cedula' => [new CedulaEcuatoriana()]]
    );

    expect($validador->fails())->toBeTrue();
});

test('rechaza una cédula con el dígito verificador falso', function () {
    $validador = Validator::make(
        ['cedula' => '0603061239'], // Falla el cálculo del módulo 10
        ['cedula' => [new CedulaEcuatoriana()]]
    );

    expect($validador->fails())->toBeTrue();
});