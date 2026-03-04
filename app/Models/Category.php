<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // This allows our Seeder to insert all the columns at once securely
    protected $guarded = [];

    // A category has many tickets (we will need this later for the Admin Analytics!)
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}