<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
	public function index(Request $request)
	{
		$query = Vehicle::with('customer');

		if ($request->has('search') && $request->search) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->where('make', 'like', "%{$search}%")
				  ->orWhere('model', 'like', "%{$search}%")
				  ->orWhere('registration_number', 'like', "%{$search}%")
				  ->orWhere('vin_number', 'like', "%{$search}%");
			});
		}

		if ($request->has('customer_id') && $request->customer_id) {
			$query->where('customer_id', $request->customer_id);
		}

		$vehicles = $query->latest()->paginate(10)->withQueryString();
		$customers = Customer::all();
		return view('vehicles.index', compact('vehicles', 'customers'));
	}

	public function create()
	{
		$customers = Customer::all();
		return view('vehicles.create', compact('customers'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'customer_id' => 'required|exists:customers,id',
			'make' => 'required|string|max:255',
			'model' => 'required|string|max:255',
			'year' => 'required|string|max:4',
			'registration_number' => 'required|string|unique:vehicles',
			'vin_number' => 'required|string|unique:vehicles',
			'color' => 'nullable|string|max:50',
			'current_mileage' => 'required|integer',
			'service_interval_months' => 'required|integer',
			'service_interval_miles' => 'required|integer'
		]);

		Vehicle::create($validated);

		return redirect()->route('vehicles.index')
			->with('success', 'Vehicle created successfully.');
	}

	public function show(Vehicle $vehicle)
	{
		$vehicle->load(['customer', 'services', 'serviceSchedules']);
		return view('vehicles.show', compact('vehicle'));
	}

	public function edit(Vehicle $vehicle)
	{
		$customers = Customer::all();
		return view('vehicles.edit', compact('vehicle', 'customers'));
	}

	public function update(Request $request, Vehicle $vehicle)
	{
		$validated = $request->validate([
			'customer_id' => 'required|exists:customers,id',
			'make' => 'required|string|max:255',
			'model' => 'required|string|max:255',
			'year' => 'required|string|max:4',
			'registration_number' => 'required|string|unique:vehicles,registration_number,' . $vehicle->id,
			'vin_number' => 'required|string|unique:vehicles,vin_number,' . $vehicle->id,
			'color' => 'nullable|string|max:50',
			'current_mileage' => 'required|integer',
			'service_interval_months' => 'required|integer',
			'service_interval_miles' => 'required|integer'
		]);

		$vehicle->update($validated);

		return redirect()->route('vehicles.index')
			->with('success', 'Vehicle updated successfully.');
	}

	public function destroy(Vehicle $vehicle)
	{
		$vehicle->delete();

		return redirect()->route('vehicles.index')
			->with('success', 'Vehicle deleted successfully.');
	}

	public function serviceHistory(Vehicle $vehicle)
	{
		$services = $vehicle->services()->with('serviceType')->latest()->get();
		return view('vehicles.service-history', compact('vehicle', 'services'));
	}

	public function upcomingServices(Vehicle $vehicle)
	{
		$schedules = $vehicle->serviceSchedules()->with('serviceType')
			->where('status', '!=', 'completed')
			->latest()
			->get();
		return view('vehicles.upcoming-services', compact('vehicle', 'schedules'));
	}
}