<?php

namespace App\Http\Controllers;

use App\Models\ServiceSchedule;
use App\Models\Vehicle;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceScheduleController extends Controller
{
	public function index(Request $request)
	{
		$query = ServiceSchedule::with(['vehicle.customer', 'serviceType']);

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
		} else {
			$query->where('status', '!=', 'completed');
		}

		if ($request->has('date_from') && $request->date_from) {
			$query->whereDate('scheduled_date', '>=', $request->date_from);
		}

		if ($request->has('date_to') && $request->date_to) {
			$query->whereDate('scheduled_date', '<=', $request->date_to);
		}

		$schedules = $query->orderBy('scheduled_date')->paginate(10)->withQueryString();
		$serviceTypes = ServiceType::where('is_active', true)->get();
		return view('service-schedules.index', compact('schedules', 'serviceTypes'));
	}

	public function create()
	{
		$vehicles = Vehicle::with('customer')->get();
		$serviceTypes = ServiceType::where('is_active', true)->get();
		return view('service-schedules.create', compact('vehicles', 'serviceTypes'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'vehicle_id' => 'required|exists:vehicles,id',
			'service_type_id' => 'required|exists:service_types,id',
			'scheduled_date' => 'required|date|after:today',
			'expected_mileage' => 'nullable|integer',
			'notes' => 'nullable|string',
			'status' => 'required|in:pending,notified,confirmed,completed,cancelled'
		]);

		ServiceSchedule::create($validated);

		return redirect()->route('service-schedules.index')
			->with('success', 'Service schedule created successfully.');
	}

	public function show($id)
	{
		$schedule = ServiceSchedule::withTrashed()
			->with(['vehicle.customer', 'serviceType'])
			->findOrFail($id);
		return view('service-schedules.show', compact('schedule'));
	}

	public function edit(ServiceSchedule $schedule)
	{
		$vehicles = Vehicle::with('customer')->get();
		$serviceTypes = ServiceType::where('is_active', true)->get();
		return view('service-schedules.edit', compact('schedule', 'vehicles', 'serviceTypes'));
	}

	public function update(Request $request, ServiceSchedule $schedule)
	{
		$validated = $request->validate([
			'vehicle_id' => 'required|exists:vehicles,id',
			'service_type_id' => 'required|exists:service_types,id',
			'scheduled_date' => 'required|date',
			'expected_mileage' => 'nullable|integer',
			'notes' => 'nullable|string',
			'status' => 'required|in:pending,notified,confirmed,completed,cancelled'
		]);

		$schedule->update($validated);

		return redirect()->route('service-schedules.index')
			->with('success', 'Service schedule updated successfully.');
	}

	public function destroy(ServiceSchedule $schedule)
	{
		$schedule->delete();
		return redirect()->route('service-schedules.index')
			->with('success', 'Service schedule deleted successfully.');
	}

	public function sendReminder(ServiceSchedule $schedule)
	{
		// This will be implemented when SMS/Email service is configured
		$schedule->update([
			'last_notification_sent' => now(),
			'notification_attempts' => $schedule->notification_attempts + 1,
			'status' => 'notified'
		]);

		return redirect()->route('service-schedules.show', $schedule)
			->with('success', 'Reminder sent successfully.');
	}

	public function upcomingReminders()
	{
		$schedules = ServiceSchedule::with(['vehicle.customer', 'serviceType'])
			->whereIn('status', ['pending', 'notified'])
			->where('scheduled_date', '<=', Carbon::now()->addDays(7))
			->orderBy('scheduled_date')
			->get();

		return view('service-schedules.upcoming-reminders', compact('schedules'));
	}

	public function overdue()
	{
		$schedules = ServiceSchedule::with(['vehicle.customer', 'serviceType'])
			->whereDate('scheduled_date', '<', now())
			->where('status', 'pending')
			->orderBy('scheduled_date')
			->paginate(10);

		return view('service-schedules.overdue', compact('schedules'));
	}
}