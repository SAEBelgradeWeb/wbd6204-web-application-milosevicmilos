<?php

namespace Database\Seeders;

use App\Models\Appliance;
use App\Models\ApplianceType;
use App\Models\Building;
use App\Models\EnergyConsumption;
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
            $this->command->comment('Creating building');
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
        $floorsCount = random_int(1, 3);

        for ($floorNumber = 0; $floorNumber < $floorsCount; $floorNumber++) {
            $this->command->comment("Creating floor: $floorNumber($floorsCount)");
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
        $roomCount = random_int(1, 2);
        for ($roomNumber = 0; $roomNumber < $roomCount; $roomNumber++) {
            $this->command->comment("Creating room: $roomNumber($roomCount)");
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
        $applianceCount = random_int(2, 10);
        for ($applianceNumber = 0; $applianceNumber < $applianceCount; $applianceNumber++) {
            $this->command->comment("Creating appliance: $applianceNumber($applianceCount)");
            $applianceType = $applianceTypes->random();

            $appliance = Appliance::factory()->create([
                'room_id' => $room->id,
                'name' => $applianceType->name . ' - Device ' . ($applianceNumber + 1),
                'appliance_type_id' => $applianceType->id
            ]);

            $this->createConsumptionRecords($appliance);
        }
    }

    /**
     * @param Appliance $appliance
     */
    private function createConsumptionRecords(Appliance $appliance): void
    {
        for ($dayCount = -400; $dayCount < 30; $dayCount++)
        {
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(4)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(5)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(6)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(7)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(8)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(9)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(10)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(11)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(12)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(13)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(14)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(15)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(16)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(17)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(18)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(19)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(20)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(21)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(22)->minute(0)->second(0)]);
            EnergyConsumption::factory()->create(['appliance_id' => $appliance->id, 'date' => now()->addDays($dayCount)->hour(23)->minute(0)->second(0)]);
        }
    }
}
