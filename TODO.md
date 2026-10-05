# TODO: Agregar "Apellidos" y cambiar "Nombre" → "Nombres"

## Pasos:

- [x] Leer archivos relevantes
- [x] Aprobar plan

### 1. Editar `resources/views/livewire/settings/profile.blade.php`
- [x] Cambiar label "Nombre" → "Nombres"
- [x] Agregar campo input para "Apellidos"

### 2. Editar `app/Livewire/Settings/Profile.php`
- [x] Agregar propiedad `public string $apellidos = '';`
- [x] En `mount()`: inicializar `$this->apellidos`
- [x] En `updateProfileInformation()`: actualizar dispatch con apellidos

### 3. Editar `app/Concerns/ProfileValidationRules.php`
- [x] Agregar regla de validación para `apellidos`

### 4. Editar `app/Models/User.php` (opcional)
- [x] Modificar `initials()` para incluir apellidos

