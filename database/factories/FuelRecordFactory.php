<?php

namespace Database\Factories;

use App\Models\FuelRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelRecord>
 */
class FuelRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'quantity' => $this->faker->randomFloat(2, 20, 150),
            'cost' => $this->faker->randomFloat(2, 30, 300),
            'date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}
