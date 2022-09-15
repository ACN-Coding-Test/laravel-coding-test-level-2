<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create(
            [
                'name' => 'admin',
                'email' => 'admin@test.my',
                'password' => bcrypt('password123')
            ]
        );

        \App\Models\User::factory(5)->create();
    }
}
