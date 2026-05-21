@extends('layouts.master')

@section('title', 'Service Details')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Service Information</h3>
				<div class="card-tools">
					@if($service->status !== 'completed')
						<a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm">
							<i class="fas fa-edit"></i> Edit
						</a>
					@endif
				</div>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-4">Service ID</dt>
					<dd class="col-sm-8">#{{ $service->id }}</dd>
					
					<dt class="col-sm-4">Service Type</dt>
					<dd class="col-sm-8">{{ $service->serviceType->name }}</dd>
					
					<dt class="col-sm-4">Service Date</dt>
					<dd class="col-sm-8">{{ $service->service_date->format('Y-m-d') }}</dd>
					
					<dt class="col-sm-4">Status</dt>
					<dd class="col-sm-8">
						<span class="badge badge-{{ 
							$service->status === 'completed' ? 'success' : 
							($service->status === 'scheduled' ? 'info' : 
							($service->status === 'in_progress' ? 'warning' : 'danger'))
						}}">
							{{ ucfirst($service->status) }}
						</span>
					</dd>
					
					<dt class="col-sm-4">Cost</dt>
					<dd class="col-sm-8">${{ number_format($service->cost, 2) }}</dd>
					
					<dt class="col-sm-4">Mileage</dt>
					<dd class="col-sm-8">{{ number_format($service->mileage_at_service) }} miles</dd>
					
					@if($service->next_service_date)
						<dt class="col-sm-4">Next Service</dt>
						<dd class="col-sm-8">
							{{ $service->next_service_date->format('Y-m-d') }}<br>
							<small class="text-muted">
								or at {{ number_format($service->next_service_mileage) }} miles
							</small>
						</dd>
					@endif
					
					<dt class="col-sm-4">Notes</dt>
					<dd class="col-sm-8">{{ $service->notes ?: 'No notes' }}</dd>
				</dl>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Vehicle Information</h3>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-4">Customer</dt>
					<dd class="col-sm-8">
						<a href="{{ route('customers.show', $service->vehicle->customer) }}">
							{{ $service->vehicle->customer->name }}
						</a>
					</dd>
					
					<dt class="col-sm-4">Vehicle</dt>
					<dd class="col-sm-8">
						<a href="{{ route('vehicles.show', $service->vehicle) }}">
							{{ $service->vehicle->make }} {{ $service->vehicle->model }}
						</a>
					</dd>
					
					<dt class="col-sm-4">Registration</dt>
					<dd class="col-sm-8">{{ $service->vehicle->registration_number }}</dd>
					
					<dt class="col-sm-4">VIN</dt>
					<dd class="col-sm-8">{{ $service->vehicle->vin_number }}</dd>
					
					<dt class="col-sm-4">Service Interval</dt>
					<dd class="col-sm-8">
						Every {{ $service->vehicle->service_interval_months }} months<br>
						or {{ number_format($service->vehicle->service_interval_miles) }} miles
					</dd>
				</dl>
			</div>
			<div class="card-footer">
				<a href="{{ route('vehicles.service-history', $service->vehicle) }}" class="btn btn-info btn-sm">
					<i class="fas fa-history"></i> View Service History
				</a>
			</div>
		</div>
	</div>
</div>
@endsection