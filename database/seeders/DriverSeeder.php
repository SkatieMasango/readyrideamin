<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->locations() as $location) {
            $driver = Driver::factory()->create([
                'current_location' => json_encode($location),
            ]);
            $driver->user->assignRole('driver');
        }

    }

    private function locations(): array
    {
        return [
            [
                'lat' => '23.774928',
                'lng' => '90.365384',
            ],[
                'lat' => '23.771631',
                'lng' => '90.359803',
            ],[
                'lat' => '23.769369',
                'lng' => '90.358580',
            ],[
                'lat' => '23.770040',
                'lng' => '90.360186',
            ],[
                'lat' => '23.773939',
                'lng' => '90.357287',
            ],
        ];
    }

}
