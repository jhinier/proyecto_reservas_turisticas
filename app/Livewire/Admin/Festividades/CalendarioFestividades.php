<?php

namespace App\Livewire\Admin\Festividades;

use App\Models\Actividad;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;

class CalendarioFestividades extends Component
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

    protected $listeners = [
        'abrirCalendario' => 'abrir'
    ];

    public function mount()
    {
        Carbon::setLocale('es');
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
        $fecha = Carbon::create(
            $this->anioActual,
            $this->mesActual,
            1
        )->subMonth();

        $this->mesActual = $fecha->month;
        $this->anioActual = $fecha->year;
    }

    public function mesSiguiente()
    {
        $fecha = Carbon::create(
            $this->anioActual,
            $this->mesActual,
            1
        )->addMonth();

        $this->mesActual = $fecha->month;
        $this->anioActual = $fecha->year;
    }

    public function seleccionarDia(int $dia)
    {
        $this->diaSeleccionado = Carbon::create(
            $this->anioActual,
            $this->mesActual,
            $dia
        )->format('Y-m-d');
    }

    #[Computed]
    public function datosCalendario()
    {
        $fecha = Carbon::create(
            $this->anioActual,
            $this->mesActual,
            1
        );

        return [
            'nombreMes'       => ucfirst($fecha->translatedFormat('F Y')),
            'diasEnMes'       => $fecha->daysInMonth,
            'primerDiaSemana' => $fecha->dayOfWeekIso,
        ];
    }

    #[Computed]
    public function agendaPorDia()
    {
        $actividades = Actividad::with([
            'publicacion'
            ])
                ->whereNotNull('publicacion_id')
                ->whereMonth('fecha', $this->mesActual)
                ->whereYear('fecha', $this->anioActual)
                ->whereHas('publicacion')
                ->orderBy('fecha')
                ->orderBy('hora')
                ->get();

        $agenda = [];

        $inicioMes = Carbon::create(
            $this->anioActual,
            $this->mesActual,
            1
        );

        $finMes = $inicioMes->copy()->endOfMonth();

        for ($dia = $inicioMes->copy(); $dia <= $finMes; $dia->addDay()) {
            $agenda[$dia->format('Y-m-d')] = [];
        }

        foreach ($actividades as $actividad) {

            // Ignorar actividades sin publicación
            if (!$actividad->publicacion) {
                continue;
            }

            $fecha = Carbon::parse($actividad->fecha)
                ->format('Y-m-d');

            if (isset($agenda[$fecha])) {
                $agenda[$fecha][] = $actividad;
            }
        }

        return $agenda;
    }

    public function render()
    {
        return view(
            'livewire.admin.festividades.calendario-festividades'
        );
    }
}