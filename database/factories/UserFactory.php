<?php

namespace Database\Factories;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(Gender::values()),
            'country_iso' => 'BD',
            'address' => 'Street '.rand(1, 100).', City',
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => '+8801'.rand(500000000, 599999999), // Example BD mobile format
            'email_verified_at' => rand(0, 1) ? now() : null,
            'password' => Hash::make('secret'), // Default password
            'otp_verified_at' => rand(0, 1) ? now() : null,
        ];
    }
}
