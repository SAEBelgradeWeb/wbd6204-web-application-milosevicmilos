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
 * Class ApplianceFilterTest
 * @package Tests\Feature
 * @group ApplianceFilterTest
 */
final class ApplianceFilterTest extends APITest
{
    use RefreshDatabase;

    public function test_admin_can_get_all_appliances(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($user1, 10);
        $this->createAppliancesForUser($user2, 10);
        $this->createAppliancesForUser($user3, 10);

        $response = $this->getJson($this->getApiDomain() . '/appliances');

        $response
            ->assertStatus(200)
            ->assertJsonCount(30, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);
    }

    /**
     * @group test
     */
    public function test_admin_can_get_all_appliances_of_specified_user(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($user1, 10);
        $this->createAppliancesForUser($user2, 20);
        $this->createAppliancesForUser($user3, 30);

        $response = $this->json('GET',$this->getApiDomain() . '/appliances', [
            'user_id' => $user1->id
        ], []);

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);
    }

    public function test_regular_user_can_get_all_his_appliances(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($loggedInUser, 10);
        $this->createAppliancesForUser($user2, 20);
        $this->createAppliancesForUser($user3, 30);

        $response = $this->json('GET',$this->getApiDomain() . '/appliances', [
            'user_id' => $user3->id
        ], []);

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);
    }

    public function test_regular_user_can_get_only_his_appliances(): void
    {
        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);

        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($loggedInUser, 10);
        $this->createAppliancesForUser($user2, 20);
        $this->createAppliancesForUser($user3, 30);

        $response = $this->getJson($this->getApiDomain() . '/appliances');

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);
    }

    public function test_filtering_of_appliances_by_building(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($user1, 10);
        $this->createAppliancesForUser($user2, 20);
        $this->createAppliancesForUser($user3, 30);

        $response = $this->json('GET',$this->getApiDomain() . '/appliances', [
            'building_id' => 3
        ], []);

        $response
            ->assertStatus(200)
            ->assertJsonCount(30, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);
    }

    public function test_filtering_of_appliances_by_building_floor(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($user1, 10);
        $this->createAppliancesForUser($user2, 20);
        $this->createAppliancesForUser($user3, 30);

        $response = $this->json('GET',$this->getApiDomain() . '/appliances', [
            'building_id' => 2,
            'floor_id' => 2
        ], []);

        $response
            ->assertStatus(200)
            ->assertJsonCount(20, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);
    }

    public function test_filtering_of_appliances_by_building_floor_room(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $this->createAppliancesForUser($user1, 10);
        $this->createAppliancesForUser($user2, 20);
        $this->createAppliancesForUser($user3, 30);

        $response = $this->json('GET',$this->getApiDomain() . '/appliances', [
            'building_id' => 1,
            'floor_id' => 1,
            'room_id' => 1
        ], []);

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, 'appliances')
            ->assertJsonStructure([
                'appliances' => [
                    '*' => [
                        'appliance_id',
                        'appliance_name',
                        'appliance_type_name',
                        'room_id',
                        'room_name',
                        'floor_id',
                        'floor_name',
                        'building_id',
                        'building_name',
                        'user_id',
                        'user_first_name',
                        'user_last_name'
                    ]
                ]
            ]);

        $response1 = $this->json('GET',$this->getApiDomain() . '/appliances', [
            'building_id' => 5,
            'floor_id' => 5,
            'room_id' => 5
        ], []);

        $response1
            ->assertStatus(200)
            ->assertJsonCount(0, 'appliances');
    }

    /**
     * @param User $user
     * @param int $count
     */
    private function createAppliancesForUser(User $user, int $count): void
    {
        ApplianceType::create(['name' => 'Water heater']);

        $building = Building::factory()->create(['user_id' => $user->id]);
        $floor = Floor::factory()->create(['building_id' => $building->id]);
        $room = Room::factory()->create(['floor_id' => $floor->id]);
        Appliance::factory($count)->create(['room_id' => $room->id]);
    }
}
