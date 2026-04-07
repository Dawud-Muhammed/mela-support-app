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

    public function notifyTicketClosed(Ticket $ticket): void
    {
        // 1. 🎉 SEND CONGRATULATION TELEGRAM TO TECHNICIAN
        if ($ticket->assignedTechnician && $ticket->assignedTechnician->telegram_chat_id) {
            $message = "🎉 <b>GREAT JOB! TICKET CLOSED</b> 🎉\n\n";
            $message .= "The user just verified your work and officially closed the ticket!\n\n";
            $message .= "<b>Ticket ID:</b> #" . $ticket->id . "\n";
            $message .= "<b>Location:</b> " . $ticket->building . " (" . $ticket->specific_location . ")\n\n";
            $message .= "<i>Thank you for your hard work! 🌟</i>";

            // Grab the Telegram tool and send it
            $telegramService = app(\App\Services\TelegramService::class);
            $telegramService->sendMessage($ticket->assignedTechnician->telegram_chat_id, $message);
        }

        // 2. SEND IN-APP DATABASE NOTIFICATIONS
        // If the person closing it is the USER, notify the TECHNICIAN!
        if (auth()->id() === $ticket->user_id && $ticket->assigned_technician_id) {
            $technician = \App\Models\User::find($ticket->assigned_technician_id);
            if ($technician) {
                $technician->notify(new \App\Notifications\TicketClosedNotification($ticket));
            }
        }

        // If the person closing it is an ADMIN, notify BOTH the User and the Technician!
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

    public function notifyTicketRejected(Ticket $ticket): void{
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
    }


    public function notifyNewMessage(Ticket $ticket):void{
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
}