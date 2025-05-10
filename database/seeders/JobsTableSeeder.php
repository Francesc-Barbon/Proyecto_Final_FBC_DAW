<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobsTableSeeder extends Seeder
{
    public function run()
    {

            Job::create([
                'user_id' => 1, // El ID del administrador (usuario creado antes)
                'description' => 'Construcción de casa',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'status' => 'En progreso',
            ]);
    }
}
