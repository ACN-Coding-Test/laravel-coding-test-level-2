<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Database\Seeders\RoleSeeder;
use App\Models\User as BaseUser;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            'admin'=>['name'=>'Admin','username'=>'admin','email'=>'admin@atyantik.com','role_id'=>Role::isAdmin()->first()->id],
            'team'=>['name'=>'Team Member','username'=>'team_member','email'=>'team-member@atyantik.com','role_id'=>Role::isTeamMember()->first()->id],
            'product_owner'=>['name'=>'Product Owner','username'=>'product_owner','email'=>'product-owner@atyantik.com','role_id'=>Role::isProductOwner()->first()->id],
        ];
        foreach ($users as $key => $user) {
            if(!BaseUser::where(['email'=>$user['email']])->first()) {
                $user = BaseUser::create($user);
                $user->password = Hash::make($key.'@123');
                $user->save();
            }
        }
    }
}
