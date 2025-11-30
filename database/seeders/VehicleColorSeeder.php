<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleColors = [
            ['name' => 'Black'],
            ['name' => 'White'],
            ['name' => 'Red'],
            ['name' => 'Blue'],
            ['name' => 'Silver'],
            ['name' => 'Gray'],
            ['name' => 'Green'],
            ['name' => 'Yellow'],
        ];

        foreach ($vehicleColors as &$color) {
            $color['created_at'] = $color['updated_at'] = Carbon::now();
        }

        DB::table('vehicle_colors')->insert($vehicleColors);
    }
}
