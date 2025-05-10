<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use Faker\Factory as Faker;

class MaterialsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        // Crear materiales de prueba
        Material::create([
            'name' => 'Cemento',
            'description' => 'Cemento de alta calidad',
            'quantity' => 100,
        ]);

        Material::create([
            'name' => 'Ladrillo',
            'description' => 'Ladrillos rojos',
            'quantity' => 200,
        ]);

        // Agregar más materiales si lo necesitas
    }
}
