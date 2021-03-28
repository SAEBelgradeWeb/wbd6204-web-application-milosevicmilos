<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Floor;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class BuildingFloorAPITest
 * @package Tests\Feature
 * @group BuildingFloorAPITest
 */
final class BuildingFloorAPITest extends APITest
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_other_users_building_floors(): void
    {
        $this->actAsUserWithRole(User::ROLE_REGULAR);
        $otherUser = User::factory()->create();

        $building = Building::factory()->create(['user_id' => $otherUser->id]);
        $floor = Floor::factory()->create(['building_id' => $building->id]);

        $baseUrl = $this->getApiDomain() . '/buildings/' . $building->id . '/floors';

        $response = $this->get($baseUrl . '/' . $floor->id);
        $response->assertNotFound();

        $response = $this->post($baseUrl);
        $response->assertNotFound();

        $response = $this->patch($baseUrl . '/' . $floor->id);
        $response->assertNotFound();

        $response = $this->delete($baseUrl . '/' . $floor->id);
        $response->assertNotFound();
    }

    /**
     * @throws Exception
     */
    public function test_admin_can_get_all_buildings_and_its_floors(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $entitiesCount = random_int(1, 100);

        User::factory()->count(11)->create();
        $buildingCollection = Building::factory()->count($entitiesCount)->create();

        $building = $buildingCollection->first();
        Floor::factory()->count($entitiesCount)->create(['building_id' => $building->id]);

        $response = $this->getJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors');

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount, 'floors')
            ->assertJsonStructure([
                  'floors' => [
                      '*' => array_values((new Floor())->getVisible())
                  ]
              ]);
    }

    /**
     * @throws Exception
     */
    public function test_regular_user_can_get_his_building_floors(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        User::factory()->count(11)->create();

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        Building::factory()->count(10)->create([
           'user_id' => 5
        ]);

        $floorsCount = random_int(1, 100);

        Floor::factory()->count($floorsCount)->create([
            'building_id' => $building->id
        ]);

        $response = $this->getJson($this->getApiDomain() . '/buildings/1' . '/floors');

        $response
            ->assertStatus(200)
            ->assertJsonCount($floorsCount, 'floors')
            ->assertJsonStructure([
                  'floors' => [
                      '*' => array_values((new Floor())->getVisible())
                  ]
              ]);
    }

    public function test_regular_user_can_create_building_floor(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $response = $this->postJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors', [
            'name' => 'Test',
            'level' => 5,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                 'name' => 'Test',
                 'level' => 5,
             ]);
    }

    public function test_admin_can_create_building_floor_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $building = Building::factory()->create([
            'user_id' => 5
        ]);

        $response = $this->postJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors', [
            'name' => 'Test',
            'level' => 5,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Test',
                'level' => 5,
            ]);
    }

    public function test_regular_user_can_update_his_building_floor(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->patchJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id, [
            'name' => 'Test Update',
            'level' => 5
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Test Update',
                'level' => 5
            ]);
    }

    public function test_admin_can_update_building_floor_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $building = Building::factory()->create([
            'user_id' => 5
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->patchJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id, [
            'name' => 'Test Edit',
            'level' => 10,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                 'name' => 'Test Edit',
                 'level' => 10,
             ]);
    }

    public function test_regular_user_can_delete_his_building_floor(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $building = Building::factory()->create([
            'user_id' => 5
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->deleteJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    public function test_admin_can_delete_any_building_floor(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->deleteJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }
}
