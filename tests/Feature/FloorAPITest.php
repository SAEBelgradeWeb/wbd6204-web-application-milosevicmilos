<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Floor;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class FloorAPITest
 * @package Tests\Feature
 * @group FloorAPI
 */
final class FloorAPITest extends APITest
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_other_users_building_floors(): void
    {
        $this->actAsUserWithRole(User::ROLE_REGULAR);
        $otherUser = User::factory()->create();

        $building = Building::factory()->create(['user_id' => $otherUser->id]);
        $floor = Floor::factory()->create(['building_id' => $building->id]);

        $baseUrl = $this->getApiDomain() . '/floors';

        $response = $this->get($baseUrl . '/' . $building->id);
        $response->assertNotFound();

        $response = $this->delete($baseUrl . '/' . $floor->id);
        $response->assertNotFound();
    }

    /**
     * @throws Exception
     * @group test
     */
    public function test_admin_can_get_all_floors(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $entitiesCount = random_int(1, 100);

        User::factory()->count(11)->create();
        $buildingCollection = Building::factory()->count($entitiesCount)->create();

        $building = $buildingCollection->first();
        Floor::factory()->count($entitiesCount)->create(['building_id' => $building->id]);

        $response = $this->getJson($this->getApiDomain() . '/floors');

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
     * @group test
     */
    public function test_regular_user_can_get_his_floors(): void
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

        $response = $this->getJson($this->getApiDomain() . '/floors');

        $response
            ->assertStatus(200)
            ->assertJsonCount($floorsCount, 'floors')
            ->assertJsonStructure([
                'floors' => [
                    '*' => array_values((new Floor())->getVisible())
                ]
            ]);
    }

    public function test_regular_user_can_delete_his_floor(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $building = Building::factory()->create([
            'user_id' => 5
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->deleteJson($this->getApiDomain() . '/floors/' . $floor->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    public function test_admin_can_delete_any_floor(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->deleteJson($this->getApiDomain() . '/floors/' . $floor->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }
}
