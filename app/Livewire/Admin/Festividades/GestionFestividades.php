<?php

namespace App\Livewire\Admin\Festividades;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Festividad;
use App\Models\Actividad;
use App\Models\PublicacionTuristica;
use App\Models\ImagenPublicacion;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GestionFestividades extends Component
{
    use WithFileUploads;

    // ====================================================
    // CONTROL DE INTERFAZ Y MODALES
    // ====================================================

    public $modoEditar = false;

    public $publicacion_id;

    public $abierto = false;

    public $festividadSeleccionada = null;

    // ====================================================
    // FILTRO DE ESTADOS
    // ====================================================

    public $filtroEstado = 'todos';

    // ====================================================
    // PROPIEDADES DEL FORMULARIO PRINCIPAL
    // ====================================================

    public $nombre;

    public $descripcion;

    public $fecha_inicio;

    public $fecha_fin;

    // ====================================================
    // GESTOR DE GALERÍA
    // ====================================================

    public $nuevasImagenes = [];

    // ====================================================
    // PROPIEDADES DE ACTIVIDADES
    // ====================================================

    public $actividad_nombre;

    public $fecha;

    public $hora;

    public $lugar;

    public $descripcion_actividad;

    public $imagen_actividad;

    // ====================================================
    // MÉTODOS DEL GESTOR DE GALERÍA
    // ====================================================

    public function abrirGaleria($id)
    {
        $this->publicacion_id = $id;

        $this->festividadSeleccionada = Festividad::with(
            'publicacion.imagenes'
        )
            ->where('publicacion_id', $id)
            ->first();

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
                    'publicacion_id' => $this->publicacion_id,
                    'imagen' => $ruta
                ]);
            }
        }

        $this->nuevasImagenes = [];

        $this->festividadSeleccionada = Festividad::with(
            'publicacion.imagenes'
        )
            ->where('publicacion_id', $this->publicacion_id)
            ->first();

        session()->flash(
            'mensaje_galeria',
            'Imágenes guardadas e indexadas con éxito'
        );
    }

    public function eliminarImagen($imagenId)
    {
        $imagen = ImagenPublicacion::find($imagenId);

        if ($imagen) {

            Storage::disk('public')->delete(
                str_replace('storage/', '', $imagen->imagen)
            );

            $imagen->delete();
        }

        if ($this->publicacion_id) {

            $this->festividadSeleccionada = Festividad::with(
                'publicacion.imagenes'
            )
                ->where('publicacion_id', $this->publicacion_id)
                ->first();
        }

        session()->flash(
            'mensaje_galeria',
            'Fotografía removida del servidor'
        );
    }

    public function removerTemporal($index)
    {
        array_splice($this->nuevasImagenes, $index, 1);
    }

    // ====================================================
    // MÉTODOS DEL FORMULARIO PRINCIPAL
    // ====================================================

    public function guardarFestividad()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ]);

        // ====================================================
        // EDITAR
        // ====================================================

        if ($this->modoEditar) {

            $publicacion = PublicacionTuristica::find(
                $this->publicacion_id
            );

            if ($publicacion) {

                $publicacion->update([
                    'nombre' => $this->nombre,
                    'descripcion' => $this->descripcion
                ]);

                $festividad = Festividad::where(
                    'publicacion_id',
                    $this->publicacion_id
                )->first();

                if ($festividad) {

                    $festividad->update([
                        'fecha_inicio' => $this->fecha_inicio,
                        'fecha_fin' => $this->fecha_fin,
                    ]);
                }
            }

            $mensajeOk = 'Festividad modificada correctamente';

        }

        // ====================================================
        // CREAR
        // ====================================================

        else {

            $publicacion = PublicacionTuristica::create([
                'user_id' => Auth::id(),
                'tipo_publicacion_id' => 1,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion
            ]);

            Festividad::create([
                'publicacion_id' => $publicacion->id,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
            ]);

            $mensajeOk = 'Festividad creada con éxito';
        }

        $this->limpiarCampos();

        $this->modoEditar = false;

        $this->emitEventos();

        session()->flash('mensaje', $mensajeOk);
    }

    // ====================================================
    // CARGAR FESTIVIDAD PARA EDITAR
    // ====================================================

    public function cargarFestividad($id)
    {
        $this->limpiarCampos();

        $this->modoEditar = true;

        $this->publicacion_id = $id;

        $festividad = Festividad::with('publicacion')
            ->where('publicacion_id', $id)
            ->first();

        if ($festividad) {

            $this->nombre = $festividad->publicacion->nombre;

            $this->descripcion =
                $festividad->publicacion->descripcion;

            $this->fecha_inicio =
                $festividad->fecha_inicio;

            $this->fecha_fin =
                $festividad->fecha_fin;
        }
    }

    // ====================================================
    // ELIMINAR
    // ====================================================

    public function eliminar($id)
    {
        $festividad = Festividad::where(
            'publicacion_id',
            $id
        )->first();

        if ($festividad) {

            $festividad->actividades()->delete();

            $festividad->delete();
        }

        $this->dispatch('actualizarCalendarioLateral');

        $this->emitEventos();

        session()->flash(
            'mensaje',
            'Festividad eliminada correctamente'
        );
    }

    // ====================================================
    // SELECCIONAR FESTIVIDAD
    // ====================================================

    public function seleccionarFestividad($id)
    {
        $this->publicacion_id = $id;
    }

    // ====================================================
    // GUARDAR ACTIVIDAD
    // ====================================================

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

            $ruta = $this->imagen_actividad->store(
                'actividades',
                'public'
            );
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

        $this->dispatch('actualizarCalendarioLateral');

        $this->emitEventos();

        session()->flash(
            'mensaje',
            'Actividad guardada correctamente'
        );
    }

    // ====================================================
    // LIMPIAR CAMPOS
    // ====================================================

    public function limpiarCampos()
    {
        $this->reset([
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'publicacion_id'
        ]);
    }

    // ====================================================
    // ACTUALIZAR CALENDARIO
    // ====================================================

    public function emitEventos()
    {
        $eventos = Festividad::with('publicacion')
            ->get()
            ->map(function ($f) {

                return [
                    'title' => $f->publicacion->nombre,
                    'start' => $f->fecha_inicio,
                    'end' => $f->fecha_fin,
                ];
            });

        $this->dispatch(
            'actualizarCalendario',
            eventos: $eventos
        );
    }

    // ====================================================
    // FILTRO DE ESTADOS
    // ====================================================

    public function actualizarFiltro($estado)
    {
        $this->filtroEstado = $estado;
    }

    // ====================================================
    // RENDER
    // ====================================================

    public function render()
    {
        // ----------------------------------------------------
        // OBTENER TODAS LAS FESTIVIDADES
        // ----------------------------------------------------

        $festividades = Festividad::with([
            'publicacion.imagenes',
            'actividades'
        ])
            ->latest()
            ->get();

        // ----------------------------------------------------
        // FECHA ACTUAL
        // ----------------------------------------------------

        $hoy = now()->startOfDay();

        // ----------------------------------------------------
        // APLICAR FILTRO
        // ----------------------------------------------------

        if ($this->filtroEstado !== 'todos') {

            $festividades = $festividades->filter(
                function ($festividad) use ($hoy) {

                    $inicio = \Carbon\Carbon::parse(
                        $festividad->fecha_inicio
                    )->startOfDay();

                    $fin = \Carbon\Carbon::parse(
                        $festividad->fecha_fin
                    )->endOfDay();

                    // -------------------------------
                    // PRÓXIMAMENTE
                    // -------------------------------

                    if (
                        $hoy->lt($inicio)
                        && $this->filtroEstado === 'proximamente'
                    ) {
                        return true;
                    }

                    // -------------------------------
                    // EN CURSO
                    // -------------------------------

                    if (
                        $hoy->gte($inicio)
                        && $hoy->lte($fin)
                        && $this->filtroEstado === 'encurso'
                    ) {
                        return true;
                    }

                    // -------------------------------
                    // FINALIZADO
                    // -------------------------------

                    if (
                        $hoy->gt($fin)
                        && $this->filtroEstado === 'finalizado'
                    ) {
                        return true;
                    }

                    return false;
                }
            );
        }

        // ----------------------------------------------------
        // EVENTOS PARA EL CALENDARIO
        // ----------------------------------------------------

        $eventos = Festividad::with('publicacion')
            ->get()
            ->map(function ($f) {

                return [
                    'title' => $f->publicacion->nombre,
                    'start' => $f->fecha_inicio,
                    'end' => $f->fecha_fin,
                ];
            });

        // ----------------------------------------------------
        // VISTA
        // ----------------------------------------------------

        return view(
            'livewire.admin.gestion-festividades',
            [
                'festividades' => $festividades,
                'eventos' => $eventos
            ]
        );
    }

    // ====================================================
    // VER DETALLES
    // ====================================================

    public $festividadDetalle = null;

    public function verDetalles($publicacionId)
    {
        $this->festividadDetalle = Festividad::with([
            'publicacion.imagenes',
            'actividades'
        ])
            ->where('publicacion_id', $publicacionId)
            ->first();
    }
}