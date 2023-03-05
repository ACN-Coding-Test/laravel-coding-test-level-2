<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(
            [
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'role_id' => Role::ROLE_TYPE_ADMIN
            ]
        );

        User::insert(
            [
                'username' => 'po',
                'password' => bcrypt('123456'),
                'role_id' => Role::ROLE_TYPE_PRODUCT_OWNER
            ]
        );

        User::insert(
            [
                'username' => 'dev1',
                'password' => bcrypt('123456'),
                'role_id' => Role::ROLE_TYPE_DEVELOPER
            ]
        );

        User::insert(
            [
                'username' => 'dev2',
                'password' => bcrypt('123456'),
                'role_id' => Role::ROLE_TYPE_DEVELOPER
            ]
        );
    }
}
