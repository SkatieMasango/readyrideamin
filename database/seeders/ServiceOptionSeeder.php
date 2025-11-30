<?php

namespace Database\Seeders;

use App\Models\ServiceOption;
use Illuminate\Database\Seeder;

class ServiceOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = ['pet', 'luggage', 'round_trip'];
        foreach ($options as $option) {
            ServiceOption::factory()->create([
                'name' => $option,
                'description' => ucwords(str_replace('_', ' ', $option)),
            ]);
        }
    }
}
