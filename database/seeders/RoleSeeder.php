<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::ACCESS_ROLE as $roleKey => $value) {
            $role = Role::firstOrCreate(['slug'=>$roleKey]);
            $role->name = $value;
            $role->save();
        }

    }
}
