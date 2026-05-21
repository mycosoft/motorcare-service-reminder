@extends('layouts.master')

@section('title', 'Customers')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Customers</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Customers</li>
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
					<button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#importModal">
						<i class="fas fa-file-import"></i> Import Customers
					</button>
					<a href="{{ route('customers.create') }}" class="btn btn-primary">
						<i class="fas fa-plus"></i> Add Customer
					</a>
				</div>
			</div>
			<!-- Search and Filter -->
			<div class="card-body border-bottom">
				<form method="GET" action="{{ route('customers.index') }}" class="row">
					<div class="col-md-4">
						<div class="input-group">
							<input type="text" name="search" class="form-control" placeholder="Search by name, email, phone..."
								value="{{ request('search') }}">
						</div>
					</div>
					<div class="col-md-3">
						<select name="city" class="form-control">
							<option value="">All Cities</option>
							@foreach($cities as $city)
								<option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary">
							<i class="fas fa-search"></i> Filter
						</button>
						<a href="{{ route('customers.index') }}" class="btn btn-default">
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
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>City</th>
							<th>Vehicles</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse($customers as $customer)
							<tr>
								<td>{{ $customer->id }}</td>
								<td>{{ $customer->name }}</td>
								<td>{{ $customer->email }}</td>
								<td>{{ $customer->phone }}</td>
								<td>{{ $customer->city }}</td>
								<td>{{ $customer->vehicles_count ?? 0 }}</td>
								<td>
									<a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">
										<i class="fas fa-eye"></i>
									</a>
									<a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">
										<i class="fas fa-edit"></i>
									</a>
									<form action="{{ route('customers.destroy', $customer) }}" method="POST" 
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
								<td colspan="7" class="text-center">No customers found.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@if($customers->hasPages())
				<div class="card-footer clearfix">
					{{ $customers->links() }}
				</div>
			@endif
		</div>
	</div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="importModalLabel">Import Customers</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label for="file">Choose CSV/Excel File</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="file" name="file" required accept=".csv,.xlsx">
							<label class="custom-file-label" for="file">Choose file</label>
						</div>
						<small class="form-text text-muted">
							Please upload a CSV or Excel file with the following columns: name, email, phone, address, city, state, postal_code
						</small>
					</div>
					<div class="mt-3">
						<a href="{{ route('customers.template') }}" class="btn btn-sm btn-info">
							<i class="fas fa-download"></i> Download Template
						</a>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Import</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
	// Update custom file input label when file is selected
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass("selected").html(fileName);
	});
});
</script>
@endpush