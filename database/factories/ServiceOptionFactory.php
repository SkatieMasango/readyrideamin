<?php

namespace Database\Factories;

use App\Enums\ServiceOptionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceOption>
 */
class ServiceOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(ServiceOptionType::values());

        return [
            'name' => null,
            'description' => null,
            'type' => $type,
            'additional_fee' => $type == 'cash' ? $this->faker->randomFloat(2, 1, 50) : 0,
        ];
    }
}
