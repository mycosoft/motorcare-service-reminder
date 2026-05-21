@extends('layouts.master')

@section('title', 'Add Service Type')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Add New Service Type</h3>
			</div>
			<form method="POST" action="{{ route('service-types.store') }}">
				@csrf
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control @error('name') is-invalid @enderror" 
									id="name" name="name" value="{{ old('name') }}" required>
								@error('name')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="description">Description</label>
								<textarea class="form-control @error('description') is-invalid @enderror" 
									id="description" name="description" rows="3">{{ old('description') }}</textarea>
								@error('description')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="base_price">Base Price ($)</label>
								<input type="number" step="0.01" class="form-control @error('base_price') is-invalid @enderror" 
									id="base_price" name="base_price" value="{{ old('base_price', '0.00') }}" required>
								@error('base_price')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="estimated_hours">Estimated Hours</label>
								<input type="number" step="1" class="form-control @error('estimated_hours') is-invalid @enderror" 
									id="estimated_hours" name="estimated_hours" value="{{ old('estimated_hours', 1) }}" required>
								@error('estimated_hours')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" 
										id="is_active" name="is_active" value="1" 
										{{ old('is_active', true) ? 'checked' : '' }}>
									<label class="custom-control-label" for="is_active">Active</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Save Service Type</button>
					<a href="{{ route('service-types.index') }}" class="btn btn-default float-right">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection