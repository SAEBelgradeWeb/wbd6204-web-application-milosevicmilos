<?php

namespace Database\Seeders;

use App\Models\ApplianceType;
use Illuminate\Database\Seeder;

final class ApplianceTypeSeeder extends Seeder
{
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->applianceTypes as $applianceType) {
            ApplianceType::create($applianceType);
        }
    }
}
