<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function actAsUserWithRole(string $role): void
    {
        Sanctum::actingAs(
            User::factory()->create(['role' => $role])
        );
    }
}
