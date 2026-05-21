@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>SMS Settings</h1>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"><i class="fas fa-sms mr-2"></i>Configure SMS</h3>
				</div>
				<form action="{{ route('settings.sms.update') }}" method="POST">
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
							<label for="sms_provider">SMS Provider</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-broadcast-tower"></i></span>
								</div>
								<select class="form-control @error('sms_provider') is-invalid @enderror" id="sms_provider" name="sms_provider" required>
									<option value="">Select Provider</option>
									<option value="twilio" {{ old('sms_provider', config('services.sms.provider')) == 'twilio' ? 'selected' : '' }}>Twilio</option>
									<option value="africas_talking" {{ old('sms_provider', config('services.sms.provider')) == 'africas_talking' ? 'selected' : '' }}>Africa's Talking</option>
									<option value="vonage" {{ old('sms_provider', config('services.sms.provider')) == 'vonage' ? 'selected' : '' }}>Vonage (Nexmo)</option>
								</select>
								@error('sms_provider')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="api_key">API Key</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="text" class="form-control @error('api_key') is-invalid @enderror" id="api_key" name="api_key" value="{{ old('api_key', config('services.sms.api_key')) }}" required>
								@error('api_key')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>

						<div class="form-group">
							<label for="sender_id">Sender ID</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-id-card"></i></span>
								</div>
								<input type="text" class="form-control @error('sender_id') is-invalid @enderror" id="sender_id" name="sender_id" value="{{ old('sender_id', config('services.sms.sender_id')) }}" required>
								@error('sender_id')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<small class="form-text text-muted">
								<i class="fas fa-info-circle"></i> This is the name or number that will appear as the sender of the SMS
							</small>
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