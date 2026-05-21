@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="login-box">
	<!-- Logo -->
	<div class="login-logo">
		<a href="{{ route('dashboard') }}"><b>Motorcare</b> Uganda</a>
	</div>

	<!-- Card -->
	<div class="card card-outline card-primary">

		<div class="card-body login-card-body">
			<p class="login-box-msg">Welcome Back, Login to continue</p>

			<form action="{{ route('login') }}" method="post">
				@csrf
				
				<div class="input-group mb-3">
					<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
						   placeholder="Email" value="{{ old('email') }}" required autofocus>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>

				<div class="input-group mb-3">
					<input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
						   placeholder="Password" required>
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
					<div class="col-8">
						<div class="icheck-primary">
							<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
							<label for="remember">
								Remember Me
							</label>
						</div>
					</div>
					<div class="col-4">
						<button type="submit" class="btn btn-primary btn-block">Sign In</button>
					</div>
				</div>
			</form>

			@if (Route::has('password.request'))
				<p class="mb-1">
					<a href="{{ route('password.request') }}">I forgot my password</a>
				</p>
			@endif
		</div>
	</div>
</div>
@endsection

@push('css')
<style>
.login-page {
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.login-box {
	margin-top: 10vh;
}
.login-logo a {
	color: white;
}
.card {
	border: none;
	box-shadow: 0 0 15px rgba(0,0,0,0.2);
}
.login-card-body {
	padding: 30px;
}
.btn-primary {
	background-color: #4e73df;
	border-color: #4e73df;
}
.btn-primary:hover {
	background-color: #2e59d9;
	border-color: #2e59d9;
}
.login-box-msg {
	font-size: 1.1rem;
	color: #6c757d;
}
</style>
@endpush