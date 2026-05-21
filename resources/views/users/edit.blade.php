@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Edit User</h3>
				</div>
				<form method="POST" action="{{ route('users.update', $user) }}">
					@csrf
					@method('PATCH')
					<div class="card-body">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control @error('name') is-invalid @enderror"
								id="name" name="name" value="{{ old('name', $user->name) }}" required>
							@error('name')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" class="form-control @error('email') is-invalid @enderror"
								id="email" name="email" value="{{ old('email', $user->email) }}" required>
							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="role">Role</label>
							<select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
								<option value="">Select Role</option>
								@foreach($roles as $role)
									<option value="{{ $role->id }}" {{ old('role', $user->roles->first()?->id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
								@endforeach
							</select>
							@error('role')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<div class="custom-control custom-switch">
								<input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
									{{ old('is_active', $user->is_active) ? 'checked' : '' }}>
								<label class="custom-control-label" for="is_active">Active</label>
							</div>
						</div>
					</div>

					<div class="card-footer">
						<button type="submit" class="btn btn-primary">Update User</button>
						<a href="{{ route('users.index') }}" class="btn btn-default float-right">Cancel</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection