<?php

namespace Database\Factories;

use App\Enums\SOSActivity;
use App\Models\Operator;
use App\Models\SOS;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SOSActivity>
 */
class SOSActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(SOSActivity::values()),
            'note' => $this->faker->sentence(),
            'operator_id' => Operator::factory(),
            'sos_id' => SOS::factory(),
        ];
    }
}
