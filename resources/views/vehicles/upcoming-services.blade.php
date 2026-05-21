@extends('layouts.master')

@section('title', 'Upcoming Services')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					Upcoming Services - {{ $vehicle->make }} {{ $vehicle->model }} 
					({{ $vehicle->registration_number }})
				</h3>
				<div class="card-tools">
					<a href="{{ route('services.create', ['vehicle_id' => $vehicle->id]) }}" 
						class="btn btn-primary">
						<i class="fas fa-plus"></i> Schedule Service
					</a>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Date</th>
							<th>Service Type</th>
							<th>Expected Mileage</th>
							<th>Status</th>
							<th>Last Notification</th>
							<th>Notes</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($schedules as $schedule)
							<tr>
								<td>{{ $schedule->scheduled_date->format('Y-m-d') }}</td>
								<td>{{ $schedule->serviceType->name }}</td>
								<td>{{ number_format($schedule->expected_mileage) }} miles</td>
								<td>
									<span class="badge badge-{{ 
										$schedule->status === 'confirmed' ? 'success' : 
										($schedule->status === 'notified' ? 'info' : 
										($schedule->status === 'pending' ? 'warning' : 'danger'))
									}}">
										{{ ucfirst($schedule->status) }}
									</span>
								</td>
								<td>
									@if($schedule->last_notification_sent)
										{{ $schedule->last_notification_sent->format('Y-m-d H:i') }}
										<br>
										<small class="text-muted">
											Attempts: {{ $schedule->notification_attempts }}
										</small>
									@else
										Not sent
									@endif
								</td>
								<td>{{ Str::limit($schedule->notes, 30) }}</td>
								<td>
									<a href="{{ route('service-schedules.show', ['schedule' => $schedule->id]) }}" 
										class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									<a href="{{ route('service-schedules.edit', ['schedule' => $schedule->id]) }}" 
										class="btn btn-sm btn-warning">
										<i class="fas fa-edit"></i>
									</a>
									@if(!$schedule->last_notification_sent || 
										$schedule->last_notification_sent->diffInDays(now()) > 7)
										<form action="{{ route('service-schedules.send-reminder', ['schedule' => $schedule->id]) }}" 
											method="POST" class="d-inline">
											@csrf
											<button type="submit" class="btn btn-sm btn-success">
												<i class="fas fa-bell"></i>
											</button>
										</form>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">No upcoming services scheduled.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			<div class="card-footer">
				<a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-default">
					<i class="fas fa-arrow-left"></i> Back to Vehicle
				</a>
			</div>
		</div>
	</div>
</div>
@endsection