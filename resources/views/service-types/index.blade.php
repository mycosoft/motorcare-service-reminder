@extends('layouts.master')

@section('title', 'Service Types')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Service Types</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Service Types</li>
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
					<a href="{{ route('service-types.create') }}" class="btn btn-primary">
						<i class="fas fa-plus"></i> Add Service Type
					</a>
				</div>
			</div>
			<!-- Search and Filter -->
			<div class="card-body border-bottom">
				<form method="GET" action="{{ route('service-types.index') }}" class="row">
					<div class="col-md-4">
						<input type="text" name="search" class="form-control" placeholder="Search name, description..."
							value="{{ request('search') }}">
					</div>
					<div class="col-md-3">
						<select name="is_active" class="form-control">
							<option value="">All Status</option>
							<option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
							<option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
						<a href="{{ route('service-types.index') }}" class="btn btn-default"><i class="fas fa-times"></i></a>
					</div>
				</form>
			</div>
			<div class="card-body table-responsive p-0">
				<table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Description</th>
							<th>Base Price</th>
							<th>Est. Hours</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($serviceTypes as $serviceType)
							<tr>
								<td>{{ $serviceType->id }}</td>
								<td>{{ $serviceType->name }}</td>
								<td>{{ Str::limit($serviceType->description, 50) }}</td>
								<td>${{ number_format($serviceType->base_price, 2) }}</td>
								<td>{{ $serviceType->estimated_hours }}</td>
								<td>
									<span class="badge badge-{{ $serviceType->is_active ? 'success' : 'danger' }}">
										{{ $serviceType->is_active ? 'Active' : 'Inactive' }}
									</span>
								</td>
								<td>
									<a href="{{ route('service-types.show', $serviceType) }}" class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									<a href="{{ route('service-types.edit', $serviceType) }}" class="btn btn-sm btn-warning">
										<i class="fas fa-edit"></i>
									</a>
									<form action="{{ route('service-types.destroy', $serviceType) }}" method="POST" 
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
								<td colspan="7" class="text-center">No service types found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@if($serviceTypes->hasPages())
				<div class="card-footer clearfix">
					{{ $serviceTypes->links() }}
				</div>
			@endif
		</div>
	</div>
</div>
@endsection