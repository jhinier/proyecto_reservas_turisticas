<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SitioTuristico;
use App\Models\PublicacionTuristica;
use App\Models\ImagenPublicacion;
use Illuminate\Support\Facades\Auth;

class GestionSitiosTuristicos extends Component
{
    use WithFileUploads;

    public $nombre, $descripcion;
    public $imagenes = [];

    public $mostrarModal = false;

    public $modoEdicion = false;

    public $sitioId;
    public $publicacionId;

    public function abrirModal()
    {
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

        public function editar($id)
    {
        $sitio = SitioTuristico::with('publicacion')
                    ->where('publicacion_id', $id)
                    ->firstOrFail();

        $this->sitioId = $sitio->publicacion_id;
        $this->publicacionId = $sitio->publicacion->id;

        $this->nombre = $sitio->publicacion->nombre;
        $this->descripcion = $sitio->publicacion->descripcion;

        $this->modoEdicion = true;

        $this->mostrarModal = true;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'imagenes.*' => 'image|max:5120',
        ]);

        // EDITAR
        if ($this->modoEdicion) {

            $publicacion = PublicacionTuristica::findOrFail($this->publicacionId);

            $publicacion->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

        } else {

            // CREAR
            $publicacion = PublicacionTuristica::create([
                'user_id' => Auth::id(),
                'tipo_publicacion_id' => 1,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);

            SitioTuristico::create([
                'publicacion_id' => $publicacion->id,
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

        $this->reset([
            'nombre',
            'descripcion',
            'imagenes',
            'mostrarModal',
            'modoEdicion',
            'sitioId',
            'publicacionId'
        ]);

        session()->flash('mensaje', 'Operación realizada correctamente');
    }


           public function eliminarSitio($id)
    {
        $sitio = SitioTuristico::with('publicacion.imagenes')
                    ->where('publicacion_id', $id)
                    ->firstOrFail();
    
        // eliminar imágenes
        foreach ($sitio->publicacion->imagenes as $img) {
    
            \Storage::disk('public')->delete($img->imagen);
    
            $img->delete();
        }
    
        // eliminar publicación
        $sitio->publicacion->delete();
    
        // eliminar sitio
        $sitio->delete();
    
        session()->flash('mensaje', 'Sitio eliminado correctamente');
    }

    public function render()
    {
        return view('livewire.admin.gestion-sitios-turisticos', [
            'sitios' => SitioTuristico::with('publicacion.imagenes')->get()
        ]);
    }
}
