<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['regular', 'special'];

        foreach ($categories as $category) {
            ServiceCategory::factory()->create(['name' => $category]);
        }
    }
}
