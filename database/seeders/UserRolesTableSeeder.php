<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_roles')->delete();
        \DB::table('user_roles')->insert(array (
            0 => 
            array (
                'role_name' => 'ADMIN',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
            1 => 
            array (
                'role_name' => 'PRODUCT_OWNER',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
            2 => 
            array (
                'role_name' => 'TEAM_MEMBER',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
        ));
    }
}
