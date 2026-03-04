<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // 🔒 SECURITY CHECK
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Get all users EXCEPT admins (Admins cannot ban each other)
        $users = User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.users', compact('users'));
    }

    public function toggleBan(User $user)
    {
        // 🔒 SECURITY CHECK
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Flip the switch! If true, make false. If false, make true.
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'suspended' : 'reactivated';

        return back()->with('success', "Account for {$user->name} has been {$status} successfully.");
    }
}