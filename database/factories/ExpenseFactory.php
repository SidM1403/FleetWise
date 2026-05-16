<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
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
            'trip_id' => null,
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'category' => $this->faker->randomElement(['Tolls', 'Parking', 'Food/Lodging', 'Fines/Penalties', 'Miscellaneous']),
            'description' => $this->faker->sentence(),
            'date' => $this->faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}
