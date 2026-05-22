<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Livewire\Forms\UsuarioForm;
use App\Services\EmprendimientoService;

class CrearEmprendimiento extends Component
{
    use WithFileUploads; // Indispensable para subir archivos

    public $step = 1;
    public UsuarioForm $datosUsuario;
    
    public ?string $nombre_emprendimiento = null;
    public ?string $descripcion = null;
    public ?TemporaryUploadedFile $imagen = null; // Propiedad para la imagen

    public function siguiente()
    {
        if ($this->step === 1) {
            $this->datosUsuario->validate(); 
        } elseif ($this->step === 2) {
            $this->validate([
                'nombre_emprendimiento' => 'required|string|min:3|max:150',
                'descripcion'           => 'required|string|min:10|max:500',
                'imagen'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Seguridad: Solo imágenes, max 5MB
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

        // Pasamos la imagen como tercer parámetro
        $servicio->registrarNuevoEmprendimiento($this->datosUsuario->all(), $datosEmpresa, $this->imagen);

        return redirect()->route('admin.emprendimientos.gestion')
                     ->with('notificacion', [
                         'type' => 'success', 
                         'title' => '¡Registro Exitoso!', 
                         'message' => 'El emprendimiento ha sido creado exitosamente.'
                     ]);
    }

    public function render()
    {
        return view('livewire.admin.crear-emprendimiento');
    }
}
