@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>General Settings</h1>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"><i class="fas fa-cog mr-2"></i>Company Information</h3>
		</div>
		<form action="{{ route('settings.general.update') }}" method="POST">
			@csrf
			<div class="card-body">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class="icon fas fa-check"></i> Success!</h5>
						{{ session('success') }}
					</div>
				@endif

				<div class="form-group">
					<label for="company_name">Company Name</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-building"></i></span>
						</div>
						<input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', config('company.name')) }}" required>
						@error('company_name')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="form-group">
					<label for="company_address">Company Address</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
						</div>
						<textarea class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" rows="3" required>{{ old('company_address', config('company.address')) }}</textarea>
						@error('company_address')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="form-group">
					<label for="company_phone">Company Phone</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-phone"></i></span>
						</div>
						<input type="text" class="form-control @error('company_phone') is-invalid @enderror" id="company_phone" name="company_phone" value="{{ old('company_phone', config('company.phone')) }}" required>
						@error('company_phone')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="form-group">
					<label for="company_email">Company Email</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-envelope"></i></span>
						</div>
						<input type="email" class="form-control @error('company_email') is-invalid @enderror" id="company_email" name="company_email" value="{{ old('company_email', config('company.email')) }}" required>
						@error('company_email')
							<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">
					<i class="fas fa-save mr-1"></i> Save Changes
				</button>
			</div>
		</form>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
	$('form').validate();
});
</script>
@endpush