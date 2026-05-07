<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use App\Services\TuristaService;
use App\Rules\CedulaEcuatoriana;
use Illuminate\Support\Facades\Log;

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
    }

    protected function rules()
    {
        return [
            'identificacion' => ['required', 'numeric', 'digits:10', new CedulaEcuatoriana()],
            'correo' => 'required|email|max:255',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'edad' => 'required|integer|min:1|max:120',
            'telefono' => 'nullable|numeric|digits:10',
        ];
    }

    public function buscarTurista(TuristaService $turistaService)
    {
        $this->resetErrorBag();
        $this->validateOnly('identificacion');

        $turista = $turistaService->buscarPorIdentificacion($this->identificacion);
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
        $this->resetErrorBag();
        $datosValidados = $this->validate();

        // Validación extra de correo duplicado
        $existeCorreo = \App\Models\User::where('email', $this->correo)
            ->where('cedula', '!=', $this->identificacion)
            ->exists();

        if ($existeCorreo) {
            $this->addError('correo', 'Este correo electrónico ya pertenece a otra persona en el sistema.');
            return;
        }

        $this->dispatch('datos-turista-completados', datos: $datosValidados);
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