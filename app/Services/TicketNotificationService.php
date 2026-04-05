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
}