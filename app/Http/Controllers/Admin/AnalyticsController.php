<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // 🔒 SECURITY CHECK: Make sure ONLY admins can view this page
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Admins only.');
        }

        // 1. Top KPIs
        $openCasesCount = Ticket::whereIn('status', ['open', 'assigned', 'in_progress'])->count();

        $resolvedTodayCount = Ticket::whereIn('status', ['resolved', 'closed'])
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // SLA Risk (Tickets open and their ETA is within the next 4 hours, or already passed)
        $slaRiskCount = Ticket::whereIn('status', ['open', 'assigned', 'in_progress'])
            ->whereNotNull('eta_timestamp')
            ->where('eta_timestamp', '<', Carbon::now()->addHours(4))
            ->count();

        // 2. Daily Ticket Volume (Last 7 Days)
        $dailyVolumes = [];
        $dayLabels = [];
        
        // Loop backwards from 6 days ago to today
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayLabels[] = $date->shortEnglishDayOfWeek; // e.g., "Mon", "Tue"
            $dailyVolumes[] = Ticket::whereDate('created_at', $date)->count();
        }

        // Calculate heights for the bar chart (percentage of the max day)
        $maxVolume = max($dailyVolumes) ?: 1; // Prevent division by zero
        $volumeHeights = array_map(function($vol) use ($maxVolume) {
            return round(($vol / $maxVolume) * 100);
        }, $dailyVolumes);

        // 3. Top 5 Technician Performance
        $topTechnicians = User::where('role', 'technician')
            ->withCount(['assignedTickets as resolved_count' => function ($query) {
                $query->whereIn('status', ['resolved', 'closed']);
            }])
            ->withCount('assignedTickets as total_count')
            ->get()
            ->map(function ($tech) {
                // Calculate success percentage
                $rate = $tech->total_count > 0 ? round(($tech->resolved_count / $tech->total_count) * 100) : 0;
                $tech->resolution_rate = $rate;
                return $tech;
            })
            ->sortByDesc('resolution_rate')
            ->take(5);

        // Send all this real data to the Blade file!
        return view('admin.analytics', compact(
            'openCasesCount',
            'resolvedTodayCount',
            'slaRiskCount',
            'dailyVolumes',
            'dayLabels',
            'volumeHeights',
            'topTechnicians'
        ));
    }
}