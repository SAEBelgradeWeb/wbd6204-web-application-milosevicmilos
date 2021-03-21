<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         User::factory()->create([
             'email' => 'admin@kilo-watts.com',
             'role' => User::ROLE_ADMIN
         ]);

        User::factory()->create([
            'email' => 'regular@kilo-watts.com',
            'role' => User::ROLE_REGULAR
        ]);

         User::factory(10)->create([
             'role' => User::ROLE_REGULAR
         ]);

         Building::factory(50)->create();
    }
}
