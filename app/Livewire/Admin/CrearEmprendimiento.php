<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Livewire\Forms\UsuarioForm;
use App\Services\EmprendimientoService;

class CrearEmprendimiento extends Component
{
    use WithFileUploads; 

    public $step = 1;
    public UsuarioForm $datosUsuario;
    
    public ?string $nombre_emprendimiento = null;
    public ?string $descripcion = null;
    public ?TemporaryUploadedFile $imagen = null; 
    
    // Arreglo dinámico para las URLs
    public array $enlaces = [''];

    public function agregarEnlace()
    {
        $this->enlaces[] = '';
    }

    public function eliminarEnlace($index)
    {
        unset($this->enlaces[$index]);
        $this->enlaces = array_values($this->enlaces); // Reindexar el arreglo
    }

    public function siguiente()
    {
        if ($this->step === 1) {
            $this->datosUsuario->validate(); 
        } elseif ($this->step === 2) {
            $this->validate([
                'nombre_emprendimiento' => 'required|string|min:3|max:150',
                'descripcion'           => 'required|string|min:10|max:500',
                'imagen'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', 
                'enlaces'               => 'nullable|array',
                'enlaces.*'             => 'nullable|url|max:255',
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
        // Limpiamos las casillas vacías
        $enlacesLimpios = array_filter($this->enlaces, fn($valor) => !is_null($valor) && trim($valor) !== '');

        $datosEmpresa = [
            'nombre_emprendimiento' => $this->nombre_emprendimiento,
            'descripcion'           => $this->descripcion,
            'enlaces'               => empty($enlacesLimpios) ? null : array_values($enlacesLimpios),
        ];

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