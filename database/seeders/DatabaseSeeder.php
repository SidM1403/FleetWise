<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Active Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@fleetwise.test',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'is_active' => true,
        ]);

        // Active Staff
        User::factory()->create([
            'name' => 'Active Staff',
            'email' => 'staff@fleetwise.test',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_active' => true,
        ]);

        // Deactivated Staff (for testing deactivation logic)
        User::factory()->create([
            'name' => 'Deactivated Staff',
            'email' => 'deactivated@fleetwise.test',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'is_active' => false,
        ]);

        // Call the Indian Fleet Seeder
        $this->call(IndianFleetSeeder::class);
    }
}
