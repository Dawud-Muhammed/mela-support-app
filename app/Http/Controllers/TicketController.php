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

       public function storeMessage(Request $request, Ticket $ticket, TicketNotificationService $notifier)
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
            $notifier->notifyNewMessage($ticket);
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
     public function verifyResolution(Request $request, Ticket $ticket, TicketNotificationService $notifier)
     {
         // Only the owner of the ticket can verify it
         Gate::authorize('view', $ticket);

         $validated = $request->validate(['action' => 'required|in:confirm,reject']);

         if ($validated['action'] === 'confirm') {

            // Update the ticket status to closed ==  Manager updates the database
            $ticket->update(['status' => 'closed']);

            //maneger tells the worker to send the congratulation telegram message
            $notifier->notifyTicketClosed($ticket);

            //manager gives the message which he got from the worker
            return redirect()->back()->with('success', 'Thank you! The case is now officially closed.');
            
         } else {
             // 🚨 THE CITIZEN REJECTED IT! Make it urgent!
             $ticket->update(['status' => 'in_progress', 'priority' => 'urgent']);

             $notifier->notifyTicketRejected($ticket);

             return redirect()->back()->with('error', 'Case reopened and escalated to URGENT priority.');
         }
     }
}

