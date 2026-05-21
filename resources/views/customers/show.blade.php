@extends('layouts.master')

@section('title', 'Customer Details')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Customer Information</h3>
				<div class="card-tools">
					<a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm">
						<i class="fas fa-edit"></i> Edit
					</a>
				</div>
			</div>
			<div class="card-body">
				<dl class="row">
					<dt class="col-sm-4">Name</dt>
					<dd class="col-sm-8">{{ $customer->name }}</dd>
					
					<dt class="col-sm-4">Email</dt>
					<dd class="col-sm-8">{{ $customer->email }}</dd>
					
					<dt class="col-sm-4">Phone</dt>
					<dd class="col-sm-8">{{ $customer->phone }}</dd>
					
					<dt class="col-sm-4">Address</dt>
					<dd class="col-sm-8">{{ $customer->address }}</dd>
					
					<dt class="col-sm-4">City</dt>
					<dd class="col-sm-8">{{ $customer->city }}</dd>
					
					<dt class="col-sm-4">State</dt>
					<dd class="col-sm-8">{{ $customer->state }}</dd>
					
					<dt class="col-sm-4">Postal Code</dt>
					<dd class="col-sm-8">{{ $customer->postal_code }}</dd>
					
					<dt class="col-sm-4">Notifications</dt>
					<dd class="col-sm-8">
						@if($customer->notification_preference_email)
							<span class="badge badge-success">Email</span>
						@endif
						@if($customer->notification_preference_sms)
							<span class="badge badge-info">SMS</span>
						@endif
					</dd>
				</dl>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Vehicles</h3>
				<div class="card-tools">
					<a href="{{ route('vehicles.create', ['customer_id' => $customer->id]) }}" class="btn btn-primary btn-sm">
						<i class="fas fa-plus"></i> Add Vehicle
					</a>
				</div>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Make/Model</th>
								<th>Registration</th>
								<th>Last Service</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($customer->vehicles as $vehicle)
								<tr>
									<td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
									<td>{{ $vehicle->registration_number }}</td>
									<td>{{ $vehicle->last_service_date ? $vehicle->last_service_date->format('Y-m-d') : 'N/A' }}</td>
									<td>
										<a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-info">
											<i class="fas fa-eye"></i>
										</a>
										<a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">
											<i class="fas fa-edit"></i>
										</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="4" class="text-center">No vehicles registered.</td>
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