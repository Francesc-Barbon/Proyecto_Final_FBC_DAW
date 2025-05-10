<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockMovement;
use Faker\Factory as Faker;
use App\Models\Material;

class StockMovementsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        // Crear movimientos de stock de prueba
        StockMovement::create([
            'material_id' => 1, // ID del material (Cemento)
            'job_id' => 1, // ID del trabajo (Construcción de casa)
            'user_id' => 1, // ID del usuario (Administrador)
            'quantity' => 50,
            'movement_type' => 'IN',
            'date' => now(),
        ]);

        StockMovement::create([
            'material_id' => 2, // ID del material (Ladrillo)
            'job_id' => 1, // ID del trabajo (Construcción de casa)
            'user_id' => 1, // ID del usuario (Administrador)
            'quantity' => 100,
            'movement_type' => 'OUT',
            'date' => now(),
        ]);
    }
}
