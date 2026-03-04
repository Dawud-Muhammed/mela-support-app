<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    // 🚨 THE VIP PASS 🚨
    // By leaving this empty, we allow ALL columns to be mass-assigned.
    // This automatically covers our new 'resolution_evidence_path' column!
    protected $guarded = []; 

    // Cast the SLA target to a Carbon DateTime object
    protected $casts = [
        'eta_timestamp' => 'datetime',
    ];

    // --- RELATIONSHIPS ---
    
    // Who created the ticket? (The Citizen)
    public function user() { 
        return $this->belongsTo(User::class); 
    }
    
    // What is the problem? (Water, Power, etc.)
    public function category() { 
        return $this->belongsTo(Category::class); 
    }
    
    // Who is fixing it? (The Technician)
    public function assignedTechnician() { 
        return $this->belongsTo(User::class, 'assigned_technician_id'); 
    }
    // --- ACCESSORS ---
    /*
     The Biggest Benefits of Starting at BIT (University Level):
Controlled Testing Environment: A city is chaotic. A university is structured. You have exact Block numbers, exact Dorm numbers, and a known number of proctors/technicians. This makes the "Smart Dispatcher" we built work flawlessly.
Solving a Searing Pain: Students hate walking across campus to find a proctor who isn't in their office, just to report a broken toilet. If you give them a link where they can snap a photo, hit submit, and track the fix while sitting in class... they will love you for it.
The Ultimate Resume / Thesis: You are a 3rd-year student. If you walk into the Dean's office or the IT Director's office with a fully functioning, modern system built on Laravel, deployed and tested by actual students... you are no longer just a student. You are an asset. This could easily become your final year project, or the university might even hire you to maintain it!
     */
    // THE GENERATOR: Creates the beautiful "MS-1-25022026" tracking ID dynamically
    protected function trackingId(): Attribute
    {
        return Attribute::make(
            get: fn () => 'MS-' . $this->id . '-' . $this->created_at->format('dmY'),
        );
    }
        // A ticket has many conversation messages
    public function messages() {
        return $this->hasMany(TicketMessage::class)->latest(); // We load newest at the bottom naturally
    }
}