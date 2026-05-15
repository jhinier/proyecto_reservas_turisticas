<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use App\Services\UserService; // Cambiamos la importación
use App\Rules\CedulaEcuatoriana;

class DatosTurista extends Component
{
    public $identificacion = '';
    public $correo = '';
    public $nombres = '';
    public $apellidos = '';
    public $edad = '';
    public $telefono = '';

    public $usuarioEncontrado = false;
    public $busquedaRealizada = false;

    public function updatedIdentificacion()
    {
        $this->busquedaRealizada = false;
        $this->usuarioEncontrado = false;
    }

    protected function rules()
    {
        return [
            'identificacion' => ['required', 'numeric', 'digits:10', new CedulaEcuatoriana()],
        ];
    }

    // Inyectamos UserService
    public function buscarTurista(UserService $userService)
    {
        $this->resetErrorBag();
        $this->validateOnly('identificacion');

        // Usamos la función desde UserService
        $turista = $userService->buscarPorIdentificacion($this->identificacion);
        $this->busquedaRealizada = true;

        if ($turista) {
            $this->correo = $turista->email;
            $this->nombres = $turista->name; 
            $this->apellidos = $turista->apellidos;
            $this->edad = $turista->edad;
            $this->telefono = $turista->telefono;
            $this->usuarioEncontrado = true;
        } else {
            $this->limpiarCampos();
        }
    }

    public function procesarDatos()
    {
        if (!$this->usuarioEncontrado) {
            return;
        }

        $this->dispatch('datos-turista-completados', datos: [
            'identificacion' => $this->identificacion,
            'correo' => $this->correo,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'edad' => $this->edad,
            'telefono' => $this->telefono,
        ]);
    }

    private function limpiarCampos()
    {
        $this->correo = '';
        $this->nombres = '';
        $this->apellidos = '';
        $this->edad = '';
        $this->telefono = '';
        $this->usuarioEncontrado = false;
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.datos-turista');
    }
}