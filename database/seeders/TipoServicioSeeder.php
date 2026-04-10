<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoServicio;

class TipoServicioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Guianza'],
            ['nombre' => 'Paquetes Turísticos'],
            ['nombre' => 'Alimentación'],
            ['nombre' => 'Hospedaje'],
            ['nombre' => 'Alquiler de Equipos'],
        ];

        foreach ($tipos as $tipo) {
            // firstOrCreate evita duplicados si corres el comando dos veces
            TipoServicio::firstOrCreate(
                ['nombre' => $tipo['nombre']], 
                $tipo
            );
        }
    }
}