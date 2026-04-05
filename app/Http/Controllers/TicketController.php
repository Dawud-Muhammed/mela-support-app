<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Notifications\TicketAssignedNotification;
use App\Notifications\TicketResolvedNotification;
class TicketController extends Controller
{
    public function create()
    {
        // 1. Fetch real categories from the DB
        $categories = Category::all();
        
        // If you haven't created categories yet, use php artisan tinker to make some!
        // Category::create(['name' => 'Water Pipe Leak', 'slug' => 'water-leak', 'sla_hours' => 24]);

        return view('tickets.create', compact('categories'));
    }


        public function show(Ticket $ticket)
    {
        Gate::authorize('view', $ticket);

        // 🚨 ADD 'messages.user' so it loads the chat history!
        $ticket->load(['category', 'user', 'assignedTechnician', 'messages.user']);

        return view('tickets.details', compact('ticket'));
    }

       public function storeMessage(Request $request, Ticket $ticket)
    {
        // 🔒 Security: Only people involved in the ticket can chat!
        Gate::authorize('view', $ticket);

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $isInternal = $request->has('is_internal');

        // 1. Save it to the DB!
        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'is_internal' => $isInternal,
        ]);

        // 2. THE NOTIFICATION ENGINE 🚀
        // Only send alerts if this is a PUBLIC message
        if (!$isInternal) {
            
            // A. If the sender is NOT the ticket creator, notify the creator!
            if (auth()->id() !== $ticket->user_id && $ticket->user) {
                $ticket->user->notify(new \App\Notifications\NewTicketMessageNotification($ticket));
            }

            // B. If the sender is NOT the assigned technician, notify the technician!
            if ($ticket->assigned_technician_id && auth()->id() !== $ticket->assigned_technician_id) {
                $technician = \App\Models\User::find($ticket->assigned_technician_id);
                if ($technician) {
                    $technician->notify(new \App\Notifications\NewTicketMessageNotification($ticket));
                }
            }
        }

        return redirect()->back(); // Instantly refresh to show the new message
    }

    // We changed $id to Ticket $ticket to use Laravel Route Model Binding
    public function success(Ticket $ticket)
    {
        // 🔒 ANTI-HACKER SHIELD: This throws 403 if the citizen didn't create this ticket!
        Gate::authorize('view', $ticket);

        return view('tickets.success', compact('ticket'));
    }

        public function store(Request $request)
    {
        // 1. STRICT VALIDATION FOR UNIVERSITY
        $validated = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'subject'           => 'required|string|max:255',
            'description'       => 'required|string',
            'building'          => 'required|string',
            'floor'             => 'required|string',
            'specific_location' => 'required|string',
            'evidence'          => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);
   
        $evidencePath = null;
        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')->store('evidence', 'public');
        }

        $category = Category::findOrFail($validated['category_id']);

        // 2. THE UNIVERSITY ROBOT DISPATCHER 🤖
        $assignedTechnician = User::where('role', 'technician')
                     ->where('specialty', 'LIKE', '%' . $category->name . '%')
                     ->where('assigned_buildings', 'LIKE', '%' . $validated['building'] . '%')
                     ->first();                     

        $initialStatus = $assignedTechnician ? 'assigned' : 'open';
        $assignedTechnicianId = $assignedTechnician ? $assignedTechnician->id : null;

        // 3. PERSISTENCE
        $ticket = Ticket::create([
            'user_id'                  => auth()->id(),
            'category_id'              => $category->id,
            'subject'                  => $validated['subject'],
            'description'              => $validated['description'],
            'building'                 => $validated['building'],
            'floor'                    => $validated['floor'],
            'specific_location'        => $validated['specific_location'],
            'evidence_path'            => $evidencePath,
            'status'                   => $initialStatus, 
            'assigned_technician_id'   => $assignedTechnicianId, 
            'priority'                 => 'medium', 
            'eta_timestamp'            => now()->addHours($category->sla_hours), 
        ]);

        // 4. NOTIFICATIONS
        if ($assignedTechnician) {
            // A. FIRE THE IN-APP BELL NOTIFICATION! 🔔
            $assignedTechnician->notify(new \App\Notifications\TicketAssignedNotification($ticket));

            // B. SEND TELEGRAM NOTIFICATION TO TECHNICIAN 📱
            if ($assignedTechnician->telegram_chat_id) {
                $message = "🚨 <b>NEW TICKET ASSIGNED</b> 🚨\n\n";
                $message .= "<b>Category:</b> " . $category->name . "\n";
                $message .= "<b>Building:</b> " . $validated['building'] . "\n";
                $message .= "<b>Floor/Room:</b> " . $validated['floor'] . " (" . $validated['specific_location'] . ")\n\n";
                $message .= "<b>Issue:</b> " . $validated['subject'] . "\n\n";
                $message .= "<i>Please log in to your Mela Support dashboard to update the status.</i>";

                $telegramService = app(\App\Services\TelegramService::class);
                $telegramService->sendMessage($assignedTechnician->telegram_chat_id, $message);
            }
        }

        return redirect()->route('tickets.success', ['ticket' => $ticket->id])
                         ->with('success', 'Ticket created and routed successfully!');
    }


    public function updateStatus(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,assigned,in_progress,resolved,closed',
            'resolution_evidence' => 'nullable|image|max:5120'
        ]);

        if ($request->hasFile('resolution_evidence')) {
            $path = $request->file('resolution_evidence')->store('evidence/resolutions', 'public');
            $ticket->resolution_evidence_path = $path;
        }

        $ticket->status = $validated['status'];
        $ticket->save();

          // 🚨 TRIGGER NOTIFICATIONS WHEN RESOLVED OR CLOSED 🚨
        if ($ticket->status === 'resolved') {
            // Send Email
            \Illuminate\Support\Facades\Mail::to($ticket->user->email)
                ->send(new \App\Mail\TicketResolvedMail($ticket));

            // Notify User it's resolved
            $ticket->user->notify(new \App\Notifications\TicketResolvedNotification($ticket));
        } 
        elseif ($ticket->status === 'closed') {
            // THE NEW FUEL: Notify the User and Technician that the ticket is officially closed
            // You can use a generic notification or create a TicketClosedNotification!
            $message = "Ticket #{$ticket->id} has been officially closed.";
            
            // For now, let's just reuse the Resolved notification class but pass a different message,
            // OR you can generate a quick `TicketClosedNotification` class!
            $ticket->user->notify(new \App\Notifications\TicketResolvedNotification($ticket));
            
            if ($ticket->assigned_technician_id) {
                $technician = \App\Models\User::find($ticket->assigned_technician_id);
                $technician->notify(new \App\Notifications\TicketResolvedNotification($ticket));
            }
        }

        return back()->with('success', 'Case status updated successfully!');
    }
        

    // // 2. ADD THIS BRAND NEW METHOD FOR THE CITIZEN
     public function verifyResolution(Request $request, Ticket $ticket)
     {
         // Only the owner of the ticket can verify it
         Gate::authorize('view', $ticket);

         $validated = $request->validate(['action' => 'required|in:confirm,reject']);

         if ($validated['action'] === 'confirm') {
             $ticket->update(['status' => 'closed']);

             // 🎉 SEND CONGRATULATION TELEGRAM TO TECHNICIAN
             if ($ticket->assignedTechnician && $ticket->assignedTechnician->telegram_chat_id) {
                 $message = "🎉 <b>GREAT JOB! TICKET CLOSED</b> 🎉\n\n";
                 $message .= "The user just verified your work and officially closed the ticket!\n\n";
                 $message .= "<b>Ticket ID:</b> #" . $ticket->id . "\n";
                 $message .= "<b>Location:</b> " . $ticket->building . " (" . $ticket->specific_location . ")\n\n";
                 $message .= "<i>Thank you for your hard work and keeping the BiT campus running! 🌟</i>";

                 $telegramService = app(\App\Services\TelegramService::class);
                 $telegramService->sendMessage($ticket->assignedTechnician->telegram_chat_id, $message);
             }

                     // THE ENGINE: If the ticket is closed, notify the necessary people!
        if ($ticket->status === 'closed') {
            
            // 1. If the person closing it is the USER, notify the TECHNICIAN!
            if (auth()->id() === $ticket->user_id && $ticket->assigned_technician_id) {
                $technician = \App\Models\User::find($ticket->assigned_technician_id);
                if ($technician) {
                    $technician->notify(new \App\Notifications\TicketClosedNotification($ticket));
                }
            }

            // 2. If the person closing it is an ADMIN, notify BOTH the User and the Technician!
            if (auth()->user()->role === 'admin') {
                $ticket->user->notify(new \App\Notifications\TicketClosedNotification($ticket));
                
                if ($ticket->assigned_technician_id) {
                    $technician = \App\Models\User::find($ticket->assigned_technician_id);
                    if ($technician) {
                        $technician->notify(new \App\Notifications\TicketClosedNotification($ticket));
                    }
                }
            }
        }

             return redirect()->back()->with('success', 'Thank you! The case is now officially closed.');
            
         } else {
             // 🚨 THE CITIZEN REJECTED IT! Make it urgent!
             $ticket->update(['status' => 'in_progress', 'priority' => 'urgent']);

             // ⚠️ SEND WARNING TELEGRAM TO TECHNICIAN
             if ($ticket->assignedTechnician && $ticket->assignedTechnician->telegram_chat_id) {
                 $message = "⚠️ <b>URGENT: WORK REJECTED</b> ⚠️\n\n";
                 $message .= "The user reported that the issue is STILL BROKEN.\n";
                 $message .= "The ticket has been reopened and escalated to <b>URGENT</b> priority.\n\n";
                 $message .= "<b>Location:</b> " . $ticket->building . " (" . $ticket->specific_location . ")\n";
                 $message .= "<i>Please return to the location immediately.</i>";

                 $telegramService = app(\App\Services\TelegramService::class);
                 $telegramService->sendMessage($ticket->assignedTechnician->telegram_chat_id, $message);
             }

                     // THE ENGINE: Notify the Technician that the user rejected the fix!
        if ($ticket->assigned_technician_id) {
            $technician = \App\Models\User::find($ticket->assigned_technician_id);
            if ($technician) {
                $technician->notify(new \App\Notifications\TicketRejectedNotification($ticket));
            }
        }

             return redirect()->back()->with('error', 'Case reopened and escalated to URGENT priority.');
         }
     }
}