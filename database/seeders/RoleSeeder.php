<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {              
        Role::insert(
            [
                'name' => 'ADMIN',
            ]
        );

        Role::insert(
            [
                'name' => 'PRODUCT_OWNER'
            ]
        );

        Role::insert(
            [
                'name' => 'DEVELOPER'
            ]
        );
    }
}
