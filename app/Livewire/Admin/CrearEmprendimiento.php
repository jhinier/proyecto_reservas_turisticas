<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Livewire\Forms\UsuarioForm; // 👈 Tu Maletín de datos del usuario
use App\Services\EmprendimientoService; // 👈 El Chef que hace el trabajo pesado

class CrearEmprendimiento extends Component
{
    public $step = 1;

    // ==========================================
    // PASO 1: Datos del Emprendedor (Usa el Form Object)
    // ==========================================
    public UsuarioForm $datosUsuario; 
    
    // ==========================================
    // PASO 2: Datos del Emprendimiento
    // ==========================================
    public $nombre_emprendimiento;
    public $descripcion;

    // ==========================================
    // VALIDACIÓN EN TIEMPO REAL
    // ==========================================
    public function updated($propertyName)
    {
        // Esto hace que los errores en rojo salgan apenas cambias de casilla
        $this->validateOnly($propertyName);
    }

    // ==========================================
    // NAVEGACIÓN ENTRE PASOS
    // ==========================================
    public function siguiente()
    {
        if ($this->step === 1) {
            // El maletín se valida a sí mismo usando las reglas de UsuarioForm.php
            $this->datosUsuario->validate(); 
            
        } elseif ($this->step === 2) {
            // Validamos solo los datos de la empresa
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

    // ==========================================
    // GUARDAR EN BASE DE DATOS (MVC + Servicios)
    // ==========================================
    public function guardar(EmprendimientoService $servicio)
    {
        // 1. Armamos el "papelito" con la orden de la empresa
        $datosEmpresa = [
            'nombre_emprendimiento' => $this->nombre_emprendimiento,
            'descripcion'           => $this->descripcion,
        ];

        // 2. Le pasamos todo al Servicio (El Chef).
        // $this->datosUsuario->all() saca todos los datos del maletín en forma de Array.
        $servicio->registrarNuevoEmprendimiento($this->datosUsuario->all(), $datosEmpresa);

        // 3. Redirigir con mensaje de éxito
        return redirect()->route('admin.emprendimientos.gestion')
                         ->with('status', 'Emprendimiento creado con éxito.');
    }

    // ==========================================
    // RENDERIZAR VISTA
    // ==========================================
    public function render()
    {
        return view('livewire.admin.crear-emprendimiento');
    }
}