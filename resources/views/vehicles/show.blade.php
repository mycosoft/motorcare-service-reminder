@extends('layouts.master')

@section('title', 'Vehicle Details')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Vehicle Information</h3>
				<div class="card-tools">
					<a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning btn-sm">
						<i class="fas fa-edit"></i> Edit
					</a>
				</div>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-4">Customer</dt>
					<dd class="col-sm-8">
						<a href="{{ route('customers.show', $vehicle->customer) }}">
							{{ $vehicle->customer->name }}
						</a>
					</dd>
					
					<dt class="col-sm-4">Make/Model</dt>
					<dd class="col-sm-8">{{ $vehicle->make }} {{ $vehicle->model }}</dd>
					
					<dt class="col-sm-4">Year</dt>
					<dd class="col-sm-8">{{ $vehicle->year }}</dd>
					
					<dt class="col-sm-4">Registration</dt>
					<dd class="col-sm-8">{{ $vehicle->registration_number }}</dd>
					
					<dt class="col-sm-4">VIN</dt>
					<dd class="col-sm-8">{{ $vehicle->vin_number }}</dd>
					
					<dt class="col-sm-4">Color</dt>
					<dd class="col-sm-8">{{ $vehicle->color }}</dd>
					
					<dt class="col-sm-4">Current Mileage</dt>
					<dd class="col-sm-8">{{ number_format($vehicle->current_mileage) }} miles</dd>
					
					<dt class="col-sm-4">Service Intervals</dt>
					<dd class="col-sm-8">
						Every {{ $vehicle->service_interval_months }} months or 
						{{ number_format($vehicle->service_interval_miles) }} miles
					</dd>
				</dl>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Service Schedule</h3>
				<div class="card-tools">
					<a href="{{ route('services.create', ['vehicle_id' => $vehicle->id]) }}" 
						class="btn btn-primary btn-sm">
						<i class="fas fa-plus"></i> Schedule Service
					</a>
				</div>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Service Type</th>
								<th>Date</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($vehicle->serviceSchedules->sortBy('scheduled_date')->take(5) as $schedule)
								<tr>
									<td>{{ $schedule->serviceType->name }}</td>
									<td>{{ $schedule->scheduled_date->format('Y-m-d') }}</td>
									<td>
										<span class="badge badge-{{ $schedule->status === 'completed' ? 'success' : 
											($schedule->status === 'pending' ? 'warning' : 'info') }}">
											{{ ucfirst($schedule->status) }}
										</span>
									</td>
									<td>
										<a href="{{ route('service-schedules.show', ['schedule' => $schedule->id]) }}" class="btn btn-sm btn-info">
											<i class="fas fa-eye"></i>
										</a>
									</td>

								</tr>
							@empty
								<tr>
									<td colspan="4" class="text-center">No scheduled services.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				<a href="{{ route('vehicles.service-history', $vehicle) }}" class="btn btn-default btn-sm">
					View Full Service History
				</a>
			</div>
		</div>
	</div>
</div>
@endsection