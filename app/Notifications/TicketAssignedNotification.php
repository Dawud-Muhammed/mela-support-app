<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketAssignedNotification extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via(object $notifiable): array
    {
        // We only use the database channel now!
        return ['database']; 
    }

    // This data powers the Modern Bell Icon dropdown
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title'     => 'Auto-Assigned Ticket',
            'message'   => 'The Dispatcher assigned you: ' . $this->ticket->subject,
            'url'       => route('tickets.show', $this->ticket->id), 
            'icon'      => 'fas fa-robot',       // Robot icon for auto-dispatch
            'bg_color'  => 'bg-blue-100 text-blue-600',
            'type'      => 'auto-assigned'
        ];
    }
}