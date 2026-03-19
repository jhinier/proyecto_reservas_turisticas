<?php

namespace App\Livewire\Admin;

use App\Models\Emprendimiento;
use App\Models\User;
use App\Services\EmprendimientoService;
use Livewire\Component;

class GestionEmprendimientos extends Component
{
    // Propiedades del Emprendimiento
    public $selected_id;
    public $nombre;
    public $descripcion;
    public $estado;
    public $user_id;

    // Propiedades del Usuario (Para editar el responsable)
    public $user_name;
    public $user_apellidos;
    public $user_email;
    public $user_telefono;
    public $user_cedula;

    public $editando = false;
    public $empresaDetalle = null;

    public function render()
    {
        return view('livewire.admin.gestion-emprendimientos', [ 
            'usuarios' => User::role('emprendimiento')->get(),
            'emprendimientos' => Emprendimiento::with('user')->latest()->get()
        ]);
    }

    public function verDetalle($id)
    {
        $this->empresaDetalle = Emprendimiento::with('user')->find($id);
        $this->modal('modal-ver-empresa')->show();
    }

    public function editar($id)
    {
        $this->resetErrorBag();
        $this->editando = true;
        $emp = Emprendimiento::with('user')->findOrFail($id);

        $this->selected_id = $id;
        $this->nombre = $emp->nombre;
        $this->descripcion = $emp->descripcion;
        
        // 🔥 SOLUCIÓN DEL ESTADO: Booleano a String
        $this->estado = $emp->estado ? '1' : '0';

        // Datos del Usuario para los Inputs
        $this->user_id = $emp->user_id;
        $this->user_name = $emp->user->name;
        $this->user_apellidos = $emp->user->apellidos;
        $this->user_email = $emp->user->email;
        $this->user_telefono = $emp->user->telefono;
        $this->user_cedula = $emp->user->cedula;
    }

    public function actualizar(EmprendimientoService $servicio)
    {
        $this->validate([
            'nombre' => 'required|max:150',
            'descripcion' => 'required|min:10|max:300',
            'estado' => 'required|in:0,1',
            'user_name' => 'required|string|max:255',
            'user_apellidos' => 'required|string|max:255',
            'user_cedula' => 'required|digits:10',
            'user_telefono' => 'required',
            'user_email' => 'required|email',
        ]);

        $datosEmpresa = [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
        ];

        $datosUsuario = [
            'name' => $this->user_name,
            'apellidos' => $this->user_apellidos,
            'email' => $this->user_email,
            'telefono' => $this->user_telefono,
            'cedula' => $this->user_cedula,
        ];

        $servicio->actualizarTodo($this->selected_id, $datosEmpresa, $datosUsuario);

        $this->modal('modal-emprendimiento')->close();
        
        // 🔥 ALERTA DE ÉXITO (Toasts)
        $this->dispatch('notify', type: 'success', title: 'Actualización Exitosa', message: 'Los datos del emprendimiento y responsable han sido guardados.');
    }

    // 🔥 FUNCIÓN ELIMINAR AÑADIDA PARA QUE FUNCIONE EL BOTÓN DE LA TABLA
    public function eliminar($id)
    {
        Emprendimiento::destroy($id);
        
        // 🔥 ALERTA DE ELIMINACIÓN (Toasts)
        $this->dispatch('notify', type: 'danger', title: 'Registro Eliminado', message: 'El emprendimiento ha sido borrado permanentemente del sistema.');
    }
}