<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Livewire\Forms\UsuarioForm;
use App\Services\EmprendimientoService;

class CrearEmprendimiento extends Component
{
    public $step = 1;
    public UsuarioForm $datosUsuario; // Este es nuestro Form Object
    
    public $nombre_emprendimiento;
    public $descripcion;


    public function siguiente()
    {
        if ($this->step === 1) {
            // Valida todo el objeto UsuarioForm antes de pasar al paso 2
            $this->datosUsuario->validate(); 
        } elseif ($this->step === 2) {
            $this->validate([
                'nombre_emprendimiento' => 'required|string|min:3', 
                'descripcion' => 'required|string|min:10',
            ]);
        }
        $this->step++;
    }

    public function atras()
    {
        $this->step--;
    }

    public function guardar(EmprendimientoService $servicio)
    {
        $datosEmpresa = [
            'nombre_emprendimiento' => $this->nombre_emprendimiento,
            'descripcion'           => $this->descripcion,
        ];

        // Se envía el array de datos del usuario y el array de la empresa al servicio
        $servicio->registrarNuevoEmprendimiento($this->datosUsuario->all(), $datosEmpresa);

        return redirect()->route('admin.emprendimientos.gestion')
                     ->with('notificacion', [
                         'type' => 'success', 
                         'title' => '¡Registro Exitoso!', 
                         'message' => 'El emprendimiento ha sido creado y el usuario asignado.'
                     ]);
    }

    public function render()
    {
        return view('livewire.admin.crear-emprendimiento');
    }
}