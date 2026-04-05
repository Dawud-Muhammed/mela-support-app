<?php

namespace App\Services;

use App\Models\User;

class TechnicianDispatcherService
{
    /**
     * Find the best technician for the job.
     */
public function findBestTechnician(string $categoryName,string $building): ?user{
return  User::where('role', 'technician')
                     ->where('specialty', 'LIKE', '%' . $categoryName . '%')
                     ->where('assigned_buildings', 'LIKE', '%' . $building . '%')
                     ->first();
}
}