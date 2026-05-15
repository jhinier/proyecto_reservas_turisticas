<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\ReservaService;

class CalendarioLateral extends Component
{
    public bool $abierto = false;
    
    #[Reactive]
    public ?string $filtroCategoria = null;
    
    #[Reactive]
    public ?string $filtroEstado = null;
    
    #[Reactive]
    public ?string $buscarCedula = null;

    public int $mesActual;
    public int $anioActual;
    public string $diaSeleccionado;

    protected $listeners = ['abrirCalendario' => 'abrir'];

    public function mount()
    {
        $this->irAHoy();
    }

    public function abrir() 
    { 
        $this->abierto = true; 
    }

    public function cerrar() 
    { 
        $this->abierto = false; 
    }

    public function irAHoy()
    {
        $hoy = Carbon::today();
        $this->mesActual = $hoy->month;
        $this->anioActual = $hoy->year;
        $this->diaSeleccionado = $hoy->format('Y-m-d');
    }

    public function mesAnterior()
    {
        $fecha = Carbon::create($this->anioActual, $this->mesActual, 1)->subMonth();
        $this->mesActual = $fecha->month;
        $this->anioActual = $fecha->year;
    }

    public function mesSiguiente()
    {
        $fecha = Carbon::create($this->anioActual, $this->mesActual, 1)->addMonth();
        $this->mesActual = $fecha->month;
        $this->anioActual = $fecha->year;
    }

    public function semanaAnterior()
    {
        $this->diaSeleccionado = Carbon::parse($this->diaSeleccionado)->subWeek()->format('Y-m-d');
        $this->sincronizarMesConDia();
    }

    public function semanaSiguiente()
    {
        $this->diaSeleccionado = Carbon::parse($this->diaSeleccionado)->addWeek()->format('Y-m-d');
        $this->sincronizarMesConDia();
    }

    private function sincronizarMesConDia()
    {
        $fecha = Carbon::parse($this->diaSeleccionado);
        $this->mesActual = $fecha->month;
        $this->anioActual = $fecha->year;
    }

    public function seleccionarDia(int $dia)
    {
        $this->diaSeleccionado = Carbon::create($this->anioActual, $this->mesActual, $dia)->format('Y-m-d');
    }

    #[Computed]
    public function datosCalendario()
    {
        $fechaFoco = Carbon::create($this->anioActual, $this->mesActual, 1);
        return [
            'nombreMes'       => $fechaFoco->translatedFormat('F Y'),
            'diasEnMes'       => $fechaFoco->daysInMonth,
            'primerDiaSemana' => $fechaFoco->dayOfWeekIso,
        ];
    }

    #[Computed]
    public function diasMostrar()
    {
        $inicio = Carbon::parse($this->diaSeleccionado)->startOfWeek(Carbon::MONDAY);
        $dias = [];
        
        for ($i = 0; $i < 7; $i++) {
            $dias[] = $inicio->copy()->addDays($i);
        }
        
        return $dias;
    }

    #[Computed]
    public function agendaPorDia()
    {
        $emprendimientoId = Auth::user()->emprendimiento->id;
        $inicioSemana = $this->diasMostrar[0]->format('Y-m-d');
        $finSemana = $this->diasMostrar[6]->format('Y-m-d');

        $servicios = app(ReservaService::class)->obtenerAgendaPorRangoYFiltros(
            $emprendimientoId, 
            $inicioSemana, 
            $finSemana, 
            $this->filtroCategoria,
            $this->filtroEstado,
            $this->buscarCedula
        );

        $agenda = [];
        foreach($this->diasMostrar as $dia) {
            $agenda[$dia->format('Y-m-d')] = [];
        }

        foreach($servicios as $servicio) {
            $inicioStr = Carbon::parse($servicio->fecha_inicio)->format('Y-m-d');
            $finStr = $servicio->fecha_fin ? Carbon::parse($servicio->fecha_fin)->format('Y-m-d') : $inicioStr;
            
            foreach($this->diasMostrar as $diaObj) {
                $diaStr = $diaObj->format('Y-m-d');
                if($diaStr >= $inicioStr && $diaStr <= $finStr) {
                    $agenda[$diaStr][] = $servicio;
                }
            }
        }

        return $agenda;
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.calendario-lateral');
    }
}