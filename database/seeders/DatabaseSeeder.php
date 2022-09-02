<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Roles Seeder
        Roles::create(["name"=>'ADMIN',"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);
        Roles::create(["name"=>'PROJECT_OWNER',"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);
        Roles::create(["name"=>'MEMBERS',"created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);

        //Create Admin User
        User::create(['username'=>'admin','password'=>bcrypt('password'),'role_id'=>1]);

        //Statuses Seeder
        Status::create(["name"=>'NOT_STARTED', "created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);
        Status::create(["name"=>'IN_PROGRESS', "created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);
        Status::create(["name"=>'READY_FOR_TEST', "created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);
        Status::create(["name"=>'COMPLETED', "created_at"=>Carbon::now(),"updated_at"=>Carbon::now()]);
    }
}
