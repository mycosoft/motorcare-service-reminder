@extends('layouts.master')

@section('title', 'Services')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Services</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Services</li>
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
					<a href="{{ route('services.create') }}" class="btn btn-primary">
						<i class="fas fa-plus"></i> Add Service Record
					</a>
				</div>
			</div>
			<!-- Search and Filter -->
			<div class="card-body border-bottom">
				<form method="GET" action="{{ route('services.index') }}" class="row">
					<div class="col-md-3">
						<input type="text" name="search" class="form-control" placeholder="Search vehicle, service type..."
							value="{{ request('search') }}">
					</div>
					<div class="col-md-2">
						<select name="status" class="form-control">
							<option value="">All Statuses</option>
							<option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
							<option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
							<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
							<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
						</select>
					</div>
					<div class="col-md-2">
						<select name="service_type_id" class="form-control">
							<option value="">All Types</option>
							@foreach($serviceTypes as $type)
								<option value="{{ $type->id }}" {{ request('service_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-2">
						<input type="date" name="date_from" class="form-control" placeholder="From" value="{{ request('date_from') }}">
					</div>
					<div class="col-md-2">
						<input type="date" name="date_to" class="form-control" placeholder="To" value="{{ request('date_to') }}">
					</div>
					<div class="col-md-1">
						<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
					</div>
					<div class="col-md-1">
						<a href="{{ route('services.index') }}" class="btn btn-default"><i class="fas fa-times"></i></a>
					</div>
				</form>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>ID</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Vehicle</th>
							<th>Service Type</th>
							<th>Cost</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($services as $service)
							<tr>
								<td>{{ $service->id }}</td>
								<td>{{ $service->service_date->format('Y-m-d') }}</td>
								<td>
									<a href="{{ route('customers.show', $service->vehicle->customer) }}">
										{{ $service->vehicle->customer->name }}
									</a>
								</td>
								<td>
									<a href="{{ route('vehicles.show', $service->vehicle) }}">
										{{ $service->vehicle->registration_number }}
									</a>
								</td>
								<td>{{ $service->serviceType->name }}</td>
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
									<a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									@if($service->status !== 'completed')
										<a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">
											<i class="fas fa-edit"></i>
										</a>
										<form action="{{ route('services.destroy', $service) }}" method="POST" 
											  class="d-inline" onsubmit="return confirm('Are you sure?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger">
												<i class="fas fa-trash"></i>
											</button>
										</form>
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
			@if($services->hasPages())
				<div class="card-footer clearfix">
					{{ $services->links() }}
				</div>
			@endif
		</div>
	</div>
</div>
@endsection