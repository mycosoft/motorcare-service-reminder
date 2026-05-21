@extends('layouts.master')

@section('title', 'Overdue Services')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Overdue Services</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('service-schedules.index') }}">Service Schedules</a></li>
                    <li class="breadcrumb-item active">Overdue</li>
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
                    <div class="card-header bg-danger">
                        <h3 class="card-title">Overdue Service Schedules</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Vehicle</th>
                                    <th>Service Type</th>
                                    <th>Scheduled Date</th>
                                    <th>Days Overdue</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->vehicle->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }} ({{ $schedule->vehicle->registration_number }})</td>
                                        <td>{{ $schedule->serviceType->name }}</td>
                                        <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                        <td><span class="badge badge-danger">{{ $schedule->scheduled_date->diffInDays(now()) }} days</span></td>
                                        <td>
                                            <span class="badge badge-{{ $schedule->status_badge_class }}">
                                                {{ ucfirst($schedule->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('service-schedules.show', $schedule) }}" class="btn btn-xs btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('service-schedules.edit', $schedule) }}" class="btn btn-xs btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('service-schedules.send-reminder', $schedule) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-success">
                                                    <i class="fas fa-bell"></i> Remind
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No overdue services found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $schedules->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection