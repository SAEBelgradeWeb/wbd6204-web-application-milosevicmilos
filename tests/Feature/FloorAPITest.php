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

    /**
     * @throws Exception
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
}
