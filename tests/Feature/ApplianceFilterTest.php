<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ApplianceFilterTest
 * @package Tests\Feature
 * @group ApplianceFilterTest
 */
final class ApplianceFilterTest extends APITest
{
    use RefreshDatabase;

    // TODO: Test if regular user doesnt pass user_id, he will get only his appliances
    // TODO: Test if regular user passes custom user_id that's not his, he will get only his appliances
    // TODO: Test if admin doesnt pass custom user_id, he will get all appliances

    // TODO: For regular user, we need to determine if all entities belong to him: Building, Floor, Room.


}
