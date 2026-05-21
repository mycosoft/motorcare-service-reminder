@extends('layouts.master')

@section('title', 'Service Schedules')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Service Schedules</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Schedules</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<div class="card-tools">
					<a href="{{ route('service-schedules.create') }}" class="btn btn-primary">
						<i class="fas fa-plus"></i> Schedule New Service
					</a>
				</div>
			</div>
			<!-- Search and Filter -->
			<div class="card-body border-bottom">
				<form method="GET" action="{{ route('service-schedules.index') }}" class="row">
					<div class="col-md-3">
						<input type="text" name="search" class="form-control" placeholder="Search vehicle, service type..."
							value="{{ request('search') }}">
					</div>
					<div class="col-md-2">
						<select name="status" class="form-control">
							<option value="">All Statuses</option>
							<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
							<option value="notified" {{ request('status') == 'notified' ? 'selected' : '' }}>Notified</option>
							<option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
							<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div class="col-md-2">
						<input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
					</div>
					<div class="col-md-2">
						<input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
						<a href="{{ route('service-schedules.index') }}" class="btn btn-default"><i class="fas fa-times"></i></a>
					</div>
				</form>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Date</th>
							<th>Customer</th>
							<th>Vehicle</th>
							<th>Service Type</th>
							<th>Expected Mileage</th>
							<th>Status</th>
							<th>Last Notification</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($schedules as $schedule)
							<tr>
								<td>{{ $schedule->scheduled_date->format('Y-m-d') }}</td>
								<td>
									<a href="{{ route('customers.show', $schedule->vehicle->customer) }}">
										{{ $schedule->vehicle->customer->name }}
									</a>
								</td>
								<td>
									<a href="{{ route('vehicles.show', $schedule->vehicle) }}">
										{{ $schedule->vehicle->registration_number }}
									</a>
								</td>
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
								<td class="text-nowrap">
									<a href="{{ route('service-schedules.show', $schedule) }}" class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									<a href="{{ route('service-schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
										<i class="fas fa-edit"></i>
									</a>
									@if(!$schedule->last_notification_sent || $schedule->last_notification_sent->diffInDays(now()) > 7)
										<form action="{{ route('service-schedules.send-reminder', $schedule) }}" method="POST" class="d-inline">
											@csrf
											<button type="submit" class="btn btn-sm btn-success">
												<i class="fas fa-bell"></i>
											</button>
										</form>
									@endif
									<form action="{{ route('service-schedules.destroy', $schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger">
											<i class="fas fa-trash"></i>
										</button>
									</form>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No scheduled services found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@if($schedules->hasPages())
				<div class="card-footer clearfix">
					{{ $schedules->links() }}
				</div>
			@endif
		</div>
	</div>
</div>
@endsection
