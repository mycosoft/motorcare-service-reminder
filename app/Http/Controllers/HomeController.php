<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\ServiceSchedule;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get counts for dashboard widgets
        $data = [
            'totalCustomers' => Customer::count(),
            'totalVehicles' => Vehicle::count(),
            'upcomingServices' => ServiceSchedule::whereDate('scheduled_date', '>=', now())->where('status', 'pending')->count(),
            'overdueServices' => ServiceSchedule::whereDate('scheduled_date', '<', now())->where('status', 'pending')->count(),
            'todayServices' => Service::whereDate('created_at', Carbon::today())->count(),

            // Get overdue service schedules
            'overdueSchedules' => ServiceSchedule::with(['vehicle.customer', 'serviceType'])
                ->whereDate('scheduled_date', '<', now())
                ->where('status', 'pending')
                ->orderBy('scheduled_date')
                ->limit(5)
                ->get(),

            // Get upcoming service schedules
            'upcomingSchedules' => ServiceSchedule::with(['vehicle.customer', 'serviceType'])
                ->whereDate('scheduled_date', '>=', now())
                ->where('status', 'pending')
                ->orderBy('scheduled_date')
                ->limit(5)
                ->get(),
            
            // Get recently added customers
            'recentCustomers' => Customer::latest()
                ->limit(8)
                ->get(),

            // Get service statistics for pie chart
            'serviceTypeStats' => ServiceType::withCount('services')
                ->having('services_count', '>', 0)
                ->get()
                ->map(function ($type) {
                    return [
                        'name' => $type->name,
                        'count' => (int) $type->services_count
                    ];
                }),

            // Get monthly service trends for line chart
            'monthlyServiceTrends' => Service::selectRaw("DATE_FORMAT(service_date, '%Y-%m') as month, COUNT(*) as count")
                ->where('service_date', '>=', now()->subMonths(11)->startOfMonth())
                ->where('status', 'completed')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->map(function ($item) {
                    return [
                        'month' => \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                        'count' => (int) $item->count
                    ];
                })
                ->whenEmpty(function () {
                    // Return last 6 months with zero counts if no data
                    $months = [];
                    for ($i = 5; $i >= 0; $i--) {
                        $months[] = [
                            'month' => now()->subMonths($i)->format('M Y'),
                            'count' => 0
                        ];
                    }
                    return collect($months);
                }),

            // Get upcoming vs completed services for this month

            'monthlyServiceStatus' => [
                'upcoming' => ServiceSchedule::whereMonth('scheduled_date', now()->month)
                    ->whereYear('scheduled_date', now()->year)
                    ->count(),
                'completed' => Service::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count()
            ]
        ];

        return view('home', $data);
    }
}
