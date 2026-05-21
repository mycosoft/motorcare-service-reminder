@extends('layouts.master')

@section('title', 'Create Role')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Role</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">New Role</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="name">Role Name *</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Permissions</label>
                                @php
                                    $groupedPermissions = $permissions->groupBy('group');
                                @endphp
                                @foreach($groupedPermissions as $group => $perms)
                                    <div class="card mt-2">
                                        <div class="card-header bg-secondary">
                                            <h5 class="mb-0">{{ ucfirst($group) }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($perms as $permission)
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="permissions[]" id="perm_{{ $permission->id }}" value="{{ $permission->id }}" class="form-check-input" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                            <label for="perm_{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($permissions->isEmpty())
                                    <p class="text-muted">No permissions available. <a href="{{ route('permissions.create') }}">Create permissions first</a>.</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Role</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection