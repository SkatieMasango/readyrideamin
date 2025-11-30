<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleModels = [
            ['name' => 'Toyota Corolla'],
            ['name' => 'Honda Civic'],
            ['name' => 'Ford Mustang'],
            ['name' => 'Chevrolet Camaro'],
            ['name' => 'Tesla Model S'],
        ];

        foreach ($vehicleModels as &$model) {
            $model['created_at'] = $model['updated_at'] = Carbon::now();
        }

        DB::table('vehicle_models')->insert($vehicleModels);
    }
}
