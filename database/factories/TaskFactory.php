<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->title(),
            'description'=>$this->faker->text(),
            'status_id'=>1,
            'project_id'=>Project::where('role_id',2)->inRandomOrder()->first()->id,
            'user_id'=>User::where('role_id',3)->inRandomOrder()->first()->id
        ];
    }
}
