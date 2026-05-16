<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
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
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'license_number' => 'LIC-' . $this->faker->unique()->numberBetween(100000, 999999),
            'license_expiry' => $this->faker->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
            'address' => $this->faker->address(),
            'vehicle_id' => null, // Will be set in seeder
        ];
    }
}
