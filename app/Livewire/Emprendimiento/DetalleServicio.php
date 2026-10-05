<?php

namespace App\Livewire\Emprendimiento;

use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalleServicio extends Component
{
    public bool $abierto = false;

    public ?Servicio $servicio = null;

    #[On('abrir-detalle-servicio')]
    public function abrir(int $servicioId): void
    {
        $emprendimientoId = Auth::user()?->emprendimiento?->id;

        abort_unless($emprendimientoId, 403);

        $this->servicio = Servicio::query()
            ->with([
                'imagenes:id,servicio_id,imagen',
                'categoriaPivot:id,emprendimiento_id,tipo_servicio_id',
                'categoriaPivot.tipoServicio:id,nombre',
                'detalleHospedaje',
                'detalleGuianza',
                'detalleAlimentacion',
                'detallePaqueteTuristico',
            ])
            ->whereHas('categoriaPivot', function ($query) use ($emprendimientoId) {
                $query->where('emprendimiento_id', $emprendimientoId);
            })
            ->findOrFail($servicioId);

        $this->abierto = true;
    }

    public function cerrar(): void
    {
        $this->abierto = false;
        $this->servicio = null;
    }

    public function render()
    {
        return view('livewire.emprendimiento.detalle-servicio');
    }
}
