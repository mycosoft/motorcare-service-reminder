<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Motor Care Service') }} - @yield('title')</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
	@stack('styles')
</head>
<body class="hold-transition {{ auth()->check() ? 'sidebar-mini' : 'login-page' }}">
	@auth
		<div class="wrapper">
			<!-- Navbar -->
			@include('layouts.navbar')

			<!-- Main Sidebar Container -->
			@include('layouts.sidebar')

			<!-- Content Wrapper -->
			<div class="content-wrapper">
				<!-- Content Header -->
				<div class="content-header">
					<div class="container-fluid">
						@yield('content-header')
					</div>
				</div>

				<!-- Main content -->
				<div class="content">
					<div class="container-fluid">
						@if(session('success'))
							<div class="alert alert-success alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								{{ session('success') }}
							</div>
						@endif

						@if(session('error'))
							<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								{{ session('error') }}
							</div>
						@endif

						{{ $slot ?? '' }}
						@yield('content')
					</div>
				</div>
			</div>

			<!-- Footer -->
			@include('layouts.footer')
		</div>
	@else
		{{ $slot ?? '' }}
		@yield('content')
	@endauth

	<!-- jQuery -->
	<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- Toastr -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
	<script>
		// Toastr configuration
		toastr.options = {
			"closeButton": true,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"timeOut": "3000"
		};
	</script>
	@stack('scripts')
</body>
</html>
