<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->delete();
        User::query()->delete();


        $admin = Role::create(['id'=>Role::ADMIN,'name' => 'ADMIN']);
        $product_owner = Role::create(['id' =>Role::PRODUCT_OWNER ,'name' => 'PRODUCT_OWNER']);
        $team_member = Role::create(['id' =>Role::TEAM_MEMBER ,'name' => 'TEAM_MEMBER']);


        $data_user['username'] ='admin';
        $data_user['password'] = Hash::make('test123');
        $data_user['role_id'] = Role::ADMIN;

        $user = User::create($data_user);


        $data_product_owner['username'] ='product_owner';
        $data_product_owner['password'] = Hash::make('test123');
        $data_product_owner['role_id'] = Role::PRODUCT_OWNER;

        $user = User::create($data_product_owner);

        $data_team_member['username'] ='team_member';
        $data_team_member['password'] = Hash::make('test123');
        $data_team_member['role_id'] = Role::TEAM_MEMBER;

        $user = User::create($data_team_member);
    }
}
