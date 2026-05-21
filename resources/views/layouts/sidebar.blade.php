<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="{{ route('dashboard') }}" class="brand-link">
		<span class="brand-text font-weight-light"><b>Motorcare Uganda</b></span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				@include('layouts.sidebar-menu')
			</ul>
		</nav>
	</div>
</aside>
