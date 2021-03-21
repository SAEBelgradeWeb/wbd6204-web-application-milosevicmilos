<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param string $role
     * @return User
     */
    public function actAsUserWithRole(string $role): User
    {
        $user = User::factory()->create(['role' => $role]);

        Sanctum::actingAs(
            $user
        );

        return $user;
    }
}
