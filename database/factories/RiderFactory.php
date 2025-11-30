<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rider>
 */
class RiderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'id_number' => 'ID-' . $this->faker->unique()->numerify('#####'),
            'is_resident' => $this->faker->boolean(),
            'current_location' => [
                'lat' => $this->faker->latitude(),
                'lng' => $this->faker->longitude(),
            ],
            'heading' => $this->faker->randomFloat(2, 0, 360),
        ];
    }
}
