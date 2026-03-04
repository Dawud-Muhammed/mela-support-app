<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $query = Ticket::with('category');

    // 🔒 SECURE FILTERING BY ROLE (This makes the numbers different for everyone!)
    if ($user->role === 'user') {
        $query->where('user_id', $user->id); // Student sees only theirs
    } elseif ($user->role === 'technician') {
        $query->where('assigned_technician_id', $user->id); // Tech sees only theirs
    }
    // Admin has no filters, sees everything.

    // Fetch the secured list of tickets
    $tickets = $query->latest()->get();

    // 1. 📊 THE 6-STAGE PIPELINE METRICS
    $stats = [
        'total'       => $tickets->count(),
        'open'        => $tickets->where('status', 'open')->count(),
        'assigned'    => $tickets->where('status', 'assigned')->count(),
        'in_progress' => $tickets->where('status', 'in_progress')->count(),
        'resolved'    => $tickets->where('status', 'resolved')->count(),
        'closed'      => $tickets->where('status', 'closed')->count(),
    ];

    // 2. ⏱️ REAL SLA PULSE (Only calculate for active tickets)
    $activeTickets = $tickets->whereIn('status', ['open', 'assigned', 'in_progress']);
    $totalActive = $activeTickets->count();
    
    $overdueCount = $activeTickets->whereNotNull('eta_timestamp')
                                  ->where('eta_timestamp', '<', now())
                                  ->count();
                                  
    $nearingBreach = $activeTickets->whereNotNull('eta_timestamp')
                                   ->where('eta_timestamp', '>', now())
                                   ->where('eta_timestamp', '<', now()->addHours(4))
                                   ->count();

    $slaPercentage = $totalActive > 0 ? round((($totalActive - $overdueCount) / $totalActive) * 100) : 100;

    // 3. 🚨 REAL PRIORITY MIX
    $priorities = [
        'urgent' => $tickets->where('priority', 'urgent')->count(),
        'high'   => $tickets->where('priority', 'high')->count(),
        'medium' => $tickets->where('priority', 'medium')->count(),
        'low'    => $tickets->where('priority', 'low')->count(),
    ];

    $recentTickets = $tickets->take(5);

    return view('dashboard', compact('stats', 'recentTickets', 'slaPercentage', 'nearingBreach', 'priorities'));
}
}


