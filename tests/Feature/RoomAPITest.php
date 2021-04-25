<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class RoomAPITest
 * @package Tests\Feature
 * @group RoomAPI
 */
final class RoomAPITest extends APITest
{
    use RefreshDatabase;

    /**
     * @throws Exception
     */
    public function test_admin_can_get_all_rooms(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $entitiesCount = random_int(1, 100);

        User::factory()->count(11)->create();
        $buildingCollection = Building::factory()->count($entitiesCount)->create();

        $building = $buildingCollection->first();
        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        Room::factory()->count($entitiesCount)->create([
            'floor_id' => $floor->id
        ]);

        $response = $this->getJson($this->getApiDomain() . '/rooms');

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount, 'rooms')
            ->assertJsonStructure([
                'rooms' => [
                    '*' => array_values((new Room())->getVisible())
                ]
            ]);
    }

    /**
     * @throws Exception
     */
    public function test_regular_user_can_get_his_rooms(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        User::factory()->count(11)->create();

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        Building::factory()->count(10)->create([
            'user_id' => 5
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $roomCount = random_int(1, 100);
        Room::factory()->count($roomCount)->create([
            'floor_id' => $floor->id
        ]);

        $response = $this->getJson($this->getApiDomain() . '/rooms');

        $response
            ->assertStatus(200)
            ->assertJsonCount($roomCount, 'rooms')
            ->assertJsonStructure([
                'rooms' => [
                    '*' => array_values((new Room())->getVisible())
                ]
            ]);
    }
}
