<?php

namespace Tests\Feature;

use App\Models\Appliance;
use App\Models\ApplianceType;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApplianceAPITest
 * @package Tests\Feature
 * @group ApplianceAPITest
 */
final class ApplianceAPITest extends APITest
{
    use RefreshDatabase;

    public function test_regular_user_cannot_access_other_users_buildings(): void
    {
        $this->actAsUserWithRole(User::ROLE_REGULAR);
        $otherUser = User::factory()->create();

        $room = $this->createRoomForUser($otherUser);
        $appliance = Appliance::factory()->create(['room_id' => $room->id]);

        $response = $this->get($this->getApiDomain() . '/appliances/' . $appliance->id);
        $response->assertNotFound();

        $response = $this->post($this->getApiDomain() . '/appliances', [
            'room_id' => $room->id
        ]);
        $response->assertNotFound();

        $response = $this->patch($this->getApiDomain() . '/appliances/' . $appliance->id, [
            'room_id' => $room->id
        ]);
        $response->assertNotFound();

        $response = $this->delete($this->getApiDomain() . '/appliances/' . $appliance->id);
        $response->assertNotFound();
    }

    public function test_regular_user_can_create_appliances(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $room = $this->createRoomForUser($loggedInUser);

        $response = $this->postJson($this->getApiDomain() . '/appliances', [
            'room_id' => $room->id,
            'name' => 'Test',
            'appliance_type_id' => 1,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'room_id' => $room->id,
                'name' => 'Test',
                'appliance_type_id' => 1,
            ]);
    }

    public function test_admin_can_create_appliance_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $room = $this->createRoomForUser(User::factory()->create());

        $response = $this->postJson($this->getApiDomain() . '/appliances', [
            'room_id' => $room->id,
            'name' => 'Test Update',
            'appliance_type_id' => 1,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'room_id' => $room->id,
                'name' => 'Test Update',
                'appliance_type_id' => 1,
             ]);
    }

    public function test_regular_user_can_update_his_appliance(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $room = $this->createRoomForUser($loggedInUser);
        $appliance = Appliance::factory()->create(['room_id' => $room->id]);

        $response = $this->patchJson($this->getApiDomain() . '/appliances/' . $appliance->id, [
            'room_id' => $room->id,
            'name' => 'Test Update',
            'appliance_type_id' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'room_id' => $room->id,
                'name' => 'Test Update',
                'appliance_type_id' => 1,
             ]);
    }

    public function test_admin_can_update_appliance_for_any_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $room = $this->createRoomForUser(User::factory()->create());
        $appliance = Appliance::factory()->create(['room_id' => $room->id]);

        $response = $this->patchJson($this->getApiDomain() . '/appliances/' . $appliance->id, [
            'room_id' => $room->id,
            'name' => 'Test Update',
            'appliance_type_id' => 1,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'room_id' => $room->id,
                'name' => 'Test Update',
                'appliance_type_id' => 1,
             ]);
    }

    public function test_regular_user_can_delete_his_appliance(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $room = $this->createRoomForUser($loggedInUser);
        $appliance = Appliance::factory()->create(['room_id' => $room->id]);

        $response = $this->deleteJson($this->getApiDomain() . '/appliances/' . $appliance->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    public function test_admin_can_delete_any_appliance(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $room = $this->createRoomForUser(User::factory()->create());
        $appliance = Appliance::factory()->create(['room_id' => $room->id]);

        $response = $this->deleteJson($this->getApiDomain() . '/appliances/' . $appliance->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }

    /**
     * @param User $user
     * @return Room
     */
    private function createRoomForUser(User $user): Room
    {
        ApplianceType::create(['name' => 'Water heater']);

        $building = Building::factory()->create(['user_id' => $user->id]);
        $floor = Floor::factory()->create(['building_id' => $building->id]);

        return Room::factory()->create(['floor_id' => $floor->id]);
    }
}
