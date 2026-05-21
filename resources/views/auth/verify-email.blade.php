<x-app-layout>
	<div class="login-box">
		<div class="login-logo">
			<a href="{{ url('/') }}"><b>Motor</b>Care</a>
		</div>
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Verify Your Email Address</p>

				@if (session('status') == 'verification-link-sent')
					<div class="alert alert-success" role="alert">
						A new verification link has been sent to your email address.
					</div>
				@endif

				<p class="text-center mb-3">
					Before proceeding, please check your email for a verification link.
					If you did not receive the email,
				</p>

				<form method="POST" action="{{ route('verification.send') }}">
					@csrf
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">
								Resend Verification Email
							</button>
						</div>
					</div>
				</form>

				<p class="mt-3 mb-1">
					<a href="{{ route('login') }}">Back to login</a>
				</p>
			</div>
		</div>
	</div>
</x-app-layout>