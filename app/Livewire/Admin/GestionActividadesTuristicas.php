<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PublicacionTuristica;
use App\Models\ImagenPublicacion;
use App\Models\ActividadTuristica; // O tu modelo real de Actividad
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GestionActividadesTuristicas extends Component
{
    use WithFileUploads;

    // Propiedades del Formulario
    public $nombre;
    public $descripcion;
    public $duracion_estimada;
    public $dificultad;
    public $recomendaciones;

    // Propiedades de Imágenes
    public $imagenes = [];             // Únicamente para subir nuevas fotos
    public $imagenesGuardadas = [];    // Mapea las fotos del servidor en tiempo real

    // Modales y Control de Estados
    public $mostrarModal = false;
    public $modoEdicion = false;
    public $publicacionId;             // Guarda el ID de la publicación activa
    public $actividadId;

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
            'imagenesGuardadas',
            'mostrarModal',
            'modoEdicion',
            'publicacionId',
            'actividadId'
        ]);
        $this->resetErrorBag();
    }

    public function editar($id)
    {
        $this->resetCampos();

        // Buscamos la actividad en base a su publicacion_id
        $actividad = ActividadTuristica::with('publicacion.imagenes')
            ->where('publicacion_id', $id)
            ->firstOrFail();

        $this->publicacionId = $actividad->publicacion_id;
        $this->actividadId = $actividad->id;

        // Cargamos los datos en el formulario
        $this->nombre = $actividad->publicacion->nombre;
        $this->descripcion = $actividad->publicacion->descripcion;
        $this->duracion_estimada = $actividad->duracion_estimada;
        $this->dificultad = $actividad->dificultad;
        $this->recomendaciones = $actividad->recomendaciones;

        // Pasamos las imágenes guardadas al gestor del modal
        $this->imagenesGuardadas = $actividad->publicacion->imagenes;

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
            'imagenes.*' => 'nullable|image|max:5120',
        ]);

        if ($this->modoEdicion) {
            // ACTUALIZAR REGISTROS
            $publicacion = PublicacionTuristica::findOrFail($this->publicacionId);
            $publicacion->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            $actividad = ActividadTuristica::where('publicacion_id', $this->publicacionId)->firstOrFail();
            $actividad->update([
                'duracion_estimada' => $this->duracion_estimada,
                'dificultad' => $this->dificultad,
                'recomendaciones' => $this->recomendaciones,
            ]);
        } else {
            // CREAR NUEVO REGISTRO
            $publicacion = PublicacionTuristica::create([
                'user_id' => Auth::id(),
                'tipo_publicacion_id' => 2, // Asumiendo que 2 representa actividades
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            ActividadTuristica::create([
                'publicacion_id' => $publicacion->id,
                'duracion_estimada' => $this->duracion_estimada,
                'dificultad' => $this->dificultad,
                'recomendaciones' => $this->recomendaciones,
            ]);
        }

        // Guardar nuevas fotos si fueron cargadas en el input
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
        session()->flash('mensaje', 'Actividad guardada con éxito.');
    }

    // Función del gestor de galería para eliminar fotos individuales sin cerrar el modal
    public function eliminarImagen($id)
    {
        $imagen = ImagenPublicacion::findOrFail($id);
        Storage::disk('public')->delete($imagen->imagen);
        $imagen->delete();

        // Refrescar el visor de la galería en caliente
        if ($this->modoEdicion) {
            $this->imagenesGuardadas = ImagenPublicacion::where('publicacion_id', $this->publicacionId)->get();
        }
    }

    public function eliminarActividad($id)
    {
        $actividad = ActividadTuristica::with('publicacion.imagenes')
            ->where('publicacion_id', $id)
            ->firstOrFail();

        // Borrar archivos del storage físico
        foreach ($actividad->publicacion->imagenes as $img) {
            Storage::disk('public')->delete($img->imagen);
            $img->delete();
        }

        $actividad->publicacion->delete();
        $actividad->delete();

        session()->flash('mensaje', 'Actividad eliminada correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.gestion-actividades-turisticas', [
            'actividades' => ActividadTuristica::with('publicacion.imagenes')->get()
        ]);
    }
}