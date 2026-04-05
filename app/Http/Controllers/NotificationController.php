<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // 1. Show the full page with Pagination
    public function index(Request $request)
    {
        // Get all notifications, 15 per page!
        $notifications = $request->user()->notifications()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    // 2. Mark a single notification as read, then redirect to the ticket
    public function readAndRedirect(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        
        $notification->markAsRead(); // Turn off the red dot!

        return redirect($notification->data['url'] ?? route('dashboard'));
    }

    // 3. Mark ALL notifications as read (Used by the "Mark all read" button in the dropdown)
    public function markAllRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}