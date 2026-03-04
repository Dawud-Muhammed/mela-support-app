<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
   protected $fillable = ['ticket_id', 'user_id', 'message', 'is_internal'];

    // Who sent it?
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Which ticket does it belong to?
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
}
