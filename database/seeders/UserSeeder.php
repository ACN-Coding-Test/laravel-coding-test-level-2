<?php

namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
        {
            DB::table('users')->insert([
                'username' => 'admin',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
            ]);
            DB::table('users')->insert([
                'username' => 'product.owner',
                'password' => Hash::make('productowner@123'),
                'role' => 'product_owner',
            ]);
            DB::table('users')->insert([
                'username' => 'team.member.1',
                'password' => Hash::make('teammember1@123'),
                'role' => 'team_member',
                
            ]);
            DB::table('users')->insert([
                'username' => 'team.member.2',
                'password' => Hash::make('teammember2@123'),
                'role' => 'team_member',
            ]);
        }
}