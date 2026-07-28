<?php

namespace App\Livewire\Admin;

use App\Services\EmprendimientoService;
use App\Models\TipoServicio;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GestionEmprendimientos extends Component
{
    use WithFileUploads, WithPagination;

    // Propiedades del formulario (Emprendimiento)
    public $selected_id, $nombre, $descripcion, $estado, $user_id, $imagen, $imagenActual;

    // Propiedades del formulario (Usuario Responsable)
    public $user_name, $user_apellidos, $user_email, $user_telefono, $user_cedula;

    // Arreglo dinámico para las URLs (edición)
    public array $enlaces = [''];

    // Banderas de interfaz
    public $editando = false;
    public $empresaDetalle = null;

    // Filtros
    public $busqueda = '';
    public $filtroTipoServicio = '';
    public $tiposServicio = [];

    public function mount()
    {
        $this->tiposServicio = TipoServicio::pluck('nombre', 'id')->toArray();
    }

    public function updatedBusqueda()
    {
        $this->resetPage();
    }

    public function updatedFiltroTipoServicio()
    {
        $this->resetPage();
    }

    public function agregarEnlace()
    {
        $this->enlaces[] = '';
    }

    public function eliminarEnlace($index)
    {
        unset($this->enlaces[$index]);
        $this->enlaces = array_values($this->enlaces);
    }

    /**
     * Renderiza la vista delegando la obtención de datos al Servicio.
     */
    public function render(EmprendimientoService $servicio)
    {
        return view('livewire.admin.gestion-emprendimientos', [ 
            'usuarios' => $servicio->obtenerUsuariosEmprendedores(),
            'emprendimientos' => $servicio->listarPaginados(10, $this->busqueda, $this->filtroTipoServicio)
        ]);
    }

    /**
     * Busca el detalle mediante el servicio y abre el modal.
     */
    public function verDetalle($id, EmprendimientoService $servicio)
    {
        $this->authorize('gestionar emprendimientos');

        // Limpiamos detalle previo para evitar parpadeos de datos viejos
        $this->empresaDetalle = null;

        // El servicio se encarga de la consulta pesada
        $this->empresaDetalle = $servicio->buscarConRelaciones($id);
        
        $this->modal('modal-ver-empresa')->show();
    }

    /**
     * Prepara los campos para edición delegando la búsqueda al servicio.
     */
    public function editar($id, EmprendimientoService $servicio)
    {
        $this->authorize('gestionar emprendimientos');
        $this->resetErrorBag();
        $this->editando = true;
        
        // Obtenemos los datos desde el servicio
        $emp = $servicio->buscarConRelaciones($id);

        $this->selected_id = $id;
        $this->nombre = $emp->nombre;
        $this->descripcion = $emp->descripcion;
        $this->estado = $emp->estado ? '1' : '0';
        $this->imagen = null;
        $this->imagenActual = $emp->imagen;

        $this->user_id = $emp->user_id;
        $this->user_name = $emp->user->name;
        $this->user_apellidos = $emp->user->apellidos;
        $this->user_email = $emp->user->email;
        $this->user_telefono = $emp->user->telefono;
        $this->user_cedula = $emp->user->cedula;

        // Cargar enlaces existentes
        $this->enlaces = $emp->enlaces ?? [''];

        $this->modal('modal-emprendimiento')->show();
    }

    /**
     * Guarda un nuevo registro.
     */
    public function guardar(EmprendimientoService $servicio)
    {
        $this->authorize('gestionar emprendimientos');

        $this->validate([
            'nombre' => 'required|max:150',
            'descripcion' => 'required|min:10|max:300',
            'estado' => 'required|in:0,1',
            'user_name' => 'required|string|max:255',
            'user_apellidos' => 'required|string|max:255',
            'user_cedula' => 'required|digits:10|unique:users,cedula',
            'user_telefono' => 'required',
            'user_email' => 'required|email|unique:users,email',
        ]);

        $datosEmpresa = [
            'nombre_emprendimiento' => $this->nombre,
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

        $servicio->registrarNuevoEmprendimiento($datosUsuario, $datosEmpresa);

        $this->reset(['nombre', 'descripcion', 'estado', 'user_name', 'user_apellidos', 'user_cedula', 'user_telefono', 'user_email']);
        $this->modal('modal-emprendimiento')->close();
        
        $this->dispatch('notify', type: 'success', title: 'Registro Exitoso', message: 'El emprendimiento ha sido creado exitosamente.');
    }

    /**
     * Actualiza un registro existente.
     */
    public function actualizar(EmprendimientoService $servicio)
    {
        $this->authorize('gestionar emprendimientos');

        $this->validate([
            'nombre' => 'required|max:150',
            'descripcion' => 'required|min:10|max:300',
            'estado' => 'required|in:0,1',
            'user_name' => 'required|string|max:255',
            'user_apellidos' => 'required|string|max:255',
            'user_cedula' => 'required|digits:10',
            'user_telefono' => 'required',
            'user_email' => 'required|email',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'enlaces' => 'nullable|array',
            'enlaces.*' => 'nullable|url|max:255',
        ]);

        // Limpiamos las casillas vacías
        $enlacesLimpios = array_filter($this->enlaces, fn($valor) => !is_null($valor) && trim($valor) !== '');

        $datosEmpresa = [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'enlaces' => empty($enlacesLimpios) ? null : array_values($enlacesLimpios),
        ];

        $datosUsuario = [
            'name' => $this->user_name,
            'apellidos' => $this->user_apellidos,
            'email' => $this->user_email,
            'telefono' => $this->user_telefono,
            'cedula' => $this->user_cedula,
        ];

        $servicio->actualizarTodo($this->selected_id, $datosEmpresa, $datosUsuario, $this->imagen);

        $this->reset(['imagen', 'imagenActual']);
        $this->modal('modal-emprendimiento')->close();
        $this->dispatch('notify', type: 'success', title: 'Actualización Exitosa', message: 'Los datos han sido guardados.');
    }

    /**
     * Elimina el registro.
     */
    public function eliminar($id, EmprendimientoService $servicio)
    {
        $this->authorize('gestionar emprendimientos');

        if ($servicio->eliminarRegistroCompleto($id)) {
            $this->dispatch('notify', type: 'danger', title: 'Registro Eliminado', message: 'El negocio y usuario se han borrado.');
        }
    }
}
