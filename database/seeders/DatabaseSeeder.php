<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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
        $roles = ['Admin', 'Product Owner', 'Team Member'];
        User::factory(30)->create()->each(function ($user) use ($roles) {
            $k = array_rand($roles);
            $role = $roles[$k];

            $user->assignRole($role);

            if ($role == 'Product Owner') {
                if($user_id = User::role('Product Owner')->inRandomOrder()->first()->id){

                    Project::factory(5)->create(['user_id' => $user_id])->each(function ($project) {
                        $tasks = Task::factory(5)->create([
                            'project_id' => $project,
                            'user_id' => User::role('Team Member')->inRandomOrder()->first()->id
                        ]);

                        // $project->tasks()->saveMany($tasks);
                    });
                }
            }
        });
    }
}
