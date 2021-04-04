<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UserAPITest
 * @package Tests\Feature
 * @group UserAPI
 */
final class UserAPITest extends APITest
{
    use RefreshDatabase;

    public function test_regular_user_cannot_manage_users(): void
    {
        $this->userWithRoleCannotAccessEndpoints(User::ROLE_REGULAR, '/users');
    }

    /**
     * @throws Exception
     */
    public function test_admin_can_get_all_users(): void
    {
        $this->userWithRoleCanGetAllModelsOfType(User::ROLE_ADMIN, new User());
    }

    public function test_admin_can_create_user(): void
    {
        $this->userWithRoleCanCreateModelOfType(User::ROLE_ADMIN, new User(), [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'testemail@test.com',
            'role' => User::ROLE_REGULAR,
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ],
        [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'testemail@test.com',
            'role' => User::ROLE_REGULAR,
        ]);
    }

    public function test_admin_can_get_one_user(): void
    {
        $this->userWithRoleCanGetOneModelOfType(User::ROLE_ADMIN, new User());
    }

    public function test_admin_can_update_user(): void
    {
        $this->userWithRoleCanUpdateModelOfType(User::ROLE_ADMIN, new User(), [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'testemail@test.com',
            'role' => User::ROLE_REGULAR
        ]);
    }

    /**
     * @group test
     */
    public function test_admin_can_delete_user(): void
    {
        $this->userWithRoleCanDeleteModelOfType(User::ROLE_ADMIN, new User());
    }
}
