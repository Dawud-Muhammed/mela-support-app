<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // 1. Show the Profile Page
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    // 2. Update Phone & Telegram ID
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate the inputs
        $rules = [
            'phone' => 'nullable|string|max:20',
        ];

        // Only validate telegram ID if they are a technician
        if ($user->role === 'technician') {
            $rules['telegram_chat_id'] = 'nullable|string|max:50';
        }

        $validated = $request->validate($rules);

        // Update the user
        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    // 3. Update Password securely
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}