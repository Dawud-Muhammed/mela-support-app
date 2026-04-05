<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketRejectedNotification extends Notification
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
            'title'     => 'Resolution Rejected',
            'message'   => 'The user rejected the resolution for: ' . $this->ticket->subject,
            'url'       => route('tickets.show', $this->ticket->id), 
            'icon'      => 'alert-circle', // Warning icon
            'type'      => 'rejected'
        ];
    }
}