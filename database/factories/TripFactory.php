<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-6 months', 'now');
        $end = (clone $start)->modify('+' . $this->faker->numberBetween(1, 10) . ' hours');
        $status = $this->faker->randomElement(['completed', 'completed', 'ongoing', 'pending']);
        
        return [
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'driver_id' => \App\Models\Driver::factory(),
            'origin' => $this->faker->city(),
            'destination' => $this->faker->city(),
            'start_odometer' => $this->faker->numberBetween(10000, 50000),
            'end_odometer' => $status === 'completed' ? $this->faker->numberBetween(50100, 51000) : null,
            'departure_time' => $start,
            'arrival_time' => $status === 'completed' ? $end : null,
            'distance' => $status === 'completed' ? $this->faker->numberBetween(50, 800) : null,
            'status' => $status,
        ];
    }
}
