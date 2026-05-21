@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<!-- Profile Information -->
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Profile Information</h3>
				</div>
				<form method="POST" action="{{ route('profile.update') }}">
					@csrf
					@method('patch')
					<div class="card-body">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror" 
								id="name" name="name" value="{{ old('name', $user->name) }}" required>
							@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control @error('email') is-invalid @enderror" 
								id="email" name="email" value="{{ old('email', $user->email) }}" required>
							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary">Update Profile</button>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-6">
			<!-- Update Password -->
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Update Password</h3>
				</div>
				<form method="POST" action="{{ route('profile.password') }}">
					@csrf
					@method('put')
					<div class="card-body">
						<div class="form-group">
							<label for="current_password">Current Password</label>
							<input type="password" class="form-control @error('current_password') is-invalid @enderror" 
								id="current_password" name="current_password" required>
							@error('current_password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="password">New Password</label>
							<input type="password" class="form-control @error('password') is-invalid @enderror" 
								id="password" name="password" required>
							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="password_confirmation">Confirm Password</label>
							<input type="password" class="form-control" 
								id="password_confirmation" name="password_confirmation" required>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-info">Update Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@if(session('success'))
	@push('scripts')
	<script>
		$(document).ready(function() {
			toastr.success('{{ session('success') }}');
		});
	</script>
	@endpush
@endif
@endsection