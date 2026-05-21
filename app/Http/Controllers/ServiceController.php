<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Vehicle;
use App\Models\ServiceType;
use App\Models\ServiceSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceController extends Controller
{
	public function index(Request $request)
	{
		$query = Service::with(['vehicle.customer', 'serviceType']);

		if ($request->has('search') && $request->search) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->whereHas('vehicle', function($vq) use ($search) {
					$vq->where('make', 'like', "%{$search}%")
					   ->orWhere('model', 'like', "%{$search}%")
					   ->orWhere('registration_number', 'like', "%{$search}%");
				})->orWhereHas('serviceType', function($stq) use ($search) {
					$stq->where('name', 'like', "%{$search}%");
				});
			});
		}

		if ($request->has('status') && $request->status) {
			$query->where('status', $request->status);
		}

		if ($request->has('service_type_id') && $request->service_type_id) {
			$query->where('service_type_id', $request->service_type_id);
		}

		if ($request->has('date_from') && $request->date_from) {
			$query->whereDate('service_date', '>=', $request->date_from);
		}

		if ($request->has('date_to') && $request->date_to) {
			$query->whereDate('service_date', '<=', $request->date_to);
		}

		$services = $query->latest()->paginate(10)->withQueryString();
		$serviceTypes = ServiceType::where('is_active', true)->get();
		return view('services.index', compact('services', 'serviceTypes'));
	}

	public function create()
	{
		$vehicles = Vehicle::with('customer')->get();
		$serviceTypes = ServiceType::where('is_active', true)->get();
		return view('services.create', compact('vehicles', 'serviceTypes'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'vehicle_id' => 'required|exists:vehicles,id',
			'service_type_id' => 'required|exists:service_types,id',
			'service_date' => 'required|date',
			'mileage_at_service' => 'required|integer',
			'cost' => 'required|numeric|min:0',
			'notes' => 'nullable|string',
			'status' => 'required|in:scheduled,in_progress,completed,cancelled'
		]);

		$service = Service::create($validated);

		if ($request->status === 'completed') {
			$this->scheduleNextService($service);
		}

		return redirect()->route('services.index')
			->with('success', 'Service record created successfully.');
	}

	public function show(Service $service)
	{
		$service->load(['vehicle.customer', 'serviceType']);
		return view('services.show', compact('service'));
	}

	public function edit(Service $service)
	{
		$vehicles = Vehicle::with('customer')->get();
		$serviceTypes = ServiceType::where('is_active', true)->get();
		return view('services.edit', compact('service', 'vehicles', 'serviceTypes'));
	}

	public function update(Request $request, Service $service)
	{
		$validated = $request->validate([
			'vehicle_id' => 'required|exists:vehicles,id',
			'service_type_id' => 'required|exists:service_types,id',
			'service_date' => 'required|date',
			'mileage_at_service' => 'required|integer',
			'cost' => 'required|numeric|min:0',
			'notes' => 'nullable|string',
			'status' => 'required|in:scheduled,in_progress,completed,cancelled'
		]);

		$oldStatus = $service->status;
		$service->update($validated);

		if ($oldStatus !== 'completed' && $request->status === 'completed') {
			$this->scheduleNextService($service);
		}

		return redirect()->route('services.index')
			->with('success', 'Service record updated successfully.');
	}

	public function destroy(Service $service)
	{
		$service->delete();
		return redirect()->route('services.index')
			->with('success', 'Service record deleted successfully.');
	}

	private function scheduleNextService(Service $service)
	{
		$vehicle = $service->vehicle;
		
		$nextServiceDate = Carbon::parse($service->service_date)
			->addMonths($vehicle->service_interval_months);
		
		$nextServiceMileage = $service->mileage_at_service + $vehicle->service_interval_miles;

		$service->update([
			'next_service_date' => $nextServiceDate,
			'next_service_mileage' => $nextServiceMileage
		]);

		ServiceSchedule::create([
			'vehicle_id' => $vehicle->id,
			'service_type_id' => $service->service_type_id,
			'scheduled_date' => $nextServiceDate,
			'expected_mileage' => $nextServiceMileage,
			'notes' => 'Automatically scheduled based on service intervals',
			'status' => 'pending'
		]);
	}
}