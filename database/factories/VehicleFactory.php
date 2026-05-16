<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_number' => 'V-' . $this->faker->unique()->numberBetween(1000, 9999),
            'vehicle_type' => $this->faker->randomElement(['Truck', 'Van', 'Car', 'Bus']),
            'model' => $this->faker->word() . ' ' . $this->faker->year(),
            'capacity' => $this->faker->numberBetween(1, 20) . ' tons',
            'registration_date' => $this->faker->date(),
            'insurance_expiry' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'maintenance']),
        ];
    }
}
