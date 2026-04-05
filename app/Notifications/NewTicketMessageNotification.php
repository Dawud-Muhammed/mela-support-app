<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTicketMessageNotification extends Notification
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
            'title'     => 'New Reply',
            'message'   => 'Someone replied to ticket: ' . $this->ticket->subject,
            'url'       => route('tickets.show', $this->ticket->id) . '#messages', // Jump straight to messages
            'icon'      => 'fas fa-comment-dots', // Chat bubble
            'bg_color'  => 'bg-purple-100 text-purple-600',
            'type'      => 'thread-reply'
        ];
    }
}