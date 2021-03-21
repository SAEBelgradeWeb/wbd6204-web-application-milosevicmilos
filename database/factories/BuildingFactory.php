<?php

namespace Database\Factories;

use App\Models\Building;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(2, 11),
            'name' => $this->faker->streetName,
            'address' => $this->faker->streetAddress,
        ];
    }
}
