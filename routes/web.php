<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AgentController; // We added this for the Admin to create agents
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\CheckIfBanned;
use Illuminate\Http\Request;

// ==========================================
// PUBLIC ROUTES (No login required)
// ==========================================
Route::get('/', function () {
    return view('index');
})->name('landing');
// ==========================================
// AUTHENTICATED ROUTES (Must be logged in)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // --- COMMON ROUTES (Everyone sees these) ---


    // --- 1. TICKETING SYSTEM (Citizens & Agents) ---
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/success/{ticket}', [TicketController::class, 'success'])->name('tickets.success');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    // 🚨 NEW: The route for Agents to change the status!
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    // 🚨 NEW: Citizen Verification Route
    Route::patch('/tickets/{ticket}/verify', [TicketController::class, 'verifyResolution'])->name('tickets.verify');

    Route::post('/tickets/{ticket}/messages', [App\Http\Controllers\TicketController::class, 'storeMessage'])->name('tickets.messages.store');
    // --- 2. ADMIN ROUTES ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);
  
    // 📊 Admin Analytics Route
    Route::get('/admin/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');

    // The route your Admin form submits to when creating "Selam Alemu"
    Route::post('/admin/agents', [AgentController::class, 'store'])->name('admin.agents.store');

    // --- 3. PROFILE ROUTES (Everyone can edit their profile) ---
    

// 👤 User Profile Routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

});



// 🛡️ Wrap ALL your dashboard and ticket routes in both 'auth' AND 'CheckIfBanned'
Route::middleware(['auth', 'verified', CheckIfBanned::class])->group(function () {
    
    // (Your existing Dashboard, Ticket, and Profile routes go here)

    // 🚨 ADMIN USER MANAGEMENT ROUTES
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{user}/toggle-ban', [UserController::class, 'toggleBan'])->name('admin.users.toggle_ban');
});

// Breeze Auth Routes (Login, Register, Password Reset)
require __DIR__.'/auth.php';

// NOTIFICATION ROUTES
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifications/{id}/redirect', [App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.redirect');
Route::post('/notifications/mark-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');