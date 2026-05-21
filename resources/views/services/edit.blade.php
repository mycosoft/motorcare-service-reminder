@extends('layouts.master')

@section('title', 'Edit Service Record')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Edit Service Record #{{ $service->id }}</h3>
			</div>
			<form method="POST" action="{{ route('services.update', $service) }}">
				@csrf
				@method('PUT')
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
											{{ old('vehicle_id', $service->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
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
											{{ old('service_type_id', $service->service_type_id) == $type->id ? 'selected' : '' }}
											data-base-price="{{ $type->base_price }}">
											{{ $type->name }} (Base: ${{ number_format($type->base_price, 2) }})
										</option>
									@endforeach
								</select>
								@error('service_type_id')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="service_date">Service Date</label>
								<input type="date" class="form-control @error('service_date') is-invalid @enderror" 
									id="service_date" name="service_date" 
									value="{{ old('service_date', $service->service_date->format('Y-m-d')) }}" required>
								@error('service_date')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="mileage_at_service">Current Mileage</label>
								<input type="number" class="form-control @error('mileage_at_service') is-invalid @enderror" 
									id="mileage_at_service" name="mileage_at_service" 
									value="{{ old('mileage_at_service', $service->mileage_at_service) }}" required>
								@error('mileage_at_service')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="cost">Cost ($)</label>
								<input type="number" step="0.01" class="form-control @error('cost') is-invalid @enderror" 
									id="cost" name="cost" value="{{ old('cost', $service->cost) }}" required>
								@error('cost')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<select class="form-control @error('status') is-invalid @enderror" 
									id="status" name="status" required>
									<option value="scheduled" {{ old('status', $service->status) == 'scheduled' ? 'selected' : '' }}>
										Scheduled
									</option>
									<option value="in_progress" {{ old('status', $service->status) == 'in_progress' ? 'selected' : '' }}>
										In Progress
									</option>
									<option value="completed" {{ old('status', $service->status) == 'completed' ? 'selected' : '' }}>
										Completed
									</option>
									<option value="cancelled" {{ old('status', $service->status) == 'cancelled' ? 'selected' : '' }}>
										Cancelled
									</option>
								</select>
								@error('status')
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
									id="notes" name="notes" rows="3">{{ old('notes', $service->notes) }}</textarea>
								@error('notes')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Update Service Record</button>
					<a href="{{ route('services.index') }}" class="btn btn-default float-right">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>

@push('scripts')
<script>
	document.getElementById('service_type_id').addEventListener('change', function() {
		const selectedOption = this.options[this.selectedIndex];
		const basePrice = selectedOption.getAttribute('data-base-price');
		if (basePrice) {
			document.getElementById('cost').value = basePrice;
		}
	});
</script>
@endpush
@endsection