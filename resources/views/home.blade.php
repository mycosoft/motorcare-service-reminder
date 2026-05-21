@extends('layouts.master')

@section('title', 'Dashboard')

@section('content-header')
<div class="row mb-2 align-items-center">
    <div class="col-sm-6">
        <h2 class="mb-1">Welcome Back, {{ auth()->user()->name }}!</h2>
        <p class="text-muted mb-0">Here's what's happening with your service center today.</p>
    </div>
    <div class="col-sm-6 text-right">
        <span class="text-muted">{{ now()->format('l, F j, Y') }}</span>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalVehicles }}</h3>
                    <p>Registered Vehicles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-car"></i>
                </div>
                <a href="{{ route('vehicles.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $upcomingServices }}</h3>
                    <p>Upcoming Services</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('service-schedules.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $overdueServices }}</h3>
                    <p>Overdue Services</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('service-schedules.overdue') }}" class="small-box-footer">View Overdue <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-1"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 mb-2">
                            <a href="{{ route('customers.create') }}" class="btn btn-block btn-primary">
                                <i class="fas fa-user-plus mr-1"></i> Add Customer
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <a href="{{ route('vehicles.create') }}" class="btn btn-block btn-success">
                                <i class="fas fa-car mr-1"></i> Add Vehicle
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <a href="{{ route('services.create') }}" class="btn btn-block btn-info">
                                <i class="fas fa-tools mr-1"></i> New Service
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <a href="{{ route('service-schedules.create') }}" class="btn btn-block btn-warning">
                                <i class="fas fa-calendar-plus mr-1"></i> Schedule Service
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <a href="{{ route('customers.import') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-file-import mr-1"></i> Import Customers
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 mb-2">
                            <a href="{{ route('service-schedules.upcoming-reminders') }}" class="btn btn-block btn-danger">
                                <i class="fas fa-bell mr-1"></i> Send Reminders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- Overdue Services -->
            @if($overdueSchedules->count() > 0)
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Overdue Services ({{ $overdueSchedules->count() }})
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Service Type</th>
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overdueSchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->vehicle->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }}</td>
                                    <td>{{ $schedule->serviceType->name }}</td>
                                    <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                    <td><span class="badge badge-danger">{{ $schedule->scheduled_date->diffInDays(now()) }} days</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('service-schedules.overdue') }}" class="btn btn-sm btn-danger float-right">View All Overdue</a>
                </div>
            </div>
            @endif

            <!-- Upcoming Services -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar mr-1"></i>
                        Upcoming Service Reminders
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Service Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($upcomingSchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->vehicle->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->vehicle->make }} {{ $schedule->vehicle->model }}</td>
                                    <td>{{ $schedule->serviceType->name }}</td>
                                    <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $schedule->status_badge_class }}">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No upcoming services found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('service-schedules.index') }}" class="btn btn-sm btn-info float-right">View All Schedules</a>
                </div>
            </div>
        </section>

        <!-- right col -->
        <section class="col-lg-5 connectedSortable">
            <!-- Recent Customers -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-1"></i>
                        Recently Added Customers
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="users-list clearfix">
                        @forelse($recentCustomers as $customer)
                            <li>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random" alt="User Image">
                                <a class="users-list-name" href="{{ route('customers.show', $customer) }}">{{ $customer->name }}</a>
                                <span class="users-list-date">{{ $customer->created_at->diffForHumans() }}</span>
                            </li>
                        @empty
                            <li class="text-center p-3">No customers found</li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('customers.index') }}">View All Customers</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Charts row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Monthly Service Trends
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="serviceLineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Service Types Distribution
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="serviceTypePieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .users-list > li {
        width: 25%;
        float: left;
        padding: 10px;
        text-align: center;
    }
    .users-list > li img {
        border-radius: 50%;
        max-width: 100%;
        height: auto;
    }
    .users-list-name {
        font-weight: 600;
        color: #444;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: block;
    }
    .users-list-date {
        color: #999;
        font-size: 12px;
    }
    .small-box.bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function () {
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.card-header',
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    $('.connectedSortable .card-header').css('cursor', 'move');

    var lineChartLabels = {!! json_encode(collect($monthlyServiceTrends)->pluck('month')->toArray()) !!};
    var lineChartData = {!! json_encode(collect($monthlyServiceTrends)->pluck('count')->toArray()) !!};

    const serviceLineChart = new Chart(document.getElementById('serviceLineChart'), {
        type: 'line',
        data: {
            labels: lineChartLabels,
            datasets: [{
                label: 'Number of Services',
                data: lineChartData,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Number of Services'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });

    var pieChartLabels = {!! json_encode(collect($serviceTypeStats)->pluck('name')->toArray()) !!};
    var pieChartData = {!! json_encode(collect($serviceTypeStats)->pluck('count')->toArray()) !!};

    var pieChartCtx = document.getElementById('serviceTypePieChart');
    if (pieChartCtx && pieChartLabels.length > 0) {
        new Chart(pieChartCtx, {
            type: 'pie',
            data: {
                labels: pieChartLabels,
                datasets: [{
                    data: pieChartData,
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
});
</script>
@endpush