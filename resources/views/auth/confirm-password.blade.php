<x-app-layout>
	<div class="login-box">
		<div class="login-logo">
			<a href="{{ url('/') }}"><b>Motor</b>Care</a>
		</div>
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">
					This is a secure area of the application. Please confirm your password before continuing.
				</p>

				<form method="POST" action="{{ route('password.confirm') }}">
					@csrf

					<div class="input-group mb-3">
						<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
							placeholder="Password" required autocomplete="current-password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>

					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">
								Confirm Password
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>