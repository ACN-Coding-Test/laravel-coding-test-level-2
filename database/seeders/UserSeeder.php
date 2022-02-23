<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed a default user
        $data = [
            'name' => 'Default User',
            'username' => 'user1',
            'password' => bcrypt('Secret123#'),
        ];

        User::updateOrCreate(['email' => 'test@test.com'], $data);
    }
}
