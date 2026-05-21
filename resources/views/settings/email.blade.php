@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>Email Settings</h1>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"><i class="fas fa-envelope mr-2"></i>Configure Email</h3>
				</div>
				<form action="{{ route('settings.email.update') }}" method="POST">
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
							<label for="smtp_host">SMTP Host</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-server"></i></span>
								</div>
								<input type="text" class="form-control @error('smtp_host') is-invalid @enderror" id="smtp_host" name="smtp_host" value="{{ old('smtp_host', config('mail.mailers.smtp.host')) }}" placeholder="e.g., smtp.gmail.com" required>
								@error('smtp_host')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="smtp_port">SMTP Port</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-plug"></i></span>
								</div>
								<input type="number" class="form-control @error('smtp_port') is-invalid @enderror" id="smtp_port" name="smtp_port" value="{{ old('smtp_port', config('mail.mailers.smtp.port')) }}" placeholder="e.g., 587" required>
								@error('smtp_port')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="smtp_username">SMTP Username</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" class="form-control @error('smtp_username') is-invalid @enderror" id="smtp_username" name="smtp_username" value="{{ old('smtp_username', config('mail.mailers.smtp.username')) }}" required>
								@error('smtp_username')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="smtp_password">SMTP Password</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-lock"></i></span>
								</div>
								<input type="password" class="form-control @error('smtp_password') is-invalid @enderror" id="smtp_password" name="smtp_password" required>
								@error('smtp_password')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="mail_from_address">From Address</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-at"></i></span>
								</div>
								<input type="email" class="form-control @error('mail_from_address') is-invalid @enderror" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', config('mail.from.address')) }}" required>
								@error('mail_from_address')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="mail_from_name">From Name</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-signature"></i></span>
								</div>
								<input type="text" class="form-control @error('mail_from_name') is-invalid @enderror" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', config('mail.from.name')) }}" required>
								@error('mail_from_name')
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
	</div>
</div>
@endsection

@push('scripts')
<script>
$(function() {
	// Initialize form validation if needed
	$('form').validate();
});
</script>
@endpush