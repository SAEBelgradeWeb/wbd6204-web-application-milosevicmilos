<?php

namespace Database\Factories;

use App\Models\ApplianceType;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ApplianceTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplianceType::class;

    private $applianceTypes = [
        ['name' => 'Air conditioner'],
        ['name' => 'Clothes dryer'],
        ['name' => 'Clothes iron'],
        ['name' => 'Coffee machine'],
        ['name' => 'Desktop computer'],
        ['name' => 'Dishwasher'],
        ['name' => 'Electric kettle'],
        ['name' => 'Fan'],
        ['name' => 'Fridge'],
        ['name' => 'Heater'],
        ['name' => 'IT gear'],
        ['name' => 'Lamp'],
        ['name' => 'Laptop computer'],
        ['name' => 'Microwave oven'],
        ['name' => 'Mobile adapters'],
        ['name' => 'Oven'],
        ['name' => 'Stereo'],
        ['name' => 'Television'],
        ['name' => 'Toaster oven'],
        ['name' => 'Vacuum cleaner'],
        ['name' => 'Washing machine'],
        ['name' => 'Water heater'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return $this->faker->randomElement($this->applianceTypes);
    }
}
