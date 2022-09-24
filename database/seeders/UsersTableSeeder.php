<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Let's clear the users table first
         \DB::table('users')->delete();
         $faker = \Faker\Factory::create();
         $password = Hash::make('admin@123');
          User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => $password,
            'role_id' => 1,
        ]);
    }
}
