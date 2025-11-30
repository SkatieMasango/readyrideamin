<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            CurrencyTableSeeder::class,
            // VehicleColorSeeder::class,
            // VehicleModelSeeder::class,
            AnnouncementSeeder::class,
        ]);
        if (app()->isLocal()) {
            $this->seedLocal();
        } else {
            $this->seedProduction();
        }
    }

    private function seedLocal()
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            SettingsTableSeeder::class,
            UsersTableSeeder::class,
            //OrderSeeder::class,
            RegionSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
            ServiceOptionSeeder::class,
            CouponSeeder::class,
            // RiderSeeder::class,
            FleetSeeder::class,
            VehicleColorSeeder::class,
            VehicleModelSeeder::class,
            DriverSeeder::class,
            // SOSSeeder::class,
        ]);

        $this->command->alert('<comment>(:---------------Users Credentials---------------:)</comment>');
        foreach (User::all() as $user) {
            $this->command->info("               Email: {$user->email} | Password: password");
        }
        $this->command->alert('<comment>(:-----------------(:Successfully:)-----------------------:)</comment>');
    }

    private function seedProduction()
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            SettingsTableSeeder::class,
        ]);
        $this->command->alert('<comment>(:-----------------(:Successfully:)-----------------------:)</comment>');
    }
}
