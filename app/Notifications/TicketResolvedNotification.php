<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketResolvedNotification extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title'     => 'Ticket Resolved!',
            'message'   => 'Your ticket has been resolved: ' . $this->ticket->subject,
            'url'       => route('tickets.show', $this->ticket->id), 
            'icon'      => 'fas fa-check-circle', // Success Checkmark
            'bg_color'  => 'bg-green-100 text-green-600',
            'type'      => 'resolved'
        ];
    }
}