<?php

namespace Database\Seeders;

use App\Models\SOS;
use Illuminate\Database\Seeder;

class SOSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SOS::factory(10)->create();
    }
}
