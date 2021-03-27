<?php

namespace Database\Factories;

use App\Models\Floor;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class FloorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Floor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'building_id' => random_int(2, 11),
            'name' => 'Floor',
            'level' => random_int(0, 10),
        ];
    }
}
