<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class permisos extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==========================================
        // 2. CREAR TODOS LOS PERMISOS (Las Acciones)
        // ==========================================
        
        // Permisos exclusivos del SuperAdministrador
        Permission::create(['name' => 'crear administradores gad']);
        
        // Permisos del GAD (SuperAdmin y Admin GAD)
        Permission::create(['name' => 'gestionar emprendimientos']);
        Permission::create(['name' => 'gestionar publicaciones']); // Sitios, actividades, festividades
        Permission::create(['name' => 'gestionar usuarios']);
        
        // Permisos del Emprendimiento
        Permission::create(['name' => 'gestionar servicios turisticos']);
        Permission::create(['name' => 'gestionar reservas']);
        
        // Permisos del Turista/Usuario
        Permission::create(['name' => 'hacer reservas']);


        // ==========================================
        // 3. CREAR ROLES Y REPARTIR PERMISOS
        // ==========================================
        
        // 3.1. Super Administrador (Tiene control absoluto)
        $roleSuperAdmin = Role::create(['name' => 'superAdministrador']);
        $roleSuperAdmin->givePermissionTo(Permission::all()); // Le damos TODOS los permisos creados arriba

        // 3.2. Administrador del GAD
        $roleAdminGad = Role::create(['name' => 'administrador_gad']);
        $roleAdminGad->givePermissionTo([
            'gestionar emprendimientos',
            'gestionar publicaciones',
            'gestionar usuarios'
        ]);

        // 3.3. Emprendimiento (Dueño de negocio)
        $roleEmprendimiento = Role::create(['name' => 'emprendimiento']);
        $roleEmprendimiento->givePermissionTo([
            'gestionar servicios turisticos',
            'gestionar reservas'
        ]);

        // 3.4. Usuario (Turista)
        $roleUsuario = Role::create(['name' => 'usuario']);
        $roleUsuario->givePermissionTo([
            'hacer reservas'
        ]);


        // ==========================================
        // 4. CREAR UN USUARIO DE PRUEBA Y DARLE EL ROL MÁXIMO
        // ==========================================
        $superAdmin = User::updateOrCreate(
            ['email' => 'alcaldia@gad.gob.ec'], 
            [
                'name' => 'Super Admin GAD',
                'apellidos' => 'del GAD',
                'password' => Hash::make('admin1234'), 
                'cedula' => '0600000000',
                'telefono' => '0900000000',
                'edad'      => 30,
            ]
        );

        // Le asignamos el rol de jefe máximo
        $superAdmin->assignRole($roleSuperAdmin);

    }
}