@extends('layouts.master')

@section('title', 'Vehicles')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Vehicles</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Vehicles</li>
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
					<a href="{{ route('vehicles.create') }}" class="btn btn-primary">
						<i class="fas fa-plus"></i> Add Vehicle
					</a>
				</div>
			</div>
			<!-- Search and Filter -->
			<div class="card-body border-bottom">
				<form method="GET" action="{{ route('vehicles.index') }}" class="row">
					<div class="col-md-4">
						<div class="input-group">
							<input type="text" name="search" class="form-control" placeholder="Search make, model, reg, VIN..."
								value="{{ request('search') }}">
						</div>
					</div>
					<div class="col-md-3">
						<select name="customer_id" class="form-control">
							<option value="">All Customers</option>
							@foreach($customers as $customer)
								<option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary">
							<i class="fas fa-search"></i> Filter
						</button>
						<a href="{{ route('vehicles.index') }}" class="btn btn-default">
							<i class="fas fa-times"></i> Clear
						</a>
					</div>
				</form>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>ID</th>
							<th>Customer</th>
							<th>Make/Model</th>
							<th>Registration</th>
							<th>Last Service</th>
							<th>Next Service</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($vehicles as $vehicle)
							<tr>
								<td>{{ $vehicle->id }}</td>
								<td>
									<a href="{{ route('customers.show', $vehicle->customer) }}">
										{{ $vehicle->customer->name }}
									</a>
								</td>
								<td>{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year }})</td>
								<td>{{ $vehicle->registration_number }}</td>
								<td>{{ $vehicle->last_service_date ? $vehicle->last_service_date->format('Y-m-d') : 'Never' }}</td>
								<td>
									@if($vehicle->services->where('status', 'completed')->first()?->next_service_date)
										{{ $vehicle->services->where('status', 'completed')->first()->next_service_date->format('Y-m-d') }}
									@else
										N/A
									@endif
								</td>
								<td>
									<a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									<a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning">
										<i class="fas fa-edit"></i>
									</a>
									<a href="{{ route('vehicles.service-history', $vehicle) }}" class="btn btn-sm btn-secondary">
										<i class="fas fa-history"></i>
									</a>
									<form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" 
										  class="d-inline" onsubmit="return confirm('Are you sure?');">
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
								<td colspan="7" class="text-center">No vehicles found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@if($vehicles->hasPages())
				<div class="card-footer clearfix">
					{{ $vehicles->links() }}
				</div>
			@endif
		</div>
	</div>
</div>
@endsection