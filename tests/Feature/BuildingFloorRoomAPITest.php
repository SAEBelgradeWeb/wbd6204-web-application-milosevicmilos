<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class BuildingFloorRoomAPITest
 * @package Tests\Feature
 * @group BuildingFloorRoomAPITest
 */
final class BuildingFloorRoomAPITest extends APITest
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_other_users_building_floors(): void
    {
        $this->actAsUserWithRole(User::ROLE_REGULAR);
        $otherUser = User::factory()->create();

        $building = Building::factory()->create(['user_id' => $otherUser->id]);
        $floor = Floor::factory()->create(['building_id' => $building->id]);
        $room = Room::factory()->create(['floor_id' => $floor->id]);

        $baseUrl = $this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms';

        $response = $this->get($baseUrl . '/' . $room->id);
        $response->assertNotFound();

        $response = $this->post($baseUrl);
        $response->assertNotFound();

        $response = $this->patch($baseUrl . '/' . $room->id);
        $response->assertNotFound();

        $response = $this->delete($baseUrl . '/' . $room->id);
        $response->assertNotFound();
    }

    /**
     * @throws Exception
     */
    public function test_admin_can_get_all_buildings_and_its_floor_rooms(): void
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

        $response = $this->getJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms');

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
    public function test_regular_user_can_get_his_building_floor_rooms(): void
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

        $response = $this->getJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms');

        $response
            ->assertStatus(200)
            ->assertJsonCount($roomCount, 'rooms')
            ->assertJsonStructure([
                  'rooms' => [
                      '*' => array_values((new Room())->getVisible())
                  ]
              ]);
    }

    public function test_regular_user_can_create_building_floor_room(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $building = Building::factory()->create([
            'user_id' => $loggedInUser->id
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->postJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms', [
            'name' => 'Test',
            'size' => 50,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                 'name' => 'Test',
                 'size' => 50,
             ]);
    }

    public function test_admin_can_create_building_floor_room_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        User::factory()->count(10)->create();

        $building = Building::factory()->create([
            'user_id' => 5
        ]);

        $floor = Floor::factory()->create([
            'building_id' => $building->id
        ]);

        $response = $this->postJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms', [
            'name' => 'Test',
            'size' => 50,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Test',
                'size' => 50,
            ]);
    }

    public function test_regular_user_can_update_his_building_floor_room(): void
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

        $response = $this->patchJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms/' . $room->id, [
            'name' => 'Test Update',
            'size' => 5
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Test Update',
                'size' => 5
            ]);
    }

    public function test_admin_can_update_building_floor_room_for_any_user(): void
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

        $response = $this->patchJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms/' . $room->id, [
            'name' => 'Test Update',
            'size' => 5
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Test Update',
                'size' => 5
             ]);
    }

    public function test_regular_user_can_delete_his_building_floor_room(): void
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

        $response = $this->deleteJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms/' . $room->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    public function test_admin_can_delete_any_building_floor_room(): void
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

        $response = $this->deleteJson($this->getApiDomain() . '/buildings/' . $building->id . '/floors/' . $floor->id . '/rooms/' . $room->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }
}
