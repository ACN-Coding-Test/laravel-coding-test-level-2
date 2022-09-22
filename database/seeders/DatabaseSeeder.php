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
        User::create([
            "name" => "Superuser",
            "username" => "admin",
            "password" => bcrypt("admin"),
            "role_id" => 3
        ]);

    }
}
