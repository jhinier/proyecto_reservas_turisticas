<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SitioTuristico;
use App\Models\ActividadTuristica;
use App\Models\Festividad;

class LandingController extends Controller
{
    public function index()
    {
        // Esto le dice a Laravel que busque tu vista welcome.blade.php
        // y la muestre en la pantalla.
        return view('welcome');
    }

        public function detalleSitio($id)
    {
        $sitio = SitioTuristico::with('publicacion.imagenes')
                    ->findOrFail($id);
    
        return view(
            'turista.publicacion.detalle-sitio',
            compact('sitio')
        );
    }

    public function detalleActividad($id)
    {
        $actividad = ActividadTuristica::with('publicacion.imagenes')
                        ->findOrFail($id);

        return view(
            'livewire.Turista.publicacion.detalle-actividad',
            compact('actividad')
        );
    }

    public function detalleFestividad($id)
    {
        $festividad = Festividad::with([
            'publicacion.imagenes',
            'actividades'
        ])->findOrFail($id);
    
        return view(
            'livewire.Turista.publicacion.detalle-festividad',
            compact('festividad')
        );
    }



}
