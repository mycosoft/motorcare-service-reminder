<!-- Dashboard -->
<li class="nav-item">
	<a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
		<i class="nav-icon fas fa-tachometer-alt"></i>
		<p>Dashboard</p>
	</a>
</li>

<!-- MAIN OPERATIONS -->
<li class="nav-header">MAIN OPERATIONS</li>

<!-- Customers -->
<li class="nav-item">
	<a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-users"></i>
		<p>Customers</p>
	</a>
</li>

<!-- Vehicles -->
<li class="nav-item">
	<a href="{{ route('vehicles.index') }}" class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-car"></i>
		<p>Vehicles</p>
	</a>
</li>

<!-- SERVICE MANAGEMENT -->
<li class="nav-header">SERVICE MANAGEMENT</li>

<!-- Services -->
<li class="nav-item {{ request()->routeIs('services.*') || request()->routeIs('service-types.*') ? 'menu-open' : '' }}">
	<a href="#" class="nav-link {{ request()->routeIs('services.*') || request()->routeIs('service-types.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-tools"></i>
		<p>
			Services
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{ route('services.index') }}" class="nav-link {{ request()->routeIs('services.index') ? 'active' : '' }}">
				<i class="far fa-circle nav-icon"></i>
				<p>Service Records</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('service-types.index') }}" class="nav-link {{ request()->routeIs('service-types.*') ? 'active' : '' }}">
				<i class="far fa-circle nav-icon"></i>
				<p>Service Types</p>
			</a>
		</li>
	</ul>
</li>

<!-- Schedules -->
<li class="nav-item {{ request()->routeIs('service-schedules.*') ? 'menu-open' : '' }}">
	<a href="#" class="nav-link {{ request()->routeIs('service-schedules.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-calendar-alt"></i>
		<p>
			Schedules
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{ route('service-schedules.index') }}" class="nav-link {{ request()->routeIs('service-schedules.index') ? 'active' : '' }}">
				<i class="far fa-circle nav-icon"></i>
				<p>All Schedules</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('service-schedules.upcoming-reminders') }}" class="nav-link {{ request()->routeIs('service-schedules.upcoming-reminders') ? 'active' : '' }}">
				<i class="far fa-circle nav-icon"></i>
				<p>Upcoming Reminders</p>
			</a>
		</li>
	</ul>
</li>

@if(auth()->user()->isAdmin())
<!-- ADMINISTRATION -->
<li class="nav-header">ADMINISTRATION</li>

<!-- System Settings -->
<li class="nav-item {{ request()->routeIs('settings.*') ? 'menu-open' : '' }}">
	<a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-cog"></i>
		<p>
			System Settings
			<i class="right fas fa-angle-left"></i>
		</p>
	</a>
	<ul class="nav nav-treeview">
		<li class="nav-item">
			<a href="{{ route('settings.email') }}" class="nav-link {{ request()->routeIs('settings.email') ? 'active' : '' }}">
				<i class="far fa-envelope nav-icon"></i>
				<p>Email Settings</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('settings.sms') }}" class="nav-link {{ request()->routeIs('settings.sms') ? 'active' : '' }}">
				<i class="far fa-comment-alt nav-icon"></i>
				<p>SMS Settings</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('settings.notification') }}" class="nav-link {{ request()->routeIs('settings.notification') ? 'active' : '' }}">
				<i class="far fa-bell nav-icon"></i>
				<p>Notification Settings</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{ route('settings.general') }}" class="nav-link {{ request()->routeIs('settings.general') ? 'active' : '' }}">
				<i class="fas fa-sliders-h nav-icon"></i>
				<p>General Settings</p>
			</a>
		</li>
	</ul>
</li>

<!-- User Management -->
<li class="nav-item">
	<a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-users-cog"></i>
		<p>User Management</p>
	</a>
</li>

<!-- Roles -->
<li class="nav-item">
	<a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-user-shield"></i>
		<p>Roles</p>
	</a>
</li>

<!-- Permissions -->
<li class="nav-item">
	<a href="{{ route('permissions.index') }}" class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-key"></i>
		<p>Permissions</p>
	</a>
</li>
@endif

<!-- USER ACCOUNT -->
<li class="nav-header">ACCOUNT MANAGEMENT</li>
<li class="nav-item">
	<a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-user"></i>
		<p>Profile</p>
	</a>
</li>
<li class="nav-item">
	<a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
		<i class="nav-icon fas fa-sign-out-alt"></i>
		<p>Logout</p>
	</a>
	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		@csrf
	</form>
</li>
