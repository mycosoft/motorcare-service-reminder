@extends('layouts.master')

@section('title', 'Service History')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					Service History - {{ $vehicle->make }} {{ $vehicle->model }} 
					({{ $vehicle->registration_number }})
				</h3>
				<div class="card-tools">
					<a href="{{ route('services.create', ['vehicle_id' => $vehicle->id]) }}" 
						class="btn btn-primary">
						<i class="fas fa-plus"></i> Add Service Record
					</a>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Date</th>
							<th>Service Type</th>
							<th>Mileage</th>
							<th>Cost</th>
							<th>Status</th>
							<th>Next Service</th>
							<th>Notes</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($services as $service)
							<tr>
								<td>{{ $service->service_date->format('Y-m-d') }}</td>
								<td>{{ $service->serviceType->name }}</td>
								<td>{{ number_format($service->mileage_at_service) }} miles</td>
								<td>${{ number_format($service->cost, 2) }}</td>
								<td>
									<span class="badge badge-{{ 
										$service->status === 'completed' ? 'success' : 
										($service->status === 'scheduled' ? 'info' : 
										($service->status === 'in_progress' ? 'warning' : 'danger'))
									}}">
										{{ ucfirst($service->status) }}
									</span>
								</td>
								<td>
									@if($service->next_service_date)
										{{ $service->next_service_date->format('Y-m-d') }}<br>
										<small class="text-muted">
											or at {{ number_format($service->next_service_mileage) }} miles
										</small>
									@else
										N/A
									@endif
								</td>
								<td>{{ Str::limit($service->notes, 30) }}</td>
								<td>
									<a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									@if($service->status !== 'completed')
										<a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">
											<i class="fas fa-edit"></i>
										</a>
									@endif
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center">No service records found.</td>
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