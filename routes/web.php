<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LandingController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\GestionEmprendimientos; 
use App\Livewire\Admin\CrearEmprendimiento;
use App\Livewire\Admin\GestionUsuarios; 
use App\Livewire\Emprendimiento\Dashboard as EmprendimientoDashboard;
use App\Livewire\Emprendimiento\SeleccionarTipoServicio;
use App\Livewire\Emprendimiento\GestorServicios;
use App\Livewire\Emprendimiento\GestionServicios\CrearHospedaje;
use App\Livewire\Admin\Festividades\GestionFestividades;
use App\Livewire\Admin\GestionSitiosTuristicos;
use App\Livewire\Admin\GestionActividadesTuristicas;

use App\Livewire\Emprendimiento\GestionServicios\CrearGuianza;
use App\Livewire\Emprendimiento\GestionServicios\CrearAlimentacion;
use App\Livewire\Emprendimiento\GestionServicios\CrearPaqueteTuristico;
use App\Livewire\Emprendimiento\GestionServicios\CrearAlquilerEquipo;
use App\Livewire\Emprendimiento\GestorReservas;
use App\Livewire\Emprendimiento\Reserva\CrearReserva;
use App\Http\Controllers\Emprendimiento\ReporteEmprendedorController;
use App\Livewire\Admin\MapaTuristico\Index;
use App\Livewire\Turista\MapaTuristico\Index as MapaTuristicoTurista;

//Turista Publicaciones
use App\Http\Controllers\Turista\TuristaController;

// Importamos los componentes del turista
use App\Livewire\Turista\Servicios\BuscadorServicios;
use App\Livewire\Turista\Servicios\VerServicios;


// 1. PÁGINA PÚBLICA (Lo que ve todo el mundo al entrar)
Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasAnyRole(['admin', 'superAdministrador', 'administrador_gad'])) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($user->hasRole('emprendimiento')) {
            return redirect()->route('emprendimiento.panel');
        }
    }
    
    // Si no tiene sesión activa o es turista, carga el controlador normalmente
    return app(LandingController::class)->index();
})->name('home');

// Ruta pública del buscador de servicios
Route::get('/servicios', BuscadorServicios::class)->name('turista.servicios.index');
Route::get('/empresa/{emprendimiento}/servicios/{tipo?}', VerServicios::class)->name('turista.empresa.servicios');

// Ruta Visitante un sitio turístico- PUBLICACIONES
//Route::view('/', 'livewire.Turista.publicacion.inicio');
Route::get('/sitios', [TuristaController::class, 'sitios'])->name('sitios');
Route::get('/sitio-turistico/{sitio}', [LandingController::class, 'detalleSitio'])->name('turista.sitio.detalle');
Route::get('/actividades', [TuristaController::class, 'actividades'])->name('actividades');
Route::get('/actividad-turistica/{actividad}',[LandingController::class, 'detalleActividad'])->name('turista.actividad.detalle');
Route::get('/festividades', [TuristaController::class, 'festividades'])->name('festividades');
Route::get('/festividad/{festividad}',[LandingController::class, 'detalleFestividad'])->name('turista.festividad.detalle');


// 2. RUTAS PROTEGIDAS (Solo usuarios logueados)
Route::middleware(['auth', 'verified'])->group(function () {

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

        // Si es Turista -> Lo enviamos de regreso al inicio
        return redirect()->route('home'); 
    })->name('dashboard');

    // --- GRUPO DEL GAD ---
    // Solo entran SuperAdmin y Admin del GAD
    Route::prefix('admin')->middleware(['role:superAdministrador|administrador_gad'])->group(function () {
        Route::get('/panel', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/emprendimientos/gestion', GestionEmprendimientos::class)->name('admin.emprendimientos.gestion');
        Route::get('/emprendimientos/gestion/crear', CrearEmprendimiento::class)->name('admin.emprendimientos.crear');
        Route::get('/usuarios', GestionUsuarios::class)->name('admin.usuarios');
        Route::get('/festividades/gestion', GestionFestividades::class)->name('admin.festividades.gestion');
        Route::get('/admin/sitios', GestionSitiosTuristicos::class)->name('admin.sitios.gestion');
        Route::get('/admin/actividades', GestionActividadesTuristicas::class)->name('admin.actividades');
        //Ruta de vista de mapa

        Route::get('/MapaTuristico', Index::class)->name('admin.mapa.turistico');
    });

    // --- GRUPO DE EMPRENDIMIENTOS ---
    Route::prefix('emprendimiento')->middleware(['role:emprendimiento', 'emprendimiento.activo'])->group(function () {
        Route::get('/panel', EmprendimientoDashboard::class)->name('emprendimiento.panel');
        Route::get('/mis-servicios/nuevo', SeleccionarTipoServicio::class)->name('emprendimiento.servicios.seleccion');
        Route::get('/mis-servicios/servicios', GestorServicios::class)->name('emprendimiento.servicios.index');
        Route::get('/mis-servicios/servicios/nuevo-hospedaje/{pivotId}', CrearHospedaje::class)->name('emprendimiento.hospedaje.crear');
        Route::get('/mis-servicios/servicios/nuevo-guianza/{pivotId}', CrearGuianza::class)->name('emprendimiento.guianza.crear');
        Route::get('/mis-servicios/servicios/nuevo-alimentacion/{pivotId}', CrearAlimentacion::class)->name('emprendimiento.alimentacion.crear');
        Route::get('/mis-servicios/servicios/nuevo-paquete/{pivotId}', CrearPaqueteTuristico::class)->name('emprendimiento.paquete.crear');
        Route::get('/mis-servicios/servicios/nuevo-alquiler/{pivotId}', CrearAlquilerEquipo::class)->name('emprendimiento.alquiler.crear');

        Route::get('/reservas', GestorReservas::class)->name('emprendimiento.reservas');
        Route::get('/reservas/nueva', CrearReserva::class)->name('emprendimiento.reservas.crear');
        Route::get('/reportes', \App\Livewire\Emprendimiento\GestionReportes::class)->name('emprendimiento.reportes'); // <--- EL NOMBRE TIENE QUE SER ESTE EXACTO
        Route::get('/reportes/descargar', [App\Http\Controllers\Emprendimiento\ReporteEmprendedorController::class, 'descargarReporte'])->name('reportes.descargar');
    });

   // --- GRUPO DEL TURISTA ---
    Route::prefix('turista')->group(function () {
        Route::get('/checkout', App\Livewire\Turista\Reservas\Checkout::class)->name('turista.reservas.checkout');
        Route::get('/mis-reservas', \App\Livewire\Turista\Reservas\HistorialReservas::class)->name('turista.reservas.historial')->middleware('auth');
    });
    
});

// 3. RUTAS DE PERFIL Y AJUSTES (No tocar, son del sistema)
require __DIR__.'/settings.php';
//require __DIR__.'/auth.php'; // Asegúrate de que esta línea esté si existe el archivo