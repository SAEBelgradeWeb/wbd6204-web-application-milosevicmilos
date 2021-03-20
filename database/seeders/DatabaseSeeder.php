<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create([
             'email' => 'milosevic.z.milos@gmail.com',
             'role' => User::ROLE_ADMIN
         ]);

         User::factory(10)->create();
    }
}
