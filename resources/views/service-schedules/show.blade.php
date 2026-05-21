@extends('layouts.master')

@section('title', 'Schedule Details')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Schedule Information</h3>
				<div class="card-tools">
					<a href="{{ route('service-schedules.edit', ['id' => $schedule->id]) }}" class="btn btn-warning btn-sm">
						<i class="fas fa-edit"></i> Edit
					</a>
				</div>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-4">Service Type</dt>
					<dd class="col-sm-8">{{ $schedule->serviceType->name }}</dd>
					
					<dt class="col-sm-4">Scheduled Date</dt>
					<dd class="col-sm-8">{{ $schedule->scheduled_date->format('Y-m-d') }}</dd>
					
					<dt class="col-sm-4">Expected Mileage</dt>
					<dd class="col-sm-8">{{ number_format($schedule->expected_mileage) }} miles</dd>
					
					<dt class="col-sm-4">Status</dt>
					<dd class="col-sm-8">
						<span class="badge badge-{{ $schedule->status === 'confirmed' ? 'success' : ($schedule->status === 'notified' ? 'info' : ($schedule->status === 'pending' ? 'warning' : 'danger')) }}">
							{{ ucfirst($schedule->status) }}
						</span>
					</dd>
					
					<dt class="col-sm-4">Last Notification</dt>
					<dd class="col-sm-8">
						@if($schedule->last_notification_sent)
							{{ $schedule->last_notification_sent->format('Y-m-d H:i') }}<br>
							<small class="text-muted">Attempts: {{ $schedule->notification_attempts }}</small>
						@else
							Not sent yet
						@endif
					</dd>
					
					<dt class="col-sm-4">Notes</dt>
					<dd class="col-sm-8">{{ $schedule->notes ?: 'No notes' }}</dd>
				</dl>

				@if(!$schedule->last_notification_sent || $schedule->last_notification_sent->diffInDays(now()) > 7)
					<form action="{{ route('service-schedules.send-reminder', ['id' => $schedule->id]) }}" method="POST">
						@csrf
						<button type="submit" class="btn btn-success">
							<i class="fas fa-bell"></i> Send Reminder
						</button>
					</form>
				@endif
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
						<a href="{{ route('customers.show', $schedule->vehicle->customer) }}">
							{{ $schedule->vehicle->customer->name }}
						</a>
					</dd>
					
					<dt class="col-sm-4">Vehicle</dt>
					<dd class="col-sm-8">
						<a href="{{ route('vehicles.show', $schedule->vehicle) }}">
							{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }}
						</a>
					</dd>
					
					<dt class="col-sm-4">Registration</dt>
					<dd class="col-sm-8">{{ $schedule->vehicle->registration_number }}</dd>
					
					<dt class="col-sm-4">Current Mileage</dt>
					<dd class="col-sm-8">{{ number_format($schedule->vehicle->current_mileage) }} miles</dd>
					
					<dt class="col-sm-4">Last Service</dt>
					<dd class="col-sm-8">
						@if($schedule->vehicle->last_service_date)
							{{ $schedule->vehicle->last_service_date->format('Y-m-d') }}
						@else
							No previous service
						@endif
					</dd>
				</dl>
			</div>
			<div class="card-footer">
				<a href="{{ route('vehicles.service-history', $schedule->vehicle) }}" class="btn btn-info btn-sm">
					<i class="fas fa-history"></i> View Service History
				</a>
			</div>
		</div>
	</div>
</div>
@endsection

