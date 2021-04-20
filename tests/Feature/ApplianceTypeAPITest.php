<?php

namespace Tests\Feature;

use App\Models\ApplianceType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApplianceTypeAPITest
 * @package Tests\Feature
 * @group ApplianceTypeAPITest
 */
final class ApplianceTypeAPITest extends APITest
{
    use RefreshDatabase;

    /**
     * @throws Exception
     */
    public function test_admin_can_get_all_appliance_types(): void
    {
        $this->actAsUserWithRole(User::ROLE_ADMIN);

        $entitiesCount = random_int(1, 100);

        ApplianceType::factory()->count($entitiesCount)->create();

        $response = $this->getJson($this->getApiDomain() . '/appliance-types');

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount, 'appliance_types')
            ->assertJsonStructure([
                'appliance_types' => [
                    '*' => array_values((new ApplianceType())->getVisible())
                ]
            ]);
    }

    /**
     * @throws Exception
     */
    public function test_regular_user_can_get_appliance_types(): void
    {
        $this->actAsUserWithRole(User::ROLE_REGULAR);

        $entitiesCount = random_int(1, 100);

        ApplianceType::factory()->count($entitiesCount)->create();

        $response = $this->getJson($this->getApiDomain() . '/appliance-types');

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount, 'appliance_types')
            ->assertJsonStructure([
                'appliance_types' => [
                    '*' => array_values((new ApplianceType())->getVisible())
                ]
            ]);
    }
}
