<?php

namespace Database\Seeders;

use App\Models\Appliance;
use App\Models\ApplianceType;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $this->call([ApplianceTypeSeeder::class]);

        $applianceTypes = ApplianceType::all();

        User::factory()->create([
                         'email' => 'admin@kilo-watts.com',
                         'role' => User::ROLE_ADMIN,
                         'first_name' => 'Admin',
                         'last_name' => 'User'
                     ]);

        $regularUser = User::factory()->create([
                           'email' => 'regular@kilo-watts.com',
                           'role' => User::ROLE_REGULAR,
                           'first_name' => 'Test',
                           'last_name' => 'User'
                       ]);

        // Deleted user
        User::factory()->create([
            'email' => 'deleted@kilo-watts.com',
            'role' => User::ROLE_REGULAR,
            'first_name' => 'Deleted',
            'deleted_at' => now()
        ]);

        // Unverified user
        User::factory()->create([
            'email' => 'unverified@kilo-watts.com',
            'role' => User::ROLE_REGULAR,
            'first_name' => 'Unverified',
            'email_verified_at' => null
        ]);

        $buildings = Building::factory(3)->create([
                         'user_id' => $regularUser->id
                     ]);

        foreach ($buildings as $building) {
            $this->createFloors($building, $applianceTypes);
        }
    }

    /**
     * @param Building $building
     * @param Collection $applianceTypes
     * @throws Exception
     */
    private function createFloors(Building $building, Collection $applianceTypes): void
    {
        for ($floorNumber = 0; $floorNumber < random_int(1, 10); $floorNumber++) {
            $floor = Floor::factory()->create([
                'building_id' => $building->id,
                'name' => 'Floor ' . $floorNumber,
                'level' => $floorNumber
            ]);

            $this->createRooms($floor, $applianceTypes);
        }
    }

    /**
     * @param Floor $floor
     * @param Collection $applianceTypes
     * @throws Exception
     */
    private function createRooms(Floor $floor, Collection $applianceTypes): void
    {
        for ($roomNumber = 0; $roomNumber < random_int(2, 10); $roomNumber++) {
            $room = Room::factory()->create([
                'floor_id' => $floor->id
            ]);

            $this->createAppliances($room, $applianceTypes);
        }
    }

    /**
     * @param Room $room
     * @param Collection $applianceTypes
     * @throws Exception
     */
    private function createAppliances(Room $room, Collection $applianceTypes): void
    {
        for ($applianceNumber = 0; $applianceNumber < random_int(5, 25); $applianceNumber++) {
            $applianceType = $applianceTypes->random();

            Appliance::factory()->create([
                'room_id' => $room->id,
                'name' => $applianceType->name . ' - Device ' . ($applianceNumber + 1),
                'appliance_type_id' => $applianceType->id
            ]);
        }
    }
}
