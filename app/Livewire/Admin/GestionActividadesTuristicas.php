<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PublicacionTuristica;
use App\Models\ImagenPublicacion;
use App\Models\ActividadTuristica;
use Illuminate\Support\Facades\Auth;

class GestionActividadesTuristicas extends Component
{
    use WithFileUploads;

    public $nombre;
    public $descripcion;
    public $duracion_estimada;
    public $dificultad;
    public $recomendaciones;

    public $imagenes = [];

    public $mostrarModal = false;
    public $modoEdicion = false;

    public $actividadId;
    public $publicacionId;

    public function abrirModal()
    {
        $this->resetCampos();

        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->resetCampos();
    }

    public function resetCampos()
    {
        $this->reset([
            'nombre',
            'descripcion',
            'duracion_estimada',
            'dificultad',
            'recomendaciones',
            'imagenes',
            'mostrarModal',
            'modoEdicion',
            'actividadId',
            'publicacionId'
        ]);
    }

    public function editar($id)
    {
        $actividad = ActividadTuristica::with('publicacion')
            ->where('publicacion_id', $id)
            ->firstOrFail();

        $this->actividadId = $actividad->publicacion_id;
        $this->publicacionId = $actividad->publicacion->id;

        $this->nombre = $actividad->publicacion->nombre;
        $this->descripcion = $actividad->publicacion->descripcion;

        $this->duracion_estimada = $actividad->duracion_estimada;
        $this->dificultad = $actividad->dificultad;
        $this->recomendaciones = $actividad->recomendaciones;

        $this->modoEdicion = true;

        $this->mostrarModal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'duracion_estimada' => 'required|string',
            'dificultad' => 'required|string',
            'recomendaciones' => 'required|string',
            'imagenes.*' => 'image|max:5120',
        ]);

        // EDITAR
        if ($this->modoEdicion) {

            $publicacion = PublicacionTuristica::findOrFail($this->publicacionId);

            $publicacion->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            $actividad = ActividadTuristica::where('publicacion_id', $this->publicacionId)
                ->firstOrFail();

            $actividad->update([
                'duracion_estimada' => $this->duracion_estimada,
                'dificultad' => $this->dificultad,
                'recomendaciones' => $this->recomendaciones,
            ]);

        } else {

            // CREAR PUBLICACIÓN
            $publicacion = PublicacionTuristica::create([
                'user_id' => Auth::id(),
                'tipo_publicacion_id' => 2,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            // CREAR ACTIVIDAD
            ActividadTuristica::create([
                'publicacion_id' => $publicacion->id,
                'duracion_estimada' => $this->duracion_estimada,
                'dificultad' => $this->dificultad,
                'recomendaciones' => $this->recomendaciones,
            ]);
        }

        // GUARDAR IMÁGENES
        if (!empty($this->imagenes)) {

            foreach ($this->imagenes as $img) {

                $ruta = $img->store('publicaciones', 'public');

                ImagenPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'imagen' => $ruta,
                ]);
            }
        }

        $this->resetCampos();

        session()->flash('mensaje', 'Actividad turística guardada correctamente');
    }

    public function eliminarActividad($id)
    {
        $actividad = ActividadTuristica::with('publicacion.imagenes')
            ->where('publicacion_id', $id)
            ->firstOrFail();

        foreach ($actividad->publicacion->imagenes as $img) {

            \Storage::disk('public')->delete($img->imagen);

            $img->delete();
        }

        $actividad->publicacion->delete();

        $actividad->delete();

        session()->flash('mensaje', 'Actividad eliminada correctamente');
    }

    public function eliminarImagen($id)
    {
        $imagen = ImagenPublicacion::findOrFail($id);

        \Storage::disk('public')->delete($imagen->imagen);

        $imagen->delete();

        session()->flash('mensaje', 'Imagen eliminada correctamente');
    }

    public function render()
    {
        return view('livewire.admin.gestion-actividades-turisticas', [
            'actividades' => ActividadTuristica::with('publicacion.imagenes')->get()
        ]);
    }
}