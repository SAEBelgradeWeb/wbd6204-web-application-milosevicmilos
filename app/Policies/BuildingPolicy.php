<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class BuildingPolicy
{
    use HandlesAuthorization;

    /**
     * Buildings can be managed by admins and building owners.
     *
     * @param Building $building
     * @param User $user
     * @return bool
     */
    public function manage(User $user, Building $building): bool
    {
        if (( ! $user->hasRole(User::ROLE_ADMIN)) && ($building->user->id !== $user->id)) {
            return false;
        }

        return true;
    }
}
