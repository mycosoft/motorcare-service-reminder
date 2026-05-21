@extends('layouts.master')

@section('title', 'Add Vehicle')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Add New Vehicle</h3>
			</div>
			<form method="POST" action="{{ route('vehicles.store') }}">
				@csrf
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="customer_id">Customer</label>
								<select class="form-control @error('customer_id') is-invalid @enderror" 
									id="customer_id" name="customer_id" required>
									<option value="">Select Customer</option>
									@foreach($customers as $customer)
										<option value="{{ $customer->id }}" 
											{{ old('customer_id') == $customer->id ? 'selected' : '' }}>
											{{ $customer->name }} ({{ $customer->phone }})
										</option>
									@endforeach
								</select>
								@error('customer_id')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="make">Make</label>
								<input type="text" class="form-control @error('make') is-invalid @enderror" 
									id="make" name="make" value="{{ old('make') }}" required>
								@error('make')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="model">Model</label>
								<input type="text" class="form-control @error('model') is-invalid @enderror" 
									id="model" name="model" value="{{ old('model') }}" required>
								@error('model')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="year">Year</label>
								<input type="text" class="form-control @error('year') is-invalid @enderror" 
									id="year" name="year" value="{{ old('year') }}" required>
								@error('year')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="registration_number">Registration Number</label>
								<input type="text" class="form-control @error('registration_number') is-invalid @enderror" 
									id="registration_number" name="registration_number" value="{{ old('registration_number') }}" required>
								@error('registration_number')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="vin_number">VIN Number</label>
								<input type="text" class="form-control @error('vin_number') is-invalid @enderror" 
									id="vin_number" name="vin_number" value="{{ old('vin_number') }}" required>
								@error('vin_number')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="color">Color</label>
								<input type="text" class="form-control @error('color') is-invalid @enderror" 
									id="color" name="color" value="{{ old('color') }}">
								@error('color')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="current_mileage">Current Mileage</label>
								<input type="number" class="form-control @error('current_mileage') is-invalid @enderror" 
									id="current_mileage" name="current_mileage" value="{{ old('current_mileage', 0) }}" required>
								@error('current_mileage')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="service_interval_months">Service Interval (Months)</label>
								<input type="number" class="form-control @error('service_interval_months') is-invalid @enderror" 
									id="service_interval_months" name="service_interval_months" 
									value="{{ old('service_interval_months', 6) }}" required>
								@error('service_interval_months')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="service_interval_miles">Service Interval (Miles)</label>
								<input type="number" class="form-control @error('service_interval_miles') is-invalid @enderror" 
									id="service_interval_miles" name="service_interval_miles" 
									value="{{ old('service_interval_miles', 5000) }}" required>
								@error('service_interval_miles')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Save Vehicle</button>
					<a href="{{ route('vehicles.index') }}" class="btn btn-default float-right">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection