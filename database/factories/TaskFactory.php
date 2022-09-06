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
            'title' => $this->faker->text(25),
            'description' => $this->faker->sentence(2),
            'status'=>$this->faker->randomElement(['not_started']),
            'user_id'=> $this->faker->randomElement(User::all())['id'],
            'project_id'=> $this->faker->randomElement(Project::all())['id'],
        ];
    }
}
