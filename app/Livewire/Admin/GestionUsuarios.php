<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Services\UserService;

class GestionUsuarios extends Component
{
    // Variables públicas: Livewire las sincroniza automáticamente con los inputs del HTML.
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $cedula = null;
    public ?string $telefono = null;
    public ?string $role = null;

    /**
     * Reglas de validación nativas de Livewire.
     * ¿Por qué aquí? Livewire evalúa estas reglas en tiempo real desde el backend,
     * asegurando que nadie pueda saltarse la validación alterando el HTML.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'password' => 'required|min:8',
            'cedula'   => ['required', 'string', 'max:10', Rule::unique('users', 'cedula')->whereNull('deleted_at')],
            'telefono' => 'required|string|max:15',
            'role'     => 'required|exists:roles,name', // Evita que inyecten un rol falso
        ];
    }

    /**
     * Función que procesa el formulario.
     * INYECCIÓN DE DEPENDENCIAS: Al pedir UserService como parámetro, Laravel 
     * nos entrega la clase lista para usar. Esto es clave para el rendimiento 
     * porque la clase solo se carga en memoria si el usuario da clic en "Guardar".
     */
    public function guardarUsuario(UserService $userService)
    {
        // 1. Validar (Si falla, Livewire detiene la ejecución y envía los errores a la vista)
        $datosValidados = $this->validate();

        try {
            // 2. Delegamos la lógica compleja a nuestra Capa de Servicio
            $userService->crearUsuario($datosValidados);

            // 3. Limpiamos la memoria del componente (resetea los inputs)
            $this->reset(['name', 'email', 'password', 'cedula', 'telefono', 'role']);
            
            // 4. Mensaje de éxito temporal
            session()->flash('mensaje', 'Usuario creado exitosamente.');
            
        } catch (\Exception $e) {
            // Manejo de errores amigable para no mostrar pantallazos feos al usuario final
            session()->flash('error', 'Hubo un error al crear el usuario en la base de datos.');
        }
    }

    /**
     * Dibuja la pantalla.
     * EFICIENCIA: Solo traemos la lista de usuarios y roles justo antes de pintar la pantalla.
     */
    public function render()
    {
        return view('livewire.admin.gestion-usuarios', [
            'usuarios' => User::latest()->get(), // latest() ordena del más nuevo al más viejo
            'roles'    => Role::all(),
        ]);
    }
}
