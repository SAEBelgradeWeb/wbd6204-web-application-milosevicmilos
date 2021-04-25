<?php

namespace Database\Factories;

use App\Models\EnergyConsumption;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnergyConsumptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EnergyConsumption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'appliance_id' => random_int(1, 10),
            'date' => now()->minute(0)->second(0),
            'consumption' => $this->faker->randomFloat(2, 0, 250) * random_int(1, 4),
        ];
    }
}
