<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check the user's role and redirect them to their specific workspace
        $user = Auth::user();

        $redirectUrl = match ($user->role) {
        // Since we built a smart, unified dashboard, EVERYONE goes there!
        // The DashboardController will securely decide what they see based on their role.
        'admin'   => route('dashboard'),
        'agent'   => route('dashboard'),
        'citizen' => route('dashboard'), 
        default   => route('landing'),
        };

        return redirect()->intended($redirectUrl);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}