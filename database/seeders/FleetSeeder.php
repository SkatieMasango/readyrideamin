<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FleetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fleets = [
            [
                'name' => 'Fleet A',
                'phone_number' => 1234567890,
                'account_number' => 'ACC123456',
                'mobile_number' => 9876543210,
                'commission_share_percent' => 10,
                'commission_share_flat' => 5.00,
                'address' => '123 Main Street, City, Country',
                'user_name' => 'fleet_admin_a',
                'password' => 'password123',
                'fee_multiplier' => 1.2,
                'exclusivity_areas' => ['area1', 'area2'],
            ],
            [
                'name' => 'Fleet B',
                'phone_number' => 1122334455,
                'account_number' => 'ACC654321',
                'mobile_number' => 5566778899,
                'commission_share_percent' => 15,
                'commission_share_flat' => 7.50,
                'address' => '456 Another Street, City, Country',
                'user_name' => 'fleet_admin_b',
                'password' => 'password456',
                'fee_multiplier' => 1.5,
                'exclusivity_areas' => ['area3', 'area4'],
            ],
        ];

        foreach ($fleets as &$fleet) {
            $fleet['password'] = Hash::make($fleet['password']);
            $fleet['exclusivity_areas'] = json_encode($fleet['exclusivity_areas']);
            $fleet['created_at'] = $fleet['updated_at'] = Carbon::now();
        }

        DB::table('fleets')->insert($fleets);
    }
}
