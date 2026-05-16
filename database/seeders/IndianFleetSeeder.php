<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\Expense;
use App\Models\FuelRecord;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class IndianFleetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Ensure an Admin and Staff user exists
        if (!User::where('email', 'admin@fleetwise.com')->exists()) {
            User::create([
                'name' => 'Aditya Sharma',
                'email' => 'admin@fleetwise.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);
        }

        // Indian Vehicles Data
        $indianVehicles = [
            ['model' => 'Mahindra Scorpio-N', 'type' => 'SUV', 'capacity' => '7 Seater'],
            ['model' => 'Mahindra Bolero Neo', 'type' => 'SUV', 'capacity' => '7 Seater'],
            ['model' => 'Tata Safari', 'type' => 'SUV', 'capacity' => '7 Seater'],
            ['model' => 'Tata Nexon EV', 'type' => 'SUV', 'capacity' => '5 Seater'],
            ['model' => 'Tata Ace Gold (Chota Hathi)', 'type' => 'Mini Truck', 'capacity' => '1.5 Tons'],
            ['model' => 'Ashok Leyland Dost+', 'type' => 'Pickup', 'capacity' => '2 Tons'],
            ['model' => 'Mahindra Thar', 'type' => 'Off-roader', 'capacity' => '4 Seater'],
            ['model' => 'Force Traveller', 'type' => 'Van/Mini Bus', 'capacity' => '12-17 Seater'],
            ['model' => 'Maruti Suzuki Ertiga', 'type' => 'MUV', 'capacity' => '7 Seater'],
            ['model' => 'Eicher Pro 2049', 'type' => 'Truck', 'capacity' => '5 Tons'],
            ['model' => 'BharatBenz 1917R', 'type' => 'Heavy Truck', 'capacity' => '10 Tons'],
            ['model' => 'Toyota Innova Hycross', 'type' => 'MUV', 'capacity' => '8 Seater'],
        ];

        // Indian Cities for Trips
        $indianCities = [
            'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Ahmedabad', 'Chennai', 'Kolkata', 'Pune', 
            'Jaipur', 'Lucknow', 'Kanpur', 'Nagpur', 'Indore', 'Thane', 'Bhopal', 'Visakhapatnam', 
            'Patna', 'Vadodara', 'Ghaziabad', 'Ludhiana', 'Agra', 'Nashik', 'Faridabad', 'Meerut'
        ];

        // Indian Driver Names (Diverse regions)
        $driverNames = [
            'Rajesh Kumar', 'Suresh Yadav', 'Amit Sharma', 'Vikram Singh', 'Deepak Verma', 
            'Sunil Gupta', 'Sanjay Mishra', 'Prakash Iyer', 'Subramaniam V.', 'Arjun Maurya',
            'Manish Tiwari', 'Rahul Deshmukh', 'Pankaj Reddy', 'Karan Gill', 'Harish Nair',
            'Debashis Mondal', 'Gurpreet Singh', 'Prashant Patil', 'Anil Saxena', 'Rohan Mehra'
        ];

        // Vehicle Registration States (Indian Style)
        $states = ['DL', 'MH', 'KA', 'TS', 'GJ', 'TN', 'WB', 'UP', 'RJ', 'MP', 'HR', 'PB', 'AS', 'KL'];

        // 1. Create Vehicles
        $createdVehicles = [];
        foreach ($indianVehicles as $index => $vData) {
            $stateCode = $states[array_rand($states)];
            $districtCode = str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);
            $series = chr(rand(65, 90)) . chr(rand(65, 90));
            $number = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $regNumber = "{$stateCode}-{$districtCode}-{$series}-{$number}";

            // Varied status
            $status = 'active';
            if ($index % 5 == 0) $status = 'maintenance';
            if ($index % 11 == 0) $status = 'inactive';

            $createdVehicles[] = Vehicle::create([
                'vehicle_number' => $regNumber,
                'vehicle_type' => $vData['type'],
                'model' => $vData['model'],
                'capacity' => $vData['capacity'],
                'registration_date' => now()->subYears(rand(1, 5))->subDays(rand(1, 365)),
                'insurance_expiry' => now()->addMonths(rand(-2, 12)), // Some might be expired
                'status' => $status,
            ]);
        }

        // 2. Create Drivers
        $createdDrivers = [];
        foreach ($driverNames as $name) {
            $createdDrivers[] = Driver::create([
                'name' => $name,
                'phone' => '+91 ' . rand(7000000000, 9999999999),
                'license_number' => $states[array_rand($states)] . rand(1000000000000, 9999999999999),
                'license_expiry' => now()->addYears(rand(-1, 5)),
                'address' => $indianCities[array_rand($indianCities)] . ', India',
            ]);
        }

        // Assign drivers to vehicles (70% assignment)
        foreach ($createdDrivers as $index => $driver) {
            if (isset($createdVehicles[$index]) && rand(1, 10) > 3) {
                $driver->update(['vehicle_id' => $createdVehicles[$index]->id]);
            }
        }

        // 3. Generate Historical & Ongoing Data
        $startDate = now()->subMonths(6);

        // Trips (50 Historical + 5 Ongoing)
        for ($i = 0; $i < 55; $i++) {
            $vehicle = $createdVehicles[array_rand($createdVehicles)];
            $driver = $createdDrivers[array_rand($createdDrivers)];
            $origin = $indianCities[array_rand($indianCities)];
            $destination = $indianCities[array_rand($indianCities)];
            while ($origin === $destination) $destination = $indianCities[array_rand($indianCities)];

            $isOngoing = ($i >= 50);
            
            if ($isOngoing) {
                $departure = now()->subHours(rand(1, 12));
                $arrival = null;
                $status = 'ongoing';
            } else {
                $departure = (clone $startDate)->addDays(rand(0, 180))->addHours(rand(0, 23));
                $arrival = (clone $departure)->addHours(rand(4, 48));
                $status = rand(1, 10) > 2 ? 'completed' : 'pending';
                if ($status == 'pending') $arrival = null;
            }
            
            $distance = rand(100, 1500);
            $startOdo = rand(10000, 50000);

            Trip::create([
                'vehicle_id' => $vehicle->id,
                'driver_id' => $driver->id,
                'origin' => $origin,
                'destination' => $destination,
                'start_odometer' => $startOdo,
                'end_odometer' => $status == 'completed' ? $startOdo + $distance : null,
                'departure_time' => $departure,
                'arrival_time' => $arrival,
                'distance' => $status == 'completed' ? $distance : null,
                'status' => $status,
            ]);
        }

        // Expenses (INR Values)
        $expenseCategories = ['Tolls', 'Parking', 'Food/Lodging', 'Fines/Penalties', 'Loading/Unloading'];
        for ($i = 0; $i < 60; $i++) {
            $vehicle = $createdVehicles[array_rand($createdVehicles)];
            $category = $expenseCategories[array_rand($expenseCategories)];
            $amount = match($category) {
                'Tolls' => rand(150, 1200),
                'Parking' => rand(50, 500),
                'Food/Lodging' => rand(300, 2500),
                'Fines/Penalties' => rand(500, 5000),
                'Loading/Unloading' => rand(200, 1500),
                default => rand(100, 1000),
            };

            Expense::create([
                'vehicle_id' => $vehicle->id,
                'amount' => $amount,
                'category' => $category,
                'description' => "Expense in " . $indianCities[array_rand($indianCities)],
                'date' => now()->subDays(rand(0, 180)),
                'status' => rand(1, 10) > 2 ? 'approved' : 'pending',
            ]);
        }

        // Fuel Records
        for ($i = 0; $i < 40; $i++) {
            $vehicle = $createdVehicles[array_rand($createdVehicles)];
            $quantity = rand(20, 100);
            $pricePerLiter = rand(95, 105);
            
            FuelRecord::create([
                'vehicle_id' => $vehicle->id,
                'date' => now()->subDays(rand(0, 180)),
                'quantity' => $quantity,
                'cost' => $quantity * $pricePerLiter,
            ]);
        }

        // Maintenance Records (Past + Future/Pending)
        $maintenanceTasks = ['Oil Change', 'Tyre Rotation', 'Brake Service', 'Engine Tuning', 'Full Service'];
        for ($i = 0; $i < 20; $i++) {
            $vehicle = $createdVehicles[array_rand($createdVehicles)];
            $type = $maintenanceTasks[array_rand($maintenanceTasks)];
            $isFuture = ($i >= 15);
            
            Maintenance::create([
                'vehicle_id' => $vehicle->id,
                'service_date' => $isFuture ? now()->addDays(rand(1, 30)) : now()->subDays(rand(1, 180)),
                'service_type' => $type,
                'description' => $isFuture ? "Scheduled {$type} at service center." : "Completed {$type} at local service center.",
                'cost' => $isFuture ? 0 : rand(2000, 15000),
            ]);
        }
    }
}
