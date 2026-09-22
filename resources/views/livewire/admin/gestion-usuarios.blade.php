<div class="max-w-7xl mx-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-lg shadow-md col-span-1">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Registrar Nuevo Usuario</h2>

        @if (session()->has('mensaje'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('mensaje') }}</div>
        @endif

        <form wire:submit.prevent="guardarUsuario">
            
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" wire:model="name" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" wire:model="email" class="mt-1 w-full rounded border-gray-300 shadow-sm">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rol del Usuario</label>
                <select wire:model="role" class="mt-1 w-full rounded border-gray-300 shadow-sm">
                    <option value="">Seleccione un rol...</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->name }}">{{ strtoupper($rol->name) }}</option>
                    @endforeach
                </select>
                @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Guardar Usuario
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md col-span-2 overflow-x-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Usuarios Registrados</h2>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($usuarios as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $user->getRoleNames()->first() ?? 'Sin Rol' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>