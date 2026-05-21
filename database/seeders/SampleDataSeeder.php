<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\ServiceType;
use App\Models\Service;
use App\Models\ServiceSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Service Types
        $serviceTypes = [
            ['name' => 'Oil Change', 'description' => 'Regular engine oil change', 'base_price' => 50.00, 'estimated_hours' => 1, 'is_active' => true],
            ['name' => 'Full Service', 'description' => 'Complete vehicle service', 'base_price' => 150.00, 'estimated_hours' => 4, 'is_active' => true],
            ['name' => 'Tire Rotation', 'description' => 'Rotate tires for even wear', 'base_price' => 30.00, 'estimated_hours' => 1, 'is_active' => true],
            ['name' => 'Brake Service', 'description' => 'Brake inspection and repair', 'base_price' => 120.00, 'estimated_hours' => 2, 'is_active' => true],
            ['name' => 'Battery Replacement', 'description' => 'Replace car battery', 'base_price' => 80.00, 'estimated_hours' => 1, 'is_active' => true],
        ];

        foreach ($serviceTypes as $type) {
            ServiceType::firstOrCreate(['name' => $type['name']], $type);
        }

        // Create Customers
        $customers = [
            [
                'name' => 'John Muwonge',
                'email' => 'john.muwonge@example.com',
                'phone' => '+256701234567',
                'address' => '123 Kampala Road',
                'city' => 'Kampala',
                'state' => 'Central',
                'postal_code' => '256',
                'notification_preference_email' => true,
                'notification_preference_sms' => true,
            ],
            [
                'name' => 'Sarah Nansubuga',
                'email' => 'sarah.nansubuga@example.com',
                'phone' => '+256772345678',
                'address' => '456 Entebbe Road',
                'city' => 'Wakiso',
                'state' => 'Central',
                'postal_code' => '256',
                'notification_preference_email' => true,
                'notification_preference_sms' => false,
            ],
        ];

        $createdCustomers = [];
        foreach ($customers as $customer) {
            $createdCustomers[] = Customer::firstOrCreate(['email' => $customer['email']], $customer);
        }

        // Create Vehicles
        $vehicles = [
            [
                'customer_id' => $createdCustomers[0]->id,
                'make' => 'Toyota',
                'model' => 'Corolla',
                'year' => '2020',
                'registration_number' => 'UAA 123A',
                'vin_number' => '1HGBH41JXMN109186',
                'color' => 'Silver',
                'current_mileage' => 45000,
                'last_service_date' => Carbon::now()->subMonths(3),
                'service_interval_months' => 6,
                'service_interval_miles' => 5000,
            ],
            [
                'customer_id' => $createdCustomers[0]->id,
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => '2019',
                'registration_number' => 'UAA 456B',
                'vin_number' => '2HGBH41JXMN109187',
                'color' => 'White',
                'current_mileage' => 62000,
                'last_service_date' => Carbon::now()->subMonths(1),
                'service_interval_months' => 6,
                'service_interval_miles' => 5000,
            ],
            [
                'customer_id' => $createdCustomers[1]->id,
                'make' => 'Nissan',
                'model' => 'Sentra',
                'year' => '2021',
                'registration_number' => 'UBA 789C',
                'vin_number' => '3HGBH41JXMN109188',
                'color' => 'Black',
                'current_mileage' => 30000,
                'last_service_date' => Carbon::now()->subMonths(2),
                'service_interval_months' => 6,
                'service_interval_miles' => 5000,
            ],
        ];

        $createdVehicles = [];
        foreach ($vehicles as $vehicle) {
            $createdVehicles[] = Vehicle::firstOrCreate(
                ['registration_number' => $vehicle['registration_number']],
                $vehicle
            );
        }

        // Create Services (completed)
        $services = [
            [
                'vehicle_id' => $createdVehicles[0]->id,
                'service_type_id' => ServiceType::where('name', 'Oil Change')->first()->id,
                'service_date' => Carbon::now()->subMonths(3),
                'mileage_at_service' => 40000,
                'cost' => 50.00,
                'notes' => 'Regular oil change',
                'status' => 'completed',
                'next_service_date' => Carbon::now()->addMonths(3),
                'next_service_mileage' => 45000,
            ],
            [
                'vehicle_id' => $createdVehicles[0]->id,
                'service_type_id' => ServiceType::where('name', 'Full Service')->first()->id,
                'service_date' => Carbon::now()->subMonths(6),
                'mileage_at_service' => 35000,
                'cost' => 150.00,
                'notes' => 'Annual full service',
                'status' => 'completed',
                'next_service_date' => Carbon::now(),
                'next_service_mileage' => 40000,
            ],
            [
                'vehicle_id' => $createdVehicles[1]->id,
                'service_type_id' => ServiceType::where('name', 'Tire Rotation')->first()->id,
                'service_date' => Carbon::now()->subMonths(1),
                'mileage_at_service' => 60000,
                'cost' => 30.00,
                'notes' => 'Rotated all four tires',
                'status' => 'completed',
                'next_service_date' => Carbon::now()->addMonths(5),
                'next_service_mileage' => 65000,
            ],
            [
                'vehicle_id' => $createdVehicles[2]->id,
                'service_type_id' => ServiceType::where('name', 'Brake Service')->first()->id,
                'service_date' => Carbon::now()->subMonths(2),
                'mileage_at_service' => 28000,
                'cost' => 120.00,
                'notes' => 'Replaced front brake pads',
                'status' => 'completed',
                'next_service_date' => Carbon::now()->addMonths(4),
                'next_service_mileage' => 33000,
            ],
            [
                'vehicle_id' => $createdVehicles[2]->id,
                'service_type_id' => ServiceType::where('name', 'Battery Replacement')->first()->id,
                'service_date' => Carbon::now()->subMonths(4),
                'mileage_at_service' => 25000,
                'cost' => 80.00,
                'notes' => 'Replaced battery',
                'status' => 'completed',
                'next_service_date' => Carbon::now()->addMonths(8),
                'next_service_mileage' => 30000,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                [
                    'vehicle_id' => $service['vehicle_id'],
                    'service_type_id' => $service['service_type_id'],
                    'service_date' => $service['service_date'],
                ],
                $service
            );
        }

        // Create Service Schedules (upcoming)
        $schedules = [
            [
                'vehicle_id' => $createdVehicles[0]->id,
                'service_type_id' => ServiceType::where('name', 'Oil Change')->first()->id,
                'scheduled_date' => Carbon::now()->addDays(7),
                'expected_mileage' => 47500,
                'notes' => 'Scheduled oil change',
                'status' => 'pending',
            ],
            [
                'vehicle_id' => $createdVehicles[1]->id,
                'service_type_id' => ServiceType::where('name', 'Full Service')->first()->id,
                'scheduled_date' => Carbon::now()->addDays(14),
                'expected_mileage' => 65000,
                'notes' => 'Annual full service due',
                'status' => 'pending',
            ],
            [
                'vehicle_id' => $createdVehicles[2]->id,
                'service_type_id' => ServiceType::where('name', 'Tire Rotation')->first()->id,
                'scheduled_date' => Carbon::now()->addDays(21),
                'expected_mileage' => 31500,
                'notes' => 'Tire rotation due',
                'status' => 'pending',
            ],
            [
                'vehicle_id' => $createdVehicles[0]->id,
                'service_type_id' => ServiceType::where('name', 'Brake Service')->first()->id,
                'scheduled_date' => Carbon::now()->addDays(-2), // Overdue
                'expected_mileage' => 47000,
                'notes' => 'Brake inspection overdue',
                'status' => 'pending',
            ],
        ];

        foreach ($schedules as $schedule) {
            ServiceSchedule::firstOrCreate(
                [
                    'vehicle_id' => $schedule['vehicle_id'],
                    'service_type_id' => $schedule['service_type_id'],
                    'scheduled_date' => $schedule['scheduled_date'],
                ],
                $schedule
            );
        }
    }
}