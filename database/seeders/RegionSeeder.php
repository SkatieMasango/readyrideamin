<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [
                'name' => 'Dhaka Region',
                'currency' => 'BDT',
                'polygon_coordinates' => json_encode([
                    ['lat' => 23.8103, 'lng' => 90.4125],
                    ['lat' => 23.8150, 'lng' => 90.4200],
                    ['lat' => 23.8050, 'lng' => 90.4050],
                    ['lat' => 23.8103, 'lng' => 90.4125], // Close the polygon
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Chittagong Region',
                'currency' => 'BDT',
                'polygon_coordinates' => json_encode([
                    ['lat' => 22.3475, 'lng' => 91.8123],
                    ['lat' => 22.3500, 'lng' => 91.8200],
                    ['lat' => 22.3400, 'lng' => 91.8100],
                    ['lat' => 22.3475, 'lng' => 91.8123], // Close the polygon
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Sylhet Region',
                'currency' => 'BDT',
                'polygon_coordinates' => json_encode([
                    ['lat' => 24.8949, 'lng' => 91.8687],
                    ['lat' => 24.9000, 'lng' => 91.8800],
                    ['lat' => 24.8900, 'lng' => 91.8600],
                    ['lat' => 24.8949, 'lng' => 91.8687], // Close the polygon
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
