<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call([
            MasterRole::class,
            MasterStatus::class,
        ]);
        
        # Default User
        $users =  [[
            "name" => "Superuser",
            "username" => "admin",
            "password" => bcrypt("123456"),
            "role_id" => 3
        ],[
            "name" => "Product Owner",
            "username" => "product",
            "password" => bcrypt("123456"),
            "role_id" => 2
        ],[
            "name" => "Team Member",
            "username" => "member",
            "password" => bcrypt("123456"),
            "role_id" => 1
        ]];

        foreach ($users as $key => $value) {
            User::create($value);
        }

    }
}
