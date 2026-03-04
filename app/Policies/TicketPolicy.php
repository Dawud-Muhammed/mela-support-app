<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }



    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // 1. Admins can view ANY ticket
        if ($user->role === 'admin') {
            return true;
        }

        // 2. Technicians can view tickets IF:
        //    a) The ticket is specifically assigned to them
        //    OR
        //    b) The ticket's building is inside their list of assigned buildings!
        if ($user->role === 'technician') {
            if ($ticket->assigned_technician_id === $user->id) {
                return true;
            }

            // Check if the ticket's building is in the technician's assigned buildings JSON array
            if ($user->assigned_buildings) {
                $buildingsArray = json_decode($user->assigned_buildings, true);
                if (is_array($buildingsArray) && in_array($ticket->building, $buildingsArray)) {
                    return true;
                }
            }

            return false;
        }

        // 3. Normal Users can only view tickets they created
        return $user->id === $ticket->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
