<?php

namespace Database\Factories;

use App\Models\Appliance;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ApplianceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appliance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'room_id' => random_int(1, 10),
            'name' => 'Appliance',
            'appliance_type_id' => random_int(1, 22)
        ];
    }
}
