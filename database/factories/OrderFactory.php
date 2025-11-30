<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Driver;
use App\Models\Rider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(OrderStatus::values()),
            // 'created_on' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'distance_best' => $this->faker->numberBetween(1, 500),
            'duration_best' => $this->faker->numberBetween(10, 120), // in minutes
            'wait_minutes' => $this->faker->numberBetween(0, 20),
            'wait_cost' => $this->faker->randomFloat(2, 0, 20),
            // 'ride_options_cost' => $this->faker->randomFloat(2, 0, 50),
            'tax_cost' => $this->faker->randomFloat(2, 0, 15),
            'service_cost' => $this->faker->randomFloat(2, 5, 100),
            'points' => json_encode([
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
            ]),
            'addresses' => json_encode([
                $this->faker->address,
                $this->faker->address,
            ]),
            'expected_timestamp' => $this->faker->dateTimeBetween('now', '+1 week'),
            'driver_last_seen_messages_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'rider_last_seen_messages_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'destination_arrived_to' => $this->faker->numberBetween(0, 1),
            'start_timestamp' => $this->faker->dateTimeBetween('-1 year', '-6 months'),
            'finish_timestamp' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'rider_id' => Rider::factory(), // Create a rider
            'driver_id' => Driver::factory(), // Create a driver
            'cost_after_coupon' => $this->faker->randomFloat(2, 5, 80),
            'payment_mode' => $this->faker->randomElement(['Cash', 'Card', 'Wallet']),
            //            'payment_gateway_id' => PaymentGateway::factory(), // Create a payment gateway
            //            'payment_method_id' => SavedPaymentMethod::factory(), // Create a saved payment method
            'eta_pickup' => $this->faker->dateTimeBetween('-1 hour', 'now'),
            'cost_best' => $this->faker->randomFloat(2, 20, 150),
            'paid_amount' => $this->faker->randomFloat(2, 20, 150),
            'tip_amount' => $this->faker->randomFloat(2, 0, 20),
            'provider_share' => $this->faker->randomFloat(2, 10, 100),
            'currency' => $this->faker->currencyCode,
            'directions' => json_encode([
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
            ]),
            'driver_directions' => json_encode([
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
                ['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude],
            ]),
        ];
    }
}
