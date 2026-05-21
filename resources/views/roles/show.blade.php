@extends('layouts.master')

@section('title', 'View Role')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Role Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">{{ $role->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Role Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $role->name }}</td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>{{ $role->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $role->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated:</th>
                                <td>{{ $role->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning btn-block">Edit Role</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permissions ({{ $role->permissions->count() }})</h3>
                    </div>
                    <div class="card-body">
                        @if($role->permissions->isEmpty())
                            <p class="text-muted">No permissions assigned to this role.</p>
                        @else
                            @php
                                $groupedPerms = $role->permissions->groupBy('group');
                            @endphp
                            @foreach($groupedPerms as $group => $perms)
                                <div class="mb-3">
                                    <h6><strong>{{ ucfirst($group) }}</strong></h6>
                                    @foreach($perms as $permission)
                                        <span class="badge badge-primary mr-1">{{ $permission->name }}</span>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection