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

        $data_user['username'] ='admin';
        $data_user['password'] = Hash::make('test123');
        $data_user['role_id'] = Role::ADMIN;

        $user = User::create($data_user);
    }
}
