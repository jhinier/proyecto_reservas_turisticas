<?php

/**
 * Componente Livewire para crear, editar, listar y eliminar festividades turisticas.
 */

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

    // Identificador de la actividad que se está editando
    public $actividadEditandoId = null;

    // Imagen actual de la actividad
    public $imagenActividadActual = null;

    public $actividadesEdicion = [];

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
            'descripcion' => 'required|string|max:10000',
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

        $this->resetValidation();

        $this->modoEditar = true;
        $this->publicacion_id = $id;

        $festividad = Festividad::with([
            'publicacion',
            'actividades',
        ])
            ->where('publicacion_id', $id)
            ->firstOrFail();

        $this->nombre = $festividad->publicacion->nombre;
        $this->descripcion = $festividad->publicacion->descripcion;
        $this->fecha_inicio = $festividad->fecha_inicio;
        $this->fecha_fin = $festividad->fecha_fin;

        $this->refrescarActividadesEdicion();
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
            'descripcion_actividad' => 'required|string|max:10000',
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
        $this->refrescarActividadesEdicion();
    }

    /**
     * Cargar una actividad existente en el formulario de edición.
     */
    public function cargarActividadParaEditar($id)
    {
        $actividad = Actividad::where('publicacion_id', $this->publicacion_id)
            ->whereKey($id)
            ->firstOrFail();

        $this->resetValidation();

        $this->actividadEditandoId = $actividad->id;
        $this->actividad_nombre = $actividad->nombre;
        $this->fecha = $actividad->fecha?->format('Y-m-d');
        $this->hora = $actividad->hora;
        $this->lugar = $actividad->lugar;
        $this->descripcion_actividad = $actividad->descripcion;
        $this->imagenActividadActual = $actividad->imagen;
        $this->imagen_actividad = null;

        $this->dispatch('abrir-modal-editar-actividad');
    }


    /**
     * Guardar los cambios de una actividad existente.
     */
    public function actualizarActividad()
    {
        $this->validate([
            'actividad_nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required',
            'lugar' => 'required|string|max:255',
            'descripcion_actividad' => 'required|string|max:10000',
            'imagen_actividad' => 'nullable|image|max:2048',
        ]);

        $actividad = Actividad::where('publicacion_id', $this->publicacion_id)
            ->whereKey($this->actividadEditandoId)
            ->firstOrFail();

        $datos = [
            'nombre' => $this->actividad_nombre,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'lugar' => $this->lugar,
            'descripcion' => $this->descripcion_actividad,
        ];

        // Reemplazar la imagen solo si se seleccionó una nueva.
        if ($this->imagen_actividad) {
            if ($actividad->imagen) {
                Storage::disk('public')->delete($actividad->imagen);
            }

            $datos['imagen'] = $this->imagen_actividad->store(
                'actividades',
                'public'
            );
        }

        $actividad->update($datos);
        $this->refrescarActividadesEdicion();

        $this->reset([
            'actividadEditandoId',
            'actividad_nombre',
            'fecha',
            'hora',
            'lugar',
            'descripcion_actividad',
            'imagen_actividad',
            'imagenActividadActual',
        ]);

        $this->dispatch('actualizarCalendarioLateral');
        $this->emitEventos();

        session()->flash('mensaje', 'Actividad actualizada correctamente');
    }


    /**
     * Eliminar una actividad existente.
     */
    public function eliminarActividad($id)
    {
        $actividad = Actividad::where('publicacion_id', $this->publicacion_id)
            ->whereKey($id)
            ->firstOrFail();

        if ($actividad->imagen) {
            Storage::disk('public')->delete($actividad->imagen);
        }

        $actividad->delete();
        $this->refrescarActividadesEdicion();

        $this->dispatch('actualizarCalendarioLateral');
        $this->emitEventos();

        session()->flash('mensaje', 'Actividad eliminada correctamente');
    }


    private function refrescarActividadesEdicion(): void
    {
        if (!$this->publicacion_id) {
            $this->actividadesEdicion = [];

            return;
        }

        $this->actividadesEdicion = Actividad::where(
            'publicacion_id',
            $this->publicacion_id
        )
            ->get()
            ->map(function ($actividad) {
                return [
                    'id' => $actividad->id,
                    'nombre' => $actividad->nombre,
                    'fecha' => $actividad->fecha?->format('Y-m-d'),
                    'hora' => $actividad->hora,
                    'lugar' => $actividad->lugar,
                ];
            })
            ->toArray();
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
            'publicacion_id',
            'actividadesEdicion',
            'actividadEditandoId',
            'imagenActividadActual',
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
