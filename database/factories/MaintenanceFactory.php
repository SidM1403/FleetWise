<?php

namespace Database\Factories;

use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Maintenance>
 */
class MaintenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceDate = $this->faker->dateTimeBetween('-6 months', 'now');
        $nextServiceDate = (clone $serviceDate)->modify('+' . $this->faker->numberBetween(1, 12) . ' months');
        
        return [
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'service_type' => $this->faker->randomElement(['Oil Change', 'Brake Inspection', 'Tire Rotation', 'Engine Tune-up', 'Battery Replacement']),
            'cost' => $this->faker->randomFloat(2, 50, 1500),
            'description' => $this->faker->sentence(),
            'service_date' => $serviceDate->format('Y-m-d'),
            'next_service_date' => $nextServiceDate->format('Y-m-d'),
        ];
    }
}
