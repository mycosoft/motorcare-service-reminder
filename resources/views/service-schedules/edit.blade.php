@extends('layouts.master')

@section('title', 'Edit Service Schedule')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Edit Service Schedule</h3>
			</div>
			<form method="POST" action="{{ route('service-schedules.update', ['schedule' => $schedule->id]) }}">
				@csrf
				@method('PUT')
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="vehicle_id">Vehicle</label>
								<select name="vehicle_id" id="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror" required>
									<option value="">Select Vehicle</option>
									@foreach($vehicles as $vehicle)
										<option value="{{ $vehicle->id }}" {{ old('vehicle_id', $schedule->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
											{{ $vehicle->registration_number }} - {{ $vehicle->customer->name }}
										</option>
									@endforeach
								</select>
								@error('vehicle_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="service_type_id">Service Type</label>
								<select name="service_type_id" id="service_type_id" class="form-control @error('service_type_id') is-invalid @enderror" required>
									<option value="">Select Service Type</option>
									@foreach($serviceTypes as $type)
										<option value="{{ $type->id }}" {{ old('service_type_id', $schedule->service_type_id) == $type->id ? 'selected' : '' }}>
											{{ $type->name }}
										</option>
									@endforeach
								</select>
								@error('service_type_id')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="scheduled_date">Scheduled Date</label>
								<input type="date" name="scheduled_date" id="scheduled_date" 
									class="form-control @error('scheduled_date') is-invalid @enderror"
									value="{{ old('scheduled_date', $schedule->scheduled_date->format('Y-m-d')) }}" required>
								@error('scheduled_date')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="expected_mileage">Expected Mileage</label>
								<input type="number" name="expected_mileage" id="expected_mileage" 
									class="form-control @error('expected_mileage') is-invalid @enderror"
									value="{{ old('expected_mileage', $schedule->expected_mileage) }}">
								@error('expected_mileage')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
									<option value="pending" {{ old('status', $schedule->status) == 'pending' ? 'selected' : '' }}>Pending</option>
									<option value="notified" {{ old('status', $schedule->status) == 'notified' ? 'selected' : '' }}>Notified</option>
									<option value="confirmed" {{ old('status', $schedule->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
									<option value="completed" {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Completed</option>
									<option value="cancelled" {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
								</select>
								@error('status')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="notes">Notes</label>
								<textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
								@error('notes')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Update Schedule</button>
					<a href="{{ route('service-schedules.index') }}" class="btn btn-default float-right">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection