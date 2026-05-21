@extends('layouts.master')

@section('title', 'Service Type Details')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Service Type Information</h3>
				<div class="card-tools">
					<a href="{{ route('service-types.edit', $serviceType) }}" class="btn btn-warning btn-sm">
						<i class="fas fa-edit"></i> Edit
					</a>
				</div>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-4">Name</dt>
					<dd class="col-sm-8">{{ $serviceType->name }}</dd>
					
					<dt class="col-sm-4">Description</dt>
					<dd class="col-sm-8">{{ $serviceType->description }}</dd>
					
					<dt class="col-sm-4">Base Price</dt>
					<dd class="col-sm-8">${{ number_format($serviceType->base_price, 2) }}</dd>
					
					<dt class="col-sm-4">Estimated Hours</dt>
					<dd class="col-sm-8">{{ $serviceType->estimated_hours }}</dd>
					
					<dt class="col-sm-4">Status</dt>
					<dd class="col-sm-8">
						<span class="badge badge-{{ $serviceType->is_active ? 'success' : 'danger' }}">
							{{ $serviceType->is_active ? 'Active' : 'Inactive' }}
						</span>
					</dd>
				</dl>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Usage Statistics</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="info-box bg-light">
							<div class="info-box-content">
								<span class="info-box-text">Total Services</span>
								<span class="info-box-number">{{ $serviceType->services->count() }}</span>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="info-box bg-light">
							<div class="info-box-content">
								<span class="info-box-text">Scheduled Services</span>
								<span class="info-box-number">{{ $serviceType->serviceSchedules->count() }}</span>
							</div>
						</div>
					</div>
				</div>
				
				<h5 class="mt-4">Recent Services</h5>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Vehicle</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@forelse($serviceType->services()->latest()->take(5)->get() as $service)
								<tr>
									<td>{{ $service->service_date->format('Y-m-d') }}</td>
									<td>
										<a href="{{ route('vehicles.show', $service->vehicle) }}">
											{{ $service->vehicle->registration_number }}
										</a>
									</td>
									<td>
										<span class="badge badge-{{ $service->status === 'completed' ? 'success' : 'info' }}">
											{{ ucfirst($service->status) }}
										</span>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="3" class="text-center">No services found.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection