@extends('layouts.master')

@section('title', 'View Permission')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permission Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                    <li class="breadcrumb-item active">{{ $permission->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permission Information</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td><code>{{ $permission->name }}</code></td>
                            </tr>
                            <tr>
                                <th>Group:</th>
                                <td><span class="badge badge-secondary">{{ ucfirst($permission->group) }}</span></td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>{{ $permission->description ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $permission->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated:</th>
                                <td>{{ $permission->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-block">Edit Permission</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Roles with this Permission ({{ $permission->roles->count() }})</h3>
                    </div>
                    <div class="card-body">
                        @if($permission->roles->isEmpty())
                            <p class="text-muted">No roles have this permission.</p>
                        @else
                            <ul class="list-group">
                                @foreach($permission->roles as $role)
                                    <li class="list-group-item">
                                        <a href="{{ route('roles.show', $role) }}">{{ $role->name }}</a>
                                        <span class="text-muted"> - {{ $role->description ?? 'No description' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection