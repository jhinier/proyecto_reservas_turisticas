<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LandingController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\GestionEmprendimientos; 
use App\Livewire\Admin\CrearEmprendimiento;
use App\Livewire\Admin\GestionUsuarios; // Importamos tu nuevo componente
use App\Livewire\Emprendimiento\Dashboard as EmprendimientoDashboard;
use App\Livewire\Emprendimiento\GestorServicios;
use App\Livewire\Emprendimiento\GestionServicios\CrearHospedaje;

// 1. PÁGINA PÚBLICA (Lo que ve todo el mundo al entrar)
//Route::view('/', 'welcome')->name('home');
    Route::get('/', [LandingController::class, 'index'])->name('home');
// 2. RUTAS PROTEGIDAS (Solo usuarios logueados)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- EL POLICÍA DE TRÁNSITO ---
    // Esta ruta decide a qué dashboard ir según el rol
    Route::get('/dashboard', function () {
        
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        // Si es GAD -> Se va a su tabla de usuarios
        if ($usuario->hasAnyRole(['superAdministrador', 'administrador_gad'])) {
            return redirect()->route('admin.dashboard'); 
        }
        
        // Si es Emprendimiento -> Se va a su panel con números
        elseif ($usuario->hasRole('emprendimiento')) {
            return redirect()->route('emprendimiento.panel');
        }

        // Si es Turista -> Se queda en el dashboard original
        return view('dashboard'); 
    })->name('dashboard');

    // --- GRUPO DEL GAD ---
    // Solo entran SuperAdmin y Admin del GAD
    Route::prefix('admin')->middleware(['role:superAdministrador|administrador_gad'])->group(function () {
        
        // Esta es la ruta de tu módulo limpio y ordenado
        Route::get('/panel', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/emprendimientos/gestion', GestionEmprendimientos::class)->name('admin.emprendimientos.gestion');
        Route::get('/emprendimientos/gestion/crear', CrearEmprendimiento::class)->name('admin.emprendimientos.crear');

        Route::get('/usuarios', GestionUsuarios::class)->name('admin.usuarios');
        
    });

    // --- GRUPO DE EMPRENDIMIENTOS ---
    Route::prefix('emprendimiento')->middleware(['role:emprendimiento', 'emprendimiento.activo']) ->group(function () {
        // Aquí irán tus rutas de servicios y reservas más adelante
        Route::get('/panel', EmprendimientoDashboard::class)->name('emprendimiento.panel');
        Route::get('/mis-servicios/nuevo', \App\Livewire\Emprendimiento\SeleccionarTipoServicio::class)->name('emprendimiento.servicios.seleccion');
        Route::get('/mis-servicios/servicios', GestorServicios::class)->name('emprendimiento.servicios.index');
        Route::get('/emprendimiento/servicios/nuevo-hospedaje/{pivotId}', CrearHospedaje::class)->name('emprendimiento.hospedaje.crear');
    });

});

// 3. RUTAS DE PERFIL Y AJUSTES (No tocar, son del sistema)
require __DIR__.'/settings.php';
//require __DIR__.'/auth.php'; // Asegúrate de que esta línea esté si existe el archivo