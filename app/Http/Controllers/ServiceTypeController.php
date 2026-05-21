<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
	public function index(Request $request)
	{
		$query = ServiceType::query();

		if ($request->has('search') && $request->search) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
				  ->orWhere('description', 'like', "%{$search}%");
			});
		}

		if ($request->has('is_active') && $request->is_active !== '') {
			$query->where('is_active', $request->is_active);
		}

		$serviceTypes = $query->latest()->paginate(10)->withQueryString();
		return view('service-types.index', compact('serviceTypes'));
	}

	public function create()
	{
		return view('service-types.create');
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'base_price' => 'required|numeric|min:0',
			'estimated_hours' => 'required|integer|min:1',
			'is_active' => 'boolean'
		]);

		ServiceType::create($validated);

		return redirect()->route('service-types.index')
			->with('success', 'Service type created successfully.');
	}

	public function show(ServiceType $serviceType)
	{
		return view('service-types.show', compact('serviceType'));
	}

	public function edit(ServiceType $serviceType)
	{
		return view('service-types.edit', compact('serviceType'));
	}

	public function update(Request $request, ServiceType $serviceType)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'base_price' => 'required|numeric|min:0',
			'estimated_hours' => 'required|integer|min:1',
			'is_active' => 'boolean'
		]);

		$serviceType->update($validated);

		return redirect()->route('service-types.index')
			->with('success', 'Service type updated successfully.');
	}

	public function destroy(ServiceType $serviceType)
	{
		if($serviceType->services()->exists()) {
			return redirect()->route('service-types.index')
				->with('error', 'Cannot delete service type that has associated services.');
		}

		$serviceType->delete();

		return redirect()->route('service-types.index')
			->with('success', 'Service type deleted successfully.');
	}
}