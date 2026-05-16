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
        User::updateOrCreate(
            ['email' => 'admin@fleetwise.test'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'is_active' => true,
            ]
        );

        // Active Staff
        User::updateOrCreate(
            ['email' => 'staff@fleetwise.test'],
            [
                'name' => 'Active Staff',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'is_active' => true,
            ]
        );

        // Deactivated Staff
        User::updateOrCreate(
            ['email' => 'deactivated@fleetwise.test'],
            [
                'name' => 'Deactivated Staff',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'is_active' => false,
            ]
        );

        // Call the Indian Fleet Seeder
        $this->call(IndianFleetSeeder::class);
    }
}
