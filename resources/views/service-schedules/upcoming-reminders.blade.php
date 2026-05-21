@extends('layouts.master')

@section('title', 'Upcoming Reminders')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Upcoming Service Reminders</h3>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Due Date</th>
							<th>Customer</th>
							<th>Vehicle</th>
							<th>Service Type</th>
							<th>Status</th>
							<th>Last Notification</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($schedules as $schedule)
							<tr class="{{ $schedule->scheduled_date->isPast() ? 'table-danger' : 
								($schedule->scheduled_date->diffInDays(now()) <= 3 ? 'table-warning' : '') }}">
								<td>
									{{ $schedule->scheduled_date->format('Y-m-d') }}
									<br>
									<small class="text-muted">
										{{ $schedule->scheduled_date->diffForHumans() }}
									</small>
								</td>
								<td>
									<a href="{{ route('customers.show', $schedule->vehicle->customer) }}">
										{{ $schedule->vehicle->customer->name }}
									</a>
									<br>
									<small>
										{{ $schedule->vehicle->customer->phone }}
									</small>
								</td>
								<td>
									<a href="{{ route('vehicles.show', $schedule->vehicle) }}">
										{{ $schedule->vehicle->registration_number }}
									</a>
									<br>
									<small>
										{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }}
									</small>
								</td>
								<td>{{ $schedule->serviceType->name }}</td>
								<td>
									<span class="badge badge-{{ 
										$schedule->status === 'confirmed' ? 'success' : 
										($schedule->status === 'notified' ? 'info' : 'warning')
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
								<td colspan="7" class="text-center">No upcoming reminders found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection