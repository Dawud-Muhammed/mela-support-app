<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\Ticket;
use App\Models\Category;
use App\Services\FileUploadService;
use App\Services\TechnicianDispatcherService;
use App\Services\TicketNotificationService;
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

        public function store(StoreTicketRequest $request,FileUploadService  $fileUploader,TechnicianDispatcherService $dispatcher,TicketNotificationService $notifier){
        // 1. STRICT VALIDATION 
        $validated = $request->validated();
   
       // 2. THE FILE UPLOADER WORKER 🗂️
        $evidencePath = $fileUploader->UploadEvidence($request->file('evidence')); //tell the worker to upload the file and get the path

        //3. THE TECHNICIAN DISPATCHER 🤖
        $category = Category::findOrFail($validated['category_id']);
        $assignedTechnician = $dispatcher->findBestTechnician($category->name, $validated['building']); // Tell the dispatcher the category and building, and get back the best technician (or null if no one is available)
        $initialStatus = $assignedTechnician ? 'assigned' : 'open';
        $assignedTechnicianId = $assignedTechnician ? $assignedTechnician->id : null;

        // 4. PERSISTENCE
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
        

        // 5. NOTIFICATIONS
        if ($assignedTechnician) {
            $notifier->notifyTechnicianAssigned($assignedTechnician, $ticket, $category);
        }

        return redirect()->route('tickets.success', ['ticket' => $ticket->id])
                         ->with('success', 'Ticket created and routed successfully!');
    }

    public function updateStatus(UpdateTicketStatusRequest $request, Ticket $ticket, FileUploadService $fileUploader, TicketNotificationService $notifier)
    {
    //1    
        $validated = $request->validated();
    //2
        $resolution_path = $fileUploader->UploadResolutionEvidence($request->file('resolution_evidence'));
        if($resolution_path){
            $ticket->resolution_evidence_path = $resolution_path;
        }

        $ticket->status = $validated['status'];
        $ticket->save();

          // 🚨 TRIGGER NOTIFICATIONS WHEN RESOLVED OR CLOSED 🚨

        $notifier->notifyStatusUpdate($ticket);
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

