@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>Notification Settings</h1>
		</div>
	</div>

	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"><i class="fas fa-bell mr-2"></i>Configure Notifications</h3>
				</div>
				<form action="{{ route('settings.notification.update') }}" method="POST">
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
							<label for="reminder_days_before">Send Reminders (Days Before)</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-clock"></i></span>
								</div>
								<input type="number" min="1" max="30" class="form-control @error('reminder_days_before') is-invalid @enderror" id="reminder_days_before" name="reminder_days_before" value="{{ old('reminder_days_before', config('services.reminder.days_before', 7)) }}" required>
								@error('reminder_days_before')
									<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
							<small class="form-text text-muted">
								<i class="fas fa-info-circle"></i> Number of days before the service date to send reminders
							</small>
						</div>

						<div class="card card-secondary">
							<div class="card-header">
								<h3 class="card-title">Notification Channels</h3>
							</div>
							<div class="card-body">
								<div class="form-group">
									<div class="custom-control custom-switch custom-switch-lg">
										<input type="checkbox" class="custom-control-input" id="enable_email_notifications" name="enable_email_notifications" value="1" {{ old('enable_email_notifications', config('services.reminder.email_enabled', true)) ? 'checked' : '' }}>
										<label class="custom-control-label" for="enable_email_notifications">
											<i class="fas fa-envelope text-info mr-1"></i> Enable Email Notifications
										</label>
									</div>
								</div>

								<div class="form-group mb-0">
									<div class="custom-control custom-switch custom-switch-lg">
										<input type="checkbox" class="custom-control-input" id="enable_sms_notifications" name="enable_sms_notifications" value="1" {{ old('enable_sms_notifications', config('services.reminder.sms_enabled', true)) ? 'checked' : '' }}>
										<label class="custom-control-label" for="enable_sms_notifications">
											<i class="fas fa-sms text-success mr-1"></i> Enable SMS Notifications
										</label>
									</div>
								</div>
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

@push('styles')
<style>
.custom-switch-lg .custom-control-label {
	padding-top: 0.5rem;
	padding-left: 0.5rem;
	font-size: 1rem;
}
</style>
@endpush

@push('scripts')
<script>
$(function() {
	// Initialize form validation if needed
	$('form').validate();
});
</script>
@endpush