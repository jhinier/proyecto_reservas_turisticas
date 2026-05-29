<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SitioTuristico;
use App\Models\PublicacionTuristica;
use App\Models\ImagenPublicacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GestionSitiosTuristicos extends Component
{
    use WithFileUploads;

    public $nombre, $descripcion;
    public $imagenes = []; // Se usa en el formulario de creación rápida inicial

    // CONTROL DE INTERFAZ DE MODALES
    public $mostrarModal = false;
    public $modoEdicion = false;
    public $sitioId;
    public $publicacionId;

    // GESTOR DE GALERÍA AVANZADO COMPACTO
    public $abierto = false;
    public $sitioSeleccionado = null;
    public $nuevasImagenes = [];

    // ====================================================
    // MÉTODOS DEL GESTOR DE GALERÍA INDEPENDIENTE
    // ====================================================
    public function abrirGaleria($id)
    {
        $this->publicacionId = $id;
        $this->sitioSeleccionado = SitioTuristico::with('publicacion.imagenes')->where('publicacion_id', $id)->first();
        $this->nuevasImagenes = [];
        $this->abierto = true;
    }

    public function subirFotos()
    {
        $this->validate([
            'nuevasImagenes.*' => 'image|max:5120',
        ]);

        if (count($this->nuevasImagenes) > 0) {
            foreach ($this->nuevasImagenes as $img) {
                $ruta = $img->store('publicaciones', 'public');

                ImagenPublicacion::create([
                    'publicacion_id' => $this->publicacionId,
                    'imagen' => $ruta
                ]);
            }
        }

        $this->nuevasImagenes = [];
        $this->sitioSeleccionado = SitioTuristico::with('publicacion.imagenes')->where('publicacion_id', $this->publicacionId)->first();
        session()->flash('mensaje_galeria', 'Imágenes agregadas correctamente a la galería');
    }

    public function eliminarImagen($imagenId)
    {
        $imagen = ImagenPublicacion::find($imagenId);
        if ($imagen) {
            Storage::disk('public')->delete(str_replace('storage/', '', $imagen->imagen));
            $imagen->delete();
        }

        if ($this->publicacionId) {
            $this->sitioSeleccionado = SitioTuristico::with('publicacion.imagenes')->where('publicacion_id', $this->publicacionId)->first();
        }
        session()->flash('mensaje_galeria', 'Imagen eliminada de los registros');
    }

    public function removerTemporal($index)
    {
        array_splice($this->nuevasImagenes, $index, 1);
    }

    // ====================================================
    // ACCIONES GENERALES DEL COMPONENTE SITIOS
    // ====================================================
    public function abrirModal()
    {
        $this->reset(['nombre', 'descripcion', 'imagenes', 'modoEdicion', 'sitioId', 'publicacionId']);
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
        ]);

        if ($this->modoEdicion) {
            $publicacion = PublicacionTuristica::findOrFail($this->publicacionId);
            $publicacion->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);
        } else {
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

        $this->reset([
            'nombre', 'descripcion', 'imagenes', 'mostrarModal', 'modoEdicion', 'sitioId', 'publicacionId'
        ]);

        session()->flash('mensaje', 'Operación realizada correctamente');
    }

    public function eliminarSitio($id)
    {
        $sitio = SitioTuristico::with('publicacion.imagenes')
                    ->where('publicacion_id', $id)
                    ->firstOrFail();
    
        foreach ($sitio->publicacion->imagenes as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img->imagen));
            $img->delete();
        }
    
        $sitio->publicacion->delete();
        $sitio->delete();
    
        session()->flash('mensaje', 'Sitio eliminado correctamente');
    }

    public function render()
    {
        return view('livewire.admin.gestion-sitios-turisticos', [
            'sitios' => SitioTuristico::with('publicacion.imagenes')->latest()->get()
        ]);
    }
}