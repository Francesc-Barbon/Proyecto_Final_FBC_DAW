<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Material;
class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar precio por hora a los usuarios
        User::all()->each(function ($user) {
            $user->hourly_rate = rand(15, 40); // Precio entre 15 y 40 €
            $user->save();
        });

        // Asignar precio por unidad a los materiales
        Material::all()->each(function ($material) {
            $material->unit_price = rand(5, 50); // Precio entre 5 y 50 €
            $material->save();
        });

        $this->command->info('Precios asignados a usuarios y materiales.');
    }
}
