<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_category_id' => null,
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'person_capacity' => $this->faker->randomDigitNotZero(),
            'base_fare' => $this->faker->randomFloat(2, 5, 100),
            'per_hundred_meters' => $this->faker->randomFloat(2, 0.1, 5),
            'per_minute_drive' => $this->faker->randomFloat(2, 0.1, 2),
            'per_minute_wait' => $this->faker->randomFloat(2, 0.1, 2),
            'minimum_fee' => $this->faker->randomFloat(2, 10, 50),
            'two_way_available' => $this->faker->boolean,

        ];
    }
}
