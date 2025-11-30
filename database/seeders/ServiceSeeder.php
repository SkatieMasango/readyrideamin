<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceCategory::all()->each(function (ServiceCategory $serviceCategory) {
            Service::factory()->create([
                'service_category_id' => $serviceCategory->id,
            ]);
        });

    }
}
