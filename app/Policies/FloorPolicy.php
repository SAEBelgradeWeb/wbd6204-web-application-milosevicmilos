<?php

namespace App\Policies;

use App\Models\Floor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class FloorPolicy
{
    use HandlesAuthorization;

    /**
     * Room can be managed by admins and room owners.
     *
     * @param Floor $floor
     * @param User $user
     * @return bool
     */
    public function manage(User $user, Floor $floor): bool
    {
        if (( ! $user->hasRole(User::ROLE_ADMIN)) && ($floor->building->user->id !== $user->id)) {
            return false;
        }

        return true;
    }

    // TODO: When creating, check if room belongs to user
    // TODO: When updating, check if room belongs to user
}
