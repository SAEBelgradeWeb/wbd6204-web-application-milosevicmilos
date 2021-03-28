<?php

namespace App\Policies;

use App\Models\Appliance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class AppliancePolicy
{
    use HandlesAuthorization;

    /**
     * Appliance can be managed by admins and appliance owners.
     *
     * @param Appliance $appliance
     * @param User $user
     * @return bool
     */
    public function manage(User $user, Appliance $appliance): bool
    {
        if (( ! $user->hasRole(User::ROLE_ADMIN)) && ($appliance->room->floor->building->user->id !== $user->id)) {
            return false;
        }

        return true;
    }

    // TODO: When creating, check if room belongs to user
    // TODO: When updating, check if room belongs to user
}
