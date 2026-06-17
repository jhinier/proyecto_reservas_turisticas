<?php

namespace App\Simulacion\Data;

use App\Models\Servicio;
use App\Models\TipoServicio;
use App\Simulacion\Config\SimulacionConfig; // Importante
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; // Importante para fechas

/**
 * Genera datos de prueba realistas basados en servicios turísticos existentes.
 */
class TestData
{
    private static ?Collection $serviciosCache = null;

    public static function getTodosServicios(): Collection
    {
        if (self::$serviciosCache === null) {
            self::$serviciosCache = Servicio::with(['tipoServicio', 'categoriaPivot.emprendimiento'])
                ->whereNull('deleted_at')
                ->get();
        }
        return self::$serviciosCache;
    }

    public static function getServicioAleatorio(): Servicio
    {
        $servicios = self::getTodosServicios();
        if ($servicios->isEmpty()) {
            throw new \RuntimeException('No hay servicios disponibles en la base de datos para la simulación.');
        }
        return $servicios->random();
    }

    /**
     * ESTRUCTURA DE RESERVA:
     * Estas llaves deben coincidir exactamente con lo que ReservaService espera recibir.
     */
    public static function crearItemReserva(Servicio $servicio, ?int $cantidad = null, ?int $contadorPersonas = 0, ?string $estado = null): array
    {
        $cantidad = $cantidad ?? rand(1, 5);
        $tipo = $servicio->tipoServicio->nombre ?? 'Otro';
        $esHospedaje = stripos($tipo, 'hospedaje') !== false;
        $numeroPersonas = $esHospedaje ? rand(1, 4) : 0;

        $fechaInicio = now()->addDays(rand(1, 30))->format('Y-m-d');
        $duracionDias = ($esHospedaje || stripos($tipo, 'paquete') !== false) ? rand(1, 5) : 1;
        $fechaFin = now()->addDays(rand(1, 30) + $duracionDias - 1)->format('Y-m-d');

        if ($estado === null) {
            $rand = rand(1, 100);
            $acum = 0;
            foreach (SimulacionConfig::PROB_ESTADO_CREACION as $estadoKey => $porc) {
                $acum += $porc;
                if ($rand <= $acum) {
                    $estado = $estadoKey;
                    break;
                }
            }
        }

        return [
            'id'              => $servicio->id,         // <--- LA CLAVE ES 'id'
            'nombre_servicio' => $servicio->nombre,
            'tipo_servicio'   => $tipo,
            'cantidad'        => $cantidad,
            'numero_personas' => $numeroPersonas,
            'fecha_inicio'    => $fechaInicio,
            'fecha_fin'       => $fechaFin,
            'hora'            => rand(8, 20) . ':00:00', // <--- La clave que espera ReservaService
            'precio_unitario' => (float) $servicio->precio,
            'estado'          => $estado,
            'contador_entregas' => 0, 
        ];
    }

    public static function generarItemsAleatorios(int $numItems = null): array
    {
        $num = $numItems ?? rand(1, 5);
        $items = [];
        for ($i = 0; $i < $num; $i++) {
            $servicio = self::getServicioAleatorio();
            $items[] = self::crearItemReserva($servicio);
        }
        return self::agruparItems($items);
    }

    /**
     * Agrupa items duplicados.
     * Importante: Usar 'id' porque es la clave definida en crearItemReserva.
     */
    public static function agruparItems(array $items): array
    {
        $mapa = [];
        foreach ($items as $item) {
            // Unificamos la clave de agrupación
            $clave = $item['id'] . '|' . $item['fecha_inicio'] . '|' . $item['fecha_fin'] . '|' . $item['numero_personas'];
            if (isset($mapa[$clave])) {
                $mapa[$clave]['cantidad'] += $item['cantidad'];
            } else {
                $mapa[$clave] = $item;
            }
        }
        return array_values($mapa);
    }

    // --- MÉTODOS DE ESCENARIOS (Se mantienen igual) ---

    public static function escenarioSoloHospedaje(): array
    {
        $serviciosHospedaje = self::getTodosServicios()->filter(function ($s) {
            return stripos($s->tipoServicio->nombre ?? '', 'hospedaje') !== false;
        });
        if ($serviciosHospedaje->isEmpty()) {
            return self::generarItemsAleatorios(2);
        }
        return [
            self::crearItemReserva($serviciosHospedaje->random(), rand(1, 2))
        ];
    }

    public static function escenarioPaqueteTuristico(): array
    {
        $serviciosPaquete = self::getTodosServicios()->filter(function ($s) {
            return stripos($s->tipoServicio->nombre ?? '', 'paquete') !== false;
        });
        if ($serviciosPaquete->isEmpty()) {
            return self::generarItemsAleatorios(1);
        }
        return [
            self::crearItemReserva($serviciosPaquete->random(), 1)
        ];
    }

    public static function escenarioMixto(): array
    {
        return self::generarItemsAleatorios(rand(2, 4));
    }

    public static function getRandomScenario(): array
    {
        $scenarios = [
            'soloHospedaje' => self::escenarioSoloHospedaje(),
            'paqueteTuristico' => self::escenarioPaqueteTuristico(),
            'mixto' => self::escenarioMixto(),
            'aleatorio' => self::generarItemsAleatorios()
        ];
        return $scenarios[array_rand($scenarios)];
    }
}