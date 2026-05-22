<?php

namespace App\Livewire\Admin\Festividades;

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

    // FESTIVIDAD
    public $nombre;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;

    // IMÁGENES
    public $imagenes = [];

    // ACTIVIDADES
    public $actividad_nombre;
    public $fecha;
    public $hora;
    public $lugar;
    public $descripcion_actividad;
    public $imagen_actividad;

    public $publicacion_id;

    // GUARDAR FESTIVIDAD
    public function guardarFestividad()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'imagenes.*' => 'nullable|image|max:2048',
        ]);

        // PUBLICACIÓN
        $publicacion = PublicacionTuristica::create([
            'user_id' => Auth::id(),
            'tipo_publicacion_id' => 1,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion
        ]);

        // FESTIVIDAD
        Festividad::create([
            'publicacion_id' => $publicacion->id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        // IMÁGENES
        if (count($this->imagenes) > 0) {
            foreach ($this->imagenes as $img) {
                $ruta = $img->store('publicaciones', 'public');

                ImagenPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'imagen' => $ruta
                ]);
            }
        }

        $this->reset([
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'imagenes'
        ]);

        $this->emitEventos();

        session()->flash('mensaje', 'Festividad guardada correctamente');
    }

    // SELECCIONAR FESTIVIDAD
    public function seleccionarFestividad($id)
    {
        $this->publicacion_id = $id;
    }

    // GUARDAR ACTIVIDAD
    public function guardarActividad()
    {
        $this->validate([
            'actividad_nombre' => 'required',
            'fecha' => 'required',
            'hora' => 'required',
            'lugar' => 'required',
            'descripcion_actividad' => 'required',
            'imagen_actividad' => 'nullable|image|max:2048',
        ]);

        $ruta = null;

        if ($this->imagen_actividad) {
            $ruta = $this->imagen_actividad->store('actividades', 'public');
        }

        Actividad::create([
            'publicacion_id' => $this->publicacion_id,
            'nombre' => $this->actividad_nombre,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'lugar' => $this->lugar,
            'descripcion' => $this->descripcion_actividad,
            'imagen' => $ruta
        ]);

        $this->reset([
            'actividad_nombre',
            'fecha',
            'hora',
            'lugar',
            'descripcion_actividad',
            'imagen_actividad'
        ]);

        // Avisa al componente hermano (Calendario) que está en la carpeta festividades
        $this->dispatch('actualizarCalendarioLateral');
        $this->emitEventos();

        session()->flash('mensaje', 'Actividad guardada correctamente');
    }

    // ELIMINAR
    public function eliminar($id)
    {
        $festividad = Festividad::where('publicacion_id', $id)->first();

        if ($festividad) {
            $festividad->actividades()->delete();
            $festividad->delete();
        }

        $this->dispatch('actualizarCalendarioLateral');
        $this->emitEventos();
        
        session()->flash('mensaje', 'Festividad eliminada correctamente');
    }

    // EMITIR EVENTOS
    public function emitEventos()
    {
        $eventos = Festividad::with('publicacion')->get()->map(function ($f) {
            return [
                'title' => $f->publicacion->nombre,
                'start' => $f->fecha_inicio,
                'end' => $f->fecha_fin,
            ];
        });

        $this->dispatch('actualizarCalendario', eventos: $eventos);
    }

    public function render()
    {
        $festividades = Festividad::with([
            'publicacion.imagenes',
            'actividades'
        ])->latest()->get();

        $eventos = $festividades->map(function ($f) {
            return [
                'title' => $f->publicacion->nombre,
                'start' => $f->fecha_inicio,
                'end' => $f->fecha_fin,
            ];
        });

        return view('livewire.admin.gestion-festividades', [
            'festividades' => $festividades,
            'eventos' => $eventos
        ]);
    }
}