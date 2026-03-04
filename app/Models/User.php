<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * 🚨 WE UPDATED THIS LIST TO ALLOW OUR CUSTOM COLUMNS! 🚨
     */

    protected $fillable = [
        'name', 'email', 'password', 'phone', 
        'role', 'campus_role', 'specialty', 'assigned_buildings' ,'telegram_chat_id' ,'is_banned'
    ];
    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
        // For Technicians: The tickets assigned to them
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_technician_id');
    }
}