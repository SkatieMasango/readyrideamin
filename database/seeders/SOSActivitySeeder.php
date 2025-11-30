<?php

namespace Database\Seeders;

use App\Models\SOSActivity;
use Illuminate\Database\Seeder;

class SOSActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SOSActivity::factory()->count(10)->create();
    }
}
