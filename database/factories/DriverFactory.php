<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fleet;
use App\Models\VehicleColor;
use App\Models\VehicleModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicleModels = VehicleModel::pluck('id');
        $vehicleColors = VehicleColor::pluck('id');
        $fleets = Fleet::pluck('id');

        return [
            'user_id' => User::factory()->create([
                'email' => uniqid('driver_').rand(100, 999).'@example.com',
                'status' => $this->faker->randomElement(Status::cases())->value,
            ]),
            'driver_licence' => 'DL-'.rand(10000, 99999),
            'certificate_number' => 'CERT-'.rand(10000, 99999),
            'vehicle_id' => $vehicleModels->random(),
            'vehicle_color_legacy' => 'Black',
            'vehicle_color_id' => $vehicleColors->random(),
            'vehicle_production_year' => rand(2010, 2024),
            'vehicle_plate' => strtoupper(uniqid('PLATE-')),
            'search_distance' => rand(5, 50),
            'status' => ['WaitingDocuments', 'Enabled', 'Disabled'][rand(0, 2)],
            'rating' => rand(1, 5),
            'review_count' => rand(0, 100),
            'account_number' => 'ACCT'.rand(100000, 999999),
            'bank_name' => 'Bank '.rand(1, 5),
            'bank_routing_number' => 'RTN'.rand(100000, 999999),
            'bank_swift' => 'SWIFT'.rand(1000, 9999),
            'notification_player_id' => uniqid('PLAYER_'),
            'soft_rejection_note' => null,
            'preset_avatar_number' => rand(1, 10),
            'fleet_id' => $fleets->random(),
            'driver_status' => ['Online', 'Offline'][rand(0, 1)],
            'radius_in_meter' => rand(1000, 5000),
        ];
    }
}
