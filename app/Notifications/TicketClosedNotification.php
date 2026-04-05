<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketClosedNotification extends Notification
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
            'title'     => 'Ticket Officially Closed',
            'message'   => 'The user confirmed your resolution and closed: ' . $this->ticket->subject,
            'url'       => route('tickets.show', $this->ticket->id), 
            'icon'      => 'lock', // A lock icon to show it's closed securely
            'type'      => 'closed'
        ];
    }
}