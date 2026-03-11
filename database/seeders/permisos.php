<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class permisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //// Crear un permiso
$permission = Permission::create(['name' => 'edit articles']);
$permission2 = Permission::create(['name' => 'ver articulos']);
$permission3 = Permission::create(['name' => 'eliminar artitulo']);
 
// Crear un rol y asignarle el permiso
$role = Role::create(['name' => 'superAdministrador']);
$role->givePermissionTo($permission,$permission2,$permission3);
$role = Role::create(['name' => 'administrador']);
$role->givePermissionTo($permission,$permission2,$permission3);
$role = Role::create(['name' => 'usuario']);
$role->givePermissionTo($permission2);
 
// Asignar el rol a un usuario
$user = User::find(1);
$user->assignRole('superAdministrador');
    }
}
