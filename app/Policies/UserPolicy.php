<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Only "admin" can manage users.
     *
     * @param User $user
     * @return bool
     */
    public function manage(User $user): bool
    {
        if ( ! $user->hasRole(User::ROLE_ADMIN)) {
            return false;
        }

        return true;
    }
}
