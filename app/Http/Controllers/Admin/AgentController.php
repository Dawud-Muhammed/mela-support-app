<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation (Notice we expect an array for buildings, and confirmed password)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'specialty' => ['required', 'string'],
            'assigned_buildings' => ['required', 'array'], // 🚨 MUST BE ARRAY
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 🚨 MUST CONFIRM
        ]);

        // 2. Convert Array to JSON String so the DB can store it safely
        $buildingsJson = json_encode($validated['assigned_buildings']);

        // 3. Create the Campus Technician
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            
            // 🚨 BI-T SPECIFIC DATA
            'role' => 'technician', 
            'specialty' => $validated['specialty'],
            'assigned_buildings' => $buildingsJson, 
        ]);

        return redirect()->back()->with('success', ' Technician ' . $validated['name'] . ' was added to the campus workforce.');
    }
}