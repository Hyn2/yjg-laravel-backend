<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\MeetingRoom;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MeetingRoomPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function store(Admin $admin): bool
    {
        return $admin->admin_privilege;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(Admin $admin): bool
    {
        return $admin->admin_privilege;
    }
}