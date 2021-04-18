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

    public function test_regular_user_cannot_access_other_users_rooms(): void
    {
        $this->actAsUserWithRole(User::ROLE_REGULAR);
        $otherUser = User::factory()->create();

        $building = Building::factory()->create(['user_id' => $otherUser->id]);
        $floor = Floor::factory()->create(['building_id' => $building->id]);
        $room = Room::factory()->create(['floor_id' => $floor->id]);

        $baseUrl = $this->getApiDomain() . '/rooms';

        $response = $this->get($baseUrl . '/' . $room->id);
        $response->assertNotFound();

        $response = $this->delete($baseUrl . '/' . $room->id);
        $response->assertNotFound();
    }

    /**
     * @throws Exception
     * @group test
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
     * @group test
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

    public function test_regular_user_can_delete_his_room(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $building = Building::factory()->create([
            'user_id' => 5
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $room = Room::factory()->create([
            'floor_id' => $floor->id
        ]);

        $response = $this->deleteJson($this->getApiDomain() . '/rooms/' . $room->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    public function test_admin_can_delete_any_room(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $room = Room::factory()->create([
            'floor_id' => $floor->id
        ]);

        $response = $this->deleteJson($this->getApiDomain() . '/rooms/' . $room->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }
}
