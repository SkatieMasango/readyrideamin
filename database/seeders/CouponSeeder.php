<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->insert([
            [
                'code' => Str::random(10),
                'title' => 'Discount 10%',
                'description' => '10% off on all services',
                'max_users' => 100,
                'max_uses_per_user' => 1,
                'minimum_cost' => 50.00,
                'maximum_cost' => 500.00,
                'start_time' => Carbon::now()->format('H:i:s'),
                'valid_from' => Carbon::now(),
                'expired_time' => Carbon::now()->format('H:i:s'),
                'valid_till' => Carbon::now()->addMonth(),
                'discount_percent' => 10,
                'discount_flat' => 0.00,
                'rider_ids' => json_encode([4, 5]),
                'is_enabled' => true,
                'is_first_travel_only' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => Str::random(10),
                'title' => 'Flat $20 Off',
                'description' => 'Flat $20 off on your first ride',
                'many_users_can_use' => 50,
                'many_times_user_can_use' => 1,
                'minimum_cost' => 100.00,
                'maximum_cost' => 1000.00,
                 'start_time' => Carbon::now()->format('H:i:s'),
                'valid_from' => Carbon::now(),
                'expired_time' => Carbon::now()->format('H:i:s'),
                'valid_till' => Carbon::now()->addMonth(),
                'discount_percent' => 0,
                'discount_flat' => 20.00,
                'rider_ids' => json_encode([5]),
                'is_enabled' => true,
                'is_first_travel_only' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more coupon entries as needed
        ]);
    }
}
