<?php

namespace Database\Factories;

use App\Enums\SOSStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SOS>
 */
class SOSFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => SOSStatus::SUBMITTED,
            'location' => [
                'lat' => $this->faker->latitude(),
                'lng' => $this->faker->longitude(),
            ],
            'request_id' => Order::factory(), // TODO Update when create request table Request::factory()
            'submitted_by_rider' => $this->faker->boolean(),
        ];
    }


}
