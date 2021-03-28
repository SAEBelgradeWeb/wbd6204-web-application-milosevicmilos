<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\User;
use Exception;
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

        $appliance = Building::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->get($this->getApiDomain() . '/appliances/' . $building->id);
        $response->assertNotFound();

        $response = $this->patch($this->getApiDomain() . '/appliances/' . $building->id);
        $response->assertNotFound();

        $response = $this->delete($this->getApiDomain() . '/appliances/' . $building->id);
        $response->assertNotFound();
    }
//

    // TODO: I cannot create appliance in room id that doesnt belong to me.
    // TODO: I cannot update appliance in room id that doesnt belong to me.

//    /**
//     * @throws Exception
//     */
//    public function test_admin_can_get_all_buildings(): void
//    {
//        $this->actAsUserWithRole(User::ROLE_ADMIN);
//
//        $entitiesCount = random_int(1, 100);
//
//        User::factory()->count(11)->create();
//        Building::factory()->count($entitiesCount)->create();
//
//        $response = $this->getJson($this->getApiDomain() . '/buildings');
//
//        $response
//            ->assertStatus(200)
//            ->assertJsonCount($entitiesCount, 'buildings')
//            ->assertJsonStructure([
//                  'buildings' => [
//                      '*' => array_values((new Building())->getVisible())
//                  ]
//              ]);
//    }
//
//    /**
//     * @throws Exception
//     */
//    public function test_regular_user_can_get_his_buildings(): void
//    {
//        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);
//
//        $entitiesCount = random_int(1, 100);
//
//        /** @var User $loggedInUser */
//        User::factory()->count(11)->create();
//
//        Building::factory()->count($entitiesCount)->create([
//            'user_id' => $loggedInUser->id
//        ]);
//
//        Building::factory()->count(10)->create([
//           'user_id' => 5
//        ]);
//
//        $response = $this->getJson($this->getApiDomain() . '/buildings');
//
//        $response
//            ->assertStatus(200)
//            ->assertJsonCount($entitiesCount, 'buildings')
//            ->assertJsonStructure([
//                  'buildings' => [
//                      '*' => array_values((new Building())->getVisible())
//                  ]
//              ]);
//    }
//
//    public function test_regular_user_can_create_building(): void
//    {
//        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);
//
//        $response = $this->postJson($this->getApiDomain() . '/buildings', [
//            'user_id' => $loggedInUser->id,
//            'name' => 'Test',
//            'address' => 'User',
//        ]);
//
//        $response
//            ->assertStatus(201)
//            ->assertJsonFragment([
//                 'user_id' => $loggedInUser->id,
//                 'name' => 'Test',
//                 'address' => 'User',
//             ]);
//    }
//
//    public function test_admin_can_create_building_for_any_user(): void
//    {
//        $this->actAsUserWithRole(User::ROLE_ADMIN);
//
//        User::factory()->count(10)->create();
//
//        $response = $this->postJson($this->getApiDomain() . '/buildings', [
//            'user_id' => 5,
//            'name' => 'Test',
//            'address' => 'User',
//        ]);
//
//        $response
//            ->assertStatus(201)
//            ->assertJsonFragment([
//                 'user_id' => 5,
//                 'name' => 'Test',
//                 'address' => 'User',
//             ]);
//    }
//
//    public function test_regular_user_can_update_his_building(): void
//    {
//        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);
//
//        $building = Building::factory()->create([
//            'user_id' => $loggedInUser->id
//        ]);
//
//        $response = $this->patchJson($this->getApiDomain() . '/buildings/' . $building->id, [
//            'user_id' => $loggedInUser->id,
//            'name' => 'Test',
//            'address' => 'User',
//        ]);
//
//        $response
//            ->assertStatus(200)
//            ->assertJsonFragment([
//                 'user_id' => $loggedInUser->id,
//                 'name' => 'Test',
//                 'address' => 'User',
//             ]);
//    }
//
//    public function test_admin_can_update_building_for_any_user(): void
//    {
//        $this->actAsUserWithRole(User::ROLE_ADMIN);
//
//        User::factory()->count(10)->create();
//
//        $building = Building::factory()->create([
//            'user_id' => 5
//        ]);
//
//        $response = $this->patchJson($this->getApiDomain() . '/buildings/' . $building->id, [
//            'user_id' => 5,
//            'name' => 'Test Edit',
//            'address' => 'Address',
//        ]);
//
//        $response
//            ->assertStatus(200)
//            ->assertJsonFragment([
//                 'user_id' => 5,
//                 'name' => 'Test Edit',
//                 'address' => 'Address',
//             ]);
//    }
//
//    public function test_regular_user_can_delete_his_building(): void
//    {
//        $loggedInUser = $this->actAsUserWithRole(User::ROLE_REGULAR);
//
//        $building = Building::factory()->create([
//            'user_id' => $loggedInUser->id
//        ]);
//
//        $response = $this->deleteJson($this->getApiDomain() . '/buildings/' . $building->id);
//
//        $response
//            ->assertStatus(204)
//            ->assertNoContent();
//    }
//
//    public function test_admin_can_delete_any_building(): void
//    {
//        $this->userWithRoleCanDeleteModelOfType(User::ROLE_ADMIN, new User());
//    }
}
