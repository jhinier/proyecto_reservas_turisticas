<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPublicacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_publicaciones')->insert([
            ['id' => 1, 'nombre' => 'Festividad', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Sitio Turístico', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Actividad', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}


