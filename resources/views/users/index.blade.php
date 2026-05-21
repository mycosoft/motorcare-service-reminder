@extends('layouts.master')

@section('content')
<div class="container-fluid">
	<div class="row mb-2">
		<div class="col-sm-6">
			<h1>Users</h1>
		</div>
		<div class="col-sm-6">
			<div class="float-sm-right">
				<a href="{{ route('users.create') }}" class="btn btn-primary">
					<i class="fas fa-plus"></i> Add New User
				</a>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h3 class="card-title">System Users</h3>
		</div>
		<div class="card-body table-responsive p-0">
			<table class="table table-hover text-nowrap">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Roles</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse($users as $user)
						<tr>
							<td>{{ $user->name }}</td>
							<td>{{ $user->email }}</td>
							<td>
								@forelse($user->roles as $role)
									<span class="badge badge-info">{{ $role->name }}</span>
								@empty
									<span class="badge badge-secondary">No Role</span>
								@endforelse
							</td>
							<td>
								<span class="badge badge-{{ $user->is_active ? 'success' : 'warning' }}">
									{{ $user->is_active ? 'Active' : 'Inactive' }}
								</span>
							</td>
							<td>
								<a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">
									<i class="fas fa-edit"></i>
								</a>
								@if($user->id !== auth()->id())
									<form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
											<i class="fas fa-trash"></i>
										</button>
									</form>
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="text-center">No users found.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="card-footer">
			{{ $users->links() }}
		</div>
	</div>
</div>
@endsection