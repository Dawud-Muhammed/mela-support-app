<?php

namespace App\Services;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Category;
use App\Notifications\TicketAssignedNotification;

class TicketNotificationService
{
    /**
     * Notify the technician via App and Telegram.
     */
    public function notifyTechnicianAssigned(User $technician, Ticket $ticket, Category $category): void
    {
        // 1. Send the in-app notification
        $technician->notify(new TicketAssignedNotification($ticket));

        //2. Send the Telegram message
        
                if ($technician->telegram_chat_id) {
                $message = "🚨 <b>NEW TICKET ASSIGNED</b> 🚨\n\n";
                $message .= "<b>Category:</b> " . $category->name . "\n";
                $message .= "<b>Building:</b> " . $ticket->building . "\n";
                $message .= "<b>Floor/Room:</b> " . $ticket->floor . " (" . $ticket->specific_location . ")\n\n";
                $message .= "<b>Issue:</b> " . $ticket->subject . "\n\n";
                $message .= "<i>Please log in to your Mela Support dashboard to update the status.</i>";

                $telegramService = app(\App\Services\TelegramService::class);
                $telegramService->sendMessage($technician->telegram_chat_id, $message);
            }
    }
    
    public function notifyStatusUpdate(Ticket $ticket): void{
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
    }
}