@extends('layouts.master')

@section('title', 'Schedule Service')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Schedule New Service</h3>
			</div>
			<form method="POST" action="{{ route('service-schedules.store') }}">
				@csrf
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="vehicle_id">Vehicle</label>
								<select class="form-control @error('vehicle_id') is-invalid @enderror" 
									id="vehicle_id" name="vehicle_id" required>
									<option value="">Select Vehicle</option>
									@foreach($vehicles as $vehicle)
										<option value="{{ $vehicle->id }}" 
											{{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
											{{ $vehicle->registration_number }} - 
											{{ $vehicle->make }} {{ $vehicle->model }} 
											({{ $vehicle->customer->name }})
										</option>
									@endforeach
								</select>
								@error('vehicle_id')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="service_type_id">Service Type</label>
								<select class="form-control @error('service_type_id') is-invalid @enderror" 
									id="service_type_id" name="service_type_id" required>
									<option value="">Select Service Type</option>
									@foreach($serviceTypes as $type)
										<option value="{{ $type->id }}" 
											{{ old('service_type_id') == $type->id ? 'selected' : '' }}>
											{{ $type->name }}
										</option>
									@endforeach
								</select>
								@error('service_type_id')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="scheduled_date">Scheduled Date</label>
								<input type="date" class="form-control @error('scheduled_date') is-invalid @enderror" 
									id="scheduled_date" name="scheduled_date" 
									value="{{ old('scheduled_date', date('Y-m-d', strtotime('+1 day'))) }}" required>
								@error('scheduled_date')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="expected_mileage">Expected Mileage</label>
								<input type="number" class="form-control @error('expected_mileage') is-invalid @enderror" 
									id="expected_mileage" name="expected_mileage" value="{{ old('expected_mileage') }}">
								@error('expected_mileage')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="notes">Notes</label>
								<textarea class="form-control @error('notes') is-invalid @enderror" 
									id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
								@error('notes')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Schedule Service</button>
					<a href="{{ route('service-schedules.index') }}" class="btn btn-default float-right">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection