@extends('layouts.master')

@section('title', 'Add Customer')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Add New Customer</h3>
			</div>
			<form method="POST" action="{{ route('customers.store') }}">
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
								<label for="email">Email</label>
								<input type="email" class="form-control @error('email') is-invalid @enderror" 
									id="email" name="email" value="{{ old('email') }}" required>
								@error('email')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="text" class="form-control @error('phone') is-invalid @enderror" 
									id="phone" name="phone" value="{{ old('phone') }}" required>
								@error('phone')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="address">Address</label>
								<input type="text" class="form-control @error('address') is-invalid @enderror" 
									id="address" name="address" value="{{ old('address') }}">
								@error('address')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="city">City</label>
								<input type="text" class="form-control @error('city') is-invalid @enderror" 
									id="city" name="city" value="{{ old('city') }}">
								@error('city')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="state">State</label>
								<input type="text" class="form-control @error('state') is-invalid @enderror" 
									id="state" name="state" value="{{ old('state') }}">
								@error('state')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="postal_code">Postal Code</label>
								<input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
									id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
								@error('postal_code')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" 
										id="notification_preference_email" name="notification_preference_email" 
										value="1" {{ old('notification_preference_email', true) ? 'checked' : '' }}>
									<label class="custom-control-label" for="notification_preference_email">
										Email Notifications
									</label>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" 
										id="notification_preference_sms" name="notification_preference_sms" 
										value="1" {{ old('notification_preference_sms') ? 'checked' : '' }}>
									<label class="custom-control-label" for="notification_preference_sms">
										SMS Notifications
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Save Customer</button>
					<a href="{{ route('customers.index') }}" class="btn btn-default float-right">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection