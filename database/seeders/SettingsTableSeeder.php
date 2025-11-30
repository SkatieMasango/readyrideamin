<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'key' => 'site_config',
            'value' => json_encode(
                [
                    'site_name' => config('app.name'),
                    'site_title' => config('app.name'),
                    'currency' => '$',
                    'commision' => '5',
                    'currency_position' => 'left',
                    'site_email' => 'support@example.com',
                    'site_phone' => '0123456789',
                    'site_address' => 'Example address',
                    'website_logo' => fake()->imageUrl(),
                    'site_app_logo' => fake()->imageUrl(),
                    'site_favicon' => fake()->imageUrl(),
                    'android_app_link' => fake()->imageUrl(),
                    'ios_app_link' => fake()->imageUrl(),
                ]
            ),
            'is_active' => true,
        ]);
    }
}
