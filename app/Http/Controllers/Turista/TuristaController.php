<?php


namespace App\Http\Controllers\Turista;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SitioTuristico;
use App\Models\ActividadTuristica;
use App\Models\Festividad;

class TuristaController extends Controller
{
    public function sitios()
    {
        $sitios = SitioTuristico::with('publicacion.imagenes')
                    ->latest()
                    ->get();

        return view(
            'livewire.Turista.publicacion.sitios',
            compact('sitios')
        );
    }

    public function actividades()
    {
        $actividades = ActividadTuristica::with('publicacion.imagenes')
                    ->latest()
                    ->get();

        return view(
            'livewire.Turista.publicacion.actividades',
            compact('actividades')
        );
    }


    public function festividades()
    {
        $festividades = Festividad::with([
            'publicacion.imagenes',
            'actividades'
        ])->latest()->get();

        return view(
            'livewire.Turista.publicacion.festividades', 
            compact('festividades')
        );
    }
}