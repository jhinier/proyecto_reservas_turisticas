<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Festividad;
use App\Models\Actividad;
use App\Models\PublicacionTuristica;
use App\Models\ImagenPublicacion;
use Illuminate\Support\Facades\Auth;

class GestionFestividades extends Component
{
    use WithFileUploads;

    // 🔹 VARIABLES
    public $nombre, $fecha_inicio, $fecha_fin, $lugar_festividad, $descripcion_festividad, $imagen;
    public $actividad_nombre, $fecha, $hora, $lugar_actividad, $descripcion_actividad;
    public $publicacion_id;

    // 🔹 GUARDAR FESTIVIDAD
    public function guardarFestividad()
    {
        // 1. Crear publicación
        $publicacion = PublicacionTuristica::create([
            'user_id' => Auth::id(),
            'tipo_publicacion_id' => 1, // 2 = Festividad
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion_festividad
        ]);

        // 2. Crear festividad
          Festividad::create([
         'publicacion_id' => $publicacion->id,
         'nombre' => $this->nombre,
         'fecha_inicio' => $this->fecha_inicio,
         'fecha_fin' => $this->fecha_fin,
         'lugar' => $this->lugar_festividad,
         'descripcion' => $this->descripcion_festividad,
        ]);

        // 3. Imagen
        if ($this->imagen) {
            $ruta = $this->imagen->store('publicaciones', 'public');

            ImagenPublicacion::create([
                'publicacion_id' => $publicacion->id,
                'imagen' => $ruta
            ]);
        }

        $this->reset();

        session()->flash('mensaje', 'Festividad guardada correctamente');
    }

    // 🔹 SELECCIONAR FESTIVIDAD
    public function seleccionarFestividad($id)
    {
        $this->publicacion_id = $id;
    }

    // 🔹 ELIMINAR
    public function eliminar($id)
    {
        Festividad::find($id)?->delete();

        $this->emitEventos();
    }

    // 🔹 GUARDAR ACTIVIDAD
    public function guardarActividad()
    {
        Actividad::create([
            'publicacion_id' => $this->publicacion_id,
            'nombre' => $this->actividad_nombre,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'lugar' => $this->lugar_actividad,
            'descripcion' => $this->descripcion_actividad,
        ]);
    }

    // 🔹 EVENTOS CALENDARIO
    public function emitEventos()
    {
        $eventos = Festividad::all()->map(function ($f) {
            return [
                'title' => $f->nombre,
                'start' => $f->fecha_inicio,
                'end'   => $f->fecha_fin,
            ];
        });

        $this->dispatch('actualizarCalendario', eventos: $eventos);
    }

    public function render()
    {
        $festividades = Festividad::with('actividades')->get();

        $eventos = $festividades->map(function ($f) {
            return [
                'title' => $f->nombre,
                'start' => $f->fecha_inicio,
                'end'   => $f->fecha_fin,
            ];
        });

        return view('livewire.admin.gestion-festividades', [
            'festividades' => $festividades,
            'eventos' => $eventos
        ]);
    }
}