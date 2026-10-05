<?php
namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Services\ListadoServicioService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class GestorServicios extends Component
{
    #[Url(as: 'tab')]
    public ?int $pestanaActivaId = null;

    #[Url(as: 'vista', except: 'tarjetas')]
    public string $vista = 'tarjetas';

    public array $categoriasActivas = [];

    public function mount(ListadoServicioService $queryService): void
    {
        if (! in_array($this->vista, ['tarjetas', 'lista'], true)) {
            $this->vista = 'tarjetas';
        }

        $emprendimiento = Auth::user()->emprendimiento;
        $categorias = $queryService->obtenerCategoriasActivas($emprendimiento);
        $categorias = $categorias
            ->reject(fn ($categoria) => $categoria->nombre === 'Guianza')
            ->concat($categorias->filter(fn ($categoria) => $categoria->nombre === 'Guianza'))
            ->values();

        if ($categorias->isEmpty()) {
            $this->redirectRoute('emprendimiento.servicios.seleccion', navigate: true);
            return;
        }

        $this->categoriasActivas = $categorias->map(fn($cat) => [
            'pivot_id'         => $cat->pivot->id,
            'tipo_servicio_id' => $cat->id,
            'nombre'           => $cat->nombre,
            // 🔥 SOLUCIÓN: Asignamos la ruta correcta desde el backend
            'ruta_crear'       => $this->obtenerRutaPorCategoria($cat->nombre) 
        ])->toArray();

        if (!$this->pestanaActivaId && !empty($this->categoriasActivas)) {
            $this->pestanaActivaId = $this->categoriasActivas[0]['pivot_id'];
        }
    }

    /**
     * Mapeo seguro de nombres de BD a nombres de Rutas
     */
    private function obtenerRutaPorCategoria(string $nombre): string
    {
        $mapaRutas = [
            'Hospedaje'           => 'emprendimiento.hospedaje.crear',
            'Alimentación'        => 'emprendimiento.alimentacion.crear',
            'Guianza'             => 'emprendimiento.guianza.crear',
            'Alquiler de Equipos' => 'emprendimiento.alquiler.crear',
            'Paquetes Turísticos' => 'emprendimiento.paquete.crear', 
        ];

        // Devuelve la ruta, o una de fallback si por alguna razón no coincide
        return $mapaRutas[$nombre] ?? 'emprendimiento.servicios.index';
    }

    public function seleccionarPestana(int $pivotId): void
    {
        $this->pestanaActivaId = $pivotId;
    }

    #[On('cambiar-vista-servicios')]
    public function cambiarVista(string $vista): void
    {
        if (in_array($vista, ['tarjetas', 'lista'], true)) {
            $this->vista = $vista;
        }
    }

    #[Computed]
    public function categoriaActiva(): ?array
    {
        return collect($this->categoriasActivas)->firstWhere('pivot_id', $this->pestanaActivaId);
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestor-servicios');
    }
}
