<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
	public function run(): void
	{
		// Get some existing data
		$customers = Customer::all();
		$vehicles = Vehicle::all();
		$serviceTypes = ServiceType::all();

		if ($customers->isEmpty() || $vehicles->isEmpty() || $serviceTypes->isEmpty()) {
			$this->command->error('Please seed customers, vehicles, and service types first!');
			return;
		}

		// Create services for the last 12 months
		for ($i = 11; $i >= 0; $i--) {
			$month = now()->subMonths($i);
			
			// Random number of services per month (2-8)
			$servicesCount = rand(2, 8);
			
			for ($j = 0; $j < $servicesCount; $j++) {
				Service::create([
					'vehicle_id' => $vehicles->random()->id,
					'service_type_id' => $serviceTypes->random()->id,
					'service_date' => $month->copy()->addDays(rand(1, 28)),
					'mileage_at_service' => rand(1000, 100000),
					'cost' => rand(50, 500),
					'notes' => 'Sample service record',
					'status' => 'completed',
					'next_service_date' => $month->copy()->addMonths(3),
					'next_service_mileage' => rand(5000, 150000),
				]);
			}
		}
	}
}