<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use Illuminate\Support\Facades\Log;

class CancelarReservasExpiradas extends Command
{
    // Este es el nombre que usarás en la terminal para llamarlo
    protected $signature = 'reservas:cancelar-expiradas';

    protected $description = 'Cancela automáticamente reservas pendientes después de 24 horas';

    public function handle()
    {
        // Buscamos las reservas pendientes creadas hace más de 24h
        $reservas = Reserva::where('estado', Reserva::ESTADO_PENDIENTE)
                           ->where('created_at', '<', now()->subHours(24))
                           ->get();

        $count = $reservas->count();

        foreach ($reservas as $reserva) {
            $reserva->update([
                'estado' => Reserva::ESTADO_CANCELADA,
                'motivo_cancelacion' => 'Expiró tiempo de pago (24h)',
                'cancelada_en' => now(),
                'cancelada_por_rol' => 'Sistema'
            ]);
        }

        $this->info("Se han cancelado {$count} reservas expiradas correctamente.");
    }
}