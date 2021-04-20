<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

final class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * @var string[]
     */
    private $roomNames = [
        'Entrance Hall',
        'Kitchen',
        'Keeping Room',
        'Pantry',
        'Dining Room',
        'Living Room',
        'Formal Parlor',
        'Reception Room',
        'Family Room',
        'Sun Room',
        'Home Office',
        'Library',
        'Office',
        'Bathroom',
        'Powder Room',
        'Laundry Room',
        'Storage Room',
        'Master Bedroom',
        'Walk-in Closet',
        'Kids Bedroom',
        'Bedroom',
        'Nursery',
        'Guest Room',
        'Playroom',
        'Game Room',
        'Music Room',
        'Home Theatar Room',
        'Home Gym',
        'Garage',
        'Basement',
        'Wine Cellar',
        'Root Cellar',
        'Attic',
        'Loft',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'floor_id' => random_int(0, 10),
            'name' => $this->faker->randomElement($this->roomNames),
            'size' => random_int(5, 50)
        ];
    }
}
