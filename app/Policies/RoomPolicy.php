<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Room can be managed by admins and room owners.
     *
     * @param Room $room
     * @param User $user
     * @return bool
     */
    public function manage(User $user, Room $room): bool
    {
        if (( ! $user->hasRole(User::ROLE_ADMIN)) && ($room->floor->building->user->id !== $user->id)) {
            return false;
        }

        return true;
    }

    // TODO: When creating, check if room belongs to user
    // TODO: When updating, check if room belongs to user
}
