<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

/**
 * Class BuildingAPITest
 * @package Tests\Feature
 * @group BuildingAPI
 */
final class BuildingAPITest extends APITest
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_other_users_buildings(): void
    {
        $apiDomain = Config::get('app.api_url');

        $this->actAsUserWithRole(User::ROLE_REGULAR);
        $otherUser = User::factory()->create();

        $building = Building::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->get($apiDomain . '/buildings/' . $building->id);
        $response->assertNotFound();

        $response = $this->patch($apiDomain . '/buildings/' . $building->id);
        $response->assertNotFound();

        $response = $this->delete($apiDomain . '/buildings/' . $building->id);
        $response->assertNotFound();
    }

    /**
     * @throws Exception
     */
    public function test_admin_can_get_all_buildings(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $entitiesCount = random_int(1, 100);

        User::factory()->count(11)->create();
        Building::factory()->count($entitiesCount)->create();

        $apiDomain = Config::get('app.api_url');

        $response = $this->getJson($apiDomain . '/buildings');

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount, 'buildings')
            ->assertJsonStructure([
                  'buildings' => [
                      '*' => array_values((new Building())->getVisible())
                  ]
              ]);
    }

    /**
     * @throws Exception
     */
    public function test_regular_user_can_get_his_buildings(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $entitiesCount = random_int(1, 100);

        /** @var User $loggedInUser */
        User::factory()->count(11)->create();

        Building::factory()->count($entitiesCount)->create([
            'user_id' => $loggedInUser->id
        ]);

        Building::factory()->count(10)->create([
           'user_id' => 5
        ]);

        $apiDomain = Config::get('app.api_url');

        $response = $this->getJson($apiDomain . '/buildings');

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount, 'buildings')
            ->assertJsonStructure([
                  'buildings' => [
                      '*' => array_values((new Building())->getVisible())
                  ]
              ]);
    }

    public function test_regular_user_can_create_building(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $apiDomain = Config::get('app.api_url');

        $response = $this->postJson($apiDomain . '/buildings', [
            'user_id' => $loggedInUser->id,
            'name' => 'Test',
            'address' => 'User',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                 'user_id' => $loggedInUser->id,
                 'name' => 'Test',
                 'address' => 'User',
             ]);
    }

    public function test_admin_can_create_building_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $apiDomain = Config::get('app.api_url');

        $response = $this->postJson($apiDomain . '/buildings', [
            'user_id' => 5,
            'name' => 'Test',
            'address' => 'User',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                 'user_id' => 5,
                 'name' => 'Test',
                 'address' => 'User',
             ]);
    }

    public function test_regular_user_can_update_his_building(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $apiDomain = Config::get('app.api_url');

        $response = $this->patchJson($apiDomain . '/buildings/1', [
            'user_id' => $loggedInUser->id,
            'name' => 'Test',
            'address' => 'User',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                 'user_id' => $loggedInUser->id,
                 'name' => 'Test',
                 'address' => 'User',
             ]);
    }

    public function test_admin_can_update_building_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        Building::factory()->create([
            'user_id' => 2
        ]);

        $apiDomain = Config::get('app.api_url');

        $response = $this->postJson($apiDomain . '/buildings', [
            'user_id' => 2,
            'name' => 'Test',
            'address' => 'User',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                 'user_id' => 2,
                 'name' => 'Test',
                 'address' => 'User',
             ]);
    }

    /**
     * @group test
     */
    public function test_admin_can_delete_any_building(): void
    {
        $this->userWithRoleCanDeleteModelOfType(User::ROLE_ADMIN, new User());
    }
}
